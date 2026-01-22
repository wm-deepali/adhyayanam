@extends('layouts.app')

@section('title', 'Test Attempts')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Test Attempts</h4>
    </div>

    <div class="card-body">

    @php
    $activeTab = 'pending';

    if (request()->has('under_review_page')) {
        $activeTab = 'underReview';
    } elseif (request()->has('published_page')) {
        $activeTab = 'published';
    }
@endphp

        {{-- TAB MENU --}}
       <ul class="nav nav-tabs" id="resultsTabs">
    <li class="nav-item">
        <a class="nav-link {{ $activeTab === 'pending' ? 'active' : '' }}"
           data-bs-toggle="tab" href="#pending">
            Pending
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ $activeTab === 'underReview' ? 'active' : '' }}"
           data-bs-toggle="tab" href="#underReview">
            Under Review
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ $activeTab === 'published' ? 'active' : '' }}"
           data-bs-toggle="tab" href="#published">
            Published
        </a>
    </li>
</ul>


      <div class="tab-content mt-3">

    <div class="tab-pane fade {{ $activeTab === 'pending' ? 'show active' : '' }}"
         id="pending">
        @include('admin.results.shared-list', [
            'title' => 'Pending Attempts',
            'attempts' => $pending,
            'teachers' => $teachers
        ])
    </div>

    <div class="tab-pane fade {{ $activeTab === 'underReview' ? 'show active' : '' }}"
         id="underReview">
        @include('admin.results.shared-list', [
            'title' => 'Under Review Attempts',
            'attempts' => $under_review,
            'teachers' => $teachers
        ])
    </div>

    <div class="tab-pane fade {{ $activeTab === 'published' ? 'show active' : '' }}"
         id="published">
        @include('admin.results.shared-list', [
            'title' => 'Published Attempts',
            'attempts' => $published,
            'teachers' => $teachers
        ])
    </div>

</div>

</div>

@endsection
