<?php $dependentFields = isset($options->dependent_fields) && is_array($options->dependent_fields) && !empty($options->dependent_fields) ? $options->dependent_fields: []; ?>
@if(isset($options->relationship))

    {{-- If this is a relationship and the method does not exist, show a warning message --}}
    @if(isset($options->relationship->relation_method) && !method_exists( $dataType->model_name, $options->relationship->relation_method  ) )
        <p class="label label-warning">
            <i class="voyager-warning"></i> {{ __('voyager::form.field_select_dd_relationship', ['method' => $options->relationship->relation_method.'()', 'class' => $dataType->model_name]) }}
        </p>
    @elseif(!isset($options->relationship->relation_method) && !method_exists( $dataType->model_name, camel_case($row->field)  ) )
        <p class="label label-warning">
            <i class="voyager-warning"></i> {{ __('voyager::form.field_select_dd_relationship', ['method' => camel_case($row->field).'()', 'class' => $dataType->model_name]) }}
        </p>
    @endif


    <?php $relationshipMethod = isset($options->relationship->relation_method) ? $options->relationship->relation_method : camel_case($row->field); ?>
    @if( method_exists( $dataType->model_name, $relationshipMethod ) )
        @if(isset($dataTypeContent->{$row->field}) && !is_null(old($row->field, $dataTypeContent->{$row->field})))
            <?php $selected_value = old($row->field, $dataTypeContent->{$row->field}); ?>
        @else
            <?php $selected_value = old($row->field); ?>
        @endif


        <select class="form-control select2" name="{{ $row->field }}" id="{{ $row->field }}" @if(!empty($dependentFields)) data-dependent-fields="{{json_encode($dependentFields)}}" @endif>
            <?php $default = (isset($options->default) && !isset($dataTypeContent->{$row->field})) ? $options->default : null; ?>

            @if(isset($options->options))
                <optgroup label="{{ __('voyager::generic.custom') }}">
                    @foreach($options->options as $key => $option)
                        <option value="{{ ($key == '_empty_' ? '' : $key) }}" @if($default == $key && $selected_value === NULL){{ 'selected="selected"' }}@endif @if((string)$selected_value == (string)$key){{ 'selected="selected"' }}@endif>{{ $option }}</option>
                    @endforeach
                </optgroup>
            @endif
            {{-- Populate all options from relationship --}}
            <?php
            $relationshipListMethod = camel_case($row->field) . 'List';
            if (method_exists($dataTypeContent, $relationshipListMethod)) {
                $relationshipOptions = $dataTypeContent->$relationshipListMethod();
            } else {
                $relationshipClass = $dataTypeContent->{$relationshipMethod}()->getRelated();

                /** @var \Illuminate\Database\Query\Builder $relationshipOptionsQuery */
                if (isset($options->relationship->key) && isset($options->relationship->label)) {
                    $relationshipOptionsQuery = $relationshipClass::select($options->relationship->key, $options->relationship->label);
                } else {
                    $relationshipOptionsQuery = $relationshipClass::select('id', 'title');
                }

                if (isset($options->relationship->where)) {
                    $relationshipOptions = $relationshipOptionsQuery->where(
                        $options->relationship->where[0],
                        $options->relationship->where[1]
                    )->get();
                } else {
                    $relationshipOptions = $relationshipOptionsQuery->get();
                }
            }

            /** Try to get default value for the relationship
            when default is a callable function (ClassName@methodName) **/
            if ($default != null) {
                $comps = explode('@', $default);
                if (count($comps) == 2 && method_exists($comps[0], $comps[1])) {
                    $default = call_user_func([$comps[0], $comps[1]]);
                }
            }
            ?>

            <optgroup label="{{ __('voyager::database.relationship.relationship') }}">
                @foreach($relationshipOptions as $relationshipOption)
                    <?php if(isset($options->relationship->key) && isset($relationshipOption->{$options->relationship->key}) && isset($options->relationship->label)): ?>
                    <option value="{{ $relationshipOption->{$options->relationship->key} }}" @if($default == $relationshipOption->{$options->relationship->key} && $selected_value === NULL){{ 'selected="selected"' }}@endif @if($selected_value == $relationshipOption->{$options->relationship->key}){{ 'selected="selected"' }}@endif>{{ $relationshipOption->{$options->relationship->label} }}</option>
                    <?php else: ?>
                        <option value="{{ $relationshipOption->{"id"} }}" @if($default == $relationshipOption->{"id"} && $selected_value === NULL){{ 'selected="selected"' }}@endif @if($selected_value == $relationshipOption->{"id"}){{ 'selected="selected"' }}@endif>{{ $relationshipOption->{"title"} }}</option>
                    <?php endif; ?>
                @endforeach
            </optgroup>
        </select>
    @else
        <select class="form-control select2" name="{{ $row->field }}" id="{{ $row->field }}"></select>
    @endif
@else
    <?php $selected_value = (isset($dataTypeContent->{$row->field}) && !is_null(old($row->field, $dataTypeContent->{$row->field}))) ? old($row->field, $dataTypeContent->{$row->field}) : old($row->field); ?>
    <select class="form-control select2" name="{{ $row->field }}" id="{{ $row->field }}"
            @if(!empty($dependentFields)) data-dependent-fields="{{json_encode($dependentFields)}}" @endif
    >
        <?php $default = (isset($options->default) && !isset($dataTypeContent->{$row->field})) ? $options->default : null; ?>
        @if(isset($options->options))
            @foreach($options->options as $key => $option)
                <option value="{{ $key }}" @if($default == $key && $selected_value === NULL){{ 'selected="selected"' }}@endif @if($selected_value == $key){{ 'selected="selected"' }}@endif>{{ $option }}</option>
            @endforeach
        @endif
    </select>
@endif
