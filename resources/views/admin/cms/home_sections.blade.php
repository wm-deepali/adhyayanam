@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm p-4">

        <h4 class="mb-4">Manage Home Page Headings</h4>

        {{-- success message --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('cm.home.sections.update') }}">
            @csrf

            @foreach($sections as $section)
                <div class="mb-4 pb-3 border-bottom">

                    {{-- Section Label --}}
                    <label class="form-label fw-bold text-capitalize">
                        {{ str_replace('_',' ', $section->section_key) }}
                    </label>

                    {{-- Heading --}}
                    <input
                        type="text"
                        name="sections[{{ $section->section_key }}][heading]"
                        class="form-control mb-2"
                        placeholder="Heading"
                        value="{{ old('sections.'.$section->section_key.'.heading', $section->heading) }}"
                    >

                    {{-- Sub Heading --}}
                    <input
                        type="text"
                        name="sections[{{ $section->section_key }}][sub_heading]"
                        class="form-control"
                        placeholder="Sub Heading"
                        value="{{ old('sections.'.$section->section_key.'.sub_heading', $section->sub_heading) }}"
                    >
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary px-4">
                Save Changes
            </button>

        </form>
    </div>
</div>
@endsection