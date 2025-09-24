@extends('layouts.app')

@section('title')
    Edit Current Affair
@endsection

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Current Affair</h5>
                <h6 class="card-subtitle mb-2 text-muted">Update Current Affair details here.</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <form id="affair-form" method="POST" action="{{ route('current.affairs.update', $currentAffair->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="topic_id" class="form-label">Category</label>
                        <select class="form-select" name="topic_id" required>
                            @foreach($topics as $topic)
                                <option value="{{ $topic->id }}" {{ $currentAffair->topic_id == $topic->id ? 'selected' : '' }}>
                                    {{ $topic->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $currentAffair->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control" name="short_description"
                            required>{{ $currentAffair->short_description }}</textarea>
                    </div>

                     <div class="mb-3">
                        <label for="details" class="form-label">Description</label>
                        <textarea id="editor" name="details"
                            style="height: 200px;">{!! $currentAffair->details !!}</textarea>
                        @if ($errors->has('details'))
                            <span class="text-danger text-left">{{ $errors->first('details') }}</span>
                        @endif
                    </div>
                  

                    <div class="mb-3">
                        <label for="publishing_date" class="form-label">Publishing Date</label>
                        <input id="publishing_date" type="date" class="form-control" name="publishing_date"
                            value="{{ $currentAffair->publishing_date }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail_image" class="form-label">Thumbnail Image</label>
                        <input type="file" class="form-control" name="thumbnail_image" accept="image/*">
                        @if($currentAffair->thumbnail_image)
                            <img src="{{ asset('storage/' . $currentAffair->thumbnail_image) }}" class="img-thumbnail mt-2"
                                style="max-width:100px;">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="banner_image" class="form-label">Banner Image</label>
                        <input type="file" class="form-control" name="banner_image" accept="image/*">
                        @if($currentAffair->banner_image)
                            <img src="{{ asset('storage/' . $currentAffair->banner_image) }}" class="img-thumbnail mt-2"
                                style="max-width:100px;">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="pdf_file" class="form-label">Upload PDF (Optional)</label>
                        <input type="file" class="form-control" name="pdf_file" accept="application/pdf">
                        @if($currentAffair->pdf_file)
                            <p class="mt-2">Current PDF: <a href="{{ asset('storage/' . $currentAffair->pdf_file) }}"
                                    target="_blank">{{ basename($currentAffair->pdf_file) }}</a></p>
                        @endif
                        @if ($errors->has('pdf_file'))
                            <span class="text-danger text-left">{{ $errors->first('pdf_file') }}</span>
                        @endif
                    </div>


                    <div class="mb-3">
                        <label for="image_alt_tag" class="form-label">Image Alt Tag</label>
                        <input type="text" class="form-control" name="image_alt_tag"
                            value="{{ $currentAffair->image_alt_tag }}">
                    </div>

                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" value="{{ $currentAffair->meta_title }}">
                    </div>

                    <div class="mb-3">
                        <label for="meta_keyword" class="form-label">Meta Keywords</label>
                        <input type="text" class="form-control" name="meta_keyword"
                            value="{{ $currentAffair->meta_keyword }}">
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <input type="text" class="form-control" name="meta_description"
                            value="{{ $currentAffair->meta_description }}">
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('current.affairs.index') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>

      <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script>
          document.addEventListener('DOMContentLoaded', function () {
            CKEDITOR.replace('editor');
        });

         
    </script>
@endsection