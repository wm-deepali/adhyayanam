@extends('front-users.layouts.app')

@section('title')
    Test Series
@endsection

@section('content')
<section class="content">

    <div class="row">

        {{-- Purchased Test Series --}}
        <div class="col-12 col-xl-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">🎯 Purchased Test Series</h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>Test Series Name</th>
                                <th>Total Papers</th>
                                <th>Attempted</th>
                                <th>Progress</th>
                                <th>Purchased On</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($paidOrders as $order)
                                @php
                                    $testSeries = $order->test_series;
                                    $tests = $testSeries ? $testSeries->tests : collect([]);
                                    $totalTests = $tests->count();

                                    $attemptedTests = $tests->whereIn('id', $studentAttempts)->count();
                                    $progress = $totalTests > 0 ? round(($attemptedTests / $totalTests) * 100) : 0;
                                @endphp

                                @if($testSeries)
                                    <tr>
                                        <td class="fw-bold">{{ $testSeries->title }}</td>

                                        <td>{{ $totalTests }}</td>

                                        <td>{{ $attemptedTests }} / {{ $totalTests }}</td>

                                        <td style="width:170px">
                                            <div class="progress" style="height:8px;">
                                                <div class="progress-bar {{ $progress == 100 ? 'bg-success' : 'bg-warning' }}"
                                                     style="width: {{ $progress }}%"></div>
                                            </div>
                                            <small>{{ $progress }}% Completed</small>
                                        </td>

                                        <td>{{ $order->created_at?->format('d M, Y') }}</td>

                                        <td>
                                            @if($progress == 100)
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-warning text-dark">In Progress</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('user.test-series-detail', $testSeries->slug) }}"
                                               class="btn btn-primary btn-sm">
                                               View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endif

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-danger py-3">
                                        You have not purchased any Test Series yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

        {{-- Free Test Series --}}
        <div class="col-12 col-xl-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">🆓 Free Test Series</h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>Test Series Name</th>
                                <th>Progress</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($freeSeries as $series)
                                @php
                                    $tests = $series->tests;
                                    $totalTests = $tests->count();

                                    $attemptedTests = $tests->whereIn('id', $studentAttempts)->count();
                                    $progress = $totalTests > 0 ? round(($attemptedTests / $totalTests) * 100) : 0;
                                @endphp

                                <tr>
                                    <td class="fw-bold text-success">{{ $series->title }}</td>

                                    <td>{{ $attemptedTests }} / {{ $totalTests }}</td>

                                    <td>
                                        <span class="badge bg-success">FREE</span>
                                    </td>

                                    <td>
                                        <a href="{{ route('user.test-series-detail', $series->slug) }}"
                                           class="btn btn-outline-success btn-sm">
                                           Start
                                        </a>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">
                                        No free test series available currently.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>

</section>
@endsection
