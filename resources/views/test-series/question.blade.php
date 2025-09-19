@extends('layouts.app')

@section('title')
Questions
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Questions</h5>
                    <h6 class="card-subtitle mb-2 text-muted"> Manage your Test Series Questions section here.</h6>
                </div>
                <div class="justify-content-end">
                    <a href='{{route('test.series.question.create')}}' class="btn btn-primary">&#43; Add</a>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
        </div>
    </div>
</div>
@endsection