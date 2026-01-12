@extends('layouts.app')

@section('title')
    About Management
@endsection

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">About</h5>
                <h6 class="card-subtitle mb-2 text-muted"> Manage your about section here.</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <div class="container mt-4">
                    <form id="about-form" method="POST" action="{{ route('about.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="heading1" class="form-label">Heading</label>
                            <input value="{{ $about->heading1  }}" type="text" class="form-control" name="heading1"
                                placeholder="Heading" required>

                            @if ($errors->has('heading1'))
                                <span class="text-danger text-left">{{ $errors->first('heading1') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="description1" class="form-label">Description</label>
                            <textarea id="editor" name="description1" class="form-control"
                                style="height: 300px;">{!!$about->description1!!}</textarea>
                            @if ($errors->has('description1'))
                                <span class="text-danger text-left">{{ $errors->first('description1') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="youtube_url" class="form-label">YouTube URL</label>
                            <input value="{{ $about->youtube_url }}" type="url" class="form-control" name="youtube_url"
                                placeholder="YouTube URL">

                            @if ($errors->has('youtube_url'))
                                <span class="text-danger text-left">{{ $errors->first('youtube_url') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="image1" class="form-label">Upload Image</label>
                            <input type="file" class="form-control" name="image1" id="image1" accept="image/*">

                            @if ($errors->has('image1'))
                                <span class="text-danger text-left">{{ $errors->first('image1') }}</span>
                            @endif
                        </div>
                        @if (isset($about->image1))
                            <div class="mb-3">
                                <a href="{{ asset('storage/' . $about->image1) }}" download>
                                    {{ str_replace('images/', '', $about->image1) }}
                                </a>
                                <br>
                                <img src="{{ asset('storage/' . $about->image1) }}" alt="Uploaded Image" class="img-thumbnail"
                                    style="max-width: 200px; max-height: 200px;">
                            </div>
                        @endif

                        @if(\App\Helpers\Helper::canAccess('manage_about_edit'))
                            <button type="submit" class="btn btn-primary">Save Page</button>
                        @endif
                        @if($about->updated_at)
                            <div class="mt-3 text-muted">
                                <small>
                                    Last updated
                                    @if($about->updater)
                                        by <strong>{{ $about->updater->name }}</strong>
                                    @endif
                                    on {{ $about->updated_at->format('d M Y, h:i A') }}
                                </small>
                            </div>
                        @endif

                    </form>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
             CKEDITOR.replace('editor', {
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });
        });
    </script>
@endsection