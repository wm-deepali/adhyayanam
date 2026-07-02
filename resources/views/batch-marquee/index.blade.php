@extends('layouts.app')

@section('title')
    ADHYAYANAM | Batch Marquee
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">

                <div class="d-flex mb-2">
                    <div class="col">
                        <h5 class="card-title">Batch Marquee</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            Manage Batch Marquee here.
                        </h6>
                    </div>

                    <div class="justify-content-end">
                        <a href="{{ route('batch-marquee.create') }}" class="btn btn-primary">
                            + Add
                        </a>
                    </div>
                </div>

                <!-- SEARCH -->
                <form method="GET" action="{{ route('batch-marquee.index') }}" class="d-flex mb-3">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search marquee"
                        value="{{ request('search') }}">

                    <button type="submit" class="btn btn-success">
                        Search
                    </button>
                </form>

                @include('layouts.includes.messages')

                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Content</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($marquees as $marquee)
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($marquee->created_at)->format('d M Y') }}
                                </td>

                                <td>
                                    {!! \App\Helpers\Helper::limitTextChars(strip_tags($marquee->content), 100) !!}
                                </td>

                                <td>
                                    @if($marquee->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            Action
                                        </button>

                                        <ul class="dropdown-menu">

                                            <li>
                                                <a class="dropdown-item" href="{{ route('batch-marquee.edit', $marquee->id) }}">
                                                    Edit
                                                </a>
                                            </li>

                                            <li>
                                                <form method="POST" action="{{ route('batch-marquee.destroy', $marquee->id) }}"
                                                    onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="dropdown-item text-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            </li>

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    No records found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-end mt-3">
                    {{ $marquees->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection