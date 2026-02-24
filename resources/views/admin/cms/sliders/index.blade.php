@extends('layouts.app')

@section('title', 'Manage Sliders')

@section('content')
<div class="bg-light rounded p-2">
<div class="card">
<div class="card-body">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Homepage Sliders</h5>

        <button class="btn btn-primary" onclick="openCreateModal()">
            + Add Slider
        </button>
    </div>

    @include('layouts.includes.messages')

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th width="120">Image</th>
                <th>Button</th>
                <th>URL</th>
                <th width="80">Status</th>
                <th width="150">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sliders as $slider)
            <tr>
                <td>
                    <img src="{{ asset('storage/'.$slider->image) }}" width="100">
                </td>
                <td>{{ $slider->button_name ?? '-' }}</td>
                <td>{{ $slider->url ?? '-' }}</td>
                <td>
                    @if($slider->status)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Off</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-sm btn-info"
                        onclick="openEditModal(
                            {{ $slider->id }},
                            '{{ asset('storage/'.$slider->image) }}',
                            `{{ $slider->button_name }}`,
                            `{{ $slider->url }}`
                        )">
                        Edit
                    </button>

                    <form method="POST"
                          action="{{ route('cm.home.slider.delete', $slider->id) }}"
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this slider?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No sliders found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
</div>
</div>


<!-- ================= MODAL ================= -->
<div class="modal fade" id="sliderModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<form id="sliderForm" enctype="multipart/form-data">
    @csrf

    <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Add Slider</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <input type="hidden" id="slider_id" name="id">

        <!-- Image -->
        <div class="mb-3">
            <label class="form-label">Image *</label>
            <input type="file" name="image" id="imageInput" class="form-control">
            <img id="previewImage" class="mt-2 rounded"
                 style="max-width:150px; display:none;">
        </div>

        <!-- Button Name -->
        <div class="mb-3">
            <label class="form-label">Button Name</label>
            <input type="text" name="button_name" id="button_name" class="form-control">
        </div>

        <!-- URL -->
        <div class="mb-3">
            <label class="form-label">URL</label>
            <input type="text" name="url" id="url" class="form-control">
            <small class="text-muted">
                If URL provided, clicking image will redirect.
            </small>
        </div>

    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary"
                data-coreui-dismiss="modal">Cancel</button>
    </div>

</form>

</div>
</div>
</div>
@endsection


@push('after-scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const sliderModal = new coreui.Modal(document.getElementById('sliderModal'));
    const form = document.getElementById('sliderForm');

    // OPEN CREATE
    window.openCreateModal = function () {
        document.getElementById('modalTitle').innerText = 'Add Slider';
        form.reset();
        document.getElementById('slider_id').value = '';
        document.getElementById('previewImage').style.display = 'none';
        sliderModal.show();
    }

    // OPEN EDIT
    window.openEditModal = function (id, image, button, url) {
        document.getElementById('modalTitle').innerText = 'Edit Slider';

        document.getElementById('slider_id').value = id;
        document.getElementById('button_name').value = button ?? '';
        document.getElementById('url').value = url ?? '';

        let preview = document.getElementById('previewImage');
        preview.src = image;
        preview.style.display = 'block';

        sliderModal.show();
    }

    // IMAGE PREVIEW
    document.getElementById('imageInput').addEventListener('change', function(e){
        if (e.target.files.length) {
            let preview = document.getElementById('previewImage');
            preview.src = URL.createObjectURL(e.target.files[0]);
            preview.style.display = 'block';
        }
    });

    // AJAX SUBMIT
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(form);
        let id = document.getElementById('slider_id').value;

        let url = id
            ? "/content-management/cms/home-sliders/" + id
            : "{{ route('cm.home.slider.store') }}";

        axios.post(url, formData)
            .then(() => {
                sliderModal.hide();
                location.reload();
            })
            .catch(error => {
                console.log(error);
                alert('Error saving slider');
            });
    });

});
</script>
@endpush