<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.user'], function () {
        Route::post('/changePermission', array('as' => 'changePermission', 'uses' => 'Voyager\VoyagerUserController@changePermission'));
        Route::post('/changePermission', array('as' => 'change_user_permission', 'uses' => 'Voyager\VoyagerUserController@changePermission'));
        Route::post('/changePermissions', array('as' => 'change_user_permissions', 'uses' => 'Voyager\VoyagerUserController@changePermissionForTable'));
        // Calender Events
        Route::post('/events-calendar-update', 'CalendarController@eventUpdate')->name('calender.events.update');
        Route::post('/events-calendar-add', 'CalendarController@eventAdd')->name('calender.events.add');
        Route::post('/events-calendar-delete', 'CalendarController@eventDelete')->name('calendar.event.delete');

        /** This is the common route to get all similar type of list for any model */
        Route::post('api', 'ApiController@index')->name('api.index');

        /** Change Language > options > Bangla|English */
        Route::post('change-language/{language}', 'LocalizationController@changeLanguage')->name('change-language');

        /** Users */
        Route::post('users/datatable', 'Voyager\VoyagerUserController@getDatatable')->name('users.datatable');

         Route::post('daily-parkings/store', 'DailyParkingController@store')->name('daily-parkings.store');
         Route::post('daily-parkings/tenant-data', 'DailyParkingController@getTenant')->name('daily-parkings.tenant-data');
         Route::post('daily-parkings/getTenantCustomer', 'DailyParkingController@getTenantCustomer')->name('daily-parkings.station_wise_customer');
         Route::post('daily-parkings/getDashboardData', 'DailyParkingController@getDashboardData')
                ->name('daily-parkings.dashboard-datatable');
         Route::post('daily-parkings/get_vehicle_number', 'DailyParkingController@fetchCarNumber')->name('daily-parkings.get_vehicle_number');
         Route::post('daily-parkings/check-parking-limit', 'DailyParkingController@checkParkingLimit')->name('daily-parkings.check-parking-limit');
         Route::post('daily-parkings/out-data', 'DailyParkingController@outData')->name('daily-parkings.out-data');
         Route::post('daily-parkings/out', 'DailyParkingController@outVehicle')->name('daily-parkings.out');
          Route::post('daily-parkings/datatable', 'DailyParkingController@getDatatable')->name('daily-parkings.datatable');
          Route::post('daily-parkings/sync', 'DailyParkingController@sync')->name('daily-parkings.sync');
       //vehicle_number
        Route::post('car-numbers/datatable', 'CarNumberController@getDatatable')->name('car-numbers.datatable');
        Route::post('car-numbers/store', 'CarNumberController@store')->name('car-numbers.store');
        Route::post('car-numbers/update/{id}', 'CarNumberController@update')->name('car-numbers.update');

        Route::post('stations/tenant', 'TenantController@getTenantByStation')->name('stations.tenants');
        Route::post('stations/vehicle_type', 'VehicleTypeController@getVehicleTypeByStation')->name('stations.vehicle_type');
        Route::post('stations/users', 'Voyager\VoyagerUserController@getUserByStation')->name('stations.users');
        Route::post('daily-parkings/print-daily-parking', 'DailyParkingController@printDailyParking')->name('daily-parkings.print-daily-parking');
    });
});