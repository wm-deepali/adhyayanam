@extends('layouts.app')

@section('title')
    Test Paper | Edit
@endsection



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
    .question-bank-main-page {
        width: 100%;
        height: auto;
        display: grid;
        grid-template-columns: 1fr 2fr 1fr;
        gap: 10px
    }

    .button-actns-questn {
        text-align: center;
        padding: 107px 0;
    }

    .button-actns-questn i {
        display: block;
        width: 100%;
        padding: 10px;
        color: #fff;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .box-questns ul li {
        padding: 2px 10px;
        border-bottom: 1px dashed #ccc;
    }

    .box-questns {
        border: 1px solid gray;
        border-radius: 10px;
    }

    .box-questns ul {
        padding: 0px;
        list-style: none;
        margin: 0;
        max-height: 300px;
        overflow: auto;
        height: 300px;
    }

    .form-section {
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 7px;
        /*background-color: #fafafa;*/
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    select,
    textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="checkbox"] {
        margin-right: 10px;
    }

    button {
        padding: 10px 15px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .question-bank {
        width: 100%;
        height: auto;
        display: flex;
        /*grid-template-columns:1fr 1fr 1fr;*/
        flex-direction: row;
        gap: 20px;
        border-top: 1px solid gray;
        margin-top: 30px;
        padding-top: 20px;
    }

    .hidden {
        display: none;
    }

    .right-side-question::-webkit-scrollbar {
        display: none;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">


@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">Update</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Edit Question section here.</h6>
                    </div>
                    <div class="justify-content-end">
                        <!--<a href='{{route('question.bank.create')}}' class="btn btn-primary">&#43; Add</a>-->
                    </div>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>


                <div class="question-bank-main-page">
                    <input type="hidden" value="{{$paper->id}}" id="test_id">
                    <div class="left-side" style="width:100%; height:auto; ">
                        <div class="form-section">
                            <h2 class="border-bottom">Master</h2>
                            <label for="language">Select Language *</label>
                            <select class="form-control" name="language" id="language">
                                <option value="1" {{ $paper->language == '1' ? 'selected' : '' }}>Hindi</option>
                                <option value="2" {{ $paper->language == '2' ? 'selected' : '' }}>English</option>
                            </select>
                            <div class="text-danger validation-err" id="language-err"></div>

                            <label class="mt-2" for="paper_type">Paper Type *</label>
                            <select class="form-control" name="paper_type" id="paper_type">
                                <option @if($paper->paper_type == 0) selected @endif value="0">Normal</option>
                                <option @if($paper->paper_type == 1) selected @endif value="1">Previous Year</option>
                                <option @if($paper->paper_type == 2) selected @endif value="2">Current Affair</option>
                            </select>
                            <div class="text-danger validation-err" id="paper_type-err"></div>
                            <div class="form-group previous-year-group" id="previous-year" @if($paper->paper_type != 1)
                            style="display: none;" @endif>
                                <label>Previous Year</label>
                                <input type="number" class="form-control" name="previous_year" id="previous_year"
                                    value="{{$paper->previous_year ?? ''}}" placeholder="Ex. 2014">
                            </div>

                            <label class="mt-2" for="paper_type">Test Type *</label>
                            <select class="form-control" name="test_type" id="test_type" required>
                                <option value="">Select</option>
                                <option value="free" @if($paper->test_type == 'free') selected @endif>Free</option>
                                <option value="paid" @if($paper->test_type == 'paid') selected @endif>Paid</option>
                            </select>
                            <div class="text-danger validation-err" id="test_type-err"></div>




                            <label class="mt-2" for="competitive_commission">Examination Commission *</label>
                            <select id="competitive_commission" name="competitive_commission">
                                <option value="">Select Examination Commission</option>
                                @if (isset($commissions) && count($commissions) > 0)
                                    @foreach ($commissions as $commission)
                                        <option @if($paper->competitive_commission_id == $commission->id) selected @endif
                                            value='{{ $commission->id }}'>
                                            {{ $commission->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="text-danger validation-err" id="competitive_commission-err"></div>

                            <label class="mt-2" for="exam_category">Examination Category *</label>
                            <select id="exam_category" name="exam_category">
                                <option value="">--Select--</option>
                                @foreach($categories as $category)
                                    <option @if($paper->exam_category_id == $category->id) selected @endif
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger validation-err" id="exam_category-err"></div>


                            <label for="exam_subcategory">Sub Category *</label>
                            <select id="exam_subcategory" name="exam_subcategory">
                                <option value="">--Select--</option>
                                @foreach($subcategories as $subcategory)
                                    <option @if($paper->exam_subcategory_id == $subcategory->id) selected @endif
                                        value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger validation-err" id="exam_subcategory-err"></div>


                            <label class="mt-2" for="subject">Subects *</label>
                            <select id="subject" name="subject">
                                <option value="">--Select--</option>
                                @foreach($subjects as $subject)
                                    <option @if($paper->subject_id == $subject->id) selected @endif value="{{ $subject->id }}">
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="text-danger validation-err" id="subject-err"></div>

                            <div class="form-group">
                                <label>Select Chapter</label>
                                <select class="form-control" name="chapter_id" id="chapter_id">
                                    <option value="">--Select--</option>
                                    @foreach($subjects as $chapter)
                                        <option @if($paper->chapter_id == $chapter->id) selected @endif
                                            value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <label class="mt-2" for="topic">Topics *</label>
                            <select id="topic" name="topic">
                                <option value="">--Select--</option>
                                @foreach($topics as $topic)
                                    <option @if($paper->topic_id == $topic->id) selected @endif value="{{ $topic->id }}">
                                        {{ $topic->name }}
                                    </option>
                                @endforeach

                            </select>
                            <div class="text-danger validation-err" id="topic-err"></div>

                        </div>
                    </div>
                    <div class="center-card" style="width:100%; height:auto;">
                        <div class="form-section">
                            <h2 class="border-bottom">Test Paper Detail</h2>


                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Test Name: <b class="text-danger">*</b></label>
                                    <input type="text" class="form-control" placeholder="Test Name" name="name" id="name"
                                        value="{{$paper->name ?? ''}}">
                                    <div class="text-danger validation-err" id="name-err"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="duration">Test Duration in Minutes
                                        <b class="text-danger">*</b>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Test Duration" name="duration"
                                        id="duration" value="{{$paper->duration ?? 0}}">
                                    <div class="text-danger validation-err" id="duration-err"></div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="total_questions">Total Questions <b class="text-danger">*</b></label>
                                    <input type="text" class="form-control" placeholder="Enter in no."
                                        name="total_questions" id="total_questions"
                                        value="{{$paper->total_questions ?? ''}}" readonly>
                                    <div class="text-danger validation-err" id="total_questions-err"></div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="total_marks">Total Marks <b class="text-danger">*</b></label>
                                    <input type="text" class="form-control" placeholder="Enter in no." name="total_marks"
                                        id="total_marks" value="{{$paper->total_marks ?? 0}}" readonly>
                                    <div class="text-danger validation-err" id="total_marks-err"></div>
                                </div>
                            </div>

                            <div class="form-row price-fields" style="display:none;">
                                <div class="form-group col-md-4">
                                    <label for="mrp">MRP <b class="text-danger">*</b></label>
                                    <input type="number" step="0.01" class="form-control" name="mrp" id="mrp"
                                        placeholder="Enter MRP" value="{{ $paper->mrp ?? '' }}">
                                    <div class="text-danger validation-err" id="mrp-err"></div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="discount">Discount (%)</label>
                                    <input type="number" step="0.01" class="form-control" name="discount" id="discount"
                                        placeholder="Enter Discount" value="{{ $paper->discount ?? '' }}">
                                    <div class="text-danger validation-err" id="discount-err"></div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="offer_price">Offer Price</label>
                                    <input type="number" step="0.01" class="form-control" name="offer_price"
                                        id="offer_price" placeholder="Enter Offer Price"
                                        value="{{ $paper->offer_price ?? '' }}">
                                    <div class="text-danger validation-err" id="offer_price-err"></div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="text">Question Type</label><br>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="text">Total Question</label><br>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="text">Each Question Mark</label><br>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="text">Total Marks</label><br>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="checkbox" id="question-type-mcq" name="question_type[]" value="MCQ"
                                        @if($paper->mcq_total_question > 0) checked @endif>
                                    <label for="question-type-mcq"> MCQ</label>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="number" id="mcq_total_question" name="mcq_total_question"
                                        value="{{$paper->mcq_total_question ?? 0}}" placeholder="Total Question MCQ"
                                        readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="number" id="mcq_mark_per_question" name="mcq_mark_per_question"
                                        value="{{$paper->mcq_mark_per_question ?? 0}}" placeholder="Each Question Marks MCQ"
                                        readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="number" id="mcq_total_marks" name="mcq_total_marks"
                                        value="{{$paper->mcq_total_marks ?? 0}}" placeholder="Total Marks MCQ" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="checkbox" id="question-type-story" name="question_type[]"
                                        value="Story Based" @if($paper->story_total_question > 0) checked @endif>
                                    <label for="question-type-story"> Story Based</label><br>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="number" id="story_total_question" name="story_total_question"
                                        value="{{$paper->story_total_question ?? 0}}" placeholder="Total Question Story"
                                        readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="number" id="story_mark_per_question" name="story_mark_per_question"
                                        value="{{$paper->story_mark_per_question ?? 0}}"
                                        placeholder="Each Question Marks Story" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="number" id="story_total_marks" name="story_total_marks"
                                        value="{{$paper->story_total_marks ?? 0}}" placeholder="Total Marks Story" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="checkbox" id="question-type-subjective" name="question_type[]"
                                        value="Subjective" @if($paper->subjective_total_question > 0) checked @endif>
                                    <label for="question-type-subjective"> Subjective</label><br>

                                </div>
                                <div class="form-group col-md-2">
                                    <input type="number" id="subjective_total_question" name="subjective_total_question"
                                        value="{{$paper->subjective_total_question ?? 0}}"
                                        placeholder="Total Question Subjective" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="number" id="subjective_mark_per_question"
                                        name="subjective_mark_per_question"
                                        value="{{$paper->subjective_mark_per_question ?? 0}}"
                                        placeholder="Each Question Marks Subjective" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="number" id="subjective_total_marks" name="subjective_total_marks"
                                        value="{{$paper->subjective_total_marks ?? 0}}" placeholder="Total Marks Subjective"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <!--div class="form-group col-md-4">
                                                                    <label for="per_question_marks">Per Question Marks </label>
                                                                        <input type="text" class="form-control" placeholder="Enter in no." name="per_question_marks" id="per_question_marks" >
                                                                        <div class="text-danger validation-err" id="per_question_marks-err"></div>
                                                                    </div-->
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Question Selections </label>
                                    <select id="question_generated_by" name="question_generated_by" class="form-control">
                                        <option>Choose...</option>
                                        <option @if($paper->question_generated_by == 'manual') selected @endif value="manual">
                                            Manual</option>
                                        <option @if($paper->question_generated_by == 'random') selected @endif value="random">
                                            Random</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="test_instruction">Test Instructions (If Any)</label>
                                    <textarea style="height:150px" id="test_instruction" name="test_instruction"
                                        class="form-control" rows="4">{!! $paper->test_instruction !!}</textarea>
                                    <div class="text-danger validation-err" id="test_instruction-err"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="right-side" style="width:100%; height:auto;">
                        <div class="form-section">
                            <h2 class="border-bottom">Settings</h2>
                            <label for="has_negative_marks">Negative Marking </label>
                            <select id="has_negative_marks" name="has_negative_marks" onchange="toggleInputBox()">
                                <option value="no" @if($paper->has_negative_marks == 'no') selected @endif>No</option>
                                <option value="yes" @if($paper->has_negative_marks == 'yes') selected @endif>Yes</option>
                                <!-- Add more options as needed -->
                            </select>
                            <div id="additionalInputContainer"></div>
                            <label for="allow_re_attempt">Re-Attempt Allowed </label>
                            <select id="allow_re_attempt" name="allow_re_attempt" onchange="toggleInputBox1()">
                                <option value="no" @if($paper->allow_re_attempt == 'no') selected @endif>No</option>
                                <option value="yes" @if($paper->allow_re_attempt == 'yes') selected @endif>Yes</option>
                                <!-- Add more options as needed -->
                            </select>
                            <div id="additionalInputContainer1"></div>
                            <label for="question_shuffling">Reshuffling </label>
                            <select id="question_shuffling" name="question_shuffling" id="question_shuffling">
                                <option value="yes" @if($paper->question_shuffling == 'yes') selected @endif>Yes</option>
                                <option value="no" @if($paper->question_shuffling == 'no') selected @endif>No</option>
                                <!--<option value="yes">Yes</option>-->
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group row question-selection-part master-question-item">
                    <div class="col-sm-12">
                        <div class="tab-pane-generated">
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane mcq-tab {{ $paper->mcq_total_question > 0 ? 'active show' : '' }}"
                                    id="mcq-tab" role="tabpanel" aria-labelledby="base-mcq"
                                    style="{{ $paper->mcq_total_question > 0 ? '' : 'display:none;' }}">

                                    <div class="customquestiondiv">
                                        <div class="row">


                                            <div class="col-md-5">
                                                <div class="box-area-questions">
                                                    <h4>Your Questions(MCQ) <span
                                                            id="questioncountmcqshow">{{count($mcqArr)}}/{{$paper->mcq_total_question ?? 0}}</span>
                                                    </h4>
                                                    <div class="box-questns">
                                                        <ul class="selected-questions customquestionselectedbox-mcq"
                                                            id="customquestionselectedbox-mcq">
                                                            @if(isset($mcqArr) && !empty($mcqArr))
                                                                @php
                                                                    $mcqquestions = App\Models\Question::whereIn('id', $mcqArr)->where('status', 'Done')->where('question_type', 'MCQ')->get();
                                                                @endphp
                                                                @if (isset($mcqquestions) && count($mcqquestions) > 0)
                                                                    @foreach($mcqquestions as $data)
                                                                        <li id="customquestionli">
                                                                            <label>
                                                                                <span class="questn-he">
                                                                                    <input type="checkbox" name="question[]"
                                                                                        class="question" value="{!! $data->id !!}">
                                                                                    <span
                                                                                        class="question-text">{!! $data->question !!}</span>
                                                                                </span>

                                                                            </label>
                                                                        </li>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">

                                                <div class="button-actns-questn">
                                                    <button class="btn btn-primary addquestiontoselected-mcq" type="button"
                                                        fdprocessedid="49r4zxe"><i class="fa fa-arrow-left"></i></button>
                                                    <i class="fa fa-exchange"></i>
                                                    <button class="btn btn-danger removequestionfromselected-mcq"
                                                        type="button" fdprocessedid="2x8rl7"><i
                                                            class="fa fa-arrow-right"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="box-area-questions">
                                                    <h4>All Questions <span id="questioncountshow"></span></h4>
                                                    <div class="box-questns">
                                                        <ul class="customquestionbox-mcq" id="customquestionbox-mcq">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane story-tab active" id="story-tab" role="tabpanel"
                                    aria-labelledby="base-story"
                                    style="{{ $paper->story_total_question > 0 ? '' : 'display:none;' }}">
                                    <div class="customquestiondiv">
                                        <div class="row">


                                            <div class="col-md-5">
                                                <div class="box-area-questions">
                                                    <h4>Your Questions(Story Based) <span
                                                            id="questioncountstoryshow">{{count($passageArr)}}/{{$paper->story_total_question ?? 0}}</span>
                                                    </h4>
                                                    <div class="box-questns">
                                                        <ul class="selected-questions customquestionselectedbox-story"
                                                            id="customquestionselectedbox-story">
                                                            @if(isset($passageArr) && !empty($passageArr))
                                                                @php
                                                                    $storyquestions = App\Models\Question::whereIn('id', $passageArr)->where('status', 'Done')->where('question_type', 'Story Based')->get();
                                                                @endphp
                                                                @if (isset($storyquestions) && count($storyquestions) > 0)
                                                                    @foreach($storyquestions as $data)
                                                                        <li id="customquestionli">
                                                                            <label>
                                                                                <span class="questn-he">
                                                                                    <input type="checkbox" name="question[]"
                                                                                        class="question" value="{!! $data->id !!}">
                                                                                    <span
                                                                                        class="question-text">{!! $data->question !!}</span>
                                                                                </span>

                                                                            </label>
                                                                        </li>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">

                                                <div class="button-actns-questn">
                                                    <button class="btn btn-primary addquestiontoselected-story"
                                                        type="button" fdprocessedid="49r4zxe"><i
                                                            class="fa fa-arrow-left"></i></button>
                                                    <i class="fa fa-exchange"></i>
                                                    <button class="btn btn-danger removequestionfromselected-story"
                                                        type="button" fdprocessedid="2x8rl7"><i
                                                            class="fa fa-arrow-right"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="box-area-questions">
                                                    <h4>All Questions <span id="questioncountshow"></span></h4>
                                                    <div class="box-questns">
                                                        <ul class="customquestionbox-story" id="customquestionbox-story">



                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane subjective-tab active" id="subjective-tab" role="tabpanel"
                                    aria-labelledby="base-subjective"
                                    style="{{ $paper->subjective_total_question > 0 ? '' : 'display:none;' }}">
                                    <div class="customquestiondiv">
                                        <div class="row">


                                            <div class="col-md-5">
                                                <div class="box-area-questions">
                                                    <h4>Your Questions(Subjective) <span
                                                            id="questioncountsubjectiveshow">{{count($subjectiveArr)}}/{{$paper->subjective_total_question ?? 0}}</span>
                                                    </h4>
                                                    <div class="box-questns">
                                                        <ul class="selected-questions customquestionselectedbox-subjective"
                                                            id="customquestionselectedbox-subjective">
                                                            @if(isset($subjectiveArr) && !empty($subjectiveArr))
                                                                @php
                                                                    $subjectivequestions = App\Models\Question::whereIn('id', $subjectiveArr)->where('status', 'Done')->where('question_type', 'Subjective')->get();
                                                                @endphp
                                                                @if (isset($subjectivequestions) && count($subjectivequestions) > 0)
                                                                    @foreach($subjectivequestions as $data)
                                                                        <li id="customquestionli">
                                                                            <label>
                                                                                <span class="questn-he">
                                                                                    <input type="checkbox" name="question[]"
                                                                                        class="question" value="{!! $data->id !!}">
                                                                                    <span
                                                                                        class="question-text">{!! $data->question !!}</span>
                                                                                </span>

                                                                            </label>
                                                                        </li>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">

                                                <div class="button-actns-questn">
                                                    <button class="btn btn-primary addquestiontoselected-subjective"
                                                        type="button" fdprocessedid="49r4zxe"><i
                                                            class="fa fa-arrow-left"></i></button>
                                                    <i class="fa fa-exchange"></i>
                                                    <button class="btn btn-danger removequestionfromselected-subjective"
                                                        type="button" fdprocessedid="2x8rl7"><i
                                                            class="fa fa-arrow-right"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="box-area-questions">
                                                    <h4>All Questions <span id="questioncountshow"></span></h4>
                                                    <div class="box-questns">
                                                        <ul class="customquestionbox-subjective"
                                                            id="customquestionbox-subjective">



                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" id="preview-test-btn" filter_type="competitive"><i
                        class="fa fa-check"></i> Add Test</button>
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                    aria-hidden="true" id='preview-modal'>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <!-- CKEditor CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const testType = document.getElementById('test_type');
            const paperType = document.getElementById('paper_type');
            const priceFields = document.querySelector('.price-fields');

            const mrpInput = document.getElementById('mrp');
            const discountInput = document.getElementById('discount');
            const offerPriceInput = document.getElementById('offer_price');

            // 🔹 Function to show/hide price fields
            function togglePriceFields() {
                const isPaid = testType.value === 'paid';
                const isPreviousYear = paperType.value === '1';
                if (isPaid && isPreviousYear) {
                    priceFields.style.display = 'flex';
                } else {
                    priceFields.style.display = 'none';
                    mrpInput.value = '';
                    discountInput.value = '';
                    offerPriceInput.value = '';
                }
            }

            // 🔹 Function to auto-calculate offer price
            function calculateOfferPrice() {
                const mrp = parseFloat(mrpInput.value) || 0;
                const discount = parseFloat(discountInput.value) || 0;
                const offerPrice = mrp - (mrp * (discount / 100));
                offerPriceInput.value = offerPrice.toFixed(2);
            }

            // 🔹 Event listeners
            testType.addEventListener('change', togglePriceFields);
            paperType.addEventListener('change', togglePriceFields);
            mrpInput.addEventListener('input', calculateOfferPrice);
            discountInput.addEventListener('input', calculateOfferPrice);

            // Initialize on page load
            togglePriceFields();
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const existingNegativeMarks = '{{ $paper->negative_marks_per_question ?? "" }}'; // blade variable from backend
            toggleInputBox(existingNegativeMarks);
            const existingReAttemptAllowed = '{{ $paper->number_of_re_attempt_allowed ?? ""}}'
            toggleInputBox1(existingReAttemptAllowed)
        });

        let testInstructionEditor;
        ClassicEditor.create(document.querySelector('#test_instruction'))
            .then(editor => {
                testInstructionEditor = editor;
            })
            .catch(error => {
                console.error('CKEditor initialization error:', error);
            });

    </script>

    <script>
        $(document).on('change', '#subject', function (event) {
            $('#question_generated_by').val("").trigger('change');
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
        });

        $(document).on('change', '#chapter_id', function (event) {
            $('#question_generated_by').val("").trigger('change');
            $('#topic').val("").trigger('change');
            let chapter = $(this).val();
            if (chapter != '') {
                $.ajax({
                    url: `{{ URL::to('fetch-topic-by-chapter/${chapter}') }}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {
                        if (result.success) {
                            if (result.html != '') {
                                $('#topic').html(result.html);
                            }
                            else {
                                $('#topic').val("").trigger('change');
                            }

                        } else {
                            toastr.error('error encountered ' + result.msgText);
                        }
                    },
                });
            }

        });
        document.getElementById('paper_type').addEventListener('change', function () {
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
        });

    </script>
    <script>
        function toggleInputBox(prefillValue = '') {
            const negativeMarkingSelect = document.getElementById('has_negative_marks');
            const additionalInputContainer = document.getElementById('additionalInputContainer');
            if (negativeMarkingSelect.value === 'yes') {
                additionalInputContainer.innerHTML = `
                                <label for="negative_marks_per_question">Negative Mark (%)</label>
                <input type="number" id="negative_marks_per_question" name="negative_marks_per_question" min="0" max="100" step="0.01" value="{{ old('negative_marks_per_question', $paper->negative_marks_per_question ?? '') }}">
                <small>Enter negative marking as a percentage of the positive mark per question.</small>
                        `;
            } else {
                additionalInputContainer.innerHTML = '';
            }
        }


    </script>

    <script>
        function toggleInputBox1(prefillValue = '') {
            const negativeMarkingSelect = document.getElementById('allow_re_attempt');
            const additionalInputContainer = document.getElementById('additionalInputContainer1');

            if (negativeMarkingSelect.value === 'yes') {
                additionalInputContainer.innerHTML = `
                                                            <label for="number_of_re_attempt_allowed">Number of Time</label>
                                                            <input type="number" id="number_of_re_attempt_allowed" name="number_of_re_attempt_allowed" min="0" step="0.01" required  value="${prefillValue}">
                                                        `;
            } else {
                additionalInputContainer.innerHTML = '';
            }
        }

        function reset_data_and_remove_tab_mcq() {
            $(".number_of_questions_mcq").attr('disabled', true);
            $('.number_of_questions_mcq').val('0');
            $(".positive_marks_per_question_mcq").attr('disabled', true);
            $('.positive_marks_per_question_mcq').val('0');
            $(".negative_marks_per_question_mcq").attr('disabled', true);
            $('.negative_marks_per_question_mcq').val('0');
            $(".question_generated_by_mcq").attr('disabled', true);
            $('.question_generated_by_mcq').val('');
            $('.total_question_summary_mcq').html('0');
            $('.total_marks_mcq').html('0');

        }
        function calculate_total_questions_remaining_summary() {
            let total_questions = $("#total_questions").val();
            let number_of_questions_mcq;

            if ($('.question_type_mcq').prop('checked') == true) {
                number_of_questions_mcq = $('.number_of_questions_mcq').map(function () {
                    return $(this).val()
                }).toArray().reduce((previous_value, current_value) => parseInt(previous_value) + parseInt(
                    current_value), 0);
            } else {
                number_of_questions_mcq = 0;
            }
            let summary_total = parseFloat(total_questions) - (parseFloat(number_of_questions_mcq));
            return summary_total;
        }

        function calculate_total_marks_remaining_summary() {
            let total_marks = $("#total_marks").val();
            let positive_marks_per_question_mcq;
            let number_of_questions_mcq;
            let total_marks_mcq;
            let positive_marks_per_question_mca;
            let number_of_questions_mca;
            let total_marks_mca;
            let positive_marks_per_question_digit_numeric;
            let number_of_questions_digit_numeric;
            let total_marks_digit_numeric;
            let positive_marks_per_question_passage;
            let number_of_questions_passage;
            let total_marks_passage;
            let positive_marks_per_question_reasoning;
            let number_of_questions_reasoning;
            let total_marks_reasoning;
            let positive_marks_per_question_true_false;
            let number_of_questions_true_false;
            let total_marks_true_false;
            let positive_marks_per_question_fill_in_the_blank;
            let number_of_questions_fill_in_the_blank;
            let total_marks_fill_in_the_blank;
            if ($('.question_type_mcq').prop('checked') == true) {
                positive_marks_per_question_mcq = $('.positive_marks_per_question_mcq').val();
                number_of_questions_mcq = $('.number_of_questions_mcq').map(function () {
                    return $(this).val()
                }).toArray().reduce((previous_value, current_value) => parseInt(previous_value) + parseInt(
                    current_value), 0);
                total_marks_mcq = positive_marks_per_question_mcq * number_of_questions_mcq;
            } else {
                total_marks_mcq = 0;
            }

            let summary_total = parseFloat(total_marks) - (parseFloat(total_marks_mcq) + parseFloat(total_marks_mca) + parseFloat(total_marks_digit_numeric) + parseFloat(total_marks_passage) + parseFloat(total_marks_reasoning) + parseFloat(total_marks_true_false) + parseFloat(total_marks_fill_in_the_blank));
            return summary_total;
        }

        function reset_question_count_by_type() {
            $('.mcq-count-td').html(`MCQ (0)`);

        }

        function reset_mcq_question_box() {
            $(".customquestionselectedbox-mcq").html('');
            $(".customquestionbox-mcq").html('');
        }

        function reset_and_disable_question_selection() {
            reset_mcq_question_box();

            $('.question_type_mcq').prop('checked', false);
            $('.number_of_questions_mcq').val('0')
            $('.number_of_questions_mcq').attr('disabled', true);
            $('.positive_marks_per_question_mcq').val('0')
            $('.positive_marks_per_question_mcq').attr('disabled', true);
            $('.negative_marks_per_question_mcq').val('0')
            $('.negative_marks_per_question_mcq').attr('disabled', true);
            $('.question_generated_by_mcq').val('');
            $('.question_generated_by_mcq').attr('disabled', true);
            $('.total_question_summary_mcq').html('0');

        }

        function reset_data_and_remove_tab_mcq_scoped(element) {
            element.closest('.master-question-item').find(".number_of_questions_mcq").attr('disabled', true);
            element.closest('.master-question-item').find('.number_of_questions_mcq').val('0');
            element.closest('.master-question-item').find(".positive_marks_per_question_mcq").attr('disabled', true);
            element.closest('.master-question-item').find('.positive_marks_per_question_mcq').val('0');
            element.closest('.master-question-item').find(".negative_marks_per_question_mcq").attr('disabled', true);
            element.closest('.master-question-item').find('.negative_marks_per_question_mcq').val('0');
            element.closest('.master-question-item').find(".question_generated_by_mcq").attr('disabled', true);
            element.closest('.master-question-item').find('.question_generated_by_mcq').val('');
            element.closest('.master-question-item').find('.total_question_summary_mcq').html('0');
            element.closest('.master-question-item').find('.total_marks_mcq').html('0');

        }

        function reset_mcq_question_box_scoped(element) {
            element.closest('.master-question-item').find(".customquestionselectedbox-mcq").html('');
            element.closest('.master-question-item').find(".customquestionbox-mcq").html('');
        }

        function reset_data_and_remove_tab_mca_scoped(element) {
            element.closest('.master-question-item').find(".number_of_questions_mca").attr('disabled', true);
            element.closest('.master-question-item').find('.number_of_questions_mca').val('0');
            element.closest('.master-question-item').find(".positive_marks_per_question_mca").attr('disabled', true);
            element.closest('.master-question-item').find('.positive_marks_per_question_mca').val('0');
            element.closest('.master-question-item').find(".negative_marks_per_question_mca").attr('disabled', true);
            element.closest('.master-question-item').find('.negative_marks_per_question_mca').val('0');
            element.closest('.master-question-item').find(".question_generated_by_mca").attr('disabled', true);
            element.closest('.master-question-item').find('.question_generated_by_mca').val('');
            element.closest('.master-question-item').find('.total_question_summary_mca').html('0');
            element.closest('.master-question-item').find('.total_marks_mca').html('0');
            element.closest('.master-question-item').find('.mca-tab-li').hide();
            element.closest('.master-question-item').find('.mca-tab-li a.nav-link').removeClass('active');
            element.closest('.master-question-item').find(".mca-tab").removeClass('active');
        }


        $(document).ready(function () {

            var $body = document.body;
            var $menu_trigger = $body.getElementsByClassName("menu-trigger")[0];
            if (typeof $menu_trigger !== "undefined") {
                $menu_trigger.addEventListener("click", function () {
                    $body.className = $body.className == "menu-active" ? "" : "menu-active";
                });
            }
            document.documentElement.setAttribute("data-agent", navigator.userAgent);
            $("#total_marks , #total_questions").keyup(function () {
                var total_questions = $("#total_questions").val();
                var total_marks = $("#total_marks").val();
                if (total_marks && total_questions) {
                    $("#per_question_marks").val(Math.round(total_marks / total_questions * 1000) / 1000);
                }
            })
            $("#has_negative_marks").change(function () {
                if ($(this).prop('checked')) {
                    $("#negative_mark_div").show();
                } else {
                    $("#negative_mark_div").hide();
                }
            })
            $(document).on("click", ".question_type_mcq", function (event) {
                let has_negative_marks = $('.has_negative_marks:checked').val();
                if ($(this).prop('checked') == true) {
                    $(this).closest('.master-question-item').find(".number_of_questions_mcq").attr('disabled', false);
                    $(this).closest('.master-question-item').find(".positive_marks_per_question_mcq").attr('disabled', false);
                    if (has_negative_marks == 'yes') {
                        $(this).closest('.master-question-item').find(".negative_marks_per_question_mcq").attr('disabled', false);
                    }
                    $(this).closest('.master-question-item').find(".question_generated_by_mcq").attr('disabled', false);
                    $(this).closest('.master-question-item').find('a.nav-link').removeClass('active');
                    $(this).closest('.master-question-item').find('.tab-pane').removeClass('active');
                    $(this).closest('.master-question-item').find('.mcq-tab-li').show();
                    $(this).closest('.master-question-item').find('.mcq-tab-li a.nav-link').addClass('active');
                    $(this).closest('.master-question-item').find(".mcq-tab").addClass('active');
                } else {
                    reset_data_and_remove_tab_mcq_scoped($(this));
                    reset_mcq_question_box_scoped($(this));
                }
            });


        });

        $(document).on('keyup', '.number_of_questions_mcq', function (event) {
            $(".validation-err").html('');
            reset_mcq_question_box_scoped($(this));
            $(this).closest('.master-question-item').find('.question_generated_by_mcq').val('');
            let total_questions = $("#total_questions").val();
            let question_type = $(this).attr('question_type');
            if ($.isNumeric(total_questions) && total_questions > 0) {
                let number_of_questions_mcq = $(this).closest('.master-question-item').find('.number_of_questions_mcq').map(function () {
                    return $(this).val()
                }).toArray().reduce((previous_value, current_value) => parseInt(previous_value) +
                    parseInt(current_value), 0)
                $(this).closest('.master-question-item').find('.total_question_summary_mcq').html(number_of_questions_mcq);
                let summary_total = calculate_total_questions_remaining_summary();
                if (summary_total < 0) {
                    $(this).val('0');
                    $(this).closest('.master-question-item').find('.total_question_summary_mcq').html('0');
                    $(this).closest('.master-question-item').find(`.number_of_questions_mcq_${question_type}-err`).html('Total added questions cant exceed total questions');
                    let summary_total = calculate_total_questions_remaining_summary();
                    $(this).closest('.master-question-item').find('.total_questions_summary').html(summary_total);
                    let summary_total_marks = calculate_total_marks_remaining_summary();
                    $(this).closest('.master-question-item').find('.total_marks_summary').html(`${summary_total_marks} Marks`);
                } else {
                    $(this).closest('.master-question-item').find('.total_questions_summary').html(summary_total);
                }
            } else {
                $(this).val('0');
                $('#total_questions-err').html('Total question is required in numeric format');
            }
        });




        $(document).on('change', '#competitive_commission', function (event) {
            $('#question_generated_by').val("").trigger('change');
            $('#exam_category').val("").trigger('change');
            let competitive_commission = $(this).val();
            $.ajax({
                url: `{{ URL::to('fetch-exam-category-by-commission/${competitive_commission}') }}`,
                type: 'GET',
                dataType: 'json',
                success: function (result) {
                    if (result.success) {
                        $('#exam_category').html(result.html);
                    } else {
                        toastr.error('error encountered ' + result.msgText);
                    }
                },
            });
        });

        $(document).on('change', '#exam_subcategory', function (event) {
            $('#question_generated_by').val("").trigger('change');
            $('#subject').val("").trigger('change');
            let exam_subcategory = $(this).val();
            $.ajax({
                url: `{{ URL::to('fetch-subject-by-subcategory/${exam_subcategory}') }}`,
                type: 'GET',
                dataType: 'json',
                success: function (result) {
                    if (result.success) {
                        $('#subject').html(result.html);
                    } else {
                        toastr.error('error encountered ' + result.msgText);
                    }
                },
            });
        });

        $(document).on('change', '#exam_category', function (event) {
            $('#question_generated_by').val("").trigger('change');
            $('#exam_subcategory').val("").trigger('change');
            // $('#competitive_topic').html(`<option value="">Select Competitive Topic</option>`);
            let exam_category = $(this).val();
            $.ajax({
                url: `{{ URL::to('fetch-sub-category-by-exam-category/${exam_category}') }}`,
                type: 'GET',
                dataType: 'json',
                success: function (result) {
                    if (result.success) {
                        $('#exam_subcategory').html(result.html);
                    } else {
                        toastr.error('error encountered ' + result.msgText);
                    }
                },
            });
        });

        $(document).ready(function () {
            // Manually show/hide accordion items
            $(".accordion-button").click(function () {
                var targetCollapse = $($(this).data("target"));
                if (targetCollapse.hasClass("show")) {
                    targetCollapse.collapse("hide");
                } else {
                    targetCollapse.collapse("show");
                }
            });
        });
        $(document).on('change', '#test_level,#competitive_topic', function (event) {
            $(".validation-err").html('');
            reset_question_count_by_type();
            reset_and_disable_question_selection();
            reset_data_and_remove_tab_all();
            let summary_total_questions = calculate_total_questions_remaining_summary();
            $('.total_questions_summary').html(summary_total_questions);
            let summary_total_marks = calculate_total_marks_remaining_summary();
            $('.total_marks_summary').html(`${summary_total_marks} Marks`);
            let formData = new FormData();
            formData.append('test_level', $('#test_level').val());
            formData.append('language', $('#language').val());
            formData.append('course', (typeof $('#course').val() == 'undefined') ? '' : $('#course').val());
            formData.append('semester', (typeof $('#semester').val() == 'undefined') ? '' : $('#semester').val());
            formData.append('board', (typeof $('#board').val() == 'undefined') ? '' : $('#board').val());
            formData.append('grade', (typeof $('#grade').val() == 'undefined') ? '' : $('#grade').val());
            formData.append('competitive_commission', (typeof $('#competitive_commission').val() == 'undefined') ? '' : $('#competitive_commission').val());
            formData.append('exam_category', (typeof $('#exam_category').val() == 'undefined') ? '' : $('#exam_category').val());
            formData.append('competitive_topic', (typeof $('#competitive_topic').val() == 'undefined') ? '' : $('#competitive_topic').val());
            formData.append('subject', (typeof $('#subject').val() == 'undefined') ? '' : $('#subject').val());
            formData.append('chapter_id', (typeof $('#chapter_id').val() == 'undefined') ? '' : $('#chapter_id').val());
            formData.append('topic', (typeof $('#topic').val() == 'undefined') ? '' : $('#topic').val());
            formData.append('paper_type', $('#paper_type').val());
            formData.append('test_type', $('#test_type').val());
            formData.append('previous_year', $('#previous_year').val());
            if (!$('#test_level').val()) {
                return false;
            }
            $.ajax({
                url: "{{ URL::to('admin/fetch-question-type-count-by-selection') }}",
                type: 'POST',
                processData: false,
                contentType: false,
                dataType: 'json',
                data: formData,
                success: function (result) {
                    if (result.success) {
                        $('.mcq-count-td').html(`MCQ (${result.mcq_questions})`);
                        $('.mca-count-td').html(`MCA (${result.mca_questions})`);
                        $('.digit-numeric-count-td').html(`Digit Numeric (${result.digit_numeric_questions})`);
                        $('.passage-count-td').html(`Passage/Story (${result.passage_questions})`);
                        $('.reasoning-count-td').html(`Reasoning Subjective (${result.reasoning_questions})`);
                        $('.true-false-count-td').html(`True/False (${result.truefalse_questions})`);
                        $('.fill-in-the-blank-count-td').html(`Fill in the blank (${result.fill_in_the_blank_questions})`);
                    } else {
                        if (result.code == 422) {
                            for (const key in result.errors) {
                                $(`#${key}-err`).html(result.errors[key][0]);
                            }
                        } else {
                            toastr.error('error encountered -' + result.msgText);
                        }
                    }
                }
            });
        });





        $(document).on('click', '.number_of_questions', function (event) {
            var data = $(this).val();
            console.log(data)
            if (data == "0") {
                $(this).val("");
            }
        })

        $(document).on('change', '#question_generated_by', function (event) {

            $(this).attr('disabled', true);
            $(".validation-err").html('');
            let question_generated_by = $(this).val();
            let number_of_questions = $("#total_questions").val();
            var storyquestions = $('#story_total_question').val();
            var subjectivequestions = $('#subjective_total_question').val();
            var mcqquestions = $('#mcq_total_question').val();
            var question_ids = $('.selected-questions .question').map(function () {
                return $(this).val()
            }).toArray()
            let formData = new FormData();
            formData.append('question_ids', question_ids);
            formData.append('question_generated_by', question_generated_by);
            formData.append('language', $('#language').val());


            formData.append('competitive_commission', (typeof $('#competitive_commission').val() == 'undefined') ? '' : $('#competitive_commission').val());
            formData.append('exam_category', (typeof $('#exam_category').val() == 'undefined') ? '' : $('#exam_category').val());
            formData.append('exam_subcategory', (typeof $('#exam_subcategory').val() == 'undefined') ? '' : $('#exam_subcategory').val());
            formData.append('subject', (typeof $('#subject').val() == 'undefined') ? '' : $('#subject').val());
            formData.append('chapter_id', (typeof $('#chapter_id').val() == 'undefined') ? '' : $('#chapter_id').val());
            formData.append('topic', (typeof $('#topic').val() == 'undefined') ? '' : $('#topic').val());
            formData.append('total_questions', number_of_questions);
            formData.append('paper_type', $('#paper_type').val());
            formData.append('test_type', $('#test_type').val());
            formData.append('mcq_question_total', mcqquestions);
            formData.append('story_question_total', storyquestions);
            formData.append('subjective_question_total', subjectivequestions);
            formData.append('previous_year', $('#previous_year').val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ URL::to('generate-test-questions-by-selections') }}",
                type: 'post',
                processData: false,
                contentType: false,
                dataType: 'json',
                data: formData,
                context: this,
                success: function (result) {
                    if (result.success) {
                        $(this).attr('disabled', false);

                        if (question_generated_by == 'manual') {

                            $('.addquestiontoselected-mcq').closest('.master-question-item').find('.customquestionselectedbox-mcq').html('');
                            $('.addquestiontoselected-mcq').closest('.master-question-item').find('.customquestionbox-mcq').html(result.mcq_html);

                            $('.addquestiontoselected-story').closest('.master-question-item').find('.customquestionselectedbox-story').html('');
                            $('.addquestiontoselected-story').closest('.master-question-item').find('.customquestionbox-story').html(result.story_html);

                            $('.addquestiontoselected-subjective').closest('.master-question-item').find('.customquestionselectedbox-subjective').html('');
                            $('.addquestiontoselected-subjective').closest('.master-question-item').find('.customquestionbox-subjective').html(result.subjective_html);

                        } else {
                            $('.addquestiontoselected-mcq').closest('.master-question-item').find('.customquestionbox-mcq').html('');
                            $('.addquestiontoselected-mcq').closest('.master-question-item').find('.customquestionselectedbox-mcq').html(result.mcq_html);

                            $('.addquestiontoselected-story').closest('.master-question-item').find('.customquestionbox-story').html('');
                            $('.addquestiontoselected-story').closest('.master-question-item').find('.customquestionselectedbox-story').html(result.story_html);

                            $('.addquestiontoselected-subjective').closest('.master-question-item').find('.customquestionbox-subjective').html('');
                            $('.addquestiontoselected-subjective').closest('.master-question-item').find('.customquestionselectedbox-subjective').html(result.subjective_html);

                        }
                    } else {
                        $(this).attr('disabled', false);
                        if (result.code == 422) {
                            for (const key in result.errors) {
                                $(`#${key}-err`).html(result.errors[key][0]);
                            }
                        } else {
                            toastr.error('error encountered -' + result.msgText);
                        }
                    }
                }
            })
        });







        $(document).on('click', '#add-test-section-btn', function (event) {
            $(this).attr('disabled', true);
            $(".validation-err").html('');
            let formData = new FormData();
            if ($('.master-question-item:last .selected-questions .question').length == 0) {
                toastr.error('Please Select Question Then Add More Section');
                return true;
            }
            if ($('.section-block:last .selected-questions .question').length == 0) {
                toastr.error('Please Select Question Then Add More Section');
                return true;
            }
            var question_ids = $('.selected-questions .question').map(function () {
                return $(this).val()
            }).toArray()
            formData.append('test_level', $('#test_level').val());
            formData.append('question_ids', question_ids);
            formData.append('language', $('#language').val());
            formData.append('course', (typeof $('#course').val() == 'undefined') ? '' : $('#course').val());
            formData.append('semester', (typeof $('#semester').val() == 'undefined') ? '' : $('#semester').val());
            formData.append('board', (typeof $('#board').val() == 'undefined') ? '' : $('#board').val());
            formData.append('grade', (typeof $('#grade').val() == 'undefined') ? '' : $('#grade').val());
            formData.append('competitive_commission', (typeof $('#competitive_commission').val() == 'undefined') ? '' : $('#competitive_commission').val());
            formData.append('exam_category', (typeof $('#exam_category').val() == 'undefined') ? '' : $('#exam_category').val());
            formData.append('competitive_topic', (typeof $('#competitive_topic').val() == 'undefined') ? '' : $('#competitive_topic').val());
            formData.append('subject', (typeof $('#subject').val() == 'undefined') ? '' : $('#subject').val());
            formData.append('paper_type', $('#paper_type').val());
            formData.append('previous_year', $('#previous_year').val());
            formData.append('master_question_item_count', $('.master-question-item').length);
            $.ajax({
                url: `{{ URL::to('admin/append-test-section') }}`,
                type: 'POST',
                processData: false,
                contentType: false,
                dataType: 'json',
                data: formData,
                context: this,
                success: function (result) {
                    $(this).attr('disabled', false);
                    if (result.success) {
                        $("#add-test-section-btn").remove();
                        $(".add-test-master-question-btn").remove();
                        var len = $(".section-block").length;
                        if (len == 1) {
                            $("#main-section-div").last().append(`<a href="javascript:void(0);" class="btn btn-danger btn-sm remove-test-section-btn">Remove Section</a>`)
                        }

                        $("#main-section-div").last().append(result.html);
                        $("#main-section-div").last().append(`<a href="javascript:void(0);" id="add-test-section-btn" class="btn btn-success btn-sm mr-2 bg"><i class="fa fa-plus"></i> Add More Section</a><a href="javascript:void(0);" class="btn btn-danger btn-sm remove-test-section-btn">Remove Section</a>`)
                    } else {
                        if (result.code == 422) {
                            for (const key in result.errors) {
                                $(`#${key}-err`).html(result.errors[key][0]);
                            }
                        } else {
                            toastr.error('error encountered -' + result.msgText);
                        }
                    }
                },
            });
        });

        $(document).on('click', '.remove-test-section-btn', function (event) {
            // $(this).prev('.section-block').remove();
            $(this).prevAll('.section-block:first').remove();
            $(this).remove();
            var len = $(".section-block").length;
            if (len == 1) {
                $(".remove-test-section-btn").remove();
            }
            // $(this).parent().remove();
            // 
            // if(len >1){
            //      $("#main-section-div").last().append(`<a href="javascript:void(0);" id="add-test-section-btn" class="btn btn-primary btn-sm mr-2 bg"><i class="fa fa-plus"></i> Add More Section</a>`);
            // }

        });

        $(document).on('click', '.add-test-master-question-btn', function (event) {
            $(this).attr('disabled', true);
            $(".validation-err").html('');
            if ($('.master-question-item:last .selected-questions .question').length == 0) {
                toastr.error('Please Select Question Then Add More Master');
                return true;
            }
            var question_ids = $('.selected-questions .question').map(function () {
                return $(this).val()
            }).toArray()
            let formData = new FormData();
            formData.append('test_level', $('#test_level').val());
            formData.append('question_ids', question_ids);
            formData.append('language', $('#language').val());
            formData.append('course', (typeof $('#course').val() == 'undefined') ? '' : $('#course').val());
            formData.append('semester', (typeof $('#semester').val() == 'undefined') ? '' : $('#semester').val());
            formData.append('board', (typeof $('#board').val() == 'undefined') ? '' : $('#board').val());
            formData.append('grade', (typeof $('#grade').val() == 'undefined') ? '' : $('#grade').val());
            formData.append('competitive_commission', (typeof $('#competitive_commission').val() == 'undefined') ? '' : $('#competitive_commission').val());
            formData.append('exam_category', (typeof $('#exam_category').val() == 'undefined') ? '' : $('#exam_category').val());
            formData.append('competitive_topic', (typeof $('#competitive_topic').val() == 'undefined') ? '' : $('#competitive_topic').val());
            formData.append('subject', (typeof $('#subject').val() == 'undefined') ? '' : $('#subject').val());
            formData.append('paper_type', $('#paper_type').val());
            formData.append('previous_year', $('#previous_year').val());
            formData.append('master_question_item_count', $('.master-question-item').length);
            $.ajax({
                url: `{{ URL::to('admin/append-test-master-question') }}`,
                type: 'POST',
                processData: false,
                contentType: false,
                dataType: 'json',
                data: formData,
                context: this,
                success: function (result) {
                    $(this).attr('disabled', false);
                    if (result.success) {
                        $(".add-test-master-question-btn").remove();
                        if ($(".master-question-item").length == 1) {
                            $(".add-test-master-question-btn").append(`<a href="javascript:void(0);" class="btn btn-danger btn-sm remove-test-master-question-btn">Remove Master Question</a>`);
                        }

                        // $(this).closest(".main-master-question-div").last().append(`<a href="javascript:void(0);" class="btn btn-danger btn-sm remove-test-master-question-btn">Remove Master Question</a>`)
                        $(".main-master-question-div").last().append(result.html);
                        $(".main-master-question-div").last().append(`<a href="javascript:void(0);" id="add-test-master-question-btn" class="btn btn-primary btn-sm mr-2 bg add-test-master-question-btn"><i class="fa fa-plus"></i> Add Master Question</a><a href="javascript:void(0);" class="btn btn-danger btn-sm remove-test-master-question-btn">Remove Master Question</a>`)
                    } else {
                        if (result.code == 422) {
                            for (const key in result.errors) {
                                $(`#${key}-err`).html(result.errors[key][0]);
                            }
                        } else {
                            toastr.error('error encountered -' + result.msgText);
                        }
                    }
                },
            });
        });

        $(document).on('click', '.remove-test-master-question-btn', function (event) {
            $(this).prevAll('.master-question-item:first').remove();
            $(this).remove();
            var len = $(".master-question-item").length;
            if (len == 1) {
                $(".remove-test-master-question-btn").remove();
            }

        });




        $(document).ready(function () {

            $(document).on('click', '.question', function (event) {
                if ($(this).is(":checked")) {
                    $(this).parent().parent().parent().addClass('questn-selected');
                } else {
                    $(this).parent().parent().parent().removeClass('questn-selected');
                }
            });



            $(document).on('keyup', '#total_questions', function (event) {
                // reset_and_disable_question_selection();
                let summary_total_questions = calculate_total_questions_remaining_summary();
                $('#total_questions_summary').html(summary_total_questions);
                let summary_total_marks = calculate_total_marks_remaining_summary();
                $('#total_marks_summary').html(`${summary_total_marks} Marks`);
                let total_questions = $(this).val();
                $('#total_questions_summary').html(total_questions);
                $("#que-setting").removeAttr("style")
                $("#main-section-div").removeAttr("style")

            });

            $(document).on('keyup', '#total_marks', function (event) {
                //reset_and_disable_question_selection();
                let summary_total_questions = calculate_total_questions_remaining_summary();
                $('#total_questions_summary').html(summary_total_questions);
                let summary_total_marks = calculate_total_marks_remaining_summary();
                $('#total_marks_summary').html(summary_total_marks);
                $(".validation-err").html('');
                let total_questions = $("#total_questions").val();
                if ($.isNumeric(total_questions) && total_questions > 0) {
                    let total_marks = $(this).val();
                    $('#total_marks_summary').html(`${total_marks} Marks`);
                } else {
                    $(this).val('0');
                    $('#total_questions-err').html('Total question is required in numeric format');
                }
            });









            $(document).on('click', '.addquestiontoselected-mcq', function (event) {


                var selQuestion = $(this).closest('.master-question-item').find('#customquestionbox-mcq li.questn-selected');
                const total = $("#mcq_total_question").val();
                if ($(this).closest('.master-question-item').find(".customquestionselectedbox-mcq .question").length + selQuestion.length > total) {
                    alert(`You can maximum ${total} question select`)
                    return false;
                }
                var temp = $(this).closest('.master-question-item').find('#customquestionselectedbox-mcq').html();
                var test_temp = '';
                var testing = $(this).closest('.master-question-item').find('#customquestionbox-mcq li.questn-selected span span');
                for (let i = 0; i < selQuestion.length; i++) {
                    $(selQuestion[i]).removeClass('questn-selected')
                    temp += selQuestion[i].outerHTML;
                    $(selQuestion[i]).remove();
                    test_temp += `<li>${testing[i].innerHTML}</li>`;
                }
                $(this).closest('.master-question-item').find('#customquestionselectedbox-mcq').html(temp);
                $('.slide-menu-mcq').append(test_temp);
                const selected = $(this).closest('.master-question-item').find(".customquestionselectedbox-mcq .question").length;

                $(this).closest('.master-question-item').find("#questioncountmcqshow").text(`(${selected}/${total})`)
            });

            $(document).on('click', '.removequestionfromselected-mcq', function (event) {
                var selQuestion = $(this).closest('.master-question-item').find('#customquestionselectedbox-mcq li.questn-selected');
                var temp = $(this).closest('.master-question-item').find('#customquestionbox-mcq').html();
                for (let i = 0; i < selQuestion.length; i++) {
                    $(selQuestion[i]).removeClass('questn-selected');
                    temp += selQuestion[i].outerHTML;
                    $(selQuestion[i]).remove();
                }
                $(this).closest('.master-question-item').find('#customquestionbox-mcq').html(temp);
                const selected = $(this).closest('.master-question-item').find(".customquestionselectedbox-mcq .question").length;
                const total = $("#total_questions").val();
                $(this).closest('.master-question-item').find("#questioncountmcqshow").text(`(${selected}/${total})`)
            });


            $(document).on('click', '.addquestiontoselected-story', function (event) {


                var selQuestion = $(this).closest('.master-question-item').find('#customquestionbox-story li.questn-selected');
                const total = $("#story_total_question").val();
                if ($(this).closest('.master-question-item').find(".customquestionselectedbox-story .question").length + selQuestion.length > total) {
                    alert(`You can maximum ${total} question select`)
                    return false;
                }
                var temp = $(this).closest('.master-question-item').find('#customquestionselectedbox-story').html();
                var test_temp = '';
                var testing = $(this).closest('.master-question-item').find('#customquestionbox-story li.questn-selected span span');
                for (let i = 0; i < selQuestion.length; i++) {
                    $(selQuestion[i]).removeClass('questn-selected')
                    temp += selQuestion[i].outerHTML;
                    $(selQuestion[i]).remove();
                    test_temp += `<li>${testing[i].innerHTML}</li>`;
                }
                $(this).closest('.master-question-item').find('#customquestionselectedbox-story').html(temp);
                $('.slide-menu-story').append(test_temp);
                const selected = $(this).closest('.master-question-item').find(".customquestionselectedbox-story .question").length;

                $(this).closest('.master-question-item').find("#questioncountstoryshow").text(`(${selected}/${total})`)
            });

            $(document).on('click', '.removequestionfromselected-story', function (event) {
                var selQuestion = $(this).closest('.master-question-item').find('#customquestionselectedbox-story li.questn-selected');
                var temp = $(this).closest('.master-question-item').find('#customquestionbox-story').html();
                for (let i = 0; i < selQuestion.length; i++) {
                    $(selQuestion[i]).removeClass('questn-selected');
                    temp += selQuestion[i].outerHTML;
                    $(selQuestion[i]).remove();
                }
                $(this).closest('.master-question-item').find('#customquestionbox-story').html(temp);
                const selected = $(this).closest('.master-question-item').find(".customquestionselectedbox-story .question").length;
                const total = $("#total_questions").val();
                $(this).closest('.master-question-item').find("#questioncountstoryshow").text(`(${selected}/${total})`)
            });


            $(document).on('click', '.addquestiontoselected-subjective', function (event) {


                var selQuestion = $(this).closest('.master-question-item').find('#customquestionbox-subjective li.questn-selected');
                const total = $("#subjective_total_question").val();
                if ($(this).closest('.master-question-item').find(".customquestionselectedbox-subjective .question").length + selQuestion.length > total) {
                    alert(`You can maximum ${total} question select`)
                    return false;
                }
                var temp = $(this).closest('.master-question-item').find('#customquestionselectedbox-subjective').html();
                var test_temp = '';
                var testing = $(this).closest('.master-question-item').find('#customquestionbox-subjective li.questn-selected span span');
                for (let i = 0; i < selQuestion.length; i++) {
                    $(selQuestion[i]).removeClass('questn-selected')
                    temp += selQuestion[i].outerHTML;
                    $(selQuestion[i]).remove();
                    test_temp += `<li>${testing[i].innerHTML}</li>`;
                }
                $(this).closest('.master-question-item').find('#customquestionselectedbox-subjective').html(temp);
                $('.slide-menu-subjective').append(test_temp);
                const selected = $(this).closest('.master-question-item').find(".customquestionselectedbox-subjective .question").length;

                $(this).closest('.master-question-item').find("#questioncountsubjectiveshow").text(`(${selected}/${total})`)
            });

            $(document).on('click', '.removequestionfromselected-subjective', function (event) {
                var selQuestion = $(this).closest('.master-question-item').find('#customquestionselectedbox-subjective li.questn-selected');
                var temp = $(this).closest('.master-question-item').find('#customquestionbox-subjective').html();
                for (let i = 0; i < selQuestion.length; i++) {
                    $(selQuestion[i]).removeClass('questn-selected');
                    temp += selQuestion[i].outerHTML;
                    $(selQuestion[i]).remove();
                }
                $(this).closest('.master-question-item').find('#customquestionbox-subjective').html(temp);
                const selected = $(this).closest('.master-question-item').find(".customquestionselectedbox-subjective .question").length;
                const total = $("#total_questions").val();
                $(this).closest('.master-question-item').find("#questioncountsubjectiveshow").text(`(${selected}/${total})`)
            });


            $(document).on('click', '#preview-test-btn', function (event) {
                const hasNegativeMarking = document.getElementById('has_negative_marks').value;
                const negativeMarksInput = document.getElementById('negative_marks_per_question');
                if (hasNegativeMarking === 'yes') {
                    if (!negativeMarksInput || negativeMarksInput.value === '' || Number(negativeMarksInput.value) <= 0) {
                        alert('Please enter a negative marks value greater than zero.');
                        if (negativeMarksInput) {
                            negativeMarksInput.focus();
                        }
                        return false; // Prevent form submission
                    }
                }
                $(this).attr('disabled', true);
                $(".validation-err").html('');
                const mcqselectedqu = $('.master-question-item').find(".customquestionselectedbox-mcq .question").length;
                const storyselectedqu = $('.master-question-item').find(".customquestionselectedbox-story .question").length;
                const subjectiveselectedqu = $('.master-question-item').find(".customquestionselectedbox-subjective .question").length;

                const selectedqu = mcqselectedqu + storyselectedqu + subjectiveselectedqu;
                // alert(selectedqu);
                let filter_type = $(this).attr('filter_type');
                let formData = new FormData();
                formData.append('language', $('#language').val());

                formData.append('competitive_commission', (typeof $('#competitive_commission').val() == 'undefined') ? '' : $('#competitive_commission').val());
                formData.append('exam_category', (typeof $('#exam_category').val() == 'undefined') ? '' : $('#exam_category').val());
                formData.append('exam_subcategory', (typeof $('#exam_subcategory').val() == 'undefined') ? '' : $('#exam_subcategory').val());
                formData.append('subject', (typeof $('#subject').val() == 'undefined') ? '' : $('#subject').val());
                formData.append('topic', (typeof $('#topic').val() == 'undefined') ? '' : $('#topic').val());
                formData.append('paper_type', $('#paper_type').val());
                formData.append('previous_year', $('#previous_year').val());

                formData.append('name', $('#name').val());
                formData.append('id', $('#test_id').val());
                formData.append('duration', $('#duration').val());
                formData.append('per_question_marks', $('#per_question_marks').val());
                formData.append('total_questions', $('#total_questions').val());
                formData.append('selectedquestion', selectedqu ?? 0);
                formData.append('total_marks', $('#total_marks').val());
                formData.append('question_generated_by', $('#question_generated_by').val());
                formData.append('test_instruction', testInstructionEditor.getData() || '');
                formData.append('has_negative_marks', $('#has_negative_marks').val());
                formData.append('negative_marks_per_question', $('#negative_marks_per_question').val());

                formData.append('question_shuffling', $('#question_shuffling').val());
                formData.append('number_of_re_attempt_allowed', $('#number_of_re_attempt_allowed').val() ?? 0);
                formData.append('mcq_total_question', $('#mcq_total_question').val());
                formData.append('mcq_mark_per_question', $('#mcq_mark_per_question').val());
                formData.append('mcq_total_marks', $('#mcq_total_marks').val());

                formData.append('story_total_question', $('#story_total_question').val());
                formData.append('story_mark_per_question', $('#story_mark_per_question').val());
                formData.append('story_total_marks', $('#story_total_marks').val());

                formData.append('subjective_total_question', $('#subjective_total_question').val());
                formData.append('subjective_mark_per_question', $('#subjective_mark_per_question').val());
                formData.append('subjective_total_marks', $('#subjective_total_marks').val());

                formData.append('allow_re_attempt', $('#allow_re_attempt').val());
                formData.append('test_type', $('#test_type').val());
                formData.append('positive_per_question_marks', $('#per_question_marks').val());
                formData.append('negative_marks_per_question', $('#negative_marks_per_question').val() ?? 0);

                let non_section_details = {
                    question_ids: $('.selected-questions .question').map(function () {
                        return $(this).val()
                    }).toArray(),

                    mcq_questions: $("#customquestionselectedbox-mcq .question").map(function () {
                        return $(this).val();
                    }).toArray(),

                    story_questions: $("#customquestionselectedbox-story .question").map(function () {
                        return $(this).val();
                    }).toArray(),

                    subjective_questions: $("#customquestionselectedbox-subjective .question").map(function () {
                        return $(this).val();
                    }).toArray(),



                };

                formData.append('non_section_details', JSON.stringify(non_section_details));





                formData.append('filter_type', filter_type);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ URL::to('preview-test') }}",
                    type: 'post',
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    data: formData,
                    context: this,
                    success: function (result) {
                        $(this).attr('disabled', false);
                        if (result.success) {
                            $('#preview-modal').html(result.html);
                            $('#preview-modal').modal('show');
                        } else {
                            if (result.code == 422) {
                                for (const key in result.errors) {
                                    $(`#${key}-err`).html(result.errors[key][0]);
                                }
                            } else {
                                toastr.error('error encountered -' + result.msgText);
                            }
                        }
                    }
                })
            });

            $(document).on('click', '#add-test-btn', function (event) {
                $(this).attr('disabled', true);

                let filter_type = $(this).attr('filter_type');
                let formData = new FormData();
                var test_id = $('#test_id').val()
                formData.append('language', $('#language').val());

                formData.append('competitive_commission', (typeof $('#competitive_commission').val() == 'undefined') ? '' : $('#competitive_commission').val());
                formData.append('exam_category', (typeof $('#exam_category').val() == 'undefined') ? '' : $('#exam_category').val());
                formData.append('exam_subcategory', (typeof $('#exam_subcategory').val() == 'undefined') ? '' : $('#exam_subcategory').val());
                formData.append('subject', (typeof $('#subject').val() == 'undefined') ? '' : $('#subject').val());
                formData.append('chapter_id', (typeof $('#chapter_id').val() == 'undefined') ? '' : $('#chapter_id').val());
                formData.append('topic', (typeof $('#topic').val() == 'undefined') ? '' : $('#topic').val());
                formData.append('paper_type', $('#paper_type').val());
                formData.append('previous_year', $('#previous_year').val());
                formData.append('name', $('#name').val());
                formData.append('duration', $('#duration').val());

                formData.append('mcq_total_question', $('#mcq_total_question').val());
                formData.append('mcq_mark_per_question', $('#mcq_mark_per_question').val());
                formData.append('mcq_total_marks', $('#mcq_total_marks').val());

                formData.append('story_total_question', $('#story_total_question').val());
                formData.append('story_mark_per_question', $('#story_mark_per_question').val());
                formData.append('story_total_marks', $('#story_total_marks').val());

                formData.append('subjective_total_question', $('#subjective_total_question').val());
                formData.append('subjective_mark_per_question', $('#subjective_mark_per_question').val());
                formData.append('subjective_total_marks', $('#subjective_total_marks').val());

                formData.append('total_questions', $('#total_questions').val());
                formData.append('total_marks', $('#total_marks').val());
                formData.append('question_generated_by', $('#question_generated_by').val());
                formData.append('test_instruction', testInstructionEditor.getData() || '');
                formData.append('has_negative_marks', $('#has_negative_marks').val());
                formData.append('negative_marks_per_question', $('#negative_marks_per_question').val() ?? 0);

                formData.append('question_shuffling', $('#question_shuffling').val());
                formData.append('number_of_re_attempt_allowed', $('#number_of_re_attempt_allowed').val() ?? 0);

                formData.append('allow_re_attempt', $('#allow_re_attempt').val());
                formData.append('test_type', $('#test_type').val());
                formData.append('positive_per_question_marks', $('#per_question_marks').val());
                let non_section_details = {
                    question_ids: $('.selected-questions .question').map(function () {
                        return $(this).val()
                    }).toArray(),

                    mcq_questions: $("#customquestionselectedbox-mcq .question").map(function () {
                        return $(this).val();
                    }).toArray(),

                    story_questions: $("#customquestionselectedbox-story .question").map(function () {
                        return $(this).val();
                    }).toArray(),

                    subjective_questions: $("#customquestionselectedbox-subjective .question").map(function () {
                        return $(this).val();
                    }).toArray(),



                };
                // let non_section_details = {
                //     question_ids: $('.selected-questions .question').map(function() {
                //         return $(this).val()
                //     }).toArray(),

                //     has_question_type_mcq: ($('#question_type_mcq').prop('checked')) ? 'yes' : 'no',

                //     number_of_questions_mcq: $('.number_of_questions_mcq').map(function() {
                //         return $(this).val()
                //     }).toArray().reduce((previous_value, current_value) => parseInt(previous_value) + parseInt(current_value), 0),
                //     positive_marks_per_question_mcq: $('#positive_marks_per_question_mcq').val(),
                //     negative_marks_per_question_mcq: $('#negative_marks_per_question_mcq').val(),
                //     question_generated_by_mcq: $('#question_generated_by_mcq').val(),
                //     mcq_questions: $("#customquestionselectedbox-mcq .question").map(function() {
                //         return $(this).val();
                //     }).toArray(),
                //     number_of_questions_mcq_details: $(".number_of_questions_mcq").map(function() {
                //         return {
                //             question_type: $(this).attr('question_type'),
                //             type_of_question: $(this).attr('type_of_question'),
                //             number_of_question: $(this).val(),
                //         }
                //     }).get(),

                // };

                formData.append('non_section_details', JSON.stringify(non_section_details));


                // Add price fields only when test type is paid and paper type is Previous Year
                if ($('#test_type').val() === 'paid' && $('#paper_type').val() === '1') {
                    formData.append('mrp', $('#mrp').val());
                    formData.append('discount', $('#discount').val());
                    formData.append('offer_price', $('#offer_price').val());
                } else {
                    formData.append('mrp', '');
                    formData.append('discount', '');
                    formData.append('offer_price', '');
                }

                let marks_by_section_detail = $('.question-container-div').map(function () {
                    var quesattr = $(this).attr('question_id');
                    var subquesattr = $(this).attr('sub_question_id');
                    var test_question_type = $(this).attr('test_question_type');

                    if (typeof quesattr !== 'undefined' && quesattr !== false) {
                        var question_ids = quesattr;
                    }
                    else {
                        var question_ids = "";
                    }
                    if (typeof subquesattr !== 'undefined' && subquesattr !== false) {
                        var sub_question_ids = subquesattr;
                    }
                    else {
                        var sub_question_ids = "";
                    }


                    if (typeof test_question_type !== 'undefined' && test_question_type !== false) {
                        var testquestiontype = test_question_type;
                    }
                    else {
                        var testquestiontype = "";
                    }
                    var subpositivemark = $(this).find('.sub_positive_mark').val();
                    var subnegativemark = $(this).find('.sub_negative_mark').val();
                    if (typeof subpositivemark !== 'undefined' && subpositivemark !== false) {
                        var sub_positive_marks = subpositivemark;
                    }
                    else {
                        var sub_positive_marks = 0;
                    }

                    if (typeof subnegativemark !== 'undefined' && subnegativemark !== false) {
                        var sub_negative_marks = subnegativemark;
                    }
                    else {
                        var sub_negative_marks = 0;
                    }
                    return {
                        question_id: question_ids,
                        sub_question_id: sub_question_ids,
                        test_question_type: testquestiontype,
                        positive_mark: $(this).find('.positive_mark').val(),
                        negative_mark: $(this).find('.negative_mark').val(),
                        sub_negative_mark: sub_negative_marks,
                        sub_positive_mark: sub_positive_marks,
                    }
                }).get();
                formData.append('question_marks_details', JSON.stringify(marks_by_section_detail));





                let total_question_count_entered = $('.number_of_questions').map(function () {
                    return $(this).val()
                }).toArray().reduce((previous_value, current_value) => parseInt(previous_value) + parseInt(current_value), 0);
                formData.append('total_question_count_entered', total_question_count_entered);

                let total_selected_questions_count = $('.selected-questions .question').map(function () {
                    return $(this).val()
                }).toArray().length;
                formData.append('total_selected_questions_count', total_selected_questions_count);

                let total_selected_questions = $('.selected-questions .question').map(function () {
                    return $(this).val()
                }).toArray();
                formData.append('total_selected_questions', total_selected_questions);
                let total_positive_marks = 0;
                $('.positive_mark').each(function () {
                    let value = parseFloat($(this).val()) || 0;
                    total_positive_marks += value;
                });

                formData.append('total_positive_marks', total_positive_marks);
                let total_negative_marks = 0;
                $('.negative_mark').each(function () {
                    let value = parseFloat($(this).val()) || 0;
                    total_negative_marks += value;
                });

                formData.append('total_negative_marks', total_negative_marks);



                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `{{ URL::to('test-paper/update/${test_id}') }}`,
                    type: 'post',
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    data: formData,
                    context: this,
                    success: function (result) {
                        if (result.success) {
                            //toastr.success(result.msgText);
                            window.location = `{{ URL::to('test-paper') }}`;
                        } else {
                            $(this).attr('disabled', false);
                            if (result.code == 422) {
                                for (const key in result.errors) {
                                    $(`#${key}-err`).html(result.errors[key][0]);
                                }
                            } else {
                                toastr.error('error encountered -' + result.msgText);
                            }
                        }
                    }
                })
            });






        });

        document.getElementById('question-type-mcq').addEventListener('change', function () {
            if (this.checked) {
                document.getElementById('mcq_total_question').removeAttribute('readonly');
                document.getElementById('mcq_mark_per_question').removeAttribute('readonly');
                document.getElementById('mcq-tab').style.display = 'block';
            } else {
                document.getElementById('mcq_total_question').setAttribute('readonly', true);
                document.getElementById('mcq_mark_per_question').setAttribute('readonly', true);
                document.getElementById('mcq_total_question').value = 0;
                document.getElementById('mcq_mark_per_question').value = 0;
                document.getElementById('mcq_total_marks').value = 0;
                document.getElementById('mcq-tab').style.display = 'none';

            }
        });
        document.getElementById('question-type-story').addEventListener('change', function () {
            if (this.checked) {
                document.getElementById('story_total_question').removeAttribute('readonly');
                document.getElementById('story_mark_per_question').removeAttribute('readonly');
                document.getElementById('story-tab').style.display = 'block';
            } else {
                document.getElementById('story_total_question').setAttribute('readonly', true);
                document.getElementById('story_mark_per_question').setAttribute('readonly', true);
                document.getElementById('story_total_question').value = 0;
                document.getElementById('story_mark_per_question').value = 0;
                document.getElementById('story_total_marks').value = 0;
                document.getElementById('story-tab').style.display = 'none';

            }
        });
        document.getElementById('question-type-subjective').addEventListener('change', function () {
            if (this.checked) {
                document.getElementById('subjective_total_question').removeAttribute('readonly');
                document.getElementById('subjective_mark_per_question').removeAttribute('readonly');
                document.getElementById('subjective-tab').style.display = 'block';
            } else {
                document.getElementById('subjective_total_question').setAttribute('readonly', true);
                document.getElementById('subjective_mark_per_question').setAttribute('readonly', true);
                document.getElementById('subjective_total_question').value = 0;
                document.getElementById('subjective_mark_per_question').value = 0;
                document.getElementById('subjective_total_marks').value = 0;
                document.getElementById('subjective-tab').style.display = 'none';

            }
        });
        $('#mcq_total_question, #mcq_mark_per_question').on('keyup', function (event) {
            var mcqMarks = $('#mcq_mark_per_question').val();
            var mcqquestions = $('#mcq_total_question').val();
            var totalmarks = mcqMarks * mcqquestions;
            $('#mcq_total_marks').val(totalmarks);
            updatemarks();
        });
        $('#mcq_total_question, #mcq_mark_per_question').on('input', function () {
            var mcqMarks = $('#mcq_mark_per_question').val();
            var mcqquestions = $('#mcq_total_question').val();
            var totalmarks = mcqMarks * mcqquestions;
            $('#mcq_total_marks').val(totalmarks);
            updatemarks();
        });
        $('#subjective_total_question, #subjective_mark_per_question').on('keyup', function (event) {
            var subjectiveMarks = $('#subjective_mark_per_question').val();
            var subjectivequestions = $('#subjective_total_question').val();
            var totalmarks = subjectiveMarks * subjectivequestions;
            $('#subjective_total_marks').val(totalmarks);
            updatemarks();
        });
        $('#subjective_total_question, #subjective_mark_per_question').on('input', function () {
            var subjectiveMarks = $('#subjective_mark_per_question').val();
            var subjectivequestions = $('#subjective_total_question').val();
            var totalmarks = subjectiveMarks * subjectivequestions;
            $('#subjective_total_marks').val(totalmarks);
            updatemarks();
        });
        $('#story_total_question, #story_mark_per_question').on('keyup', function (event) {
            var storyMarks = $('#story_mark_per_question').val();
            var storyquestions = $('#story_total_question').val();
            var totalmarks = storyMarks * storyquestions;
            $('#story_total_marks').val(totalmarks);
            updatemarks();
        });
        $('#story_total_question, #story_mark_per_question').on('input', function () {
            var storyMarks = $('#story_mark_per_question').val();
            var storyquestions = $('#story_total_question').val();
            var totalmarks = storyMarks * storyquestions;
            $('#story_total_marks').val(totalmarks);
            updatemarks();
        });
        function updatemarks() {
            var storyquestions = $('#story_total_question').val();
            var subjectivequestions = $('#subjective_total_question').val();
            var mcqquestions = $('#mcq_total_question').val();

            var storymarks = $('#story_total_marks').val();
            var subjectivemarks = $('#subjective_total_marks').val();
            var mcqmarks = $('#mcq_total_marks').val();

            var totalMarks = parseFloat(storymarks) + parseFloat(subjectivemarks) + parseFloat(mcqmarks);
            var totalQuestions = parseFloat(storyquestions) + parseFloat(subjectivequestions) + parseFloat(mcqquestions);

            $('#total_questions').val(totalQuestions);
            $('#total_marks').val(totalMarks);
            var selected = 0;
            $("#questioncountmcqshow").text(`(${selected}/${mcqquestions})`)
            $("#questioncountstoryshow").text(`(${selected}/${storyquestions})`)
            $("#questioncountsubjectiveshow").text(`(${selected}/${subjectivequestions})`)
        }
    </script>
@endsection