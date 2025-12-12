@extends('layouts.app')

@section('title', 'Add Percentage')

@section('content')

<div class="card shadow-sm">
    <div class="card-header">
        <h5>Add Percentage Range</h5>
    </div>

    <div class="card-body">

        @include('layouts.includes.messages')

        <form action="{{ route('percentage.system.store') }}" method="POST">
            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>From Percentage (%)</label>
                    <input type="number" step="0.01" name="from_percentage" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>To Percentage (%)</label>
                    <input type="number" step="0.01" name="to_percentage" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Division</label>
                    <input type="text" name="division" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

            </div>

            <button type="submit" class="btn btn-primary">Save</button>

        </form>
    </div>
</div>

@endsection
