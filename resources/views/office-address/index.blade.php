@extends('layouts.app')

@section('title')
Office Address
@endsection

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between">

        <h5>Office Addresses</h5>

        <a href="{{ route('office-address.create') }}"
           class="btn btn-primary">

            Add Office

        </a>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>Office Type</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @foreach($addresses as $address)

                    <tr>

                        <td>
                            {{ $address->office_type }}
                        </td>

                        <td>
                            {{ $address->phone }}
                        </td>

                        <td>

                            @if($address->status)

                                <span class="badge bg-success">
                                    Active
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Inactive
                                </span>

                            @endif

                        </td>

                        <td>

    <div class="dropdown">

        <button class="btn btn-sm btn-primary dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">

            Actions

        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

            {{-- Edit --}}
            <li>

                <a href="{{ route('office-address.edit',$address->id) }}"
                   class="dropdown-item d-flex align-items-center gap-2">

                    <i class="fa fa-edit text-primary"></i>

                    Edit

                </a>

            </li>


            {{-- Delete --}}
            <li>

                <form action="{{ route('office-address.delete',$address->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this office address?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="dropdown-item d-flex align-items-center gap-2 text-danger">

                        <i class="fa fa-trash"></i>

                        Delete

                    </button>

                </form>

            </li>

        </ul>

    </div>

</td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection