@extends('layouts.app')

@section('title')
Question Bank
@endsection

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .card-body table th{
        font-size:13px;
    }
</style>

<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Test Series</h5>
                    <!--<h6 class="card-subtitle mb-2 text-muted"> Manage your Question Bank section here.</h6>-->
                </div>
                <div class="justify-content-end">
                    <a href='{{route('pyq.create')}}' class="btn btn-primary">&#43; Create PYQ</a>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <div class="table-responsive-lg">
  
            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                    <th scope="col" width="1%">#</th>
                        <th scope="col" >Date & Time</th>
                        <th scope="col">Paper Type</th>
                        <th scope="col">Year</th>
                        <th scope="col">Title</th>
                        <th scope="col">Subjects</th>
                        <th scope="col">Exam Commission</th>
                        <th scope="col">Category</th>
                        <th scope="col">Sub Category</th>
                        <th scope="col">PDF</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($pyq as $res)
                    @php
                    if($res->has_subject == 1)
                    {
                        $subject=array();
                        foreach($res->pyqSub as $sub)
                        {
                            $subject[] = $sub->subject->name ?? '';
                        }
                        $subjects = implode(', ', $subject);
                        
                    }
                    else{
                        $subjects = '-';
                    }
                    
                    @endphp
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{$res->created_at}}</td>
                        <td>{{$res->paper_type}}</td>
                        <td>{{ $res->year }}</td>
                        <td>{{ $res->title}}</td>
                        <td>{{ $subjects }}</td>
                        <td>{{$res->commission->name?? "_"}}</td>
                        <td>{{$res->category->name?? "_"}}</td>
                        <td>{{$res->subcategory->name?? "_"}}</td>
                        <td><a href="{{url('/storage/app/pyq-pdf',$res->pdf)}}" target="blank"><img height="80px" src="{{asset('img/pdficon.png')}}" /></a></td>
                        <td>{{$res->status}}</td>
                        <td>
                            <a href="{{ route('pyq.edit', $res->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('pyq.destroy', $res->id) }}" method="POST" style="display:inline;">
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
</div>
@endsection