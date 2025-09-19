@if (isset($questions) && count($questions)>0)
    @foreach($questions as $data)
        <li id="customquestionli">
            <label>
                <span class="questn-he">
                    <input type="checkbox" name="question[]" class="question" value="{!! $data->id !!}">
                    <span class="question-text">{!! $data->question !!}</span>
                </span>
                
            </label>
        </li>
    @endforeach
@endif
