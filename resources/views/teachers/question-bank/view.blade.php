@extends('layouts.teacher-app')

@section('title')
    Question Bank | View
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@section('content')
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

        #image-preview {
            width: 100%;
            max-width: 300px;
            height: auto;
        }
    </style>
    @php
        $catArr = array('0' => 'Normal', '1' => 'Previous Year', '2' => 'Current Affair');
    @endphp
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">{{ $question->question_type ?? "" }} Question</h5>
                        <h6 class="card-subtitle mb-2 text-muted">View Question Bank here.</h6>
                    </div>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <div class="mt-2">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Language</strong>: {{ $question->language == '1' ? 'Hindi' : 'English'}}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Question Category</strong>: {{ $catArr[$question->question_category] }}</p>
                        </div>
                        @if($question->question_category == 1)
                            <div class="col-md-4">
                                <p><strong>Year</strong>: {{ $question->previous_year }}</p>
                            </div>
                        @endif
                        <div class="col-md-4">
                            <p><strong>Fee Type</strong>: {{ucwords($question->fee_type ?? "")}}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Commission</strong>: {{ucwords($question->commission->name ?? "")}}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Category</strong>: {{ucwords($question->category->name ?? "")}}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>SubCategory</strong>: {{ucwords($question->subcategory->name ?? "")}}</p>
                        </div>

                        <div class="col-md-4">
                            <p><strong>Subject</strong>: {{ $question->subject->name ?? "" }}</p>
                        </div>

                        <div class="col-md-4">
                            <p><strong>Chapter</strong>: {{ $question->chapter->name ?? "" }}</p>
                        </div>

                        <div class="col-md-4">
                            <p><strong>Topic</strong>: {{ $question->topics->name ?? "" }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Has Instructions</strong>: {{ $question->has_instruction == 1 ? 'Yes' : 'No'}}</p>
                        </div>
                        @if($question->has_instruction == 1)
                            <div class="col-md-4">
                                <p><strong>Instructions</strong>: {!! $question->instruction !!}</p>
                            </div>
                        @endif
                        <div class="col-md-4">
                            <p><strong>Show On PYQ</strong>: {{ucwords($question->show_on_pyq ?? "")}}</p>
                        </div>
                        @if($question->image != "")
                            <div class="col-md-4">
                                <p><strong>Image</strong>: <a href="{{ asset('storage/question' . $question->image) }}"><img
                                            src="{{ asset('storage/question' . $question->image) }}" width="50" height="25"></a>
                                </p>
                            </div>
                        @endif
                        @if($question->note != "")
                            <div class="col-md-4">
                                <p><strong>Note</strong>: {{ $question->note }}</p>
                            </div>
                        @endif

                        <div class="col-md-12">
                            <h4>Question
                                <hr>
                            </h4>
                        </div>
                        <div class="col-md-12">
                            {!! $question->question ?? "" !!}
                        </div>
                        @if($question->question_type == 'MCQ')
                            <div class="col-md-12">
                                <p><strong>A)</strong> {!! $question->option_a ?? "" !!}</p>
                            </div>
                            <div class="col-md-12">
                                <p><strong>B)</strong> {!! $question->option_b ?? "" !!}</p>
                            </div>
                            <div class="col-md-12">
                                <p><strong>C)</strong> {!! $question->option_c ?? "" !!}</p>
                            </div>
                            <div class="col-md-12">
                                <p><strong>D)</strong> {!! $question->option_d ?? "" !!}</p>
                            </div>
                            @if(strip_tags($question->option_e) != "")
                                <div class="col-md-12">
                                    <p><strong>E)</strong> {!! $question->option_e ?? "" !!}</p>
                                </div>
                            @endif
                            <div class="col-md-12">
                                <p><strong>Answer: </strong> {!! $question->answer ?? "" !!}</p>
                            </div>
                        @endif


                        @if($question->question_type == 'Subjective')

                            @if(strip_tags($question->answer_format) != "")
                                <div class="col-md-12">
                                    <p><strong>Answer Format</strong> {!! $question->answer_format ?? "" !!}</p>
                                </div>
                            @endif
                        @endif

                        @if($question->question_type == 'Story Based')


                            @if(strip_tags($question->answer_format) != "")
                                <div class="col-md-12">
                                    <p><strong>Answer Format</strong> {!! $question->answer_format ?? "" !!}</p>
                                </div>
                            @endif

                            @if(isset($question->questionDeatils) && count($question->questionDeatils) > 0)
                                @foreach($question->questionDeatils as $details)
                                    <div class="col-md-12" style="display:flex;">
                                        {!! 'Q' . $loop->iteration . '. ' . $details->question ?? "" !!}
                                    </div>
                                    @if(strip_tags($details->option_a) != "")
                                        <div class="col-md-12">
                                            <p><strong>A)</strong> {!! $details->option_a ?? "" !!}</p>
                                        </div>
                                    @endif
                                    @if(strip_tags($details->option_b) != "")
                                        <div class="col-md-12">
                                            <p><strong>B)</strong> {!! $details->option_b ?? "" !!}</p>
                                        </div>
                                    @endif
                                    @if(strip_tags($details->option_c) != "")
                                        <div class="col-md-12">
                                            <p><strong>C)</strong> {!! $details->option_c ?? "" !!}</p>
                                        </div>
                                    @endif
                                    @if(strip_tags($details->option_d) != "")
                                        <div class="col-md-12">
                                            <p><strong>D)</strong> {!! $details->option_d ?? "" !!}</p>
                                        </div>
                                    @endif
                                    @if(strip_tags($details->option_e) != "")
                                        <div class="col-md-12">
                                            <p><strong>E)</strong> {!! $details->option_e ?? "" !!}</p>
                                        </div>
                                    @endif
                                    @if(strip_tags($details->answer) != "")
                                        <div class="col-md-12">
                                            <p><strong>Answer: </strong> {!! $details->answer ?? "" !!}</p>
                                        </div>
                                    @endif
                                    @if(strip_tags($details->answer_format) != "")
                                        <div class="col-md-12">
                                            <p><strong>Answer Format: </strong> {!! strip_tags($details->answer_format) ?? "" !!}</p>
                                        </div>
                                    @endif
                                    @if(isset($details->solution) && strip_tags($details->solution) != "")
                                        <div class="col-md-12">
                                            <p><strong>Solution: </strong> {!! $details->solution !!}</p>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                        @endif

                        @if($question->has_solution == 'yes' && strip_tags($question->solution) != "")
                            <div class="col-md-12">
                                <h4 class="mt-3">Solution
                                    <hr>
                                </h4>
                            </div>
                            <div class="col-md-12">
                                {!! $question->solution !!}
                            </div>
                        @endif



                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection