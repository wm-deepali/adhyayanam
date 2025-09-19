
@if (isset($sub_categories) && count($sub_categories)>0)
<option value="">Select Sub Category</option>
    @foreach($sub_categories as $sub_category)
        <option value="{{ $sub_category->id }}">{{ $sub_category->name }}</option>
    @endforeach
@endif