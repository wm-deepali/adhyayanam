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
                    <a href='{{route('question.bank.bulk-upload')}}' class="btn btn-primary">&#43; Bulk Upload</a>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <form id="form-question" action="{{ route('question.bank.import-questions') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div id="questions-container">
                <div class="form-body">
                                <h4 class="form-section">Add Multiples Questions Through MS-Word/MS-Excel File</h4>
                                <div id="multiple_choice_div" style="">
                                    <p>For reference (how to manage Multiple choice question in docx file) - <a href="{{ asset('question-samples/multiple_choice_word.docx') }}" download="">click here</a></p>
                                    <p>For reference (how to manage Multiple choice question in xlsx file) - <a href="{{ asset('question-samples/multiple_choice_excel.xlsx') }}" download="">click here</a></p>
                                </div>
                                <div id="story_based_div" style="display:none;">
                                    <p>For reference (how to manage Passage question in docx file) - <a href="{{ asset('question-samples/Passage_format.docx') }}" download="">click here</a></p>
                                </div>
                                <div id="subjective_div" style="display:none;">
                                    <p>For reference (how to manage Subjective question in docx file) - <a href="{{ asset('question-samples/subjective_word.docx') }}" download="">click here</a></p>
                                    <p>For reference (how to manage Subjective question in xlsx file) - <a href="{{ asset('question-samples/subjective_excel.xlsx') }}" download="">click here</a></p>
                                </div>
                    </div>
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
                                    <select id="question-type"class="form-control" name="question_type" required>
                                        <option value="MCQ">MCQ</option>
                                        <option value="Subjective">Subjective</option>
                                        <option value="Story Based">Story Based</option>
                                    </select>
                                </div>
                                <div class="form-group" id="passage_type_div" style="display:none;">
                                    <label>Passage Question Type</label>
                                    <select class="form-control" name="passage_question_type" id="passage_question_type">
                                        <option value="" selected>Select Type</option>
                                        <option value="multiple_choice">Multiple Choice</option>
                                        <option value="reasoning_subjective">Reasoning/Subjective</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Fee Type</label>
                                    <select id="fee-type"class="form-control" name="fee_type">
                                        <option value="Free">Free</option>
                                        <option value="Paid">Paid</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Question Category</label>
                                    <select id="question-category"class="form-control" name="question_category">
                                        <option value="0">Normal</option>
                                        <option value="1">Previous Year</option>
                                    </select>
                                </div>
                                <div class="form-group previous-year-group" id="previous-year" style="display: none;">
                                    <label>Previous Year</label>
                                    <input type="number" class="form-control" name="previous_year" placeholder="Ex. 2014">
                                </div>
                                <div class="form-group">
                                    <label>Select Examination Commission</label>
                                    <select class="form-control" name="commission_id" id="exam_com_id">
                                        <option value="">None</option>
                                        @foreach($commissions as $commission)
                                            <option value="{{ $commission->id }}">{{ $commission->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Select Category</label>
                                    <select class="form-control" name="category_id" id="category_id">
                                        <option value="">None</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group sub-cat hidecls" >
                                    <label>Sub Category</label>
                                    <select class="form-control" name="sub_category_id" id="sub_category_id">
                                        <option value="">--Select--</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Select Subject</label>
                                    <select class="form-control" name="subject_id" id="subject_id">
                                        <option value="">None</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endforeach
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
                                        <option value="">None</option>
                                        @foreach($topics as $topic)
                                            <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                            </div>
                            <div class="col-md-6" id="question_form">
                                <div class="question-count" class="form-group">
                                    <h4>Upload File</h4>
                                </div>
                                <div class="form-group">
                                    <label for="file">File to Upload <b class="text-danger">*</b></label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="file" id="file" accept=".docx, application/vnd.openxmlformats-officedocument.wordprocessingml.document, .xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                        
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                        <hr>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Upload</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

<script>
     $(document).ready(function() {
    $(document).on('change', '#exam_com_id', function(event) {
            
            $('#category_id').html("");
            $('#subject_id').html("");
            $('#chapter_id').html("");
            $('#topic_id').html("");
            let competitive_commission = $(this).val();
            $.ajax({
                url: `{{ URL::to('fetch-exam-category-by-commission/${competitive_commission}') }}`,
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        $('#category_id').html(result.html);
                    } else {
                        toastr.error('error encountered ' + result.msgText);
                    }
                },
            });
        });

        $(document).on('change', '#category_id', function(event) {
            
            $('#sub_category_id').html("");
            let exam_category = $(this).val();
            if(exam_category !='')
            {
                $.ajax({
                url: `{{ URL::to('fetch-sub-category-by-exam-category/${exam_category}') }}`,
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        if(result.html !='')
                        {
                            $('#sub_category_id').html(result.html);
                            $('.sub-cat').removeClass('hidecls');
                            $('#sub_category_id').attr("required", true);
                        }
                        else{
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
            else{
                $('#sub_category_id').val("").trigger('change');
                $('.sub-cat').addClass('hidecls');
                $('#sub_category_id').attr("required", false);
            }
            
        });

        $(document).on('change', '#exam_com_id,#category_id,#sub_category_id', function(e) {
            e.preventDefault(e);

            $('#subject_id').val("").trigger('change');
            let competitive_commission = $('#exam_com_id').val();
            let category_id = $('#category_id').val();
            let sub_category_id = $('#sub_category_id').val();
            $.ajax({
                headers: { "Access-Control-Allow-Origin": "*" },
                url: `{{ URL::to('fetch-subject/${competitive_commission}/${category_id}/${sub_category_id}') }}`,
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        $('#subject_id').html(result.html);
                    } else {
                        alert(result.msgText);
                        //toastr.error('error encountered ' + result.msgText);
                    }
                },
            });
        });
        $(document).on('change', '#subject_id', function(event) {
            
            $('#chapter_id').val("").trigger('change');
            let subject = $(this).val();
            if(subject !='')
            {
                $.ajax({
                url: `{{ URL::to('fetch-chapter-by-subject/${subject}') }}`,
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        if(result.html !='')
                        {
                            $('#chapter_id').html(result.html);
                        }
                        else{
                            $('#chapter_id').val("").trigger('change');
                        }
                        
                    } else {
                        toastr.error('error encountered ' + result.msgText);
                    }
                },
                });
            }
            else{
                // $('#sub_category_id').val("").trigger('change');
                // $('.sub-cat').addClass('hidecls');
                // $('#sub_category_id').attr("required", false);
            }
            
        });
        $(document).on('change', '#chapter_id', function(event) {
            
            $('#topic_id').val("").trigger('change');
            let chapter = $(this).val();
            if(chapter !='')
            {
                $.ajax({
                url: `{{ URL::to('fetch-topic-by-chapter/${chapter}') }}`,
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        if(result.html !='')
                        {
                            $('#topic_id').html(result.html);
                        }
                        else{
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
        var mcqquestionType = document.getElementById('multiple_choice_div');
        var storyquestionType = document.getElementById('story_based_div');
        var subjectivequestionType = document.getElementById('subjective_div');
        var passageType = document.getElementById('passage_type_div');
        if (this.value == 'MCQ') {
            mcqquestionType.style.display = 'block';
            storyquestionType.style.display = 'none';
            subjectivequestionType.style.display = 'none';
            passageType.style.display = 'none';
             document.getElementById('passage_question_type').required = false;
        } 
        else if(this.value == 'Subjective') {
            subjectivequestionType.style.display = 'block';
            storyquestionType.style.display = 'none';
            mcqquestionType.style.display = 'none';
            passageType.style.display = 'none';
             document.getElementById('passage_question_type').required = false;
        }
        else if(this.value == 'Story Based') {
            storyquestionType.style.display = 'block';
            passageType.style.display = 'block';
             document.getElementById('passage_question_type').required = true;
            mcqquestionType.style.display = 'none';
            subjectivequestionType.style.display = 'none';
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
