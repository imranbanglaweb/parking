<input type="text" class="form-control datetimepicker" name="{{ $row->field }}" id="{{ $row->field }}"
       value="@if(isset($dataTypeContent->{$row->field})){{ \Carbon\Carbon::parse(old($row->field, $dataTypeContent->{$row->field}))->format('Y-m-d H:i:s') }}@else{{old($row->field)}}@endif">
