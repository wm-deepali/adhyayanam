@extends('layouts.app')

@section('title')
    Create Teacher
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-3">Registration Form</h3>

                @include('layouts.includes.messages')
                <form id="teacherForm" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Personal Profile --}}
                    <h4 class="mt-3 mb-3">Personal Profile</h4>
                    <div class="row">
                        <div class="col-md-6">

                            {{-- Personal Profile --}}
                            <div class="mb-3">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="full_name" class="form-control" required>
                                <small class="form-text text-muted">Enter your full name</small>
                            </div>

                            <div class="mb-3">
                                <label>Email ID <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                                <small class="form-text text-muted">Enter a valid email (e.g. user@example.com)</small>
                            </div>

                            <div class="mb-3">
                                <label>Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" name="mobile_number" class="form-control" required pattern="[0-9]{10}">
                                <small class="form-text text-muted">Mobile should be exactly 10 digits.</small>
                            </div>

                            <div class="mb-3"><label>WhatsApp Number</label>
                                <input type="text" name="whatsapp_number" class="form-control">
                                <small class="form-text text-muted">Optional, 10 digits</small>
                            </div>
                            <div class="mb-3">
                                <label>Gender</label>
                                <select class="form-control" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3"><label>Date of Birth</label>
                                <input type="date" name="dob" class="form-control">
                                 <small class="form-text text-muted">Format: YYYY-MM-DD</small>
                            </div>
                            <div class="mb-3"><label>Highest Qualification</label>
                                <input type="text" name="highest_qualification" class="form-control">
                            </div>
                            <div class="mb-3"><label>Total Experience (Years)</label>
                                <input type="number" name="total_experience" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required minlength="6">
                                <small class="form-text text-muted">Password must be at least 6 characters.</small>
                            </div>

                            <div class="mb-3">
                                <label>Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required
                                    minlength="6">
                                <small class="form-text text-muted">Must match the password above.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3"><label>Full Address</label>
                                <textarea name="address" class="form-control"></textarea>
                            </div>
                            <div class="mb-3"><label>Country</label>
                                <input type="text" name="country" class="form-control">
                            </div>
                            <div class="mb-3"><label>State</label>
                                <input type="text" name="state" class="form-control">
                            </div>
                            <div class="mb-3"><label>City</label>
                                <input type="text" name="city" class="form-control">
                            </div>
                            <div class="mb-3"><label>Pin Code</label>
                                <input type="text" name="pin_code" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Allowed Language</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="language[]" value="1"
                                        id="lang_hindi">
                                    <label class="form-check-label" for="lang_hindi">Hindi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="language[]" value="2"
                                        id="lang_english">
                                    <label class="form-check-label" for="lang_english">English</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Account Setup --}}
                    <h4 class="mt-4 mb-3">Account Setup</h4>
                    <div id="account-container">
                        <div class="account-setup-block row mb-3">
                            <div class="col-md-3 mb-3">
                                <label>Examination Commission</label>
                                <select name="exam_type[]" class="form-control exam_comission">
                                    <option value="">Select Commission</option>
                                    @foreach ($commissions as $commission)
                                        <option value="{{ $commission->id }}">{{ $commission->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Category</label>
                                <select name="category[]" class="form-control category">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3 sub-cat d-none">
                                <label>Subcategory</label>
                                <select name="sub_category[]" class="form-control sub_category">
                                    <option value="">Select Subcategory</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Subject</label>
                                <select name="subject[]" class="form-control subject">
                                    <option value="">Select Subject</option>
                                </select>
                            </div>
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-danger remove-block" disabled>Remove</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addMore" class="btn btn-secondary mb-3">Add More</button>

                    {{-- Question Type Permission --}}
                    <h4 class="mt-4 mb-3">Question Type Permission</h4>
                    <div class="row">
                        @php
                            $questionTypes = ['MCQ', 'Subjective', 'Story / Passage-Based'];
                        @endphp
                        @foreach($questionTypes as $type)
                            <div class="col-md-4 mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input qtype-checkbox" id="qtype_{{ $loop->index }}"
                                        value="{{ $type }}" name="question_type_permission[]">
                                    <label class="form-check-label" for="qtype_{{ $loop->index }}">{{ $type }}</label>
                                </div>
                                <div class="mt-2 pay-per-question" style="display:none;">
                                    <label>Pay Per Question (₹)</label>
                                    <input type="number" name="pay_per_question[{{ $type }}]" class="form-control" min="0"
                                        placeholder="Enter amount">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Bank Detail --}}
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mt-4 mb-3">Bank Detail</h4>
                            <div class="mb-3"><label>UPI ID</label><input type="text" name="upi_id" class="form-control">
                            </div>
                            <div class="mb-3"><label>Account Name</label><input type="text" name="account_name"
                                    class="form-control"></div>
                            <div class="mb-3"><label>Account Number</label><input type="text" name="account_number"
                                    class="form-control"></div>
                            <div class="mb-3"><label>Confirm Account Number</label><input type="text"
                                    name="confirm_account_number" class="form-control"></div>
                            <div class="mb-3"><label>Bank Name</label><input type="text" name="bank_name"
                                    class="form-control"></div>
                            <div class="mb-3"><label>Bank Branch</label><input type="text" name="bank_branch"
                                    class="form-control"></div>
                            <div class="mb-3"><label>IFSC Code</label><input type="text" name="ifsc_code"
                                    class="form-control"></div>
                            <div class="mb-3"><label>SWIFT Code</label><input type="text" name="swift_code"
                                    class="form-control"></div>
                            <div class="mb-3">
                                <label>Upload Cancelled Cheque</label>
                                <input type="file" name="cancelled_cheque" class="form-control">
                                <small class="form-text text-muted">Accepted: jpeg, jpg, png, webp, pdf | Max size:
                                    2MB</small>
                            </div>
                            <div class="mb-3">
                                <label>Upload QR Code</label>
                                <input type="file" name="qr_code" class="form-control">
                                <small class="form-text text-muted">Accepted: jpeg, jpg, png, webp, pdf | Max size:
                                    2MB</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h4 class="mt-4 mb-3">Documents</h4>
                            <div class="mb-3"><label>PAN Card Number</label><input type="text" name="pan_number"
                                    class="form-control"></div>
                            <div class="mb-3">
                                <label>Upload PAN Card Copy</label>
                                <input type="file" name="pan_file" class="form-control">
                                <small class="form-text text-muted">Accepted: jpeg, jpg, png, webp, pdf | Max size:
                                    2MB</small>
                            </div>
                            <div class="mb-3"><label>Aadhar Card Number</label><input type="text" name="aadhar_number"
                                    class="form-control"></div>
                            <div class="mb-3">
                                <label>Upload Aadhar Card (Front)</label>
                                <input type="file" name="aadhar_front" class="form-control">
                                <small class="form-text text-muted">Accepted: jpeg, jpg, png, webp, pdf | Max size:
                                    2MB</small>
                            </div>

                            <div class="mb-3">
                                <label>Upload Aadhar Card (Back)</label>
                                <input type="file" name="aadhar_back" class="form-control">
                                <small class="form-text text-muted">Accepted: jpeg, jpg, png, webp, pdf | Max size:
                                    2MB</small>
                            </div>
                            <div class="mb-3">
                                <label>Upload Profile Picture</label>
                                <input type="file" name="profile_picture" class="form-control">
                                <small class="form-text text-muted">Accepted: jpeg, jpg, png, webp | Max size: 2MB</small>
                            </div>

                            <div class="mb-3">
                                <label>Upload Education Documents</label>
                                <input type="file" name="education_docs[]" class="form-control" multiple>
                                <small class="form-text text-muted">Accepted: pdf, doc, docx, jpeg, jpg, png | Max size: 5MB
                                    each</small>
                            </div>

                            <div class="mb-3">
                                <label>Upload CV</label>
                                <input type="file" name="cv" class="form-control">
                                <small class="form-text text-muted">Accepted: pdf, doc, docx | Max size: 5MB</small>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            var accountContainer = $('#account-container');

            // Load categories via AJAX
            function loadCategories(commissionId, block) {
                var categorySelect = block.find('.category');
                if (!commissionId) {
                    categorySelect.html('<option value="">Select Category</option>');
                    resetSubcategoryAndSubject(block);
                    return;
                }
                axios.get('/fetch-exam-category-by-commission/' + commissionId)
                    .then(function (response) {
                        if (response.data.success) {
                            categorySelect.html(response.data.html);
                        }
                    });
            }

            function resetSubcategoryAndSubject(block) {
                var subCatWrapper = block.find('.sub-cat');
                block.find('.sub_category').html('<option value="">Select Subcategory</option>');
                block.find('.subject').html('<option value="">Select Subject</option>');
                subCatWrapper.addClass('d-none');
            }

            function loadSubcategories(categoryId, block) {
                var subCatWrapper = block.find('.sub-cat');
                var subcategorySelect = block.find('.sub_category');
                if (!categoryId) {
                    subCatWrapper.addClass('d-none');
                    subcategorySelect.html('<option value="">Select Subcategory</option>');
                    block.find('.subject').html('<option value="">Select Subject</option>');
                    return;
                }
                axios.get('/fetch-sub-category-by-exam-category/' + categoryId)
                    .then(function (response) {
                        if (response.data.success) {
                            if (response.data.html) {
                                subCatWrapper.removeClass('d-none');
                                subcategorySelect.html(response.data.html);
                            } else {
                                subCatWrapper.addClass('d-none');
                                subcategorySelect.html('<option value="">Select Subcategory</option>');
                            }
                            block.find('.subject').html('<option value="">Select Subject</option>');
                        }
                    });
            }

            function loadSubjects(subCategoryId, block) {
                var subjectSelect = block.find('.subject');
                if (!subCategoryId) {
                    subjectSelect.html('<option value="">Select Subject</option>');
                    return;
                }
                axios.get('/fetch-subject-by-subcategory/' + subCategoryId)
                    .then(function (response) {
                        if (response.data.success) {
                            subjectSelect.html(response.data.html);
                        }
                    });
            }

            accountContainer.on('change', '.exam_comission', function () {
                var block = $(this).closest('.account-setup-block');
                var commissionId = $(this).val();
                loadCategories(commissionId, block);
            });

            accountContainer.on('change', '.category', function () {
                var block = $(this).closest('.account-setup-block');
                var categoryId = $(this).val();
                loadSubcategories(categoryId, block);
            });

            accountContainer.on('change', '.sub_category', function () {
                var block = $(this).closest('.account-setup-block');
                var subCategoryId = $(this).val();
                loadSubjects(subCategoryId, block);
            });

            $('#addMore').click(function () {
                var firstBlock = accountContainer.find('.account-setup-block').first();
                var clone = firstBlock.clone();

                clone.find('select').val('');
                clone.find('.sub-cat').addClass('d-none');
                clone.find('.sub_category, .subject').html('<option value="">Select</option>');

                accountContainer.append(clone);
                updateRemoveButtons();
            });

            accountContainer.on('click', '.remove-block', function () {
                if (accountContainer.find('.account-setup-block').length > 1) {
                    $(this).closest('.account-setup-block').remove();
                    updateRemoveButtons();
                } else {
                    alert('At least one account setup block is required.');
                }
            });

            function updateRemoveButtons() {
                var blocks = accountContainer.find('.account-setup-block');
                if (blocks.length === 1) {
                    blocks.find('.remove-block').attr('disabled', true);
                } else {
                    blocks.find('.remove-block').attr('disabled', false);
                }
            }

            updateRemoveButtons();

            // Pay Per Question toggle
            $('.qtype-checkbox').change(function () {
                var payBox = $(this).closest('.col-md-4').find('.pay-per-question');
                payBox.toggle(this.checked);
            });

            // Form submission with Axios + SweetAlert
            $('#teacherForm').submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                axios.post("{{ route('manage-teachers.store') }}", formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }).then(function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Teacher created successfully!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ route('manage-teachers.index') }}";
                    });
                }).catch(function (error) {
                    if (error.response && error.response.status === 422) {
                        let errors = error.response.data.errors;
                        let messages = '';
                        Object.keys(errors).forEach(function (key) {
                            errors[key].forEach(function (msg) {
                                messages += msg + '<br>';
                            });
                        });
                        Swal.fire('Validation Error', messages, 'error');
                    } else {
                        Swal.fire('Error', 'An unexpected error occurred. Please try again.', 'error');
                    }
                });
            });
        });
    </script>
@endsection