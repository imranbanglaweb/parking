<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Sync extends Model
{
    protected $connection = 'mysql2';
    use SoftDeletes;
    protected $table = 'daily_parkings';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'sync_status',
        'vehicle_type_id',
        'station_id',
        'token_number',
        'tenant_id',
        'station_parking_id',
        'code_id',
        'area_id',
        'vehicle_number',
        'mobile_number',
        'payment_status',
        'clock_in',
        'clock_out',
        'total_time',
        'payable_amount',
        'paid_amount',
        'sync_status'
    ];

    //
}
