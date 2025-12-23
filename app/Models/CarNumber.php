<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Station;
use App\Models\Tenant;
use App\Models\VehicleType;
class CarNumber extends Model
{
    use SoftDeletes;
    protected $table = 'car_numbers';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'area',
        'code',
        'vehicle_number',
        'mobile_number'
    ];
    public function station()
    {
        return $this->brlongsTo(Station::class);
    }
     public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
