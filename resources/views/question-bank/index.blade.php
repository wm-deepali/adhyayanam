@extends('layouts.app')

@section('title')
    Question Bank
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">Question Bank</h5>
                        <h6 class="card-subtitle mb-2 text-muted"> Manage your Question Bank section here.</h6>
                    </div>
                    <div class="justify-content-end">
                        <a href='{{route('question.bank.create')}}' class="btn btn-primary">&#43; Add</a>
                        <a href='{{route('question.bank.bulk-upload')}}' class="btn btn-primary">&#43; Bulk Upload</a>
                        <a href='{{route('question.bank.rejected')}}' class="btn btn-primary">Rejected Questions</a>
                        <a href='{{route('question.bank.pending')}}' class="btn btn-primary">Pending Questions</a>
                    </div>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <div class="row">
                    <h4 class="form-section">Filter by</h4>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Select Language</label>
                            <select class="form-control" id="language">
                                <option value="">Select Language</option>
                                <option value="1">Hindi</option>
                                <option value="2">English</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Question Type</label>
                            <select class="form-control" id="question_type">
                                <option value="">Select Question Type</option>
                                <option value="MCQ">MCQ</option>
                                <option value="Subjective">Subjective</option>
                                <option value="Story Based">Story Based</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fee Type</label>
                            <select class="form-control" id="fee_type">
                                <option value="">Select Fee Type</option>
                                <option value="Free">Free</option>
                                <option value="Paid">Paid</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Question Category</label>
                            <select class="form-control" id="question_category">
                                <option value="0">Normal</option>
                                <option value="1">Previous Year</option>
                                <option value="2">Current Affair</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 previous-year-group" id="previous-year" style="display: none;">
                        <div class="form-group">
                            <label>Previous Year</label>
                            <input type="number" class="form-control" id="previous_year" placeholder="Ex. 2014">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Select Examination Commission</label>
                            <select class="form-control" name="commission_id" id="exam_com_id">
                                <option value="">--Select--</option>
                                @foreach($commissions as $commission)
                                    <option value="{{ $commission->id }}">{{ $commission->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Select Category</label>
                            <select class="form-control" name="category_id" id="category_id">
                                <option value="">--Select--</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-3  sub-cat hidecls">
                        <div class="form-group">
                            <label>Sub Category</label>
                            <select class="form-control" name="sub_category_id" id="sub_category_id">
                                <option value="">--Select--</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Select Subject</label>
                            <select class="form-control" name="subject_id" id="subject_id">
                                <option value="">--Select--</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Select Chapter</label>
                            <select class="form-control" name="chapter_id" id="chapter_id">
                                <option value="">--Select--</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Select Topic</label>
                            <select class="form-control" name="topic" id="topic_id">
                                <option value="">--Select--</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6" style="margin-top: 25px;">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary filterbtn">Filter Now</button>
                            <button type="button" class="btn btn-danger resetbtn">Reset</button>
                        </div>
                    </div>
                </div>
                <div id="question-container">
                    @include('question-bank.question-table')
                </div>
            </div>
        </div>
    </div>
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

                                }
                                else {
                                    $('#sub_category_id').val("").trigger('change');
                                    $('.sub-cat').addClass('hidecls');

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
                            // alert(result.msgText);
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




        $(document).on('click', '.filterbtn', function (event) {
            let page = 1;
            let language = $('#language').val();
            let question_type = $('#question_type').val();
            let fee_type = $('#fee_type').val();
            let question_category = $('#question_category').val();
            let previous_year = $('#previous_year').val();
            let exam_com_id = $('#exam_com_id').val();
            let category_id = $('#category_id').val();
            let sub_category_id = $('#sub_category_id').val();
            let subject_id = $('#subject_id').val();
            let chapter_id = $('#chapter_id').val();
            let topic_id = $('#topic_id').val();

            getData(page, language, question_type, fee_type, question_category, previous_year, exam_com_id, category_id, sub_category_id, subject_id, chapter_id, topic_id);
        })
        $(document).on('click', '.resetbtn', function (event) {
            $('#exam_com_id').val('');

            $('#category_id').html('')
            $('#category_id').html('<option value="">Select Category</option>');

            $('#sub_category_id').html('')
            $('#sub_category_id').html('<option value="">Select Sub Category</option>');

            $('#subject_id').html('')
            $('#subject_id').html('<option value="">Select Subject</option>');

            $('#chapter_id').html('')
            $('#chapter_id').html('<option value="">Select Chapter</option>');

            $('#topic_id').html('')
            $('#topic_id').html('<option value="">Select Topic</option>');

            $('#question_type').val('');
            $('#previous_year').val('');
            $('#question_category').val('');
            $('#fee_type').val('');
            $('#language').val('');

            let page = 1;
            let language = $('#language').val();
            let question_type = $('#question_type').val();
            let fee_type = $('#fee_type').val();
            let question_category = $('#question_category').val();
            let previous_year = $('#previous_year').val();
            let exam_com_id = $('#exam_com_id').val();
            let category_id = $('#category_id').val();
            let sub_category_id = $('#sub_category_id').val();
            let subject_id = $('#subject_id').val();
            let chapter_id = $('#chapter_id').val();
            let topic_id = $('#topic_id').val();
            getData(page, language, question_type, fee_type, question_category, previous_year, exam_com_id, category_id, sub_category_id, subject_id, chapter_id, topic_id);
        })
        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            let page = $(this).attr('href').split('page=')[1];
            let language = $('#language').val();
            let question_type = $('#question_type').val();
            let fee_type = $('#fee_type').val();
            let question_category = $('#question_category').val();
            let previous_year = $('#previous_year').val();
            let exam_com_id = $('#exam_com_id').val();
            let category_id = $('#category_id').val();
            let sub_category_id = $('#sub_category_id').val();
            let subject_id = $('#subject_id').val();
            let chapter_id = $('#chapter_id').val();
            let topic_id = $('#topic_id').val();
            getData(page, language, question_type, fee_type, question_category, previous_year, exam_com_id, category_id, sub_category_id, subject_id, chapter_id, topic_id);
        });

        function getData(page, language, question_type, fee_type, question_category, previous_year, exam_com_id, category_id, sub_category_id, subject_id, chapter_id, topic_id) {
            $.ajax({
                url: '{{ URL::to('question-bank') }}?page=' + page + '&language=' + language + '&question_type=' + question_type + '&fee_type=' + fee_type + '&question_category=' + question_category + '&previous_year=' + previous_year + '&exam_com_id=' + exam_com_id + '&category_id=' + category_id + '&sub_category_id=' + sub_category_id + '&subject_id=' + subject_id + '&chapter_id=' + chapter_id + '&topic_id=' + topic_id,
                type: "get",
                datatype: "html"
            }).done(function (data) {
                $("#question-container").empty().html(data);
            }).fail(function (jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });
        }

        document.getElementById('question_category').addEventListener('change', function () {
            var previousYearGroup = document.getElementById('previous-year');
            if (this.value == '1') {
                previousYearGroup.style.display = 'block';
            } else {
                previousYearGroup.style.display = 'none';
            }
        });
    </script>
@endsection