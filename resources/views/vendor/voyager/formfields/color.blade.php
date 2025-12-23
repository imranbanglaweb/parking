@php
    $defaultColor = "#000000";
   if(isset($row->details) && isset($row->details->default)){
       $defaultColor = $row->details->default;
   }
@endphp
<input type="color" class="form-control" name="{{ $row->field }}" id="{{ $row->field }}"
       value="{{ old($row->field, $dataTypeContent->{$row->field} ? $dataTypeContent->{$row->field}: $defaultColor) }}">
