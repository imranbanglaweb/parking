<?php

use App\Models\User;
use Illuminate\Support\Str;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return TCG\Voyager\Facades\Voyager::setting($key, $default);
    }
}

if (!function_exists('menu')) {
    function menu($menuName, $type = null, array $options = [])
    {
        return TCG\Voyager\Facades\Voyager::model('Menu')->display($menuName, $type, $options);
    }
}

if (!function_exists('voyager_asset')) {
    function voyager_asset($path, $secure = null)
    {
        return route('voyager.voyager_assets') . '?path=' . urlencode($path);
    }
}

if (!function_exists('get_file_name')) {
    function get_file_name($name)
    {
        preg_match('/(_)([0-9])+$/', $name, $matches);
        if (count($matches) == 3) {
            return Illuminate\Support\Str::replaceLast($matches[0], '', $name) . '_' . (intval($matches[2]) + 1);
        } else {
            return $name . '_1';
        }
    }
}

if (!function_exists('getUserTypes')) {
    function getUserTypes(string $for = User::NORMAL_USER)
    {
        $userTypes = User::USER_TYPES;

        if ($for == User::NORMAL_USER) {
            unset($userTypes[User::SUPER_ADMIN]);
        }
        return $userTypes ?? [];
    }
}

if (!function_exists('getFormattedUserTypes')) {
    function getFormattedUserTypes(string $for = User::NORMAL_USER)
    {
        $userTypes = getUserTypes($for);
        if (!$userTypes) return [];

        return array_map(function ($type) {
            return Str::title(Str::replaceFirst('_', ' ', $type));
        }, $userTypes);
    }
}


if (!function_exists('bn2en')) {
    function bn2en($number)
    {
        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        return str_replace($bn, $en, $number);
    }
}

if (!function_exists('en2bn')) {
    function en2bn($number)
    {
        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        return str_replace($en, $bn, $number);
    }
}

if (!function_exists('localizedMenu')) {
    function localizedMenu($menuName, $type = null, array $options = [])
    {
        $localizedMenu = App\Facades\Voyager::model('Menu')->display($menuName, $type, $options);

        return $localizedMenu;
    }
    if (!function_exists('isCommonLocalKey')) {
        function isCommonLocalKey($key = null)
        {
            return !is_null($key) && in_array(Str::snake($key), config('voyager.common_local_keys'), true);
        }
    }
}
