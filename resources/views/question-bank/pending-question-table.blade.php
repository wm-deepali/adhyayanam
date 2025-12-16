<table class="table table-striped mt-5">
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
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($questionBanks as $data)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{$data->created_at}}</td>
                <td>{!! $data->question !!}</td>
                <td>{{$data->topics->name ?? "_"}}</td>
                <td>{{$data->subject->name ?? "-"}}</td>
                <td>{{$data->instruction}}</td>
                <td>
                    @if($data->status === 'Pending')
                        <span class="badge bg-warning text-light">Pending</span>
                    @elseif($data->status === 'resubmitted')
                        <span class="badge bg-info text-light">Resubmitted</span>
                    @endif
                </td>
                <td>{{ $data->addedBy->full_name ?? '-' }}<br>{{ $data->addedBy->email ?? '-' }}</td>
                <td>

                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu">
                            @if(\App\Helpers\Helper::canAccess('manage_question_bank'))
                                <li>
                                    <a class="dropdown-item" href="{{ route('question.bank.view', $data->id) }}">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </li>
                            @endif

                            @if(\App\Helpers\Helper::canAccess('manage_question_bank_edit'))
                                <li>
                                    <a class="dropdown-item" href="{{ route('question.bank.edit', $data->id) }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </li>
                            @endif
                            @if(\App\Helpers\Helper::canAccess('manage_question_bank_delete'))
                                <li>
                                    <button type="button" class="dropdown-item text-danger deleteBtn" data-id="{{ $data->id }}"
                                        data-url="{{ route('question.bank.delete', $data->id) }}">
                                        <i class="fas fa-trash" style="color:#dc3545!important"></i> Delete</button>
                                </li>
                            @endif
                            @if(\App\Helpers\Helper::canAccess('manage_question_bank_status'))
                                <li>
                                    <form action="{{ route('question.bank.update-status', $data->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="Done">
                                        <button type="submit" class="dropdown-item text-success"><i class="fas fa-check"></i>
                                            Approve</button>
                                    </form>
                                </li>
                            @endif
                            @if(\App\Helpers\Helper::canAccess('manage_question_bank_status'))
                                <li>
                                    <button class="dropdown-item text-warning" data-bs-toggle="modal"
                                        data-bs-target="#rejectModal{{ $data->id }}"><i class="fas fa-times"></i>
                                        Reject</button>
                                </li>
                            @endif
                        </ul>

                    </div>
                </td>
            </tr>

            <!-- Reject Modal -->
            <div class="modal fade" id="rejectModal{{ $data->id ?? '' }}" tabindex="-1"
                aria-labelledby="rejectModalLabel{{ $data->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('question.bank.update-status', $data->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="Rejected">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rejectModalLabel{{ $data->id }}">Reject Question
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Reason for Rejection</label>
                                    <textarea name="note" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-warning">Reject</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center mt-3">
    {{ $questionBanks->links('pagination::bootstrap-5') }}
</div>