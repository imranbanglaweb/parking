<input  type="text"  data-name="{{ $row->display_name }}"  class="form-control timepicker" name="{{ $row->field }}" id="{{ $row->field }}"
       placeholder="{{ old($row->field, $options->placeholder ?? $row->display_name) }}"
       {!! isBreadSlugAutoGenerator($options) !!}
       @if($dataTypeContent->{$row->field})
              value="{{ \Carbon\Carbon::parse(old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? ''))->format('H:i:s') }}"
       @else
               value="{{old($row->field)}}"
       @endif
>
