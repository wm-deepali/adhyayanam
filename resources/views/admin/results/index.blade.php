@extends('layouts.app')

@section('title', 'Test Attempts')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Test Attempts</h4>
    </div>

    <div class="card-body">

        {{-- TAB MENU --}}
        <ul class="nav nav-tabs" id="resultsTabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#pending">Pending</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#underReview">Under Review</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#published">Published</a>
            </li>
        </ul>

        <div class="tab-content mt-3">

            {{-- PENDING TAB --}}
            <div class="tab-pane fade show active" id="pending">
                @include('admin.results.shared-list', [
                    'title' => 'Pending Attempts',
                    'attempts' => $pending,
                    'teachers' => $teachers
                ])
            </div>

            {{-- UNDER REVIEW TAB --}}
            <div class="tab-pane fade" id="underReview">
                @include('admin.results.shared-list', [
                    'title' => 'Under Review Attempts',
                    'attempts' => $under_review,
                    'teachers' => $teachers
                ])
            </div>

            {{-- PUBLISHED TAB --}}
            <div class="tab-pane fade" id="published">
                @include('admin.results.shared-list', [
                    'title' => 'Published Attempts',
                    'attempts' => $published,
                    'teachers' => $teachers
                ])
            </div>

        </div>
    </div>
</div>

@endsection
