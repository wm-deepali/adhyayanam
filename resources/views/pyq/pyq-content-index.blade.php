@extends('layouts.app')

@section('title')
Pyq Content List
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Pyq Content List</h5>
            <a href="{{ route('pyq.content.create') }}" class="btn btn-primary mb-3">Create New</a>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Commission ID</th>
                        <th>Category ID</th>
                        <th>Sub Category ID</th>
                        <th>Heading</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pyqContents as $pyqContent)
                        <tr>
                            <td>{{ $pyqContent->id }}</td>
                            <td>{{ $pyqContent->examinationCommission->name }}</td>
                            <td>{{ $pyqContent->category->name }}</td>
                            <td>{{ $pyqContent->subCategory->name }}</td>
                            <td>{{ $pyqContent->heading }}</td>
                            <td>
                                <a href="{{ route('pyq.content.edit', $pyqContent->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('pyq.content.delete', $pyqContent->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection
