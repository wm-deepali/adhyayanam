@extends('layouts.app')

@section('title')
Study Material || Edit
@endsection

@section('content')

<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit</h5>
            <h6 class="card-subtitle mb-2 text-muted">Edit Study Material here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form id="study-form" method="POST" action="{{ route('study.material.update', $material->id) }}" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-control" name="category_id" id="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $material->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('category_id'))
                        <span class="text-danger text-left">{{ $errors->first('category_id') }}</span>
                    @endif
                </div>
                
                

                <div class="mb-3">
                    <label for="topic_id" class="form-label">Main Topic</label>
                    <select class="form-control" name="topic_id" id="topic_id" required>
                        <option value="">Select Main Topic</option>
                        @foreach($topics as $topic)
                            <option value="{{ $topic->id }}" {{ $topic->id == $material->topic_id ? 'selected' : '' }}>{{ $topic->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('topic_id'))
                        <span class="text-danger text-left">{{ $errors->first('topic_id') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" value="{{ $material->title }}" placeholder="Title" required>
                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="short_description" class="form-label">Short Description</label>
                    <textarea class="form-control" name="short_description" required>{{ $material->short_description }}</textarea>
                    @if ($errors->has('short_description'))
                        <span class="text-danger text-left">{{ $errors->first('short_description') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="detail_content" class="form-label">Description</label>
                    <textarea id="editor" name="detail_content" style="height: 200px;">{!! $material->detail_content !!}</textarea>
                    @if ($errors->has('detail_content'))
                        <span class="text-danger text-left">{{ $errors->first('detail_content') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="IsPaid" class="form-label">Paid</label>
                    <select class="form-control" name="IsPaid" id="IsPaid" required>
                        <option value="0" {{ $material->IsPaid == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $material->IsPaid == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                    @if ($errors->has('IsPaid'))
                        <span class="text-danger text-left">{{ $errors->first('IsPaid') }}</span>
                    @endif
                </div>

                <div class="mb-3 priceField" style="{{ $material->IsPaid == 1 ? '' : 'display: none;' }}">
                    <label for="mrp" class="form-label">MRP:</label>
                    <input type="number" class="form-control" id="mrp" name="mrp" value="{{ $material->mrp }}">
                    @if ($errors->has('mrp'))
                        <span class="text-danger text-left">{{ $errors->first('mrp') }}</span>
                    @endif
                </div>

                <div class="mb-3 priceField" style="{{ $material->IsPaid == 1 ? '' : 'display: none;' }}">
                    <label for="discount" class="form-label">Discount (%):</label>
                    <input type="number" class="form-control" id="discount" name="discount" value="{{ $material->discount }}">
                    @if ($errors->has('discount'))
                        <span class="text-danger text-left">{{ $errors->first('discount') }}</span>
                    @endif
                </div>

                <div class="mb-3 priceField" style="{{ $material->IsPaid == 1 ? '' : 'display: none;' }}">
                    <label for="offered-price" class="form-label">Offered Price:</label>
                    <input type="text" class="form-control" id="offered-price" name="price" value="{{ $material->price }}" readonly>
                    @if ($errors->has('price'))
                        <span class="text-danger text-left">{{ $errors->first('price') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" name="status" required>
                        <option value="Active" {{ $material->status == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ $material->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @if ($errors->has('status'))
                        <span class="text-danger text-left">{{ $errors->first('status') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="banner" class="form-label">Upload Banner</label>
                    <input type="file" class="form-control" name="banner" accept="image/*">
                    @if ($errors->has('banner'))
                        <span class="text-danger text-left">{{ $errors->first('banner') }}</span>
                    @endif
                    @if($material->banner)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $material->banner) }}" alt="Current Banner" style="height: 100px;">
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="pdf" class="form-label">Upload PDF</label>
                    <input type="file" class="form-control" name="pdf" accept="application/pdf">
                    @if ($errors->has('pdf'))
                        <span class="text-danger text-left">{{ $errors->first('pdf') }}</span>
                    @endif
                    @if($material->pdf)
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $material->pdf) }}" target="_blank" download="Material.pdf">View Current PDF</a>
                        </div>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" class="form-control" name="meta_title" value="{{ $material->meta_title }}" placeholder="Meta Title">
                    @if ($errors->has('meta_title'))
                        <span class="text-danger text-left">{{ $errors->first('meta_title') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="meta_keyword" class="form-label">Meta Keyword</label>
                    <input type="text" class="form-control" name="meta_keyword" value="{{ $material->meta_keyword }}" placeholder="Meta Keyword">
                    @if ($errors->has('meta_keyword'))
                        <span class="text-danger text-left">{{ $errors->first('meta_keyword') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <input type="text" class="form-control" name="meta_description" value="{{ $material->meta_description }}" placeholder="Meta Description">
                    @if ($errors->has('meta_description'))
                        <span class="text-danger text-left">{{ $errors->first('meta_description') }}</span>
                    @endif
                </div>
            
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('study.material.index') }}" class="btn">Back</a>
            </form>
            
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>

<script>
$(document).ready(function(){
    $("#IsPaid").change(function(){
        var data = $(this).val();
        if(data == 1){
            $(".priceField").show();
        } else {
            $(".priceField").hide();
        }
    });
    
    function calculateOfferedPrice() {
        var mrp = parseFloat($('#mrp').val());
        var discount = parseFloat($('#discount').val());

        if (isNaN(mrp) || isNaN(discount)) {
            $('#offered-price').val(mrp);
            return;
        }

        var offeredPrice = mrp - (mrp * (discount / 100));
        $('#offered-price').val(offeredPrice.toFixed(2));
    }

    $('#mrp, #discount').on('input', calculateOfferedPrice);
});

document.addEventListener('DOMContentLoaded', function() {
    CKEDITOR.replace('editor');
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // const examinationCommissionSelect = document.getElementById('commission_id');
    // const categorySelect = document.getElementById('category_id');

    // examinationCommissionSelect.addEventListener('change', function() {
    //     const examinationCommissionId = this.value;
    //     if (examinationCommissionId) {
    //         fetchCategories(examinationCommissionId);
    //     }
    // });

    // function fetchCategories(examinationCommissionId) {
    //     $.ajax({
    //         url: `{{ route('settings.categories', '') }}/${examinationCommissionId}`,
    //         type: 'GET',
    //         dataType: 'json',
    //         success: function(response) {
    //             categorySelect.innerHTML = '<option value="" selected disabled>None</option>';
    //             response.categories.forEach(category => {
    //                 categorySelect.innerHTML += `<option value="${category.id}">${category.name}</option>`;
    //             });
    //         },
    //         error: function(error) {
    //             console.error('Error fetching categories:', error);
    //         }
    //     });
    // }
});
$(document).on('change', '#category_id', function(event) {
            
    $('#topic_id').val("");
    let category = $(this).val();
    $.ajax({
        url: `{{ URL::to('study-material/main-topic/fetch-topic-by-category/${category}') }}`,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#topic_id').html(result.html);
            } else {
                //toastr.error('error encountered ' + result.msgText);
            }
        },
    });
});
</script>
@endsection