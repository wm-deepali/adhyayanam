@extends('layouts.app')

@section('title')
Edit|Sub Category
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Edit</h5>
                    <h6 class="card-subtitle mb-2 text-muted"> Edit Sub Category here.</h6>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <form method="POST" action="{{ route('cm.sub-category.update',$subCat->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
    <label class="form-label">Examination Commission</label>
    <select class="form-select"
            id="commission_id"
            name="examination_commission_id"
            required>

        <option value="" disabled>Select Commission</option>

        @foreach($commissions as $commission)
            <option value="{{ $commission->id }}"
                {{ $commission->id == $subCat->examination_commission_id ? 'selected' : '' }}>
                {{ $commission->name }}
            </option>
        @endforeach
    </select>
</div>

              <div class="mb-3">
    <label class="form-label">Category</label>
    <select class="form-select" name="category_id" id="category_id" required>
        <option value="" disabled>Select Category</option>

        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                {{ $category->id == $subCat->category_id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{$subCat->name ?? ''}}" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" class="form-control" name="meta_title" placeholder="Meta Title" value="{{$subCat->meta_title ?? ''}}">
                    @error('meta_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="meta_keyword" class="form-label">Meta Keywords</label>
                    <input type="text" class="form-control" name="meta_keyword" placeholder="Meta Keywords" value="{{$subCat->meta_keyword ?? ''}}">
                    @error('meta_keyword')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" name="meta_description" placeholder="Meta Description">{{$subCat->meta_description ?? ''}}</textarea>
                    @error('meta_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="canonical_url" class="form-label">Canonical URL</label>
                    <input type="url" class="form-control" name="canonical_url" placeholder="Canonical URL" value="{{$subCat->canonical_url ?? ''}}">
                    @error('canonical_url')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" name="image" accept="image/*">
                    <img src="{{asset('storage/'.$subCat->image)}}" style="max-width:65px;" alt="">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="alt_tag" class="form-label">Alt Tag</label>
                    <input type="text" class="form-control" name="alt_tag" placeholder="Alt Tag" value="{{$subCat->alt_tag ?? ''}}">
                    @error('alt_tag')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="1" {{$subCat->status==1 ? 'selected':''}}>Active</option>
                        <option value="0" {{$subCat->status==1 ? 'selected':''}}>Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{route('cm.category')}}" class="btn">Back</a>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const commissionSelect = document.getElementById('commission_id');
    const categorySelect = document.getElementById('category_id');

    commissionSelect.addEventListener('change', function () {

        const commissionId = this.value;

        categorySelect.innerHTML =
            '<option selected disabled>Loading categories...</option>';

        fetch(`{{ url('fetch-exam-category-by-commission') }}/${commissionId}`)
            .then(res => res.json())
            .then(result => {

                if (result.success) {
                    categorySelect.innerHTML = result.html;
                } else {
                    categorySelect.innerHTML =
                        '<option value="" disabled>No categories found</option>';
                }
            })
            .catch(() => {
                categorySelect.innerHTML =
                    '<option value="" disabled>Error loading categories</option>';
            });
    });

});
</script>

@endsection