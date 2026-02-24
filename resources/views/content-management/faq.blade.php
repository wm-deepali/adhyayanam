@extends('layouts.app')

@section('title')
    FAQ Management
@endsection

@section('content')
    <div class="bg-light rounded">
        <div class="card">
            <div class="card-body">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="card-title mb-0">FAQ</h5>
                        <h6 class="card-subtitle text-muted">
                            Manage your FAQ section here.
                        </h6>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        @if(\App\Helpers\Helper::canAccess('manage_faq_add'))
                            <a href="{{ route('faq.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Add FAQ
                            </a>
                        @endif

                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                            ← Back
                        </a>
                    </div>
                </div>

                {{-- SEARCH BAR --}}
                <div class="mb-3">
                    <form method="GET" action="{{ route('cm.faq') }}" class="d-flex align-items-center gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control form-control-sm" placeholder="Search FAQ..." style="width: 260px;">

                        <button type="submit" class="btn btn-primary btn-sm">
                            Search
                        </button>

                        <a href="{{ route('cm.faq') }}" class="btn btn-outline-secondary btn-sm">
                            Clear
                        </a>
                    </form>
                </div>

                {{-- Messages --}}
                <div class="mb-2">
                    @include('layouts.includes.messages')
                </div>

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th width="25%">Question</th>
                                <th>Answer</th>
                                <th width="12%">Category</th>
                                <th>Added By</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faqs as $faq)
                                <tr>
                                    <td>
                                        {{ ($faqs->currentPage() - 1) * $faqs->perPage() + $loop->iteration }}
                                    </td>
                                    <td>{{ $faq->question }}</td>
                                    <td>{{ $faq->answer }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ ucfirst(str_replace('_', ' ', $faq->type ?? 'general')) }}
                                        </span>

                                        @if($faq->show_on_home)
                                            <span class="badge bg-success ms-1">Home</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $faq->creator ? $faq->creator->name : 'Super Admin' }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                                Actions
                                            </button>

                                            <ul class="dropdown-menu">
                                                @if(\App\Helpers\Helper::canAccess('manage_faq_edit'))
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('faq.edit', $faq->id) }}">
                                                            Edit
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(\App\Helpers\Helper::canAccess('manage_faq_delete'))
                                                    <li>
                                                        <form action="{{ route('faq.destroy', $faq->id) }}" method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this FAQ?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No FAQs found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $faqs->links() }}
                </div>

            </div>
        </div>
    </div>

@endsection