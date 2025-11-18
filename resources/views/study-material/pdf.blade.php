<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Study Material PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-height: 60px;
        }

        .details {
            margin-top: 20px;
        }

        .details strong {
            display: inline-block;
            width: 150px;
        }

        .row {
            margin-bottom: 8px;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="header">
        <!-- <img src="{{ url('images/Neti-logo.png#full') }}" alt="Logo"> -->
        <h2>Study Material Details</h2>
    </div>

    <div class="details">
        <div class="row"><strong>Commission:</strong> {{ $material->commission->name ?? 'N/A' }}</div>
        <div class="row"><strong>Category:</strong> {{ $material->category->name ?? 'N/A' }}</div>
        <div class="row"><strong>Sub Category:</strong> {{ $material->subcategory->name ?? 'N/A' }}</div>
        @if($material->subjects->count())
            <div class="row"><strong>Subject:</strong> {{ $material->subjects->pluck('name')->implode(', ') }}</div>
        @endif
        {{-- Multiple Chapters --}}
        @if($material->chapters->count())
            <div class="row"><strong>Chapter:</strong> {{ $material->chapters->pluck('name')->implode(', ') }}</div>
        @endif
        @if($material->topics->count())
            <div class="row"><strong>Topic:</strong> {{ $material->topics->pluck('name')->implode(', ') }}</div>
        @endif

        <div class="row"><strong>Material Type:</strong> {{ ucfirst(str_replace('_', ' ', $material->material_type)) }}
        </div>
        <div class="row"><strong>Language:</strong> {{ ucfirst($material->language)  }}</div>
        <div class="row"><strong>Title:</strong> {{ $material->title }}</div>
        <div class="row"><strong>Short Description:</strong> {{ $material->short_description }}</div>
        <div class="row"><strong>Detail Content:</strong> {!! $material->detail_content !!}</div>
        <div class="row"><strong>Paid:</strong> {{ $material->IsPaid ? 'Yes' : 'No' }}</div>

        @if($material->IsPaid)
            <div class="row"><strong>MRP:</strong> {{ $material->mrp }}</div>
            <div class="row"><strong>Discount:</strong> {{ $material->discount }}%</div>
            <div class="row"><strong>Offered Price:</strong> {{ $material->price }}</div>
        @endif

        <div class="row"><strong>Status:</strong> {{ $material->status }}</div>
        <div class="row"><strong>PDF Downloadable:</strong> {{ $material->is_pdf_downloadable ? 'Yes' : 'No' }}</div>
        <div class="row"><strong>Created At:</strong> {{ $material->created_at->format('d M, Y H:i A') }}</div>
    </div>
</body>

</html>