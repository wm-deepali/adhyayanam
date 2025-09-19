@extends('layouts.app')

@section('title')
Upcoming Exams | Create
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Create</h5>
                    <h6 class="card-subtitle mb-2 text-muted"> Create Upcoming Exams here.</h6>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form method="POST" action="{{ route('upcoming.exam.store') }}" enctype="multipart/form-data">
                @csrf
            
                <!-- Commission -->
                <div class="mb-3">
                    <label for="commission_id" class="form-label">Select Examination Commission</label>
                    <select class="form-control" name="commission_id" required>
                        <option value="">Select Examination Commission</option>
                        @foreach($commissions as $commission)
                            <option value="{{ $commission->id }}">{{ $commission->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('commission_id'))
                        <span class="text-danger text-left">{{ $errors->first('commission_id') }}</span>
                    @endif
                </div>
            
                <!-- Examination Name -->
                <div class="mb-3">
                    <label for="examination_name" class="form-label">Enter Examination Name</label>
                    <input type="text" class="form-control" name="examination_name" placeholder="Examination Name" required>
                    @if ($errors->has('examination_name'))
                        <span class="text-danger text-left">{{ $errors->first('examination_name') }}</span>
                    @endif
                </div>
            
                <!-- Advertisement Date -->
                <div class="mb-3">
                    <label for="advertisement_date" class="form-label">Select Date of Advertisement</label>
                    <input type="date" class="form-control" name="advertisement_date" required>
                    @if ($errors->has('advertisement_date'))
                        <span class="text-danger text-left">{{ $errors->first('advertisement_date') }}</span>
                    @endif
                </div>
            
                <!-- Form Distribution Date -->
                <div class="mb-3">
                    <label for="form_distribution_date" class="form-label">Select Form Distribution Date</label>
                    <input type="date" class="form-control" name="form_distribution_date" required>
                    @if ($errors->has('form_distribution_date'))
                        <span class="text-danger text-left">{{ $errors->first('form_distribution_date') }}</span>
                    @endif
                </div>
            
                <!-- Last Date for Submission -->
                <div class="mb-3">
                    <label for="submission_last_date" class="form-label">Select Last Date for Submission</label>
                    <input type="date" class="form-control" name="submission_last_date" required>
                    @if ($errors->has('submission_last_date'))
                        <span class="text-danger text-left">{{ $errors->first('submission_last_date') }}</span>
                    @endif
                </div>
            
                <!-- Examination Date -->
                <div class="mb-3">
                    <label for="examination_date" class="form-label">Examination Date</label>
                    <input type="date" class="form-control" name="examination_date" required>
                    @if ($errors->has('examination_date'))
                        <span class="text-danger text-left">{{ $errors->first('examination_date') }}</span>
                    @endif
                </div>
            
                <!-- Link -->
                <div class="mb-3">
                    <label for="link" class="form-label">Enter Link</label>
                    <input type="url" class="form-control" name="link" placeholder="Link">
                    @if ($errors->has('link'))
                        <span class="text-danger text-left">{{ $errors->first('link') }}</span>
                    @endif
                </div>
            
                <!-- PDF -->
                <div class="mb-3">
                    <label for="pdf" class="form-label">Upload PDF (If any)</label>
                    <input type="file" class="form-control" name="pdf" accept="application/pdf">
                    @if ($errors->has('pdf'))
                        <span class="text-danger text-left">{{ $errors->first('pdf') }}</span>
                    @endif
                </div>
            
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('upcoming.exam.index') }}" class="btn">Back</a>
            </form>            
        </div>
    </div>
</div>
@endsection