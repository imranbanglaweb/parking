<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Station;
use App\Models\Tenant;
use App\Models\VehicleType;
class CustomerCategory extends Model
{
    use SoftDeletes;
    protected $table = 'customer_categories';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'space_limit',
        'used',
        'left'
    ];
    public function station()
    {
        return $this->brlongsTo(Station::class);
    }
    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }
     public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
