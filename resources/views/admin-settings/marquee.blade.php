@extends('layouts.app')

@section('title')
Marquee Setting
@endsection

@section('content')
<div class="bg-light rounded p-3">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Marquee Setting</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Update Marquee Setting</h6>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            @if(\App\Helpers\Helper::canAccess('manage_marquee_add'))
<button class="btn btn-primary mb-3 d-flex align-items-center" type="button"
        data-bs-toggle="collapse" data-bs-target="#bannerForm">
    <span class="me-2">Add</span> 
    <span id="toggleIcon" class="fas fa-plus"></span>
</button>
@endif

            <div class="collapse" id="bannerForm">
                <form method="POST" action="{{ route('settings.marquee.store') }}" id="header-form">
                    @csrf
                    <div class="row mt-2">
                        <div class="col-md-4" id="manage_button_url">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" placeholder="Enter Text....">
                            </div>
                        </div>
                        <div class="col-md-4" id="manage_button_url">
                            <div class="form-group">
                                <label>Link</label>
                                <input type="text" class="form-control" name="link" placeholder="Enter Button Link....">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <button class="btn btn-primary waves-effect waves-float waves-light" type="submit">Add Marquee</button>
                    </div>
                </form>
            </div>
            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th scope="col">Date & Time</th>
                        <th scope="col">Title</th>
                        <th scope="col">Link</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($marquees as $data)
                    <tr>
                        <th scope="row">{{ Carbon\Carbon::parse($data->created_at)->format('d M Y'); }}</th>
                        <td>{{$data->title}}</td>
                        <td>{{$data->link}}</td>
                        <td>
    @if(\App\Helpers\Helper::canAccess('manage_marquee_edit'))
        <a href="{{ route('settings.marquee.edit', $data->id) }}"
           class="btn btn-sm btn-primary">
            Edit
        </a>
    @endif

    @if(\App\Helpers\Helper::canAccess('manage_marquee_delete'))
        <form action="{{ route('settings.marquee.delete', $data->id) }}"
              method="POST"
              style="display:inline-block;"
              onsubmit="return confirm('Delete this marquee?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">
                Delete
            </button>
        </form>
    @endif

    @if(
        !\App\Helpers\Helper::canAccess('manage_marquee_edit') &&
        !\App\Helpers\Helper::canAccess('manage_marquee_delete')
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
