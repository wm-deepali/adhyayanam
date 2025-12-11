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
            <div class="auto-container row">

                <!-- Sidebar: Subjects -->
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="border rounded p-3 bg-white shadow-sm">
                        <h5 class="mb-3">Subjects</h5>
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
                </div>

                <!-- Syllabus Content -->
                <div class="col-lg-9 col-md-8">
                    @if($syllabus->isEmpty())
                        <div class="alert alert-info text-center py-4">
                            No syllabus available for this selection.
                        </div>
                    @else
                        @foreach($syllabus as $item)
                            <div class="syllabus-item mb-4 p-4 border rounded shadow-sm bg-white">
                                <h5 class="mb-2 fw-bold">{{ $item->title }} <small class="text-muted">({{ $item->type }})</small>
                                </h5>
                                <div class="text-dark mb-2">
                                    {!! $item->detail_content !!}
                                </div>

                                @if($item->pdf)
                                    <a href="{{ asset('storage/' . $item->pdf) }}" target="_blank" class="btn btn-sm btn-primary">
                                        📄 Download PDF
                                    </a>
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
                padding: 9px 12px;
                color: #333;
                border-radius: 4px;
                margin-bottom: 6px;
                transition: 0.3s;
                font-size: 15px;
            }

            .subject-list li a.active,
            .subject-list li a:hover {
                background-color: #ff8a00;
                color: #fff;
                font-weight: 600;
            }

            .syllabus-item h5 {
                color: #1b1b1b;
            }

            @media(max-width: 768px) {
                .syllabus-section .auto-container {
                    flex-direction: column;
                }
            }
        </style>

    </body>
@endsection