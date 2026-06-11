@extends('layouts.app')

@section('title')
    Counter Section
@endsection

@section('content')

<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Counter Section</h5>
                    <h6 class="card-subtitle text-muted">
                        Manage counter values and labels.
                    </h6>
                </div>

                <a href="{{ route('about.index') }}"
                   class="btn btn-secondary btn-sm">
                    ← Back
                </a>
            </div>

            <div class="mt-3">
                @include('layouts.includes.messages')
            </div>

            <form method="POST"
                  action="{{ route('about.counter.store') }}">

                @csrf

                <div class="card mt-3">
                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="mb-0">Counters</h6>

                            <button type="button"
                                    id="add-counter"
                                    class="btn btn-success btn-sm">
                                Add Counter
                            </button>
                        </div>

                        <div id="counter-wrapper">

                            @forelse($counters as $counter)

                                <div class="counter-row border rounded p-3 mb-3">

                                    <div class="row">

                                        <div class="col-md-5">
                                            <label class="form-label">
                                                Value
                                            </label>

                                            <input type="text"
                                                   class="form-control"
                                                   name="value[]"
                                                   value="{{ $counter->value }}"
                                                   placeholder="415+">
                                        </div>

                                        <div class="col-md-5">
                                            <label class="form-label">
                                                Label
                                            </label>

                                            <input type="text"
                                                   class="form-control"
                                                   name="label[]"
                                                   value="{{ $counter->label }}"
                                                   placeholder="Students Enrolled">
                                        </div>

                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button"
                                                    class="btn btn-danger remove-counter w-100">
                                                Remove
                                            </button>
                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="counter-row border rounded p-3 mb-3">

                                    <div class="row">

                                        <div class="col-md-5">
                                            <label class="form-label">
                                                Value
                                            </label>

                                            <input type="text"
                                                   class="form-control"
                                                   name="value[]"
                                                   placeholder="415+">
                                        </div>

                                        <div class="col-md-5">
                                            <label class="form-label">
                                                Label
                                            </label>

                                            <input type="text"
                                                   class="form-control"
                                                   name="label[]"
                                                   placeholder="Students Enrolled">
                                        </div>

                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button"
                                                    class="btn btn-danger remove-counter w-100">
                                                Remove
                                            </button>
                                        </div>

                                    </div>

                                </div>

                            @endforelse

                        </div>

                    </div>
                </div>

                <div class="mt-3">

                    @if(\App\Helpers\Helper::canAccess('manage_about_edit'))
                        <button type="submit"
                                class="btn btn-primary">
                            Save Changes
                        </button>
                    @endif

                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$(document).ready(function () {

    $('#add-counter').on('click', function () {

        let html = `
            <div class="counter-row border rounded p-3 mb-3">

                <div class="row">

                    <div class="col-md-5">
                        <label class="form-label">
                            Value
                        </label>

                        <input type="text"
                               class="form-control"
                               name="value[]"
                               placeholder="415+">
                    </div>

                    <div class="col-md-5">
                        <label class="form-label">
                            Label
                        </label>

                        <input type="text"
                               class="form-control"
                               name="label[]"
                               placeholder="Students Enrolled">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button"
                                class="btn btn-danger remove-counter w-100">
                            Remove
                        </button>
                    </div>

                </div>

            </div>
        `;

        $('#counter-wrapper').append(html);
    });

    $(document).on('click', '.remove-counter', function () {

        if ($('.counter-row').length > 1) {
            $(this).closest('.counter-row').remove();
        }

    });

});

</script>

@endsection