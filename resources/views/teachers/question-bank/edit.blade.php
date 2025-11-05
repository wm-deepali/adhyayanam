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
                                            <label for="passage_question_type">Question Type</label>
                                            <div class="input-group">
                                                <select class="form-control" name="passage_question_type"
                                                    id="passage_question_type">
                                                    <option value="" selected>Select Type</option>
                                                    <option value="multiple_choice"
                                                        @if($question->passage_question_type == 'multiple_choice') selected
                                                        @endif>Multiple Choice</option>
                                                    <option value="reasoning_subjective"
                                                        @if($question->passage_question_type == 'reasoning_subjective') selected
                                                        @endif>Reasoning/Subjective</option>
                                                </select>
                                            </div>
                                            <div class="text-danger validation-err" id="passage_question_type-err">
                                            </div>
                                        </div>
                                        @if($question->passage_question_type == 'multiple_choice')
                                            <div class="mb-3" id="multiple_choice_passage_div">
                                                <div class="optionBox_mcp">
                                                    <div class="blockbox block_mcp">
                                                        @if($question->passage_question_type == 'multiple_choice' && isset($question->questionDeatils) && count($question->questionDeatils) > 0)
                                                            @foreach($question->questionDeatils as $quesDetails)
                                                                <div class="col-md-12">
                                                                    <label for="">Question </label>
                                                                    <div class="input-group">
                                                                        <textarea name="passage_mcq_questions[]"
                                                                            class="form-control multiple_choice_passage_question ckeditor rightContent"
                                                                            id="multiple_choice_passage_question" rows="2"
                                                                            cols="4">{{$quesDetails->question}}</textarea>
                                                                        <div class="text-danger validation-err"
                                                                            id="passage_mcq_questions-err"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label for="">Correct Answer</label>
                                                                    <div class="input-group">
                                                                        <select class="form-control multiple_choice_passage_answer"
                                                                            name="multiple_choice_passage_answer[]">
                                                                            <option value="A" @if($quesDetails->answer == 'A') selected
                                                                            @endif>Option A</option>
                                                                            <option value="B" @if($quesDetails->answer == 'B') selected
                                                                            @endif>Option B</option>
                                                                            <option value="C" @if($quesDetails->answer == 'C') selected
                                                                            @endif>Option C</option>
                                                                            <option value="D" @if($quesDetails->answer == 'D') selected
                                                                            @endif>Option D</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <label for="">Option A </label>
                                                                    <div class="input-group">
                                                                        <textarea
                                                                            class="form-control multiple_choice_passage_option_a ckeditor rightContent"
                                                                            name="multiple_choice_passage_option_a[]"
                                                                            id="multiple_choice_passage_option_a" rows="2" cols="4"
                                                                            placeholder="Option A">{{$quesDetails->option_a}}</textarea>
                                                                        <div class="text-danger validation-err"
                                                                            id="multiple_choice_passage_option_a-err"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <label for="">Option B </label>
                                                                    <div class="input-group">
                                                                        <textarea
                                                                            class="form-control multiple_choice_passage_option_b ckeditor rightContent"
                                                                            rows="2" name="multiple_choice_passage_option_b[]"
                                                                            id="multiple_choice_passage_option_b" cols="4"
                                                                            placeholder="Option B">{{$quesDetails->option_b}}</textarea>
                                                                        <div class="text-danger validation-err"
                                                                            id="multiple_choice_passage_option_b-err"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <label for="">Option C </label>
                                                                    <div class="input-group">
                                                                        <textarea
                                                                            class="form-control multiple_choice_passage_option_c ckeditor rightContent"
                                                                            name="multiple_choice_passage_option_c[]"
                                                                            id="multiple_choice_passage_option_c" rows="2" cols="4"
                                                                            placeholder="Option C">{{$quesDetails->option_c}}</textarea>
                                                                        <div class="text-danger validation-err"
                                                                            id="multiple_choice_passage_option_c-err"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <label for="">Option D </label>
                                                                    <div class="input-group">
                                                                        <textarea
                                                                            class="form-control multiple_choice_passage_option_d ckeditor rightContent"
                                                                            name="multiple_choice_passage_option_d[]"
                                                                            id="multiple_choice_passage_option_d" rows="2" cols="4"
                                                                            placeholder="Option D">{{$quesDetails->option_d}}</textarea>
                                                                        <div class="text-danger validation-err"
                                                                            id="multiple_choice_passage_option_d-err"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 solution-group" @if(empty($quesDetails->solution))
                                                                style="display: none;" @endif>
                                                                    <label>Solution</label>
                                                                    <div class="input-group">
                                                                        <textarea class="form-control ckeditor"
                                                                            name="passage_mcq_solution[]" rows="2" cols="4"
                                                                            placeholder="Solution">{!! $quesDetails->solution !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif

                                                        <div class="col-sm-12">
                                                            <button type="button" class="btn btn-primary addbox add_mcp"><i
                                                                    class="fa fa-plus"></i>
                                                                Add More</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($question->passage_question_type == 'reasoning_subjective')
                                                <div class="mb-3" id="reasoning_subjective_passage_div" style="display: none;">
                                                    <div class="optionBox_rp">
                                                        <div class="blockbox block_rp">
                                                            @if($question->passage_question_type == 'reasoning_subjective' && isset($question->questionDeatils) && count($question->questionDeatils) > 0)
                                                                @foreach($question->questionDeatils as $quesDetails)
                                                                    <div class="col-md-9">
                                                                        <label for="">Question </label>
                                                                        <div class="input-group">
                                                                            <textarea
                                                                                class="form-control reasoning_subjective_passage_question ckeditor rightContent"
                                                                                name="reasoning_passage_questions[]"
                                                                                id="reasoning_subjective_passage_question" rows="2"
                                                                                cols="4">{{$quesDetails->question}}</textarea>
                                                                            <div class="text-danger validation-err"
                                                                                id="reasoning_passage_questions-err"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 solution-group" @if(empty($quesDetails->solution))
                                                                    style="display: none;" @endif>
                                                                        <label>Solution</label>
                                                                        <div class="input-group">
                                                                            <textarea class="form-control ckeditor"
                                                                                name="reasoning_passage_solution[]" rows="2" cols="4"
                                                                                placeholder="Solution">{!! $quesDetails->solution !!}</textarea>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                           
                                                            <div class="col-sm-3"><button type="button"
                                                                    class="btn btn-primary addbox add_rp"><i class="fa fa-plus"></i> Add
                                                                    More</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3" id="answer_format_div" style="display: none;">
                                                    <label>Answer Type</label>
                                                    <select class="form-control" name="answer_format[]">
                                                        <option value="">Select</option>
                                                        <option value="audio">Audio</option>
                                                        <option value="video">Video</option>
                                                        <option value="image">Image</option>
                                                        <option value="document">Document</option>
                                                        <option value="text input">Text Input</option>
                                                    </select>
                                                </div>
                                                <!-- <div class="mb-3" id="solution_div" style="display: none;">
                                                                                    <label>Solution</label>
                                                                                    <input type="file" class="form-control" name="answerformatsolution[]"
                                                                                        placeholder="Solution">
                                                                                </div> -->
                                            </div>
                                        @endif
                                @endif
                                <div id="question-clone"></div>
                                {{-- <div class="col-md-12 d-flex justify-content-end mt-2">
                                    <button type="button" id="add-more" class="btn btn-secondary mb-3">Add More</button>
                                </div> --}}
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


        document.getElementById('question-category').addEventListener('change', function () {
            var previousYearGroup = document.getElementById('previous-year');
            if (this.value == '1') {
                previousYearGroup.style.display = 'block';
            } else {
                previousYearGroup.style.display = 'none';
            }
        });
        document.getElementById('add-more').addEventListener('click', function () {
            let questionBlock = document.getElementById('question_form');
            let newQuestionBlock = questionBlock.cloneNode(true);

            // Update question count
            let count = document.querySelectorAll('.question-block').length + 1;
            newQuestionBlock.querySelector('.question-count').innerHTML = '<h4 class="mt-4">Question ' + count + '</h4>';

            // Append the cloned question block
            document.getElementById('question-clone').appendChild(newQuestionBlock);
        });
        function toggleInstruction(checkbox) {
            const instructionGroup = checkbox.closest('.question-block').querySelector('.instruction-group');
            instructionGroup.style.display = checkbox.checked ? 'block' : 'none';
        }

        function toggleOptionE(checkbox) {
            const optionEGroup = checkbox.closest('.question-block').querySelector('.option-e-group');
            optionEGroup.style.display = checkbox.checked ? 'block' : 'none';
        }
        function toggleSolution(checkbox) {
            const block = checkbox.closest('.question-block');
            if (!block) return;
            const groups = block.querySelectorAll('.solution-group');
            groups.forEach(function (grp) {
                grp.style.display = checkbox.checked ? 'block' : 'none';
                if (checkbox.checked) {
                    grp.querySelectorAll('textarea.ckeditor').forEach(function (el) {
                        if (!el.id) { el.id = 'ck_' + Math.random().toString(36).slice(2, 9); }
                        if (typeof CKEDITOR !== 'undefined') {
                            if (!CKEDITOR.instances[el.id]) { CKEDITOR.replace(el.id); }
                        }
                    });
                }
            });
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.ckeditor').forEach(function (el) {
                CKEDITOR.replace(el);
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.quesckeditor').forEach(function (el) {
                CKEDITOR.replace(el);
            });
        });

        function loadeditor() {
            document.querySelectorAll('.ckeditor').forEach(function (el) {
                if (!el.id) { el.id = 'ck_' + Math.random().toString(36).slice(2, 9); }
                if (typeof CKEDITOR !== 'undefined') {
                    if (!CKEDITOR.instances[el.id]) { CKEDITOR.replace(el.id); }
                }
            });
        }

        $(document).on('change', '#passage_question_type', function (event) {
            let passage_question_type = $(this).val();
            $("#multiple_choice_passage_div").hide();
            $("#reasoning_subjective_passage_div").hide();
            if (passage_question_type == 'multiple_choice') {
                $("#multiple_choice_passage_div").show();
                try { var qb = document.getElementById('question_form').closest('.question-block'); if (qb) { var chk = qb.querySelector('.has-solution'); if (chk) { toggleSolution(chk); } } } catch (e) { }
            } else if (passage_question_type == 'reasoning_subjective') {
                $("#reasoning_subjective_passage_div").show();
                $("#answer_format_div").show();
                try { var qb = document.getElementById('question_form').closest('.question-block'); if (qb) { var chk = qb.querySelector('.has-solution'); if (chk) { toggleSolution(chk); } } } catch (e) { }
            }
        });
        var id = 1;
        $(document).on('click', '.add_mcp', function (event) {
            $('.block_mcp:last').after(`
                        <div class="block_mcp">

            <div class="col-md-12">
                                                            <label for="">Question </label>
                                                            <div class="input-group">
                                                                <textarea name="passage_mcq_questions[]" class="form-control multiple_choice_passage_question ckeditor rightContent" id="multiple_choice_passage_question_${id}" rows="2" cols="4"></textarea>
                                                                <div class="text-danger validation-err" id="passage_mcq_questions-err"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="">Correct Answer</label>
                                                            <div class="input-group">
                                                                <select class="form-control multiple_choice_passage_answer" name="multiple_choice_passage_answer[]">
                                                                    <option value="A" selected>Option A</option>
                                                                    <option value="B">Option B</option>
                                                                    <option value="C">Option C</option>
                                                                    <option value="D">Option D</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <label for="">Option A </label>
                                                            <div class="input-group">
                                                                <textarea class="form-control multiple_choice_passage_option_a ckeditor rightContent" name="multiple_choice_passage_option_a[]" id="multiple_choice_passage_option_a_${id}"  rows="2" cols="4" placeholder="Option A"></textarea>
                                                                <div class="text-danger validation-err" id="multiple_choice_passage_option_a-err"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <label for="">Option B </label>
                                                            <div class="input-group">
                                                                <textarea class="form-control multiple_choice_passage_option_b ckeditor rightContent" rows="2" name="multiple_choice_passage_option_b[]" id="multiple_choice_passage_option_b_${id}" cols="4" placeholder="Option B"></textarea>
                                                                <div class="text-danger validation-err" id="multiple_choice_passage_option_b-err"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <label for="">Option C </label>
                                                            <div class="input-group">
                                                                <textarea class="form-control multiple_choice_passage_option_c ckeditor rightContent" name="multiple_choice_passage_option_c[]" id="multiple_choice_passage_option_c_${id}" rows="2" cols="4" placeholder="Option C"></textarea>
                                                                <div class="text-danger validation-err" id="multiple_choice_passage_option_c-err"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <label for="">Option D </label>
                                                            <div class="input-group">
                                                                <textarea class="form-control multiple_choice_passage_option_d ckeditor rightContent" name="multiple_choice_passage_option_d[]" id="multiple_choice_passage_option_d_${id}" rows="2" cols="4" placeholder="Option D"></textarea>
                                                                <div class="text-danger validation-err" id="multiple_choice_passage_option_d-err"></div>
                                                            </div>
                                                        </div>
                                                          <div class="col-md-12 solution-group" style="display: none;">
                                                        <label>Solution</label>
                                                        <div class="input-group">
                                                            <textarea class="form-control ckeditor" name="passage_mcq_solution[]" id="multiple_choice_passage_solution_${id}" rows="2" cols="4" placeholder="Solution"></textarea>
                                                        </div>
                                                    </div>
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-danger removebox remove_mcp"><i class="fa fa-minus"></i> Remove</button>
                                <button type="button" class="btn btn-primary addbox add_mcp"><i class="fa fa-plus"></i> Add More</button>
                            </div>
                        </div>
                    `);
            id = id + 1
            loadeditor();
            try { var qb = event.currentTarget.closest('.question-block'); if (qb) { var chk = qb.querySelector('.has-solution'); if (chk) { toggleSolution(chk); } } } catch (e) { }
            // $('.editor').summernote();
        });
        $('.optionBox_mcp').on('click', '.remove_mcp', function () {
            $(this).parent().parent().remove();
        });


        $(document).on('click', '.add_rp', function (event) {
            $('.block_rp:last').after(`
                        <div class="blockbox block_rp">
                            <div class="col-md-9">
                                                            <label for="">Question </label>
                                                            <div class="input-group">
                                                                <textarea class="form-control reasoning_subjective_passage_question ckeditor rightContent" name="reasoning_passage_questions[]" id="reasoning_subjective_passage_question" rows="2" cols="4"></textarea>
                                                                <div class="text-danger validation-err" id="reasoning_passage_questions-err"></div>
                                                            </div>
                                                        </div>
                                                         <div class="col-md-12 solution-group" style="display: none;">
                            <label>Solution</label>
                            <div class="input-group">
                                <textarea class="form-control ckeditor" name="reasoning_passage_solution[]" rows="2" cols="4" placeholder="Solution"></textarea>
                            </div>
                        </div>
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-danger removebox remove_rp"><i class="fa fa-minus"></i> Remove</button>
                                <button type="button" class="btn btn-primary addbox add_rp"><i class="fa fa-plus"></i> Add More</button>
                            </div>
                        </div>
                    `);
            id = id + 1
            loadeditor();
            try { var qb = event.currentTarget.closest('.question-block'); if (qb) { var chk = qb.querySelector('.has-solution'); if (chk) { toggleSolution(chk); } } } catch (e) { }
            // $('.editor').summernote();
        });
        $('.optionBox_rp').on('click', '.remove_rp', function () {
            $(this).parent().parent().remove();
        });

    </script>
@endsection