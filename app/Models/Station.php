<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\VehicleType;
use App\Models\CustomerCategory;
use App\Models\Rate;
use App\Models\Tenant;
use App\Models\CarNumber;
use App\Models\DailyParking;
class Station extends Model
{
    use SoftDeletes;
    protected $table = 'stations';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name'
    ];

     public function vehicleTypes()
    {
        return $this->hasMany(VehicleType::class);
    }
    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }
    public function dailyParkings()
    {
        return $this->hasMany(DailyParking::class);
    }
    public function carNumbers()
    {
        return $this->hasMany(CarNumber::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
