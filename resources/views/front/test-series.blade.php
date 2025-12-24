@extends('front.partials.app')
@section('header')
  <title>{{ 'Test Series' }}</title>
  <meta name="description" content="{{ $seo->description ?? 'Default Description' }}">
  <meta name="keywords" content="{{ $seo->keywords ?? 'default, keywords' }}">
  <link rel="canonical" href="{{ $seo->canonical ?? url()->current() }}">
@endsection
@section('content')

  <body class="hidden-bar-wrapper">
    <!-- Page Title -->
    <section class="page-title">
      <div class="auto-container">
        <h2>Adhyayanam</h2>
        <ul class="bread-crumb clearfix">
          <li><a href="{{url('/')}}">Home</a></li>
          <li>Test Series</li>
        </ul>
      </div>
    </section>
    <!-- End Page Title -->
    <section class="course-page-section-two">
      <div class="auto-container">
        <div class="row clearfix">

          <!-- Sidebar Column -->
          <!-- ================= SIDEBAR ================= -->
          <div class="sidebar-column col-lg-3 col-md-8 col-sm-12">

            <form method="GET" action="{{ route('test-series', [
    request()->route('examid'),
    request()->route('catid'),
    request()->route('subcat')
  ]) }}">

              <!-- 🔍 SEARCH -->
              <div class="sidebar-widget search-box">
                <div class="widget-content">
                  <div class="form-group">
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Search Test Series">
                    <button type="submit">
                      <span class="icon fa fa-search"></span>
                    </button>
                  </div>
                </div>
              </div>

              <!-- 🎯 FILTERS -->
              <div class="sidebar-widget category-widget">
                <div class="widget-content">

                  <div class="sidebar-title">
                    <h5>Filter Test Series</h5>
                  </div>

                  {{-- SUBJECT --}}
                  <select name="subject_id" class="form-control mb-2">
                    <option value="">Select Subject</option>
                    @foreach($subjects as $subject)
                      <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                      </option>
                    @endforeach
                  </select>

                  {{-- CHAPTER --}}
                  <select name="chapter_id" class="form-control mb-2">
                    <option value="">Select Chapter</option>
                    @foreach($chapters as $chapter)
                      <option value="{{ $chapter->id }}" {{ request('chapter_id') == $chapter->id ? 'selected' : '' }}>
                        {{ $chapter->name }}
                      </option>
                    @endforeach
                  </select>

                  {{-- TOPIC --}}
                  <select name="topic_id" class="form-control mb-3">
                    <option value="">Select Topic</option>
                    @foreach($topics as $topic)
                      <option value="{{ $topic->id }}" {{ request('topic_id') == $topic->id ? 'selected' : '' }}>
                        {{ $topic->name }}
                      </option>
                    @endforeach
                  </select>

                  <button class="btn btn-primary w-100">Apply Filters</button>

                  @if(request()->hasAny(['search', 'subject_id', 'chapter_id', 'topic_id']))
                                  <a href="{{ route('test-series', [
                      request()->route('examid'),
                      request()->route('catid'),
                      request()->route('subcat')
                    ]) }}" class="btn btn-light w-100 mt-2">
                                    Clear Filters
                                  </a>
                  @endif

                </div>
              </div>

            </form>
          </div>

          <!-- Blocks Column -->
          <div class="blocks-column col-lg-9 col-md-12 col-sm-12">

            <!-- Filter Box -->
            <div class="filter-box">
              <div class="d-flex justify-content-between align-items-center flex-wrap">
                <!-- Left Box -->
                <div class="left-box d-flex align-items-center">
                  <div class="results">Showing 1–10 of {{count($testPackages)}} results</div>
                </div>
                <!-- Right Box -->
                <!--div class="right-box d-flex align-items-center">
                    <div class="form-group">
                      <select name="currency" class="">
                        <option>Recently Added</option>
                        <option>Added 01</option>
                        <option>Added 02</option>
                        <option>Added 03</option>
                        <option>Added 04</option>
                      </select>
                    </div>
                  </div-->
              </div>
            </div>
            <!-- End Filter Box -->

            <div class="row clearfix">
              @foreach($testPackages as $testPackage)
                <div class="course-block-two style-two col-xl-4 col-lg-6 col-md-6 col-sm-12">
                  <div class="inner-box">
                    <div class="image osd-f">
                      <a href="test-series-detail.html"><img src="{{asset('storage/' . $testPackage->logo)}}" alt=""></a>
                      <div class="user-r"><span>3.45k Users</span></div>
                    </div>
                    <div class="lower-content osdc">
                      <div class="content">

                        <h4><a href="test-serie-detail.html"> {{$testPackage->title}} </a></h4>
                        <div class="number-of-test">{{count($testPackage->testseries)}} Test <span class="green-free">|
                            @if($testPackage->fee_type == 'paid') Premium @else Free @endif</span></div>
                        <div class="contents">
                          <ul class="lstyle">
                            <li>{{$testPackage->testseries->where('type_name', 'Chapter Test')->count()}} Chapter Test</li>
                            <li>{{$testPackage->testseries->where('type_name', 'Current Affairs')->count()}} Current Affairs
                            </li>
                            <li>{{$testPackage->testseries->where('type_name', 'Subject Wise')->count()}} Subject Test</li>
                            <li>{{$testPackage->testseries->where('type_name', 'Topic Wise')->count()}} Topic Test</li>
                            <li>+{{$testPackage->testseries->where('type_name', 'Full Test')->count()}} more tests</li>
                          </ul>
                        </div>
                      </div>
                      <div class="bottom-btn">
                        <a class="course-btn osd" href="{{route('test-series-detail', $testPackage->slug)}}">View Test
                          Series</a>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach


            </div>

            <!-- Styled Pagination -->
            {{$testPackages->links()}}
            <!-- End Styled Pagination -->

          </div>

        </div>

      </div>
    </section>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('input[type="radio"][name="category_id"]');
        const form = document.getElementById('filterForm');

        radios.forEach(radio => {
          radio.addEventListener('change', function () {
            form.submit();
          });
        });
      });
    </script>


  </body>
@endsection