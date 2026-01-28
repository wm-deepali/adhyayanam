@extends('layouts.app')

@section('title','Feedback')

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="mb-0">Feedback</h5>
                    <small class="text-muted">Manage feedback requests</small>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">← Back</a>
            </div>

            @include('layouts.includes.messages')

            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th width="12%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feeds as $feed)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <img src="{{ url('uploads/feed-photos/'.$feed->photo) }}"
                                     class="img-thumbnail"
                                     style="max-width:60px">
                            </td>

                            <td>{{ $feed->username }}</td>
                            <td>{{ $feed->email }}</td>
                            <td>{{ $feed->number }}</td>
                            <td>{{ Str::limit($feed->message, 40) }}</td>

                            {{-- STATUS --}}
                            <td>
                                @if(\App\Helpers\Helper::canAccess('manage_testimonials_status'))
                                    <form action="{{ route('feed.updateStatus',$feed->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <select name="status"
                                                class="form-select form-select-sm"
                                                onchange="this.form.submit()">
                                            <option value="0" {{ $feed->status==0?'selected':'' }}>Pending</option>
                                            <option value="1" {{ $feed->status==1?'selected':'' }}>Active</option>
                                            <option value="2" {{ $feed->status==2?'selected':'' }}>Published</option>
                                            <option value="3" {{ $feed->status==3?'selected':'' }}>Passive</option>
                                        </select>
                                    </form>
                                @else
                                    <span class="badge bg-secondary">{{ $feed->status_label }}</span>
                                @endif
                            </td>

                            <td>{{ $feed->created_at->format('d M Y') }}</td>

                            {{-- ACTIONS --}}
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('feed.show',$feed->id) }}" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    @if(\App\Helpers\Helper::canAccess('manage_feedback_delete'))
                                    <form action="{{ route('feed.delete',$feed->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this feedback?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-link p-0 text-danger">
                                            <i class="fa fa-trash" style="color:#dc3545!important"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No feedback found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection