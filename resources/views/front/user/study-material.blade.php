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
                <form method="GET"
                  action="{{ route('study.material.front', ['examid' => $examid, 'catid' => $catid, 'subcat' => $subcat]) }}"
                  id="searchForm">
                  <div class="form-group">
                    <input type="search" name="search" value="{{ request('search') ?? '' }}" placeholder="Search">
                    <button type="submit"><span class="icon fa fa-search"></span></button>
                  </div>
                </form>
              </div>
            </div>


          </div>

          <!-- Blocks Column -->
          <div class="blocks-column col-lg-9 col-md-12 col-sm-12">

            <!-- Filter Box -->
            <div class="filter-box">

              <!-- Dropdown Filters Start -->
              <form method="GET"
                action="{{ route('study.material.front', ['examid' => $examid, 'catid' => $catid, 'subcat' => $subcat]) }}"
                id="filterForm" class="mb-3">
                <div class="row g-2">

                  <!-- Subject -->
                  <div class="col">
                    <select name="subject_id" class="form-control">
                      <option value="">--Select Subject--</option>
                      @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                          {{ $subject->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <!-- Chapter -->
                  <div class="col">
                    <select name="chapter_id" class="form-control">
                      <option value="">--Select Chapter--</option>
                      @foreach($chapters as $chapter)
                        <option value="{{ $chapter->id }}" {{ request('chapter_id') == $chapter->id ? 'selected' : '' }}>
                          {{ $chapter->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <!-- Topic -->
                  <div class="col">
                    <select name="topic_id" class="form-control">
                      <option value="">--Select Topic--</option>
                      @foreach($topics as $topic)
                        <option value="{{ $topic->id }}" {{ request('topic_id') == $topic->id ? 'selected' : '' }}>
                          {{ $topic->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <!-- Submit Button -->
                  <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filter</button>
                  </div>

                </div>
              </form>
              <!-- Dropdown Filters End -->

              <div class="d-flex justify-content-between align-items-center flex-wrap">
                <!-- Left Box -->
                <div class="left-box d-flex align-items-center">
                  <div class="results">Showing 1 - 12 of 54 results</div>
                </div>
                . <div class="right-box d-flex align-items-center">
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
              @foreach($studyMaterials as $data)
                <div class="course-block-five col-lg-4 col-md-6 col-sm-12">
                  <div class="inner-box">

                    <div class="content">

                      <!-- Banner Image -->
                      @if($data->banner)
                        <div class="image-box" style="height:180px; overflow:hidden; margin-bottom:10px;">
                          <img src="{{ asset('storage/' . $data->banner) }}" alt="{{ $data->title }}"
                            style="width:100%; height:100%; object-fit:cover;">
                        </div>
                      @endif

                      <!-- Title -->
                      <h4 class="osd sm">
                        <a href="{{ route('study.material.details', $data->id) }}">{{ $data->title }}</a>
                      </h4>

                      <!-- Short Description -->
                      @if($data->short_description)
                        <p>{{ Str::limit($data->short_description, 80) }}</p>
                      @endif

                      <!-- Paid / Free Badge -->
                      <div class="osd-label {{ $data->IsPaid ? 'paid' : 'free' }}">
                        {{ $data->IsPaid ? 'Paid' : 'Free' }}
                      </div>

                      <!-- View Detail Button -->
                      <a class="course-btn" href="{{ route('study.material.details', $data->id) }}">
                        View Detail <span class="flaticon-arrow-pointing-to-right"></span>
                      </a>
                    </div>

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