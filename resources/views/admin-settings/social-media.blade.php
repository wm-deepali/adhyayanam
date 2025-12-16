@extends('layouts.app')

@section('title')
    Social Media Settings
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Social Media Settings</h5>
                <form method="POST" action="{{ route('settings.social.store') }}" id="social-media-form"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="youtube" class="form-label">YouTube</label>
                        <input type="text" class="form-control" name="youtube" value="{{ $settings->youtube ?? '' }}">
                        @error('youtube')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="facebook" class="form-label">Facebook</label>
                        <input type="text" class="form-control" name="facebook" value="{{ $settings->facebook ?? '' }}">
                        @error('facebook')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="instagram" class="form-label">Instagram</label>
                        <input type="text" class="form-control" name="instagram" value="{{ $settings->instagram ?? '' }}">
                        @error('instagram')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="linkedin" class="form-label">LinkedIn</label>
                        <input type="text" class="form-control" name="linkdin" value="{{ $settings->linkdin ?? '' }}">
                        @error('linkdin')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="twitter" class="form-label">Twitter</label>
                        <input type="text" class="form-control" name="twitter" value="{{ $settings->twitter ?? '' }}">
                        @error('twitter')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="whatsapp" class="form-label">WhatsApp</label>
                        <input type="text" class="form-control" name="whatsapp" value="{{ $settings->whatsapp ?? '' }}">
                        @error('whatsapp')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @if(\App\Helpers\Helper::canAccess('manage_social_add'))
                        <button type="submit" class="btn btn-primary">Save</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection