@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <style>
        .dashboard-card {
            border: none;
            border-radius: 16px;
            transition: .3s;
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
        }

        .dashboard-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #fff;
        }

        .dashboard-number {
            font-size: 28px;
            font-weight: 700;
            line-height: 1;
        }

        .dashboard-label {
            color: #6c757d;
            font-size: 14px;
        }

        .table-card {
            border: none;
            border-radius: 16px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
        }
    </style>

    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Dashboard</h2>
            <p class="text-muted">Welcome to Adhyayanam Admin Panel</p>
        </div>
    </div>

    {{-- ROW 1 --}}
    <div class="row">

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="dashboard-icon bg-primary">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="ms-3">
                        <div class="dashboard-number">
                            {{ number_format($totalOrders) }}
                        </div>
                        <div class="dashboard-label">Total Orders</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="dashboard-icon bg-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="ms-3">
                        <div class="dashboard-number">
                            ₹{{ number_format($successfulPayments, 2) }}
                        </div>
                        <div class="dashboard-label">Successful Payments</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="dashboard-icon bg-danger">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="ms-3">
                        <div class="dashboard-number">
                            ₹{{ number_format($failedPayments, 2) }}
                        </div>
                        <div class="dashboard-label">Failed Payments</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="dashboard-icon bg-info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="ms-3">
                        <div class="dashboard-number">
                            {{ number_format($studentRegistered) }}
                        </div>
                        <div class="dashboard-label">Students Registered</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ROW 2 --}}
    <div class="row">

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="dashboard-icon bg-warning">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="ms-3">
                        <div class="dashboard-number">
                            {{ number_format($totalTestSeries) }}
                        </div>
                        <div class="dashboard-label">Test Series</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="dashboard-icon bg-primary">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="ms-3">
                        <div class="dashboard-number">
                            {{ number_format($totalCourses) }}
                        </div>
                        <div class="dashboard-label">Courses</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="dashboard-icon bg-success">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="ms-3">
                        <div class="dashboard-number">
                            {{ number_format($totalStudyMaterials) }}
                        </div>
                        <div class="dashboard-label">Study Material</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="dashboard-icon bg-dark">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="ms-3">
                        <div class="dashboard-number">
                            {{ number_format($totalLmsVideos) }}
                        </div>
                        <div class="dashboard-label">LMS Videos</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ROW 3 --}}
    <div class="row">

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="dashboard-icon bg-primary">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="ms-3">
                        <div class="dashboard-number">
                            {{ number_format($totalTestAttempted) }}
                        </div>
                        <div class="dashboard-label">Total Test Attempted</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="dashboard-icon bg-success">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="ms-3">
                        <div class="dashboard-number">
                            {{ number_format($resultDeclared) }}
                        </div>
                        <div class="dashboard-label">Result Declared</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="dashboard-icon bg-warning">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="ms-3">
                        <div class="dashboard-number">
                            {{ number_format($resultsPending) }}
                        </div>
                        <div class="dashboard-label">Results Pending</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card dashboard-card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="dashboard-icon bg-danger">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="ms-3">
                        <div class="dashboard-number">
                            {{ number_format($testPending) }}
                        </div>
                        <div class="dashboard-label">Test Pending</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- RECENT STUDENTS --}}
    <div class="card table-card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Recently Registered Students</h5>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Student Info</th>
                        <th>Order Purchased</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentStudents as $student)
                        <tr>
                            <td>
                                {{ $student->created_at->format('d M Y h:i A') }}
                            </td>

                          <td>
    <strong>{{ !empty($student->name) ? $student->name : 'Guest User' }}</strong>
    <br>
    <small>{{ $student->mobile ?? '-' }}</small>
</td>

                            <td>
                                {{ \App\Models\Order::where('student_id', $student->id)->latest()->value('package_name') ?? '-' }}
                                   <br>
    <small>  {{ \App\Models\Order::where('student_id', $student->id)->latest()->value('order_type') ?? '-' }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">
                                No students found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- RECENT ORDERS --}}
    <div class="card table-card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Recent Orders</h5>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Order ID</th>
                        <th>Student Info</th>
                        <th>Payment Status</th>
                        <th>Payment Method</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td>
                                {{ $order->created_at->format('d M Y h:i A') }}
                            </td>

                            <td>
                                {{ $order->order_code }}
                            </td>

                            <td>
                                <strong>{{ !empty( $order->student->name) ? $order->student->name : 'Guest User' }}</strong>
                                <br>
                                <small>{{ $order->student->mobile ?? '-' }}</small>
                            </td>

                            <td>
                                @if(strtolower($order->payment_status) == 'success')
                                    <span class="badge bg-success">
                                        {{ $order->payment_status }}
                                    </span>
                                @elseif(strtolower($order->payment_status) == 'failed')
                                    <span class="badge bg-danger">
                                        {{ $order->payment_status }}
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        {{ $order->payment_status }}
                                    </span>
                                @endif
                            </td>

                            <td>
                              {{ !empty($order->transaction->payment_method) ? $order->transaction->payment_method : 'Cashfree' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                No orders found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- RECENT TEST ATTEMPTS --}}
    <div class="card table-card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Recent Test Attempts</h5>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Test Name</th>
                        <th>Test Type</th>
                        <th>Student Info</th>
                        <th>Result Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentAttempts as $attempt)
                        <tr>
                            <td>
                                {{ $attempt->created_at->format('d M Y h:i A') }}
                            </td>

                            <td>
                                {{ $attempt->test->name ?? 'Deleted Test' }}
                            </td>

                            <td>
                                {{ ucfirst($attempt->test->test_paper_type ?? '-') }}
                            </td>

                            <td>
                                <strong>{{ !empty( $attempt->student->name) ? $attempt->student->name : 'Guest User' }}</strong>
                                <br>
                                <small>{{ $attempt->student->mobile ?? '-' }}</small>
                            </td>

                            <td>
                                @if($attempt->status == 'published')
                                    <span class="badge bg-success">Published</span>
                                @elseif($attempt->status == 'under_review')
                                    <span class="badge bg-warning">Under Review</span>
                                @else
                                    <span class="badge bg-danger">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                No attempts found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection