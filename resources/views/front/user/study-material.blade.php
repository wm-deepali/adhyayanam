@extends('front.partials.app')
@section('header')
	  <title>Study Material View All</title>
@endsection
@section('content')
<body class="hidden-bar-wrapper">
  <!-- Page Title -->
  <section class="page-title">
    <div class="auto-container">
      <h2>Adhyayanam</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="{{url('/')}}">Home</a></li>
        <li>Study Materials</li>
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
              <form method="post" action="{{ route('study.material.search') }}" id="searchForm">
              @csrf
                <div class="form-group">
                  <input type="search" name="search_field" value="{{ isset($search) && $search !='' ? $search : ''}}" placeholder="Search" required="" >
                  <button type="submit"><span class="icon fa fa-search"></span></button>
                </div>
              </form>
            </div>
          </div>

          <div class="sidebar-widget category-widget">
            <div class="widget-content">
              <!-- Sidebar Title -->
              <div class="sidebar-title">
                <h5>Study Materials</h5>
              </div>

              <!-- Brands List -->
              <div class="brands-list">
                <form method="post" action="{{ route('study.material.filter') }}" id="filterForm">
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
                <div class="results">Showing 1 - 12 of 54 results</div>
              </div>
              <!-- Right Box -->
              <div class="right-box d-flex align-items-center">
                <div class="form-group">
                  <select name="currency" class="">
                    <option>Recently Added</option>
                    <option>Added 01</option>
                    <option>Added 02</option>
                    <option>Added 03</option>
                    <option>Added 04</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <!-- End Filter Box -->

          <div class="row clearfix">
            <!-- SM Block Five -->
            @foreach($topics as $data)
            <div class="course-block-five col-lg-4 col-md-6 col-sm-12">
              <div class="inner-box">
                <div class="content">
                  <h4 class="osd sm">{{$data->name}}</h4>
                  @if($data->studyMaterials)
                  @foreach($data->studyMaterials as $material)
                  <ul class="sm-list">
                    <li><a href="{{route('study.material.details',$material->id)}}">{{$material->title}}</a>
                      @if($material->IsPaid)
                      <div class="osd-label paid">Paid</div>
                      @endif</li>
                  </ul>
                  @endforeach
                  @endif
                </div>
                <a class="course-btn" href="{{route('study.material.topics',$data->id)}}">View all topics <span
                  class="flaticon-arrow-pointing-to-right"></span></a>
              </div>
            </div>
            @endforeach

          </div>

          <!-- Styled Pagination -->
          <ul class="styled-pagination">
            <li><a href="#" class="active">1</a></li>
            <li class="next"><a href="#"><span class="flaticon-arrow-pointing-to-right"></span></a></li>
          </ul>
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