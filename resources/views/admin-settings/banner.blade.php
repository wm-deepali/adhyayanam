@extends('layouts.app')

@section('title')
Banner Setting
@endsection

@section('content')
<div class="bg-light rounded p-3">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Banner Setting</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Update Banner Setting</h6>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            @if(\App\Helpers\Helper::canAccess('manage_banner_add'))
<button class="btn btn-primary mb-3 d-flex align-items-center" type="button"
        data-bs-toggle="collapse" data-bs-target="#bannerForm">
    <span class="me-2">Add</span> 
    <span id="toggleIcon" class="fas fa-plus"></span>
</button>
@endif
            <div class="collapse" id="bannerForm">
                <form method="POST" action="{{ route('settings.banner.store') }}" id="header-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mb-0">Please upload image size <span class="text-danger">1366px*509px </span> for the better view. <span class="text-danger">(Maximum Image weight 200KB) </span></p>
                                <div class="custom-img-uploader mt-2">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn-file">
                                                <input type="file" name="image" id="imgSec" required="">
                                                <img id='upload-img' style="max-width:240px" class="img-upload-block" src="{{ url('images/no_image.jpg') }}" />
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Banner Position</label>
                                        <select class="form-control" name="position" required="">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Banner Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Banner Name" required="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4" id="manage_button_url">
                            <div class="form-group">
                                <label>Slider / Banner Link</label>
                                <input type="text" class="form-control" name="link" placeholder="Enter Button Link....">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <button class="btn btn-primary waves-effect waves-float waves-light" type="submit">Add Banner</button>
                    </div>
                </form>
            </div>
            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th scope="col">Date & Time</th>
                        <th scope="col">Banner</th>
                        <th scope="col">Title</th>
                        <th scope="col">Position</th>
                        <th scope="col">Link</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners as $data)
                    <tr>
                        <th scope="row">{{ Carbon\Carbon::parse($data->created_at)->format('d M Y'); }}</th>
                        <td><img style="height: auto;width: 80px;" src="{{ asset('storage/' . $data->image) }}" alt="{{$data->name}}"></td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->position}}</td>
                        <td>{{$data->link}}</td>
                        <td>
    @if(\App\Helpers\Helper::canAccess('manage_banner_edit'))
        <a href="{{ route('settings.banner.edit', $data->id) }}" class="btn btn-sm btn-primary">
            Edit
        </a>
    @endif

    @if(\App\Helpers\Helper::canAccess('manage_banner_delete'))
        <form action="{{ route('settings.banner.delete', $data->id) }}" method="POST"
              style="display:inline-block;"
              onsubmit="return confirm('Delete this banner?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">
                Delete
            </button>
        </form>
    @endif

    @if(
        !\App\Helpers\Helper::canAccess('manage_banner_edit') &&
        !\App\Helpers\Helper::canAccess('manage_banner_delete')
    )
        <span class="text-muted">—</span>
    @endif
</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Image preview
        document.getElementById('imgSec').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                document.getElementById('upload-img').src = URL.createObjectURL(file);
            }
        });

        // Toggle button icon
        const bannerForm = document.getElementById('bannerForm');
        bannerForm.addEventListener('show.bs.collapse', function () {
            document.getElementById('toggleIcon').classList.remove('fa-plus');
            document.getElementById('toggleIcon').classList.add('fa-minus');
        });
        bannerForm.addEventListener('hide.bs.collapse', function () {
            document.getElementById('toggleIcon').classList.remove('fa-minus');
            document.getElementById('toggleIcon').classList.add('fa-plus');
        });
    });
</script>
@endsection
