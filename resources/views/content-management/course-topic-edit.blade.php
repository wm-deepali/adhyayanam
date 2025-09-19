@extends('layouts.app')

@section('title')
Edit|Topic
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Edit</h5>
                    <h6 class="card-subtitle mb-2 text-muted"> Edit Topic here.</h6>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form method="POST" action="{{ route('topic.update',$topic->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="exam_com_id" class="form-label">Examination Commission</label>
                    <select class="form-select" name="exam_com_id" id="exam_com_id" required>
                        <option value="" selected disabled>None</option>
                        @foreach($commissions as $commission)
                            <option @if($topic->exam_com_id == $commission->id) selected @endif value="{{ $commission->id }}">{{ $commission->name }}</option>
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
                        <option @if($topic->category_id == $category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 sub-cat hidecls">
                    <label for="sub_category_id" class="form-label">Sub Category</label>
                    <select class="form-select" name="sub_category_id" id="sub_category_id" >
                        @foreach($subcategories as $subcategory)
                        <option @if($topic->sub_category_id == $subcategory->id) selected @endif value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                    @endforeach
                    </select>
                    
                </div>
                <div class="mb-3">
                    <label for="subject_id" class="form-label">Subject</label>
                    <select class="form-select" name="subject_id" required id="subject_id">
                        <option value="">Select </option>
                        @foreach($subjects as $subject)
                            <option @if($topic->subject_id == $subject->id) selected @endif value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="chapter_id" class="form-label">Chapter</label>
                    <select class="form-select" name="chapter_id" required id="chapter_id">
                        <option value="">Select</option>
                        @foreach($chapters as $chapter)
                        <option @if($topic->chapter_id == $chapter->id) selected @endif value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                    @endforeach
                    </select>
                    @error('chapter_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{$topic->name}}" required>
                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="topic_number" class="form-label">Topic Number</label>
                    <input type="text" class="form-control" name="topic_number" placeholder="Topic Number" value="{{$topic->topic_number}}">
                    @if ($errors->has('topic_number'))
                        <span class="text-danger text-left">{{ $errors->first('topic_number') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control" name="description" placeholder="Description" required value="{{$topic->description}}">
                    @if ($errors->has('description'))
                        <span class="text-danger text-left">{{ $errors->first('description') }}</span>
                    @endif
                </div>
            
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" name="status">
                        <option @if($topic->status == 1) selected @endif value="1">Active</option>
                        <option @if($topic->status == 0) selected @endif  value="0">Inactive</option>
                    </select>
                    @if ($errors->has('status'))
                        <span class="text-danger text-left">{{ $errors->first('status') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{route('cm.chapter')}}" class="btn">Back</a>
            </form>
            
        </div>
    </div>
</div>
@endsection
<script>
     $(document).ready(function() {
    $(document).on('change', '#exam_com_id', function(event) {
            
            $('#category_id').val("").trigger('change');
            let competitive_commission = $(this).val();
            $.ajax({
                url: `{{ URL::to('fetch-exam-category-by-commission/${competitive_commission}') }}`,
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        $('#category_id').html(result.html);
                    } else {
                        toastr.error('error encountered ' + result.msgText);
                    }
                },
            });
        });

        $(document).on('change', '#category_id', function(event) {
            
            $('#sub_category_id').val("").trigger('change');
            let exam_category = $(this).val();
            if(exam_category !='')
            {
                $.ajax({
                url: `{{ URL::to('fetch-sub-category-by-exam-category/${exam_category}') }}`,
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        if(result.html !='')
                        {
                            $('#sub_category_id').html(result.html);
                            $('.sub-cat').removeClass('hidecls');
                            $('#sub_category_id').attr("required", true);
                        }
                        else{
                            $('#sub_category_id').val("").trigger('change');
                            $('.sub-cat').addClass('hidecls');
                            $('#sub_category_id').attr("required", false);
                        }
                        
                    } else {
                        toastr.error('error encountered ' + result.msgText);
                    }
                },
                });
            }
            else{
                $('#sub_category_id').val("").trigger('change');
                $('.sub-cat').addClass('hidecls');
                $('#sub_category_id').attr("required", false);
            }
            
        });

        $(document).on('change', '#exam_com_id,#category_id,#sub_category_id', function(e) {
            e.preventDefault(e);

            $('#subject_id').val("").trigger('change');
            let competitive_commission = $('#exam_com_id').val();
            let category_id = $('#category_id').val();
            let sub_category_id = $('#sub_category_id').val();
            $.ajax({
                headers: { "Access-Control-Allow-Origin": "*" },
                url: `{{ URL::to('fetch-subject/${competitive_commission}/${category_id}/${sub_category_id}') }}`,
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        $('#subject_id').html(result.html);
                    } else {
                        alert(result.msgText);
                        //toastr.error('error encountered ' + result.msgText);
                    }
                },
            });
        });
        $(document).on('change', '#subject_id', function(event) {
            
            $('#chapter_id').val("").trigger('change');
            let subject = $(this).val();
            if(subject !='')
            {
                $.ajax({
                url: `{{ URL::to('fetch-chapter-by-subject/${subject}') }}`,
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        if(result.html !='')
                        {
                            $('#chapter_id').html(result.html);
                        }
                        else{
                            $('#chapter_id').val("").trigger('change');
                        }
                        
                    } else {
                        toastr.error('error encountered ' + result.msgText);
                    }
                },
                });
            }
            
        });
    });
</script>