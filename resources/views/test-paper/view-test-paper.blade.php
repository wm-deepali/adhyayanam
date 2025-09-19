@extends('layouts.app')

@section('title')
Test Paper | View
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@section('content')
<style>
    .question-bank-main-page{
        width:100%;
        height:auto;
        display:grid;
        grid-template-columns:1fr 2fr 1fr;
        gap:10px
    }
    .button-actns-questn {
    text-align: center;
    padding: 107px 0;
}
.button-actns-questn i {
    display: block;
    width: 100%;
    padding: 10px;
    color:#fff;
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
    border:1px solid gray; 
    border-radius:10px;
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

input[type="text"], input[type="number"], input[type="file"], select, textarea {
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
.question-bank{
    width:100%;
    height:auto;
    display:flex;
    /*grid-template-columns:1fr 1fr 1fr;*/
    flex-direction:row;
    gap:20px;
    border-top:1px solid gray;
    margin-top:30px;
    padding-top:20px;
}
.hidden{
    display:none;
}
.right-side-question::-webkit-scrollbar{
    display:none;
}
#image-preview {
        width: 100%;
        max-width: 300px;
        height: auto;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">{{ucwords($paper->name ?? "") }} ({{$paper->test_code ?? "" }})</h5>
                    <h6 class="card-subtitle mb-2 text-muted">View Test Paper section here.</h6>
                </div>
            </div>
           
            <div class="mt-2">
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Paper Name</strong>: {{ucwords($paper->name ?? "")}} ({{$paper->test_code ?? "" }})</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Paper Type</strong>: {{ $paper->paper_type ==0 ? 'Normal' : ($paper->paper_type ==1 ?'Previous Year' : "Current Affair")}}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Language</strong>: {{ $paper->language == '1' ? 'Hindi' : 'English'}}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Fee Type</strong>: {{ucwords($paper->test_type ?? "")}}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Commission</strong>: {{ucwords($paper->commission->name ?? "")}}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Category</strong>: {{ucwords($paper->category->name ?? "")}}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>SubCategory</strong>: {{ucwords($paper->subcategory->name ?? "")}}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Test Paper Type</strong>: {{ $paper->test_paper_type }}</p>
                    </div>

                    
                    <div class="col-md-4">
                        <p><strong>Subject</strong>: {{ ucfirst($paper->subject->name ?? "") }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Chapter</strong>: {{ ucfirst($paper->chapter->name ?? "") }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Topic</strong>: {{ $paper->topic->name ?? "" }}</p>
                    </div>

                    <div class="col-md-4">
                        <p><strong>Total Question</strong>: {{ $paper->total_questions ?? 0 }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Duration</strong>: {{ $paper->duration ?? 0 }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Total Marks</strong>: {{ $paper->total_marks ?? 0 }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Question Shuffling</strong>: {{ ucfirst($paper->question_shuffling) }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Allow Re Attempt</strong>: {{ ucfirst($paper->allow_re_attempt) }}</p>
                    </div>
                    @if($paper->allow_re_attempt == "yes")
                    <div class="col-md-4">
                        <p><strong>Number Of Re Attempt Allowed</strong>: {{ $paper->number_of_re_attempt_allowed ?? 0 }}</p>
                    </div>
                    @endif
                    <div class="col-md-4">
                        <p><strong>Has Negative Marks</strong>: {{ ucfirst($paper->has_negative_marks) }}</p>
                    </div>
                    @if($paper->has_negative_marks == "yes")
                    <div class="col-md-4">
                        <p><strong>Negative Marks Per Question</strong>: {{ $paper->negative_marks_per_question ?? 0 }}</p>
                    </div>
                    @endif

                   
                    @php
                        $testDatas = json_decode($paper->question_marks_details,true);
                        
                    @endphp
                    @if(isset($testDatas) && !empty($testDatas))
                        @foreach($testDatas as $key=>$testpaper)
                       
                            @if(isset($testpaper['sub_question_id']) && $testpaper['sub_question_id'] !="")
                            @php
                                $subquesDetails = Helper::getSubQuestionDetails($testpaper['sub_question_id'], $testpaper['test_question_type'], $testpaper['sub_negative_mark'], $testpaper['sub_positive_mark']);
                            @endphp
                                @include('test-series.sub-questions', ['question' => $subquesDetails, 'marks'=>$testpaper['sub_positive_mark'], 'index'=>$key])
                            @endif
                            @if(isset($testpaper['question_id']) && $testpaper['question_id'] !="")
                            @php
                            $quesDetails = Helper::getQuestionDetails($testpaper['question_id'], $testpaper['test_question_type'], $testpaper['sub_negative_mark'], $testpaper['positive_mark']);
                            @endphp
                             @include('test-series.questions', ['question' => $quesDetails, 'marks'=>$testpaper['positive_mark'], 'index'=>$key])
                            @endif
                        @endforeach
                    @endif
                    
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection