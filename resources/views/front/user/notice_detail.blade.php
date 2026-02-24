@extends('front.partials.app')

@section('header')
    <title>{{ $notice->title }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($notice->detail_content), 150) }}">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')

    <body class="hidden-bar-wrapper">

        <!-- Page Title -->
        <section class="page-title">
            <div class="auto-container">
                <h2>{{ $notice->title }}</h2>
                <ul class="bread-crumb clearfix">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Notice</li>
                </ul>
            </div>
        </section>

        <!-- Notice Content -->
        <section class="choose-section-two">
            <div class="auto-container">

                <div class="row clearfix">

                    @if($notice->image)
                        <div class="col-12 mb-4 text-center">
                            <img src="{{ asset('storage/' . $notice->image) }}" class="img-fluid rounded shadow"
                                style="max-height:400px">
                        </div>
                    @endif

                    <div class="col-12">

                        @if(!empty($notice->short_description))
                            <div class="mb-4 p-3 bg-light rounded">
                                <strong>Summary:</strong>
                                <p class="mb-0">{{ $notice->short_description }}</p>
                            </div>
                        @endif

                        <div class="contents">
                            {!! $notice->detail_content !!}
                        </div>

                    </div>

                </div>

            </div>
        </section>

    </body>
@endsection