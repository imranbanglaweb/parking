# Data Fetching Api

**For Select Option**
###### If any drop-down is dependent on another drop-down Or you want to generate drop-down options dynamically then:
```html
<select class="form-control select2-ajax-custom" name="department_id"
    id="department_id"
    data-url="{{route('api.index')}}"
    data-model="{{App\Models\Model::class}}"
    data-label="name"
    data-placeholder="{{__("voyager::generic.none")}}"
>
<option>Select</option>
</select>
```
```html
<select class="form-control select2-ajax-custom" 
    name="department_id"
    id="department_id"
    data-url="{{route('api.index')}}"
    data-model="{{App\Models\Model::class}}"
    data-label="name"
    data-depend-on="{{json_encode(['company_id', 'branch_id'])}}"
    data-placeholder="{{__("voyager::generic.none")}}"
>
<option>Select</option>
</select>
```
```html
<select class="form-control select2-ajax-custom" 
    name="department_id"
    id="department_id"
    data-url="{{route('api.index')}}"
    data-model="{{App\Models\Model::class}}"
    data-label="name"
    data-depend-on="{{json_encode(['m_company_id' => 'company_id', 'm_branch_id' => 'branch_id'])}}"
    data-placeholder="{{__("voyager::generic.none")}}"
>
<option>Select</option>
</select>
```
```html
<select class="form-control select2-ajax-custom" 
    name="department_id"
    id="department_id"
    data-url="{{route('api.index')}}"
    data-model="{{App\Models\Model::class}}"
    data-label="name"
    data-depend-on="{{json_encode(['m_company_id' => 'company_id', 'm_branch_id' => 'branch_id'])}}"
    data-additional-queries="{{json_encode(['status' => 1])}}"
    data-additional-labels="{{json_encode(['status', 'name'])}}"
    data-search-fields="{{json_encode(['name','address'])}}"
    data-placeholder="{{__("voyager::generic.none")}}"
>
<option>Select</option>
</select>
```
