@extends('layouts.app')

@section('title','Study Material Detail')

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <h5 class="mb-1">{{ $studyMaterial->title }}</h5>
                    <small class="text-muted">
                        Student: {{ $student->full_name }}
                        |
                        Order ID: {{ $order->order_code ?? 'N/A' }}
                    </small>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                    ← Back
                </a>
            </div>

            {{-- BASIC INFO --}}
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Status</strong><br>
                    <span class="badge {{ $studyMaterial->status === 'Active' ? 'bg-success' : 'bg-danger' }}">
                        {{ $studyMaterial->status }}
                    </span>
                </div>

                <div class="col-md-3">
                    <strong>Type</strong><br>
                    {{ $studyMaterial->based_on }}
                </div>

                <div class="col-md-3">
                    <strong>Language</strong><br>
                    {{ ucfirst($studyMaterial->language) }}
                </div>

                <div class="col-md-3">
                    <strong>Purchased On</strong><br>
                    {{ $order?->created_at?->format('d M Y') ?? '—' }}
                </div>
            </div>

            {{-- BANNER --}}
            @if($studyMaterial->banner)
                <div class="mb-3 text-center">
                    <img src="{{ asset('storage/'.$studyMaterial->banner) }}"
                         class="img-fluid rounded"
                         style="max-height:200px;">
                </div>
            @endif

            {{-- DESCRIPTION --}}
            <div class="card mb-3">
                <div class="card-body">
                    <h6>Short Description</h6>
                    <p class="text-muted">
                        {{ $studyMaterial->short_description }}
                    </p>

                    <h6 class="mt-3">Detailed Content</h6>
                    {!! $studyMaterial->detail_content !!}
                </div>
            </div>

            {{-- PRICING --}}
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Paid</strong><br>
                    {{ $studyMaterial->IsPaid ? 'Yes' : 'No' }}
                </div>

                <div class="col-md-3">
                    <strong>MRP</strong><br>
                    ₹{{ number_format($studyMaterial->mrp, 2) }}
                </div>

                <div class="col-md-3">
                    <strong>Discount</strong><br>
                    ₹{{ number_format($studyMaterial->discount, 2) }}
                </div>

                <div class="col-md-3">
                    <strong>Final Price</strong><br>
                    ₹{{ number_format($studyMaterial->price, 2) }}
                </div>
            </div>

            {{-- PDF DOWNLOAD --}}
            @if($studyMaterial->pdf && $studyMaterial->is_pdf_downloadable)
                <div class="mt-3">
                    <a href="{{ asset('storage/'.$studyMaterial->pdf) }}"
                       target="_blank"
                       class="btn btn-primary btn-sm">
                        📥 Download PDF
                    </a>
                </div>
            @else
                <div class="alert alert-info mt-3">
                    PDF not available for this study material.
                </div>
            @endif

        </div>
    </div>
</div>
@endsection