@extends('layouts.app')

@section('title')
Test Series | View
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
                    <h5 class="card-title">{{ucwords($test_series->title ?? "") }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">View Test Series section here.</h6>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="mt-2">
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Title</strong>: {{ucwords($test_series->title ?? "")}}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Language</strong>: {{ $test_series->language == '1' ? 'Hindi' : 'English'}}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Fee Type</strong>: {{ucwords($test_series->fee_type ?? "")}}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Commission</strong>: {{ucwords($test_series->commission->name ?? "")}}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Category</strong>: {{ucwords($test_series->category->name ?? "")}}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>SubCategory</strong>: {{ucwords($test_series->subcategory->name ?? "")}}</p>
                    </div>
                    @if($test_series->fee_type == 'paid')
                    <div class="col-md-4">
                        <p><strong>MRP(₹)</strong>: {{ $test_series->mrp }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Discount(%)</strong>: {{ $test_series->discount }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Offered Price(₹)</strong>: {{ $test_series->price }}</p>
                    </div>
                    @endif

                    <div class="col-md-4">
                        <p><strong>Slug</strong>: {{ $test_series->slug }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Test Selections</strong>: {{ ucfirst($test_series->test_generated_by) }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Total Papers</strong>: {{ $test_series->total_paper }}</p>
                    </div>

                    @if(isset($test_series->testseries) && count($test_series->testseries)>0)
                    <div class="col-md-6">
                        <p><strong>Test Type</strong>: {{ $test_series->testseries[0]->type_name ?? "" }}</p>
                    </div>
                    @foreach($test_series->testseries as $details)
                    <div class="col-md-12">
                        <h5>{{ $details->test_paper_type ?? "" }} Paper</h5>
                    </div>
                    @if(isset($test_series->tests) && count($test_series->tests)>0)
                    @foreach($test_series->tests as $testpaper)
                    @php
                        $testDatas = json_decode($testpaper->question_marks_details,true);
                        
                    @endphp
                    @if(isset($testDatas) && !empty($testDatas))
                        @foreach($testDatas as $key=>$paper)
                       
                            @if($paper['sub_question_id'] !="")
                            @php
                                $subquesDetails = Helper::getSubQuestionDetails($paper['sub_question_id'], $paper['test_question_type'], $paper['sub_negative_mark'], $paper['sub_positive_mark']);
                            @endphp
                                @include('test-series.sub-questions', ['question' => $subquesDetails, 'marks'=>$paper['sub_positive_mark'], 'index'=>$key])
                            @else
                            @php
                            $quesDetails = Helper::getQuestionDetails($paper['question_id'], $paper['test_question_type'], $paper['sub_negative_mark'], $paper['positive_mark']);
                            @endphp
                             @include('test-series.questions', ['question' => $quesDetails, 'marks'=>$paper['positive_mark'], 'index'=>$key])
                            @endif
                        @endforeach
                    @endif
                    @endforeach
                    
                    @endif
                    @endforeach
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection