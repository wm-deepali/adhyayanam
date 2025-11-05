@extends('layouts.app')

@section('title')
Test Paper
@endsection

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .card-body table th{
        font-size:13px;
    }
    .badge-warning {
    color: #212529;
    background-color: #ffc107 !important;
}
</style>

<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Test Paper</h5>
                    <!--<h6 class="card-subtitle mb-2 text-muted"> Manage your Question Bank section here.</h6>-->
                </div>
                <div class="justify-content-end">
                    <a href='{{route('test.paper.create')}}' class="btn btn-primary">&#43; Create New Paper</a>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <div class="table-responsive-lg">
  
            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th scope="col" >Date & Time</th>
                        
                        <th scope="col">Test Paper Name</th>
                        <th scope="col">Test Info</th>
                        <th scope="col">Cat / Sub Cat</th>
                        <th scope="col">Language/<br/>Fee Type</th>
                        <th scope="col">Total Questions</th>
                        <th scope="col">Total Marks/<br/>Durations</th>
                        
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($test as $bank)
                    <tr>
                       
                       <td style="width:12%;">{{ date('d/m/Y', strtotime($bank->created_at))}}<br/>{{ date('g:i A', strtotime($bank->created_at))}}</td>
                        
                        <td>{{ $bank->name }}<br/><span class="badge badge-success">{{$bank->test_code ?? ""}}</span></td>
                        
                        @php
    if ($bank->paper_type == 2) {
        // Current Affair
        $typeName = 'Current Affair';
    } elseif ($bank->paper_type == 1) {
        // Previous Year
        $typeName = 'Previous Year';
    } elseif ($bank->paper_type == 0) {
        // Full / Subject / Chapter / Topic based on null checks
        if (is_null($bank->topic_id) && is_null($bank->subject_id) && is_null($bank->chapter_id)) {
            $typeName = 'Full Test';
        } elseif (is_null($bank->topic_id) && !is_null($bank->subject_id) && is_null($bank->chapter_id)) {
            $typeName = 'Subject Wise';
        } elseif (is_null($bank->topic_id) && !is_null($bank->chapter_id)) {
            $typeName = 'Chapter Wise';
        } elseif (!is_null($bank->topic_id)) {
            $typeName = 'Topic Wise';
        } else {
            $typeName = '-';
        }
    } else {
        $typeName = '-';
    }
@endphp


                        <td> {{ $typeName}}
                        <br/>({{$bank->test_paper_type ?? ""}})</td>
                        
                        <td>{{$bank->category->name??"_"}}<br/><span class="text-success">{{$bank->subcategory->name??"_"}}</span></td>
                        
                        @php 
                        if($bank->test_type == 'paid')
                        {
                         $colorClass="warning";
                        }
                        else
                        {
                        $colorClass="success";
                        }
                        @endphp
                        <td>{{$bank->language == 1 ? 'Hindi' : 'English'}}<br/><span class="badge badge-{{$colorClass}}">{{ucfirst($bank->test_type) ?? ""}}</span></td>
                        
                        <td>{{$bank->total_questions}}</td>
                        
                        <td>{{$bank->total_marks}}<br/><span class="badge badge-secondary">{{$bank->duration ?? ""}} mins</span></td>
                       
                        <td>Active</td>
                        <td>
                            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Actions
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('test.paper.view', $bank->id) }}"><i class="fas fa-eye"></i> View</a></li>
                <li><a class="dropdown-item" href="{{ route('test.paper.edit', $bank->id) }}"><i class="fas fa-edit"></i> Edit</a></li>
               <li>
                      <form action="{{ route('test.paper.delete', $bank->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash" style="color: #dc3545!important"></i> Delete</button>
                </form>
                    
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
</div>
@endsection