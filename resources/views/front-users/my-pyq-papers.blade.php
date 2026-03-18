@extends('front-users.layouts.app')

@section('title')
    My PYQ Papers
@endsection

@section('content')

    <section class="page-title mb-3">
        <div class="container">

            <h2>My PYQ Papers</h2>

            <ul class="breadcrumb">
                <li><a href="{{ route('user.dashboard') }}">Home</a></li>
                <li> > PYQ Papers</li>
            </ul>

        </div>
    </section>


    <section class="pyq-paper-list py-3">

        <div class="container">

            <div class="row">

                <div class="col-md-12">


                    <div class="card shadow-sm">

                        <div class="card-header fw-bold">
                            Purchased PYQ Papers
                        </div>


                        <div class="card-body">


                            @if($papers->count() > 0)

                                @foreach($papers as $paper)

                                    <div class="card mb-2 shadow-sm">

                                        <div class="card-body d-flex justify-content-between align-items-center">

                                            <div>

                                                <strong>{{ $paper->name }}</strong>

                                                <div class="text-muted small mt-1">

                                                    {{ $paper->total_questions ?? '-' }} Questions |
                                                    {{ $paper->total_marks ?? '-' }} Marks |
                                                    {{ $paper->duration ?? '-' }} mins

                                                </div>

                                                <div class="text-muted small mt-1">

                                                    @if($paper->subject)
                                                        <span><strong>Subject:</strong> {{ $paper->subject->name }}</span>
                                                    @endif

                                                    @if($paper->chapter)
                                                        <span class="ms-2"><strong>Chapter:</strong> {{ $paper->chapter->name }}</span>
                                                    @endif

                                                    @if($paper->topic)
                                                        <span class="ms-2"><strong>Topic:</strong> {{ $paper->topic->name }}</span>
                                                    @endif

                                                </div>

                                            </div>


                                            <div>
                                                
                                                <a href="{{ route('test.instruction', base64_encode($paper->id)) }}"
                                                    class="btn btn-success btn-sm">

                                                    Attempt Now

                                                </a>

                                            </div>


                                        </div>

                                    </div>

                                @endforeach

                            @else

                                <div class="alert alert-info text-center">

                                    You have not purchased any PYQ papers yet.

                                </div>

                            @endif


                        </div>

                    </div>


                </div>

            </div>

        </div>

    </section>

@endsection