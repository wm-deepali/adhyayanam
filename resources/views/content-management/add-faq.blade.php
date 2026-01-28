@extends('layouts.app')

@section('title')
    Add FAQ
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-title">Add FAQ</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Add your FAQ here.</h6>
                    </div>

                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                        ← Back
                    </a>
                </div>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <div class="container mt-4">
                    <form method="POST" action="{{ route('faq.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Question</label>
                            <input type="text" class="form-control" name="question" placeholder="Enter FAQ question"
                                required>
                            @error('question')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Answer</label>
                            <textarea class="form-control" name="answer" rows="3" placeholder="Enter FAQ answer"
                                required></textarea>
                            @error('answer')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- FAQ CATEGORY --}}
                        <div class="mb-3">
                            <label class="form-label">FAQ Related To</label>
                            <select class="form-control" name="type">
                                <option value="">Select Category</option>
                                <option value="course">Course</option>
                                <option value="test_series">Test Series</option>
                                <option value="study_material">Study Material</option>
                                <option value="batches">Batches</option>
                                <option value="online_programme">Online Programme</option>
                                <option value="general">General</option>
                            </select>

                            <small class="text-muted">
                                This FAQ will be shown under the selected section on the website.
                            </small>

                            @error('type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save FAQ
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection