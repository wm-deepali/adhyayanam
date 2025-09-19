@extends('layouts.adminmaster')

@section('title')

    Admin : YOGKULAM NO 1 YOGA Teaching

@endsection

@section('header')

    @include('layouts.aheader')

@endsection

@section('content')

@inject('Permission', 'App\PermissionTraitForBlade')
<style>
    .adminbtn-blue, .adminbtn-blue:focus {
    background-color: #dc6b1e;
    color: #fff;
    border-radius: 25px;
    font-family: 'Roboto', sans-serif;
}
</style>
<div class="page-header">

					<div class="row">

						<div class="col-md-12 col-sm-12">

							<div class="title">

								<h4>Manage Live Classes</h4>

							</div>

							<nav aria-label="breadcrumb" role="navigation">

								<ol class="breadcrumb">

									<li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>

									<li class="breadcrumb-item active" aria-current="page">Live Classes</li>

								</ol>

							</nav>

						</div>

					</div>

</div>

<div class="pd-20 card-box mb-30">

   <div class="row">

        <div class="col-sm-4">

           <h4>Manage Live Classes</h4>

       </div>

       <div class="col-sm-8" style='text-align:right'>

           

                    <a data-action="reload"><i class="ft-rotate-cw"></i> Refresh </a>

                     &nbsp;&nbsp;&nbsp;

                    <a href="javascript:history.go(-1)"><i class="fa fa-backward"></i> Go Back</a>
                    <a href="{{route('topic.create')}}"><i class="fa fa-plus"></i> Add</a>

                     &nbsp;&nbsp;&nbsp;

       </div>

   </div>

</div>

<div class="pd-20 card-box mb-30">

   

   <div class="col-sm-12">

       <div class="row" style='margin-top:30px;'>

        <div class="card-block">

        <table class="table">
        <thead>
            <tr>
                <th>Date & Time</th>
                <th>Video Title</th>
                <th>Title</th>
                <th>Course</th>
                 <th> Category</th>
                 <th>Course Type</th>
                 <th>Schedule Date</th>
                 <th>Assignment</th>
                 <th>Teacher Name</th>
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
                 <td>{{ $topic->courses->course_name ?? "-" }}</td>
                 <td>{{ $topic->coursecategory->name ?? "-" }}</td>
                 <td>{{ $topic->course_type }}</td>
                 <td>{{ $topic->schedule_date }}</td>
                <td>
                    @if ($topic->assignment)
                        <img src="{{ asset('storage/' . $topic->assignment) }}" alt="{{ $topic->name }}" style="max-width: 100px;">
                    @else
                        No Image
                    @endif
                </td>
                
                <td>{{ $topic->teacher->teacherName ?? "-" }}</td>
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
                    <a href="{{ route('topic.edit', $topic->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('topic.destroy', $topic->id) }}" method="POST" style="display: inline;">
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

</div>

@endsection

@section('footer')

@include('layouts.afooter')

    
@endsection