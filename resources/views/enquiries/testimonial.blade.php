@extends('layouts.app')

@section('title')
    Testimonials
@endsection

@section('content')
    <div class="bg-light rounded p-2">
        <div class="card">
            <div class="card-body">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-title mb-0">Testimonials</h5>
                        <h6 class="card-subtitle text-muted">
                            Manage Testimonials here.
                        </h6>
                    </div>

                    {{-- BACK BUTTON --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('feed.create') }}" class="btn btn-primary btn-sm">
                            + Add Testimonial
                        </a>

                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                            ← Back
                        </a>
                    </div>
                </div>

                {{-- MESSAGES --}}
                @include('layouts.includes.messages')

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Rating</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th width="12%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feeds as $feed)
                                <tr>
                                    {{-- INDEX --}}
                                    <td>{{ $loop->iteration }}</td>

                                    {{-- IMAGE --}}
                                    <td>
                                        <div class="d-flex align-items-center gap-2">

                                            <img src="{{ url('uploads/feed-photos/' . $feed->photo) }}"
                                                style="width:50px;height:50px;border-radius:50%;object-fit:cover;">

                                            <div>
                                                <strong>{{ $feed->username }}</strong><br>
                                                <small class="text-muted">
                                                    {{ $feed->designation ?? 'Student' }}
                                                </small>
                                            </div>

                                        </div>
                                    </td>

                                    <td>
                                        @if($feed->rating)
                                            <span style="color:#FFC107;font-size:16px;">
                                                {!! str_repeat('★', $feed->rating) !!}
                                            </span>
                                            <span class="text-muted">
                                                {!! str_repeat('☆', 5 - $feed->rating) !!}
                                            </span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ \Str::limit($feed->message, 40) }}</td>

                                    {{-- STATUS --}}
                                    <td>
                                        @if(\App\Helpers\Helper::canAccess('manage_testimonials_status'))
                                            <form action="{{ route('feed.updateStatus', $feed->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')

                                                <select name="status" class="form-select form-select-sm"
                                                    onchange="this.form.submit()">
                                                    <option value="0" {{ $feed->status == 0 ? 'selected' : '' }}>
                                                        Pending
                                                    </option>
                                                    <option value="1" {{ $feed->status == 1 ? 'selected' : '' }}>
                                                        Active
                                                    </option>
                                                    <option value="2" {{ $feed->status == 2 ? 'selected' : '' }}>
                                                        Published
                                                    </option>
                                                    <option value="3" {{ $feed->status == 3 ? 'selected' : '' }}>
                                                        Passive
                                                    </option>
                                                </select>
                                            </form>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ $feed->status_label }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>{{ $feed->created_at->format('d M Y, h:i A') }}</td>

                                    {{-- ACTIONS --}}
                                    <td>

                                        <div class="dropdown">

                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">

                                                Actions

                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

                                                {{-- View Testimonial --}}
                                                <li>
                                                    <a href="{{ route('feed.show', $feed->id) }}"
                                                        class="dropdown-item d-flex align-items-center gap-2">

                                                        <i class="fa fa-eye text-primary"></i>

                                                        View Testimonial

                                                    </a>
                                                </li>


                                                {{-- Delete --}}
                                                @if(\App\Helpers\Helper::canAccess('manage_feedback_delete'))

                                                    <li>

                                                        <form action="{{ route('feed.delete', $feed->id) }}" method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this testimonial?');">

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
                                    <td colspan="9" class="text-center text-muted">
                                        No testimonials found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection