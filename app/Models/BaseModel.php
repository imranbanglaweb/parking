<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    public function save(array $options = [])
    {
        return parent::save($options);
    }
}