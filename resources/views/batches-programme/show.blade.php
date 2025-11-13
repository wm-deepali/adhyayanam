@extends('layouts.app')

@section('title')
View | Batches and Online Programme
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">View Batch / Programme</h5>
            <h6 class="card-subtitle mb-2 text-muted">Details of the batch.</h6>

            <a href="{{ route('batches-programme.index') }}" class="btn btn-secondary mb-3">Back</a>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{ $batch->name }}</td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td>{{ $batch->start_date }}</td>
                    </tr>
                    <tr>
                        <th>Heading</th>
                        <td>{{ $batch->batch_heading }}</td>
                    </tr>
                    <tr>
                        <th>Duration</th>
                        <td>{{ $batch->duration }} Days</td>
                    </tr>
                    <tr>
                        <th>MRP</th>
                        <td>{{ $batch->mrp }}</td>
                    </tr>
                    <tr>
                        <th>Discount</th>
                        <td>{{ $batch->discount }}</td>
                    </tr>
                    <tr>
                        <th>Offered Price</th>
                        <td>{{ $batch->offered_price }}</td>
                    </tr>
                    <tr>
                        <th>Short Description</th>
                        <td>{{ $batch->short_description }}</td>
                    </tr>
                    <tr>
                        <th>Batch Overview</th>
                        <td>{!! $batch->batch_overview !!}</td>
                    </tr>
                    <tr>
                        <th>Batch Detail</th>
                        <td>{!! $batch->detail_content !!}</td>
                    </tr>
                    <tr>
                        <th>Thumbnail</th>
                        <td>
                            @if($batch->thumbnail_image)
                                <img src="{{ asset('storage/'.$batch->thumbnail_image) }}" style="height:50px; width:auto;">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Banner</th>
                        <td>
                            @if($batch->banner_image)
                                <img src="{{ asset('storage/'.$batch->banner_image) }}" style="height:50px; width:auto;">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Youtube URL</th>
                        <td>{{ $batch->youtube_url }}</td>
                    </tr>
                    <tr>
                        <th>Meta Title</th>
                        <td>{{ $batch->meta_title }}</td>
                    </tr>
                    <tr>
                        <th>Meta Keyword</th>
                        <td>{{ $batch->meta_keyword }}</td>
                    </tr>
                    <tr>
                        <th>Meta Description</th>
                        <td>{{ $batch->meta_description }}</td>
                    </tr>
                    <tr>
                        <th>Alt Tag</th>
                        <td>{{ $batch->image_alt_tag }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $batch->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $batch->updated_at->format('d M Y, H:i') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
