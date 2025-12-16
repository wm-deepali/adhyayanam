@extends('layouts.app')

@section('title')
    Pyq Content List
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pyq Content List</h5>
                @if(\App\Helpers\Helper::canAccess('manage_pyq_content_add'))
                    <a href="{{ route('pyq.content.create') }}" class="btn btn-primary mb-3">
                        Create New
                    </a>
                @endif
                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Commission</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Heading</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pyqContents as $pyqContent)
                            <tr>
                                <td>{{ $pyqContent->id }}</td>
                                <td>{{ $pyqContent->examinationCommission->name ?? '—' }}</td>
                                <td>{{ $pyqContent->category->name ?? '—' }}</td>
                                <td>{{ $pyqContent->subCategory->name ?? '—' }}</td>
                                <td>{{ $pyqContent->heading ?? '—' }}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton{{ $pyqContent->id }}" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $pyqContent->id }}">

                                            {{-- VIEW --}}
                                            @if(\App\Helpers\Helper::canAccess('manage_pyq_content'))
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('pyq.content.show', $pyqContent->id) }}">
                                                        <i class="fa fa-eye text-info me-1"></i> View
                                                    </a>
                                                </li>
                                            @endif

                                            {{-- EDIT --}}
                                            @if(\App\Helpers\Helper::canAccess('manage_pyq_content_edit'))
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('pyq.content.edit', $pyqContent->id) }}">
                                                        <i class="fa fa-edit text-primary me-1"></i> Edit
                                                    </a>
                                                </li>
                                            @endif

                                            {{-- DELETE --}}
                                            @if(\App\Helpers\Helper::canAccess('manage_pyq_content_delete'))
                                                <li>
                                                    <form action="{{ route('pyq.content.delete', $pyqContent->id) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this content?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fa fa-trash me-1" style="color:#dc3545!important"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif

                                        </ul>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection