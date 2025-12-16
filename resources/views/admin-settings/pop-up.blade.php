<!-- resources/views/pop_up/create.blade.php -->

@extends('layouts.app')

@section('title')
    Create PopUp
@endsection

@section('content')
    <div class="bg-light rounded p-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Create PopUp</h5>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <form method="POST" action="{{ route('settings.popup.store') }}" enctype="multipart/form-data"
                    id="popupForm">
                    @csrf
                    <div class="form-group">
                        <label>PopUp Image</label>
                        <input type="file" name="pop_image" class="form-control" id="popImageInput">
                        <img id="popImagePreview" src="{{isset($popUp) ? asset('storage/' . $popUp->pop_image) : ''}}"
                            alt="Popup Image" style="max-width: 150px; margin-top:10px;">
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" name="link" class="form-control" value="{{ $popUp->link ?? " " }}">
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $popUp->title ?? "" }}">
                    </div>
                    @if(\App\Helpers\Helper::canAccess('manage_popup_add'))
                        <div class="mt-2">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    @endif

                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const popImageInput = document.getElementById('popImageInput');
            const popImagePreview = document.getElementById('popImagePreview');

            popImageInput.addEventListener('change', function (event) {
                const file = event.target.files[0];
                const reader = new FileReader();

                reader.onload = function (e) {
                    popImagePreview.src = e.target.result;
                    popImagePreview.style.display = 'block';
                }

                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection