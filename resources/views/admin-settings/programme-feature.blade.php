<!-- resources/views/programme_feature/edit.blade.php -->
@extends('layouts.app')

@section('title')
    Edit Programme Feature
@endsection

@section('content')
    <div class="bg-light rounded p-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Programme Feature</h5>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <form method="POST" action="{{ route('settings.programme_feature.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Banner</label>
                                <input type="file" name="banner"
                                    value="{{isset($programmeFeature) ? $programmeFeature->banner : ''}}"
                                    class="form-control">
                                @if ($programmeFeature)
                                    <img src="{{ asset('storage/' . $programmeFeature->banner) }}" alt="Banner"
                                        style="max-width: 100px;">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ $programmeFeature->title ?? ''}}" required>
                            </div>
                            <div class="form-group">
                                <label>Short Description</label>
                                <textarea name="short_description" class="form-control"
                                    required>{{ $programmeFeature->short_description ?? '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Heading</label>
                                <input type="text" name="heading" class="form-control"
                                    value="{{ $programmeFeature->heading ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>Feature</label>
                                <textarea name="feature" class="form-control"
                                    required>{{ $programmeFeature->feature ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Icon 1</label>
                                <input type="file" name="icon1"
                                    value="{{isset($programmeFeature) ? $programmeFeature->icon1 : ''}}"
                                    class="form-control">
                                @if ($programmeFeature)
                                    <img src="{{ asset('storage/' . $programmeFeature->icon1) }}" alt="Icon 1"
                                        style="max-width: 50px;">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Icon 1 Title</label>
                                <input type="text" name="icon_title1" class="form-control"
                                    value="{{ $programmeFeature->icon_title1 ?? ''}}">
                            </div>
                            <div class="form-group">
                                <label>Icon 2</label>
                                <input type="file" name="icon2"
                                    value="{{ isset($programmeFeature) ? $programmeFeature->icon2 : ''}}"
                                    class="form-control">
                                @if ($programmeFeature)
                                    <img src="{{ asset('storage/' . $programmeFeature->icon2) }}" alt="Icon 2"
                                        style="max-width: 50px;">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Icon 2 Title</label>
                                <input type="text" name="icon_title2" class="form-control"
                                    value="{{ $programmeFeature->icon_title2 ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Icon 3</label>
                                <input type="file" name="icon3"
                                    value="{{  isset($programmeFeature) ? $programmeFeature->icon3 : ''}}"
                                    class="form-control">
                                @if ($programmeFeature)
                                    <img src="{{ asset('storage/' . $programmeFeature->icon3) }}" alt="Icon 3"
                                        style="max-width: 50px;">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Icon 3 Title</label>
                                <input type="text" name="icon_title3" class="form-control"
                                    value="{{ $programmeFeature->icon_title3 ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Icon 4</label>
                                <input type="file" name="icon4"
                                    value="{{ isset($programmeFeature) ? $programmeFeature->icon4 : ''}}"
                                    class="form-control">
                                @if ($programmeFeature)
                                    <img src="{{ asset('storage/' . $programmeFeature->icon4) }}" alt="Icon 4"
                                        style="max-width: 50px;">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Icon 4 Title</label>
                                <input type="text" name="icon_title4" class="form-control"
                                    value="{{ $programmeFeature->icon_title4 ?? '' }}">
                            </div>
                        </div>
                    </div>
                    @if(\App\Helpers\Helper::canAccess('manage_programme_feature_add'))
                        <div class="col-md-12 mt-2">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    @endif
                      @if($programmeFeature->created_at)
                        <div class="text-muted">
                            Last updated by
                            <strong>{{ $programmeFeature->creator->name ?? 'N/A' }}</strong>
                             on {{ $programmeFeature->updated_at->format('d M Y, h:i A') }}
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection