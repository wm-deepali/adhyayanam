@extends('layouts.app')

@section('title')
    Header Settings
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col">
                        <h5 class="card-title">Header Settings</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Update Header Settings</h6>
                    </div>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <form method="POST" action="{{ route('settings.header.store') }}" id="header-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="script" class="form-label">Script</label>
                        <div style="height:80px;" id="script">{!!$settings->script ?? '' !!}</div>
                        @error('script')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="twitter_card" class="form-label">Twitter Card</label>
                        <input type="text" class="form-control" name="twitter_card"
                            value="{{ $settings->twitter_card ?? '' }}">
                        @error('twitter_card')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="og_tags" class="form-label">OG Tags</label>
                        <input type="text" class="form-control" name="og_tags" value="{{ $settings->og_tags ?? '' }}">
                        @error('og_tags')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" value="{{ $settings->meta_title ?? '' }}">
                        @error('meta_title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                        <input type="text" class="form-control" name="meta_keywords"
                            value="{{ $settings->meta_keywords ?? '' }}">
                        @error('meta_keywords')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control" name="meta_description"
                            rows="3">{{ $settings->meta_description ?? '' }}</textarea>
                        @error('meta_description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="canonical_url" class="form-label">Canonical URL</label>
                        <input type="text" class="form-control" name="canonical_url"
                            value="{{ $settings->canonical_url ?? '' }}">
                        @error('canonical_url')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="company_logo" class="form-label">Company Logo</label>
                        <input type="file" class="form-control" name="company_logo" accept="image/*">
                        @if ($settings && $settings->company_logo)
                            <img src="{{ Storage::url($settings->company_logo) }}" alt="Company Logo" class="img-thumbnail mt-2"
                                width="100">
                        @endif
                        @error('company_logo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" name="contact_number"
                            value="{{ $settings->contact_number ?? '' }}">
                        @error('contact_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email_id" class="form-label">Email ID</label>
                        <input type="email" class="form-control" name="email_id" value="{{ $settings->email_id ?? '' }}">
                        @error('email_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Company Address</label>
                        <input type="text" class="form-control" name="address" value="{{ $settings->address ?? '' }}">
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="map_embbed" class="form-label">Embbed Map</label>
                        <textarea class="form-control" name="map_embbed">{{ $settings->map_embbed ?? '' }}</textarea>
                        @error('map_embbed')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                        <input type="text" class="form-control" name="whatsapp_number"
                            value="{{ $settings->whatsapp_number ?? '' }}">
                        @error('whatsapp_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @if(\App\Helpers\Helper::canAccess('manage_header_add'))
                        <button type="submit" class="btn btn-primary">Save</button>
                    @endif
                    @if($settings->created_at)
                        <div class="text-muted">
                            Last updated by
                            <strong>{{ $settings->creator->name ?? 'N/A' }}</strong>
                        </div>
                    @endif

                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var quill = new Quill('#script', {
                modules: {
                    toolbar: [
                        [{ header: [1, 2, false] }],
                        ['bold', 'italic', 'underline'],
                        ['image', 'code-block'],
                    ],
                },
                placeholder: 'Add you script...',
                theme: 'snow', // or 'bubble'
            });

            const form = document.getElementById('header-form');
            form.addEventListener('submit', (event) => {
                event.preventDefault(); // Prevent default form submission

                // Get Quill content as HTML
                const script = quill.root.innerHTML;

                // Create a hidden input to hold the Quill content
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'script';
                hiddenInput.value = script;

                // Append the hidden input to the form
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            });
        });
    </script>
@endsection