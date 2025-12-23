<?php

namespace App\Http\Controllers\Voyager;

use App\Events\Voyager\BreadDataAdded;
use App\Events\Voyager\BreadDataDeleted;
use App\Events\Voyager\BreadDataRestored;
use App\Events\Voyager\BreadDataUpdated;
use App\Events\Voyager\BreadImagesDeleted;
use App\Facades\Voyager;
use App\Http\Controllers\Voyager\ContentTypes\Checkbox;
use App\Http\Controllers\Voyager\ContentTypes\Coordinates;
use App\Http\Controllers\Voyager\ContentTypes\File;
use App\Http\Controllers\Voyager\ContentTypes\Image as ContentImage;
use App\Http\Controllers\Voyager\ContentTypes\Json;
use App\Http\Controllers\Voyager\ContentTypes\MultipleCheckbox;
use App\Http\Controllers\Voyager\ContentTypes\MultipleImage;
use App\Http\Controllers\Voyager\ContentTypes\Password;
use App\Http\Controllers\Voyager\ContentTypes\Relationship;
use App\Http\Controllers\Voyager\ContentTypes\SelectMultiple;
use App\Http\Controllers\Voyager\ContentTypes\Text;
use App\Http\Controllers\Voyager\ContentTypes\Timestamp;
use App\Http\Controllers\Voyager\Traits\BreadRelationshipParser;
use App\Models\DataType;
use Illuminate\Support\Facades\Log;
use App\Voyager\Database\Schema\SchemaManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class VoyagerBaseController extends Controller
{
    use BreadRelationshipParser;

    //***************************************
    //               ____
    //              |  _ \
    //              | |_) |
    //              |  _ <
    //              | |_) |
    //              |____/
    //
    //      Browse our Data Type (B)READ
    //
    //****************************************
    protected $additionalColumnsInList = [];

    public function index(Request $request)
    {
        /** GET THE SLUG, ex. 'posts', 'pages', etc. */
        $slug = $this->getSlug($request);

        /** GET THE DataType based on the slug */
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        /** Check permission */
        $this->authorize('browse', app($dataType->model_name));

        $getter = $dataType->server_side ? 'paginate' : 'get';

        $search = (object)['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];
        $searchable = $dataType->server_side ? array_keys(SchemaManager::describeTable(app($dataType->model_name)->getTable())->toArray()) : '';
        $orderBy = $request->get('order_by', $dataType->order_column);
        $sortOrder = $request->get('sort_order', null);

        $usesSoftDeletes = false;
        $showSoftDeleted = false;
        $orderColumn = [];

        if ($orderBy) {
            $index = $dataType->browseRows->where('field', $orderBy)->keys()->first() + 1;
            $orderColumn = [[$index, 'desc']];
            if (!$sortOrder && isset($dataType->order_direction)) {
                $sortOrder = $dataType->order_direction;
                $orderColumn = [[$index, $dataType->order_direction]];
            } else {
                $orderColumn = [[$index, 'desc']];
            }
        }

        /** Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType */
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);
            /** @var Collection $columnNames */
            $columnNames = $dataType->browseRows()->select(['data_type_id', 'field', 'id', 'type'])
                ->where('type', '!=', 'relationship')
                ->pluck('field');

            if (method_exists($model, 'trashed')) {
                $columnNames->prepend('id')->prepend('deleted_at');
            } else {
                $columnNames->prepend('id');
            }

            if (count($this->additionalColumnsInList)) {
                foreach ($this->additionalColumnsInList as $column) {
                    $columnNames->prepend($column);
                }
            }
            $columnNames = $columnNames->all();
            if (!empty($columnNames) && $dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $query = $model->select($columnNames)->{$dataType->scope}();
            } else if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $query = $model->{$dataType->scope}();
            } else if (!empty($columnNames)) {
                $query = $model->select($columnNames);
            } else {
                $query = $model->select("*");
            }

            /** Use withTrashed() if model uses SoftDeletes and if toggle is selected */
            if ($model && in_array(SoftDeletes::class, class_uses($model)) && app('VoyagerAuth')->user()->can('delete', app($dataType->model_name))) {
                $usesSoftDeletes = true;

                if ($request->get('showSoftDeleted')) {
                    $showSoftDeleted = true;
                    $query = $query->withTrashed();
                }
            }

            /** If a column has a relationship associated with it, we do not want to show that field */
            $this->removeRelationshipField($dataType, 'browse');

            if ($search->value != '' && $search->key && $search->filter) {
                $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
                $search_value = ($search->filter == 'equals') ? $search->value : '%' . $search->value . '%';
                $query->where($search->key, $search_filter, $search_value);
            }

            if ($orderBy && in_array($orderBy, $dataType->fields())) {
                $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'desc';
                $dataTypeContent = call_user_func([
                    $query->orderBy($orderBy, $querySortOrder),
                    $getter,
                ]);
            } elseif ($model->timestamps) {
                $dataTypeContent = call_user_func([$query->latest($model::CREATED_AT), $getter]);
            } else {
                $dataTypeContent = call_user_func([$query->orderBy($model->getKeyName(), 'DESC'), $getter]);
            }

            /** Replace relationships' keys for labels and create READ links if a slug is provided. */
            $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType);
        } else {
            /** If Model doesn't exist, get data from table name */
            $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
            $model = false;
        }

        /** Check if BREAD is Translatable */
        if (($isModelTranslatable = is_bread_translatable($model))) {
            $dataTypeContent->load('translations');
        }

        /**  Check if server side pagination is enabled */
        $isServerSide = isset($dataType->server_side) && $dataType->server_side;

        /** Check if a default search key is set */
        $defaultSearchKey = $dataType->default_search_key ?? null;

        $view = 'voyager::bread.browse';

        if (view()->exists("voyager::$slug.browse")) {
            $view = "voyager::$slug.browse";
        }

        return Voyager::view($view, compact(
            'dataType',
            'dataTypeContent',
            'isModelTranslatable',
            'search',
            'orderBy',
            'orderColumn',
            'sortOrder',
            'searchable',
            'isServerSide',
            'defaultSearchKey',
            'usesSoftDeletes',
            'showSoftDeleted'
        ));
    }

    public function show(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $isSoftDeleted = false;

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
            if ($dataTypeContent->deleted_at) {
                $isSoftDeleted = true;
            }
        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
        }

        // Replace relationships' keys for labels and create READ links if a slug is provided.
        $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType, true);

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'read');

        // Check permission
        $this->authorize('read', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.read';

        if (view()->exists("voyager::$slug.read")) {
            $view = "voyager::$slug.read";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'isSoftDeleted'));
    }

    public function store(Request $request)
    {
        $slug = $this->getSlug($request);

        /** @var DataType $dataType */
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        /** Check permission */
        $this->authorize('add', app($dataType->model_name));

        /** Validate fields with ajax */
        $val = $this->validateBread($request->all(), $dataType->addRows, $dataType->name)->validate();
        $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());

        event(new BreadDataAdded($dataType, $data));

        return redirect()
            ->route("voyager.{$dataType->slug}.index")
            ->with([
                'message' => __('voyager::generic.successfully_added_new') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
                'alert-type' => 'success',
            ]);
    }

    public function edit(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

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
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
        }

        foreach ($dataType->editRows as $key => $row) {
            $dataType->editRows[$key]['col_width'] = isset($row->details->width) ? $row->details->width : 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'edit');

        // Check permission
        $this->authorize('edit', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable'));
    }

    /** POST BR(E)AD */
    public function update(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        /** @var DataType $dataType */
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        /** Compatibility with Model binding. */
        $id = $id instanceof \Illuminate\Database\Eloquent\Model ? $id->{$id->getKeyName()} : $id;

        $model = app($dataType->model_name);
        if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
            $model = $model->{$dataType->scope}();
        }
        if ($model && in_array(SoftDeletes::class, class_uses($model))) {
            $data = $model->withTrashed()->findOrFail($id);
        } else {
            $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);
        }

        /** Check permission */
        $this->authorize('edit', $data);

        /** Validate fields with ajax */
        $val = $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();
        $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

        event(new BreadDataUpdated($dataType, $data));

        return redirect()
            ->route("voyager.{$dataType->slug}.index")
            ->with([
                'message' => __('voyager::generic.successfully_updated') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
                'alert-type' => 'success',
            ]);
    }

    public function create(Request $request)
    {
        $slug = $this->getSlug($request);

        /** @var DataType $dataType */
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        /** Check permission */
        $this->authorize('add', app($dataType->model_name));

        /** @var Model $dataTypeContent */
        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? new $dataType->model_name()
            : false;

        foreach ($dataType->addRows as $key => $row) {
            $dataType->addRows[$key]['col_width'] = $row->details->width ?? 100;
        }

        /** If a column has a relationship associated with it, we do not want to show that field */
        $this->removeRelationshipField($dataType, 'add');

        /** Check if BREAD is Translatable */
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable'));
    }

    /**
     * Get BREAD relations data.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function relation(Request $request)
    {
        $slug = $this->getSlug($request);
        $page = $request->input('page');
        $on_page = 50;
        $search = $request->input('search', false);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $filterConditions = $request->input('filter_condition');

        $rows = $request->input('method', 'add') == 'add' ? $dataType->addRows : $dataType->editRows;

        foreach ($rows as $key => $row) {
            if ($row->field === $request->input('type')) {
                $options = $row->details;

                $additionalOptions = $row->additional_details;

                $skip = $on_page * ($page - 1);

                /** @var Builder $model */

                $model = app($options->model);

                $columnsToSelect = [$options->key, $options->label];
                if (!empty($additionalOptions) && isset($additionalOptions->additional_fields) && is_array($additionalOptions->additional_fields)) {
                    $columnsToSelect = array_merge($columnsToSelect, $additionalOptions->additional_fields);
                }

                /*
                if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                    $model = $model->select($columnsToSelect)->{$dataType->scope}();
                } else {
                    $model = $model->select($columnsToSelect);
                }
                */

                $model = $model->select($columnsToSelect);
                Log::debug($filterConditions);
                if (!empty($filterConditions) && is_array($filterConditions)) {
                    collect($filterConditions)->each(function ($item, $key) use ($model) {
                        if (is_array($item) && count($item) == 2 && isset($item['field']) && isset($item['value'])) {
                            $model->where($item['field'], $item['value']);

                        } else if (is_array($item) && count($item) == 2 && isset($item['relation']) && isset($item['value'])) {
                            $model->whereHas($item['relation'], function (Builder $query) use ($item) {
                                $query->where($item['relation'] . '.id', $item['value']);
                            });
                        }
                    });
                }


                /** If search query, use LIKE to filter results depending on field label */
                if ($search) {
                    if (!empty($additionalOptions) && isset($additionalOptions->search_fields) && is_array($additionalOptions->search_fields)) {
                        $searchFields = $additionalOptions->search_fields;
                        $model->where(function (Builder $q) use ($search, $searchFields) {
                            foreach ($searchFields as $searchField) {
                                $q->orWhere($searchField, 'LIKE', '%' . $search . '%');
                            }
                            return $q;
                        });
                    } else {
                        $model->where($options->label, 'LIKE', '%' . $search . '%');
                    }

                    $total_count = $model->count();
                    $relationshipOptions = $model->take($on_page)->skip($skip)
                        ->get();
                } else {
                    $total_count = $model->count();
                    $relationshipOptions = $model->take($on_page)->skip($skip)->get();
                }

                $label = $options->label;
                if (!empty($additionalOptions) && isset($additionalOptions->label)) {
                    $label = $additionalOptions->label;
                }

                $results = [];
                foreach ($relationshipOptions as $relationshipOption) {
                    $results[] = [
                        'id' => $relationshipOption->{$options->key},
                        'text' => $relationshipOption->{$label},
                    ];
                }

                return response()->json([
                    'results' => $results,
                    'pagination' => [
                        'more' => ($total_count > ($skip + $on_page)),
                    ],
                ]);
            }
        }

        /** No result found, return empty array */
        return response()->json([], 404);
    }

    /**
     * Remove translations, images and files related to a BREAD item.
     *
     * @param \Illuminate\Database\Eloquent\Model $dataType
     * @param \Illuminate\Database\Eloquent\Model $data
     *
     * @return void
     */
    protected function cleanup($dataType, $data)
    {
        // Delete Translations, if present
        if (is_bread_translatable($data)) {
            $data->deleteAttributeTranslations($data->getTranslatableAttributes());
        }

        // Delete Images
        $this->deleteBreadImages($data, $dataType->deleteRows->where('type', 'image'));

        // Delete Files
        foreach ($dataType->deleteRows->where('type', 'file') as $row) {
            if (isset($data->{$row->field})) {
                foreach (json_decode($data->{$row->field}) as $file) {
                    $this->deleteFileIfExists($file->download_link);
                }
            }
        }

        // Delete media-picker files
        $dataType->rows->where('type', 'media_picker')->where('details.delete_files', true)->each(function ($row) use ($data) {
            $content = $data->{$row->field};
            if (isset($content)) {
                if (!is_array($content)) {
                    $content = json_decode($content);
                }
                if (is_array($content)) {
                    foreach ($content as $file) {
                        $this->deleteFileIfExists($file);
                    }
                } else {
                    $this->deleteFileIfExists($content);
                }
            }
        });
    }


    public function validateServerSide(Request $request)
    {
        $inputs = $request->input();

        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        if ($dataType->id && !empty($inputs['field']) && !empty($inputs[$inputs['field']])) {
            /** @var Builder $model */
            $model = app($dataType->model_name)->query();
            if (!empty($inputs['except_field']) && !empty($inputs['except_val'])) {
                $model->where($inputs['except_field'], '!=', $inputs['except_val']);
            }
            $model->where($inputs['field'], $inputs[$inputs['field']]);

            collect($inputs)->except(['field', $inputs['field'], 'except_field', 'except_val'])->each(function ($item, $key) use ($model) {
                $model->where($key, $item);
            });


            if ($model->exists()) {
                return "false";
            }
            return "true";
        }

        return "false";

    }

    public function destroy(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        /** @var DataType $dataType */
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission


        // Init array of IDs
        $ids = [];
        if (empty($id)) {
            // Bulk delete, get IDs from POST
            $ids = explode(',', $request->ids);
        } else {
            // Single item delete, get ID from URL
            $ids[] = $id;
        }
        foreach ($ids as $id) {
            $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);

            $model = app($dataType->model_name);
            if (!($model && in_array(SoftDeletes::class, class_uses($model)))) {
                $this->cleanup($dataType, $data);
            }
        }

        $displayName = count($ids) > 1 ? $dataType->getTranslatedAttribute('display_name_plural') : $dataType->getTranslatedAttribute('display_name_singular');

        if ($data && count($ids) == 1) {
            $this->authorize('delete', $data);
            $res = $data->delete();
            if (method_exists($data, 'onDeleteCleanUp')) {
                $data->onDeleteCleanUp();
            }
        } else {
            $res = $data->destroy($ids);
        }

        $data = $res
            ? [
                'message' => __('voyager::generic.successfully_deleted') . " {$displayName}",
                'alert-type' => 'success',
            ]
            : [
                'message' => __('voyager::generic.error_deleting') . " {$displayName}",
                'alert-type' => 'error',
            ];

        if ($res) {
            event(new BreadDataDeleted($dataType, $data));
        }

        return redirect()->route("voyager.{$dataType->slug}.index")->with($data);
    }

    public function restore(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        /** @var DataType $dataType */
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Get record
        $model = call_user_func([$dataType->model_name, 'withTrashed']);
        if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
            $model = $model->{$dataType->scope}();
        }
        $data = $model->findOrFail($id);

        $this->authorize('restore', $data);

        $displayName = $dataType->getTranslatedAttribute('display_name_singular');

        $res = $data->restore($id);
        $data = $res
            ? [
                'message' => __('voyager::generic.successfully_restored') . " {$displayName}",
                'alert-type' => 'success',
            ]
            : [
                'message' => __('voyager::generic.error_restoring') . " {$displayName}",
                'alert-type' => 'error',
            ];

        if ($res) {
            event(new BreadDataRestored($dataType, $data));
        }

        return redirect()->route("voyager.{$dataType->slug}.index")->with($data);
    }

    /**
     * Validates bread POST request.
     *
     * @param array $request The Request
     * @param array $data Field data
     * @param string $slug Slug
     * @param int $id Id of the record to update
     *
     * @return mixed
     */
    public function validateBread($request, $data, $name = null, $id = null)
    {
        $rules = [];
        $messages = [];
        $customAttributes = [];
        $is_update = $name && $id;

        $fieldsWithValidationRules = $this->getFieldsWithValidationRules($data);

        foreach ($fieldsWithValidationRules as $field) {
            $fieldRules = $field->details->validation->rule;
            $fieldName = $field->field;

            // Show the field's display name on the error message
            if (!empty($field->display_name)) {
                $customAttributes[$fieldName] = $field->getTranslatedAttribute('display_name');
            }

            // Get the rules for the current field whatever the format it is in
            $rules[$fieldName] = is_array($fieldRules) ? $fieldRules : explode('|', $fieldRules);

            if ($id && property_exists($field->details->validation, 'edit')) {
                $action_rules = $field->details->validation->edit->rule;
                $rules[$fieldName] = array_merge($rules[$fieldName], (is_array($action_rules) ? $action_rules : explode('|', $action_rules)));
            } elseif (!$id && property_exists($field->details->validation, 'add')) {
                $action_rules = $field->details->validation->add->rule;
                $rules[$fieldName] = array_merge($rules[$fieldName], (is_array($action_rules) ? $action_rules : explode('|', $action_rules)));
            }
            // Fix Unique validation rule on Edit Mode

            foreach ($rules[$fieldName] as &$fieldRule) {

                if (strpos(strtoupper($fieldRule), 'UNIQUE') !== false) {

                    $parts = explode(':', $fieldRule);
                    $additionalConditions = [];
                    if (count($parts) == 2) {
                        $uniColumns = explode(',', $parts[1]);
                        if (count($uniColumns) > 2) {
                            for ($in = 2; $in < count($uniColumns); $in++) {
                                if ($uniColumns[$in] && !empty($request[$uniColumns[$in]])) {
                                    $additionalConditions[$uniColumns[$in]] = $request[$uniColumns[$in]];
                                }

                            }

                        }
                    }


                    if ($is_update && !empty($additionalConditions)) {
                        $fieldRule = \Illuminate\Validation\Rule::unique($name)->where(function ($query) use ($additionalConditions) {
                            foreach ($additionalConditions as $field => $val) {
                                $query->where($field, $val);
                            }
                            return $query;
                        })->ignore($id);
                    } else if (!empty($additionalConditions)) {
                        $fieldRule = \Illuminate\Validation\Rule::unique($name)->where(function ($query) use ($additionalConditions) {
                            foreach ($additionalConditions as $field => $val) {
                                $query->where($field, $val);
                            }
                            return $query;
                        });
                    } else if ($is_update) {
                        $fieldRule = \Illuminate\Validation\Rule::unique($name)->ignore($id);
                    }
                }
            }

            // Set custom validation messages if any
            if (!empty($field->details->validation->messages)) {
                foreach ($field->details->validation->messages as $key => $msg) {
                    $messages["{$fieldName}.{$key}"] = $msg;
                }
            }
        }

        return Validator::make($request, $rules, $messages, $customAttributes);
    }

    public function getContentBasedOnType(Request $request, $slug, $row, $options = null)
    {
        switch ($row->type) {
            /********** PASSWORD TYPE **********/
            case 'password':
                return (new Password($request, $slug, $row, $options))->handle();
            /********** CHECKBOX TYPE **********/
            case 'checkbox':
                return (new Checkbox($request, $slug, $row, $options))->handle();
            /********** MULTIPLE CHECKBOX TYPE **********/
            case 'multiple_checkbox':
                return (new MultipleCheckbox($request, $slug, $row, $options))->handle();
            /********** FILE TYPE **********/
            case 'file':
                return (new File($request, $slug, $row, $options))->handle();
            /********** MULTIPLE IMAGES TYPE **********/
            case 'multiple_images':
                return (new MultipleImage($request, $slug, $row, $options))->handle();
            /********** SELECT MULTIPLE TYPE **********/
            case 'select_multiple':
                return (new SelectMultiple($request, $slug, $row, $options))->handle();
            /********** IMAGE TYPE **********/
            case 'image':
                return (new ContentImage($request, $slug, $row, $options))->handle();
            /********** TIMESTAMP TYPE **********/
            case 'timestamp':
                return (new Timestamp($request, $slug, $row, $options))->handle();
            /********** COORDINATES TYPE **********/
            case 'coordinates':
                return (new Coordinates($request, $slug, $row, $options))->handle();
            /********** RELATIONSHIPS TYPE **********/
            case 'relationship':
                return (new Relationship($request, $slug, $row, $options))->handle();
            /********** ALL OTHER TEXT TYPE **********/
            case 'json':
                return (new Json($request, $slug, $row, $options))->handle();
            /********** ALL OTHER TEXT TYPE **********/
            default:
                return (new Text($request, $slug, $row, $options))->handle();
        }
    }

    /**
     * Delete all images related to a BREAD item.
     *
     * @param \Illuminate\Database\Eloquent\Model $data
     * @param \Illuminate\Database\Eloquent\Model $rows
     *
     * @return void
     */
    public function deleteBreadImages($data, $rows)
    {
        foreach ($rows as $row) {
            if ($data->{$row->field} != config('voyager.user.default_avatar')) {
                $this->deleteFileIfExists($data->{$row->field});
            }

            if (isset($row->details->thumbnails)) {
                foreach ($row->details->thumbnails as $thumbnail) {
                    $ext = explode('.', $data->{$row->field});
                    $extension = '.' . $ext[count($ext) - 1];

                    $path = str_replace($extension, '', $data->{$row->field});

                    $thumb_name = $thumbnail->name;

                    $this->deleteFileIfExists($path . '-' . $thumb_name . $extension);
                }
            }
        }

        if ($rows->count() > 0) {
            event(new BreadImagesDeleted($data, $rows));
        }
    }

    /**
     * Order BREAD items.
     * @param string $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function order(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));

        if (!isset($dataType->order_column) || !isset($dataType->order_display_column)) {
            return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with([
                    'message' => __('voyager::bread.ordering_not_set'),
                    'alert-type' => 'error',
                ]);
        }

        $model = app($dataType->model_name);
        if ($model && in_array(SoftDeletes::class, class_uses($model))) {
            $model = $model->withTrashed();
        }
        $results = $model->orderBy($dataType->order_column, $dataType->order_direction)->get();

        $display_column = $dataType->order_display_column;

        $dataRow = Voyager::model('DataRow')->whereDataTypeId($dataType->id)->whereField($display_column)->first();

        $view = 'voyager::bread.order';

        if (view()->exists("voyager::$slug.order")) {
            $view = "voyager::$slug.order";
        }

        return Voyager::view($view, compact(
            'dataType',
            'display_column',
            'dataRow',
            'results'
        ));
    }

    public function update_order(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));

        $model = app($dataType->model_name);

        $order = json_decode($request->input('order'));
        $column = $dataType->order_column;
        foreach ($order as $key => $item) {
            if ($model && in_array(SoftDeletes::class, class_uses($model))) {
                $i = $model->withTrashed()->findOrFail($item->id);
            } else {
                $i = $model->findOrFail($item->id);
            }
            $i->$column = ($key + 1);
            $i->save();
        }
    }

    public function action(Request $request)
    {
        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $action = new $request->action($dataType, null);

        return $action->massAction(explode(',', $request->ids), $request->headers->get('referer'));
    }
}
