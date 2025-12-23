<?php

namespace App\Models;
use App\Models\Department;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use TCG\Voyager\Facades\Voyager;
use App\Notifications\PasswordReset;


class User extends \TCG\Voyager\Models\User
{
    use SoftDeletes, Notifiable;

    const SUPER_ADMIN = 'super_admin';
    const ADMIN = 'admin';
    const NORMAL_USER = 'normal_user';

    const USER_TYPES = [
        User::SUPER_ADMIN => User::SUPER_ADMIN,
        User::ADMIN => User::ADMIN,
        User::NORMAL_USER => User::NORMAL_USER
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'user_type', 'user_name', 'mobile','otp',
        'password', 'created_by', 'updated_by', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isSuperAdmin()
    {
        return $this->user_type === User::SUPER_ADMIN;
    }

    public function isAdmin()
    {
        return $this->user_type === User::ADMIN;
    }

    public function isSuperUser()
    {
        return $this->is_superuser;
    }
    /**
     * @param array $types
     * @return mixed
     * @author Baker Hasan <baker@softbdltd.com>
     */
    public function hasType(...$types)
    {
        return in_array($this->user_type, $types, true);
    }

    /**
     * @param $query
     * @return Builder
     */
    public function scopeAcl($query)
    {
        /**  @var Builder $query */
        /** @var \App\Models\User $authUser */

        $authUser = Auth::user();
        if ($authUser->isSuperAdmin() || $authUser->isSuperUser()) {
            return $query;
        }

        if ($authUser->isAdmin()) {
            $query->where('user_type', '!=', User::SUPER_ADMIN);
        }

        return $query;
    }

    /**
     * users custom permission start
     */
    public function activePermissions()
    {
        return $this->hasMany(UsersPermission::class)->where('status', true)->with('permission');
    }

    public function inActivePermissions()
    {
        return $this->hasMany(UsersPermission::class)->where('status', false)->with('permission');
    }

    public function role()
    {
        return $this->belongsTo(Voyager::modelClass('Role'));
    }

    public function loadRolesRelations()
    {
        if (!$this->relationLoaded('role')) {
            $this->load('role');
        }

        if (!$this->relationLoaded('roles')) {
            $this->load('roles');
        }

        if (!$this->relationLoaded('activePermissions')) {
            $this->load('activePermissions');
        }
        if (!$this->relationLoaded('inActivePermissions')) {
            $this->load('inActivePermissions');
        }
    }

    public function loadPermissionsRelations()
    {
        $this->loadRolesRelations();

        if ($this->role && !$this->role->relationLoaded('permissions')) {
            $this->role->load('permissions');
            $this->load('roles.permissions');
        }
    }

    public function hasPermission($name)
    {
        $this->loadPermissionsRelations();

        return $this->roles_all()->contains($name);
    }

    /**
     * @return Collection
     */
    public function allPermissionKey()
    {
        $this->loadRolesRelations();
        $inactiveKeys = $this->getInactivePermissionKeys();

        $activeKeys = $this->getActivePermissionKeys();

        $defaultRolekeys = $this->role->permissions()->pluck('key')->concat($activeKeys);

        return $this->roles()->get()
            ->map(function ($additionalRole) {
                return $additionalRole->permissions()->pluck('key')->all();
            })
            ->flatten()
            ->concat($defaultRolekeys)
            ->diff($inactiveKeys)
            ->unique();
    }

    public function getCustomPermissions()
    {
        return collect([$this->getActivePermissionKeys()])->merge($this->getInactivePermissionKeys())->flatten();
    }

    public function getActivePermissionKeys()
    {
        return $this->activePermissions()->get()->map(function ($userPermission) {
            return $userPermission->permission->key;
        });
    }

    public function getInactivePermissionKeys()
    {
        return $this->inActivePermissions()->get()->map(function ($userPermission) {
            return $userPermission->permission->key;
        });
    }

    public function roles_all()
    {
        return Cache::rememberForever('userwise_permissions_' . auth()->id(), function () {
            return $this->allPermissionKey();
        });
    }
    public function register(array $options = [])
    {
        return parent::save($options);
    }
    public function save(array $options = [])
    {
        return parent::save($options);
    }

    public function update(array $attributes = [], array $options = [])
    {
        $this->updated_by = auth()->user()->id;
        return parent::update($attributes, $options);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
