@extends('layouts.app')

@section('title')
Adhyayanam | E-Learning | Topics
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Topic</h5>
                    <h6 class="card-subtitle mb-2 text-muted"> Manage Topic section here.</h6>
                </div>
                <div class="justify-content-end">
                    <a href='{{route('topic.create')}}' class="btn btn-primary">&#43; Add</a>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th scope="col" width="1%">#</th>
                        <th scope="col" width="15%">Subject</th>
                        <th scope="col" width="15%">Chapter Name</th>
                        <th scope="col">Name</th>
                        <th scope="col">Topic Number</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topics as $topic)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{$topic->subject->name}}</td>
                        <td>{{$topic->chapter->name ?? ""}}</td>
                        <td>{{$topic->name}}</td>
                        <td>{{$topic->topic_number}}</td>
                        <td>{{$topic->description}}</td>
                        <td>
                        @if($topic->status == 1)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-secondary">Inactive</span>
                        @endif
                        </td>
                        <td>
                            <a href="{{route('topic.edit',$topic->id)}}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('topic.destroy', $topic->id) }}" method="DELETE" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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