@extends('layouts.teacher-app')

@section('title')
    Question Bank | Create
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">Create</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Create Question section here.</h6>
                    </div>
                    <div class="justify-content-end">
                        <a href='{{route('teacher.question.bank.create')}}' class="btn btn-primary">&#43; Add</a>
                    </div>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <form id="form-question" action="{{ route('teacher.question.bank.update', $question->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div id="questions-container">
                        <div class="question-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Select Language</label>
                                        <select class="form-control" name="language">
                                            @foreach($languages as $lang)
                                                <option @if($question->language == $lang) selected @endif value="{{ $lang }}">
                                                    {{ $lang == 1 ? 'Hindi' : ($lang == 2 ? 'English' : 'Other') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Question Type</label>
                                        <select id="question-type" class="form-control" name="question_type" required>
                                            <option value="{{$question->question_type}}">{{$question->question_type}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Fee Type</label>
                                        <select id="fee-type" class="form-control" name="fee_type">
                                            <option value="Free" @if($question->fee_type == 'Free') selected @endif>Free
                                            </option>
                                            <option value="Paid" @if($question->fee_type == 'Paid') selected @endif>Paid
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
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
                                    <div class="mb-3 previous-year-group" id="previous-year" style="display: none;">
                                        <label>Previous Year</label>
                                        <input type="number" class="form-control" name="previous_year"
                                            placeholder="Ex. 2014">
                                    </div>
                                    <div class="mb-3">
                                        <label>Select Examination Commission</label>
                                        <select class="form-control" name="commission_id" id="exam_com_id">
                                            <option value="">--Select--</option>
                                            @foreach($commissions as $commission)
                                                <option @if($question->commission_id == $commission->id) selected @endif
                                                    value="{{ $commission->id }}">{{ $commission->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Select Category</label>
                                        <select class="form-control" name="category_id" id="category_id">
                                            <option value="">--Select--</option>
                                            @foreach($categories as $category)
                                                <option @if($question->category_id == $category->id) selected @endif
                                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 sub-cat">
                                        <label>Sub Category</label>
                                        <select class="form-control" name="sub_category_id" id="sub_category_id">
                                            <option value="">--Select--</option>
                                            @foreach($subcategories as $subcategory)
                                                <option @if($question->sub_category_id == $subcategory->id) selected @endif
                                                    value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Select Subject</label>
                                        <select class="form-control" name="subject_id" id="subject_id">
                                            <option value="">--Select--</option>
                                            @foreach($subjects as $subject)
                                                <option @if($question->subject_id == $subject->id) selected @endif
                                                    value="{{ $subject->id }}">{{ $subject->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Select Chapter</label>
                                        <select class="form-control" name="chapter_id" id="chapter_id">
                                            <option value="">--Select--</option>
                                            @foreach($subjects as $chapter)
                                                <option @if($question->chapter_id == $chapter->id) selected @endif
                                                    value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
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
                                    <div class="mb-3 instruction-group" @if($question->has_instruction == 0)
                                    style="display: none;" @endif>
                                        <textarea class="form-control quill-editor"
                                            name="instruction">{!! strip_tags($question->instruction) !!}</textarea>
                                        <label>Instruction</label>
                                    </div>
                                    <div class="mb-3 mt-2">
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
                                    <div class="mb-3 mt-2">
                                        <input type="checkbox" class="form-check-input" @if($question->show_on_pyq == "yes")
                                        checked @endif name="show_on_pyq" value="yes">
                                        <label for="show_on_pyq">Show on PYQ</label>
                                    </div>
                                </div>
                                @if($question->question_type == "MCQ")
                                    <div class="col-md-6" id="question_form">
                                        <div class="question-count" class="mb-3">
                                            <h4>Question 1</h4>
                                        </div>
                                        <div class="mb-3">
                                            <label>Enter Question</label>
                                            <textarea class="form-control quesckeditor"
                                                name="question[]">{{$question->question}}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Answer</label>
                                            <input type="text" class="form-control" name="answer[]" placeholder="Ex. a"
                                                value="{{$question->answer}}">
                                        </div>
                                        <div class="mb-3">
                                            <label>Option A</label>
                                            <textarea class="form-control quill-editor2 ckeditor"
                                                name="option_a[]">{{$question->option_a}}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Option B</label>
                                            <textarea class="form-control quill-editor3 ckeditor"
                                                name="option_b[]">{{$question->option_b}}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Option C</label>
                                            <textarea class="form-control quill-editor4 ckeditor"
                                                name="option_c[]">{{$question->option_c}}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Option D</label>
                                            <textarea class="form-control quill-editor5 ckeditor"
                                                name="option_d[]">{{$question->option_d}}</textarea>
                                        </div>
                                        <div class="mb-3 option-e-group" @if($question->has_option_e == 0) style="display: none;"
                                        @endif>
                                            <label>Option E</label>
                                            <textarea class="form-control quill-editor6 ckeditor"
                                                name="option_e[]">{{$question->option_e}}</textarea>
                                        </div>
                                        <div class="form-group solution-group" @if($question->has_solution != 'yes')
                                        style="display: none;" @endif>
                                            <label>Solution</label>
                                            <textarea class="form-control ckeditor"
                                                name="solution[]">{!! $question->solution !!}</textarea>
                                        </div>
                                    </div>
                                @elseif($question->question_type == "Subjective")
                                    <div class="col-md-6" id="question_form">
                                        <div class="question-count" class="mb-3">
                                            <h4>Question 1</h4>
                                        </div>
                                        <div class="mb-3">
                                            <label>Enter Question</label>
                                            <textarea class="form-control quesckeditor"
                                                name="question[]">{{$question->question}}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Answer Type</label>
                                            <select class="form-control" name="answer_format[]">
                                                <option value="">Select</option>
                                                <option value="audio" @if($question->answer_format == 'audio') selected @endif>
                                                    Audio</option>
                                                <option value="video" @if($question->answer_format == 'video') selected @endif>
                                                    Video</option>
                                                <option value="image" @if($question->answer_format == 'image') selected @endif>
                                                    Image</option>
                                                <option value="document" @if($question->answer_format == 'document') selected
                                                @endif>Document</option>
                                                <option value="text input" @if($question->answer_format == 'text input') selected
                                                @endif>Text Input</option>
                                            </select>
                                        </div>
                                        <div class="form-group solution-group" @if($question->has_solution != 'yes')
                                        style="display: none;" @endif>
                                            <label>Solution</label>
                                            <textarea class="form-control ckeditor"
                                                name="solution[]">{!! $question->solution !!}</textarea>
                                        </div>
                                    </div>
                                @elseif($question->question_type == "Story Based")
                                    <div class="col-md-6" id="story_question_form">

                                        <div class="question-count form-group">
                                            <h4>Question 1</h4>
                                        </div>

                                        {{-- MAIN PASSAGE --}}
                                        <div class="form-group">
                                            <label>Enter Story / Passage</label>
                                            <textarea class="form-control ckeditor"
                                                name="question[]">{!! $question->question !!}</textarea>
                                        </div>

                                        <hr>

                                        <h5>Sub Questions</h5>

                                        <div id="story-sub-questions">

                                            @forelse($question->questionDeatils as $detail)
                                                <div class="sub-question-block border p-3 mb-3">

                                                    {{-- ✅ SUB QUESTION ID --}}
                                                    <input type="hidden" name="sub_question_id[]" value="{{ $detail->id }}">

                                                    {{-- SUB QUESTION TYPE --}}
                                                    <div class="form-group">
                                                        <label>Sub Question Type</label>
                                                        <select class="form-control sub-question-type" name="sub_question_type[]">
                                                            <option value="mcq" {{ $detail->type === 'mcq' ? 'selected' : '' }}>MCQ
                                                            </option>
                                                            <option value="reasoning" {{ $detail->type === 'reasoning' ? 'selected' : '' }}>Reasoning / Subjective
                                                            </option>
                                                        </select>
                                                    </div>

                                                    {{-- QUESTION --}}
                                                    <div class="form-group">
                                                        <label>Question</label>
                                                        <textarea class="form-control ckeditor"
                                                            name="sub_question[]">{!! $detail->question !!}</textarea>
                                                    </div>

                                                    {{-- MCQ FIELDS --}}
                                                    <div class="mcq-fields"
                                                        style="{{ $detail->type === 'mcq' ? '' : 'display:none;' }}">

                                                        <div class="form-group">
                                                            <label>Option A</label>
                                                            <textarea class="form-control ckeditor"
                                                                name="option_a[]">{!! $detail->option_a !!}</textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Option B</label>
                                                            <textarea class="form-control ckeditor"
                                                                name="option_b[]">{!! $detail->option_b !!}</textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Option C</label>
                                                            <textarea class="form-control ckeditor"
                                                                name="option_c[]">{!! $detail->option_c !!}</textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Option D</label>
                                                            <textarea class="form-control ckeditor"
                                                                name="option_d[]">{!! $detail->option_d !!}</textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Correct Answer</label>
                                                            <select class="form-control" name="answer[]">
                                                                <option value="A" {{ $detail->answer === 'A' ? 'selected' : '' }}>
                                                                    Option A</option>
                                                                <option value="B" {{ $detail->answer === 'B' ? 'selected' : '' }}>
                                                                    Option B</option>
                                                                <option value="C" {{ $detail->answer === 'C' ? 'selected' : '' }}>
                                                                    Option C</option>
                                                                <option value="D" {{ $detail->answer === 'D' ? 'selected' : '' }}>
                                                                    Option D</option>
                                                            </select>
                                                        </div>

                                                    </div>

                                                    {{-- REASONING / SUBJECTIVE --}}
                                                    <div class="reasoning-fields"
                                                        style="{{ $detail->type === 'reasoning' ? '' : 'display:none;' }}">

                                                        <div class="form-group">
                                                            <label>Answer Format</label>
                                                            <select class="form-control" name="answer_format[]">
                                                                <option value="">Select</option>
                                                                <option value="text" {{ $detail->answer_format === 'text' ? 'selected' : '' }}>Text</option>
                                                                <option value="audio" {{ $detail->answer_format === 'audio' ? 'selected' : '' }}>Audio</option>
                                                                <option value="video" {{ $detail->answer_format === 'video' ? 'selected' : '' }}>Video</option>
                                                                <option value="image" {{ $detail->answer_format === 'image' ? 'selected' : '' }}>Image</option>
                                                                <option value="document" {{ $detail->answer_format === 'document' ? 'selected' : '' }}>Document</option>
                                                            </select>
                                                        </div>

                                                    </div>

                                                    {{-- SOLUTION --}}
                                                    <div class="form-group solution-group"
                                                        style="{{ empty($detail->solution) ? 'display:none;' : '' }}">
                                                        <label>Solution</label>
                                                        <textarea class="form-control ckeditor"
                                                            name="solution[]">{!! $detail->solution !!}</textarea>
                                                    </div>

                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-danger remove-sub-question">
                                                            Remove Sub Question
                                                        </button>
                                                    </div>

                                                </div>
                                            @empty
                                                {{-- EMPTY DEFAULT BLOCK --}}
                                                <div class="sub-question-block border p-3 mb-3">
                                                    <input type="hidden" name="sub_question_type[]" value="mcq">
                                                </div>
                                            @endforelse

                                        </div>



                                        <button type="button" id="add-sub-question" class="btn btn-primary mt-2">
                                            + Add Sub Question
                                        </button>

                                    </div>
                                @endif
                                <div id="question-clone"></div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mb-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $(document).on('change', '#exam_com_id', function (event) {

                $('#category_id').html("");
                $('#subject_id').html("");
                $('#chapter_id').html("");
                $('#topic_id').html("");
                let competitive_commission = $(this).val();
                $.ajax({
                    url: `{{ URL::to('teacher/fetch-categories-by-commission/${competitive_commission}') }}`,
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
                        url: `{{ URL::to('teacher/fetch-subcategories-by-category/${exam_category}') }}`,
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
                    url: `{{ URL::to('teacher/fetch-subjects-by-subcategory/${sub_category_id}') }}`,
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
                        url: `{{ URL::to('teacher/fetch-chapter-by-subject/${subject}') }}`,
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
                        url: `{{ URL::to('teacher/fetch-topic-by-chapter/${chapter}') }}`,
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

    <script>

        /* =========================================================
           SUB QUESTION TYPE CHANGE (MCQ / REASONING)
        ========================================================= */
        document.addEventListener('change', function (e) {
            if (!e.target.classList.contains('sub-question-type')) return;

            const block = e.target.closest('.sub-question-block');
            const isMcq = e.target.value === 'mcq';

            block.querySelector('.mcq-fields').style.display = isMcq ? 'block' : 'none';
            block.querySelector('.reasoning-fields').style.display = isMcq ? 'none' : 'block';

            // Re-init editors safely
            setTimeout(() => {
                destroyEditorsIn(block);
                initEditorsIn(block);
            }, 50);

        });


        /* =========================================================
           ADD SUB QUESTION
        ========================================================= */

        document.getElementById('add-sub-question')?.addEventListener('click', function () {

            const container = document.getElementById('story-sub-questions');

            // Clone last sub-question block
            const lastBlock = container.querySelector('.sub-question-block:last-child');
            const clone = lastBlock.cloneNode(true);

            /* ===============================
               RESET VALUES (EXCEPT TYPE)
            =============================== */
            clone.querySelectorAll('textarea').forEach(el => el.value = '');

            clone.querySelectorAll('select').forEach(el => {
                if (!el.classList.contains('sub-question-type')) {
                    el.selectedIndex = 0;
                }
            });

            /* ===============================
               🔑 RESET sub_question_id
            =============================== */
            let idInput = clone.querySelector('input[name="sub_question_id[]"]');

            if (!idInput) {
                idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'sub_question_id[]';
                clone.prepend(idInput);
            }

            idInput.value = ''; // new sub question

            container.appendChild(clone);

            /* ===============================
               SHOW / HIDE FIELDS BASED ON TYPE
            =============================== */
            const typeSelect = clone.querySelector('.sub-question-type');
            const isMcq = typeSelect && typeSelect.value === 'mcq';

            clone.querySelector('.mcq-fields').style.display = isMcq ? 'block' : 'none';
            clone.querySelector('.reasoning-fields').style.display = isMcq ? 'none' : 'block';

            /* ===============================
               CKEDITOR SAFE RE-INIT
            =============================== */
            setTimeout(() => {
                destroyEditorsIn(clone);
                initEditorsIn(clone);
            }, 50);
        });


        /* =========================================================
           REMOVE SUB QUESTION
        ========================================================= */
        document.addEventListener('click', function (e) {
            if (!e.target.classList.contains('remove-sub-question')) return;

            const blocks = document.querySelectorAll('.sub-question-block');

            // Prevent removing last one
            if (blocks.length <= 1) {
                alert('At least one sub question is required');
                return;
            }

            const block = e.target.closest('.sub-question-block');

            // Destroy CKEditor safely
            block.querySelectorAll('textarea').forEach(el => {
                if (el.id && CKEDITOR.instances[el.id]) {
                    CKEDITOR.instances[el.id].destroy(true);
                }
            });

            block.remove();
        });

        function toggleSolution(chk) {
            const block = chk.closest('.question-block');
            block.querySelectorAll('.solution-group').forEach(group => {
                if (chk.checked) {
                    group.style.display = 'block';
                    destroyEditorsIn(group);
                    initEditorsIn(group);
                } else {
                    destroyEditorsIn(group);
                    group.style.display = 'none';
                }
            });
        }

        function destroyEditorsIn(container) {
            if (!container || !window.CKEDITOR) return;

            container.querySelectorAll('textarea').forEach(el => {
                if (el.id && CKEDITOR.instances[el.id]) {
                    CKEDITOR.instances[el.id].destroy(true);
                }
                el.removeAttribute('id');
            });

            container.querySelectorAll('.cke').forEach(e => e.remove());
        }

        function initEditorsIn(container) {
            if (!container || !window.CKEDITOR) return;

            container.querySelectorAll('textarea.ckeditor, textarea.quesckeditor')
                .forEach(el => {
                    if (!el.id) {
                        el.id = 'ck_' + Math.random().toString(36).slice(2, 9);
                    }
                    if (!CKEDITOR.instances[el.id]) {
                        CKEDITOR.replace(el.id);
                    }
                });
        }

        document.getElementById('question-category').addEventListener('change', function () {
            var previousYearGroup = document.getElementById('previous-year');
            if (this.value == '1') {
                previousYearGroup.style.display = 'block';
            } else {
                previousYearGroup.style.display = 'none';
            }
        });


        function toggleInstruction(checkbox) {
            const instructionGroup = checkbox.closest('.question-block').querySelector('.instruction-group');
            instructionGroup.style.display = checkbox.checked ? 'block' : 'none';
        }

        function toggleOptionE(checkbox) {
            const optionEGroup = checkbox.closest('.question-block').querySelector('.option-e-group');
            optionEGroup.style.display = checkbox.checked ? 'block' : 'none';
        }

    </script>
@endsection