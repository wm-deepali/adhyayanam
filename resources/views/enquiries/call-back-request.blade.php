@extends('layouts.app')

@section('title')
Call Back Request
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Call Back Request</h5>
            <h6 class="card-subtitle mb-2 text-muted"> Manage Call Back Request here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <div class="container mt-4">
                <table class="table table-striped mt-5">
                    <thead>
                        <tr>
                            <th scope="col" width="1%">#</th>
                            <th scope="col">Query For</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Mobile Number</th>
                            <th scope="col">Email</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($callbacks as $callback)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $callback->query_for }}</td>
                            <td>{{ $callback->full_name }}</td>
                            <td>{{ $callback->mobile}}</td>
                            <td>{{ $callback->email}}</td>
                            <td>
                                <form action="{{ route('enquiries.call.delete', $callback->id) }}" method="POST" style="display:inline;">
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