@extends('front-users.layouts.app')

@section('title')
My Courses
@endsection

@section('content')

<style>

.course-card{
display:flex;
gap:20px;
background:#fff;
border-radius:10px;
padding:20px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
margin-bottom:20px;
align-items:flex-start;
}

.course-image{
width:220px;
flex-shrink:0;
}

.course-image img{
width:100%;
height:260px;
object-fit:cover;
border-radius:8px;
}

.course-content{
flex:1;
}

.course-title-row{
display:flex;
justify-content:space-between;
align-items:center;
}

.course-title{
font-size:20px;
font-weight:600;
margin-bottom:5px;
}

.course-rating{
color:#f5a623;
font-size:14px;
}

.course-desc{
font-size:14px;
color:#666;
margin-bottom:15px;
}

.course-meta{
display:grid;
grid-template-columns:repeat(3,1fr);
gap:10px;
margin-bottom:15px;
}

.meta-box{
background:#f7f8fb;
padding:8px 10px;
border-radius:6px;
font-size:13px;
}

.meta-box strong{
display:block;
font-size:12px;
color:#888;
}

.start-btn{
text-align:right;
}

.start-btn a{
padding:7px 16px;
border-radius:6px;
font-size:14px;
}

</style>


<section class="content">

@forelse($orders as $order)

@if($order->order_type == 'Course' && $order->course)

@php $course = $order->course; @endphp

<div class="course-card">

{{-- IMAGE --}}
<div class="course-image">
<img src="{{ asset('storage/' . $course->thumbnail_image) }}" 
alt="{{ $course->image_alt_tag }}">
</div>


{{-- CONTENT --}}
<div class="course-content">

<div class="course-title-row">

<div class="course-title">
{{ $course->course_heading }}
</div>

<div class="course-rating">
⭐⭐⭐⭐⭐ 4.5
</div>

</div>


<div class="course-desc">
{{ Str::limit($course->short_description, 150) }}
</div>


<div class="course-meta">

<div class="meta-box">
<strong>Duration</strong>
{{ $course->duration }} Weeks
</div>

<div class="meta-box">
<strong>Classes</strong>
{{ $course->num_classes }}
</div>

<div class="meta-box">
<strong>Topics</strong>
{{ $course->num_topics }}
</div>

<div class="meta-box">
<strong>Language</strong>
{{ $course->language_of_teaching }}
</div>

<div class="meta-box">
<strong>Mode</strong>
{{ ucfirst($course->course_mode) }}
</div>

<div class="meta-box">
<strong>Fee Paid</strong>
₹ {{ $order->total }}
</div>

</div>


<div class="start-btn">

<a href="{{ route('course.detail', $course->id) }}" 
class="btn btn-primary">

Start Learning

</a>

</div>


</div>

</div>

@endif

@empty

<div class="alert alert-info">
You have not purchased any courses yet.
</div>

@endforelse

</section>

@endsection
