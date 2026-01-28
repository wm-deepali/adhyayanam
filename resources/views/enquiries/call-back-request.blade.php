@extends('layouts.app')

@section('title')
    Call Back Requests
@endsection

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="card-title mb-0">Call Back Requests</h5>
                    <h6 class="card-subtitle text-muted">
                        Manage call back requests here.
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
                            <th width="1%">#</th>
                            <th>Query For</th>
                            <th>Full Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th width="12%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($callbacks as $callback)
                            <tr>
                                {{-- INDEXING --}}
                                <td>
                                    {{ ($callbacks->currentPage() - 1) * $callbacks->perPage() + $loop->iteration }}
                                </td>

                                <td>{{ $callback->query_for ?? '-' }}</td>
                                <td>{{ $callback->full_name ?? '-' }}</td>
                                <td>{{ $callback->mobile ?? '-' }}</td>
                                <td>{{ $callback->email ?? '-' }}</td>

                                <td>
                                    <div class="d-flex gap-2">

                                        {{-- VIEW --}}
                                        <a href="{{ route('enquiries.call.show', $callback->id) }}"
                                           title="View Request">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        {{-- DOWNLOAD (if file exists) --}}
                                        @if(!empty($callback->file))
                                            <a href="{{ asset('storage/'.$callback->file) }}"
                                               title="Download File">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        @endif

                                        {{-- DELETE --}}
                                        @if(\App\Helpers\Helper::canAccess('manage_call_requests_delete'))
                                            <form action="{{ route('enquiries.call.delete', $callback->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this call request?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-link p-0 text-danger"
                                                        title="Delete">
                                                    <i class="fa fa-trash" style="color:#dc3545!important"></i>
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No call back requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $callbacks->links() }}
            </div>

        </div>
    </div>
</div>
@endsection