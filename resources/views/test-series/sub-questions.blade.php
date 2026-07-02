@if(isset($question) && !empty($question))
    @php
        $questionText = \App\Helpers\Helper::cleanFontStyle($question->question ?? '');
        $optionA = \App\Helpers\Helper::cleanFontStyle($question->option_a ?? '');
        $optionB = \App\Helpers\Helper::cleanFontStyle($question->option_b ?? '');
        $optionC = \App\Helpers\Helper::cleanFontStyle($question->option_c ?? '');
        $optionD = \App\Helpers\Helper::cleanFontStyle($question->option_d ?? '');
        $optionE = \App\Helpers\Helper::cleanFontStyle($question->option_e ?? '');
        $answerText = \App\Helpers\Helper::cleanFontStyle($question->answer ?? '');
        $answerFormat = \App\Helpers\Helper::cleanFontStyle($question->answer_format ?? '');
    @endphp

    <div class="col-md-12" style="display:flex; justify-content:space-between; align-items:center;">
        <div>
            {!! 'Q' . $parentIndex . ' (' . $index . ') ' . $questionText !!}
        </div>

        {{-- ✅ Show Positive + Negative Marks --}}
        <div class="text-right">
            <strong>
                (Marks: {{ $marks }}
                @if(isset($negative_marks) && $negative_marks > 0)
                    | Negative: {{ $negative_marks }}
                @endif)
            </strong>
        </div>
    </div>

    {{-- ✅ Options --}}
    @if(strip_tags($optionA) != "")
        <div class="col-md-12"><p><strong>A)</strong> {!! $optionA !!}</p></div>
    @endif
    @if(strip_tags($optionB) != "")
        <div class="col-md-12"><p><strong>B)</strong> {!! $optionB !!}</p></div>
    @endif
    @if(strip_tags($optionC) != "")
        <div class="col-md-12"><p><strong>C)</strong> {!! $optionC !!}</p></div>
    @endif
    @if(strip_tags($optionD) != "")
        <div class="col-md-12"><p><strong>D)</strong> {!! $optionD !!}</p></div>
    @endif
    @if(strip_tags($optionE) != "")
        <div class="col-md-12"><p><strong>E)</strong> {!! $optionE !!}</p></div>
    @endif

    {{-- ✅ Answer --}}
    @if(strip_tags($answerText) != "")
        <div class="col-md-12">
            <p><strong>Answer:</strong> {!! $answerText !!}</p>
        </div>
    @endif

    {{-- ✅ Subjective Answer Format --}}
    @if(strip_tags($answerFormat) != "")
        <div class="col-md-12">
            <p><strong>Answer Format:</strong> {!! strip_tags($answerFormat) !!}</p>
        </div>
    @endif
@endif