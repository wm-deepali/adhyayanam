@extends('layouts.app')

@section('title')
    Edit Teacher
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-3">Edit Teacher</h3>

                @include('layouts.includes.messages')

                <form id="teacherForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Personal Profile --}}
                    <h4 class="mt-3 mb-3">Personal Profile</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="full_name" class="form-control" required
                                    value="{{ old('full_name', $teacher->full_name) }}">
                                <small class="form-text text-muted">Enter full name</small>
                            </div>

                            <div class="mb-3">
                                <label>Email ID <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required
                                    value="{{ old('email', $teacher->email) }}">
                                <small class="form-text text-muted">Enter a valid email (e.g. user@example.com)</small>
                            </div>

                            <div class="mb-3">
                                <label>Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" name="mobile_number" class="form-control" required pattern="[0-9]{10}"
                                    value="{{ old('mobile_number', $teacher->mobile_number) }}">
                                <small class="form-text text-muted">Must be exactly 10 digits</small>
                            </div>

                            <div class="mb-3">
                                <label>WhatsApp Number</label>
                                <input type="text" name="whatsapp_number" class="form-control"
                                    value="{{ old('whatsapp_number', $teacher->whatsapp_number) }}">
                                <small class="form-text text-muted">Optional, 10 digits</small>
                            </div>

                            <div class="mb-3">
                                <label>Gender</label>
                                <select class="form-control" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $teacher->gender) == 'male' ? 'selected' : '' }}>
                                        Male</option>
                                    <option value="female" {{ old('gender', $teacher->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $teacher->gender) == 'other' ? 'selected' : '' }}>
                                        Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" class="form-control"
                                    value="{{ old('dob', $teacher->dob ? $teacher->dob->format('Y-m-d') : '') }}">
                                <small class="form-text text-muted">Format: YYYY-MM-DD</small>
                            </div>

                            <div class="mb-3"><label>Highest Qualification</label>
                                <input type="text" name="highest_qualification" class="form-control"
                                    value="{{ old('highest_qualification', $teacher->highest_qualification) }}">
                            </div>
                            <div class="mb-3"><label>Total Experience (Years)</label>
                                <input type="number" name="total_experience" class="form-control"
                                    value="{{ old('total_experience', $teacher->total_experience) }}">
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="mb-3"><label>Full Address</label>
                                <textarea name="address"
                                    class="form-control">{{ old('address', $teacher->full_address) }}</textarea>
                            </div>
                            <div class="mb-3"><label>Country</label>
                                <input type="text" name="country" class="form-control"
                                    value="{{ old('country', $teacher->country) }}">
                            </div>
                            <div class="mb-3"><label>State</label>
                                <input type="text" name="state" class="form-control"
                                    value="{{ old('state', $teacher->state) }}">
                            </div>
                            <div class="mb-3"><label>City</label>
                                <input type="text" name="city" class="form-control"
                                    value="{{ old('city', $teacher->city) }}">
                            </div>
                            <div class="mb-3"><label>Pin Code</label>
                                <input type="text" name="pin_code" class="form-control"
                                    value="{{ old('pin_code', $teacher->pin_code) }}">
                            </div>
                            <div class="mb-3">
                                <label>Allowed Language</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="language[]" value="1"
                                        id="lang_hindi" {{ (in_array('1', old('language', $teacher->allow_languages ?? [])) ? 'checked' : '') }}>
                                    <label class="form-check-label" for="lang_hindi">Hindi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="language[]" value="2"
                                        id="lang_english" {{ (in_array('2', old('language', $teacher->allow_languages ?? [])) ? 'checked' : '') }}>
                                    <label class="form-check-label" for="lang_english">English</label>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- Account Setup --}}
                    <h4 class="mt-4 mb-3">Account Setup</h4>
                    <div id="account-setup-container">
                        @foreach($examMappings as $index => $mapping)
                            <div class="account-block row mb-3" data-index="{{ $index }}">
                                <div class="col-md-3 mb-3">
                                    <label>Examination Commission</label>
                                    <select name="exam_type[]" class="form-control exam_comission" data-index="{{ $index }}">
                                        <option value="">Select Commission</option>
                                        @foreach ($commissions as $commission)
                                            <option value="{{ $commission->id }}" @if($commission->id == $mapping->exam_type_id)
                                            selected @endif>{{ $commission->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label>Category</label>
                                    <select name="category[]" class="form-control category" data-index="{{ $index }}">
                                        <option value="">Select Category</option>
                                        @foreach($categories[$index] ?? [] as $category)
                                            <option value="{{ $category->id }}" @if($category->id == $mapping->category_id) selected
                                            @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3 sub-cat @if(!$mapping->sub_category_id) d-none @endif"
                                    data-index="{{ $index }}">
                                    <label>Sub Category</label>
                                    <select name="sub_category[]" class="form-control sub_category" data-index="{{ $index }}">
                                        <option value="">Select Sub Category</option>
                                        @foreach($subcategories[$index] ?? [] as $subcategory)
                                            <option value="{{ $subcategory->id }}" @if($subcategory->id == $mapping->sub_category_id)
                                            selected @endif>{{ $subcategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label>Subject</label>
                                    <select name="subject[]" class="form-control subject" data-index="{{ $index }}">
                                        <option value="">Select Subject</option>
                                        @foreach($subjects[$index] ?? [] as $subject)
                                            <option value="{{ $subject->id }}" @if($subject->id == $mapping->subject_id) selected
                                            @endif>{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-danger remove-block">Remove</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="addMore" class="btn btn-secondary mt-2">Add More</button>


                    {{-- Question Type Permission --}}
                    <h4 class="mt-4 mb-3">Question Type Permission</h4>
                    <div class="row">
                        @php
                            $questionTypes = ['MCQ', 'Subjective', 'Story / Passage-Based'];
                            $oldPermissions = old('question_type_permission', []);
                            $oldPayments = old('pay_per_question', []);
                        @endphp
                        @foreach($questionTypes as $type)
                            <div class="col-md-4 mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input qtype-checkbox" id="qtype_{{ $loop->index }}"
                                        value="{{ $type }}" name="question_type_permission[]" {{ in_array($type, $oldPermissions) ? 'checked' : '' }}>
                                    <labeWl class="form-check-label" for="qtype_{{ $loop->index }}">{{ $type }}</labeWl>
                                </div>
                                <div class="mt-2 pay-per-question"
                                    style="{{ in_array($type, $oldPermissions) ? 'display:block' : 'display:none' }}">
                                    <label>Pay Per Question (₹)</label>
                                    <input type="number" name="pay_per_question[{{ $type }}]" class="form-control" min="0"
                                        placeholder="Enter amount" value="{{ $oldPayments[$type] ?? '' }}">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        {{-- Bank Detail --}}
                        <div class="col-md-6">
                            <h4 class="mt-4 mb-3">Bank Detail</h4>
                            <div class="mb-3"><label>UPI ID</label><input type="text" name="upi_id" class="form-control"
                                    value="{{ old('upi_id', $teacher->upi_id) }}"></div>
                            <div class="mb-3"><label>Account Name</label><input type="text" name="account_name"
                                    class="form-control" value="{{ old('account_name', $teacher->account_name) }}"></div>
                            <div class="mb-3"><label>Account Number</label><input type="text" name="account_number"
                                    class="form-control" value="{{ old('account_number', $teacher->account_number) }}">
                            </div>
                            <div class="mb-3"><label>Confirm Account Number</label><input type="text"
                                    name="confirm_account_number" class="form-control"
                                    value="{{ old('confirm_account_number') }}"></div>
                            <div class="mb-3"><label>Bank Name</label><input type="text" name="bank_name"
                                    class="form-control" value="{{ old('bank_name', $teacher->bank_name) }}"></div>
                            <div class="mb-3"><label>Bank Branch</label><input type="text" name="bank_branch"
                                    class="form-control" value="{{ old('bank_branch', $teacher->bank_branch) }}"></div>
                            <div class="mb-3"><label>IFSC Code</label><input type="text" name="ifsc_code"
                                    class="form-control" value="{{ old('ifsc_code', $teacher->ifsc_code) }}"></div>
                            <div class="mb-3"><label>SWIFT Code</label><input type="text" name="swift_code"
                                    class="form-control" value="{{ old('swift_code', $teacher->swift_code) }}"></div>
                            {{-- Cancelled Cheque --}}
                            <div class="mb-3">
                                <label>Upload Cancelled Cheque</label>
                                <input type="file" name="cancelled_cheque" class="form-control">
                                <small class="form-text text-muted">Accepted: jpeg, jpg, png, pdf | Max size: 2MB</small>

                                @if($teacher->cancelled_cheque)
                                    <div class="mt-2">
                                        @if(Str::endsWith($teacher->cancelled_cheque, ['.jpg', '.jpeg', '.png']))
                                            <img src="{{ asset('storage/' . $teacher->cancelled_cheque) }}" class="img-thumbnail"
                                                style="max-width:150px;">
                                        @else
                                            <a href="{{ asset('storage/' . $teacher->cancelled_cheque) }}" target="_blank">View
                                                File</a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            {{-- QR Code --}}
                            <div class="mb-3">
                                <label>Upload QR Code</label>
                                <input type="file" name="qr_code" class="form-control">
                                <small class="form-text text-muted">Accepted: jpeg, jpg, png, pdf | Max size: 2MB</small>

                                @if($teacher->qr_code)
                                    <div class="mt-2">
                                        @if(Str::endsWith($teacher->qr_code, ['.jpg', '.jpeg', '.png']))
                                            <img src="{{ asset('storage/' . $teacher->qr_code) }}" class="img-thumbnail"
                                                style="max-width:150px;">
                                        @else
                                            <a href="{{ asset('storage/' . $teacher->qr_code) }}" target="_blank">View File</a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Documents --}}
                        <div class="col-md-6">
                            <h4 class="mt-4 mb-3">Documents</h4>
                            <div class="mb-3"><label>PAN Card Number</label><input type="text" name="pan_number"
                                    class="form-control" value="{{ old('pan_number', $teacher->pan_number) }}"></div>
                            {{-- PAN File --}}
                            <div class="mb-3">
                                <label>Upload PAN Card Copy</label>
                                <input type="file" name="pan_file" class="form-control">
                                <small class="form-text text-muted">Accepted: jpeg, jpg, png, pdf | Max size: 2MB</small>

                                @if($teacher->pan_file)
                                    <div class="mt-2">
                                        @if(Str::endsWith($teacher->pan_file, ['.jpg', '.jpeg', '.png']))
                                            <img src="{{ asset('storage/' . $teacher->pan_file) }}" class="img-thumbnail"
                                                style="max-width:150px;">
                                        @else
                                            <a href="{{ asset('storage/' . $teacher->pan_file) }}" target="_blank">View File</a>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            {{-- Aadhar Front --}}
                            <div class="mb-3">
                                <label>Upload Aadhar Card (Front)</label>
                                <input type="file" name="aadhar_front" class="form-control">
                                <small class="form-text text-muted">Accepted: jpeg, jpg, png, pdf | Max size: 2MB</small>

                                @if($teacher->aadhar_front)
                                    <div class="mt-2">
                                        @if(Str::endsWith($teacher->aadhar_front, ['.jpg', '.jpeg', '.png']))
                                            <img src="{{ asset('storage/' . $teacher->aadhar_front) }}" class="img-thumbnail"
                                                style="max-width:150px;">
                                        @else
                                            <a href="{{ asset('storage/' . $teacher->aadhar_front) }}" target="_blank">View File</a>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            {{-- Aadhar Back --}}
                            <div class="mb-3">
                                <label>Upload Aadhar Card (Back)</label>
                                <input type="file" name="aadhar_back" class="form-control">
                                <small class="form-text text-muted">Accepted: jpeg, jpg, png, pdf | Max size: 2MB</small>

                                @if($teacher->aadhar_back)
                                    <div class="mt-2">
                                        @if(Str::endsWith($teacher->aadhar_back, ['.jpg', '.jpeg', '.png']))
                                            <img src="{{ asset('storage/' . $teacher->aadhar_back) }}" class="img-thumbnail"
                                                style="max-width:150px;">
                                        @else
                                            <a href="{{ asset('storage/' . $teacher->aadhar_back) }}" target="_blank">View File</a>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            {{-- Profile Picture --}}
                            <div class="mb-3">
                                <label>Upload Profile Picture</label>
                                <input type="file" name="profile_picture" class="form-control file-input"
                                    data-preview="profile_preview">
                                <small class="form-text text-muted">Accepted: jpeg, jpg, png | Max size: 2MB</small>

                                <div id="profile_preview" class="mt-2">
                                    @if($teacher->profile_picture)
                                        <img src="{{ asset('storage/' . $teacher->profile_picture) }}" class="img-thumbnail"
                                            style="max-width:150px;">
                                    @endif
                                </div>
                            </div>

                            {{-- Education Docs --}}
                            <div class="mb-3">
                                <label>Upload Education Documents</label>
                                <input type="file" name="education_docs[]" class="form-control" multiple>
                                <small class="form-text text-muted">Accepted: pdf, doc, docx, jpeg, jpg, png | Max size: 5MB
                                    each</small>

                                @if($teacher->education_docs)
                                    <div class="mt-2">
                                        @foreach(json_decode($teacher->education_docs, true) as $doc)
                                            @if(Str::endsWith($doc, ['.jpg', '.jpeg', '.png']))
                                                <img src="{{ asset('storage/' . $doc) }}" class="img-thumbnail me-2 mb-2"
                                                    style="max-width:120px;">
                                            @else
                                                <a href="{{ asset('storage/' . $doc) }}" target="_blank" class="d-block">View File</a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            {{-- CV --}}
                            <div class="mb-3">
                                <label>Upload CV</label>
                                <input type="file" name="cv" class="form-control">
                                <small class="form-text text-muted">Accepted: pdf, doc, docx | Max size: 5MB</small>

                                @if($teacher->cv)
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $teacher->cv) }}" target="_blank">View CV</a>
                                    </div>
                                @endif
                            </div>


                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">Update Teacher</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('teacherForm').addEventListener('submit', function (e) {
            e.preventDefault();

            let form = e.target;
            let formData = new FormData(form);

            axios.post("{{ route('manage-teachers.update', $teacher->id) }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Teacher updated successfully!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ route('manage-teachers.index') }}";
                    });
                })
                .catch(function (error) {
                    if (error.response && error.response.status === 422) {
                        let errors = error.response.data.errors;
                        let messages = '';
                        for (let field in errors) {
                            errors[field].forEach(function (msg) {
                                messages += msg + '<br>';
                            });
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: messages,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An unexpected error occurred. Please try again.'
                        });
                    }
                });
        });


        $(document).ready(function () {
            var container = $('#account-setup-container');

            function loadCategories(commissionId, block) {
                var categorySelect = block.find('.category');
                if (!commissionId) {
                    categorySelect.html('<option value="">Select Category</option>');
                    resetSubcategoryAndSubject(block);
                    return;
                }
                axios.get(`/fetch-exam-category-by-commission/${commissionId}`).then(({ data }) => {
                    categorySelect.html(data.html);
                });
            }

            function resetSubcategoryAndSubject(block) {
                block.find('.sub-cat').addClass('d-none');
                block.find('.sub_category').html('<option value="">Select Subcategory</option>');
                block.find('.subject').html('<option value="">Select Subject</option>');
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
                axios.get(`/fetch-sub-category-by-exam-category/${categoryId}`).then(({ data }) => {
                    if (data.html) {
                        subCatWrapper.removeClass('d-none');
                        subcategorySelect.html(data.html);
                    } else {
                        subCatWrapper.addClass('d-none');
                        subcategorySelect.html('<option value="">Select Subcategory</option>');
                    }
                    block.find('.subject').html('<option value="">Select Subject</option>');
                });
            }

            function loadSubjects(subCategoryId, block) {
                var subjectSelect = block.find('.subject');
                if (!subCategoryId) {
                    subjectSelect.html('<option value="">Select Subject</option>');
                    return;
                }
                axios.get(`/fetch-subject-by-subcategory/${subCategoryId}`).then(({ data }) => {
                    subjectSelect.html(data.html);
                });
            }

            // Event handlers per block
            container.on('change', '.exam_comission', function () {
                var block = $(this).closest('.account-block');
                loadCategories($(this).val(), block);
                resetSubcategoryAndSubject(block);
            });
            container.on('change', '.category', function () {
                var block = $(this).closest('.account-block');
                loadSubcategories($(this).val(), block);
            });
            container.on('change', '.sub_category', function () {
                var block = $(this).closest('.account-block');
                loadSubjects($(this).val(), block);
            });

            // Add More Account block
            $('#addMore').click(() => {
                var first = container.find('.account-block').first();
                var clone = first.clone();

                clone.find('select').val('');
                clone.find('.sub-cat').addClass('d-none');
                clone.find('.sub_category, .subject').html('<option value="">Select</option>');
                container.append(clone);
            });

            // Remove block with minimum 1 enforcement
            container.on('click', '.remove-block', function () {
                if (container.find('.account-block').length > 1) {
                    $(this).closest('.account-block').remove();
                } else {
                    alert('At least one account setup block is required.');
                }
            });

            // Pay per question toggle
            $('.qtype-checkbox').change(function () {
                $(this).closest('.col-md-4').find('.pay-per-question').toggle(this.checked);
            });
        });
    </script>
@endsection