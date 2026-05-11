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

                                        <div class="dropdown">

                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">

                                                Actions

                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

                                                {{-- View Request --}}
                                                <li>
                                                    <a href="{{ route('enquiries.call.show', $callback->id) }}"
                                                        class="dropdown-item d-flex align-items-center gap-2">

                                                        <i class="fa fa-eye text-primary"></i>

                                                        View Request

                                                    </a>
                                                </li>


                                                {{-- Download File --}}
                                                @if(!empty($callback->file))

                                                    <li>
                                                        <a href="{{ asset('storage/' . $callback->file) }}"
                                                            class="dropdown-item d-flex align-items-center gap-2">

                                                            <i class="fa fa-download text-success"></i>

                                                            Download File

                                                        </a>
                                                    </li>

                                                @endif


                                                {{-- Delete --}}
                                                @if(\App\Helpers\Helper::canAccess('manage_call_requests_delete'))

                                                    <li>

                                                        <form action="{{ route('enquiries.call.delete', $callback->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this call request?');">

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
                    {{ $callbacks->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection