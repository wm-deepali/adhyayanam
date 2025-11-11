<style>
    .exam-paper {
        background: #fff;
        border: 1px solid #ccc;
        padding: 100px 80px;
    }

    .exam-haeding {
        text-align: center;
    }

    .exam-haeding h2 {
        color: #000;
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 40px;
    }

    .exam-haeding h3 {
        color: #000;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 30px;
    }

    .exam-haeding h4 {
        color: #000;
        font-size: 26px;
        font-weight: 600;
    }

    .time-hours {
        display: flex;
        justify-content: space-between;
    }

    .time-hours h2 {
        font-size: 24px;
        color: #000;
        font-weight: 700;
    }

    .instructions {
        padding: 30px 0;
        border-top: 1px solid #ccc;
    }

    .instructions ol {
        padding-left: 15px;
    }

    .instructions ol li {
        line-height: 24px;
        margin-bottom: 20px;
    }

    .instructions h3 {
        font-size: 24px;
        color: #000;
        font-weight: 600;
    }

    .sections {
        border-top: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
        padding: 25px 0;
        text-align: center;
    }

    .sections h2 {
        font-size: 24px;
        color: #000;
        font-weight: 700;
        margin: 0;
    }

    .intro-information {
        display: flex;
        margin-bottom: 15px;
        align-items: center;
    }

    .intro-information .col-form-label {
        margin-right: 15px;
        font-size: 24px;
        color: #333;
        font-weight: 600;
    }

    .intro-information .form-control {
        width: 200px;
        border-radius: 0;
    }

    .instruction-col {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 25px 0;
    }

    .col-bx {
        width: 55%;
    }

    .col-bx ol {
        padding-left: 15px;
    }

    .col-bx ol li {
        line-height: 24px;
        margin-bottom: 15px;
    }

    .intro-information {
        padding-top: 20px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    .colt {
        display: flex;
        justify-content: end;
        margin-bottom: 15px;
    }

    .colt .col-form-label {
        margin-right: 15px;
    }

    .colt .form-control,
    .mark {
        width: 40px;
        border-radius: 0;
        padding: 6px 10px;
        text-align: center;
    }

    .instruction-last-border {
        width: 75%;
        margin: 0 auto;
        border-bottom: 1px solid #eee;
    }

    .question-sec {
        padding: 20px 0;
    }

    .qs-col {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .qs-col.last {
        margin-bottom: 0;
    }

    .question-head {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 0;
    }

    .customradio {
        display: block;
        position: relative;
        padding-left: 30px;
        margin-bottom: 0px;
        cursor: pointer;
        font-size: 14px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        margin-bottom: 10px;
    }

    .customradio input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 18px;
        width: 18px;
        background-color: white;
        border-radius: 2%;
        border: 1px solid #BEBEBE;
    }

    .customradio:hover input~.checkmark {
        background-color: transparent;
    }

    .customradio input:checked~.checkmark {
        background-color: white;
        border: 1px solid #BEBEBE;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .customradio input:checked~.checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .customradio .checkmark:after {
        top: 0px;
        left: 0px;
        width: 17px;
        height: 17px;
        border-radius: 2%;
        background: #6F42C1;
    }

    /* Custom Radio Button End*/
    .secnd .customradio {
        width: 150px;
        margin-right: 30px;
    }

</style>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Preview</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="exam-paper">
                <div class="exam-haeding">
                    <h2>{{ $testData['name'] }}</h2>
                   
                </div>
                <div class="time-hours">
                    <h2>Time: {{ $testData['duration'] }} minutes</h2>
                    <h2 class="ml-auto">Max. Marks : {{ $testData['total_marks'] }}</h2>
                </div>
                <div class="instructions">
                    @if($testData['test_instruction'])
                    <h3>General Instructions :</h3>
                    <ol>
                        {!! $testData['test_instruction'] !!}
                    </ol>
                    @endif
                </div>
                <div style="margin-left:65%">Positive Mark @if ($testData['has_negative_marks'] == 'yes') Negative Mark @endif</div>
                
                    @php
                        if(isset($testData['non_section_details']['mcq_questions']) && !empty($testData['non_section_details']['mcq_questions']))
                        {
                            $mcqquestions = App\Models\Question::whereIn('id', $testData['non_section_details']['mcq_questions'])->where('status','Done')->where('question_type', 'MCQ')->get();
                        }
                        if(isset($testData['non_section_details']['story_questions']) && !empty($testData['non_section_details']['story_questions']))
                        {
                            $passagequestions = App\Models\Question::whereIn('id', $testData['non_section_details']['story_questions'])->where('status','Done')->where('question_type', 'Story Based')->get();
                        }
                        if(isset($testData['non_section_details']['subjective_questions']) && !empty($testData['non_section_details']['subjective_questions']))
                        {
                            $subjectivequestions = App\Models\Question::whereIn('id', $testData['non_section_details']['subjective_questions'])->where('status','Done')->where('question_type', 'Subjective')->get();
                        }
                        
                    @endphp
                    
                    @if (isset($mcqquestions) && count($mcqquestions) > 0)
                        @foreach ($mcqquestions as $question)
                            <div class="sec-instruction preview-questions-container">
                                <div class="instruction-last-border"></div>
                                <div class="question-sec">
                                    @php
    $testDetail = \App\Models\TestDetail::where('test_id', $testData['id'] ?? null)
        ->where('question_id', $question->id)
        ->first();

$test = \App\Models\Test::where('id', $testData['id'] ?? null)
        ->first();

    $default_positive = $testData['mcq_mark_per_question'] ?? '';

    $positive_mark_value = $testDetail->positive_mark ?? $default_positive;
    if (isset($test->mcq_mark_per_question) && $test->mcq_mark_per_question != $default_positive) {
        $positive_mark_value = $default_positive;
    }

   $negative_percentage = $testData['negative_marks_per_question'] ?? 0;
    $negative_mark_value = round(($positive_mark_value * $negative_percentage) / 100, 2);
@endphp

<div class="qs-col last question-container-div"
     question_id="{{ $question->id }}"
     test_question_type="MCQ">

    <div>{{ $loop->iteration }}. {!! $question->question !!}</div>

    <input type="text"
           class="form-control mark positive_mark mcq_positive_mark"
           placeholder="enter positive marks"
           value="{{ $positive_mark_value }}"
           style="width: 50px;">

    @if ($testData['has_negative_marks'] == 'yes')
        <input type="text"
               class="form-control mark negative_mark"
               placeholder="enter negative marks"
               readonly
               value="{{ $negative_mark_value }}"
               style="width: 50px;">
    @endif
</div>

                                    
                                    <label class="customradio"><span class="radiotextsty">i) {!! $question->option_a !!}</span>
                                            <input type="checkbox" name="checkbox" disabled>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="customradio"><span class="radiotextsty">ii) {!! $question->option_b !!}</span>
                                            <input type="checkbox" name="checkbox" disabled>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="customradio"><span class="radiotextsty">iii) {!! $question->option_c !!}</span>
                                            <input type="checkbox" name="checkbox" disabled>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="customradio"><span class="radiotextsty">iv) {!! $question->option_d !!}</span>
                                            <input type="checkbox" name="checkbox" disabled>
                                            <span class="checkmark"></span>
                                        </label>
                                        @if ($question->option_e != '')
                                            <label class="customradio"><span class="radiotextsty">iv) {!! $question->option_e !!}</span>
                                                <input type="checkbox" name="checkbox" disabled>
                                                <span class="checkmark"></span>
                                            </label>
                                        @endif
                                   
                                </div>
                            </div>
                        @endforeach
                    @endif
 
                    @if (isset($subjectivequestions) && count($subjectivequestions) > 0)
                        @foreach ($subjectivequestions as $question)
                         @php
    $testDetail = \App\Models\TestDetail::where('test_id', $testData['id'] ?? null)
        ->where('question_id', $question->id)
        ->first();

    $test = \App\Models\Test::where('id', $testData['id'] ?? null)
        ->first();

    $default_positive = $testData['subjective_mark_per_question'] ?? '';
    $positive_mark_value = $testDetail->positive_mark ?? $default_positive;
    if (isset($test->subjective_mark_per_question) && $test->subjective_mark_per_question != $default_positive) {
        $positive_mark_value = $default_positive;
    }

    $negative_percentage = $testData['negative_marks_per_question'] ?? 0;
    $negative_mark_value = round(($positive_mark_value * $negative_percentage) / 100, 2);

@endphp

                            <div class="sec-instruction preview-questions-container">
                                <div class="instruction-last-border"></div>
                                <div class="question-sec">
                                    <div class="qs-col last question-container-div" question_id='{{ $question->id }}' test_question_type="Subjective">

                                            <div>{{ $loop->iteration }}. {!! $question->question !!}</div>
                                        
                                        <input type="text" class="form-control mark positive_mark subjective_positive_mark" placeholder="enter positive marks" value="{{ $positive_mark_value  }}" style="width: 50px;">
                                        @if ($testData['has_negative_marks'] == 'yes')
                                            <input type="text" class="form-control mark negative_mark"  placeholder="enter negative marks"  readonly value="{{ $negative_mark_value }}" style="width: 50px;">
                                        @endif
                                    </div>
                                    @if ($question->answer_format != '')
                                    <label class="customradio"><span class="radiotextsty">i) {{$question->answer_format}}</span>
                                    @endif   
                                    @if ($question->image != '')
                                    <label class="customradio"><span class="radiotextsty">i) <img src=""></span>
                                    @endif     
                                   
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if (isset($passagequestions) && count($passagequestions) > 0)
                   
                        @foreach ($passagequestions as $question)
                         @php
    $testDetail = \App\Models\TestDetail::where('test_id', $testData['id'] ?? null)
        ->where('question_id', $question->id)
        ->first();

$test = \App\Models\Test::where('id', $testData['id'] ?? null)
        ->first();

    $default_positive = $testData['story_mark_per_question'] ?? '';
    $positive_mark_value = $testDetail->positive_mark ?? $default_positive;
    if (isset($test->story_mark_per_question) && $test->story_mark_per_question != $default_positive ) {
        $positive_mark_value = $default_positive;
    }

 $negative_percentage = $testData['negative_marks_per_question'] ?? 0;
    $negative_mark_value = round(($positive_mark_value * $negative_percentage) / 100, 2);
@endphp

                            <div class="sec-instruction preview-questions-container">
                                <div class="instruction-last-border"></div>
                                <div class="question-sec">
                                    <div class="qs-col last question-container-div" question_id='{{ $question->id }}' test_question_type="Passage">

                                            <div>{{ $loop->iteration }}. {!! $question->question !!}</div>
                                        
                                        <input type="text" class="form-control mark positive_mark passage_positive_mark" placeholder="enter positive marks" value="{{ $positive_mark_value }}" style="width: 50px;">
                                        @if ($testData['has_negative_marks'] == 'yes')
                                            <input type="text" class="form-control mark negative_mark"  placeholder="enter negative marks"  readonly value="{{ $negative_mark_value }}" style="width: 50px;">
                                        @endif
                                    </div>
                                    @if ($question->image != '')
                                    <label class="customradio"><span class="radiotextsty">i) <img src=""></span>
                                    @endif    
                                    
                                    
                                        @php
                                        $questionDetails = App\Models\QuestionDetail::where('question_id', $question->id)->get();
                                        
                                        @endphp
                                        @if (isset($questionDetails) && count($questionDetails) > 0)
                                            @foreach ($questionDetails as $questiondetail)
                                                <div class="sec-instruction preview-questions-container">
                                                    <div class="instruction-last-border"></div>
                                                    <div class="question-sec">
                                                        <div class="qs-col last question-container-div" sub_question_id='{{ $questiondetail->id }}' test_question_type="Sub Passage">

                                                                <div>{{ $loop->iteration }}. {!! $questiondetail->question !!}</div>
                                                            
                                                           @php
    // Fetch existing test detail for sub-question if editing
    $subTestDetail = \App\Models\TestDetail::where('test_id', $testData['id'] ?? null)
        ->where('question_id', $questiondetail->id)
        ->first();

        $test = \App\Models\Test::where('id', $testData['id'] ?? null)
        ->first();

 $default_positive = $testData['story_mark_per_question'] ?? '';
    
    $sub_positive_mark = $subTestDetail->positive_mark ??  round($testData['story_mark_per_question'] / count($questionDetails), 2);;
    if (isset($test->story_mark_per_question) && $test->story_mark_per_question != $default_positive) {
        $sub_positive_mark = round($testData['story_mark_per_question'] / count($questionDetails), 2);
    }

     $negative_percentage = $testData['negative_marks_per_question'] ?? 0;
    $sub_negative_mark = round(($sub_positive_mark * $negative_percentage) / 100, 2);
@endphp

<input type="text"
       class="form-control mark sub_positive_mark"
       placeholder="enter sub_positive marks"
       value="{{ $sub_positive_mark }}"
       style="width: 50px;">

@if ($testData['has_negative_marks'] == 'yes')
    <input type="text"
           class="form-control mark sub_negative_mark"
           placeholder="enter sub_negative marks"
            readonly
           value="{{ $sub_negative_mark }}"
           style="width: 50px;">
@endif

                                                        </div>
                                                        @if ($questiondetail->option_a != '')
                                                            <label class="customradio"><span class="radiotextsty">i) {!! $questiondetail->option_a !!}</span>
                                                                <input type="checkbox" name="checkbox" disabled>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        @endif
                                                        @if ($questiondetail->option_b != '')
                                                            <label class="customradio"><span class="radiotextsty">ii) {!! $questiondetail->option_b !!}</span>
                                                                <input type="checkbox" name="checkbox" disabled>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        @endif
                                                        @if ($questiondetail->option_c != '')
                                                            <label class="customradio"><span class="radiotextsty">iii) {!! $questiondetail->option_c !!}</span>
                                                                <input type="checkbox" name="checkbox" disabled>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        @endif
                                                        @if ($questiondetail->option_d != '')
                                                            <label class="customradio"><span class="radiotextsty">iv) {!! $questiondetail->option_d !!}</span>
                                                                <input type="checkbox" name="checkbox" disabled>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        @endif
                                                            @if ($questiondetail->option_e != '')
                                                                <label class="customradio"><span class="radiotextsty">iv) {!! $questiondetail->option_e !!}</span>
                                                                    <input type="checkbox" name="checkbox" disabled>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            @endif
                                                             @if (strip_tags($questiondetail->answer_format) != '')
                                            <label class="customradio">{{$question->answer_format}}</label>
                                        @endif   
                                                    
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    
                                     
                                     
                                   
                                </div>
                            </div>
                        @endforeach
                    @endif
                
                
            </div>
        </div>
        <div class="modal-footer">
            <div class="text-success" id="total-marks">
            </div>
            <div class="text-danger" id="marks_related-err">
            </div>
            <button type="button" class="btn btn-secondary close1" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id='add-test-btn' filter_type='{{ $filter_type }}'>Submit</button>
        </div>
    </div>
</div>
<script>
$(document).on("click", ".close1", function () {
    $(".modal").modal('hide');
});

$(document).ready(function () {
    calculateTotalMarks();
});

// whenever any marks change
$(document).on("keyup change", ".positive_mark, .sub_positive_mark", function () {
    calculateTotalMarks();
});

function calculateTotalMarks() {
    let total_positive_marks = 0;

    // 1️⃣ handle normal positive marks (MCQ, Subjective, etc.)
    $('.positive_mark').each(function () {
        let value = parseFloat($(this).val()) || 0;
        total_positive_marks += value;
    });

    // 2️⃣ handle sub-questions under passage and prevent exceeding passage mark
    $(".question-container-div[test_question_type='Passage']").each(function () {
        let passagePositive = parseFloat($(this).find(".passage_positive_mark").val()) || 0;
        let subQuestions = $(this).closest(".question-sec").find(".sub_positive_mark");
        let subTotal = 0;

        subQuestions.each(function () {
            subTotal += parseFloat($(this).val()) || 0;
        });

        if (subTotal > passagePositive) {
            $(this).find(".passage_positive_mark").css("border", "2px solid red");
            $("#marks_related-err").html(
                `⚠️ Sub-question marks (${subTotal}) exceed total passage mark (${passagePositive}).`
            ).show();
            $("#add-test-btn").prop("disabled", true);
        } else {
            $(this).find(".passage_positive_mark").css("border", "");
            $("#marks_related-err").html("").hide();
            $("#add-test-btn").prop("disabled", false);
        }
    });

    // 3️⃣ Show total test marks
    $("#total-marks").html("Total Marks: " + total_positive_marks.toFixed(2));

    // 4️⃣ Compare with required total marks
    const required_total = parseFloat("{{ $testData['total_marks'] }}");
    const diff = parseFloat((total_positive_marks - required_total).toFixed(2));

    if (diff !== 0) {
        let msg =
            diff > 0
                ? `⚠️ You exceeded total marks by ${diff}.`
                : `⚠️ You are short of total marks by ${Math.abs(diff)}.`;
        $("#marks_related-err").html(msg).show();
        $("#add-test-btn").prop("disabled", true);
    } else {
        if ($("#marks_related-err").html() === "") {
            $("#marks_related-err").hide();
        }
        $("#add-test-btn").prop("disabled", false);
    }
}
</script>
