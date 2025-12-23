<?php

namespace App\Http\Controllers\Voyager;

use App\Facades\Voyager;
use App\Models\DataType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use TCG\Voyager\Http\Controllers\VoyagerRoleController as BaseVoyagerRoleController;

class VoyagerRoleController extends VoyagerBaseController
{
    public function update(Request $request, $id)
    {
        $slug = $this->getSlug($request);
        /** @var DataType $dataType */
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        // Check permission
        $this->authorize('edit', app($dataType->model_name));

        /**Validate fields with ajax */
        $val = $this->validateBread($request->all(), $dataType->editRows);
        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }

        if (!$request->ajax()) {
            $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);
            $this->insertUpdateData($request, $slug, $dataType->editRows, $data);
            $data->permissions()->sync($request->input('permissions', []));

            $data->users()->pluck('id')->each(function ($userId){
                Cache::forget('userwise_permissions_' . $userId);
            });

            return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with([
                    'message'    => __("bread.{$dataType->slug}.model_name") . ' ' . __('voyager::generic.successfully_updated'),
                    'alert-type' => 'success',
                ]);
        }
    }

    // POST BRE(A)D
    public function store(Request $request)
    {
        $slug = $this->getSlug($request);

        /** @var DataType $dataType */
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        //Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows);

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }

        if (!$request->ajax()) {
            /** @var Model $data */
            $data = new $dataType->model_name();
            $this->insertUpdateData($request, $slug, $dataType->addRows, $data);

            $data->permissions()->sync($request->input('permissions', []));

            return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with([
                    'message' => __("bread.{$dataType->slug}.model_name") . ' ' . __('voyager::generic.successfully_added_new'),
                    'alert-type' => 'success',
                ]);
        }
    }
}
