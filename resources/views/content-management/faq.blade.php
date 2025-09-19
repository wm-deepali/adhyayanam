@extends('layouts.app')

@section('title')
FAQ Management
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">FAQ</h5>
            <h6 class="card-subtitle mb-2 text-muted"> Manage your faq section here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <div class="container mt-4">
                <form method="POST" action="{{ route('faq.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <input 
                               type="text" 
                               class="form-control" 
                               name="question" 
                               placeholder="Question" required>
                        @if ($errors->has('question'))
                            <span class="text-danger text-left">{{ $errors->first('question') }}</span>
                        @endif
                    </div>
            
                    <div class="mb-3">
                        <label for="answer" class="form-label">Answer</label>
                        <textarea class="form-control" 
                                  name="answer" 
                                  placeholder="Answer" required></textarea>
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
                               placeholder="Type">
                        @if ($errors->has('type'))
                            <span class="text-danger text-left">{{ $errors->first('type') }}</span>
                        @endif
                    </div>
            
                    <button type="submit" class="btn btn-primary">Save FAQ</button>
                </form>
                <table class="table table-striped mt-5">
                    <thead>
                        <tr>
                            <th scope="col" width="1%">#</th>
                            <th scope="col" width="15%">Question</th>
                            <th scope="col">Answer</th>
                            <th scope="col" width="10%">Type</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($faqs as $faq)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $faq->question }}</td>
                            <td>{{ $faq->answer }}</td>
                            <td>{{ $faq->type ?? "--" }}</td>
                            <td>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection