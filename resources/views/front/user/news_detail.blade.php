@extends('front.partials.app')

@section('header')
    <title>{{ $news->title }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($news->detail_content), 150) }}">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')

    <body class="hidden-bar-wrapper">

        <!-- Page Title -->
        <section class="page-title">
            <div class="auto-container">
                <h2>{{ $news->title }}</h2>
                <ul class="bread-crumb clearfix">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>News</li>
                </ul>
            </div>
        </section>

        <!-- news Content -->
        <section class="choose-section-two">
            <div class="auto-container">

                <div class="row clearfix">

                    @if($news->image)
                        <div class="col-12 mb-4 text-center">
                            <img src="{{ asset('storage/' . $news->image) }}" class="img-fluid rounded shadow"
                                style="max-height:400px">
                        </div>
                    @endif

                    <div class="col-12">

                        @if(!empty($news->short_description))
                            <div class="mb-4 p-3 bg-light rounded">
                                <strong>Summary:</strong>
                                <p class="mb-0">{{ $news->short_description }}</p>
                            </div>
                        @endif

                        <div class="contents">
                            {!! $news->detail_content !!}
                        </div>

                    </div>

                </div>

            </div>
        </section>

    </body>
@endsection