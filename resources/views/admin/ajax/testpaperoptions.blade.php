@if(isset($testpapers) && count($testpapers) > 0)
    @foreach($testpapers as $data)
        <li id="customquestionli">
            <label>
                <span class="questn-he">
                    <input type="checkbox"
                           name="question[]"
                           class="question"
                           value="{{ $data->id }}">

                    <span class="question-text">
                        {{ $data->name }}

                        <small class="text-muted d-block">
                            @if($data->subject)
                                Subject: {{ $data->subject->name }}
                            @endif

                            @if($data->chapter)
                                | Chapter: {{ $data->chapter->name }}
                            @endif

                            @if($data->topic)
                                | Topic: {{ $data->topic->name }}
                            @endif
                        </small>
                    </span>
                </span>
            </label>
        </li>
    @endforeach
@endif
