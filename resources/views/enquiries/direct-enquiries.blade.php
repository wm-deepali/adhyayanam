@extends('layouts.app')

@section('title')
    Direct Enquiries
@endsection

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Direct Enquiries</h5>
                <h6 class="card-subtitle mb-2 text-muted"> Manage Enquiries section here.</h6>

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
                                <th scope="col">Details</th>
                                <th scope="col">File</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enquiries as $enquiry)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $enquiry->query_for }}</td>
                                    <td>{{ $enquiry->full_name }}</td>
                                    <td>{{ $enquiry->mobile}}</td>
                                    <td>{{ $enquiry->email}}</td>
                                    <td>{{ $enquiry->details}}</td>
                                    <td><a href="{{ asset('storage/' . $enquiry->file) }}" class="btn btn-primary"
                                            download>Download</a></td>
                                    <td>
                                        @if(\App\Helpers\Helper::canAccess('manage_direct_enquiries_delete'))
                                            <form action="{{ route('enquiries.direct.delete', $enquiry->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        @endif
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