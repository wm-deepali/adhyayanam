@extends('layouts.app')

@section('title')
SEO
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <div class="col">
                    <h5 class="card-title">Search Engine Optimization</h5>
                    <h6 class="card-subtitle mb-2 text-muted"> Manage your SEO section here.</h6>
                </div>
                <div class="justify-content-end">
                    <a href='{{route('seo.create')}}' class="btn btn-primary">&#43; Add</a>
                </div>
            </div>
            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>
            <table class="table table-striped mt-5">
                <thead>
                    <tr>
                        <th scope="col" width="1%">#</th>
                        <th scope="col" width="15%">Page</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Keywords</th>
                        <th scope="col">Canonical</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seos as $seo)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{$seo->page}}</td>
                        <td>{{$seo->title}}</td>
                        <td>{{$seo->description}}</td>
                        <td>{{$seo->keywords}}</td>
                        <td>{{$seo->canonical}}</td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection