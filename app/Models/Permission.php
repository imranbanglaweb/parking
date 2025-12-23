<?php

namespace App\Models;

use App\Facades\Voyager;
use Illuminate\Support\Facades\DB;

class Permission extends BaseModel
{
    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany(Voyager::modelClass('Role'));
    }

    public static function generateFor($table_name)
    {
        self::firstOrCreate(['key' => 'browse_' . $table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'read_' . $table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'edit_' . $table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'add_' . $table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'delete_' . $table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'restore_' . $table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'force_delete_' . $table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'bulk_delete_' . $table_name, 'table_name' => $table_name]);
    }

    public static function removeFrom($table_name)
    {
        self::where(['table_name' => $table_name])->delete();
    }

    public function onDeleteCleanUp()
    {
        $roles = $this->roles();

        if($roles){
            DB::table($roles->getTable())->where('permission_id', '=', $this->id)->delete();
        }
    }
}
