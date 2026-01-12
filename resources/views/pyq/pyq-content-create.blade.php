@extends('layouts.app')

@section('title')
    Create Pyq Content
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Create Pyq Content</h5>
            <h6 class="card-subtitle mb-2 text-muted">Fill in the details to add new content.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form id="pyq-content-form" method="POST" action="{{ route('pyq.content.store') }}">
                @csrf
            
                <!-- Commission ID -->
                <div class="mb-3">
                    <label for="examination_commission_id" class="form-label">Examination Commission</label>
                    <select class="form-select" name="commission_id" id="examination_commission_id" required>
                        <option value="" selected disabled>None</option>
                        @foreach($commissions as $commission)
                            <option value="{{ $commission->id }}">{{ $commission->name }}</option>
                        @endforeach
                    </select>
                    @error('commission_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Category ID -->
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" name="category_id" id="category_id" required>
                        <option value="" selected disabled>None</option>
                        <!-- Options will be dynamically loaded -->
                    </select>
                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Sub Category ID -->
                <div class="mb-3">
                    <label for="sub_category_id" class="form-label">Sub Category</label>
                    <select class="form-select" name="sub_category_id" id="sub_category_id">
                        <option value="" selected disabled>None</option>
                        <!-- Options will be dynamically loaded -->
                    </select>
                    @error('sub_category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="subject_id" class="form-label">Subject</label>
                    <select class="form-select" name="subject_id" id="subject_id">
                        <option value="" selected disabled>None</option>
                        <!-- Options will be dynamically loaded -->
                    </select>
                    @error('subject_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Heading -->
                <div class="mb-3">
                    <label for="heading" class="form-label">Heading</label>
                    <input type="text" class="form-control" name="heading" placeholder="Heading" required>
                    @if ($errors->has('heading'))
                        <span class="text-danger text-left">{{ $errors->first('heading') }}</span>
                    @endif
                </div>
            
                <!-- Detail Content -->
                <div class="mb-3">
                    <label for="detail_content" class="form-label">Detail Content</label>
                    <textarea id="editor" class="form-control" name="detail_content" placeholder="Detail Content" required></textarea>
                    @if ($errors->has('detail_content'))
                        <span class="text-danger text-left">{{ $errors->first('detail_content') }}</span>
                    @endif
                </div>
            
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('pyq.content.index') }}" class="btn">Back</a>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
          CKEDITOR.replace('editor', {
    filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
    filebrowserUploadMethod: 'form'
});
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const examinationCommissionSelect = document.getElementById('examination_commission_id');
    const categorySelect = document.getElementById('category_id');
    const subCategorySelect = document.getElementById('sub_category_id');

    examinationCommissionSelect.addEventListener('change', function() {
        const examinationCommissionId = this.value;
        if (examinationCommissionId) {
            fetchCategories(examinationCommissionId);
        }
    });

    categorySelect.addEventListener('change', function() {
        const categoryId = this.value;
        if (categoryId) {
            fetchSubCategories(categoryId);
        }
    });
    
    $('#sub_category_id').change(function() {
        var subCategoryId = $(this).val();
        if (subCategoryId) {
            $.ajax({
                url: "{{ route('fetch-subject-by-subcategory', ':sub_category_id') }}".replace(':sub_category_id', subCategoryId),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#subject_id').empty();
                        $('#subject_id').append(response.html);
                    } else {
                        console.error('Error: ' + response.msgText);
                        // You can handle the error here, for example, display a message to the user
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + error);
                    // You can handle the AJAX error here, for example, display a message to the user
                }
            });
        } else {
            $('#subject_id').empty();
            $('#subject_id').append('<option value="" selected disabled>Select Subject</option>');
        }
    });

    function fetchCategories(examinationCommissionId) {
        $.ajax({
            url: `{{ route('settings.categories', '') }}/${examinationCommissionId}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                categorySelect.innerHTML = '<option value="" selected disabled>None</option>';
                response.categories.forEach(category => {
                    categorySelect.innerHTML += `<option value="${category.id}">${category.name}</option>`;
                });
            },
            error: function(error) {
                console.error('Error fetching categories:', error);
            }
        });
    }

    function fetchSubCategories(categoryId) {
        $.ajax({
            url: `{{ route('settings.subcategories', '') }}/${categoryId}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                subCategorySelect.innerHTML = '<option value="" selected disabled>None</option>';
                response.subcategories.forEach(subcategory => {
                    subCategorySelect.innerHTML += `<option value="${subcategory.id}">${subcategory.name}</option>`;
                });
            },
            error: function(error) {
                console.error('Error fetching subcategories:', error);
            }
        });
    }
});
</script>
@endsection
