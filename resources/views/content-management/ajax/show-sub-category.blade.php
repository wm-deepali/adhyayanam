@extends('layouts.app')

@section('title')
    View | Sub Category
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title mb-3">Sub Category Details</h5>

            <table class="table table-bordered">
                <tr>
                    <th>Examination Commission</th>
                    <td>{{ $subCat->examinationCommission->name ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Category</th>
                    <td>{{ $subCat->category->name ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Name</th>
                    <td>{{ $subCat->name }}</td>
                </tr>

                <tr>
                    <th>Meta Title</th>
                    <td>{{ $subCat->meta_title ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Meta Keywords</th>
                    <td>{{ $subCat->meta_keyword ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Meta Description</th>
                    <td>{{ $subCat->meta_description ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Canonical URL</th>
                    <td>{{ $subCat->canonical_url ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Alt Tag</th>
                    <td>{{ $subCat->alt_tag ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        {!! $subCat->status
                            ? '<span class="badge bg-success">Active</span>'
                            : '<span class="badge bg-secondary">Inactive</span>' !!}
                    </td>
                </tr>

                <tr>
                    <th>Created By</th>
                    <td>{{ $subCat->creator->name ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Image</th>
                    <td>
                        @if($subCat->image)
                            <img src="{{ asset('storage/'.$subCat->image) }}"
                                 width="80">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    </td>
                </tr>
            </table>

            <a href="{{ route('cm.sub.category') }}" class="btn btn-secondary">
                Back
            </a>

        </div>
    </div>
</div>
@endsection
