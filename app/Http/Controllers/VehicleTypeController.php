<?php

namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\CarNumber;
use App\Models\Station;
use App\Models\Area;
use App\Models\Code;
use App\Models\Tenant;
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
class VehicleTypeController extends VoyagerBaseController
{
 public function getVehicleTypeByStation(Request $request) {
     $user = Auth::user();
     if(Auth::user()->isAdmin()){
        $vehicle_types= VehicleType::where('status',1)->get();
        $vehicle_type_id=$request->vehicle_type_id;
        $view = "voyager::car-numbers.partials.vehicle_type";
        return Voyager::view($view, compact('vehicle_types','vehicle_type_id'));
     }else{
        $vehicle_types= VehicleType::where('status',1)->get();
        $vehicle_type_id=$request->vehicle_type_id;
        $view = "voyager::car-numbers.partials.vehicle_type";
        return Voyager::view($view, compact('vehicle_types','vehicle_type_id'));
     }
    }

}
