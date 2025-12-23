<?php

namespace App\Widgets;
use App\Models\User;
use App\Models\Station;
use App\Models\Tenant;
use App\Models\Area;
use App\Models\Code;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardDimmer extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */

    public function run()
    {


        $user=Auth::user();

        $stations=  Station::all();
        $tenants= Tenant::all();
        $areas= Area::all();
        $codes= Code::all();
        $station_data=  Station::where('id',$user->station_id)->first();
        return view('voyager::dashboard-dimmer', compact('stations','tenants','codes','areas','station_data'));


    }


    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
}
