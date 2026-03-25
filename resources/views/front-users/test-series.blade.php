@extends('front-users.layouts.app')

@section('title')
    Test Series
@endsection

@section('content')

    <style>
        /* ====================== DESKTOP TABLES (Unchanged) ====================== */
        .progress { height: 8px; }
        .table th { font-weight: 600; }

        /* ====================== MOBILE CARD STYLES ====================== */
        .test-mobile-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .test-mobile-header {
            padding: 18px 20px;
            border-bottom: 1px solid #f1f5f9;
        }

        .test-mobile-body {
            padding: 20px;
        }

        .test-title {
            font-size: 17px;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 12px;
        }

        .test-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .meta-box {
            background: #f8fafc;
            padding: 12px 14px;
            border-radius: 12px;
        }

        .meta-label {
            font-size: 12.5px;
            color: #64748b;
            display: block;
            margin-bottom: 4px;
        }

        .meta-value {
            font-weight: 500;
            color: #1e2937;
        }

        .progress-container {
            margin: 15px 0;
        }

        .mobile-progress {
            height: 10px;
            border-radius: 10px;
            background: #e2e8f0;
        }

        .mobile-progress-bar {
            height: 100%;
            border-radius: 10px;
            transition: width 0.4s ease;
        }

        .free-badge {
            background: #22c55e;
            color: white;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 20px;
        }
         @media (max-width: 740px) {
    

.content{
    padding:0px !important;
}
}
    </style>

    <section class="content py-3">
        <div class="container">

            <!-- ==================== PURCHASED TEST SERIES ==================== -->
            <div class="mb-5">
                <h5 class="mb-3 fw-bold text-primary">
                    🎯 Purchased Test Series
                </h5>

                <!-- Desktop Table -->
                <div class="d-none d-lg-block">
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <table class="table table-bordered table-hover align-middle mb-0">
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
                                            <td style="width:180px">
                                                <div class="progress" style="height:8px;">
                                                    <div class="progress-bar {{ $progress == 100 ? 'bg-success' : 'bg-primary' }}" 
                                                         style="width: {{ $progress }}%"></div>
                                                </div>
                                                <small class="text-muted">{{ $progress }}% Completed</small>
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
                                                   class="btn btn-primary btn-sm">View Details</a>
                                            </td>
                                        </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                You have not purchased any Test Series yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Mobile Card View -->
                <div class="d-lg-none">
                    @forelse($paidOrders as $order)
                        @php
                            $testSeries = $order->test_series;
                            $tests = $testSeries ? $testSeries->tests : collect([]);
                            $totalTests = $tests->count();
                            $attemptedTests = $tests->whereIn('id', $studentAttempts)->count();
                            $progress = $totalTests > 0 ? round(($attemptedTests / $totalTests) * 100) : 0;
                        @endphp
                        @if($testSeries)
                        <div class="test-mobile-card">
                            <div class="test-mobile-header">
                                <div class="test-title">{{ $testSeries->title }}</div>
                            </div>
                            <div class="test-mobile-body">
                                <div class="test-meta">
                                    <div class="meta-box">
                                        <span class="meta-label">Total Papers</span>
                                        <span class="meta-value">{{ $totalTests }}</span>
                                    </div>
                                    <div class="meta-box">
                                        <span class="meta-label">Attempted</span>
                                        <span class="meta-value">{{ $attemptedTests }} / {{ $totalTests }}</span>
                                    </div>
                                </div>

                                <div class="progress-container">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">Progress</small>
                                        <small class="fw-medium">{{ $progress }}%</small>
                                    </div>
                                    <div class="mobile-progress">
                                        <div class="mobile-progress-bar bg-primary" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div>
                                        <small class="text-muted">Purchased On</small><br>
                                        <strong>{{ $order->created_at?->format('d M, Y') }}</strong>
                                    </div>
                                    <a href="{{ route('user.test-series-detail', $testSeries->slug) }}" 
                                       class="btn btn-primary">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <div class="alert alert-info text-center py-4">
                            You have not purchased any Test Series yet.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ==================== FREE TEST SERIES ==================== -->
            <div>
                <h5 class="mb-3 fw-bold text-success">
                    🆓 Free Test Series
                </h5>

                <!-- Desktop Table -->
                <div class="d-none d-lg-block">
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <table class="table table-bordered table-striped align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Test Series Name</th>
                                        <th>Total Papers</th>
                                        <th>Attempted</th>
                                        <th>Progress</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($freeSeries as $series)
                                        @php
                                            $tests = $series->tests ?? collect([]);
                                            $totalTests = $tests->count();
                                            $attemptedTests = $tests->whereIn('id', $studentAttempts)->count();
                                            $progress = $totalTests > 0 ? round(($attemptedTests / $totalTests) * 100) : 0;
                                        @endphp
                                        <tr>
                                            <td class="fw-bold">
                                                {{ $series->title }}
                                                <span class="badge bg-success ms-2">FREE</span>
                                            </td>
                                            <td>{{ $totalTests }}</td>
                                            <td>{{ $attemptedTests }} / {{ $totalTests }}</td>
                                            <td style="width:180px">
                                                <div class="progress" style="height:8px;">
                                                    <div class="progress-bar {{ $progress == 100 ? 'bg-success' : 'bg-primary' }}" 
                                                         style="width: {{ $progress }}%"></div>
                                                </div>
                                                <small class="text-muted">{{ $progress }}% Completed</small>
                                            </td>
                                            <td>
                                                @if($progress == 100)
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">In Progress</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('user.test-series-detail', $series->slug) }}" 
                                                   class="btn btn-outline-success btn-sm">View Details</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                No free test series available currently.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Mobile Card View for Free Series -->
                <div class="d-lg-none">
                    @forelse($freeSeries as $series)
                        @php
                            $tests = $series->tests ?? collect([]);
                            $totalTests = $tests->count();
                            $attemptedTests = $tests->whereIn('id', $studentAttempts)->count();
                            $progress = $totalTests > 0 ? round(($attemptedTests / $totalTests) * 100) : 0;
                        @endphp
                        <div class="test-mobile-card">
                            <div class="test-mobile-header bg-success bg-opacity-10">
                                <div class="test-title">
                                    {{ $series->title }}
                                    <span class="free-badge">FREE</span>
                                </div>
                            </div>
                            <div class="test-mobile-body">
                                <div class="test-meta">
                                    <div class="meta-box">
                                        <span class="meta-label">Total Papers</span>
                                        <span class="meta-value">{{ $totalTests }}</span>
                                    </div>
                                    <div class="meta-box">
                                        <span class="meta-label">Attempted</span>
                                        <span class="meta-value">{{ $attemptedTests }} / {{ $totalTests }}</span>
                                    </div>
                                </div>

                                <div class="progress-container">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">Progress</small>
                                        <small class="fw-medium">{{ $progress }}%</small>
                                    </div>
                                    <div class="mobile-progress">
                                        <div class="mobile-progress-bar bg-success" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('user.test-series-detail', $series->slug) }}" 
                                       class="btn btn-outline-success w-100">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info text-center py-4">
                            No free test series available currently.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </section>

@endsection