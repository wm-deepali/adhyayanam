@extends('layouts.app')

@section('title')
    Adhayaynam | Study Material | View
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Study Material Details</h5>
                <h6 class="card-subtitle mb-2 text-muted">All information about this material</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Commission:</strong>
                        <p>{{ $material->commission->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Category:</strong>
                        <p>{{ $material->category->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Sub Category:</strong>
                        <p>{{ $material->subcategory->name ?? 'N/A' }}</p>
                    </div>
                    @if($material->subjects->count())
                        <div class="col-md-6 mb-3">
                            <strong>Subject:</strong>
                            <p> {{ $material->subjects->pluck('name')->implode(', ') }}</p>
                        </div>
                    @endif
                    {{-- Multiple Chapters --}}
                    @if($material->chapters->count())
                        <strong>Chapter:</strong>
                        <p>
                            {{ $material->chapters->pluck('name')->implode(', ') }}
                        </p>
                    @endif

                    {{-- Multiple Topics --}}
                    @if($material->topics->count())
                        <strong>Topic:</strong>
                        <p>{{ $material->topic->name ?? 'N/A' }}</p>
                    @endif

                    <div class="col-md-6 mb-3">
                        <strong>Language:</strong>
                        <p>{{ ucfirst($material->language) }}</p>
                    </div>

                    <div class="col-md-12 mb-3">
                        <strong>Material Type:</strong>
                        <p>
                            @if ($material->material_type == 'topic_based')
                                Topic Based
                            @elseif ($material->material_type == 'chapter_based')
                                Chapter Based
                            @elseif ($material->material_type == 'subject_based')
                                Subject Based
                            @else
                                General
                            @endif
                        </p>
                    </div>

                    <div class="col-md-12 mb-3">
                        <strong>Title:</strong>
                        <p>{{ $material->title }}</p>
                    </div>

                    <div class="col-md-12 mb-3">
                        <strong>Short Description:</strong>
                        <p>{{ $material->short_description }}</p>
                    </div>

                    <div class="col-md-12 mb-3">
                        <strong>Detail Content:</strong>
                        <div>{!! $material->detail_content !!}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Paid:</strong>
                        <p>{{ $material->IsPaid ? 'Yes' : 'No' }}</p>
                    </div>

                    @if($material->IsPaid)
                        <div class="col-md-4 mb-3">
                            <strong>MRP:</strong>
                            <p>{{ $material->mrp }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>Discount:</strong>
                            <p>{{ $material->discount }}%</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>Offered Price:</strong>
                            <p>{{ $material->price }}</p>
                        </div>
                    @endif

                    <div class="col-md-6 mb-3">
                        <strong>Status:</strong>
                        <p>
                            @if ($material->status == 'Active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>PDF Downloadable:</strong>
                        <p>{{ $material->is_pdf_downloadable ? 'Yes' : 'No' }}</p>
                    </div>

                    <div class="col-md-12 mb-3">
                        <strong>Banner:</strong><br>
                        @if($material->banner)
                            <img src="{{ asset('storage/' . $material->banner) }}" alt="Banner" style="max-height:150px;">
                        @else
                            <p>No Banner</p>
                        @endif
                    </div>

                    <div class="col-md-12 mb-3">
                        <strong>Meta Title:</strong>
                        <p>{{ $material->meta_title ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-12 mb-3">
                        <strong>Meta Keyword:</strong>
                        <p>{{ $material->meta_keyword ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-12 mb-3">
                        <strong>Meta Description:</strong>
                        <p>{{ $material->meta_description ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-12 mb-3">
                        <strong>Created At:</strong>
                        <p>{{ $material->created_at->format('d M, Y H:i A') }}</p>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('study.material.index') }}" class="btn btn-secondary">Back</a>
                    <a href="{{ route('study.material.download', $material->id) }}" class="btn btn-success">Download PDF</a>

                </div>
            </div>
        </div>
    </div>
@endsection