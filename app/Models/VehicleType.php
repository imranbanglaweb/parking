<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Station;
use App\Models\CustomerCategory;
use App\Models\Rate;
use App\Models\Tenant;
use App\Models\DailyParking;
class VehicleType extends Model
{
    use SoftDeletes;
    protected $table = 'vehicle_types';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name'
    ];

     public function station()
    {
        return $this->belongsTo(Station::class);
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

}
