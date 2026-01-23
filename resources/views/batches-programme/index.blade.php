@extends('layouts.app')

@section('title')
    ADHYAYANAM | Batches and Online Programme
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <div class="d-flex mb-2">
                <div class="col">
                    <h5 class="card-title">Batches and Online Programme</h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        Manage Batches and Online Programme section here.
                    </h6>
                </div>

                <div class="justify-content-end">
                    @if(\App\Helpers\Helper::canAccess('manage_batches_add'))
                        <a href="{{ route('batches-programme.create') }}" class="btn btn-primary">
                            + Add
                        </a>
                    @endif
                </div>
            </div>

            <!-- SEARCH -->
            <form method="GET" action="{{ route('batches-programme.index') }}" class="d-flex mb-3">
                <input type="text" name="search" class="form-control me-2"
                       placeholder="Search by title"
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-success">Search</button>
            </form>

            @include('layouts.includes.messages')

            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Thumbnail</th>
                        <th>Banner</th>
                        <th>Heading</th>
                        <th>Start Date</th>
                        <th>MRP</th>
                        <th>Discount</th>
                        <th>Offered Price</th>
                        <th>Duration</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($batches as $data)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</td>

                            <td>
                                <img src="{{ url('storage/'.$data->thumbnail_image) }}"
                                     style="width:40px">
                            </td>

                            <td>
                                <img src="{{ url('storage/'.$data->banner_image) }}"
                                     style="width:40px">
                            </td>

                            <td>{{ $data->batch_heading }}</td>
                            <td>{{ $data->start_date }}</td>
                            <td>{{ $data->mrp }}</td>
                            <td>{{ $data->discount }}</td>
                            <td>{{ $data->offered_price }}</td>
                            <td>{{ $data->duration ?? 0 }} Days</td>
                            <td>{{ $data->creator->name ?? 'Super Admin' }}</td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                        Action
                                    </button>

                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item"
                                               href="{{ route('batches-programme.show',$data->id) }}">
                                                View
                                            </a>
                                        </li>

                                        @if(\App\Helpers\Helper::canAccess('manage_batches_edit'))
                                            <li>
                                                <a class="dropdown-item"
                                                   href="{{ route('batches-programme.edit',$data->id) }}">
                                                    Edit
                                                </a>
                                            </li>
                                        @endif

                                        @if(\App\Helpers\Helper::canAccess('manage_batches_delete'))
                                            <li>
                                                <form method="POST"
                                                      action="{{ route('batches-programme.delete',$data->id) }}"
                                                      onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item text-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">
                                No records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- PAGINATION LINKS -->
            <div class="d-flex justify-content-end mt-3">
                {{ $batches->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
