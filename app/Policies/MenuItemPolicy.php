<?php

namespace App\Policies;

use App\Facades\Voyager;
use App\Models\User;


class MenuItemPolicy extends CustomBasePolicy
{
    protected static $datatypes = null;
    protected static $permissions = null;

    /**
     * Check if user has an associated permission.
     *
     * @param \App\Models\User $user
     * @param object $model
     * @param string $action
     *
     * @return bool
     */
    protected function checkPermission(User $user, $model, $action)
    {
        if($model->permission_key){
            return $user->hasPermission($model->permission_key);
        }
        if (self::$permissions == null) {
            self::$permissions = Voyager::model('Permission')->all();
        }

        if (self::$datatypes == null) {
            self::$datatypes = Voyager::model('DataType')::all()->keyBy('slug');
        }

        $regex = str_replace('/', '\/', preg_quote(route('voyager.dashboard')));
        $slug = preg_replace('/'.$regex.'/', '', $model->link(true));
        $slug = str_replace('/', '', $slug);

        if ($str = self::$datatypes->get($slug)) {
            $slug = $str->name;
        }

        if ($slug == '') {
            $slug = 'admin';
        } elseif ($slug == 'compass' && !\App::environment('local') && !config('voyager.compass_in_production', false)) {
            return false;
        }

        if (empty($action)) {
            $action = 'browse';
        }

        // If permission doesn't exist, we can't check it!
        if (!self::$permissions->contains('key', $action.'_'.$slug)) {
            return true;
        }

        return $user->hasPermission($action.'_'.$slug);
    }
}
