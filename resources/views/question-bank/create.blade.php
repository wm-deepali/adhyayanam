@extends('layouts.app')

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
                        <a href='{{route('question.bank.create')}}' class="btn btn-primary">&#43; Add</a>
                    </div>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <form id="form-question" action="{{ route('question.bank.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div id="questions-container">
                        <div class="question-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Language</label>
                                        <select class="form-control" name="language">
                                            <option value="1">Hindi</option>
                                            <option value="2">English</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Question Type</label>
                                        <select id="question-type" class="form-control" name="question_type" required>
                                            <option value="MCQ">MCQ</option>
                                            <option value="Subjective">Subjective</option>
                                            <option value="Story Based">Story Based</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Fee Type</label>
                                        <select id="fee-type" class="form-control" name="fee_type">
                                            <option value="Free">Free</option>
                                            <option value="Paid">Paid</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Question Category</label>
                                        <select id="question-category" class="form-control" name="question_category">
                                            <option value="0">Normal</option>
                                            <option value="1">Previous Year</option>
                                            <option value="2">Current Affair</option>
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
                                                <option value="{{ $commission->id }}">{{ $commission->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Category</label>
                                        <select class="form-control" name="category_id" id="category_id">
                                            <option value="">--Select--</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group sub-cat hidecls">
                                        <label>Sub Category</label>
                                        <select class="form-control" name="sub_category_id" id="sub_category_id">
                                            <option value="">--Select--</option>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Select Subject</label>
                                        <select class="form-control" name="subject_id" id="subject_id">
                                            <option value="">--Select--</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Chapter</label>
                                        <select class="form-control" name="chapter_id" id="chapter_id">
                                            <option value="">--Select--</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Topic</label>
                                        <select class="form-control" name="topic" id="topic_id">
                                            <option value="">--Select--</option>

                                        </select>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input id="has_instruction" type="checkbox" class="form-check-input has-instruction"
                                            name="has_instruction" onchange="toggleInstruction(this)">
                                        <label for="has_instruction">Has an Instruction</label>
                                    </div>
                                    <div class="form-group instruction-group" style="display: none;">
                                        <textarea class="form-control quill-editor ckeditor" name="instruction"></textarea>
                                        <label>Instruction</label>
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="checkbox" class="form-check-input has-option-e" name="has_option_e"
                                            onchange="toggleOptionE(this)">
                                        <label>Has option E</label>
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="checkbox" class="form-check-input" name="show_on_pyq" value="yes">
                                        <label for="show_on_pyq">Show on PYQ</label>
                                    </div>
                                </div>
                                <div class="col-md-6" id="mcq_question_form">
                                    <div class="question-count" class="form-group">
                                        <h4>Question 1</h4>
                                    </div>
                                    <div class="form-group">
                                        <label>Enter Question</label>
                                        <textarea class="form-control quesckeditor" name="question[]"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Answer</label>
                                        <input type="text" class="form-control" name="answer[]" placeholder="Ex. a">
                                    </div>
                                    <div class="form-group">
                                        <label>Option A</label>
                                        <textarea class="form-control quill-editor2 ckeditor" name="option_a[]"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Option B</label>
                                        <textarea class="form-control quill-editor3 ckeditor" name="option_b[]"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Option C</label>
                                        <textarea class="form-control quill-editor4 ckeditor" name="option_c[]"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Option D</label>
                                        <textarea class="form-control quill-editor5 ckeditor" name="option_d[]"></textarea>
                                    </div>
                                    <div class="form-group option-e-group" style="display: none;">
                                        <label>Option E</label>
                                        <textarea class="form-control quill-editor6 ckeditor" name="option_e[]"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6" id="subjective_question_form" style="display:none;">
                                    <div class="question-count" class="form-group">
                                        <h4>Question 1</h4>
                                    </div>
                                    <div class="form-group">
                                        <label>Enter Question</label>
                                        <textarea class="form-control quesckeditor" name="question[]"></textarea>
                                    </div>
                                    <div class="form-group">
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
                                    <div class="form-group">
                                        <label>Solution</label>
                                        <input type="file" class="form-control" name="answerformatsolution[]"
                                            placeholder="Solution">
                                    </div>

                                </div>
                                <div class="col-md-6" id="story_question_form" style="display:none;">
                                    <div class="question-count" class="form-group">
                                        <h4>Question 1</h4>
                                    </div>
                                    <div class="form-group">
                                        <label>Enter Question</label>
                                        <textarea class="form-control quesckeditor" name="question[]"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="passage_question_type">Question Type</label>
                                        <div class="input-group">
                                            <select class="form-control" name="passage_question_type"
                                                id="passage_question_type">
                                                <option value="" selected>Select Type</option>
                                                <option value="multiple_choice">Multiple Choice</option>
                                                <option value="reasoning_subjective">Reasoning/Subjective</option>
                                            </select>
                                        </div>
                                        <div class="text-danger validation-err" id="passage_question_type-err">
                                        </div>
                                    </div>
                                    <div class="form-group" id="multiple_choice_passage_div" style="display: none;">
                                        <div class="optionBox_mcp">
                                            <div class="blockbox block_mcp">

                                                <div class="col-md-12">
                                                    <label for="">Question </label>
                                                    <div class="input-group">
                                                        <textarea name="passage_mcq_questions[]"
                                                            class="form-control multiple_choice_passage_question ckeditor rightContent"
                                                            id="multiple_choice_passage_question" rows="2"
                                                            cols="4"></textarea>
                                                        <div class="text-danger validation-err"
                                                            id="passage_mcq_questions-err"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="">Correct Answer</label>
                                                    <div class="input-group">
                                                        <select class="form-control multiple_choice_passage_answer"
                                                            name="multiple_choice_passage_answer[]">
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
                                                        <textarea
                                                            class="form-control multiple_choice_passage_option_a ckeditor rightContent"
                                                            name="multiple_choice_passage_option_a[]"
                                                            id="multiple_choice_passage_option_a" rows="2" cols="4"
                                                            placeholder="Option A"></textarea>
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
                                                            placeholder="Option B"></textarea>
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
                                                            placeholder="Option C"></textarea>
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
                                                            placeholder="Option D"></textarea>
                                                        <div class="text-danger validation-err"
                                                            id="multiple_choice_passage_option_d-err"></div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <button type="button" class="btn btn-primary addbox add_mcp"><i
                                                            class="fa fa-plus"></i>
                                                        Add More</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="reasoning_subjective_passage_div" style="display: none;">
                                        <div class="optionBox_rp">
                                            <div class="blockbox block_rp">
                                                <div class="col-md-9">
                                                    <label for="">Question </label>
                                                    <div class="input-group">
                                                        <textarea
                                                            class="form-control reasoning_subjective_passage_question ckeditor rightContent"
                                                            name="reasoning_passage_questions[]"
                                                            id="reasoning_subjective_passage_question" rows="2"
                                                            cols="4"></textarea>
                                                        <div class="text-danger validation-err"
                                                            id="reasoning_passage_questions-err"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3"><button type="button"
                                                        class="btn btn-primary addbox add_rp"><i class="fa fa-plus"></i> Add
                                                        More</button></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="answer_format_div" style="display: none;">
                                        <label>Answer Type</label>
                                        <select class="form-control" name="passage_answer_format[]">
                                            <option value="">Select</option>
                                            <option value="audio">Audio</option>
                                            <option value="video">Video</option>
                                            <option value="image">Image</option>
                                            <option value="document">Document</option>
                                            <option value="text input">Text Input</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="solution_div" style="display: none;">
                                        <label>Solution</label>
                                        <input type="file" class="form-control" name="answerformatsolution[]"
                                            placeholder="Solution">
                                    </div>

                                </div>
                                <div id="question-clone"></div>
                                <div class="col-md-12 d-flex justify-content-end mt-2" id="add-more-btn-dv">
                                    <button type="button" id="add-more" class="btn btn-secondary mb-3">Add More</button>
                                </div>
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


        document.getElementById('question-category').addEventListener('change', function () {
            var previousYearGroup = document.getElementById('previous-year');
            if (this.value == '1') {
                previousYearGroup.style.display = 'block';
            } else {
                previousYearGroup.style.display = 'none';
            }
        });

        document.getElementById('question-type').addEventListener('change', function () {
            var mcqquestionType = document.getElementById('mcq_question_form');
            var storyquestionType = document.getElementById('story_question_form');
            var subjectivequestionType = document.getElementById('subjective_question_form');
            var addmorediv = document.getElementById('add-more-btn-dv');
            if (this.value == 'MCQ') {
                mcqquestionType.style.display = 'block';
                storyquestionType.style.display = 'none';
                subjectivequestionType.style.display = 'none';
                addmorediv.style.display = 'block';
            }
            else if (this.value == 'Subjective') {
                subjectivequestionType.style.display = 'block';
                storyquestionType.style.display = 'none';
                mcqquestionType.style.display = 'none';
                addmorediv.style.display = 'block';
            }
            else if (this.value == 'Story Based') {
                storyquestionType.style.display = 'block';
                mcqquestionType.style.display = 'none';
                subjectivequestionType.style.display = 'none';
                addmorediv.setAttribute('style', 'display: none !important');

            }
        });

        let questionIndex = 1; // Start with question 1

        document.getElementById('add-more').addEventListener('click', function () {
            questionIndex++; // increment for each new question

            var qType = document.getElementById('question-type');
            var questionBlock;
            if (qType.value == 'MCQ') {
                questionBlock = document.getElementById('mcq_question_form');
            } else if (qType.value == 'Subjective') {
                questionBlock = document.getElementById('subjective_question_form');
            } else if (qType.value == 'Story Based') {
                questionBlock = document.getElementById('story_question_form');
            }

            let newQuestionBlock = questionBlock.cloneNode(true);

            // Update question count
            newQuestionBlock.querySelector('.question-count').innerHTML = '<h4 class="mt-4">Question ' + questionIndex + '</h4>';

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
                CKEDITOR.replace(el);
            });
        }

        $(document).on('change', '#passage_question_type', function (event) {
            let passage_question_type = $(this).val();
            $("#multiple_choice_passage_div").hide();
            $("#reasoning_subjective_passage_div").hide();
            if (passage_question_type == 'multiple_choice') {
                $("#multiple_choice_passage_div").show();
            } else if (passage_question_type == 'reasoning_subjective') {
                $("#reasoning_subjective_passage_div").show();
                $("#answer_format_div").show();
                $("#solution_div").show();
            }
        });
        var id = 1;
        $(document).on('click', '.add_mcp', function (event) {
            $('.block_mcp:last').after(`
                <div class="block_mcp">

    <div class="col-md-12">
                                                    <label for="">Question </label>
                                                    <div class="input-group">
                                                        <textarea name="passage_mcq_questions[]" class="form-control multiple_choice_passage_question ckeditor rightContent" id="multiple_choice_passage_question" rows="2" cols="4"></textarea>
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
                                                        <textarea class="form-control multiple_choice_passage_option_a ckeditor rightContent" name="multiple_choice_passage_option_a[]" id="multiple_choice_passage_option_a"  rows="2" cols="4" placeholder="Option A"></textarea>
                                                        <div class="text-danger validation-err" id="multiple_choice_passage_option_a-err"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="">Option B </label>
                                                    <div class="input-group">
                                                        <textarea class="form-control multiple_choice_passage_option_b ckeditor rightContent" rows="2" name="multiple_choice_passage_option_b[]" id="multiple_choice_passage_option_b" cols="4" placeholder="Option B"></textarea>
                                                        <div class="text-danger validation-err" id="multiple_choice_passage_option_b-err"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="">Option C </label>
                                                    <div class="input-group">
                                                        <textarea class="form-control multiple_choice_passage_option_c ckeditor rightContent" name="multiple_choice_passage_option_c[]" id="multiple_choice_passage_option_c" rows="2" cols="4" placeholder="Option C"></textarea>
                                                        <div class="text-danger validation-err" id="multiple_choice_passage_option_c-err"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="">Option D </label>
                                                    <div class="input-group">
                                                        <textarea class="form-control multiple_choice_passage_option_d ckeditor rightContent" name="multiple_choice_passage_option_d[]" id="multiple_choice_passage_option_d" rows="2" cols="4" placeholder="Option D"></textarea>
                                                        <div class="text-danger validation-err" id="multiple_choice_passage_option_d-err"></div>
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
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-danger removebox remove_rp"><i class="fa fa-minus"></i> Remove</button>
                        <button type="button" class="btn btn-primary addbox add_rp"><i class="fa fa-plus"></i> Add More</button>
                    </div>
                </div>
            `);
            id = id + 1
            loadeditor();
            // $('.editor').summernote();
        });
        $('.optionBox_rp').on('click', '.remove_rp', function () {
            $(this).parent().parent().remove();
        });

    </script>
@endsection