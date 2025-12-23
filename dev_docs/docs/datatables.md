#Datatable

## Frontend Part
**Important/Required Part of configuration**
```php-inline
var dataTableParams = {!! json_encode(
    array_merge([
        "language" => __('voyager::datatable'),
        "processing" => true,
        "serverSide" => true,
        "ordering" => true,
        "searching" => true,
        "stateSave"=> false,
        "ajax" => [
            "method" => "POST",
            "url" => route("users.datatable"),
        ],
        "columns" => [
            [ "data" => 'action', 'orderable' => false, 'searchable' => false, 'visible' => true]
        ]
    ],
    config('voyager.dashboard.data_tables', []))
, true) !!};
```
**Initialize Datatable**
```javascript
let table = $('#dataTable').DataTable(dataTableParams);
```
**Add this line if you want to show soft deleted rows**
```javascript
let showSoftDeletes = 0;
$('#show_soft_deletes').change(function () {
    showSoftDeletes = $(this).prop('checked') ? 1 : 0;
    table.draw();
});
```
**To customize search behavior**
```javascript
$(document).on('focus', '.dataTables_filter input', function() {
    $(this).unbind().bind('keyup', function(e) {
        if(e.keyCode === 13) {
            table.search( this.value ).draw();
        }
    });
});
```
**To delete specific row**
```javascript
$(document, 'td').on('click', '.delete', function (e) {
    $('#delete_form')[0].action = $(this).data('action');
    $('#delete_modal').modal('show');
});
```

## Backend Part
**Declare a route for datatable (N.B: method => post)**
```php-inline
Route::post('users/datatable', 'Voyager\VoyagerUserController@getDatatable')->name('users.datatable');
```

**Controller Method implementation**
```php-inline
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
            ->editColumn('name', function (User $user) use ($authuser) { return ""; })
            ->addColumn('action', function (User $user) use ($authUser) { return ""; })
            ->rawColumns(['action'])
            ->toJson();
    } catch (\Exception $ex) {
        return response()->json([], 404);
    }
}
```
