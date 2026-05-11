@extends('layouts.app')

@section('title')
    Direct Enquiries
@endsection

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-title mb-0">Direct Enquiries</h5>
                        <h6 class="card-subtitle text-muted">
                            Manage enquiries section here.
                        </h6>
                    </div>

                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                        ← Back
                    </a>
                </div>

                {{-- Messages --}}
                <div class="mb-2">
                    @include('layouts.includes.messages')
                </div>

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Query For</th>
                                <th>Full Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Details</th>
                                <th>File</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enquiries as $enquiry)
                                <tr>
                                    <td>
                                        {{ ($enquiries->currentPage() - 1) * $enquiries->perPage() + $loop->iteration }}
                                    </td>
                                    <td>{{ $enquiry->query_for ?? '-' }}</td>
                                    <td>{{ $enquiry->full_name ?? '-' }}</td>
                                    <td>{{ $enquiry->mobile ?? '-' }}</td>
                                    <td>{{ $enquiry->email ?? '-' }}</td>
                                    <td>{{ Str::limit($enquiry->details, 50) }}</td>
                                    <td>
                                        @if($enquiry->file)
                                            <a href="{{ asset('storage/' . $enquiry->file) }}" title="Download File">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>

                                        <div class="dropdown">

                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">

                                                Actions

                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

                                                {{-- View Enquiry --}}
                                                <li>
                                                    <a href="{{ route('enquiries.direct.show', $enquiry->id) }}"
                                                        class="dropdown-item d-flex align-items-center gap-2">

                                                        <i class="fa fa-eye text-primary"></i>

                                                        View Enquiry

                                                    </a>
                                                </li>


                                                {{-- Delete --}}
                                                @if(\App\Helpers\Helper::canAccess('manage_direct_enquiries_delete'))

                                                    <li>

                                                        <form action="{{ route('enquiries.direct.delete', $enquiry->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this enquiry?');">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                class="dropdown-item d-flex align-items-center gap-2 text-danger">

                                                                <i class="fa fa-trash"></i>

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
                                    <td colspan="8" class="text-center text-muted">
                                        No enquiries found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $enquiries->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection