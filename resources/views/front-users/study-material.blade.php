@extends('front-users.layouts.app')

@section('title')
    Study Material
@endsection

@section('content')

    <style>
        /* ====================== DESKTOP TABLE (No Change) ====================== */
        .table-action i {
            font-size: 18px;
        }

        /* ====================== MOBILE CARD VIEW ====================== */
        .study-mobile-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
            margin-bottom: 18px;
            overflow: hidden;
        }

        .study-mobile-card .card-body {
            padding: 20px;
        }

        .study-title {
            font-size: 17px;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 12px;
        }

        .study-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 18px;
        }

        .meta-item {
            font-size: 13.5px;
        }

        .meta-label {
            display: block;
            font-size: 12px;
            color: #64748b;
            margin-bottom: 2px;
        }

        .meta-value {
            font-weight: 500;
            color: #1e2937;
        }

        .study-status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 500;
        }
        @media (max-width: 740px) {
    

.content{
    padding:0px !important;
}
}
    </style>

    <section class="content py-3">
        <div class="container">

            <!-- ==================== DESKTOP TABLE VIEW ==================== -->
            <div class="d-none d-lg-block">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">My Study Materials</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Study Material Title</th>
                                    <th>Examination Commission</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Subjects</th>
                                    <th>Language</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    @php $m = $order->study_material; @endphp
                                    <tr>
                                        <td><strong>{{ $m->title }}</strong></td>
                                        <td>{{ $m->commission->name ?? 'N/A' }}</td>
                                        <td>{{ $m->category?->name ?? 'N/A' }}</td>
                                        <td>{{ $m->subcategory?->name ?? 'N/A' }}</td>
                                        <td>
                                            @if($m->subjects->count())
                                                {{ $m->subjects->pluck('name')->implode(', ') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($m->language) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $m->status == 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($m->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('study.material.details', $m->id) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i data-feather="eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            No Study Material Purchased Yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ==================== MOBILE CARD VIEW ==================== -->
            <div class="d-lg-none">
                @forelse ($orders as $order)
                    @php $m = $order->study_material; @endphp
                    <div class="study-mobile-card">
                        <div class="card-body">
                            <h5 class="study-title">{{ $m->title }}</h5>

                            <div class="study-meta">
                                <div class="meta-item">
                                    <span class="meta-label">Commission</span>
                                    <span class="meta-value">{{ $m->commission->name ?? 'N/A' }}</span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label">Category</span>
                                    <span class="meta-value">{{ $m->category?->name ?? 'N/A' }}</span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label">Subcategory</span>
                                    <span class="meta-value">{{ $m->subcategory?->name ?? 'N/A' }}</span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label">Language</span>
                                    <span class="meta-value">{{ ucfirst($m->language) }}</span>
                                </div>
                            </div>

                            @if($m->subjects->count())
                                <div class="mb-3">
                                    <span class="meta-label">Subjects</span>
                                    <p class="mb-0 text-muted small">
                                        {{ $m->subjects->pluck('name')->implode(', ') }}
                                    </p>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div>
                                    <span class="meta-label">Status</span><br>
                                    <span class="study-status bg-{{ $m->status == 'active' ? 'success' : 'secondary' }} text-white">
                                        {{ ucfirst($m->status) }}
                                    </span>
                                </div>
                                <a href="{{ route('study.material.details', $m->id) }}" 
                                   class="btn btn-primary px-4">
                                    <i data-feather="eye" class="me-2"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info text-center py-5 mx-3">
                        No Study Material Purchased Yet.
                    </div>
                @endforelse
            </div>

        </div>
    </section>

@endsection