@extends('layouts.app')

@section('title', 'Test Series Summary')

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="mb-0">Test Series Summary</h5>
                        <small class="text-muted">Manage Test Series Summary here</small>
                    </div>

                    {{-- BACK BUTTON --}}
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                        ← Back
                    </a>
                </div>

                @include('layouts.includes.messages')

                {{-- SEARCH + CLEAR --}}
                <form method="GET" action="{{ route('students.student-test-series-summary') }}" class="d-flex gap-2 mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Search by name, email, mobile"
                        value="{{ request('search') }}">

                    <button class="btn btn-success">Search</button>

                    @if(request()->filled('search'))
                        <a href="{{ route('students.student-test-series-summary') }}" class="btn btn-secondary">
                            Clear
                        </a>
                    @endif
                </form>

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th>Date & Time</th>
                                <th>Student Name</th>
                                <th>Mobile</th>
                                <th>Order ID</th>
                                <th>Total Tests</th>
                                <th>Attempted</th>
                                <th>Pending</th>
                                <th>Status</th>
                                <th width="12%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $res)
                                <tr>
                                    {{-- INDEXING WITH PAGINATION --}}
                                    <td>
                                        {{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}
                                    </td>

                                    <td>{{ $res->created_at->format('d M Y, h:i A') }}</td>
                                    <td>{{ $res->name }}</td>
                                    <td>{{ $res->mobile }}</td>
                                    <td>{{ $res->last_order }}</td>
                                    <td>{{ $res->test_series_order_count }}</td>
                                    <td>{{ $res->test_series_order_attempt_count }}</td>
                                    <td>{{ $res->test_series_order_pending_count }}</td>
                                    <td>
                                        <span class="badge bg-success">Active</span>
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td>
                                        <div class="d-flex gap-2">

                                            {{-- View Student --}}
                                            @if(!empty($res->id))
                                                <a href="{{ route('students.student-profile-detail', $res->id) }}"
                                                    title="View Student">
                                                    <i class="fa fa-user-graduate"></i>
                                                </a>
                                            @endif

                                            {{-- View Test Series Detail --}}
                                            @if(!empty($res->id) && !empty($res->test_series_id))
                                                <a href="{{ route('test-series.detail', [$res->id, $res->test_series_id]) }}"
                                                    title="View Test Series Detail">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">
                                        No records found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $students->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection