<option value="">--Select One--</option>
@foreach($tenants as $tenant)
<option @if($tenant_id==$tenant->id)selected @endif value="{{ $tenant->id}}">
    {{ $tenant->name}}
</option>
@endforeach