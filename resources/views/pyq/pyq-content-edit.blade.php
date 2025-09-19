@extends('layouts.app')

@section('title')
    Edit Pyq Content
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit Pyq Content</h5>
            <h6 class="card-subtitle mb-2 text-muted">Update the details of the content.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form id="pyq-content-form" method="POST" action="{{ route('pyq.content.update', $pyqContent->id) }}">
                @csrf
            
                <!-- Commission ID -->
                <div class="mb-3">
                    <label for="examination_commission_id" class="form-label">Examination Commission</label>
                    <select class="form-select" name="commission_id" id="examination_commission_id" required>
                        <option value="" disabled>None</option>
                        @foreach($commissions as $commission)
                            <option value="{{ $commission->id }}" {{ $pyqContent->commission_id == $commission->id ? 'selected' : '' }}>{{ $commission->name }}</option>
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
                        <option value="" disabled>None</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $pyqContent->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Sub Category ID -->
                <div class="mb-3">
                    <label for="sub_category_id" class="form-label">Sub Category</label>
                    <select class="form-select" name="sub_category_id" id="sub_category_id">
                        <option value="" disabled>None</option>
                        @foreach($subCategories as $subCategory)
                            <option value="{{ $subCategory->id }}" {{ $pyqContent->sub_category_id == $subCategory->id ? 'selected' : '' }}>{{ $subCategory->name }}</option>
                        @endforeach
                    </select>
                    @error('sub_category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="subject_id" class="form-label">Subject</label>
                    <select class="form-select" name="subject_id" id="subject_id">
                        <option value="" selected disabled>None</option>
                        @foreach($subjects as $subject)
                             <option value="{{ $subject->id }}" {{ $pyqContent->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                        <!-- Options will be dynamically loaded -->
                    </select>
                    @error('subject_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Heading -->
                <div class="mb-3">
                    <label for="heading" class="form-label">Heading</label>
                    <input type="text" class="form-control" name="heading" value="{{ $pyqContent->heading }}" required>
                    @error('heading')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Detail Content -->
                <div class="mb-3">
                    <label for="detail_content" class="form-label">Detail Content</label>
                    <textarea id="editor" class="form-control" name="detail_content" required>{{ $pyqContent->detail_content }}</textarea>
                    @error('detail_content')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('pyq.content.index') }}" class="btn">Back</a>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
         CKEDITOR.replace('editor');
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
