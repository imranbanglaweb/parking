<?php
namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\CarNumber;
use App\Models\Station;
use App\Models\Area;
use App\Models\Code;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Notification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use \DateTime;
Use \Carbon\Carbon;
use App\Http\Controllers\Voyager\VoyagerBaseController;

class CarNumberController extends VoyagerBaseController
{
public function index(Request $request) {
        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $showSoftDeleted = false;
        $isServerSide = false;
        $model = app($dataType->model_name);
        $usesSoftDeletes = true;
        if ($request->get('showSoftDeleted')) {
            $showSoftDeleted = true;
        }
        $this->authorize('browse', app(CarNumber::class));
        $isServerSide = false;
        $localPrefix = 'bread.car-numbers.';
        $view = "voyager::car-numbers.browse";
        return Voyager::view($view, compact(
                                'isServerSide', 'usesSoftDeletes', 'localPrefix','showSoftDeleted','dataType'
        ));
    }

    public function getDatatable(Request $request) {
        /** @var User $user */
        $authUser = Auth::user();
        try {
            /** @var Builder $users */

            $numbers = CarNumber::select([
                        'car_numbers.id as id',
                        'car_numbers.vehicle_number',
                        'car_numbers.mobile_number',
                        'car_numbers.parking_number',
                        'car_numbers.status',
                        'car_numbers.deleted_at',
                        's.name as station_name',
                        't.name as tenant_name',
                        'a.name as area_name',
                        'c.name as code_name',
                        'v.name as vehicle_type',
            ]);
            $numbers->join('stations as s', 's.id', '=', 'car_numbers.station_id');
            $numbers->join('tenants as t', 't.id', '=', 'car_numbers.tenant_id');
            $numbers->join('areas as a', 'a.id', '=', 'car_numbers.area_id');
            $numbers->join('codes as c', 'c.id', '=', 'car_numbers.code_id');
            $numbers->join('vehicle_types as v', 'v.id', '=', 'car_numbers.vehicle_type_id');
            /** check soft delete */
            if($request->showSoftDeleted==1){
                $numbers->onlyTrashed();
            }
            $numbers->orderBy('car_numbers.station_id','ASC');


            /** action buttons */
            return DataTables::eloquent($numbers)
                            ->addIndexColumn()

                            ->addColumn('status', function (CarNumber $number) {
                                if($number->status==1){
                                    return "<span class='active'>Active</span>";
                                }else{
                                    return "<span class='inactive'>Inactive</span>";
                                }
                            })
                            ->addColumn('station', function (CarNumber $number) {
                                return $number->station_name;
                            })
                             ->addColumn('tenant', function (CarNumber $number) {
                                 if($number->tenant_name){
                                    return $number->tenant_name;
                                 }else{
                                     return ' ';
                                 }
                            })
                             ->addColumn('vehicle_type', function (CarNumber $number) {
                                 if($number->vehicle_type){
                                    return $number->vehicle_type;
                                 }else{
                                     return ' ';
                                 }
                            })
                            ->addColumn('vehicle_number', function (CarNumber $number) {
                                 if($number->area_name && $number->code_name && $number->vehicle_number){
                                    return $number->area_name.'-'.$number->code_name.'-'.$number->vehicle_number;
                                 }else{
                                     return ' ';
                                 }
                            })

                            ->addColumn('action', function (CarNumber $number) use ($authUser) {
                                $str = "";

                                if ($authUser->can('read', $number)) {
                                    $str .= ' <a class="btn btn-sm btn-warning view" href="' . route('voyager.car-numbers.show', $number->id) . '"><i class="voyager-eye"></i> ' . __('voyager::generic.view') . '</a>';
                                }

                                if ($authUser->can('edit', $number)) {
                                    $str .= ' <a class="btn btn-sm btn-primary edit" href="' . route('voyager.car-numbers.edit', $number->id) . '"><i class="voyager-edit"></i> ' . __('voyager::generic.edit') . '</a>';
                                }
                                if ($authUser->can('delete', $number)) {
                                     if ($number->deleted_at) {
                                        $str .= "<a href='" . route('voyager.car-numbers.restore', $number->id) . "'
                                        title='restore' class='btn btn-success  restore' data-id='" . $number->id . "'
                                         data-id='" . $number->id . "' id='restore-'.$number->id>
                                        <i class='voyager-trash'></i> <span class='hidden-xs hidden-sm'>" . __('voyager::generic.restore') . "</span></a>";
                                    } else {
                                        $str .= " <a href='javascript:;'title='delete' class='btn btn-sm btn-danger delete'  data-id='" . $number->id . "' id='delete-'.$number->id><i class='voyager-trash'></i> <span class='hidden-xs hidden-sm'>" . __('voyager::generic.delete') . "</span></a>";
                                    }
                                }

                                return $str;
                            })

                            ->rawColumns(['action','status','station','tenant','vehicle_type','car_number'])
                            ->toJson();
                             Log::debug('asdkjgasdgj');
        } catch (\Exception $ex) {
            return response()->json([], 404);
        }
    }

    public function create(Request $request) {

        $authUser = Auth::user();

        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        /** @var User $dataTypeContent */
        $dataTypeContent = (strlen($dataType->model_name) != 0) ? new $dataType->model_name() : false;

        foreach ($dataType->addRows as $key => $row) {
            $dataType->addRows[$key]['col_width'] = $row->details->width ?? 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'add');


        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);
        $stations= Station::where('status',1)->get();
        $areas= Area::where('status',1)->get();
        $codes= Code::where('status',1)->get();
        $vehicle_types= VehicleType::where('status',1)->get();

        $userTypes = getFormattedUserTypes($authUser->user_type);
        $view = "voyager::car-numbers.add";

        return Voyager::view($view, compact('userTypes','stations','areas','codes','vehicle_types','dataType', 'dataTypeContent', 'isModelTranslatable'));
    }


    public function store(Request $request) {
        //Log::debug(implode(', ', $request->patient_history));
        //return;
        $slug = $this->getSlug($request);
        // Check permission
        $this->authorize('add', app(CarNumber::class));

        $validator = Validator::make($request->all(), [
                    "station_id" => "required",
                    "tenant_id" => "required",
                    "area_id" => "required",
                    "code_id" => "required",
                    "vehicle_number" => "required",
                    "vehicle_type_id" => "required"
        ]);
        if ($validator->fails()) {
             // return redirect()->back()->withErrors($validator->errors());
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }
        /** @var Auth $user */
        $user = Auth::user();

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $carNumber = new CarNumber();
            $carNumber->station_id =$request->station_id;
            $carNumber->tenant_id =$request->tenant_id;
            $carNumber->area_id =$request->area_id;
            $carNumber->code_id =$request->code_id;
            $carNumber->vehicle_type_id =$request->vehicle_type_id;
            $carNumber->vehicle_number =$request->vehicle_number;
            $carNumber->mobile_number =$request->mobile_number;
            $carNumber->parking_number =$request->parking_number;
            $carNumber->added_by = $user->id;
            $carNumber->save();
             // return dd($request);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();
            return response()->json(['errors' => array($exception->getMessage() . __('voyager::generic.try_again'))], 422);
        }

        return response()->json(['success' => __('voyager::generic.successfully_created')]);

    }

    public function edit(Request $request,$id) {
        $authUser = Auth::user();
        $this->authorize('edit', app(CarNumber::class));
        $car_number= CarNumber::where('id',$id)->first();
        $stations= Station::where('status',1)->get();
        $areas= Area::where('status',1)->get();
        $codes= Code::where('status',1)->get();
        $vehicle_types= VehicleType::where('status',1)->get();
        // Check if BREAD is Translatable
        $view = "voyager::car-numbers.edit";
        return Voyager::view($view, compact('car_number','stations','areas','codes','vehicle_types'));
    }

    public function update(Request $request, $id) {
        $this->authorize('edit', app(CarNumber::class));

        $validator = Validator::make($request->all(), [
            "station_id" => "required",
            "tenant_id" => "required",
            "area_id" => "required",
            "code_id" => "required",
            "vehicle_number" => "required",
            "vehicle_type_id" => "required"

        ]);
        if ($validator->fails()) {
             // return redirect()->back()->withErrors($validator->errors());
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }
        /** @var Auth $user */
        $user = Auth::user();

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $carNumber = CarNumber::where('id',$id)->first();
            $carNumber->station_id =$request->station_id;
            $carNumber->tenant_id =$request->tenant_id;
            $carNumber->area_id =$request->area_id;
            $carNumber->code_id =$request->code_id;
            $carNumber->vehicle_type_id =$request->vehicle_type_id;
            $carNumber->vehicle_number =$request->vehicle_number;
            $carNumber->mobile_number =$request->mobile_number;
            $carNumber->parking_number =$request->parking_number;
            $carNumber->added_by = $user->id;
            $carNumber->save();

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();
            return response()->json(['errors' => array($exception->getMessage() . __('voyager::generic.try_again'))], 422);
        }

        return response()->json(['success' => __('voyager::generic.successfully_updated')]);

    }


}
