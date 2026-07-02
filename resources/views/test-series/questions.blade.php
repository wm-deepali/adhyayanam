@if(isset($question) && !empty($question))
    @php
        $qindex = $index;
        $questionText = \App\Helpers\Helper::cleanFontStyle($question->question ?? '');
        $optionA = \App\Helpers\Helper::cleanFontStyle($question->option_a ?? '');
        $optionB = \App\Helpers\Helper::cleanFontStyle($question->option_b ?? '');
        $optionC = \App\Helpers\Helper::cleanFontStyle($question->option_c ?? '');
        $optionD = \App\Helpers\Helper::cleanFontStyle($question->option_d ?? '');
        $optionE = \App\Helpers\Helper::cleanFontStyle($question->option_e ?? '');
        $answerText = \App\Helpers\Helper::cleanFontStyle($question->answer ?? '');
        $answerFormat = \App\Helpers\Helper::cleanFontStyle($question->answer_format ?? '');
    @endphp

    <div class="col-md-12" style="display:ruby;">
        {!! 'Q' . $qindex . ' ' . $questionText !!}

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
            <p><strong>A)</strong> {!! $optionA !!}</p>
        </div>
        <div class="col-md-12">
            <p><strong>B)</strong> {!! $optionB !!}</p>
        </div>
        <div class="col-md-12">
            <p><strong>C)</strong> {!! $optionC !!}</p>
        </div>
        <div class="col-md-12">
            <p><strong>D)</strong> {!! $optionD !!}</p>
        </div>
        @if(strip_tags($optionE) != "")
            <div class="col-md-12">
                <p><strong>E)</strong> {!! $optionE !!}</p>
            </div>
        @endif
        <div class="col-md-12">
            <p><strong>Answer: </strong> {!! $answerText !!}</p>
        </div>
    @endif

    {{-- ✅ Subjective Type --}}
    @if($question->question_type == 'Subjective')
        @if(strip_tags($answerFormat) != "")
            <div class="col-md-12">
                <p><strong>Answer Format:</strong> {!! $answerFormat !!}</p>
            </div>
        @endif
    @endif
@endif