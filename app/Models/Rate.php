<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Station;
use App\Models\CustomerCategory;
use App\Models\VehicleType;
use App\Models\Rate;
use App\Models\DailyParking;
class Rate extends Model
{
    use SoftDeletes;
    protected $table = 'rates';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'first_hour',
        'next_hour'
    ];

     public function station()
    {
        return $this->belongsTo(Station::class);
    }
    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

}
