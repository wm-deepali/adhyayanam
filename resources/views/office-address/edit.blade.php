@extends('layouts.app')

@section('title')
    Edit Office Address
@endsection

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5>Edit Office Address</h5>

        <a href="{{ route('office-address.index') }}"
           class="btn btn-secondary btn-sm">

            ← Back

        </a>

    </div>

    <div class="card-body">

        @include('layouts.includes.messages')

        <form action="{{ route('office-address.update',$address->id) }}"
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
                           value="{{ old('office_type',$address->office_type) }}"
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
                           value="{{ old('phone',$address->phone) }}">

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
                           value="{{ old('email',$address->email) }}">

                </div>

                {{-- Sort Order --}}
                <div class="col-md-6 mb-3">

                    <label>
                        Sort Order
                    </label>

                    <input type="number"
                           name="sort_order"
                           class="form-control"
                           value="{{ old('sort_order',$address->sort_order) }}">

                </div>

            </div>

            {{-- Status --}}
            <div class="mb-3">

                <label>
                    Status
                </label>

                <select name="status"
                        class="form-control">

                    <option value="1"
                        {{ $address->status == 1 ? 'selected' : '' }}>

                        Active

                    </option>

                    <option value="0"
                        {{ $address->status == 0 ? 'selected' : '' }}>

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
                          required>{{ old('address',$address->address) }}</textarea>

            </div>

            {{-- Google Map --}}
            <div class="mb-3">

                <label>
                    Google Map Embed Code
                </label>

                <textarea name="map_embbed"
                          class="form-control"
                          rows="5">{{ old('map_embbed',$address->map_embbed) }}</textarea>

            </div>

            <button type="submit"
                    class="btn btn-primary">

                Update Office Address

            </button>

        </form>

    </div>

</div>

@endsection