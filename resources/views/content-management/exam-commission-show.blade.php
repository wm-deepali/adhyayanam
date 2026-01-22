@extends('layouts.app')

@section('title')
View | Course Type
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h5 class="card-title">Examination Commission Details</h5>
                    <h6 class="card-subtitle mb-2 text-muted">View details of a Examination Commission</h6>
                </div>
                <a href="{{ route('cm.exam') }}" class="btn btn-secondary" style="height: fit-content;">← Back</a>
            </div>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <table class="table table-bordered mt-4">
                <tr>
                    <th>Name</th>
                    <td>{{ $exam->name }}</td>
                </tr>

                <tr>
                    <th>Description</th>
                    <td>{{ $exam->description ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Meta Title</th>
                    <td>{{ $exam->meta_title ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Meta Keyword</th>
                    <td>{{ $exam->meta_keyword ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Meta Description</th>
                    <td>{{ $exam->meta_description ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Canonical URL</th>
                    <td>{{ $exam->canonical_url ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Image</th>
                    <td>
                        @if($exam->image)
                            <img src="{{ asset('storage/'.$exam->image) }}" width="120" alt="{{ $exam->alt_tag }}">
                        @else
                            N/A
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Alt Tag</th>
                    <td>{{ $exam->alt_tag ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if($exam->status == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Created By</th>
                    <td>{{ $exam->creator->name ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Created At</th>
                    <td>{{ $exam->created_at ? $exam->created_at->format('d M, Y h:i A') : 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Last Updated</th>
                    <td>{{ $exam->updated_at ? $exam->updated_at->format('d M, Y h:i A') : 'N/A' }}</td>
                </tr>
            </table>

        </div>
    </div>
</div>
@endsection
