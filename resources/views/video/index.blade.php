@extends('layouts.app')

@section('title')
Manage Video
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Manage Video</h5>
            <h6 class="card-subtitle mb-2 text-muted">Manage Video.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="container mt-4">
                <a href="{{route('video.create')}}" class="btn btn-primary">Add</a>

                <table class="table table-striped mt-5">
        <thead>
            <tr>
                <th>Date & Time</th>
                <th>Video Title</th>
                <th>Chapter</th>
                <th>Course</th>
                 <th> Category</th>
                 <th>Course Type</th>
                 <th>Duration</th>
                 <th>Assignment</th>
                 <th>Source</th>
                 <th>Ratings</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $topic)
            <tr>
                <td>{{ $topic->created_at->format('Y-m-d H:i:s') }}</td>
                <td>{{ $topic->title }}</td>
                <td>{{ $topic->chapter->name ?? "-" }}</td>
                 <td>{{ $topic->courses->name ?? "-" }}</td>
                 <td>{{ $topic->coursecategory->name ?? "-" }}</td>
                 <td>{{ $topic->course_type }}</td>
                 <td>{{ $topic->duration }}</td>
                <td>
                    @if ($topic->assignment)
                        <img src="{{ asset('storage/' . $topic->assignment) }}" alt="{{ $topic->name }}" style="max-width: 100px;">
                    @else
                        No Image
                    @endif
                </td>
                
                <td>{{ $topic->video_type }}</td>
                <td>@php
                                    $rating = $topic->rating;
                                    $fullStars = floor($rating);
                                    $hasHalfStar = ceil($rating - $fullStars) > 0;
                                    $totalStars = 5;
                                    @endphp
                                    @for ($i = 1; $i <= $fullStars; $i++)
                                        <i class="fa fa-star rating-color"></i>
                                    @endfor
                                
                                    @if ($hasHalfStar)
                                        <i class="fa fa-star-half-alt rating-color"></i>
                                    @endif
                                
                                    @for ($i = $fullStars + ($hasHalfStar ? 1 : 0); $i < $totalStars; $i++)
                                        <i class="fa fa-star"></i>
                                    @endfor</td>
                
                <td>{{ $topic->status ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('video.edit', $topic->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('video.destroy', $topic->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
            </div>

        </div>
    </div>
</div>


@endsection

