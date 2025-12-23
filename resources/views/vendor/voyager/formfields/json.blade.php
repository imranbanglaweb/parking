<div class="alert alert-danger validation-error">
    {{ __('voyager::json.invalid') }}
</div>
<textarea  id="{{ $row->field }}" class="resizable-editor" data-editor="json" name="{{ $row->field }}">{{   json_encode(old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? '{}'))  }}</textarea>

