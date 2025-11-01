<table class="table table-striped mt-5 align-middle">
    <thead>
        <tr>
            <th scope="col" width="1%">#</th>
            <th scope="col">Date & Time</th>
            <th scope="col">Question</th>
            <th scope="col">Topic</th>
            <th scope="col">Subject</th>
            <th scope="col">Instructions</th>
            <th scope="col">Status</th>
            <th scope="col">Added By</th>
            <th scope="col">Rejected by</th>
            <th scope="col">Reason</th>
            <th scope="col" width="10%">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($questionBanks as $data)
            <tr id="row-{{ $data->id }}">
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $data->created_at }}</td>
                <td>{!! $data->question !!}</td>
                <td>{{ $data->topics->name ?? "_" }}</td>
                <td>{{ $data->subject->name ?? "-" }}</td>
                <td>{{ $data->instruction }}</td>
                <td><span class="badge bg-danger">{{ ucfirst($data->status) }}</span></td>
                 <td>{{ $data->addedBy->full_name ?? '-' }}<br>{{ $data->addedBy->email ?? '-' }}</td>
                <td>
                    {{ $data->rejectedBy->name ?? '-' }}
                </td>
                <td>{{ $data->note }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                            id="dropdownMenuButton{{ $data->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $data->id }}">
                            <li><a class="dropdown-item text-primary"
                                    href="{{route('question.bank.view', $data->id)}}">View</a></li>
                            <li><a class="dropdown-item text-secondary"
                                    href="{{ route('question.bank.edit', $data->id) }}">Edit</a></li>
                            <li>
                                <button type="button" class="dropdown-item text-danger deleteBtn" data-id="{{ $data->id }}"
                                    data-url="{{ route('question.bank.delete', $data->id) }}">
                                    Delete
                                </button>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center text-muted">No records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
    {{ $questionBanks->links('pagination::bootstrap-5') }}
</div>