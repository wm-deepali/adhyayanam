<option value="">Select Exam Category</option>
@if (isset($exam_categories) && count($exam_categories)>0)
    @foreach($exam_categories as $exam_category)
        <option value='{{ $exam_category->id }}'>{{ $exam_category->name }}</option>
        
    @endforeach
@endif