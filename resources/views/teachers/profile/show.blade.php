@extends('layouts.teacher-app')

@section('title')
    Profile
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">

            <div class="card-body">
                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <h5 class="card-title">Your Details</h5>

                <dl class="row mt-4">
                    <dt class="col-sm-3">Name</dt>
                    <dd class="col-sm-9">{{ $teacher->full_name }}</dd>

                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9">{{ $teacher->email }}</dd>

                    <dt class="col-sm-3">Mobile</dt>
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
                        MCQ: {{ $teacher->allow_mcq ? 'Yes' : 'No' }} (₹{{ number_format($teacher->pay_per_mcq, 2) }})<br>
                        Subjective: {{ $teacher->allow_subjective ? 'Yes' : 'No' }} (₹{{ number_format($teacher->pay_per_subjective, 2) }})<br>
                        Story / Passage-Based: {{ $teacher->allow_story ? 'Yes' : 'No' }} (₹{{ number_format($teacher->pay_per_story, 2) }})
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
                        PAN Card Number: {{ $teacher->pan_number ?? 'N/A' }}<br>
                        @if($teacher->pan_file)
                            <a href="{{ asset('storage/'.$teacher->pan_file) }}" target="_blank">View PAN Copy</a><br>
                        @endif
                        Aadhar Card Number: {{ $teacher->aadhar_number ?? 'N/A' }}<br>
                        @if($teacher->aadhar_front)
                            <a href="{{ asset('storage/'.$teacher->aadhar_front) }}" target="_blank">View Aadhar Front</a><br>
                        @endif
                        @if($teacher->aadhar_back)
                            <a href="{{ asset('storage/'.$teacher->aadhar_back) }}" target="_blank">View Aadhar Back</a><br>
                        @endif
                        @if($teacher->profile_picture)
                            <img src="{{ asset('storage/'.$teacher->profile_picture) }}" alt="Profile Picture" width="100" class="rounded"><br>
                        @endif
                        @if($teacher->education_docs)
                            @foreach(json_decode($teacher->education_docs) as $doc)
                                <a href="{{ asset('storage/'.$doc) }}" target="_blank">View Education Document</a><br>
                            @endforeach
                        @endif
                        @if($teacher->cv)
                            <a href="{{ asset('storage/'.$teacher->cv) }}" target="_blank">View CV</a><br>
                        @endif
                    </dd>
                </dl>

                <div class="mt-4">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        Change Password
                    </button>
                </div>

                <!-- Change Password Modal -->
                <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('teacher.change-password', $teacher->id) }}">
                            @csrf
                            @method('PATCH')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" name="password" id="password" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
