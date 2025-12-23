<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Counter extends Model
{
    use SoftDeletes;
    protected $table = 'counters';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'number'
    ];
}
