@extends('front.partials.app')

@section('header')
    <title>PYQ Papers</title>

    <meta name="description" content="{{ $seo->description ?? 'Default Description' }}">
    <meta name="keywords" content="{{ $seo->keywords ?? 'default, keywords' }}">
    <link rel="canonical" href="{{ $seo->canonical ?? url()->current() }}">

    <style>
        /* FILTER BOX */

        .filter-box {
            height: 400px;
            background: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0px;
        }

        .filter-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        }


        /* PAPER CARD */

        .paper-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .paper-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
            border-left: 5px solid #e74c3c;
        }

        .paper-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .paper-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .paper-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            font-size: 14px;
            color: #666;
        }

        .paper-meta i {
            color: #e74c3c;
            margin-right: 4px;
        }

        .paper-right {
            display: flex;
            text-align: right;
            flex-direction: column;
            gap: 10px;
        }

        .paper-price {
            font-size: 20px;
            font-weight: 600;
            color: #e74c3c;
            margin-bottom: 8px;
        }

        .attempt-btn {
            background: #e74c3c;
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            text-decoration: none;
        }

        .attempt-btn:hover {
            background: #c0392b;
            color: #fff;
        }

        .form-check-label {
            font-size: 16px;
            font-weight: 500;
        }
    </style>

@endsection


@section('content')

    <body class="hidden-bar-wrapper">


        <section class="page-title bg-card text-white py-5">
            <div class="container text-center">
                <h2 class="display-5 fw-bold text-center" style="width:70%; margin:auto;">Adhyayanam</h2>
                <ul class="breadcrumb justify-content-center mt-3 mb-0">
                    <li class="breadcrumb-item"><a href="/" class="text-dark text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="/" class="text-dark text-decoration-none">PYQ Papers</a></li>

                </ul>
            </div>
        </section>



        <section class="course-page-section-two py-4">

            <div class="auto-container">





                <div class="smaterial-boxs">
                    <div class="content">

                        <h3 class="osd sm">
                            Previous Year Question Papers (PYQ)
                        </h3>

                        <!--<div class="text-justify">-->

                        <!--    <p>-->
                        <!--        Previous Year Question Papers (PYQ) are one of the most effective resources for exam preparation.-->
                        <!--        By practicing PYQ papers, students can understand the exam pattern, question types, and difficulty level.-->
                        <!--    </p>-->

                        <!--    <p>-->
                        <!--        These papers help candidates analyze important topics that are frequently asked in competitive exams-->
                        <!--        such as SSC, Railway, Banking, and other government exams.-->
                        <!--    </p>-->

                        <!--    <p>-->
                        <!--        Attempt the PYQ tests below to evaluate your preparation, improve your speed and accuracy,-->
                        <!--        and get familiar with the real exam environment.-->
                        <!--    </p>-->

                        <!--</div>-->

                    </div>

                </div>



                <div class="row mt-4">

                    {{-- LEFT YEAR FILTER --}}

                    <div class="col-md-3">

                        <div class="filter-box">

                            <h5 class="filter-title">
                                Filter By Year
                            </h5>

                            {{-- SEARCH BOX --}}
                            <div class="mb-3">

                                <input type="text" class="form-control" id="yearSearch" placeholder="Search Year...">

                            </div>

                            @php
                                $years = $papers->pluck('previous_year')->unique()->sortDesc();
                            @endphp

                            <div id="yearList">

                                @foreach($years as $year)

                                    <div class="form-check mb-2 year-item">

                                        <input class="form-check-input year-filter" type="checkbox" value="{{$year}}"
                                            id="year{{$year}}">

                                        <label class="form-check-label" for="year{{$year}}">
                                            {{$year}}
                                        </label>

                                    </div>

                                @endforeach

                            </div>

                        </div>


                    </div>



                    {{-- RIGHT PAPER CARDS --}}

                    <div class="col-md-9">

                        <div class="paper-container">

                            @forelse($papers as $paper)

                                <div class="paper-card" data-year="{{$paper->previous_year}}">

                                    <div class="paper-left">

                                        <h4 class="paper-title">
                                            {{$paper->name}}
                                        </h4>


                                        <div class="paper-meta">

                                            <span>
                                                <i class="fa fa-calendar"></i>
                                                {{$paper->previous_year}}
                                            </span>

                                            <span>
                                                <i class="fa fa-question-circle"></i>
                                                {{$paper->total_questions}} Questions
                                            </span>

                                            <span>
                                                <i class="fa fa-clock"></i>
                                                {{$paper->duration}} Min
                                            </span>

                                            <span>
                                                <i class="fa fa-file"></i>
                                                {{$paper->total_marks}} Marks
                                            </span>

                                            <span>
                                                <i class="fa fa-language"></i>
                                                {{$paper->language == '1' ? 'Hindi' : 'English'}}
                                            </span>

                                        </div>

                                    </div>



                                    <div class="paper-right">

                                        @if($paper->test_type == 'paid')

                                            <div class="paper-price ">
                                                ₹{{$paper->offer_price}}
                                            </div>

                                        @endif


                                        @auth
    <a href="{{ route('test.instruction', base64_encode($paper->id)) }}" class="attempt-btn">
        Attempt Now
    </a>
@else
    <a href="{{ route('student.login') }}" class="attempt-btn">
        Login to Attempt
    </a>
@endauth

                                    </div>

                                </div>

                            @empty

                                <div class="text-center">
                                    <p>No papers available</p>
                                </div>

                            @endforelse

                        </div>

                    </div>

                </div>



            </div>

        </section>



        <script>

            $(".year-filter").change(function () {

                var selected = [];

                $(".year-filter:checked").each(function () {
                    selected.push($(this).val());
                });


                if (selected.length == 0) {

                    $(".paper-card").show();

                    return;

                }


                $(".paper-card").hide();


                selected.forEach(function (year) {

                    $('.paper-card[data-year="' + year + '"]').show();

                });


            });

        </script>
        <script>

            $("#yearSearch").on("keyup", function () {

                var value = $(this).val().toLowerCase();

                $("#yearList .year-item").filter(function () {

                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)

                });

            });


        </script>

    </body>

@endsection