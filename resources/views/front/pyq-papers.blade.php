@extends('front.partials.app')
@section('header')
    <title>{{ 'PYQ Papers' }}</title>
    <meta name="description" content="{{ $seo->description ?? 'Default Description' }}">
    <meta name="keywords" content="{{ $seo->keywords ?? 'default, keywords' }}">
    <link rel="canonical" href="{{ $seo->canonical ?? url()->current() }}">
@endsection

@section('content')

    <body class="hidden-bar-wrapper">

        <section class="page-title">
            <div class="auto-container">
                <h2>Adhyayanam</h2>
                <ul class="bread-crumb clearfix">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>PYQ Papers</li>
                </ul>
            </div>
        </section>

        <section class="course-page-section-two py-4">
            <div class="auto-container">

                <div class="top-banner-sm">
                    <div class="image">
                        <img src="{{url('images/main-slider/slider2.png')}}" alt="">
                    </div>
                </div>

                <div class="smaterial-boxs">
                    <div class="content">
                        <h3 class="osd sm">{{ $pyq_content->heading ?? "" }}</h3>
                        <div class="text-justify">{!! $pyq_content->detail_content ?? "" !!}</div>
                    </div>
                </div>

                {{-- Subjects --}}
                @if(isset($subjects) && count($subjects) > 0)
                    <div class="smaterial-box">
                        <div class="content">
                            <h4 class="osd sm">{{ $subcat->name }} Subjectwise Previous Year Questions</h4>
                            <div class="row">
                                @foreach($subjects as $subject)
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <div class="cm-all">
                                            <a href="{{route('subject-pyqs', $subject->id)}}">{{ $subject->name }} PYQ </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Test Paper Cards --}}
                <div class="row g-4 mt-4">
                    @forelse($papers as $paper)
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 rounded-3"
                                style="background: {{ $loop->odd ? '#f5f5f9' : '#f9f6f0' }};">
                                <div class="card-body p-4 position-relative">
                                    <div class="badge bg-success position-absolute top-0 start-0 mt-2 ms-2">
                                        {{ $paper->test_type == 'paid' ? 'Paid' : 'Free' }}</div>

                                    <h5 class="fw-bold mb-1">{{ $paper->name }}</h5>
                                    <small class="text-muted d-block mb-3">Year: {{ $paper->previous_year }}</small>

                                    <div class="d-flex flex-wrap mb-3 text-secondary" style="font-size:14px;">
                                        <div class="me-3"><i
                                                class="fa-solid fa-circle-question"></i>{{ $paper->total_questions }} Questions
                                        </div>
                                        <div class="me-3"><i class="fa-regular fa-clock"></i> {{ $paper->duration }} Min</div>
                                        <div><i class="fa-regular fa-file-lines"></i> {{ $paper->total_marks }} Marks</div>
                                    </div>

                                    <div class="d-flex flex-wrap align-items-center justify-content-between border-top pt-2 text-secondary"
                                        style="font-size:13px;">
                                        <div>
                                            <i class="fa-solid fa-language me-1"></i>
                                            {{ $paper->language == '1' ? 'Hindi' : 'English' }}
                                            <span class="mx-2">|</span>
                                            <i class="fa-solid fa-laptop-file me-1"></i> Live Test
                                            <span class="mx-2">|</span>
                                            <i class="fa-regular fa-clipboard me-1"></i>{{$paper->test_paper_type ?? ""}}
                                            Question
                                        </div>
                                        <div class="text-end">
                                            @if($paper->test_type == 'paid' )
                                            <h5 class="text-danger mb-1">₹{{ $paper->offer_price }}</h5>
                                            @endif
                                            <a href="#" class="btn btn-danger btn-sm rounded-2 px-3">Attempt Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">No test papers available.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </section>

        <script>
            $(".showanswer").click(function () {
                var data = $(this).data("answer");
                $(`#${data}`).toggle();
            });
        </script>

    </body>
@endsection