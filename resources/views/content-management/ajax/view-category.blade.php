@extends('layouts.app')

@section('title')
    View | Category
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">View Category</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            Category details (read only)
                        </h6>
                    </div>
                    <a href="{{ route('cm.category') }}" class="btn btn-secondary" style="height: fit-content;">← Back</a>
                </div>

                <div class="mt-4">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Examination Commission</th>
                            <td>{{ $category->examinationCommission->name ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Name</th>
                            <td>{{ $category->name }}</td>
                        </tr>

                        <tr>
                            <th>Meta Title</th>
                            <td>{{ $category->meta_title ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Meta Keywords</th>
                            <td>{{ $category->meta_keyword ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Meta Description</th>
                            <td>{{ $category->meta_description ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Canonical URL</th>
                            <td>
                                @if($category->canonical_url)
                                    <a href="{{ $category->canonical_url }}" target="_blank">
                                        {{ $category->canonical_url }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <!-- <tr>
                            <th>Image</th>
                            <td>
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" width="120"
                                        alt="{{ $category->alt_tag }}">
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Alt Tag</th>
                            <td>{{ $category->alt_tag ?? 'N/A' }}</td>
                        </tr> -->
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($category->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Created At</th>
                            <td>{{ $category->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </table>


                </div>
            </div>
        </div>
    </div>
@endsection