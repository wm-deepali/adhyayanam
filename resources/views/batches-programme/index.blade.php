@extends('layouts.app')
@section('title')
ADHYAYANAM | Batches and Online Programme
@endsection
@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Batches and Online Programme</h5>
                    <h6 class="card-subtitle mb-2 text-muted"> Manage Batches and Online Programme section here.</h6>
                </div>
                <div class="justify-content-end">
                    <a href='{{route('batches-programme.create')}}' class="btn btn-primary">&#43; Add</a>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th scope="col">Date & Time</th>
                        <th scope="col">Thumbnail</th>
                        <th scope="col">Banner</th>
                        <th scope="col">Heading</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">MRP</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Offered Price</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($batches as $data)
                    <tr>
                        <th scope="row">{{ Carbon\Carbon::parse($data->created_at)->format('d M Y'); }}</th>
                        <td><img style="height: auto;width: 40px;" src="{{url('storage/'.$data->thumbnail_image)}}" alt=""></td>
                        <td><img style="height: auto;width: 40px;" src="{{url('storage/'.$data->banner_image)}}" alt=""></td>
                        <td>{{$data->batch_heading}}</td>
                        <td>{{$data->start_date}}</td>
                        <td>{{$data->mrp}}</td>
                        <td>{{$data->discount}}</td>
                        <td>{{$data->offered_price}}</td>
                        <td>{{$data->duration??"0"}} Days</td>
                        <td>
                            <form action="{{ route('batches-programme.delete', $data->id) }}" method="POST" style="display:inline;">
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