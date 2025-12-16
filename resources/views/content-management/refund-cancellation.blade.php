@extends('layouts.app')

@section('title')
    Refunds & Cancellation Policy Management
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Refunds & Cancellation Policy</h5>
                <h6 class="card-subtitle mb-2 text-muted"> Manage your refunds & cancellation policy section here.</h6>

                <div class="mt-2">
                    @include('layouts.includes.messages')
                </div>
                <div class="container mt-4">
                    <form id="refund-form" method="POST" action="{{ route('refund.cancellation.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="heading1" class="form-label">Heading</label>
                            <input value="{{ $refund->heading1 ?? ""}}" type="text" class="form-control" name="heading1"
                                placeholder="Heading" required>

                            @if ($errors->has('heading1'))
                                <span class="text-danger text-left">{{ $errors->first('heading1') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="description1" class="form-label">Description</label>
                            <textarea id="editor" name="description1"
                                style="height: 300px;">{!!$refund->description1!!}</textarea>
                            @if ($errors->has('description1'))
                                <span class="text-danger text-left">{{ $errors->first('description1') }}</span>
                            @endif
                        </div>
                        @if(\App\Helpers\Helper::canAccess('manage_refund_edit'))
                            <button type="submit" class="btn btn-primary">Save Page</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            CKEDITOR.replace('editor');
        });
    </script>
@endsection