@if (isset($subjects) && count($subjects)>0)
    @foreach($subjects as $subject)
        <option value='{{ $subject->id }}'>{{ $subject->name }}</option>
        
    @endforeach
@endif