@extends('layouts.app')

@section('title')
Edit | Subject
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Edit</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Edit Subject Details</h6>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form method="POST" action="{{ route('cm.subject.update', $subject->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="exam_com_id" class="form-label">Course Type</label>
                    <select class="form-select" name="exam_com_id" id="exam_com_id" required>
                        <option value="" disabled>Select Course Type</option>
                        @foreach($commissions as $commission)
                        <option value="{{ $commission->id }}" {{ $subject->exam_com_id == $commission->id ? 'selected' : '' }}>{{ $commission->name }}</option>
                        @endforeach
                    </select>
                    @error('exam_com_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" name="category_id" id="category_id" required>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $subject->exam_com_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 sub-cat">
                    <label for="sub_category_id" class="form-label">Sub Category</label>
                    <select class="form-select" name="sub_category_id" id="sub_category_id" required>
                        @foreach($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}" {{ $subject->sub_category_id == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $subject->name }}" required>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="subject_code" class="form-label">Subject Code</label>
                    <input type="text" class="form-control" name="subject_code" placeholder="Subject Code" value="{{ $subject->subject_code }}" readonly>
                    @error('subject_code')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" name="status">
                        <option value="1" {{ $subject->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $subject->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('cm.subject') }}" class="btn">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Populate the category select based on the examination commission
        $('#exam_com_id').change(function() {
            var commissionId = $(this).val();
            $.ajax({
                url: "{{ url('fetch-exam-category-by-commission') }}/" + commissionId,
                type: 'GET',
                success: function(data) {
                    $('#category_id').html(data);
                }
            });
        });

        // Populate the sub-category select based on the selected category
        $('#category_id').change(function() {
            var categoryId = $(this).val();
            $.ajax({
                url: "{{ url('fetch-sub-category-by-exam-category') }}/" + categoryId,
                type: 'GET',
                success: function(data) {
                    if (data) {
                        $('#sub_category_id').html(data);
                        $('.sub-cat').removeClass('hidecls');
                    } else {
                        $('#sub_category_id').html('<option value="" selected disabled>Select Sub Category</option>');
                        $('.sub-cat').addClass('hidecls');
                    }
                }
            });
        });

        // Trigger change event to populate category and sub-category selects
        $('#exam_com_id').trigger('change');
        $('#category_id').trigger('change');
    });
</script>
@endsection
