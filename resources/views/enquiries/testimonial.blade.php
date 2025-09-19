@extends('layouts.app')

@section('title')
    Testimonials
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Testimonials</h5>
            <h6 class="card-subtitle mb-2 text-muted"> Manage Testimonials Request here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <div class="container mt-4">
                <table class="table table-striped mt-5">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Mobile Number</th>
                            <th scope="col">Message</th>
                            <th scope="col">Status</th>
                            <th scope="col">Is Approved</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($feeds as $data)
                        <tr>
                            <td><a href='{{ url('uploads/feed-photos/' . $data->photo) }}' download="{{ $data->username }}"><img src="{{ url('uploads/feed-photos/' . $data->photo) }}" alt="Uploaded Image" class="img-thumbnail" style="max-width: 80px; max-height: 80px;border-radius:10px;"></a></td>
                            <td>{{ $data->username }}</td>
                            <td>{{ $data->email}}</td>
                            <td>{{ $data->number}}</td>
                            <td>{{ $data->message}}</td>
                            <td>
                                <form action="{{ route('feed.updateStatus', $data->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Pending</option>
                                        <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                                    </select>
                                </form>
                            </td>
                            <td>{{ $data->is_approved == 1 ? 'Yes' : 'No'}}</td>
                            <td>{{ $data->created_at}}</td>
                            <td>
                            <a href="{{ route('testimonial.view', $data->id) }}" class="btn btn-sm btn-secondary">View</a>
                                <form action="{{ route('feed.delete', $data->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
