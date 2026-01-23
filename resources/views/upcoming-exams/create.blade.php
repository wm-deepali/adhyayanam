@extends('layouts.app')

@section('title')
Upcoming Exams | Create
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">

        {{-- HEADER --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0">Create</h5>
                <h6 class="card-subtitle text-muted">
                    Create Upcoming Exams here.
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
                  action="{{ route('upcoming.exam.store') }}"
                  enctype="multipart/form-data">
                @csrf

                <!-- COMMISSION -->
                <div class="mb-3">
                    <label class="form-label">Select Examination Commission</label>
                    <select class="form-control"
                            name="commission_id"
                            id="commission_id"
                            required>
                        <option value="">Select Examination Commission</option>
                        @foreach($commissions as $commission)
                            <option value="{{ $commission->id }}">
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
                           placeholder="Examination Name"
                           required>
                    @error('examination_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- ADVERTISEMENT DATE -->
                <div class="mb-3">
                    <label class="form-label">Date of Advertisement</label>
                    <input type="date"
                           class="form-control"
                           name="advertisement_date"
                           required>
                </div>

                <!-- FORM DISTRIBUTION DATE -->
                <div class="mb-3">
                    <label class="form-label">Form Distribution Date</label>
                    <input type="date"
                           class="form-control"
                           name="form_distribution_date"
                           required>
                </div>

                <!-- LAST DATE -->
                <div class="mb-3">
                    <label class="form-label">Last Date for Submission</label>
                    <input type="date"
                           class="form-control"
                           name="submission_last_date"
                           required>
                </div>

                <!-- EXAM DATE -->
                <div class="mb-3">
                    <label class="form-label">Examination Date</label>
                    <input type="date"
                           class="form-control"
                           name="examination_date"
                           required>
                </div>

                <!-- LINK -->
                <div class="mb-3">
                    <label class="form-label">Link</label>
                    <input type="url"
                           class="form-control"
                           name="link"
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
                    Save
                </button>

            </form>
        </div>
    </div>
</div>

{{-- AUTO-FILL SCRIPT --}}
<script>
document.getElementById('commission_id').addEventListener('change', function () {
    const commissionName =
        this.options[this.selectedIndex]?.text || '';

    const examNameInput = document.getElementById('examination_name');

    if (commissionName && examNameInput.value.trim() === '') {
        examNameInput.value = commissionName + ' Examination';
    }
});
</script>
@endsection
