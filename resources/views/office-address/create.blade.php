@extends('layouts.app')

@section('title')
    Create Office Address
@endsection

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5>Create Office Address</h5>

        <a href="{{ route('office-address.index') }}"
           class="btn btn-secondary btn-sm">

            ← Back

        </a>

    </div>

    <div class="card-body">

        @include('layouts.includes.messages')

        <form action="{{ route('office-address.store') }}"
              method="POST">

            @csrf

            <div class="row">

                {{-- Office Type --}}
                <div class="col-md-6 mb-3">

                    <label>
                        Office Type
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="office_type"
                           class="form-control"
                           placeholder="Head Office / Branch Office"
                           value="{{ old('office_type') }}"
                           required>

                </div>

                {{-- Phone --}}
                <div class="col-md-6 mb-3">

                    <label>
                        Phone Number
                    </label>

                    <input type="text"
                           name="phone"
                           class="form-control"
                           placeholder="Phone Number"
                           value="{{ old('phone') }}">

                </div>

            </div>

            <div class="row">

                {{-- Email --}}
                <div class="col-md-6 mb-3">

                    <label>
                        Email Address
                    </label>

                    <input type="email"
                           name="email"
                           class="form-control"
                           placeholder="Email Address"
                           value="{{ old('email') }}">

                </div>

                {{-- Sort Order --}}
                <div class="col-md-6 mb-3">

                    <label>
                        Sort Order
                    </label>

                    <input type="number"
                           name="sort_order"
                           class="form-control"
                           value="{{ old('sort_order',0) }}">

                </div>

            </div>

            {{-- Status --}}
            <div class="mb-3">

                <label>
                    Status
                </label>

                <select name="status"
                        class="form-control">

                    <option value="1">
                        Active
                    </option>

                    <option value="0">
                        Inactive
                    </option>

                </select>

            </div>

            {{-- Address --}}
            <div class="mb-3">

                <label>
                    Office Address
                    <span class="text-danger">*</span>
                </label>

                <textarea name="address"
                          class="form-control"
                          rows="5"
                          placeholder="Enter full office address"
                          required>{{ old('address') }}</textarea>

            </div>

            {{-- Google Map --}}
            <div class="mb-3">

                <label>
                    Google Map Embed Code
                </label>

                <textarea name="map_embbed"
                          class="form-control"
                          rows="5"
                          placeholder="Paste Google Map iframe code here">{{ old('map_embbed') }}</textarea>

            </div>

            <button type="submit"
                    class="btn btn-primary">

                Save Office Address

            </button>

        </form>

    </div>

</div>

@endsection