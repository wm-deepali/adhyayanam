@extends('layouts.app')

@section('title')
Edit|Marquee Setting
@endsection

@section('content')
<div class="bg-light rounded p-3">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Edit|Marquee Setting</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Edit Marquee Setting</h6>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form method="POST" action="{{ route('settings.marquee.update') }}" id="header-form">
                @csrf
                <div class="row mt-2">
                    <div class="col-md-4" id="manage_button_url">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Text...." value="{{$marquee->title ?? ''}}">
                        </div>
                    </div>
                    <input type="text" name="id" value="{{$marquee->id}}" style="display:none">
                    <div class="col-md-4" id="manage_button_url">
                        <div class="form-group">
                            <label>Link</label>
                            <input type="text" class="form-control" name="link" placeholder="Enter Button Link...." value="{{$marquee->link ?? ''}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <button class="btn btn-primary waves-effect waves-float waves-light" type="submit">Add Marquee</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
