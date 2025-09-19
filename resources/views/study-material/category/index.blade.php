@extends('layouts.app')

@section('title')
Category
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Category</h5>
                    <h6 class="card-subtitle mb-2 text-muted"> Manage your category section here.</h6>
                </div>
                <div class="justify-content-end">
                    <a href='{{route('category.create')}}' class="btn btn-primary">&#43; Add</a>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th scope="col" width="1%">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Meta Title</th>
                        <th scope="col">Meta Keywords</th>
                        <th scope="col">Meta Description</th>
                        <th scope="col">Canonical Url</th>
                        <th scope="col">Image</th>
                        <th scope="col">Alt Tag</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $data)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{$data->name}}</td>
                        <td>{{$data->meta_title ??"--"}}</td>
                        <td>{{$data->meta_keyword ??"--"}}</td>
                        <td>{{$data->meta_description ??"--"}}</td>
                        <td>{{$data->canonical_url??"--"}}</td>
                        <td><img style="height: auto;width: 35px;" src="{{ url('storage/'.$data->image)}}" alt=""></td>
                        <td>{{$data->alt_tag??"--"}}</td>
                        <td>
                        @if($data->status == 'Active')
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-secondary">Inactive</span>
                        @endif
                        </td>
                        <td>
                            <a href="{{route('category.edit',$data->id)}}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('category.destroy', $data->id) }}" method="POST" style="display:inline;">
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