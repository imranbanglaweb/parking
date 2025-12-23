<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Station;
use App\Models\VehicleType;
use App\Models\CustomerCategory;
class Tenant extends Model
{
    use SoftDeletes;
    protected $table = 'tenants';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name'
    ];
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
    public function vehicleTypes()
    {
        return $this->hasMany(VehicleType::class);
    }
    public function customerCategories()
    {
        return $this->hasMany(CustomerCategory::class);
    }
     public function carNumbers()
    {
        return $this->hasMany(CarNumber::class);
    }
}
