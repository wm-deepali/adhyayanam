@extends('front.partials.app')

@section('header')
    <title>Syllabus</title>
@endsection

@section('content')
<body class="hidden-bar-wrapper">

<section class="page-title">
    <div class="auto-container">
        <h2>Adhyayanam</h2>
        <ul class="bread-crumb clearfix">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li>Syllabus</li>
        </ul>
    </div>
</section>

<section class="syllabus-section py-5">
    <div class="auto-container d-flex gap-4">
        <!-- Sidebar: Subjects -->
        <div class="sidebar" style="width: 25%;">
            <h4>Subjects</h4>
            <ul class="subject-list list-unstyled">
                <li>
                    <a href="{{ route('syllabus.front', [$commissionId ?? null, $categoryId ?? null, $subCategoryId ?? null]) }}"
                       class="{{ request('subject') ? '' : 'active' }}">
                        All Subjects
                    </a>
                </li>
                @foreach($subjects as $subject)
                    <li>
                        <a href="{{ route('syllabus.front', [$commissionId ?? null, $categoryId ?? null, $subCategoryId ?? null, 'subject' => $subject->id]) }}"
                           class="{{ request('subject') == $subject->id ? 'active' : '' }}">
                            {{ $subject->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Syllabus Content -->
        <div class="syllabus-content" style="width: 75%;">
            @if($syllabus->isEmpty())
                <p>No syllabus available for this selection.</p>
            @else
                @foreach($syllabus as $item)
                    <div class="syllabus-item mb-4 p-3 border rounded">
                        <h5>{{ $item->title }} ({{ $item->type }})</h5>
                        <p>{!! $item->detail_content !!}</p>
                        @if($item->pdf)
                            <a href="{{ asset('storage/' . $item->pdf) }}" target="_blank" class="btn btn-primary">Download PDF</a>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<style>
.subject-list li a {
    display: block;
    padding: 8px 12px;
    text-decoration: none;
    color: #333;
    border-radius: 4px;
    margin-bottom: 4px;
}

.subject-list li a.active,
.subject-list li a:hover {
    background-color: orange;
    color: #fff;
}
</style>

</body>
@endsection
