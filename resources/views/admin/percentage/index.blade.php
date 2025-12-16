@extends('layouts.app')

@section('title', 'Manage Percentage System')

@section('content')

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between">
            <h5 class="m-0">Manage Percentage System</h5>
            @if(\App\Helpers\Helper::canAccess('manage_percentage_add'))
                <a href="{{ route('percentage.system.create') }}" class="btn btn-primary btn-sm">
                    + Add Percentage
                </a>
            @endif
        </div>

        <div class="card-body p-0">

            @include('layouts.includes.messages')

            <table class="table table-striped mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>Date & Time</th>
                        <th>Percentage</th>
                        <th>Division</th>
                        <th>Status</th>
                        <th width="70">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($percentages as $p)
                        <tr>
                            <td>{{ $p->created_at->format('Y-m-d H:i:s') }}</td>

                            <td>{{ $p->from_percentage }}% - {{ $p->to_percentage }}%</td>

                            <td>{{ $p->division }}</td>

                            <td>{{ $p->status }}</td>

                            <td>
                                {{-- EDIT --}}
                                @if(\App\Helpers\Helper::canAccess('manage_percentage_edit'))
                                    <a href="{{ route('percentage.system.edit', $p->id) }}" class="text-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif

                                {{-- DELETE --}}
                                @if(\App\Helpers\Helper::canAccess('manage_percentage_delete'))
                                    <form action="{{ route('percentage.system.delete', $p->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-link text-danger p-0 ms-1" onclick="return confirm('Delete?')">
                                            <i class="fas fa-trash" style="color:#dc3545!important"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

@endsection