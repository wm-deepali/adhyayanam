@extends('layouts.teacher-app')

@section('title')
Question Bank
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Question Bank</h5>
                    <h6 class="card-subtitle mb-2 text-muted"> Manage your Question Bank section here.</h6>
                </div>
                <div class="justify-content-end">
                    <a href='{{route('teacher.question.bank.index')}}' class="btn btn-primary">Back</a>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
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
                        <th scope="col">Reason</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                   
                    @foreach($questionBanks as $data)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{$data->created_at}}</td>
                        <td>{!! $data->question !!}</td>
                        <td>{{$data->topics->name ??"_"}}</td>
                        <td>{{$data->subject->name ?? "-"}}</td>
                        <td>{{$data->instruction}}</td>
                        <td>{{$data->status}}</td>
                        <td>{{$data->note}}</td>
                        <td>
                            <button class="btn btn-sm btn-primary">View</button>
                            <a href="{{route('teacher.question.bank.edit',$data->id)}}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('teacher.question.bank.delete', $data->id) }}" method="POST" style="display:inline;">
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