@extends('layouts.app')

@section('title')
  Students List
@endsection

@section('content')
  <style>
    .toggle-handle {
      background-color: #fff;
      border-color: #fff;
    }

    .btn {
      color: #fff !important;
    }
  </style>
  <div class="bg-light rounded p-2">
    <div class="card">
      <div class="card-body">
        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h5 class="card-title mb-0">Manage Students</h5>
            <h6 class="card-subtitle text-muted">Manage Students List here.</h6>
          </div>


          <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
            ← Back
          </a>
        </div>

        <div class="mt-2">
          @include('layouts.includes.messages')
        </div>

        <div class="container">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- Search Box -->
            <form method="GET" action="{{ route('students.registered-student-list') }}" class="d-flex gap-2 mb-3">

              <input type="text" name="search" class="form-control" placeholder="Search by name, email, mobile"
                value="{{ request('search') }}">

              <button type="submit" class="btn btn-success">
                Search
              </button>

              {{-- CLEAR BUTTON --}}
              @if(request()->filled('search'))
                <a href="{{ route('students.registered-student-list') }}" class="btn btn-secondary">
                  Clear
                </a>
              @endif
            </form>
          </div>

          <table class="table table-striped table-responsive table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>Date & Time</th>
                <th>Order Id</th>
                <th>Student Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Total Orders</th>
                <th>Total Paid</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($students as $res)
                <tr>
                  <td>
                    {{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}
                  </td>

                  <td>{{ $res->created_at }}</td>
                  <td>{{ $res->last_order }}</td>
                  <td>{{ $res->name }}</td>
                  <td>{{ $res->mobile }}</td>
                  <td>{{ $res->email }}</td>
                  <td>{{ $res->orders_count }}</td>
                  <td>Rs. {{ $res->transactions_sum_paid_amount ?? 0 }}</td>

                  <td>
                    <input data-id="{{ $res->id }}" class="toggle-class" type="checkbox" data-toggle="toggle"
                      data-on="Active" data-off="Inactive" {{ $res->status == 'Active' ? 'checked' : '' }}>
                  </td>

                  <td>
                    <div class="d-flex gap-2">

                    
                    @if(\App\Helpers\Helper::canAccess('manage_students_edit'))
                      <a href="{{ route('students.change-password', $res->id) }}" title="Change Password">
                        <i class="fa fa-user-lock"></i>
                      </a>
                    @endif
                      {{-- View Details --}}
                      <a href="{{ route('students.student-profile-detail', $res->id) }}" title="View Details">
                        <i class="fa fa-user"></i>
                      </a>

                      {{-- View Orders --}}
                      <a href="{{ route('students.view-all-orders', $res->id) }}" title="View Orders">
                        <i class="fa fa-shopping-cart"></i>
                      </a>

                      {{-- View Tests --}}
                      <a href="{{ route('students.student-test-result-detail') }}" title="View Tests">
                        <i class="fa fa-award"></i>
                      </a>

                      {{-- View Videos --}}
                      <a href="{{ route('students.student-videos-list') }}" title="View Videos">
                        <i class="fa fa-video"></i>
                      </a>

                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="d-flex justify-content-end mt-3">
            {{ $students->links() }}
          </div>
        </div>
        <!-- Modal -->

      </div>
    </div>
  </div>
@endsection
@push('after-scripts')
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <script>
    $(function () {
      $('.toggle-class').change(function () {
        var status = $(this).prop('checked') == true ? 'Active' : 'Inactive';
        var user_id = $(this).data('id');

        $.ajax({
          type: "GET",
          dataType: "json",
          url: '{{route("students.change-status")}}',
          data: { 'status': status, 'user_id': user_id },
          success: function (data) {
            console.log(data.success)
          }
        });
      })
    })
  </script>
@endpush