<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel as baseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
class Unit extends baseModel
{
    use  SoftDeletes;
    protected $dates=['deleted_at'];
    protected $guarded=[];
    protected $table='units';


}


