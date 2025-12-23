<input type="text" class="form-control datepicker" name="{{ $row->field }}" id="{{ $row->field }}"
       placeholder="{{ $row->display_name }}"
       value="@if(isset($dataTypeContent->{$row->field})){{ \Carbon\Carbon::parse(old($row->field, $dataTypeContent->{$row->field}))->format('Y-m-d') }}@else{{old($row->field)}}@endif">
