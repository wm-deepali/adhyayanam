@if (isset($testpapers) && count($testpapers)>0)
    @foreach($testpapers as $data)
        <li id="customquestionli">
            <label>
                <span class="questn-he">
                    <input type="checkbox" name="question[]" class="question" value="{!! $data->id !!}">
                    <span class="question-text">{!! $data->name !!}</span>
                </span>
                
            </label>
        </li>
    @endforeach
@endif