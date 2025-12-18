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
                        <h6 class="card-subtitle mb-2 text-muted"> Manage Batches and Online Programme section here.</h6>
                    </div>
                    <div class="justify-content-end">
                        @if(\App\Helpers\Helper::canAccess('manage_batches_add'))
                            <a href="{{ route('batches-programme.create') }}" class="btn btn-primary">
                                &#43; Add
                            </a>
                        @endif

                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Search Box -->
                    <form method="GET" action="{{ route('batches-programme.index') }}" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Search"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-success">Search</button>
                    </form>
                </div>
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <table class="table table-striped mt-5">
                    <thead>
                        <tr>
                            <th scope="col">Date & Time</th>
                            <th scope="col">Thumbnail</th>
                            <th scope="col">Banner</th>
                            <th scope="col">Heading</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">MRP</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Offered Price</th>
                            <th scope="col">Duration</th>
                            <th>Added By</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($batches as $data)
                            <tr>
                                <th scope="row">{{ Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</th>
                                <td><img style="height: auto;width: 40px;" src="{{url('storage/' . $data->thumbnail_image)}}"
                                        alt=""></td>
                                <td><img style="height: auto;width: 40px;" src="{{url('storage/' . $data->banner_image)}}"
                                        alt="">
                                </td>
                                <td>{{$data->batch_heading}}</td>
                                <td>{{$data->start_date}}</td>
                                <td>{{$data->mrp}}</td>
                                <td>{{$data->discount}}</td>
                                <td>{{$data->offered_price}}</td>
                                <td>{{$data->duration ?? "0"}} Days</td>
                                <td>{{ $data->creator ? $data->creator->name : 'N/A'  }}</td>
                                <td>
                                    @if(
                                            \App\Helpers\Helper::canAccess('manage_batches') ||
                                            \App\Helpers\Helper::canAccess('manage_batches_edit') ||
                                            \App\Helpers\Helper::canAccess('manage_batches_delete')
                                        )
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                id="actionDropdown{{ $data->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>

                                            <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $data->id }}">

                                                {{-- VIEW --}}
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('batches-programme.show', $data->id) }}">
                                                        View
                                                    </a>
                                                </li>

                                                {{-- EDIT --}}
                                                @if(\App\Helpers\Helper::canAccess('manage_batches_edit'))
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('batches-programme.edit', $data->id) }}">
                                                            Edit
                                                        </a>
                                                    </li>
                                                @endif

                                                {{-- DELETE --}}
                                                @if(\App\Helpers\Helper::canAccess('manage_batches_delete'))
                                                    <li>
                                                        <form action="{{ route('batches-programme.delete', $data->id) }}" method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this batch?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection