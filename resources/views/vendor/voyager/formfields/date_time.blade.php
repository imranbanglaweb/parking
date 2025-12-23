<input type="text" class="form-control bootstrap-datetimepicker" id="{{ $row->field }}" data-toggle="datetimepicker" data-target="#{{ $row->field }}"
       placeholder="{{ $row->display_name }}"
       name="{{ $row->field }}"
       value="@if(isset($dataTypeContent->{$row->field})){{
            \Carbon\Carbon::parse(old($row->field, $dataTypeContent->{$row->field}))->format('Y-m-d H:i:s') }}
       @else
       {{old($row->field)}}
       @endif"
/>
