@extends('layouts.app')

@section('title')
    Hero Section
@endsection

@section('content')

<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Hero Section</h5>
                    <h6 class="card-subtitle text-muted">
                        Manage hero section content.
                    </h6>
                </div>

                <a href="{{ route('about.index') }}"
                   class="btn btn-secondary btn-sm">
                    ← Back
                </a>
            </div>

            <div class="mt-3">
                @include('layouts.includes.messages')
            </div>

            <form method="POST"
                  action="{{ route('about.hero.store') }}">

                @csrf

                <div class="card mt-3">
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">
                                Heading <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="heading"
                                   value="{{ old('heading', $section->heading ?? '') }}"
                                   placeholder="Enter Hero Heading">

                            @error('heading')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Sub Heading
                            </label>

                            <textarea
                                name="sub_heading"
                                class="form-control"
                                rows="4"
                                placeholder="Enter Hero Sub Heading">{{ old('sub_heading', $section->extra_data['sub_heading'] ?? '') }}</textarea>

                            @error('sub_heading')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="mt-3">

                    @if(\App\Helpers\Helper::canAccess('manage_about_edit'))
                        <button type="submit"
                                class="btn btn-primary">
                            Save Changes
                        </button>
                    @endif

                    @if($section->updated_at)
                        <div class="text-muted mt-2">
                            <small>
                                Last updated on
                                {{ $section->updated_at->format('d M Y, h:i A') }}
                            </small>
                        </div>
                    @endif

                </div>

            </form>

        </div>
    </div>
</div>

@endsection