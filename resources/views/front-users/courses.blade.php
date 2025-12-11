@extends('front-users.layouts.app')

@section('title')
    My Courses
@endsection

@section('content')
    <section class="content">
        <div class="row">
            @forelse($orders as $order)
                @if($order->order_type == 'Course' && $order->course)
                    @php $course = $order->course; @endphp
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img src="{{ asset('storage/' . $course->thumbnail_image) }}" class="card-img-top"
                                alt="{{ $course->image_alt_tag }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $course->course_heading }}</h5>
                                <p class="card-text">{{ Str::limit($course->short_description, 100) }}</p>
                                <ul class="list-unstyled mb-2">
                                    <li><strong>Duration:</strong> {{ $course->duration }} Weeks</li>
                                    <li><strong>Classes:</strong> {{ $course->num_classes }}</li>
                                    <li><strong>Topics:</strong> {{ $course->num_topics }}</li>
                                    <li><strong>Language:</strong>
                                        @if($course->language_of_teaching == 'E')
                                            English
                                        @elseif($course->language_of_teaching == 'H')
                                            Hindi
                                        @else
                                            {{$course->language_of_teaching}}
                                        @endif
                                    </li>
                                    <li><strong>Fee Paid:</strong> Rs. {{ $order->total }}</li>
                                </ul>
                                <a href="{{ route('course.detail', $course->id) }}" class="btn btn-primary btn-block">
                                    Start Learning
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        You have not purchased any courses yet.
                    </div>
                </div>
            @endforelse
        </div>
    </section>
@endsection