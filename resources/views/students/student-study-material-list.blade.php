@extends('layouts.app')

@section('title', 'Student Study Material')

@section('content')
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            <h5>Study Material</h5>

            <h6 class="text-primary">
                Showing purchased materials for Student ID: {{ $studentId }}
            </h6>

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order Code</th>
                            <th>Material Name</th>
                            <th>Amount</th>
                            <th>Payment Status</th>
                            <th>Purchased At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($materials as $key => $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->package_name }}</td>
                                <td>₹{{ $order->billed_amount }}</td>
                                <td>{{ $order->payment_status }}</td>
                                <td>{{ $order->created_at }}</td>

                                <td>
                                    <a href="{{ route('students.student-study-material-detail', [$order->student_id, $order->package_id]) }}"
                                       title="View Detail">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No study material purchased
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $materials->links() }}
            </div>

        </div>
    </div>
</div>
@endsection