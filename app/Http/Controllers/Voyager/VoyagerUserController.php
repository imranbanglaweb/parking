<?php

namespace App\Http\Controllers\Voyager;

use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use App\Models\Station;
use App\Models\UsersPermission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use TCG\Voyager\Facades\Voyager;
use Yajra\DataTables\Facades\DataTables;


class VoyagerUserController extends VoyagerBaseController
{
    const VIEW_PATH = 'vendor.voyager.';

    /**
     * @return mixed
     */
    public function notifications()
    {
        return Auth::user()->unreadNotifications()->limit(5)->get()->toArray();
    }

    public function profile(Request $request)
    {
        return Voyager::view(self::VIEW_PATH . 'profile');
    }

    public function index(Request $request)
    {
        $this->authorize('browse', app(User::class));
        $usesSoftDeletes = true;
        $isServerSide = false;

        $localPrefix = 'bread.users.';
        $view = "voyager::users.browse";
        return Voyager::view($view, compact(
            'isServerSide',
            'usesSoftDeletes',
            'localPrefix'
        ));
    }

    public function create(Request $request)
    {

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        /** @var User $dataTypeContent */
        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? new $dataType->model_name()
            : false;

        foreach ($dataType->addRows as $key => $row) {
            $dataType->addRows[$key]['col_width'] = $row->details->width ?? 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'add');


        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $userTypes = getFormattedUserTypes($authUser->user_type);
        $departments=  Department::all();
        $stations= Station::all();
        $view = self::VIEW_PATH . 'bread.edit-add';

        if (view()->exists(self::VIEW_PATH . "$slug.edit-add")) {
            $view = self::VIEW_PATH . "$slug.edit-add";
        }

        return Voyager::view($view, compact('userTypes', 'dataType',
            'dataTypeContent', 'isModelTranslatable','departments','stations'));
    }

    public function store(Request $request)
    {
        $user = app(User::class);
        $this->authorize('add', $user);
        $this->validate($request, [
            'name' => 'required',
            'department_id' => 'required',
            'station_id' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|regex:/^01[1-9][0-9]{8}$/|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        $inputs = $request->input();
        $attributes = [
            'name', 'email','station_id', 'user_type', 'mobile', 'status', 'role_id','is_verifier','department_id'
        ];

        foreach ($inputs as $field => $value) {
            if (in_array($field, $attributes)) {
                $user->{$field} = $value;
            }
        }

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $name = 'users/' . time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/users');
            $image->move($destinationPath, $name);
            $user->avatar = $name;
        }


        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        DB::beginTransaction();

        try {
            $user->save();
            if ($request->user_belongstomany_role_relationship) {
                $user->roles()->attach($request->user_belongstomany_role_relationship);
            }
            DB::commit();
        } catch (\Exception $e) {
            Log::debug($e);
            DB::rollback();
            return response()->json([
                'message' => __('voyager::generic.something_wrong')
            ], 403);
        }
        return response()->json([
            'message' => __('bread.users.model_name') . ' '.__('voyager::generic.successfully_added_new')
        ], 200);
    }

    public function edit(Request $request, $id)
    {
        /** @var \App\Models\User $authUser */

        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        /** @var  $dataTypeContent \App\Models\User */
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses($model))) {
                $model = $model->withTrashed();
            }
            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $model = $model->{$dataType->scope}();
            }
            $dataTypeContent = call_user_func([$model, 'findOrFail'], $id);

        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = Voyager::modelClass('User')->where('id', $id)->first();
        }

        foreach ($dataType->editRows as $key => $row) {
            $dataType->editRows[$key]['col_width'] = isset($row->details->width) ? $row->details->width : 100;
        }
        $departments=  Department::all();
        $stations= Station::all();
        $allPermissionTableNames = Voyager::model('Permission')->all()->groupBy('table_name');
        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'edit');

        $userPermissions = $dataTypeContent->allPermissionKey()->all();

        $customPermissions = $dataTypeContent->getCustomPermissions()->all();

        // Check permission
        $this->authorize('edit', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $authUser = Auth::user();

        $userTypes = getFormattedUserTypes($authUser->user_type);

        $roles = Role::pluck('display_name', 'id');

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        $userExtraRoles = $dataTypeContent->roles()->get()->keyBy('id');

        return Voyager::view($view, compact(
            'dataType', 'dataTypeContent', 'isModelTranslatable', 'userPermissions', 'customPermissions',
            'allPermissionTableNames', 'userTypes', 'roles', 'userExtraRoles','departments','stations'
        ));
    }

    public function update(Request $request, $id)
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        $this->validate($request, [
            'name' => 'required',
            'department_id' => 'required',
            'station_id' => 'required',
            'user_type' => [Rule::in(User::USER_TYPES)],
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile' => 'required|regex:/^(\+88)?01[1-9][0-9]{8}$/|unique:users,mobile,' . $id,
            'password' => 'nullable|confirmed|min:6'
        ]);

        /** @var User $user */
        $user = User::findOrFail($id);
        $this->authorize('edit', $user);

        $inputs = $request->input();
        $attributes = ['name', 'email', 'user_type', 'mobile', 'status', 'role_id','department_id','is_verifier','station_id'];
        foreach ($inputs as $field => $value) {
            if (in_array($field, $attributes)) {
                $user->{$field} = $value;
            }
        }

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $name = 'users/' . time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/users');
            $image->move($destinationPath, $name);
            $user->avatar = $name;
        }

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        DB::beginTransaction();

        try {
            $user->save();

            if ($authUser->can('editRoles', $user) && $request->user_belongstomany_role_relationship) {
                $user->roles()->sync($request->user_belongstomany_role_relationship);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => __('voyager::generic.something_wrong')
            ], 403);
        }
        return response()->json([
            'message' => __('bread.users.model_name') . ' '.__('voyager::generic.successfully_updated')
        ], 200);
    }

    public function changePermission(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'permission_id' => 'required|integer',
        ]);

        $this->authorize('editUserPermission', Voyager::model('User'));

        $user_id = $request->user_id;
        $permission_id = $request->permission_id;
        $checkboxStatus = !empty($request->checkboxStatus) && $request->checkboxStatus == 'true' ? 1 : 0;

        Cache::forget('userwise_permissions_' . $user_id);

        $userPermission = UsersPermission::updateOrCreate(
            ['permission_id' => $permission_id, 'user_id' => $user_id],
            ['status' => $checkboxStatus]
        );

        if (!empty($userPermission) && $userPermission->id) {
            return $userPermission;
        } else {
            abort(400);
        }
    }

    public function changePermissionForTable(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'permission_ids' => 'required|array|min:1',
        ]);

        $user_id = $request->user_id;
        $this->authorize('editUserPermission', Voyager::model('User'));
        $checkboxStatus = !empty($request->checkboxStatus) && $request->checkboxStatus == 'true' ? 1 : 0;
        $permissionIds = $request->permission_ids;

        $collection = collect($permissionIds)->unique()->filter(function ($element) {
            $element = is_scalar($element) ? (int)$element : $element;
            return is_integer($element);
        })->map(function ($permissionId) use ($user_id) {
            return ['permission_id' => $permissionId, 'user_id' => $user_id];
        });

        /** @var $collection Collection */

        $count = 0;
        if ($collection->isNotEmpty()) {
            Cache::forget('userwise_permissions_' . $user_id);
            $collection->each(function ($entity) use ($checkboxStatus, &$count) {
                $userPermission = UsersPermission::updateOrCreate(
                    $entity,
                    ['status' => $checkboxStatus]
                );
                if (!empty($userPermission) && $userPermission->id) {
                    $count++;
                }
            });
        }

        if ($collection->isEmpty() || $collection->count() != $count) {
            abort(400);
        } else {
            return ['success' => 1];
        }
    }

    public function getDatatable(Request $request)
    {
        /** @var User $user */
        $authUser = Auth::user();

        try {
            /** @var Builder $users */
            $users = User::select([
                'users.id as id',
                'users.name',
                'users.email',
                'users.mobile',
                'users.avatar',
                'users.user_type',
                'users.deleted_at',
                'users.created_at',
                'users.updated_at',
                'roles.display_name as role_name',
            ]);

            /** relations */
            $users->leftJoin('roles', 'users.role_id', '=', 'roles.id');

            /** check soft delete */
            if ($request->has('show_soft_deletes') && $request->show_soft_deletes) {
                $users->withTrashed();
            }

            /** check access control */
            if ($authUser->isAdmin()) {
                $users->where('user_type', '!=', User::SUPER_ADMIN);
            }

            /** action buttons */
            return DataTables::eloquent($users)
                ->addColumn('avatar', function (User $user) {
                    return '<img src="'. Voyager::image($user->avatar) .'" border="0" width="40" class="img-rounded" align="center" />';
                })
                ->addColumn('action', function (User $user) use ($authUser) {
                    $str = "";
                    if ($authUser->can('read', $user)) {
                        $str .= ' <a class="btn btn-sm btn-warning view" href="' . route('voyager.users.show', $user->id) . '"><i class="voyager-eye"></i> ' . __('voyager::generic.view') . '</a>';
                    }

                    if ($authUser->can('edit', $user)) {
                        $str .= ' <a class="btn btn-sm btn-primary edit" href="' . route('voyager.users.edit', $user->id) . '"><i class="voyager-edit"></i> ' . __('voyager::generic.edit') . '</a>';
                    }
                    if ($authUser->can('delete', $user)) {
                        $str .= " <a href='javascript:;'title='delete margin-top' class='btn btn-sm btn-danger delete' data-id='" . $user->id . "' data-id='" . $user->id . "' id='delete-'.$user->id><i class='voyager-trash'></i> <span class='hidden-xs hidden-sm'>" . __('voyager::generic.delete') . "</span></a>";
                    }
                    return $str;
                })
                ->rawColumns(['avatar', 'action'])
                ->toJson();
        } catch (\Exception $ex) {
            return response()->json([], 404);
        }
    }

    public function getUserByStation(Request $request) {

        $users= User::where('station_id',$request->station_id)->get();
        $view = "voyager::users.partials.users";
        return Voyager::view($view, compact('users'));

    }


}
