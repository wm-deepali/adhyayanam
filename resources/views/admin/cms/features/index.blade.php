@extends('layouts.app')
@section('title', 'Institute Features')

@section('content')
<div class="card">
<div class="card-body">

    <div class="d-flex justify-content-between mb-3">
        <h5 class="mb-0">Institute Features</h5>

        <button class="btn btn-primary" onclick="openCreateModal()">
            + Add Feature
        </button>
    </div>

    @include('layouts.includes.messages')

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th width="90">Image</th>
                <th>Title</th>
                <th>Description</th>
                <th width="140">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($features as $feature)
            <tr>
                <td>
                    @if($feature->image)
                        <img src="{{ asset('storage/'.$feature->image) }}"
                             width="60"
                             class="rounded">
                    @endif
                </td>

                <td>{{ $feature->title }}</td>

                <td>{!! Str::limit(strip_tags($feature->short_description), 60) !!}</td>

                <td>
                    <button class="btn btn-sm btn-info"
                        onclick="openEditModal(
                            {{ $feature->id }},
                            '{{ asset('storage/'.$feature->image) }}',
                            `{{ $feature->title }}`,
                            `{{ addslashes($feature->short_description) }}`
                        )">
                        Edit
                    </button>

                    <form method="POST"
                          action="{{ route('cm.institute.features.delete', $feature->id) }}"
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this feature?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No features added yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
</div>
@endsection



<!-- ================= MODAL ================= -->
<div class="modal fade" id="featureModal">
<div class="modal-dialog">
<div class="modal-content">

<form method="POST" id="featureForm" enctype="multipart/form-data">
    @csrf

    <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Add Feature</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <input type="hidden" id="feature_id">

        <!-- Image -->
        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" id="imageInput" class="form-control">
            <img id="previewImg" class="mt-2 rounded"
                 style="max-width:100px; display:none;">
        </div>

        <!-- Title -->
        <div class="mb-3">
            <label>Title</label>
            <input type="text"
                   name="title"
                   id="title"
                   class="form-control"
                   required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label>Description</label>
            <textarea id="descEditor"
                      name="short_description"
                      class="form-control"></textarea>
        </div>

    </div>

    <div class="modal-footer">
        <button class="btn btn-primary">Save</button>
    </div>

</form>

</div>
</div>
</div>



@push('after-scripts')

<script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function(){

    const modal = new coreui.Modal(document.getElementById('featureModal'));
    const form = document.getElementById('featureForm');

    // CKEditor
    CKEDITOR.replace('descEditor', {
        height: 120,
        toolbar: [
            ['Bold','Italic','BulletedList','Link','Unlink']
        ]
    });

    // OPEN CREATE
    window.openCreateModal = function() {
        document.getElementById('modalTitle').innerText = 'Add Feature';
        form.action = "{{ route('cm.institute.features.store') }}";
        form.reset();
        CKEDITOR.instances.descEditor.setData('');
        document.getElementById('previewImg').style.display = 'none';
        document.getElementById('feature_id').value = '';
        modal.show();
    }

    // OPEN EDIT
    window.openEditModal = function(id, image, title, desc) {
        document.getElementById('modalTitle').innerText = 'Edit Feature';
        form.action = "/content-management/cms/institute-features/update/" + id;

        document.getElementById('title').value = title;
        CKEDITOR.instances.descEditor.setData(desc);

        const preview = document.getElementById('previewImg');

        if(image){
            preview.src = image;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }

        modal.show();
    }

    // IMAGE PREVIEW
    document.getElementById('imageInput').addEventListener('change', function(e){
        if(e.target.files.length){
            const preview = document.getElementById('previewImg');
            preview.src = URL.createObjectURL(e.target.files[0]);
            preview.style.display = 'block';
        }
    });

});
</script>

@endpush