@extends('layouts.app')

@section('title','Add Testimonial')

@section('content')
<div class="card p-4">
    <h5>Add Testimonial</h5>

    <form action="{{ route('feed.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="type" value="2">

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Name</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Designation</label>
                <input type="text" name="designation" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Mobile</label>
                <input type="text" name="number" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Rating</label>
                <select name="rating" class="form-control" required>
                    <option value="">Select</option>
                    <option value="5">★★★★★</option>
                    <option value="4">★★★★</option>
                    <option value="3">★★★</option>
                    <option value="2">★★</option>
                    <option value="1">★</option>
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label>Message</label>
                <textarea name="message" class="form-control"></textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label>Photo</label>
                <input type="file" name="photo" class="form-control" required>
            </div>

        </div>

        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection