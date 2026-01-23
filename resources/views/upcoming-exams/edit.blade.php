@extends('layouts.app')

@section('title')
Upcoming Exams | Edit
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">

        {{-- HEADER --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0">Edit</h5>
                <h6 class="card-subtitle text-muted">
                    Edit Upcoming Exam here.
                </h6>
            </div>

            <div>
                <a href="{{ route('upcoming.exam.index') }}" class="btn btn-secondary">
                    ← Back
                </a>
            </div>
        </div>

        {{-- BODY --}}
        <div class="card-body">

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <form method="POST"
                  action="{{ route('upcoming.exam.update', $exam->id) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- IMPORTANT --}}

                <!-- COMMISSION -->
                <div class="mb-3">
                    <label class="form-label">Select Examination Commission</label>
                    <select class="form-control"
                            name="commission_id"
                            id="commission_id"
                            required>
                        <option value="">Select Examination Commission</option>
                        @foreach($commissions as $commission)
                            <option value="{{ $commission->id }}"
                                {{ $commission->id == $exam->commission_id ? 'selected' : '' }}>
                                {{ $commission->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('commission_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- EXAMINATION NAME (AUTO + EDITABLE) -->
                <div class="mb-3">
                    <label class="form-label">Examination Name</label>
                    <input type="text"
                           class="form-control"
                           name="examination_name"
                           id="examination_name"
                           value="{{ old('examination_name', $exam->examination_name) }}"
                           required>
                    @error('examination_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- ADVERTISEMENT DATE -->
                <div class="mb-3">
                    <label class="form-label">Date of Advertisement</label>
                    <input type="date" class="form-control"
                           name="advertisement_date"
                           value="{{ $exam->advertisement_date }}" required>
                </div>

                <!-- FORM DISTRIBUTION DATE -->
                <div class="mb-3">
                    <label class="form-label">Form Distribution Date</label>
                    <input type="date" class="form-control"
                           name="form_distribution_date"
                           value="{{ $exam->form_distribution_date }}" required>
                </div>

                <!-- LAST DATE -->
                <div class="mb-3">
                    <label class="form-label">Last Date for Submission</label>
                    <input type="date" class="form-control"
                           name="submission_last_date"
                           value="{{ $exam->submission_last_date }}" required>
                </div>

                <!-- EXAM DATE -->
                <div class="mb-3">
                    <label class="form-label">Examination Date</label>
                    <input type="date" class="form-control"
                           name="examination_date"
                           value="{{ $exam->examination_date }}" required>
                </div>

                <!-- LINK -->
                <div class="mb-3">
                    <label class="form-label">Link</label>
                    <input type="url"
                           class="form-control"
                           name="link"
                           value="{{ $exam->link }}"
                           placeholder="Enter link">
                </div>

                <!-- PDF -->
                <div class="mb-3">
                    <label class="form-label">Upload PDF (If any)</label>
                    <input type="file"
                           class="form-control"
                           name="pdf"
                           accept="application/pdf">
                </div>

                <!-- ACTION -->
                <button type="submit" class="btn btn-primary">
                    Update
                </button>

            </form>
        </div>
    </div>
</div>

{{-- AUTO-FILL SCRIPT (LIKE CREATE PAGE) --}}
<script>
document.getElementById('commission_id').addEventListener('change', function () {

    const commissionName =
        this.options[this.selectedIndex]?.text || '';

    const examNameInput = document.getElementById('examination_name');

    // Only auto-fill if user has not typed anything manually
    if (commissionName && examNameInput.value.trim() === '') {
        examNameInput.value = commissionName + ' Examination';
    }
});
</script>
@endsection
