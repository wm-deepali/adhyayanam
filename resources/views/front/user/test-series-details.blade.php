@extends('front.partials.app')
<!-- Free version (yeh use kar rahe ho toh fa-file-pdf nahi milega) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<!-- Agar pro version use kar rahe ho toh yeh link hona chahiye -->
<link rel="stylesheet" href="https://kit.fontawesome.com/your-kit-code.js">
@section('content')

    <style>
        /* container */

        .ts-container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
        }

        /* ---------------- BANNER ---------------- */

        .ts-banner {
            background: linear-gradient(135deg, #eef2ff, #f7f9ff);
            padding: 50px 0 90px 0;
            position: relative;
            overflow: visible;
        }

        .ts-banner-content {
            max-width: 700px;
        }

        .ts-banner h1 {
            font-size: 40px;
            font-weight: 700;
            margin-bottom: -15px;
            margin-top: -20px;
        }

        .ts-banner p {
            color: #555;
            line-height: 1.6;
        }

        /* stats */

        .ts-stats {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .ts-stat {
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            font-weight: 600;
        }

        /* ---------------- PRICE CARD ---------------- */

        .price-card {
            padding: 12px;
            position: absolute;
            right: 120px;
            top: 50px;
            width: 360px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }



        .price-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .price-content {
            padding: 12px 0px;
            text-align: center;
        }

        .price {
            font-size: 32px;
            font-weight: 700;
            color: #045279;
        }

        .old {
            text-decoration: line-through;
            color: #999;
            font-size: 16px;
            margin-left: 8px;
        }

        .discount {
            color: #ff3b3b;
            margin: 8px 0;
        }

        .buy-btn {
            background: linear-gradient(135deg, #045279, #7a8dff);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        /* ---------------- TOPIC BUTTON CARDS ---------------- */

        .topics-wrapper {
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            margin-top: 70px;
        }

        .topics-wrapper h2 {
            margin-bottom: 25px;
        }

        .topics-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .topic-btn {
            display: flex;
            align-items: center;
            gap: 15px;
            background: #f7f9ff;
            border: none;
            padding: 18px;
            border-radius: 12px;
            text-align: left;
            cursor: pointer;
            transition: .3s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .topic-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
        }

        .topic-icon {
            font-size: 28px;
            background: #eef2ff;
            padding: 10px;
            border-radius: 10px;
        }

        .topic-content h4 {
            margin: 0;
            font-size: 17px;
        }

        .topic-content p {
            margin: 3px 0;
            font-size: 13px;
            color: #666;
        }

        .topic-content span {
            font-size: 12px;
            font-weight: 600;
            color: #045279;
        }

        /* different colors */

        .c1 {
            background: linear-gradient(135deg, #5f7cff, #7fa4ff);
        }

        .c2 {
            background: linear-gradient(135deg, #ff7c7c, #ff9f9f);
        }

        .c3 {
            background: linear-gradient(135deg, #2dd4bf, #5eead4);
        }

        .c4 {
            background: linear-gradient(135deg, #fbbf24, #fcd34d);
        }

        .c5 {
            background: linear-gradient(135deg, #a78bfa, #c4b5fd);
        }

        /* ---------------- FEATURE CARD ---------------- */

        .feature-card {
            margin-top: 70px;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .feature-grid div {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .feature-grid i {
            color: #045279;
        }

        /* ---------------- NOTES ---------------- */

        .notes-card {
            background: white;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            margin: 50px 0;

        }

        .notes-card h3 {
            margin-bottom: 10px;
        }

        .notes-card hr {
            border: none;
            height: 1px;
            background: #eee;
            margin-bottom: 20px;
        }

        .notes-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .notes-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 12px;
            color: #444;
        }

        .notes-list span {
            color: #045279;
            font-weight: 700;
        }


        /* ---------------- TERMS ---------------- */

        .terms {
            margin-top: 30px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        /* breadcrumb */

        .ts-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            margin: 10px 0 0px 0;
            font-size: 14px;
        }

        .ts-breadcrumb a {
            color: #045279;
            text-decoration: none;
            font-weight: 500;
        }

        .ts-breadcrumb a:hover {
            text-decoration: underline;
        }

        .arrow {
            color: #888;
            font-size: 16px;
            margin: 0 3px;
        }

        .current {
            color: #555;
            font-weight: 600;
        }


        /* details section */

        .details-card {
            margin-top: 70px;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .details-desc {
            margin-top: 10px;
            color: #555;
            line-height: 1.6;
            max-width: 800px;
        }

        .details-points {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 25px;
        }

        .detail-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            border: none;
            background: #f7f9ff;
            padding: 14px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: .3s;
        }

        .detail-btn i {
            color: #045279;
        }

        .detail-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .test-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .test-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            transition: all 0.2s ease;
        }

        .test-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .test-info h3 {
            margin: 0 0 8px 0;
            font-size: 1.1rem;
            color: #222;
        }

        .test-meta {
            display: flex;
            gap: 16px;
            font-size: 0.9rem;
            color: #666;
        }

        .unlock-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: #6366f1;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .unlock-btn:hover {
            background: #4f46e5;
            transform: scale(1.04);
        }

        .unlock-btn svg {
            stroke: white;
        }

        .test-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .test-tab {
            border: none;
            background: #f1f5ff;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .test-tab.active {
            background: #6366f1;
            color: white;
        }
        
        .price-card {
    padding: 12px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    overflow: hidden;

    /* Default: mobile-friendly (non-absolute, centered) */
    position: static;          /* ya static bhi chalega */
    width: 90%;
    max-width: 400px;            /* optional: bahut bada na ho mobile pe */
    margin: 22px auto 0;         /* top margin + horizontal center */
}

/* Desktop / large screen pe absolute positioning apply karo */
@media (min-width: 992px) {     /* lg breakpoint (Bootstrap default) */
    .price-card {
        position: absolute;
        right: 120px;
        top: 50px;
        width: 360px;               /* ya jo bhi desktop pe chahiye */
        margin: 0;                  /* mobile wala margin hata do */
        /* agar parent ke relative hone ki zarurat ho to parent pe position: relative; daal dena */
    }
}

.mobile-price-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: #fff;
    padding: 10px 15px;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 999;
}

.price-left strong {
    font-size: 18px;
    font-weight: bold;
}

.price-left .old {
    text-decoration: line-through;
    font-size: 13px;
    margin-left: 5px;
    color: #888;
}

.price-right .buy-btn {
    padding: 8px 16px;
    font-size: 14px;
}


@media (max-width: 540px) { 
    .topics-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 12px;
}
.topics-wrapper {
    background: white;
    padding: 13px;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    margin-top: 30px;
}
.topic-btn {
    display: flex;
    align-items: center;
    gap: 11px;
    background: #f7f9ff;
    border: none;
    padding: 8px;
    border-radius: 12px;
    text-align: left;
    cursor: pointer;
    transition: .3s;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
}
.topics-wrapper h2 {
    margin-bottom: 15px;
    font-size: 20px;
}
.topic-content h4 {
    margin: 0;
    font-size: 15px;
}
.details-card {
    margin-top: 30px;
    background: white;
    padding: 15px;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}
.details-points {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 10px;
    margin-top: 25px;
}
.details-card h2{
   margin-bottom: 15px;
    font-size: 20px; 
}
.test-item {
    display: flex;
    flex-direction: column;
    align-items: start;
    justify-content: space-between;
    padding: 10px 10px;
    border-radius: 10px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    transition: all 0.2s ease;
}
.unlock-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 5px 15px;
    background: #6366f1;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    margin-top: 10px;
}
.feature-card {
    margin-top: 30px;
    background: white;
    padding: 15px;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}
.feature-card h2{
     margin-bottom: 15px;
    font-size: 20px; 
}
   .notes-card {
    background: white;
    padding: 15px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    margin: 30px 0;
}
.ts-banner {
    background: linear-gradient(135deg, #eef2ff, #f7f9ff);
    padding: 10px 0 90px 0;
    position: relative;
    overflow: visible;
}
.ts-banner h1 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: -15px;
     margin-top: 0px; 
}
.ts-breadcrumb {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0px;
    margin: 10px 0 12px 0;
    font-size: 12px;
}
.ts-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-top: 15px;
    flex-wrap: wrap;
}
.wd-social-icons{
    display:none !important;
}
    
}
    </style>


    <!-- BANNER -->

    <section class="ts-banner">

        <div class="ts-container">

            <div class="ts-banner-content">
                <div class="ts-breadcrumb">

                    <a href="{{ url('/') }}">Home</a>

                    @if($testseries->commission)
                        <span class="arrow">›</span>
                        <a href="#">{{ $testseries->commission->name }}</a>
                    @endif

                    @if($testseries->category)
                        <span class="arrow">›</span>
                        <a href="#">{{ $testseries->category->name }}</a>
                    @endif

                    <span class="arrow">›</span>
                    <span class="current">{{ $testseries->title }}</span>

                </div>

                <h1>{{ $testseries->title }}</h1>

                <p>
                    {!! $testseries->short_description !!}
                </p>

                <div class="ts-stats">

                    <div class="ts-stat">
                        {{ $testseries->tests->sum('total_questions') }}+ Questions
                    </div>


                    <div class="ts-stat">
                        {{ $testseries->testseries->count() }} Mock Tests
                    </div>

                    <div class="ts-stat">
                        {{ number_format($testseries->orders_count ?? 0) }} Students
                    </div>

                    <div class="ts-stat">
                        {{ $testseries->validity }} Days Validity
                    </div>
                </div>


            </div>

        </div>


        <!-- PRICE CARD -->

        <div class="price-card">

            <img src="{{ asset('storage/' . $testseries->logo) }}">

            <div class="price-content">

                <div class="price">

                {{ $testseries->fee_type == 'paid' ? '₹'.$testseries->price : 'Free' }}

                    @if($testseries->mrp)
                        <span class="old">₹{{ $testseries->mrp }}</span>
                    @endif

                </div>
                @if($testseries->mrp > $testseries->price)
                    <p class="discount">
                        {{ round((($testseries->mrp - $testseries->price) / $testseries->mrp) * 100) }}% Limited Offer
                    </p>
                @endif
                @if(auth()->user() && auth()->user()->type == 'student')

                    @php
                        $user_id = auth()->user()->id;
                        $package_id = $testseries->id;
                        $type = 'Test Series';
                        $checkExist = Helper::GetStudentOrder($type, $package_id, $user_id);
                    @endphp

                    @if(!$checkExist)

                        <a href="{{route('user.process-order', ['type' => 'test-series', 'id' => $testseries->id])}}">
                            <button class="buy-btn">Enroll Now</button>
                        </a>

                    @else

                        <button class="buy-btn" disabled>Already Enrolled</button>

                    @endif

                @else
                    <a href="{{route('student.login')}}">
                        <button class="buy-btn">
                            Enroll Now
                        </button>
                    </a>
                @endif

                <p style="margin-top:10px;font-size:13px;">
                    Validity : {{ $testseries->validity }} Days
                </p>

            </div>

        </div>
        <div class="mobile-price-bar d-md-none">

    <div class="price-left">
        <strong>
            {{ $testseries->fee_type == 'paid' ? '₹'.$testseries->price : 'Free' }}
        </strong>

        @if($testseries->mrp)
            <span class="old">₹{{ $testseries->mrp }}</span>
        @endif
    </div>

    <div class="price-right">
        @if(auth()->user() && auth()->user()->type == 'student')

            @php
                $user_id = auth()->user()->id;
                $package_id = $testseries->id;
                $type = 'Test Series';
                $checkExist = Helper::GetStudentOrder($type, $package_id, $user_id);
            @endphp

            @if(!$checkExist)
                <a href="{{route('user.process-order', ['type' => 'test-series', 'id' => $testseries->id])}}">
                    <button class="buy-btn">Enroll Now</button>
                </a>
            @else
                <button class="buy-btn" disabled>Enrolled</button>
            @endif

        @else
            <a href="{{route('student.login')}}">
                <button class="buy-btn">Enroll Now</button>
            </a>
        @endif
    </div>

</div>


    </section>


    <!-- TOPICS -->

    @php
        $type = $testseries->testseries->first()->type ?? null;

        if ($type == 2) {
            $heading = "Subjects Covered";
        } elseif ($type == 3) {
            $heading = "Chapters Covered";
        } elseif ($type == 4) {
            $heading = "Topics Covered";
        } else {
            $heading = "Test Coverage";
        }
    @endphp



    <section class="ts-container topic-section">

        <div class="topics-wrapper">

            <h2>{{ $heading }}</h2>

            <div class="topics-grid">

                @foreach($testseries->tests->groupBy(
                        $type == 2 ? 'subject_id' : ($type == 3 ? 'chapter_id' : 'topic_id')
                    ) as $key => $tests)
                        @php
                            $test = $tests->first();

                            if ($type == 2) {
                                $name = $test->subject->name ?? 'General';
                            } elseif ($type == 3) {
                                $name = $test->chapter->name ?? 'Chapter';
                            } elseif ($type == 4) {
                                $name = $test->topic->name ?? 'Topic';
                            } else {
                                $name = 'General';
                            }
                        @endphp 
                    <button class="topic-btn">

                        <div class="topic-icon">📘</div>

                        <div class="topic-content">

                            <h4>{{ $name }}</h4>

                            <p>{{ $tests->count() }} Tests</p>

                            <span>{{ $tests->sum('total_questions') }} Questions</span>

                        </div>

                        </button>

                @endforeach

            </div>

        </div>

    </section>



    <section class="ts-container">

        <div class="details-card">

            <h2>Test Series Overview</h2>

            {{-- OVERVIEW --}}
            <p class="details-desc">
                {!! $testseries->overview ?? $testseries->description !!}
            </p>
            @php
                $types = $testseries->testseries->groupBy('type');

                $typeNames = [
                    1 => 'Full Length Tests',
                    2 => 'Subject Wise Tests',
                    3 => 'Chapter Wise Tests',
                    4 => 'Topic Wise Practice',
                    5 => 'Current Affairs Tests',
                    6 => 'Previous Year Papers'
                ];

                $icons = [
                    1 => 'fa-file-lines',
                    2 => 'fa-layer-group',
                    3 => 'fa-book',
                    4 => 'fa-list',
                    5 => 'fa-newspaper',
                    6 => 'fa-history'
                ];
            @endphp

            <div class="details-points">

                {{-- DYNAMIC TYPES --}}
                @foreach($types as $type => $items)
                    <button class="detail-btn">
                        <i class="fa-solid {{ $icons[$type] ?? 'fa-file' }}"></i>
                        <span>
                            {{ $items->count() }} {{ $typeNames[$type] ?? 'Tests' }}
                        </span>

                    </button>

                @endforeach

                {{-- VALIDITY --}}
                <button class="detail-btn">
                    <i class="fa-solid fa-clock"></i>
                    <span>{{ $testseries->validity }} Days Validity</span>
                </button>

                {{-- PERFORMANCE --}}
                <button class="detail-btn">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Performance Analytics</span>
                </button>

                {{-- MOBILE --}}
                <button class="detail-btn">
                    <i class="fa-solid fa-mobile-screen"></i>
                    <span>Mobile Friendly</span>
                </button>

            </div>

        </div>

    </section>

    <section class="ts-container">
        <div class="details-card">
            <h2 style="margin-bottom:10px">Test Papers</h2>
            @php
                $typeNames = [
                    1 => 'Full Test',
                    2 => 'Subject Wise',
                    3 => 'Chapter Wise',
                    4 => 'Topic Wise',
                    5 => 'Current Affairs',
                    6 => 'PYQ'
                ];

                $groupedTests = $testseries->testseries->groupBy('type');
            @endphp

            <div class="test-tabs">

                @foreach($groupedTests as $type => $items)

                    <button class="test-tab {{ $loop->first ? 'active' : '' }}" data-type="type-{{ $type }}">
                        {{ $typeNames[$type] ?? 'Tests' }}
                        ({{ $items->count() }})

                    </button>

                @endforeach

            </div>
            <!-- Test papers list -->
            <div class="test-list">

                @foreach($testseries->testseries as $detail)
                    @php
                        $test = $detail->test;
                    @endphp
                    <div class="test-item test-card type-{{ $detail->type }}"
                        style="background: linear-gradient(90deg,#e6f3ff,#f0f9ff);">

                        <div class="test-info">

                            <h3>{{ $test->name }}</h3>

                            <div class="test-meta">

                                <span>{{ $test->total_questions }} Questions</span>

                                <span>{{ $test->total_marks }} Marks</span>

                                <span>{{ $test->duration }} Min</span>

                            </div>

                        </div>

                        @php
$student = auth()->user();
@endphp

@if($test->test_type == 'free')

  <a href="{{ route('test.instruction', base64_encode($test->id)) }}" class="unlock-btn">
                Attempt Test
            </a>

@else

    @if($student && $student->type == 'student')

        @php
            $checkExist = Helper::GetStudentOrder('Test Series', $testseries->id, $student->id);
        @endphp

        @if($checkExist)

            <a href="{{ route('test.instruction', base64_encode($test->id)) }}" class="unlock-btn">
                Attempt Test
            </a>

        @else

            <a href="{{ route('user.process-order', ['type' => 'test-series', 'id' => $testseries->id]) }}" class="unlock-btn">
                <i class="fa fa-lock"></i>
                Unlock
            </a>

        @endif

    @else

        <a href="{{ route('student.login') }}" class="unlock-btn">
            <i class="fa fa-lock"></i>
            Unlock
        </a>

    @endif

@endif

                    </div>

                @endforeach

            </div>
        </div>
    </section>




    <!-- FEATURES -->

    <section class="ts-container">

        <div class="feature-card">

            <h2>Key Features</h2>

            <div class="feature-grid">

                @if(!empty($testseries->key_features))

                    @foreach(json_decode($testseries->key_features ?? '[]') as $feature)
                        <div>
                            <i class="fa-solid fa-check"></i> {{ $feature }}
                        </div>

                    @endforeach

                @else

                    <div>No features available</div>

                @endif

            </div>

        </div>

    </section>


    <!-- description -->

    <section class="ts-container">

        <div class="notes-card">

            <h2>Test Series Description</h2>

            {{-- OVERVIEW --}}
            <p class="details-desc">
                {!! $testseries->description !!}
            </p>



        </div>

    </section>


    <script>

        document.querySelectorAll(".test-tab").forEach(tab => {

            tab.addEventListener("click", function () {

                document.querySelectorAll(".test-tab").forEach(t => t.classList.remove("active"));
                this.classList.add("active");

                let type = this.dataset.type;

                document.querySelectorAll(".test-card").forEach(card => {

                    card.style.display = "none";

                    if (card.classList.contains(type)) {
                        card.style.display = "flex";
                    }

                });

            });

        });

        // show first tab initially
        document.querySelector(".test-tab.active")?.click();

    </script>


@endsection