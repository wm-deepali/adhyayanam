@extends('front.partials.app')
@section('header')
  <title>Current Affairs</title>
@endsection
@section('content')

  <body class="hidden-bar-wrapper">

    <section class="page-title">
      <div class="auto-container">
        <h2>Adhyayanam</h2>
        <ul class="bread-crumb clearfix">
          <li><a href="index.html">Home</a></li>
          <li>Current Affairs</li>
        </ul>
      </div>
    </section>

    <section class="blog-page-section">
      <div class="auto-container">
        <div class="row clearfix">
          <div class="col-12">
            <div class="sec-title">
              <h2>Monthly Trending Current Affairs</h2>
            </div>
          </div>
          <div class="col-12 col-sm-12">
            <form method="GET" action="{{ route('current.index') }}">
              <div class="filter-box">
                <div class="d-flex justify-content-between align-items-center flex-wrap">

                  <!-- Search + Date -->
                  <div class="left-box d-flex align-items-center gap-2">

                    <input type="text" name="keyword" placeholder="Search Current Affairs..."
                      value="{{ request('keyword') }}" class="form-control">

                    <input type="date" name="search" value="{{ request('search') }}" class="form-control">

                    <button type="submit" class="btn btn-primary">
                      Search
                    </button>

                    <!-- Clear Filters -->
                    <a href="{{ route('current.index') }}" class="btn btn-secondary">
                      Clear
                    </a>

                  </div>

                  <!-- Sorting -->
                  <div class="right-box d-flex align-items-center">
                    <div class="form-group">

                      <select name="sort" class="form-control" onchange="this.form.submit()">

                        <option value="">Recently Added</option>

                        <option value="week" {{ request('sort') == 'week' ? 'selected' : '' }}>
                          Last 7 Days
                        </option>

                        <option value="month" {{ request('sort') == 'month' ? 'selected' : '' }}>
                          Last 30 Days
                        </option>

                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                          Newest First
                        </option>

                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                          Oldest First
                        </option>

                      </select>

                    </div>
                  </div>

                </div>
              </div>
            </form>
          </div>

          <div class="row">
            @foreach($topics as $topic)
              @if($topic->currentAffair && $topic->currentAffair->isNotEmpty())
                <div class="col-md-12">
                  <div class="topic-card rounded-3 bg-white overflow-hidden"
                    style="max-height: 500px; display: flex; flex-direction: column;">
                    <div class="topic-header d-flex align-items-center justify-content-between p-3  text-white"
                      style="background:#045279;">
                      <h4 class="mb-0 fw-bold fs-5">{{ $topic->name }}</h4>
                      <span class="arrow-icon fs-4">↓</span>
                    </div>

                    <div class="topic-content p-3 flex-grow-1" style="overflow-y: auto; max-height: calc(500px - 70px);">
                      <!-- header height approx subtract -->
                      <div class="d-flex flex-column gap-3">
                        @foreach($topic->currentAffair as $affair)
                          <a href="{{ route('current.details', $affair->id) }}"
                            class="affair-btn text-decoration-none text-dark rounded-3 p-3 shadow-sm hover-shadow bg-pastel-blue">
                            <div class="d-flex justify-content-between align-items-center">
                              <div>
                                <strong class="d-block mb-1">{{ $affair->title }}</strong>
                                <small class="text-muted">{{ $affair->short_description }}</small>
                              </div>
                              <span class="arrow-right fs-5 text-primary">→</span>
                            </div>
                          </a>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              @endif
            @endforeach
          </div>
        </div>

        <div class="bottom-box d-flex justify-content-center">
          {{ $topics->appends(request()->query())->links() }}
        </div>

      </div>
    </section>
  </body>
@endsection