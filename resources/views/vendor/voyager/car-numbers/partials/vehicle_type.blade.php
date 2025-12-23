<option value="">--Select One--</option>
@foreach($vehicle_types as $vehicle_type)
<option @if($vehicle_type_id==$vehicle_type->id) selected @endif  value="{{ $vehicle_type->id}}">
    {{ $vehicle_type->name}}
</option>
@endforeach