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
        <div class="sidebar-column col-lg-3 col-md-8 col-sm-12">

          <!-- Search Widget -->
          <div class="sidebar-widget search-box">
            <div class="widget-content">
            <form method="post" action="{{ route('test-series.search') }}" id="searchForm">
              @csrf
                <div class="form-group">
                  <input type="search" name="search_field" value="{{ isset($search) && $search !='' ? $search : ''}}" placeholder="Search" required="" >
                  <button type="submit"><span class="icon fa fa-search"></span></button>
                </div>
              </form>
            </div>
          </div>

          <!-- Category Widget -->
          <div class="sidebar-widget category-widget">
            <div class="widget-content">
              <!-- Sidebar Title -->
              <div class="sidebar-title">
                <h5>Test Series Categories</h5>
              </div>

              <!-- Brands List -->
              <div class="brands-list">
              <form method="post" action="{{ route('test-series.filter') }}" id="filterForm">
                    @csrf
                    @foreach($categories as $category)
                        <div class="form-group">
                            <div class="check-box">
                                <input type="radio" name="category_id" id="category-{{ $category->id }}" 
                                {{ isset($filter_selected) && $filter_selected == $category->id ? 'checked' : '' }} value="{{ $category->id }}">
                                <label for="category-{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                        </div>
                    @endforeach
                </form>
                
              </div>

            </div>
          </div>

        </div>

        <!-- Blocks Column -->
        <div class="blocks-column col-lg-9 col-md-12 col-sm-12">

          <!-- Filter Box -->
          <div class="filter-box">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
              <!-- Left Box -->
              <div class="left-box d-flex align-items-center">
                <div class="results">Showing 1–10 of {{count($testseries)}} results</div>
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
            @foreach($testseries as $testseriess)
            <div class="course-block-two style-two col-xl-4 col-lg-6 col-md-6 col-sm-12">
              <div class="inner-box">
                <div class="image osd-f">
                  <a href="test-series-detail.html"><img src="{{asset('storage/'.$testseriess->logo)}}" alt=""></a>
                  <div class="user-r"><span>3.45k Users</span></div>
                </div>
                <div class="lower-content osdc">
                  <div class="content">

                    <h4><a href="test-serie-detail.html"> {{$testseriess->title}} </a></h4>
                    <div class="number-of-test">{{count($testseriess->testseries)}} Test <span class="green-free">| @if($testseriess->fee_type == 'paid') Premium @else Free @endif</span></div>
                    <div class="contents">
                      <ul class="lstyle">
                        <li>{{$testseriess->testseries->where('type_name','Chapter Test')->count()}} Chapter Test</li>
                        <li>{{$testseriess->testseries->where('type_name','Current Affairs')->count()}} Current Affairs</li>
                        <li>{{$testseriess->testseries->where('type_name','Subject Wise')->count()}} Subject Test</li>
                        <li>{{$testseriess->testseries->where('type_name','Topic Wise')->count()}} Topic Test</li>
                        <li>+{{$testseriess->testseries->where('type_name','Full Test')->count()}} more tests</li>
                      </ul>
                    </div>
                  </div>
                  <div class="bottom-btn">
                    <a class="course-btn osd" href="{{route('test-series-detail',$testseriess->slug)}}">View Test Series</a>
                  </div>
                </div>
              </div>
            </div>
            @endforeach


          </div>

          <!-- Styled Pagination -->
         {{$testseries->links()}}
          <!-- End Styled Pagination -->

        </div>

      </div>

    </div>
  </section>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('input[type="radio"][name="category_id"]');
        const form = document.getElementById('filterForm');
  
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                form.submit();
            });
        });
    });
  </script>
 

</body>
@endsection