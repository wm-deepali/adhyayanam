@extends('layouts.app')

@section('title')
Edit FAQ
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit FAQ</h5>
            <h6 class="card-subtitle mb-2 text-muted">Update your FAQ here.</h6>

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
                        <label for="type" class="form-label">Type</label>
                        <input
                               type="text" 
                               class="form-control" 
                               name="type" 
                               placeholder="Type"
                               value="{{ old('type', $faq->type) }}">
                        @if ($errors->has('type'))
                            <span class="text-danger text-left">{{ $errors->first('type') }}</span>
                        @endif
                    </div>
            
                    <button type="submit" class="btn btn-primary">Update FAQ</button>
                    <a href="{{ route('cm.faq') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
