@extends('layouts.app')

@section('title')
    Our Vision & Mission Management
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Our Vision & Mission</h5>
                <h6 class="card-subtitle mb-2 text-muted"> Manage your vision and mission section here.</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <form method="POST" action="{{ route('vision.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="heading1" class="form-label">Heading 1</label>
                        <input value="{{ $vision->heading1 ?? "" }}" type="text" class="form-control" name="heading1"
                            placeholder="Heading 1" required>

                        @if ($errors->has('heading1'))
                            <span class="text-danger text-left">{{ $errors->first('heading1') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="description1" class="form-label">Description 1</label>
                        <textarea class="form-control" name="description1" placeholder="Description 1"
                            required>{{ $vision->description1 ?? "" }}</textarea>

                        @if ($errors->has('description1'))
                            <span class="text-danger text-left">{{ $errors->first('description1') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="image1" class="form-label">Image 1</label>
                        <input type="file" class="form-control" name="image1">

                        @if ($errors->has('image1'))
                            <span class="text-danger text-left">{{ $errors->first('image1') }}</span>
                        @endif
                    </div>
                    @if (isset($vision->image1))
                        <div class="mb-3">
                            <a href="{{ asset('storage/' . $vision->image1) }}" download>
                                {{ str_replace('images/', '', $vision->image1) }}
                            </a>
                            <br>
                            <img src="{{ asset('storage/' . $vision->image1) }}" alt="Uploaded Image" class="img-thumbnail"
                                style="max-width: 200px; max-height: 200px;">
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="heading2" class="form-label">Heading 2</label>
                        <input value="{{ $vision->heading2 ?? "" }}" type="text" class="form-control" name="heading2"
                            placeholder="Heading 2" required>

                        @if ($errors->has('heading2'))
                            <span class="text-danger text-left">{{ $errors->first('heading2') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="description2" class="form-label">Description 2</label>
                        <textarea class="form-control" name="description2" placeholder="Description 2"
                            required>{{ $vision->description2 ?? "" }}</textarea>

                        @if ($errors->has('description2'))
                            <span class="text-danger text-left">{{ $errors->first('description2') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="image2" class="form-label">Image 2</label>
                        <input type="file" class="form-control" name="image2">

                        @if ($errors->has('image2'))
                            <span class="text-danger text-left">{{ $errors->first('image2') }}</span>
                        @endif
                    </div>

                    @if (isset($vision->image2))
                        <div class="mb-3">
                            <a href="{{ asset('storage/' . $vision->image2) }}" download>
                                {{ str_replace('images/', '', $vision->image2) }}
                            </a>
                            <br>
                            <img src="{{ asset('storage/' . $vision->image2) }}" alt="Uploaded Image" class="img-thumbnail"
                                style="max-width: 200px; max-height: 200px;">
                        </div>
                    @endif
                    @if(\App\Helpers\Helper::canAccess('manage_vision_edit'))
                        <button type="submit" class="btn btn-primary">Save Page</button>
                    @endif
                    @if($vision->updated_at)
                        <div class="mt-3 text-muted">
                            <small>
                                Last updated
                                @if($vision->updater)
                                    by <strong>{{ $vision->updater->name }}</strong>
                                @endif
                                on {{ $vision->updated_at->format('d M Y, h:i A') }}
                            </small>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection