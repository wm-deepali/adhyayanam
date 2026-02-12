@extends('layouts.app')

@section('title', 'Question Bank | Edit')

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <div>
                    <h5 class="card-title">Edit Question</h5>
                    <h6 class="card-subtitle text-muted">Edit question details here</h6>
                </div>
                <a href="{{ route('question.bank.create') }}" class="btn btn-primary">+ Add</a>
            </div>

            @include('layouts.includes.messages')

            <form action="{{ route('question.bank.update', $question->id) }}" method="POST">
                @csrf

                <div class="row">
                    {{-- LEFT PANEL --}}
                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Language</label>
                                        <select class="form-control" name="language">
                                            <option @if($question->language == 1) selected @endif value="1">Hindi</option>
                                            <option @if($question->language == 2) selected @endif value="2">English</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Question Type</label>
                                        <select id="question-type" class="form-control" name="question_type" required>
                                            <option value="{{$question->question_type}}">{{$question->question_type}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Fee Type</label>
                                        <select id="fee-type" class="form-control" name="fee_type">
                                            <option value="Free" @if($question->fee_type == 'Free') selected @endif>Free
                                            </option>
                                            <option value="Paid" @if($question->fee_type == 'Paid') selected @endif>Paid
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Question Category</label>
                                        <select id="question-category" class="form-control" name="question_category">
                                            <option @if($question->question_category == 0) selected @endif value="0">Normal
                                            </option>
                                            <option @if($question->question_category == 1) selected @endif value="1">Previous
                                                Year</option>
                                            <option @if($question->question_category == 2) selected @endif value="2">Current
                                                Affair</option>
                                        </select>
                                    </div>
                                        <div class="form-group previous-year-group" id="previous-year" style="display: none;">

                                        <label>Previous Year</label>
                                        <input type="number" class="form-control" name="previous_year"
                                            placeholder="Ex. 2014">
                                    </div>
                                    <div class="form-group">
                                        <label>Select Examination Commission</label>
                                        <select class="form-control" name="commission_id" id="exam_com_id">
                                            <option value="">--Select--</option>
                                            @foreach($commissions as $commission)
                                                <option @if($question->commission_id == $commission->id) selected @endif
                                                    value="{{ $commission->id }}">{{ $commission->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Category</label>
                                        <select class="form-control" name="category_id" id="category_id">
                                            <option value="">--Select--</option>
                                            @foreach($categories as $category)
                                                <option @if($question->category_id == $category->id) selected @endif
                                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group sub-cat">
                                        <label>Sub Category</label>
                                        <select class="form-control" name="sub_category_id" id="sub_category_id">
                                            <option value="">--Select--</option>
                                            @foreach($subcategories as $subcategory)
                                                <option @if($question->sub_category_id == $subcategory->id) selected @endif
                                                    value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Select Subject</label>
                                        <select class="form-control" name="subject_id" id="subject_id">
                                            <option value="">--Select--</option>
                                            @foreach($subjects as $subject)
                                                <option @if($question->subject_id == $subject->id) selected @endif
                                                    value="{{ $subject->id }}">{{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Chapter</label>
                                        <select class="form-control" name="chapter_id" id="chapter_id">
                                            <option value="">--Select--</option>
                                            @foreach($subjects as $chapter)
                                                <option @if($question->chapter_id == $chapter->id) selected @endif
                                                    value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Topic</label>
                                        <select class="form-control" name="topic" id="topic_id">
                                            <option value="">--Select--</option>
                                            @foreach($topics as $topic)
                                                <option @if($question->topic_id == $topic->id) selected @endif
                                                    value="{{ $topic->id }}">{{ $topic->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input id="has_instruction" @if($question->has_instruction == 1) checked @endif
                                            type="checkbox" class="form-check-input has-instruction" name="has_instruction"
                                            onchange="toggleInstruction(this)">
                                        <label for="has_instruction">Has an Instruction</label>
                                    </div>
                                    <div class="form-group instruction-group" @if($question->has_instruction == 0)
                                    style="display: none;" @endif>
                                        <textarea class="form-control quill-editor"
                                            name="instruction">{!! strip_tags($question->instruction) !!}</textarea>
                                        <label>Instruction</label>
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="checkbox" class="form-check-input has-option-e"
                                            @if($question->has_option_e == 1) checked @endif name="has_option_e"
                                            onchange="toggleOptionE(this)">
                                        <label>Has option E</label>
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="checkbox" class="form-check-input has-solution"
                                            @if($question->has_solution == 'yes') checked @endif name="has_solution"
                                            onchange="toggleSolution(this)">
                                        <label>Has Solution</label>
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="checkbox" class="form-check-input" @if($question->show_on_pyq == "yes")
                                        checked @endif name="show_on_pyq" value="yes">
                                        <label for="show_on_pyq">Show on PYQ</label>
                                    </div>
                                </div>

                    {{-- RIGHT PANEL --}}
                    <div class="col-md-6">

                        {{-- ================= MCQ ================= --}}
                        @if($question->question_type === 'MCQ')

    <div class="form-group">
        <label>Question</label>
        <textarea id="q_main" class="form-control editor"
            name="question[]">{!! $question->question !!}</textarea>
    </div>

    <div class="form-group">
        <label>Correct Answer</label>
        <input type="text" class="form-control"
               name="answer[]" value="{{ $question->answer }}">
    </div>

    <div class="form-group">
        <label>Option A</label>
        <textarea class="form-control editor"
            name="option_a[]">{!! $question->option_a !!}</textarea>
    </div>

    <div class="form-group">
        <label>Option B</label>
        <textarea class="form-control editor"
            name="option_b[]">{!! $question->option_b !!}</textarea>
    </div>

    <div class="form-group">
        <label>Option C</label>
        <textarea class="form-control editor"
            name="option_c[]">{!! $question->option_c !!}</textarea>
    </div>

    <div class="form-group">
        <label>Option D</label>
        <textarea class="form-control editor"
            name="option_d[]">{!! $question->option_d !!}</textarea>
    </div>

    <div class="form-group option-e-group"
         style="{{ $question->has_option_e ? '' : 'display:none;' }}">
        <label>Option E</label>
        <textarea class="form-control editor"
            name="option_e[]">{!! $question->option_e !!}</textarea>
    </div>

    <div class="form-group solution-group"
         style="{{ $question->has_solution === 'yes' ? '' : 'display:none;' }}">
        <label>Solution</label>
        <textarea class="form-control editor"
            name="solution[]">{!! $question->solution !!}</textarea>
    </div>

                        {{-- ================= SUBJECTIVE ================= --}}
                        @elseif($question->question_type === 'Subjective')

                            <div class="form-group">
                                <label>Question</label>
                                <textarea id="subj_q" class="form-control editor"
                                    name="question[]">{!! $question->question !!}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Answer Format</label>
                                <select class="form-control" name="answer_format[]">
                                    <option value="text" @selected($question->answer_format === 'text')>Text</option>
                                    <option value="audio" @selected($question->answer_format === 'audio')>Audio</option>
                                    <option value="video" @selected($question->answer_format === 'video')>Video</option>
                                    <option value="image" @selected($question->answer_format === 'image')>Image</option>
                                    <option value="document" @selected($question->answer_format === 'document')>Document</option>
                                </select>
                            </div>

                            <div class="form-group solution-group"
     style="{{ $question->has_solution === 'yes' ? '' : 'display:none;' }}">
    <label>Solution</label>
    <textarea id="subj_sol" class="form-control editor"
        name="solution[]">{!! $question->solution !!}</textarea>
</div>


                        {{-- ================= STORY BASED ================= --}}
         {{-- ================= STORY BASED ================= --}}
@elseif($question->question_type === "Story Based")

<div id="story_question_form">

    <div class="question-count form-group">
        <h4>Question 1</h4>
    </div>

    {{-- MAIN STORY (single → id allowed) --}}
    <div class="form-group">
        <label>Enter Story / Passage</label>
        <textarea id="story_q"
                  class="form-control editor"
                  name="question[]">{!! $question->question !!}</textarea>
    </div>

    <hr>
    <h5>Sub Questions</h5>

    <div id="story-sub-questions">

        @foreach($question->questionDeatils as $detail)
        <div class="sub-question-block border p-3 mb-3">

            <input type="hidden" name="sub_question_id[]" value="{{ $detail->id }}">

            {{-- TYPE --}}
            <div class="form-group">
                <label>Sub Question Type</label>
                <select class="form-control sub-question-type"
                        name="sub_question_type[]">
                    <option value="mcq" {{ $detail->type === 'mcq' ? 'selected' : '' }}>MCQ</option>
                    <option value="reasoning" {{ $detail->type === 'reasoning' ? 'selected' : '' }}>
                        Reasoning / Subjective
                    </option>
                </select>
            </div>

            {{-- QUESTION (loop → no id) --}}
            <div class="form-group">
                <label>Question</label>
                <textarea class="form-control editor"
                          name="sub_question[]">{!! $detail->question !!}</textarea>
            </div>

            {{-- MCQ OPTIONS (loop → NO IDs) --}}
            <div class="mcq-fields" style="{{ $detail->type === 'mcq' ? '' : 'display:none;' }}">

                <div class="form-group">
                    <label>Option A</label>
                    <textarea class="form-control editor"
                              name="option_a[]">{!! $detail->option_a !!}</textarea>
                </div>

                <div class="form-group">
                    <label>Option B</label>
                    <textarea class="form-control editor"
                              name="option_b[]">{!! $detail->option_b !!}</textarea>
                </div>

                <div class="form-group">
                    <label>Option C</label>
                    <textarea class="form-control editor"
                              name="option_c[]">{!! $detail->option_c !!}</textarea>
                </div>

                <div class="form-group">
                    <label>Option D</label>
                    <textarea class="form-control editor"
                              name="option_d[]">{!! $detail->option_d !!}</textarea>
                </div>

                <div class="form-group option-e-group"
     style="{{ $question->has_option_e ? '' : 'display:none;' }}">
    <label>Option E</label>
    <textarea class="form-control editor"
              name="option_e[]">{!! $detail->option_e ?? '' !!}</textarea>
</div>

                <div class="form-group">
                    <label>Correct Answer</label>
                    <select class="form-control" name="answer[]">
                        <option value="A" {{ $detail->answer === 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ $detail->answer === 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ $detail->answer === 'C' ? 'selected' : '' }}>C</option>
                        <option value="D" {{ $detail->answer === 'D' ? 'selected' : '' }}>D</option>
                         <option value="E" {{ $detail->answer === 'E' ? 'selected' : '' }}>E</option>
                    </select>
                </div>
            </div>

            {{-- REASONING --}}
            <div class="reasoning-fields" style="{{ $detail->type === 'reasoning' ? '' : 'display:none;' }}">
                <div class="form-group">
                    <label>Answer Format</label>
                    <select class="form-control" name="answer_format[]">
                        <option value="text" {{ $detail->answer_format === 'text' ? 'selected' : '' }}>Text</option>
                        <option value="audio" {{ $detail->answer_format === 'audio' ? 'selected' : '' }}>Audio</option>
                        <option value="video" {{ $detail->answer_format === 'video' ? 'selected' : '' }}>Video</option>
                        <option value="image" {{ $detail->answer_format === 'image' ? 'selected' : '' }}>Image</option>
                        <option value="document" {{ $detail->answer_format === 'document' ? 'selected' : '' }}>Document</option>
                    </select>
                </div>
            </div>

            {{-- SOLUTION (loop → no id) --}}
            <div class="form-group solution-group"
                 style="{{ empty($detail->solution) ? 'display:none;' : '' }}">
                <label>Solution</label>
                <textarea class="form-control editor"
                          name="solution[]">{!! $detail->solution !!}</textarea>
            </div>

            <div class="text-end">
                <button type="button" class="btn btn-danger remove-sub-question">
                    Remove Sub Question
                </button>
            </div>

        </div>
        @endforeach

    </div>

    <button type="button" id="add-sub-question" class="btn btn-primary mt-2">
        + Add Sub Question
    </button>

</div>
@endif



                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-3">Update</button>
            </form>
        </div>
    </div>
</div>

{{-- ================= CKEDITOR ================= --}}
<script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {


    document.querySelectorAll('textarea.editor').forEach(function (el) {
        if (!el.id) el.id = 'ck_' + Math.random().toString(36).substr(2, 9);
    if (CKEDITOR.instances[el.id]) return;

        CKEDITOR.replace(el.id, {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
            allowedContent: true
        });
    });

});


 function toggleInstruction(checkbox) {
    const form = checkbox.closest('form');
    const instructionGroup = form.querySelector('.instruction-group');

    if (!instructionGroup) return;

    instructionGroup.style.display = checkbox.checked ? 'block' : 'none';

    if (checkbox.checked) {
        instructionGroup.querySelectorAll('textarea.editor').forEach(initEditor);
    }
}


function toggleSolution(checkbox) {

    const form = checkbox.closest('form');
    const solutionGroups = form.querySelectorAll('.solution-group');

    solutionGroups.forEach(group => {

        if (checkbox.checked) {

            group.style.display = 'block';
            group.querySelectorAll('textarea.editor').forEach(initEditor);

        } else {

            group.querySelectorAll('textarea.editor').forEach(el => {
                if (el.id && CKEDITOR.instances[el.id]) {
                    CKEDITOR.instances[el.id].destroy(true);
                }
            });

            group.style.display = 'none';
        }
    });
}

function toggleOptionE(checkbox) {

    const form = checkbox.closest('form');
    const optionEGroups = form.querySelectorAll('.option-e-group');

    optionEGroups.forEach(group => {

        if (checkbox.checked) {

            group.style.display = 'block';
            group.querySelectorAll('textarea.editor').forEach(initEditor);

        } else {

            group.querySelectorAll('textarea.editor').forEach(el => {
                if (el.id && CKEDITOR.instances[el.id]) {
                    CKEDITOR.instances[el.id].destroy(true);
                }
            });

            group.style.display = 'none';
        }
    });
}

function initEditor(el) {

    if (!el.id) {
        el.id = 'ck_' + Math.random().toString(36).substr(2, 9);
    }

    if (CKEDITOR.instances[el.id]) return;

    CKEDITOR.replace(el.id, {
        filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
        filebrowserUploadMethod: 'form',
        allowedContent: true
    });
}


/* =====================================================
   SUB QUESTION TYPE CHANGE (MCQ / REASONING)
===================================================== */
document.addEventListener('change', function (e) {

    if (!e.target.classList.contains('sub-question-type')) return;

    const block = e.target.closest('.sub-question-block');
    const isMcq = e.target.value === 'mcq';

    block.querySelector('.mcq-fields').style.display = isMcq ? 'block' : 'none';
    block.querySelector('.reasoning-fields').style.display = isMcq ? 'none' : 'block';
});


/* =====================================================
   ADD SUB QUESTION (STORY)
===================================================== */
document.getElementById('add-sub-question')?.addEventListener('click', function () {

    const container = document.getElementById('story-sub-questions');
    const last = container.querySelector('.sub-question-block:last-child');
    const clone = last.cloneNode(true);

    /* CLEAR VALUES */
    clone.querySelectorAll('textarea').forEach(el => el.value = '');
    clone.querySelectorAll('select').forEach(el => el.selectedIndex = 0);

    /* RESET ID */
    const idInput = clone.querySelector('input[name="sub_question_id[]"]');
    if (idInput) idInput.value = '';

    /* DESTROY OLD CKEDITOR INSTANCES */
    clone.querySelectorAll('textarea.editor').forEach(el => {
        if (el.id && CKEDITOR.instances[el.id]) {
            CKEDITOR.instances[el.id].destroy(true);
        }
        el.removeAttribute('id');
    });

    container.appendChild(clone);
    clone.querySelectorAll('textarea.editor').forEach(initEditor);
});


/* =====================================================
   REMOVE SUB QUESTION
===================================================== */
document.addEventListener('click', function (e) {

    if (!e.target.classList.contains('remove-sub-question')) return;

    const blocks = document.querySelectorAll('.sub-question-block');
    if (blocks.length <= 1) {
        alert('At least one sub question is required');
        return;
    }

    const block = e.target.closest('.sub-question-block');

    block.querySelectorAll('textarea.editor').forEach(el => {
        if (el.id && CKEDITOR.instances[el.id]) {
            CKEDITOR.instances[el.id].destroy(true);
        }
    });

    block.remove();
});
</script>

<script>
        $(document).ready(function () {
            $(document).on('change', '#exam_com_id', function (event) {
                $('#category_id').html("");
                $('#subject_id').html("");
                $('#chapter_id').html("");
                $('#topic_id').html("");
                let competitive_commission = $(this).val();
                $.ajax({
                    url: `{{ URL::to('fetch-exam-category-by-commission/${competitive_commission}') }}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {
                        if (result.success) {
                            $('#category_id').html(result.html);
                        } else {
                            toastr.error('error encountered ' + result.msgText);
                        }
                    },
                });
            });

            $(document).on('change', '#category_id', function (event) {

                $('#sub_category_id').html("");
                let exam_category = $(this).val();
                if (exam_category != '') {
                    $.ajax({
                        url: `{{ URL::to('fetch-sub-category-by-exam-category/${exam_category}') }}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (result) {
                            if (result.success) {
                                if (result.html != '') {
                                    $('#sub_category_id').html(result.html);
                                    $('.sub-cat').removeClass('hidecls');
                                    $('#sub_category_id').attr("required", true);
                                }
                                else {
                                    $('#sub_category_id').val("").trigger('change');
                                    $('.sub-cat').addClass('hidecls');
                                    $('#sub_category_id').attr("required", false);
                                }

                            } else {
                                toastr.error('error encountered ' + result.msgText);
                            }
                        },
                    });
                }
                else {
                    $('#sub_category_id').val("").trigger('change');
                    $('.sub-cat').addClass('hidecls');
                    $('#sub_category_id').attr("required", false);
                }

            });

            $(document).on('change', '#exam_com_id,#category_id,#sub_category_id', function (e) {
                e.preventDefault(e);

                $('#subject_id').val("").trigger('change');
                let competitive_commission = $('#exam_com_id').val();
                let category_id = $('#category_id').val();
                let sub_category_id = $('#sub_category_id').val();
                $.ajax({
                    headers: { "Access-Control-Allow-Origin": "*" },
                    url: `{{ URL::to('fetch-subject-by-subcategory/${sub_category_id}') }}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {
                        if (result.success) {
                            $('#subject_id').html(result.html);
                        } else {
                            //alert(result.msgText);
                            //toastr.error('error encountered ' + result.msgText);
                        }
                    },
                });
            });

            $(document).on('change', '#subject_id', function (event) {

                $('#chapter_id').val("").trigger('change');
                let subject = $(this).val();
                if (subject != '') {
                    $.ajax({
                        url: `{{ URL::to('fetch-chapter-by-subject/${subject}') }}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (result) {
                            if (result.success) {
                                if (result.html != '') {
                                    $('#chapter_id').html(result.html);
                                }
                                else {
                                    $('#chapter_id').val("").trigger('change');
                                }

                            } else {
                                toastr.error('error encountered ' + result.msgText);
                            }
                        },
                    });
                }
                else {
                    // $('#sub_category_id').val("").trigger('change');
                    // $('.sub-cat').addClass('hidecls');
                    // $('#sub_category_id').attr("required", false);
                }

            });

            $(document).on('change', '#chapter_id', function (event) {

                $('#topic_id').val("").trigger('change');
                let chapter = $(this).val();
                if (chapter != '') {
                    $.ajax({
                        url: `{{ URL::to('fetch-topic-by-chapter/${chapter}') }}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (result) {
                            if (result.success) {
                                if (result.html != '') {
                                    $('#topic_id').html(result.html);
                                }
                                else {
                                    $('#topic_id').val("").trigger('change');
                                }

                            } else {
                                toastr.error('error encountered ' + result.msgText);
                            }
                        },
                    });
                }

            });
        });

    </script>
@endsection
