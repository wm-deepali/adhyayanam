@if(isset($question) && !empty($question))
    @php
        $qindex = $index;
    @endphp

    <div class="col-md-12" style="display:ruby;">
        {!! 'Q' . $qindex . ' ' . $question->question ?? "" !!}

        {{-- ✅ Show both Positive & Negative Marks --}}
        <span class="text-right">
            <strong>
                (Marks: {{ $marks }}
                @if(isset($negative_marks) && $negative_marks > 0)
                    | Negative: {{ $negative_marks }}
                @endif)
            </strong>
        </span>
    </div>

    {{-- ✅ MCQ Type --}}
    @if($question->question_type == 'MCQ')
        <div class="col-md-12">
            <p><strong>A)</strong> {!! $question->option_a ?? "" !!}</p>
        </div>
        <div class="col-md-12">
            <p><strong>B)</strong> {!! $question->option_b ?? "" !!}</p>
        </div>
        <div class="col-md-12">
            <p><strong>C)</strong> {!! $question->option_c ?? "" !!}</p>
        </div>
        <div class="col-md-12">
            <p><strong>D)</strong> {!! $question->option_d ?? "" !!}</p>
        </div>
        @if(strip_tags($question->option_e) != "")
            <div class="col-md-12">
                <p><strong>E)</strong> {!! $question->option_e ?? "" !!}</p>
            </div>
        @endif
        <div class="col-md-12">
            <p><strong>Answer: </strong> {!! $question->answer ?? "" !!}</p>
        </div>
    @endif

    {{-- ✅ Subjective Type --}}
    @if($question->question_type == 'Subjective')
        @if(strip_tags($question->answer_format) != "")
            <div class="col-md-12">
                <p><strong>Answer Format:</strong> {!! $question->answer_format ?? "" !!}</p>
            </div>
        @endif
    @endif
@endif