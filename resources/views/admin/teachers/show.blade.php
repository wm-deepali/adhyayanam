@extends('layouts.app')

@section('title', 'Teacher Profile')

@section('content')
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Teacher Profile: {{ $teacher->full_name }}</h3>

            <div>
                {{-- EDIT BUTTON --}}
                @if(\App\Helpers\Helper::canAccess('manage_teachers_edit'))
                    <a href="{{ route('manage-teachers.edit', $teacher->id) }}" class="btn btn-primary btn-sm me-2">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                @endif

                {{-- BACK BUTTON --}}
                <a href="{{ route('manage-teachers.index') }}" class="btn btn-secondary btn-sm">
                    Back to List
                </a>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Full Name</dt>
                <dd class="col-sm-9">{{ $teacher->full_name }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $teacher->email }}</dd>

                <dt class="col-sm-3">Mobile Number</dt>
                <dd class="col-sm-9">{{ $teacher->mobile_number }}</dd>

                <dt class="col-sm-3">WhatsApp Number</dt>
                <dd class="col-sm-9">{{ $teacher->whatsapp_number ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Gender</dt>
                <dd class="col-sm-9">{{ ucfirst($teacher->gender) ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Date of Birth</dt>
                <dd class="col-sm-9">{{ $teacher->dob ? $teacher->dob->format('d-m-Y') : 'N/A' }}</dd>

                <dt class="col-sm-3">Highest Qualification</dt>
                <dd class="col-sm-9">{{ $teacher->highest_qualification }}</dd>

                <dt class="col-sm-3">Experience (Years)</dt>
                <dd class="col-sm-9">{{ $teacher->total_experience }}</dd>

                <dt class="col-sm-3">Address</dt>
                <dd class="col-sm-9">{{ $teacher->full_address }}</dd>

                <dt class="col-sm-3">Country</dt>
                <dd class="col-sm-9">{{ $teacher->country }}</dd>

                <dt class="col-sm-3">State</dt>
                <dd class="col-sm-9">{{ $teacher->state }}</dd>

                <dt class="col-sm-3">City</dt>
                <dd class="col-sm-9">{{ $teacher->city }}</dd>

                <dt class="col-sm-3">Pin Code</dt>
                <dd class="col-sm-9">{{ $teacher->pin_code }}</dd>

                <dt class="col-sm-3">Allowed Languages</dt>
                <dd class="col-sm-9">{{ implode(', ', $teacher->allow_languages ?? []) }}</dd>

                <dt class="col-sm-3">Question Type Permissions</dt>
                <dd class="col-sm-9">
                    MCQ: {{ $teacher->allow_mcq ? 'Yes' : 'No' }} (₹{{ number_format($teacher->pay_per_mcq, 2) }})
                    <br>
                    Subjective: {{ $teacher->allow_subjective ? 'Yes' : 'No' }}
                    (₹{{ number_format($teacher->pay_per_subjective, 2) }})
                    <br>
                    Story / Passage-Based: {{ $teacher->allow_story ? 'Yes' : 'No' }}
                    (₹{{ number_format($teacher->pay_per_story, 2) }})
                </dd>

                <dt class="col-sm-3">Bank Details</dt>
                <dd class="col-sm-9">
                    UPI ID: {{ $teacher->upi_id ?? 'N/A' }}<br>
                    Account Name: {{ $teacher->account_name ?? 'N/A' }}<br>
                    Account Number: {{ $teacher->account_number ?? 'N/A' }}<br>
                    Bank Name: {{ $teacher->bank_name ?? 'N/A' }}<br>
                    Bank Branch: {{ $teacher->bank_branch ?? 'N/A' }}<br>
                    IFSC Code: {{ $teacher->ifsc_code ?? 'N/A' }}<br>
                    SWIFT Code: {{ $teacher->swift_code ?? 'N/A' }}
                </dd>

                <dt class="col-sm-3">Documents</dt>
                <dd class="col-sm-9">
                    PAN Card Number: {{ $teacher->pan_number ?? 'N/A' }} <br>
                    @if($teacher->pan_file)
                        <a href="{{ asset('storage/' . $teacher->pan_file) }}" target="_blank">View PAN Copy</a><br>
                    @endif
                    Aadhar Card Number: {{ $teacher->aadhar_number ?? 'N/A' }} <br>
                    @if($teacher->aadhar_front)
                        <a href="{{ asset('storage/' . $teacher->aadhar_front) }}" target="_blank">View Aadhar Front</a><br>
                    @endif
                    @if($teacher->aadhar_back)
                        <a href="{{ asset('storage/' . $teacher->aadhar_back) }}" target="_blank">View Aadhar Back</a><br>
                    @endif
                    @if($teacher->profile_picture)
                        <img src="{{ asset('storage/' . $teacher->profile_picture) }}" alt="Profile Picture" width="100"
                            class="rounded"><br>
                    @endif
                    @if($teacher->education_docs)
                        @foreach(json_decode($teacher->education_docs) as $doc)
                            <a href="{{ asset('storage/' . $doc) }}" target="_blank">View Education Document</a><br>
                        @endforeach
                    @endif
                    @if($teacher->cv)
                        <a href="{{ asset('storage/' . $teacher->cv) }}" target="_blank">View CV</a><br>
                    @endif
                </dd>
            </dl>
        </div>
    </div>
@endsection