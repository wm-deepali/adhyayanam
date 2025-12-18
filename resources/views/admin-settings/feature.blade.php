<!-- resources/views/feature/create.blade.php -->
@extends('layouts.app')

@section('title')
    Create Feature
@endsection

@section('content')
    <div class="bg-light rounded p-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Create Feature</h5>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <form method="POST" action="{{ route('settings.feature.store') }}" enctype="multipart/form-data"
                    id="featureForm">
                    @csrf
                    <!--<div class="form-group">-->
                    <!--    <label>Heading</label>-->
                    <!--    <input type="text" name="heading" class="form-control" value="{{ isset($feature) ? $feature->heading : '' }}" required>-->
                    <!--</div>-->
                    <div class="form-group">
                        <label>Title 1</label>
                        <input type="text" name="title1" class="form-control"
                            value="{{ isset($feature) ? $feature->title1 : '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Title 2</label>
                        <input type="text" name="title2" class="form-control"
                            value="{{ isset($feature) ? $feature->title2 : '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Title 3</label>
                        <input type="text" name="title3" class="form-control"
                            value="{{ isset($feature) ? $feature->title3 : '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>Icon 1</label>
                        <input type="file" name="icon1" value="{{isset($feature) ? url($feature->icon1) : ''}}"
                            class="form-control">
                        <img src="{{isset($feature) ? asset('storage/' . $feature->icon1) : ''}}" alt="Popup Image"
                            style="max-width: 150px; margin-top:10px;">
                    </div>
                    <div class="form-group">
                        <label>Icon 2</label>
                        <input type="file" name="icon2" value="{{isset($feature) ? url($feature->icon2) : ''}}"
                            class="form-control">
                        <img src="{{isset($feature) ? asset('storage/' . $feature->icon2) : ''}}" alt="Popup Image"
                            style="max-width: 150px; margin-top:10px;">
                    </div>
                    <div class="form-group">
                        <label>Icon 3</label>
                        <input type="file" name="icon3" value="{{isset($feature) ? url($feature->icon3) : ''}}"
                            class="form-control">
                        <img id="popImagePreview" src="{{isset($feature) ? asset('storage/' . $feature->icon3) : ''}}"
                            alt="Popup Image" style="max-width: 150px; margin-top:10px;">
                    </div>
                    <div class="form-group">
                        <label>Short Description 1</label>
                        <textarea name="short_description1" class="form-control"
                            required>{{ isset($feature) ? $feature->short_description1 : '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Short Description 2</label>
                        <textarea name="short_description2" class="form-control"
                            required>{{ isset($feature) ? $feature->short_description2 : '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Short Description 3</label>
                        <textarea name="short_description3" class="form-control"
                            required>{{ isset($feature) ? $feature->short_description3 : '' }}</textarea>
                    </div>
                    @if(\App\Helpers\Helper::canAccess('manage_feature_add'))
                        <div class="mt-2">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    @endif
                      @if($feature->created_at)
                        <div class="text-muted">
                            Last updated by
                            <strong>{{ $feature->creator->name ?? 'N/A' }}</strong>
                             on {{ $feature->updated_at->format('d M Y, h:i A') }}
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection