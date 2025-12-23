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
class Area extends Model
{
    use SoftDeletes;
    protected $table = 'areas';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name'
    ];

    
    public function carNumbers()
    {
        return $this->hasMany(CarNumber::class);
    }
}
