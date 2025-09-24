@extends('layouts.app')

@section('title')
    Create New Current Affair
@endsection

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Create</h5>
                <h6 class="card-subtitle mb-2 text-muted"> Create Current Affairs here.</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <form id="affair-form" method="POST" action="{{ route('current.affairs.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="topic_id" class="form-label">Category</label>
                        <select class="form-select" name="topic_id" required>
                            <!-- Assuming you have a $topics variable passed to the view containing available topics -->
                            @foreach($topics as $topic)
                                <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('topic_id'))
                            <span class="text-danger text-left">{{ $errors->first('topic_id') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Title" required>
                        @if ($errors->has('title'))
                            <span class="text-danger text-left">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea class="form-control" name="short_description" placeholder="Short Description"
                            required></textarea>
                        @if ($errors->has('short_description'))
                            <span class="text-danger text-left">{{ $errors->first('short_description') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="details" class="form-label">Description</label>
                        <textarea id="editor" name="details" style="height: 200px;"></textarea>
                        @if ($errors->has('details'))
                            <span class="text-danger text-left">{{ $errors->first('details') }}</span>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <label for="publishing_date" class="form-label">Publishing Date</label>
                        <input id="publishing_date" type="date" class="form-control" name="publishing_date"
                            placeholder="Y-m-d" required>
                        @if ($errors->has('publishing_date'))
                            <span class="text-danger text-left">{{ $errors->first('publishing_date') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail_image" class="form-label">Thumbnail Image</label>
                        <input type="file" class="form-control" name="thumbnail_image" accept="image/*">
                        @if ($errors->has('thumbnail_image'))
                            <span class="text-danger text-left">{{ $errors->first('thumbnail_image') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="banner_image" class="form-label">Banner Image</label>
                        <input type="file" class="form-control" name="banner_image" accept="image/*">
                        @if ($errors->has('banner_image'))
                            <span class="text-danger text-left">{{ $errors->first('banner_image') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="pdf_file" class="form-label">Upload PDF (Optional)</label>
                        <input type="file" class="form-control" name="pdf_file" accept="application/pdf">
                        @if ($errors->has('pdf_file'))
                            <span class="text-danger text-left">{{ $errors->first('pdf_file') }}</span>
                        @endif
                    </div>


                    <div class="mb-3">
                        <label for="image_alt_tag" class="form-label">Image Alt Tag</label>
                        <input type="text" class="form-control" name="image_alt_tag" placeholder="Image Alt Tag">
                        @if ($errors->has('image_alt_tag'))
                            <span class="text-danger text-left">{{ $errors->first('image_alt_tag') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" placeholder="Meta Title">
                        @if ($errors->has('meta_title'))
                            <span class="text-danger text-left">{{ $errors->first('meta_title') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="meta_keyword" class="form-label">Meta Keywords</label>
                        <input type="text" class="form-control" name="meta_keyword" placeholder="Meta Keywords">
                        @if ($errors->has('meta_keyword'))
                            <span class="text-danger text-left">{{ $errors->first('meta_keyword') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <input type="text" class="form-control" name="meta_description" placeholder="Meta Description">
                        @if ($errors->has('meta_description'))
                            <span class="text-danger text-left">{{ $errors->first('meta_description') }}</span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('current.affairs.index') }}" class="btn">Back</a>
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