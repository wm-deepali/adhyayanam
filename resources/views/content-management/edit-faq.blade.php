@extends('layouts.app')

@section('title')
Edit FAQ
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
             <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-title">Edit FAQ</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Update your FAQ here.</h6>
                    </div>

                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                        ← Back
                    </a>
                </div>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="container mt-4">
                <form method="POST" action="{{ route('faq.update', $faq->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <input 
                               type="text" 
                               class="form-control" 
                               name="question" 
                               placeholder="Question"
                               value="{{ old('question', $faq->question) }}" 
                               required>
                        @if ($errors->has('question'))
                            <span class="text-danger text-left">{{ $errors->first('question') }}</span>
                        @endif
                    </div>
            
                    <div class="mb-3">
                        <label for="answer" class="form-label">Answer</label>
                        <textarea class="form-control" 
                                  name="answer" 
                                  placeholder="Answer" 
                                  required>{{ old('answer', $faq->answer) }}</textarea>
                        @if ($errors->has('answer'))
                            <span class="text-danger text-left">{{ $errors->first('answer') }}</span>
                        @endif
                    </div>
            
                   <div class="mb-3">
    <label class="form-label">FAQ Related To</label>

    <select class="form-control" name="type">
        <option value="">Select Category</option>
        <option value="course" {{ old('type',$faq->type)=='course' ? 'selected' : '' }}>Course</option>
        <option value="test_series" {{ old('type',$faq->type)=='test_series' ? 'selected' : '' }}>Test Series</option>
        <option value="study_material" {{ old('type',$faq->type)=='study_material' ? 'selected' : '' }}>Study Material</option>
        <option value="batches" {{ old('type',$faq->type)=='batches' ? 'selected' : '' }}>Batches</option>
        <option value="online_programme" {{ old('type',$faq->type)=='online_programme' ? 'selected' : '' }}>Online Programme</option>
        <option value="general" {{ old('type',$faq->type)=='general' ? 'selected' : '' }}>General</option>
    </select>

    <small class="text-muted">
        This FAQ will be shown under the selected section.
    </small>
</div>

                    <div class="mb-3 form-check">
    <input type="checkbox"
           class="form-check-input"
           id="showOnHome"
           name="show_on_home"
           value="1"
           {{ old('show_on_home', $faq->show_on_home) ? 'checked' : '' }}>

    <label class="form-check-label" for="showOnHome">
        Also show this FAQ on Home Page
    </label>
</div>
            
                    <button type="submit" class="btn btn-primary">Update FAQ</button>
                    <a href="{{ route('cm.faq') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
