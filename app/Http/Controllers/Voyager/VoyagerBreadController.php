<?php

namespace App\Http\Controllers\Voyager;

use App\Events\Voyager\BreadAdded;
use App\Events\Voyager\BreadDeleted;
use App\Events\Voyager\BreadUpdated;
use App\Facades\Voyager;
use App\Voyager\Database\Schema\SchemaManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use ReflectionClass;


class VoyagerBreadController extends Controller
{
    public function index()
    {
        $this->authorize('browse_bread');

        $dataTypes = Voyager::model('DataType')->select('id', 'name', 'slug')->get()->keyBy('name')->toArray();

        $tables = array_map(function ($table) use ($dataTypes) {
            $table = [
                'name' => $table,
                'slug' => $dataTypes[$table]['slug'] ?? null,
                'dataTypeId' => $dataTypes[$table]['id'] ?? null,
            ];

            return (object)$table;
        }, SchemaManager::listTableNames());

        return Voyager::view('voyager::tools.bread.index')->with(compact('dataTypes', 'tables'));
    }

    /**
     * Create BREAD.
     *
     * @param Request $request
     * @param string $table Table name.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request, $table)
    {
        $this->authorize('browse_bread');

        $dataType = Voyager::model('DataType')->whereName($table)->first();

        $data = $this->prepopulateBreadInfo($table);
        $data['fieldOptions'] = SchemaManager::describeTable((isset($dataType) && strlen($dataType->model_name) != 0)
            ? app($dataType->model_name)->getTable()
            : $table
        );

        return Voyager::view('voyager::tools.bread.edit-add', $data);
    }


    private function prepopulateBreadInfo($table)
    {
        $displayName = Str::singular(implode(' ', explode('_', Str::title($table))));
        $modelNamespace = config('voyager.models.namespace', app()->getNamespace());
        if (empty($modelNamespace)) {
            $modelNamespace = app()->getNamespace();
        }

        return [
            'table' => $table,
            'slug' => Str::slug($table),
            'display_name' => $displayName,
            'display_name_plural' => Str::plural($displayName),
            'model_name' => $modelNamespace . Str::studly(Str::singular($table)),
            'generate_permissions' => true,
            'server_side' => false,
        ];
    }

    /**
     * Store BREAD.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('browse_bread');

        try {
            $dataType = Voyager::model('DataType');
            $res = $dataType->updateDataType($request->all(), true);
            $data = $res
                ? $this->alertSuccess(__('voyager::bread.success_created_bread'))
                : $this->alertError(__('voyager::bread.error_creating_bread'));
            if ($res) {
                event(new BreadAdded($dataType, $data));
            }
        } catch (\Exception $e) {
            return redirect()->route('voyager.bread.index')->with($this->alertException($e, 'Saving Failed'));
        }

        if($request->query('continue') && $res){
            return redirect()->route('voyager.bread.edit', $dataType->name)->with($data);
        }
        return redirect()->route('voyager.bread.index')->with($data);
    }


    /**
     * Edit BREAD. Overriden method
     *
     * @param string $table
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($table)
    {
        $this->authorize('browse_bread');

        $dataType = Voyager::model('DataType')->whereName($table)->first();

        $fieldOptions = SchemaManager::describeTable((strlen($dataType->model_name) != 0)
            ? app($dataType->model_name)->getTable()
            : $dataType->name
        );

        $tables = SchemaManager::listTableNames();
        $dataTypeRelationships = Voyager::model('DataRow')->where('data_type_id', '=', $dataType->id)->where('type', '=', 'relationship')->get();
        $additionalPermissions = Voyager::model('Permission')->where('table_name', '=', $dataType->name)->where('is_user_defined', '=', 1)->get();
        $scopes = [];
        if ($dataType->model_name != '') {
            $scopes = $this->getModelScopes($dataType->model_name);
        }

        return Voyager::view('voyager::tools.bread.edit-add', compact('dataType', 'fieldOptions', 'tables', 'dataTypeRelationships', 'scopes', 'additionalPermissions'));
    }


    /**
     * Update BREAD.
     *
     * @param \Illuminate\Http\Request $request
     * @param number $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $id)
    {
        $this->authorize('browse_bread');

        /* @var \App\Models\DataType $dataType */
        try {
            $dataType = Voyager::model('DataType')->find($id);

            $res = $dataType->updateDataType($request->all(), true);
            $data = $res
                ? $this->alertSuccess(__('voyager::bread.success_update_bread', ['datatype' => $dataType->name]))
                : $this->alertError(__('voyager::bread.error_updating_bread'));
            if ($res) {
                event(new BreadUpdated($dataType, $data));
            }
        } catch (\Exception $e) {
            return back()->with($this->alertException($e, __('voyager::generic.update_failed')));
        }

        if ($request->query('continue')) {
            return redirect()->route('voyager.bread.edit', $dataType->name)->with($data);
        }
        return redirect()->route('voyager.bread.index')->with($data);
    }

    /**
     * Delete BREAD.
     *
     * @param Number $id BREAD data_type id.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $this->authorize('browse_bread');

        /* @var \App\Models\DataType $dataType */
        $dataType = Voyager::model('DataType')->find($id);

        $res = Voyager::model('DataType')->destroy($id);
        $data = $res
            ? $this->alertSuccess(__('voyager::bread.success_remove_bread', ['datatype' => $dataType->name]))
            : $this->alertError(__('voyager::bread.error_updating_bread'));
        if ($res) {
            event(new BreadDeleted($dataType, $data));
        }

        if (!is_null($dataType)) {
            Voyager::model('Permission')->removeFrom($dataType->name);
        }

        return redirect()->route('voyager.bread.index')->with($data);
    }

    public function getModelScopes($model_name)
    {
        $reflection = new ReflectionClass($model_name);

        return collect($reflection->getMethods())->filter(function ($method) {
            return Str::startsWith($method->name, 'scope');
        })->whereNotIn('name', ['scopeWithTranslations', 'scopeWithTranslation', 'scopeWhereTranslation'])->transform(function ($method) {
            return lcfirst(Str::replaceFirst('scope', '', $method->name));
        });
    }

    // ************************************************************
    //  _____      _       _   _                 _     _
    // |  __ \    | |     | | (_)               | |   (_)
    // | |__) |___| | __ _| |_ _  ___  _ __  ___| |__  _ _ __  ___
    // |  _  // _ \ |/ _` | __| |/ _ \| '_ \/ __| '_ \| | '_ \/ __|
    // | | \ \  __/ | (_| | |_| | (_) | | | \__ \ | | | | |_) \__ \
    // |_|  \_\___|_|\__,_|\__|_|\___/|_| |_|___/_| |_|_| .__/|___/
    //                                                  | |
    //                                                  |_|
    // ************************************************************

    /**
     * Add Relationship.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addRelationship(Request $request)
    {
        $relationshipField = $this->getRelationshipField($request);

        if (!class_exists($request->relationship_model)) {
            return back()->with([
                'message' => 'Model Class ' . $request->relationship_model . ' does not exist. Please create Model before creating relationship.',
                'alert-type' => 'error',
            ]);
        }

        try {
            DB::beginTransaction();

            $relationship_column = $request->relationship_column_belongs_to;
            if ($request->relationship_type == 'hasOne' || $request->relationship_type == 'hasMany') {
                $relationship_column = $request->relationship_column;
            }

            // Build the relationship details
            $relationshipDetails = [
                'model' => $request->relationship_model,
                'table' => $request->relationship_table,
                'type' => $request->relationship_type,
                'column' => $relationship_column,
                'key' => $request->relationship_key,
                'label' => $request->relationship_label,
                'pivot_table' => $request->relationship_pivot,
                'pivot' => ($request->relationship_type == 'belongsToMany') ? '1' : '0',
                'taggable' => $request->relationship_taggable,
            ];

            $className = Voyager::modelClass('DataRow');
            $newRow = new $className();

            $newRow->data_type_id = $request->data_type_id;
            $newRow->field = $relationshipField;
            $newRow->type = 'relationship';
            $newRow->display_name = $request->relationship_table;
            $newRow->required = 0;

            foreach (['browse', 'read', 'edit', 'add', 'delete'] as $check) {
                $newRow->{$check} = 1;
            }

            $newRow->details = $relationshipDetails;
            $newRow->order = intval(Voyager::model('DataType')->find($request->data_type_id)->lastRow()->order) + 1;

            if (!$newRow->save()) {
                return back()->with([
                    'message' => 'Error saving new relationship row for ' . $request->relationship_table,
                    'alert-type' => 'error',
                ]);
            }

            DB::commit();

            return back()->with([
                'message' => 'Successfully created new relationship for ' . $request->relationship_table,
                'alert-type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with([
                'message' => 'Error creating new relationship: ' . $e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    /**
     * Get Relationship Field.
     *
     * @param Request $request
     *
     * @return string
     */
    private function getRelationshipField($request)
    {
        // We need to make sure that we aren't creating an already existing field

        $dataType = Voyager::model('DataType')->find($request->data_type_id);

        $field = Str::singular($dataType->name) . '_' . $request->relationship_type . '_' . Str::singular($request->relationship_table) . '_relationship';

        $relationshipFieldOriginal = $relationshipField = strtolower($field);

        $existingRow = Voyager::model('DataRow')->where('field', '=', $relationshipField)->first();
        $index = 1;

        while (isset($existingRow->id)) {
            $relationshipField = $relationshipFieldOriginal . '_' . $index;
            $existingRow = Voyager::model('DataRow')->where('field', '=', $relationshipField)->first();
            $index += 1;
        }

        return $relationshipField;
    }

    /**
     * Delete Relationship.
     *
     * @param Number $id Record id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteRelationship($id)
    {
        Voyager::model('DataRow')->destroy($id);

        return back()->with([
            'message' => 'Successfully deleted relationship.',
            'alert-type' => 'success',
        ]);
    }
}
