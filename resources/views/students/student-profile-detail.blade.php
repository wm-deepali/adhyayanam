@extends('layouts.app')

@section('title', 'Student Profile')

@section('content')

<div class="bg-light rounded p-2">

    {{-- HEADER --}}
    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Student Profile</h5>
                <small class="text-muted">Detailed student overview</small>
            </div>

            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                ← Back
            </a>
        </div>
    </div>

    {{-- PROFILE + INFO --}}
    <div class="row">

        {{-- LEFT PROFILE --}}
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">

                    <img class="rounded-circle mb-3"
                         src="{{ $profile->avatar ? asset('/'.$profile->avatar) : asset('default-user.png') }}"
                         width="120" height="120">

                    <h5>{{ $profile->full_name }}</h5>
                    <p class="text-muted">{{ $profile->email }}</p>

                    <a href="{{ route('students.change-password', $profile->id) }}"
                       class="btn btn-dark btn-sm mt-2">
                        Change Password
                    </a>

                </div>
            </div>
        </div>

        {{-- RIGHT DETAILS --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>General Information</strong>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td>{{ $profile->full_name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $profile->email }}</td>
                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td>{{ $profile->mobile }}</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>{{ $profile->gender ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>DOB</th>
                            <td>{{ $profile->date_of_birth ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Joined</th>
                            <td>{{ $profile->created_at }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- SUMMARY CARDS --}}
    <div class="row mt-3">

        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h6>Test Series</h6>
                    <p>Total Orders: {{ $testSeries['totalOrder'] ?? 0 }}</p>
                    <p>Total Amount: ₹{{ $testSeries['totalBilledAmount'] ?? 0 }}</p>
                    <p>Last Order: #{{ $testSeries['lastOrderCode'] ?? '--' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h6>Courses</h6>
                    <p>Total Orders: {{ $course['totalOrder'] ?? 0 }}</p>
                    <p>Total Amount: ₹{{ $course['totalBilledAmount'] ?? 0 }}</p>
                    <p>Last Order: #{{ $course['lastOrderCode'] ?? '--' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h6>Study Material</h6>
                    <p>Total Orders: {{ $studyMaterial['totalOrder'] ?? 0 }}</p>
                    <p>Total Amount: ₹{{ $studyMaterial['totalBilledAmount'] ?? 0 }}</p>
                    <p>Last Order: #{{ $studyMaterial['lastOrderCode'] ?? '--' }}</p>
                </div>
            </div>
        </div>

    </div>

    {{-- TABS --}}
    <div class="card mt-4">
        <div class="card-body">

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#orders">
                        Orders
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#videos">
                        Videos
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-3">

                {{-- ORDERS TAB --}}
                <div class="tab-pane fade show active" id="orders">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($orders ?? [] as $order)
                                <tr>
                                    <td>{{ $order->order_code }}</td>
                                    <td>{{ $order->order_type }}</td>
                                    <td>₹{{ $order->billed_amount }}</td>
                                    <td>{{ $order->payment_status }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        No orders found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

                {{-- VIDEOS TAB --}}
                <div class="tab-pane fade" id="videos">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Video</th>
                                <th>Views</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($videos ?? [] as $v)
                                <tr>
                                    <td>{{ $v->video->title ?? '-' }}</td>
                                    <td>{{ $v->watched_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">
                                        No video activity
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>

</div>

@endsection