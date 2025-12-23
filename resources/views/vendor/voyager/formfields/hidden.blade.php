<input type="hidden" class="form-control" name="{{ $row->field }}" id="{{ $row->field }}"
       placeholder="{{ $row->display_name }}"
       {!! isBreadSlugAutoGenerator($options) !!}
       value="{{ old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? '') }}">
