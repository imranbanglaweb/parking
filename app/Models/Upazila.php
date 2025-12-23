<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Upazila extends Model
{
    use SoftDeletes;
    protected $table = 'upazilas';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name'
    ];
    
     public function customerBookings()
    {
        return $this->hasMany(CustomerBooking::class);
    }
}
