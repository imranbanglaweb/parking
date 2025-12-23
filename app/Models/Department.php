<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Department extends Model
{
    use SoftDeletes;
    protected $table = 'departments';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name'
    ];
    
     public function users()
    {
        return $this->hasMany(User::class);
    }
}
