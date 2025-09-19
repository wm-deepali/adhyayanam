<option value="">Select Topic</option>
@if (isset($topics) && count($topics)>0)
    @foreach($topics as $topic)
        <option value='{{ $topic->id }}'>{{ $topic->name }}</option>
        
    @endforeach
@endif