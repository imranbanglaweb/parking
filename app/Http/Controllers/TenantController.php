<?php
namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\CarNumber;
use App\Models\Station;
use App\Models\Area;
use App\Models\Code;
use App\Models\Tenant;
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

class TenantController extends VoyagerBaseController
{

     public function getTenantByStation(Request $request) {
        $user = Auth::user();
        if(Auth::user()->isAdmin()){
        $tenants= Tenant::where('station_id',$request->station_id)->get();
        $tenant_id=$request->tenant_id;
        $view = "voyager::car-numbers.partials.tenants";
        return Voyager::view($view, compact('tenants','tenant_id'));
        }else{
            $tenants= Tenant::where('station_id',$user->station_id)->get();
            $tenant_id=$request->tenant_id;
            $view = "voyager::car-numbers.partials.tenants";
            return Voyager::view($view, compact('tenants','tenant_id'));
        }
    }
}
