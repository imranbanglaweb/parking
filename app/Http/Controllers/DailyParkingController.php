<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Models\Country;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use App\Models\DailyParking;
use App\Models\Station;
use App\Models\Tenant;
use App\Models\Rate;
use App\Models\VehicleType;
use App\Models\CustomerCategory;
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
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DailyParkingExport;
Use \Carbon\Carbon;
use App\Http\Controllers\Voyager\VoyagerBaseController;
ini_set('max_execution_time', '30000');
ini_set("pcre.backtrack_limit", "55000000");
class DailyParkingController extends VoyagerBaseController
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
        $stations= Station::where('status',1)->get();
        $this->authorize('browse', app(DailyParking::class));
        $isServerSide = false;
        $localPrefix = 'bread.daily-parkings.';
        $view = "voyager::daily-parkings.browse";
        return Voyager::view($view, compact(
                                'isServerSide', 'usesSoftDeletes','stations', 'localPrefix','showSoftDeleted','dataType'
        ));
    }

    public function getDatatable(Request $request) {
        /** @var User $user */
        $authUser = Auth::user();
         $start_date='';
        $end_date='';
        if($request->start_date!=null && $request->end_date==null){
             $start_date = $request->start_date.' '.'00:00:00';
             $end_date = $request->start_date.' '.'23:59:59';
        }
        if($request->start_date==null && $request->end_date!=null){
            $start_date = $request->end_date.' '.'00:00:00';
            $end_date = $request->end_date.' '.'23:59:59';
        }
        if($request->start_date!=null && $request->end_date!=null){
            $start_date = $request->start_date.' '.'00:00:00';
            $end_date = $request->end_date.' '.'23:59:59';
        }

        try {
            /** @var Builder $users */
            $parkings = DailyParking::select([
               'daily_parkings.token_number',
               'daily_parkings.id',
               'daily_parkings.mobile_number',
               'daily_parkings.total_time',
               'daily_parkings.clock_in',
               'daily_parkings.clock_out',
               'daily_parkings.payable_amount',
               'daily_parkings.vehicle_number',
               'a.name as area',
               'c.name as code',
               't.name as tenant',
               'v.name as vehicle_type',
               's.name as station'
            ])
            ->leftJoin('tenants as t', 't.id', '=', 'daily_parkings.tenant_id')
            ->leftJoin('stations as s', 's.id', '=', 'daily_parkings.station_id')
            ->leftJoin('vehicle_types as v', 'v.id', '=', 'daily_parkings.vehicle_type_id')
            ->leftJoin('areas as a', 'a.id', '=', 'daily_parkings.area_id')
            ->leftJoin('codes as c', 'c.id', '=', 'daily_parkings.code_id');
            if ($request->start_date==null && $request->end_date==null){
                $parkings->whereDate('daily_parkings.clock_in', Carbon::now()->format('Y-m-d'));
            }else{
            $parkings->whereBetween('daily_parkings.clock_in',[$start_date, $end_date]);
            }
            $parkings->when(!empty($request->station_id), function ($query) use ($request) {
                        return $query->where('daily_parkings.station_id',$request->station_id);
            });
            $parkings->when(!empty($request->tenant_id), function ($query) use ($request) {
                        return $query->where('daily_parkings.tenant_id',$request->tenant_id);
            });
            $parkings->when(!empty($request->vehicle_type_id), function ($query) use ($request) {
                        return $query->where('daily_parkings.vehicle_type_id',$request->vehicle_type_id);
            });
            $parkings->when(!empty($request->vehicle_number), function ($query) use ($request) {
                        return $query->where('daily_parkings.vehicle_number',$request->vehicle_number);
            });
            $parkings->when(!empty($request->payment_status), function ($query) use ($request) {
                        return $query->where('daily_parkings.payment_status',$request->payment_status);
            });
             $parkings->when(!empty($request->collection_by), function ($query) use ($request) {
                        return $query->where('daily_parkings.collection_by',$request->collection_by);
            });

            if(!Auth::user()->isAdmin()){
                $parkings->where('daily_parkings.station_id',$authUser->station_id);
            }
            $parkings->orderBy('daily_parkings.id','DESC');
            return DataTables::eloquent($parkings)
               ->addIndexColumn()
               ->addColumn('vehicle_number', function (DailyParking $parking) {
                                return $parking->area.'-'.$parking->code.' '.$parking->vehicle_number;
                            })
                  ->addColumn('station', function (DailyParking $parking) {
                                return $parking->station;
                            })
                 ->addColumn('tenant', function (DailyParking $parking) {
                                return $parking->tenant;
                            })
                ->addColumn('clock_in', function (DailyParking $parking) {
                                return date('d-M-Y H:i:s', strtotime($parking->clock_in));
                            })
                ->addColumn('clock_out', function (DailyParking $parking) {
                            if(!empty($parking->clock_out) || $parking->clock_out!=null){
                                return date('d-M-Y H:i:s', strtotime($parking->clock_out));
                            }else{
                                return 'N/A';
                            }
                            })
                ->addColumn('vehicle_type', function (DailyParking $parking) {
                                return $parking->vehicle_type;
                            })

                ->rawColumns(['vehicle_number','tenant','action','clock_in','clock_out','station'])
                ->toJson();
        } catch (\Exception $ex) {
            return response()->json([], 404);
        }
    }
     public function printDailyParking(Request $request)
    {
        $authUser = Auth::user();
        $data= $request->all();
        $start_date='';
        $end_date='';

         if($request->start_date!=null && $request->end_date==null){
             $start_date = $request->start_date.' '.'00:00:00';
             $end_date = $request->start_date.' '.'23:59:59';
        }
        if($request->start_date==null && $request->end_date!=null){
            $start_date = $request->end_date.' '.'00:00:00';
            $end_date = $request->end_date.' '.'23:59:59';
        }
        if($request->start_date!=null && $request->end_date!=null){
            $start_date = $request->start_date.' '.'00:00:00';
            $end_date = $request->end_date.' '.'23:59:59';
        }

        $today=Carbon::now()->format('d_m_Y');
            $parkings = DB::table('daily_parkings')->select(
                     DB::raw("CONCAT(a.name,'-',c.name) AS code"),
                        't.name as tenant',
                        'v.name as vehicle_type',
                        's.name as station',
                        'daily_parkings.token_number',
                        'daily_parkings.vehicle_number',
                        'daily_parkings.mobile_number',
                        'daily_parkings.clock_in',
                        'daily_parkings.clock_out',
                        'daily_parkings.total_time',
                        'daily_parkings.payable_amount',
                        'daily_parkings.paid_amount',

                        DB::raw( '(SELECT name FROM users u WHERE u.id = daily_parkings.collection_by) as collector')
                    )

                    ->leftJoin('tenants as t', 't.id', '=', 'daily_parkings.tenant_id')
                    ->leftJoin('stations as s', 's.id', '=', 'daily_parkings.station_id')
                    ->leftJoin('vehicle_types as v', 'v.id', '=', 'daily_parkings.vehicle_type_id')
                    ->leftJoin('areas as a', 'a.id', '=', 'daily_parkings.area_id')
                    ->leftJoin('codes as c', 'c.id', '=', 'daily_parkings.code_id')
                    ->where('daily_parkings.clock_out','!=',NULL);

            if ($request->start_date==null && $request->end_date==null){
                $parkings->whereDate('daily_parkings.clock_out', Carbon::now()->format('Y-m-d'));
            }else{
            $parkings->whereBetween('daily_parkings.clock_out',[$start_date, $end_date]);
            }
            $parkings->when(!empty($request->station_id), function ($query) use ($request) {
                        return $query->where('daily_parkings.station_id',$request->station_id);
            });
            $parkings->when(!empty($request->tenant_id), function ($query) use ($request) {
                        return $query->where('daily_parkings.tenant_id',$request->tenant_id);
            });
            $parkings->when(!empty($request->vehicle_type_id), function ($query) use ($request) {
                        return $query->where('daily_parkings.vehicle_type_id',$request->vehicle_type_id);
            });
            $parkings->when(!empty($request->vehicle_number), function ($query) use ($request) {
                        return $query->where('daily_parkings.vehicle_number',$request->vehicle_number);
            });
            $parkings->when(!empty($request->payment_status), function ($query) use ($request) {
                        return $query->where('daily_parkings.payment_status',$request->payment_status);
            });
             $parkings->when(!empty($request->collection_by), function ($query) use ($request) {
                        return $query->where('daily_parkings.collection_by',$request->collection_by);
            });

            if(!Auth::user()->isAdmin()){
                $parkings->where('daily_parkings.station_id',$authUser->station_id);
            }
            $parkings->orderBy('daily_parkings.id','DESC');
            $parkings = $parkings->get();
            //dd($parkings);

            $test_date='';
            if($request->start_date!=null && $request->end_date==null){
                 $test_date=date('d.m.Y', strtotime($request->start_date));
            }
            if($request->start_date==null && $request->end_date!=null){
                 $test_date=date('d.m.Y', strtotime($request->end_date));
            }

            if($request->start_date!=null && $request->end_date!=null){
                $test_date=date('d.m.Y', strtotime($request->start_date)).' - '.date('d.m.Y', strtotime($request->end_date));

            }

            if($request->start_date==null && $request->end_date==null){
                $test_date=Carbon::now()->format('Y-m-d');
            }
            switch ($request->input('action')) {
            case 'pdf':

            $pdf = PDF::loadView('reports.daily-parking-report',compact('parkings','test_date'));
            //$pdf->setPaper('A4', 'landscape');
                //$pdf->setOptions('defaultFont', 'SolaimanLipi');
            return $pdf->download('daily_parking_'.$test_date.'.pdf');

            case 'excell':
                return Excel::download(new DailyParkingExport($data), $test_date.'_daily_parking.xlsx');

        }


    }
    public function getTenant(Request $request) {
        $agent= Agent::where('id',$request->ref_by)->first();
        return response()->json(['mobile'=>$agent->mobile,'email'=>$agent->email]);
    }
    public function getTenantCustomer(Request $request) {
        $tenants= Tenant::where('station_id',$request->station_id)->get();

        $html = '<option value="">' . __('Select Customer') . '</option>';
        if(!empty($tenants)){
            foreach ($tenants as $tenant) {
                $html .= '<option  value="' . $tenant->id . '">' . $tenant->name . '</option>';
            }
        }
        return response()->json(['html' => $html]);
    }

    public function getDashboardData(Request $request) {
        //return $request;
        $authUser = Auth::user();
        try {
           $data = $request->all();
            /** @var Builder $users */
           $parkings = DailyParking::select([
               'daily_parkings.token_number',
               'daily_parkings.id',
               'daily_parkings.mobile_number',
               'daily_parkings.total_time',
               'daily_parkings.clock_in',
               'daily_parkings.clock_out',
               'daily_parkings.payable_amount',
               'daily_parkings.vehicle_number',
               'a.name as area',
               'c.name as code',
               't.name as tenant'
            ])
            ->leftJoin('areas as a', 'a.id', '=', 'daily_parkings.area_id')
            ->leftJoin('tenants as t', 't.id', '=', 'daily_parkings.tenant_id')
            ->leftJoin('codes as c', 'c.id', '=', 'daily_parkings.code_id')
            ->where('daily_parkings.clock_out',NULL);
           if(!$authUser->isAdmin()){
            $parkings->where('daily_parkings.station_id',$authUser->station_id);
           }
            $parkings->orderBy('daily_parkings.id','DESC');
            return DataTables::eloquent($parkings)
               ->addColumn('vehicle_number', function (DailyParking $parking) {
                                return $parking->area.'-'.$parking->code.' '.$parking->vehicle_number;
                            })
                ->addColumn('action', function (DailyParking $parking) use ($authUser) {
                                $str = "";

                                if ($authUser->can('read', $parking)) {
                                    $str .= ' <a class="btn btn-sm btn-danger out" data-id="' . $parking->id . '"><i class="voyager-power"></i> ' . __('voyager::generic.out') . '</a>';
                                }


                                return $str;
                            })
                ->rawColumns(['vehicle_number','action'])
                ->toJson();

        } catch (\Exception $ex) {
            return response()->json([], 404);
        }
    }
    public function store(Request $request) {
        //Log::debug(implode(', ', $request->patient_history));
        //return;
        $slug = $this->getSlug($request);
        // Check permission
        $this->authorize('add', app(DailyParking::class));

        $validator = Validator::make($request->all(), [
                    "vehicle_type_id" => "required",
                    "station_id" => "required",
                    "tenant_id" => "required",
                    'vehicle_number' => [
                        'required', Rule::unique('daily_parkings')->where(function($query) {
                                    $query->whereNull('clock_out');
                                })
                    ],
                    "area_id" => "required",
                    "code_id" => "required"
        ]);
        if ($validator->fails()) {
             // return redirect()->back()->withErrors($validator->errors());
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }
        /** @var Auth $user */
        $user = Auth::user();

        try {
            DB::beginTransaction();
            $station_data=  Station::where('id',$user->station_id)->first();
            $payment_status='';
            $token_number=1;
            $dailyParking=  DailyParking::where('station_id',$user->station_id)->orderBy('id','DESC')->first();
            if($dailyParking){
                $c_token_number=preg_replace("/[^0-9.]/", "", $dailyParking->token_number);
                $n_token_number=(int)$c_token_number+1;
                $token_number=$station_data->short_code.$n_token_number;
            }else{
                $token_number=$station_data->short_code.$token_number;
            }
            $customer_limit = DB::table('customer_categories')
            ->where('tenant_id',$request->tenant_id )
            ->where('vehicle_type_id',$request->vehicle_type_id )
            ->first();
            $used=$customer_limit->used+1;
            $left=$customer_limit->left-1;
    //print_r($customer_limit);
            $payment_status='Paid';
            if($customer_limit->left > 0){
                $payment_status='Free';
            }else{
                $payment_status='Paid';
            }

            $user = Auth::user();
            $parking = new DailyParking();
            $parking->vehicle_type_id =$request->vehicle_type_id;
            $parking->station_id =$request->station_id;
            $parking->tenant_id =$request->tenant_id;
            $parking->area_id =$request->area_id;
            $parking->code_id =$request->code_id;
            $parking->vehicle_number =$request->vehicle_number;
            $parking->mobile_number =$request->mobile_number;
            $parking->token_number =$token_number;
            $parking->clock_in =  date('Y-m-d H:i:s');
            $parking->payment_status =$payment_status;
            $parking->added_by = $user->id;
            $parking->save();
            DailyParking::findOrFail($parking->id)->update(['station_parking_id'=>$parking->id]);

            if($payment_status=='Free' && $request->tenant_id){
                CustomerCategory::where('vehicle_type_id',$request->vehicle_type_id)->where('tenant_id',$request->tenant_id)->update(['used'=>$used,'left'=>$left]);
            }
             // return dd($request);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();
            return response()->json(['errors' => array($exception->getMessage() . __('voyager::generic.try_again'))], 422);
        }
        $station_data=  Station::where('id',$user->station_id)->first();
        $parking_data = DailyParking::select([
               'daily_parkings.token_number',
               'daily_parkings.id',
               'daily_parkings.clock_in',
               'daily_parkings.vehicle_number',
               'a.name as area',
               'c.name as code',
               'v.name as vehicle_type'
            ])
            ->leftJoin('areas as a', 'a.id', '=', 'daily_parkings.area_id')
            ->leftJoin('codes as c', 'c.id', '=', 'daily_parkings.code_id')
            ->leftJoin('vehicle_types as v', 'v.id', '=', 'daily_parkings.vehicle_type_id')
            ->where('daily_parkings.id',$parking->id)->first();
        $receit_view = "voyager::receit.in-receit";
        $receit= Voyager::view($receit_view,  compact('parking_data','station_data'))->render();
        return response()->json(['success' => __('voyager::generic.successfully_created'),'receit'=>$receit]);

    }
    function fetchCarNumber(Request $request)
    {
    $user = Auth::user();
     if($request->get('query'))
     {
      $query = $request->get('query');
      $vehicle_type = $request->get('vehicle_type');
      $data = DB::table('car_numbers')
        ->where('vehicle_number', 'LIKE', "{$query}%")
        ->where('station_id',$user->station_id)
        ->where('vehicle_type_id',$vehicle_type)
        ->whereNull('deleted_at')
        ->get();

      $vehicle_details=  DailyParking::where('vehicle_number', 'LIKE', "{$query}%")
        ->where('station_id',$user->station_id)
        ->where('vehicle_type_id',$vehicle_type)
        ->orderBy('id','DESC')
        ->groupBy('vehicle_number')
        ->get();

      if(count($data)>0){
      $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
      foreach($data as $row)
      {
       $output .= '
       <li><a class="vehicle_details" data-tenent="'.$row->tenant_id.'" data-area="'.$row->area_id.'" data-code="'.$row->code_id.'" data-mobile="'.$row->mobile_number.'" href="#">'.$row->vehicle_number.'</a></li>
       ';
      }
      $output .= '</ul>';
     }
     else if(count($vehicle_details)>0){
      $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
      foreach($vehicle_details as $row)
      {
       $output .= '
       <li><a class="vehicle_details" data-tenent=" " data-area="'.$row->area_id.'" data-code="'.$row->code_id.'" data-mobile="'.$row->mobile_number.'" href="#">'.$row->vehicle_number.'</a></li>
       ';
      }
      $output .= '</ul>';
     }
     else{
         $output='';
     }
      echo $output;
     }
    }

    Public function checkParkingLimit(Request $request){

    if($request->vehicle_type_id && $request->tenant_id)
     {
        $vehicle_type_id=$request->vehicle_type_id;
        $tenant_id=$request->tenant_id;
        $customer_limit = DB::table('customer_categories')
        ->where('tenant_id',$tenant_id )
        ->where('vehicle_type_id',$vehicle_type_id )
        ->first();
       // return $vehicle_type_id;
        if($customer_limit->left>0){
            return 2;
        }else{
            return 3;
        }
     }else{
         return 4;
     }
    }

    public function outData(Request $request) {
        $user = Auth::user();
        $parking_data = DailyParking::select([
               'daily_parkings.token_number',
               'daily_parkings.id',
               'daily_parkings.clock_in',
               'daily_parkings.payment_status',
               'daily_parkings.vehicle_number',
               'daily_parkings.vehicle_type_id',
               'daily_parkings.tenant_id',
               'a.name as area',
               'c.name as code',
               'v.name as vehicle_type',
               't.name as tenant',
            ])
            ->leftJoin('areas as a', 'a.id', '=', 'daily_parkings.area_id')
            ->leftJoin('tenants as t', 't.id', '=', 'daily_parkings.tenant_id')
            ->leftJoin('codes as c', 'c.id', '=', 'daily_parkings.code_id')
            ->leftJoin('vehicle_types as v', 'v.id', '=', 'daily_parkings.vehicle_type_id')
            ->where('daily_parkings.id',$request->daily_parking_id)->first();
        $rate=  Rate::where('vehicle_type_id',$parking_data->vehicle_type_id)->first();
        $view = "voyager::out-vehicle";
        return Voyager::view($view, compact(
                                'parking_data','rate'
        ));

    }

    public function outVehicle(Request $request) {
        //Log::debug(implode(', ', $request->patient_history));
        //return;

        // Check permission
        //Log::debug($request->o_id);
        $this->authorize('read', app(DailyParking::class));

        $validator = Validator::make($request->all(), [
                    "o_vehicle_type_id" => "required",
                    "o_token_number" => "required",
                    "o_vehicle_number" => "required",
                    "o_clock_in" => "required",
                    "o_clock_out" => "required",
                    "o_total_time" => "required",
                    "o_payable_amount" => "required"
        ]);
        if ($validator->fails()) {
             // return redirect()->back()->withErrors($validator->errors());
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }
        /** @var Auth $user */
        $user = Auth::user();

        try {
            DB::beginTransaction();

             $customer_limit = DB::table('customer_categories')
            ->where('tenant_id',$request->o_tenant_id )
            ->where('vehicle_type_id',$request->o_vehicle_type_id )
            ->first();
            $used=$customer_limit->used-1;
            $left=$customer_limit->left+1;

            $parking=  DailyParking::where('id',$request->o_id)->first();
            $parking->clock_out =$request->o_clock_out;
            $parking->total_time =$request->o_total_time;
            $parking->payable_amount =$request->o_payable_amount;
            $parking->paid_amount =$request->o_paid_amount;
            $parking->updated_by = $user->id;
            $parking->collection_by = $user->id;
            $parking->sync_status = 0;
            $parking->save();
            //Log::debug($parking);
            //Log::debug($request->o_tenant_id);

            if($parking->payment_status=='Free' && $request->o_tenant_id){
               CustomerCategory::where('vehicle_type_id',$request->o_vehicle_type_id)->where('tenant_id',$request->o_tenant_id)->update(['used'=>$used,'left'=>$left]);

            }
             // return dd($request);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();
            return response()->json(['errors' => array($exception->getMessage() . __('voyager::generic.try_again'))], 422);
        }

        $parking_data = DailyParking::select([
               'daily_parkings.token_number',
               'daily_parkings.id',
               'daily_parkings.clock_in',
               'daily_parkings.vehicle_number',
               'daily_parkings.clock_out',
               'daily_parkings.total_time',
               'daily_parkings.payable_amount',
               'daily_parkings.paid_amount',
               'a.name as area',
               'c.name as code',
               'v.name as vehicle_type'
            ])
            ->leftJoin('areas as a', 'a.id', '=', 'daily_parkings.area_id')
            ->leftJoin('codes as c', 'c.id', '=', 'daily_parkings.code_id')
            ->leftJoin('vehicle_types as v', 'v.id', '=', 'daily_parkings.vehicle_type_id')
            ->where('daily_parkings.id',$parking->id)->first();
         $station_data=Station::where('id',$user->station_id)->first();
        $receit_view = "voyager::receit.out-receit";
        $receit= Voyager::view($receit_view,  compact('parking_data','station_data'))->render();
        return response()->json(['success' => __('daily-parkings.successfully_updated'),'receit'=>$receit]);

    }

    public function sync(Request $request) {
        //Log::debug(implode(', ', $request->patient_history));
        //return;
        $slug = $this->getSlug($request);
        // Check permission
        $this->authorize('sync', app(DailyParking::class));


        /** @var Auth $user */
        $user = Auth::user();

        try {

            $parkings =  DailyParking::where('station_id',$user->station_id)->where('sync_status',0)->get();
            //return $parkings;
            DB::beginTransaction();


            foreach ($parkings as $park) {
                $parking= new DailyParking;
                DailyParking::findOrFail($park->id)->update(['sync_status'=>1]);

                $customer_category=new CustomerCategory;
                $customer_category->setConnection('mysql2');
                $category_data=$customer_category->where('station_id', '=',$user->station_id)->where('vehicle_type_id',$park->vehicle_type_id)->first();

                $customer_category->where('id', $category_data->id)->update(
                            array(
                                'used' => $category_data->used,
                                'left' => $category_data->left,
                            ));

                $parkin=new DailyParking;
                $parkin->setConnection('mysql2');
                $parkin_data=$parkin->where('station_parking_id',$park->id)->first();
                if($parkin_data){
                    $parkin->where('station_parking_id', '=', $park->id)->update(
                            array(
                                'vehicle_type_id' => $park->vehicle_type_id,
                                'station_id' => $park->station_id,
                                'token_number' => $park->token_number,
                                'tenant_id' => $park->tenant_id,
                                'station_parking_id' => $park->id,
                                'code_id' => $park->code_id,
                                'area_id' => $park->area_id,
                                'vehicle_number' => $park->vehicle_number,
                                'mobile_number' => $park->mobile_number,
                                'payment_status' => $park->payment_status,
                                'clock_in' => $park->clock_in,
                                'clock_out' => $park->clock_out,
                                'total_time' => $park->total_time,
                                'payable_amount' => $park->payable_amount,
                                'paid_amount' => $park->paid_amount,
                                'status' => $park->status,
                                'deleted_at' => $park->deleted_at,
                                'added_by' => $park->added_by,
                                'updated_by' => $park->updated_by,
                                'created_at' => $park->created_at,
                                'updated_at' => $park->updated_at,
                                'sync_status' => $park->sync_status

                                ));
                }else{
                    $parkin->vehicle_type_id =$park->vehicle_type_id;
                    $parkin->station_id =$park->station_id;
                    $parkin->token_number =$park->token_number;
                    $parkin->tenant_id =$park->tenant_id;
                    $parkin->station_parking_id =$park->station_parking_id;
                    $parkin->code_id =$park->code_id;
                    $parkin->area_id =$park->area_id;
                    $parkin->vehicle_number =$park->vehicle_number;
                    $parkin->mobile_number =$park->mobile_number;
                    $parkin->payment_status =$park->payment_status;
                    $parkin->clock_in =$park->clock_in;
                    $parkin->clock_out =$park->clock_out;
                    $parkin->total_time =$park->total_time;
                    $parkin->payable_amount =$park->payable_amount;

                    $parkin->paid_amount = $park->paid_amount;
                    $parkin->status =$park->status;
                    $parkin->deleted_at = $park->deleted_at;
                    $parkin->added_by = $park->added_by;
                    $parkin->updated_by = $park->updated_by;
                    $parkin->created_at = $park->created_at;
                    $parkin->updated_at = $park->updated_at;
                    $parkin->sync_status =1;
                    $parkin->save();
                }
            }



             // return dd($request);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();
            return response()->json(['error' => $exception->getMessage().__('voyager::generic.try_again')]);

        }
        return response()->json(['success' => __('voyager::generic.successfully_created')]);

    }


}
