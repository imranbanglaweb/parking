<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Request;
use TCG\Voyager\Events\BreadUpdated;
use TCG\Voyager\Facades\Voyager;

class AddAdditionalPermission
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param BreadUpdated $event
     * @return void
     */
    public function handle(BreadUpdated $bread)
    {
        $data = Request::all();

        /*
                Log::debug("hurrah");
                Log::debug($data);
        */

        if (!empty($data)) {
            $permissionModelClassName = Voyager::model('Permission');
            $tableName = $bread->dataType->name;
            $existingPermissions = $permissionModelClassName::where('table_name', '=', $tableName)
                ->where('is_user_defined', '=', 1)
                ->pluck('key')
                ->map(function($permissionKey, $key) use($tableName){
                    return str_replace('_'.$tableName, '', $permissionKey);
                });

            $permissionKeyToInsert = collect([]);
            if(!empty($data['additional_permissions']) && is_array($data['additional_permissions'])) {
                $permissionKeyToInsert = collect($data['additional_permissions'])->filter(function ($permissionCode, $key) {
                    return !empty($permissionCode) && is_string($permissionCode);
                })->map(function ($permissionCode, $key) {
                    return preg_replace('/\s+/', '', $permissionCode);
                })->diff($existingPermissions);
                $permissionKeyToRemove = $existingPermissions->diff($data['additional_permissions']);
            } else {
                $permissionKeyToRemove = $existingPermissions;
            }

/*            Log::debug($permissionKeyToInsert->all());
            Log::debug($permissionKeyToRemove->all());*/

            if($permissionKeyToRemove->isNotEmpty()){
                $ptoRemove = $permissionKeyToRemove->map(function($permissionKey, $key) use($tableName) {
                    return $permissionKey . '_' . $tableName;
                })->all();

                $permissionModelClassName::whereIn('key', $ptoRemove)->delete();
            }
            if($permissionKeyToInsert->isNotEmpty()){
                $permissionKeyToInsert->each(function($permissionKey, $key) use($permissionModelClassName, $tableName) {
                    $permissionModelClassName::firstOrCreate(['key' => $permissionKey . '_' . $tableName, 'table_name' => $tableName, 'is_user_defined' => 1]);
                });

            }
        }
    }
}
