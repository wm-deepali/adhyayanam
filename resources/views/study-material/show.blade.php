@extends('layouts.app')

@section('title', 'View | Study Material')

@section('content')
    {{-- Styles --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <div class="bg-light rounded">
        <div class="card shadow-sm border-0">
            <div class="card-body">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                    <div>
                        <h5 class="card-title mb-1 font-weight-bold">View Study Material</h5>
                        <small class="text-muted">Study material details overview</small>
                    </div>

                    <div>
                        @if(\App\Helpers\Helper::canAccess('manage_study_material'))
                            <a href="{{ route('study.material.index') }}"
                               class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        @endif

                        @if(\App\Helpers\Helper::canAccess('manage_study_material_edit'))
                            <a href="{{ route('study.material.edit', $material->id) }}"
                               class="btn btn-primary btn-sm">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                        @endif

                        @if(\App\Helpers\Helper::canAccess('manage_study_material_download'))
                            <a href="{{ route('study.material.download', $material->id) }}"
                               class="btn btn-success btn-sm">
                                <i class="fa fa-download"></i> Download PDF
                            </a>
                        @endif
                    </div>
                </div>

                @include('layouts.includes.messages')

                {{-- BASIC DETAILS --}}
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Examination Commission</label>
                        <div class="text-muted">{{ $material->commission->name ?? 'N/A' }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Category</label>
                        <div class="text-muted">{{ $material->category->name ?? 'N/A' }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Sub Category</label>
                        <div class="text-muted">{{ $material->subcategory->name ?? 'N/A' }}</div>
                    </div>

                    @if($material->subjects->count())
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Subject</label>
                            <div class="text-muted">
                                {{ $material->subjects->pluck('name')->implode(', ') }}
                            </div>
                        </div>
                    @endif

                    @if($material->chapters->count())
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Chapter</label>
                            <div class="text-muted">
                                {{ $material->chapters->pluck('name')->implode(', ') }}
                            </div>
                        </div>
                    @endif

                    @if($material->topics->count())
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Topic</label>
                            <div class="text-muted">
                                {{ $material->topics->pluck('name')->implode(', ') }}
                            </div>
                        </div>
                    @endif

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Language</label>
                        <div class="text-muted">{{ ucfirst($material->language) }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Material Type</label>
                        <div class="text-muted">
                            {{ $material->based_on ?? ucwords(str_replace('_',' ',$material->material_type)) }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Paid</label>
                        <div class="text-muted">{{ $material->IsPaid ? 'Yes' : 'No' }}</div>
                    </div>

                    @if($material->IsPaid)
                        <div class="col-md-3 mb-3">
                            <label class="font-weight-bold">MRP</label>
                            <div class="text-muted">₹ {{ $material->mrp }}</div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="font-weight-bold">Offered Price</label>
                            <div class="text-muted">₹ {{ $material->price }}</div>
                        </div>
                    @endif

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Status</label><br>
                        @if($material->status === 'Active')
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">PDF Downloadable</label>
                        <div class="text-muted">
                            {{ $material->is_pdf_downloadable ? 'Yes' : 'No' }}
                        </div>
                    </div>
                </div>

                {{-- CONTENT --}}
                <hr>

                <div class="mb-3">
                    <label class="font-weight-bold">Title</label>
                    <div class="text-dark">{{ $material->title }}</div>
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold">Short Description</label>
                    <div class="text-muted">{{ $material->short_description }}</div>
                </div>

                <div class="mb-4">
                    <label class="font-weight-bold">Detail Content</label>
                    <div class="border p-3 rounded bg-white shadow-sm">
                        {!! $material->detail_content !!}
                    </div>
                </div>

                {{-- SECTIONS --}}
                @if(!empty($material->sections) && count($material->sections))
                    <hr>
                    <label class="font-weight-bold mb-1">Sections</label>
                    <small class="text-muted d-block mb-2">
                        Click on section titles to expand and verify formatted content.
                    </small>

                    <div class="accordion" id="materialSections">
                        @foreach($material->sections as $index => $section)
                            <div class="card mb-2">
                                <div class="card-header p-2">
                                    <button class="btn btn-link w-100 text-left font-weight-bold"
                                            data-toggle="collapse"
                                            data-target="#section{{ $index }}">
                                        {{ $section->title }}
                                    </button>
                                </div>

                                <div id="section{{ $index }}"
                                     class="collapse {{ $index === 0 ? 'show' : '' }}"
                                     data-parent="#materialSections">
                                    <div class="card-body bg-white">
                                        {!! $section->description !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- BANNER --}}
                <hr>
                <label class="font-weight-bold">Banner</label><br>
                @if($material->banner)
                    <img src="{{ asset('storage/'.$material->banner) }}"
                         class="img-thumbnail mt-2"
                         style="max-height:150px;">
                @else
                    <span class="text-muted">No Banner</span>
                @endif

                {{-- META --}}
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <label class="font-weight-bold">Created On</label>
                        <div class="text-muted">{{ $material->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold">Updated On</label>
                        <div class="text-muted">{{ $material->updated_at->format('d M Y, h:i A') }}</div>
                    </div>
                </div>

                {{-- DELETE --}}
                @if(\App\Helpers\Helper::canAccess('manage_study_material_delete'))
                    <div class="mt-4 text-right">
                        <form action="{{ route('study.material.delete', $material->id) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this study material?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- REQUIRED JS (VERY IMPORTANT) --}}
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
@endsection
