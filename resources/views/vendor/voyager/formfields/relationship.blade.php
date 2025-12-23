@if(isset($options->model) && isset($options->type))

    @if(class_exists($options->model))

        @php $relationshipField = $row->field; @endphp

            @if($options->type == 'belongsTo')

            @if(isset($view) && ($view == 'browse' || $view == 'read'))

                @php
                    $relationshipData = (isset($data)) ? $data : $dataTypeContent;
                    $model = app($options->model);
                    $query = $model::where($options->key, old($options->column, $relationshipData->{$options->column}))->first();
                @endphp
{{--                <span>{{$options->model}} {{  $options->column }} {{$options->key}}</span>--}}
                @if(isset($query))
                    <p>{{ $query->{$options->label} }}</p>
                @else
                    <p>{{ __('voyager::generic.no_results') }} </p>
                @endif

            @else

                <?php $label = $options->label; $dependsOn = null; $dependentFields = null; $additionalQuery = null; $searchFields = null; $additionalLabels = null; ?>
                <?php if(!empty($additional_options) && isset($additional_options->additional_query) && (is_array($additional_options->additional_query) || is_object($additional_options->additional_query) )): ?>
                    <?php $additionalQuery = json_encode($additional_options->additional_query); ?>
                <?php endif; ?>
                <?php if(!empty($additional_options) && isset($additional_options->depend_on) && (is_array($additional_options->depend_on) || is_object($additional_options->depend_on) )): ?>
                    <?php $dependsOn = json_encode($additional_options->depend_on); ?>
                <?php endif; ?>
                <?php if(!empty($additional_options) && isset($additional_options->dependent_fields) && is_array($additional_options->dependent_fields)): ?>
                    <?php $dependentFields = json_encode($additional_options->dependent_fields); ?>
                <?php endif; ?>
                <?php if(!empty($additional_options) && isset($additional_options->label)): ?>
                    <?php $label = $additional_options->label; ?>
                <?php endif; ?>
                <select
                    id="{{ $options->column }}"
                    data-placeholder="{{ !empty($additional_options) && isset($additional_options->placeholder) ? __($additional_options->placeholder) : __('voyager::generic.none')}}"
                    class="form-control select2-ajax" name="{{ $options->column }}"
                    data-get-items-route="{{route('voyager.' . $dataType->slug.'.relation')}}"
                    data-get-items-field="{{$row->field}}"
                    data-method="{{ isset($dataTypeContent) ? 'edit' : 'add' }}"
                   <?php if(!empty($dependsOn)): ?>  data-depend-on="{{$dependsOn}}" <?php endif; ?>
                   <?php if(!empty($dependentFields)): ?>  data-dependent-fields="{{$dependentFields}}" <?php endif; ?>
                   <?php if(!empty($additionalQuery)): ?>  data-additional-queries="{{$additionalQuery}}" <?php endif; ?>
                >
                    @php
                        $selectedValue = old($options->column, $dataTypeContent->{$options->column});
                        $model = app($options->model);

                        $query = $model::where($options->key, $selectedValue)->get();

                    @endphp
                        <option value="">{{__('voyager::generic.none')}}</option>

                    @foreach($query as $relationshipData)
                        <option value="{{ $relationshipData->{$options->key} }}" @if( $selectedValue == $relationshipData->{$options->key}){{ 'selected' }}@endif>{{ $relationshipData->{$label} }}</option>
                    @endforeach
                </select>

            @endif

        @elseif($options->type == 'hasOne')

            @php

                $relationshipData = (isset($data)) ? $data : $dataTypeContent;

                $model = app($options->model);
                $query = $model::where($options->column, '=', $relationshipData->id)->first();

            @endphp

            @if(isset($query))
                <p>{{ $query->{$options->label} }}</p>
            @else
                <p>{{ __('voyager::generic.no_results') }}</p>
            @endif

        @elseif($options->type == 'hasMany')

            @if(isset($view) && ($view == 'browse' || $view == 'read'))

                @php
                    $relationshipData = (isset($data)) ? $data : $dataTypeContent;
                    $model = app($options->model);

            		$selected_values = $model::where($options->column, '=', $relationshipData->id)->get()->map(function ($item, $key) use ($options) {
            			return $item->{$options->label};
            		})->all();
                @endphp

                @if($view == 'browse')
                    @php
                        $string_values = implode(", ", $selected_values);
                        if(mb_strlen($string_values) > 25){ $string_values = mb_substr($string_values, 0, 25) . '...'; }
                    @endphp
                    @if(empty($selected_values))
                        <p>{{ __('voyager::generic.no_results') }}</p>
                    @else
                        <p>{{ $string_values }}</p>
                    @endif
                @else
                    @if(empty($selected_values))
                        <p>{{ __('voyager::generic.no_results') }}</p>
                    @else
                        <ul>
                            @foreach($selected_values as $selected_value)
                                <li>{{ $selected_value }}</li>
                            @endforeach
                        </ul>
                    @endif
                @endif

            @else

                @php
                    $model = app($options->model);
                    $query = $model::where($options->column, '=', $dataTypeContent->id)->get();
                @endphp

                @if(isset($query))
                    <ul>
                        @foreach($query as $query_res)
                            <li>{{ $query_res->{$options->label} }}</li>
                        @endforeach
                    </ul>

                @else
                    <p>{{ __('voyager::generic.no_results') }}</p>
                @endif

            @endif

        @elseif($options->type == 'belongsToMany')

            @if(isset($view) && ($view == 'browse' || $view == 'read'))

                @php
                    $relationshipData = (isset($data)) ? $data : $dataTypeContent;

                    $selected_values = isset($relationshipData) ? $relationshipData->belongsToMany($options->model, $options->pivot_table)->get()->map(function ($item, $key) use ($options) {
            			return $item->{$options->label};
            		})->all() : array();
                @endphp

                @if($view == 'browse')
                    @php
                        $string_values = implode(", ", $selected_values);
                        if(mb_strlen($string_values) > 25){ $string_values = mb_substr($string_values, 0, 25) . '...'; }
                    @endphp
                    @if(empty($selected_values))
                        <p>{{ __('voyager::generic.no_results') }}</p>
                    @else
                        <p>{{ $string_values }}</p>
                    @endif
                @else
                    @if(empty($selected_values))
                        <p>{{ __('voyager::generic.no_results') }}</p>
                    @else
                        <ul>
                            @foreach($selected_values as $selected_value)
                                <li>{{ $selected_value }}</li>
                            @endforeach
                        </ul>
                    @endif
                @endif

            @else
                <?php
                       $dependsOn = null;  $additionalQuery = null;   ?>
                <?php if(!empty($additional_options) && isset($additional_options->additional_query) && (is_array($additional_options->additional_query) || is_object($additional_options->additional_query) )): ?>
                    <?php $additionalQuery = json_encode($additional_options->additional_query); ?>
                <?php endif; ?>
                <?php if(!empty($additional_options) && isset($additional_options->depend_on) && (is_array($additional_options->depend_on) || is_object($additional_options->depend_on) )): ?>
                    <?php $dependsOn = json_encode($additional_options->depend_on); ?>
                <?php endif; ?>

                <select
                    class="form-control @if(isset($options->taggable) && $options->taggable == 'on') select2-taggable @else select2-ajax @endif"
                    id="{{ $relationshipField }}"
                    name="{{ $relationshipField }}[]" multiple
                    data-get-items-route="{{route('voyager.' . $dataType->slug.'.relation')}}"
                    data-get-items-field="{{$row->field}}"

                    <?php if(!empty($dependsOn)): ?>  data-depend-on="{{$dependsOn}}" <?php endif; ?>
                    <?php if(!empty($additionalQuery)): ?>  data-additional-queries="{{$additionalQuery}}" <?php endif; ?>

                    @if(isset($options->taggable) && $options->taggable == 'on')
                        data-route="{{ route('voyager.'.\Illuminate\Support\Str::slug($options->table).'.store') }}"
                        data-label="{{$options->label}}"
                        data-error-message="{{__('voyager::bread.error_tagging')}}"
                    @endif
                >

                        @php
                            if(old($relationshipField)){
                                $selected_values = old($relationshipField);
                            } else {
                             $selected_values = isset($dataTypeContent) ? $dataTypeContent->belongsToMany($options->model, $options->pivot_table)->get()->map(function ($item, $key) use ($options) {
                                return $item->{$options->key};
                                })->all() : array();
                            }

                            $relationshipOptions = app($options->model)->select($options->key, $options->label)->get();
                        @endphp

                        @if(!$row->required)
                            <option value="">{{__('voyager::generic.none')}}</option>
                        @endif

                        @foreach($relationshipOptions as $relationshipOption)
                            <option value="{{ $relationshipOption->{$options->key} }}" @if(in_array($relationshipOption->{$options->key}, $selected_values)){{ 'selected="selected"' }}@endif>{{ $relationshipOption->{$options->label} }}</option>
                        @endforeach

                </select>

            @endif

        @endif

    @else

        cannot make relationship because {{ $options->model }} does not exist.

    @endif

@endif
