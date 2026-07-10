@extends('front-users.layouts.app')

@section('title')
    My Profile
@endsection

<style>
    @media (max-width: 740px) {
        .content {
            padding: 0 !important;
        }
    }

    .profile-avatar-wrapper {
        position: relative;
        width: 110px;
        height: 110px;
    }

    .profile-avatar-wrapper img {
        width: 110px;
        height: 110px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-avatar-edit-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        background: #0d6efd;
        color: #fff;
        border: 2px solid #fff;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
</style>

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <h4 class="text-dark">My Profile</h4>
                <hr>
                @include('front-users.layouts.includes.messages')

                <!-- ============ BASIC INFO BOX ============ -->
                <div class="box">
                    <div class="box-body">
                        <form id="profileInfoForm" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex align-items-center mb-30">
                                <div class="profile-avatar-wrapper">
                                    <img src="{{ auth()->user()->avatar
        ? url('storage/' . auth()->user()->avatar)
        : url('src/images/avatar/avatar-13.png') }}" alt="profile"
                                        id="profile_image_preview">
                                    <label for="profile_image_input" class="profile-avatar-edit-btn">
                                        <i class="fa fa-camera"></i>
                                    </label>
                                    <input type="file" name="profile_image" id="profile_image_input"
                                        accept="image/png,image/jpeg,image/jpg" style="display:none">
                                </div>
                                <div class="ps-20">
                                    <h5 class="mb-0">{{ auth()->user()->name ?? 'User Name' }}</h5>
                                    <p class="my-5 text-fade">{{ auth()->user()->type ?? 'Student' }}</p>
                                    <p class="mb-0 text-fade">Username: {{ auth()->user()->username ?? '-' }}</p>
                                </div>
                            </div>
                            <span id="profile_image_msg" style="display:none" class="text-danger d-block mb-15"></span>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name"
                                        value="{{ auth()->user()->first_name }}" required>
                                    <span id="first_name_msg" style="display:none" class="text-danger"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name"
                                        value="{{ auth()->user()->last_name }}" required>
                                    <span id="last_name_msg" style="display:none" class="text-danger"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" name="date_of_birth" id="date_of_birth"
                                        value="{{ auth()->user()->date_of_birth ? \Carbon\Carbon::parse(auth()->user()->date_of_birth)->format('Y-m-d') : '' }}">
                                    <span id="date_of_birth_msg" style="display:none" class="text-danger"></span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ auth()->user()->gender == 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female" {{ auth()->user()->gender == 'Female' ? 'selected' : '' }}>
                                            Female</option>
                                        <option value="Other" {{ auth()->user()->gender == 'Other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    <span id="gender_msg" style="display:none" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <span id="profile_success_msg"></span>
                            </div>

                            <button type="button" class="btn btn-primary" id="saveProfileBtn">Save Changes</button>
                        </form>
                    </div>
                </div>

                <!-- ============ MOBILE NUMBER BOX ============ -->
                <div class="box">
                    <div class="box-body">
                        <div class="d-md-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="text-primary fw-500">Mobile Number</h5>
                                <p class="mb-0" id="current_mobile_display">{{ auth()->user()->mobile ?? 'Not Added' }}</p>
                            </div>
                            <button class="btn btn-info" data-toggle="modal" data-target="#changeMobileModal">Change
                                Number</button>
                        </div>
                    </div>
                </div>

                <!-- ============ EMAIL BOX ============ -->
                <div class="box">
                    <div class="box-body">
                        <div class="d-md-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="text-primary fw-500">Email ID</h5>
                                <p class="mb-0" id="current_email_display">{{ auth()->user()->email ?? 'Not Added' }}</p>
                            </div>
                            <button class="btn btn-info" data-toggle="modal" data-target="#changeEmailModal">Change
                                Email</button>
                        </div>
                    </div>
                </div>


                <!-- ============ REFERRAL CODE BOX ============ -->
                <div class="box">
                    <div class="box-body">
                        <div class="d-md-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="text-primary fw-500">My Referral Code</h5>
                                <p class="mb-0">
                                    Share this code with friends. You'll earn a bonus in your wallet every time someone
                                    signs up using it.
                                </p>
                            </div>
                            <div class="d-flex align-items-center mt-2 mt-md-0">
                                <input type="text" class="form-control text-center fw-bold" id="referral_code_display"
                                    value="{{ auth()->user()->referral_code ?? '-' }}" readonly
                                    style="max-width: 150px; letter-spacing: 2px;">
                                <button class="btn btn-info ms-2" id="copyReferralCodeBtn" type="button">
                                    <i class="fa fa-copy"></i> Copy
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Change Mobile Modal -->
        <div class="modal fade" id="changeMobileModal" tabindex="-1" aria-labelledby="changeMobileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="changeMobileModalLabel">Change Mobile Number</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="mobile_step1">
                            <div class="mb-3">
                                <label for="new_mobile_number" class="form-label">Enter New Mobile Number</label>
                                <input type="text" class="form-control" id="new_mobile_number" maxlength="10"
                                    placeholder="10 digit mobile number">
                                <span id="new_mobile_number_msg" style="display:none" class="text-danger"></span>
                            </div>
                        </div>
                        <div id="mobile_step2" style="display:none">
                            <p class="mb-2">OTP sent to <b id="mobile_otp_sent_to"></b></p>
                            <div class="mb-3">
                                <label for="mobile_otp" class="form-label">Enter OTP</label>
                                <input type="text" class="form-control" id="mobile_otp" maxlength="4"
                                    placeholder="4 digit OTP">
                                <span id="mobile_otp_msg" style="display:none" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="sendMobileOtpBtn">Submit</button>
                        <button type="button" class="btn btn-primary" id="verifyMobileOtpBtn"
                            style="display:none">Verify</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Email Modal -->
        <div class="modal fade" id="changeEmailModal" tabindex="-1" aria-labelledby="changeEmailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="changeEmailModalLabel">Change Email ID</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="email_step1">
                            <div class="mb-3">
                                <label for="new_email_id" class="form-label">Enter New Email ID</label>
                                <input type="email" class="form-control" id="new_email_id" placeholder="you@example.com">
                                <span id="new_email_id_msg" style="display:none" class="text-danger"></span>
                            </div>
                        </div>
                        <div id="email_step2" style="display:none">
                            <p class="mb-2">OTP sent to <b id="email_otp_sent_to"></b></p>
                            <div class="mb-3">
                                <label for="email_otp" class="form-label">Enter OTP</label>
                                <input type="text" class="form-control" id="email_otp" maxlength="4"
                                    placeholder="4 digit OTP">
                                <span id="email_otp_msg" style="display:none" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="sendEmailOtpBtn">Submit</button>
                        <button type="button" class="btn btn-primary" id="verifyEmailOtpBtn"
                            style="display:none">Verify</button>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection

@push('after-scripts')
    <script>
        // ============ PROFILE PHOTO PREVIEW ============
        $('#profile_image_input').on('change', function () {
            let file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#profile_image_preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        // ============ SAVE BASIC PROFILE INFO ============
        $('#saveProfileBtn').on('click', function () {
            var flag = true;
            function check_field(id) {
                if (!$('#' + id).val()) {
                    $('#' + id + '_msg').fadeIn(200).show().html('Required Field');
                    flag = false;
                } else {
                    $('#' + id + '_msg').fadeOut(200).hide();
                }
            }
            check_field('first_name');
            check_field('last_name');

            if (!flag) {
                return false;
            }

            var data = new FormData($('#profileInfoForm')[0]);

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ route('user.profile.update') }}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result.success) {
                        $('#profile_success_msg').css('color', 'green').html('🗹 ' + result.message);
                        if (result.profile_image_url) {
                            $('#profile_image_preview').attr('src', result.profile_image_url);
                        }
                    } else {
                        if (result.code == 422) {
                            $.each(result.errors, function (key, value) {
                                $('#' + key + '_msg').fadeIn(200).show().html(value[0]);
                            });
                        }
                    }
                },
                error: function () {
                    $('#profile_success_msg').css('color', 'red').html('Something went wrong. Please try again.');
                }
            });
        });

        // ============ CHANGE MOBILE ============
        let currentNewMobile = '';

        $('#sendMobileOtpBtn').on('click', function () {
            let mobile = $('#new_mobile_number').val().trim();
            if (!/^\d{10}$/.test(mobile)) {
                $('#new_mobile_number_msg').fadeIn(200).show().text('Enter valid 10 digit mobile number');
                return;
            }
            $('#new_mobile_number_msg').fadeOut(200).hide();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ route('send-otp-change-mobile') }}",
                type: 'POST',
                data: { mobile_number: mobile },
                success: function (result) {
                    if (result.success) {
                        currentNewMobile = mobile;
                        $('#mobile_otp_sent_to').text(mobile);
                        $('#mobile_step1').hide();
                        $('#mobile_step2').show();
                        $('#sendMobileOtpBtn').hide();
                        $('#verifyMobileOtpBtn').show();
                    } else {
                        $('#new_mobile_number_msg').fadeIn(200).show().text(result.message || 'Something went wrong');
                    }
                },
                error: function () {
                    $('#new_mobile_number_msg').fadeIn(200).show().text('Something went wrong. Please try again.');
                }
            });
        });

        $('#verifyMobileOtpBtn').on('click', function () {
            let otp = $('#mobile_otp').val().trim();
            if (!otp) {
                $('#mobile_otp_msg').fadeIn(200).show().text('Enter OTP');
                return;
            }
            $('#mobile_otp_msg').fadeOut(200).hide();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ route('verify-change-mobile') }}",
                type: 'POST',
                data: { mobile_number: currentNewMobile, otp: otp },
                success: function (result) {
                    if (result.success) {
                        alert(result.message);
                        window.location.href = "{{ url('/user/profile') }}";
                    } else {
                        $('#mobile_otp_msg').fadeIn(200).show().text(result.message || 'Incorrect OTP');
                    }
                },
                error: function () {
                    $('#mobile_otp_msg').fadeIn(200).show().text('Something went wrong. Please try again.');
                }
            });
        });

        // ============ CHANGE EMAIL ============
        let currentNewEmail = '';

        $('#sendEmailOtpBtn').on('click', function () {
            let email = $('#new_email_id').val().trim();
            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                $('#new_email_id_msg').fadeIn(200).show().text('Enter valid email address');
                return;
            }
            $('#new_email_id_msg').fadeOut(200).hide();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ route('send-otp-change-email') }}",
                type: 'POST',
                data: { email: email },
                success: function (result) {
                    if (result.success) {
                        currentNewEmail = email;
                        $('#email_otp_sent_to').text(email);
                        $('#email_step1').hide();
                        $('#email_step2').show();
                        $('#sendEmailOtpBtn').hide();
                        $('#verifyEmailOtpBtn').show();
                    } else {
                        $('#new_email_id_msg').fadeIn(200).show().text(result.message || 'Something went wrong');
                    }
                },
                error: function () {
                    $('#new_email_id_msg').fadeIn(200).show().text('Something went wrong. Please try again.');
                }
            });
        });

        $('#verifyEmailOtpBtn').on('click', function () {
            let otp = $('#email_otp').val().trim();
            if (!otp) {
                $('#email_otp_msg').fadeIn(200).show().text('Enter OTP');
                return;
            }
            $('#email_otp_msg').fadeOut(200).hide();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ route('verify-change-email') }}",
                type: 'POST',
                data: { email: currentNewEmail, otp: otp },
                success: function (result) {
                    if (result.success) {
                        alert(result.message);
                        window.location.href = "{{ url('/user/profile') }}";
                    } else {
                        $('#email_otp_msg').fadeIn(200).show().text(result.message || 'Incorrect OTP');
                    }
                },
                error: function () {
                    $('#email_otp_msg').fadeIn(200).show().text('Something went wrong. Please try again.');
                }
            });
        });

        // ============ COPY REFERRAL CODE ============
        $('#copyReferralCodeBtn').on('click', function () {
            let codeField = document.getElementById('referral_code_display');
            codeField.select();
            codeField.setSelectionRange(0, 99999); // for mobile

            navigator.clipboard.writeText(codeField.value).then(function () {
                let btn = $('#copyReferralCodeBtn');
                let originalHtml = btn.html();
                btn.html('<i class="fa fa-check"></i> Copied!');
                setTimeout(function () {
                    btn.html(originalHtml);
                }, 1500);
            }).catch(function () {
                alert('Copy failed. Please copy manually: ' + codeField.value);
            });
        });
    </script>
@endpush