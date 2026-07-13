@extends('front-users.layouts.app')

@section('title')
    Test Series Detail
@endsection

<style>
    .cb-item {
        align-items: center;
    }

    @media (max-width: 740px) {
        .content {
            padding: 0px !important;
        }

        .card-body {
            padding: 10px !important;

            flex-direction: column !important;
            gap: 10px !important;
        }

        .cb-item {
            align-items: start !important;
        }
    }

    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: end;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 16px;
        border-radius: 14px;
        margin-bottom: 16px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 170px;
    }

    .filter-group label {
        font-size: 12.5px;
        font-weight: 600;
        color: #64748b;
    }

    .filter-group select {
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 14px;
        background: #fff;
        color: #1e2937;
    }

    .filter-reset-btn {
        border: 1px solid #d1d5db;
        background: #fff;
        color: #374151;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        height: fit-content;
    }

    .filter-reset-btn:hover {
        border-color: #ef4444;
        color: #ef4444;
    }

    .filter-empty-state {
        display: none;
    }

    .paper-status-badge {
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        display: inline-block;
        margin-top: 6px;
    }

    .status-completed {
        background: #dcfce7;
        color: #15803d;
    }

    .status-in-progress {
        background: #fef3c7;
        color: #92400e;
    }

    .status-not-attempted {
        background: #f1f5f9;
        color: #64748b;
    }

    @media (max-width: 740px) {
        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            min-width: 100%;
        }
    }

    /* ====================== WALLET CHECKOUT MODAL ====================== */
    #walletCheckoutModal .modal-content {
        border-radius: 20px;
        border: none;
    }

    #walletCheckoutModal .modal-header {
        border-bottom: 1px solid #f1f5f9;
    }

    #walletCheckoutModal .modal-footer {
        border-top: 1px solid #f1f5f9;
    }

    #walletCheckoutModal .form-check-input {
        width: 3em;
        height: 1.5em;
        cursor: pointer;
    }

    #walletCheckoutModal .form-check-input:checked {
        background-color: #2563eb;
        border-color: #2563eb;
    }
</style>

@section('content')

    @php
        $user_id = auth()->id();
        $package_id = $testseries->id ?? null;
        $type = 'Test Series';

        // Check purchase (returns order data or null)
        $checkExist = ($user_id && $package_id)
            ? \App\Helpers\Helper::GetStudentOrder($type, $package_id, $user_id)
            : null;

        $totalTests = $testseries->tests->count() ?? 0;

        // Helper to work out Full/Subject/Chapter/Topic wise labelling (same logic used in admin evaluate view)
        $resolvePaperType = function ($testpaper) {
            if ($testpaper->paper_type == 1)
                return 'Previous Year';
            if ($testpaper->paper_type == 2)
                return 'Current Affair';

            if (is_null($testpaper->topic_id) && is_null($testpaper->subject_id) && is_null($testpaper->chapter_id)) {
                return 'Full Test';
            }
            if (!is_null($testpaper->subject_id) && is_null($testpaper->chapter_id)) {
                return 'Subject Wise';
            }
            if (!is_null($testpaper->chapter_id) && is_null($testpaper->topic_id)) {
                return 'Chapter Wise';
            }
            if (!is_null($testpaper->topic_id)) {
                return 'Topic Wise';
            }
            return '-';
        };

        // Helper to render attempt status for a paper
        $resolveAttemptStatus = function ($testpaper) use ($attempts) {
            $attempt = $attempts->get($testpaper->id);

            if (!$attempt) {
                return ['label' => 'Not Attempted', 'class' => 'status-not-attempted', 'btn_label' => 'Attempt Now'];
            }

            if ($attempt->status === 'in_progress') {
                return ['label' => 'In Progress', 'class' => 'status-in-progress', 'btn_label' => 'Resume Test'];
            }

            return ['label' => 'Completed', 'class' => 'status-completed', 'btn_label' => 'Retake Test'];
        };
    @endphp

    <section class="page-title mb-3">
        <div class="container">
            <h2>{{ $testseries->title }}</h2>
            <ul class="breadcrumb">
                <li><a href="{{ route('user.dashboard') }}">Home</a></li>
                <li>Test Series Detail</li>
            </ul>
        </div>
    </section>

    <section class="testseries-detail py-3">
        <div class="container">
            <div class="row">

                <div class="col-md-12">

                    {{-- Test Series Summary --}}
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body ">

                            <div class="text-center mb-3">
                                <img src="{{ $testseries->logo ? asset('storage/' . $testseries->logo) : asset('images/placeholder-logo.png') }}"
                                    class="img-fluid rounded" style="max-height:150px;max-width:150px;"
                                    alt="{{ $testseries->title }}">
                            </div>

                            <h3 class="mb-2">{{ $testseries->title }}</h3>

                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <div>
                                    <strong>{{ $totalTests }}</strong> Total Papers
                                </div>

                                <div>
                                    <span
                                        class="badge {{ $testseries->fee_type == 'paid' ? 'bg-warning text-dark' : 'bg-success' }}">
                                        {{ $testseries->fee_type == 'paid' ? 'Premium' : 'Free' }}
                                    </span>
                                </div>

                            </div>

                            <p class="text-muted">
                                Last updated on {{ $testseries->updated_at?->format('d M, Y') }}
                            </p>

                            {{-- Category Wise Counts --}}
                            @php
                                $fullCount = $testseries->testseries->where('type', 1)->count();
                                $subjectCount = $testseries->testseries->where('type', 2)->count();
                                $chapterCount = $testseries->testseries->where('type', 3)->count();
                                $topicCount = $testseries->testseries->where('type', 4)->count();
                                $currentCount = $testseries->testseries->where('type', 5)->count();
                                $prevCount = $testseries->testseries->where('type', 6)->count();
                            @endphp

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="list-group mb-3">
                                        <div class="list-group-item">Chapter Tests: {{ $chapterCount }}</div>
                                        <div class="list-group-item">Subject Tests: {{ $subjectCount }}</div>
                                        <div class="list-group-item">Topic Tests: {{ $topicCount }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="list-group mb-3">
                                        <div class="list-group-item">Full Tests: {{ $fullCount }}</div>
                                        <div class="list-group-item">Current Affair Papers: {{ $currentCount }}</div>
                                        <div class="list-group-item">Previous Year Papers: {{ $prevCount }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Description --}}
                            <h5 class="mt-3">About this Test Series</h5>
                            <div class="text-muted">
                                {!! $testseries->description !!}
                            </div>

                        </div>
                    </div>


                    {{-- Tests Listing --}}
                    <div class="card shadow-sm">
                        <div class="card-header fw-bold">
                            All Available Tests
                        </div>

                        <div class="card-body">

                            {{-- PAID but NOT PURCHASED --}}
                            @if($testseries->fee_type == 'paid' && !$checkExist)
                                <div class="alert alert-warning text-center mb-3">
                                    🔒 This is a premium test series.
                                    Please purchase to access tests.
                                </div>

                                <div class="text-center mb-3">
                                    <button type="button" class="btn btn-primary btn-lg" id="openEnrollModalBtn" data-type="test-series"
                                        data-id="{{ $testseries->id }}" data-name="{{ $testseries->name }}">
                                        Enroll Now
                                    </button>
                                </div>

                                <hr>
                            @endif


                            {{-- SHOW TESTS ONLY IF FREE OR PURCHASED --}}
                            @if($testseries->fee_type == 'free' || $checkExist)

                                <ul class="nav nav-tabs mb-3" id="testTabs">

                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#mockup">
                                            Mock Tests
                                        </button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#previous">
                                            Previous Year Papers
                                        </button>
                                    </li>

                                </ul>

                                <div class="tab-content">

                                    {{-- Mockup Tests --}}
                                    <div class="tab-pane fade show active" id="mockup">

                                        {{-- =============== MOCK TESTS FILTER BAR =============== --}}
                                        @if($subjects->count() || $chapters->count() || $topics->count())
                                            <div class="filter-bar" data-section="mock">

                                                <div class="filter-group">
                                                    <label>Subject</label>
                                                    <select class="filter-select" data-type="subject">
                                                        <option value="all">All Subjects</option>
                                                        @foreach($subjects as $subject)
                                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="filter-group">
                                                    <label>Chapter</label>
                                                    <select class="filter-select" data-type="chapter">
                                                        <option value="all">All Chapters</option>
                                                        @foreach($chapters as $chapter)
                                                            <option value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="filter-group">
                                                    <label>Topic</label>
                                                    <select class="filter-select" data-type="topic">
                                                        <option value="all">All Topics</option>
                                                        @foreach($topics as $topic)
                                                            <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="filter-group">
                                                    <label>Paper Type</label>
                                                    <select class="filter-select" data-type="papertype">
                                                        <option value="all">All Types</option>
                                                        <option value="Full Test">Full Test</option>
                                                        <option value="Subject Wise">Subject Wise</option>
                                                        <option value="Chapter Wise">Chapter Wise</option>
                                                        <option value="Topic Wise">Topic Wise</option>
                                                        <option value="Current Affair">Current Affair</option>
                                                    </select>
                                                </div>

                                                <button type="button" class="filter-reset-btn" data-reset="mock">
                                                    Reset Filters
                                                </button>

                                            </div>
                                        @endif

                                        @forelse($testseries->tests->where('paper_type', '!=', 1) as $testpaper)
                                            @php
                                                $status = $resolveAttemptStatus($testpaper);
                                                $paperTypeLabel = $resolvePaperType($testpaper);
                                            @endphp
                                            <div class="card mb-2 shadow-sm mock-test-row"
                                                data-subject="{{ $testpaper->subject_id ?? 'none' }}"
                                                data-chapter="{{ $testpaper->chapter_id ?? 'none' }}"
                                                data-topic="{{ $testpaper->topic_id ?? 'none' }}"
                                                data-papertype="{{ $paperTypeLabel }}">
                                                <div class="card-body cb-item d-flex justify-content-between ">

                                                    <div>
                                                        <strong>{{ $testpaper->name }}</strong>

                                                        {{-- ✅ TEST SYLLABUS --}}
                                                        <div class="text-muted small mt-1">
                                                            <span
                                                                class="badge bg-light text-dark border">{{ $paperTypeLabel }}</span>

                                                            @if($testpaper->subject)
                                                                <span class="ms-2"><strong>Subject:</strong>
                                                                    {{ $testpaper->subject->name }}</span>
                                                            @endif

                                                            @if($testpaper->chapter)
                                                                <span class="ms-2"><strong>Chapter:</strong>
                                                                    {{ $testpaper->chapter->name }}</span>
                                                            @endif

                                                            @if($testpaper->topic)
                                                                <span class="ms-2"><strong>Topic:</strong>
                                                                    {{ $testpaper->topic->name }}</span>
                                                            @endif
                                                        </div>

                                                        <div class="text-muted small mt-1">
                                                            {{ $testpaper->total_questions }} Questions |
                                                            {{ $testpaper->total_marks }} Marks |
                                                            {{ $testpaper->duration }} mins
                                                        </div>

                                                        <span class="paper-status-badge {{ $status['class'] }}">
                                                            {{ $status['label'] }}
                                                        </span>
                                                    </div>

                                                    <div>
                                                        <a href="{{ route('test.instruction', base64_encode($testpaper->id)) }}"
                                                            class="btn btn-success btn-sm">
                                                            {{ $status['btn_label'] }}
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-muted text-center py-3">No mock tests available in this series yet.</p>
                                        @endforelse

                                        <div class="filter-empty-state text-center py-4 text-muted" data-empty="mock">
                                            No tests match the selected filters.
                                        </div>

                                    </div>


                                    {{-- Previous Year Tests --}}
                                    <div class="tab-pane fade" id="previous">

                                        {{-- =============== PREVIOUS YEAR FILTER BAR =============== --}}
                                        @if($subjects->count() || $chapters->count() || $topics->count())
                                            <div class="filter-bar" data-section="previous">

                                                <div class="filter-group">
                                                    <label>Subject</label>
                                                    <select class="filter-select" data-type="subject">
                                                        <option value="all">All Subjects</option>
                                                        @foreach($subjects as $subject)
                                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="filter-group">
                                                    <label>Chapter</label>
                                                    <select class="filter-select" data-type="chapter">
                                                        <option value="all">All Chapters</option>
                                                        @foreach($chapters as $chapter)
                                                            <option value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="filter-group">
                                                    <label>Topic</label>
                                                    <select class="filter-select" data-type="topic">
                                                        <option value="all">All Topics</option>
                                                        @foreach($topics as $topic)
                                                            <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <button type="button" class="filter-reset-btn" data-reset="previous">
                                                    Reset Filters
                                                </button>

                                            </div>
                                        @endif

                                        @forelse($testseries->tests->where('paper_type', 1) as $testpaper)
                                            @php
                                                $status = $resolveAttemptStatus($testpaper);
                                            @endphp
                                            <div class="card mb-2 shadow-sm previous-test-row"
                                                data-subject="{{ $testpaper->subject_id ?? 'none' }}"
                                                data-chapter="{{ $testpaper->chapter_id ?? 'none' }}"
                                                data-topic="{{ $testpaper->topic_id ?? 'none' }}">
                                                <div class="card-body d-flex justify-content-between align-items-center">

                                                    <div>
                                                        <strong>{{ $testpaper->name }}</strong>

                                                        {{-- ✅ TEST SYLLABUS --}}
                                                        <div class="text-muted small mt-1">
                                                            @if($testpaper->subject)
                                                                <span><strong>Subject:</strong> {{ $testpaper->subject->name }}</span>
                                                            @endif

                                                            @if($testpaper->chapter)
                                                                <span class="ms-2"><strong>Chapter:</strong>
                                                                    {{ $testpaper->chapter->name }}</span>
                                                            @endif

                                                            @if($testpaper->topic)
                                                                <span class="ms-2"><strong>Topic:</strong>
                                                                    {{ $testpaper->topic->name }}</span>
                                                            @endif
                                                        </div>

                                                        <div class="text-muted small mt-1">
                                                            {{ $testpaper->total_questions }} Questions |
                                                            {{ $testpaper->total_marks }} Marks |
                                                            {{ $testpaper->duration }} mins
                                                        </div>

                                                        <span class="paper-status-badge {{ $status['class'] }}">
                                                            {{ $status['label'] }}
                                                        </span>
                                                    </div>

                                                    <div>
                                                        <a href="{{ route('test.instruction', base64_encode($testpaper->id)) }}"
                                                            class="btn btn-success btn-sm">
                                                            {{ $status['btn_label'] }}
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-muted text-center py-3">No previous year papers available in this series
                                                yet.</p>
                                        @endforelse

                                        <div class="filter-empty-state text-center py-4 text-muted" data-empty="previous">
                                            No tests match the selected filters.
                                        </div>

                                    </div>

                                </div>

                            @endif

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

      <!-- ============ WALLET CHECKOUT MODAL ============ -->
        <div class="modal fade" id="walletCheckoutModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title fw-bold" id="checkoutModalCourseName">Confirm Enrollment</h5>
                    </div>
                    <div class="modal-body" style="padding: 24px;">

                        <div id="walletLoadingState" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="text-muted mt-2 mb-0">Checking your wallet balance...</p>
                        </div>

                        <div id="walletCheckoutBody" style="display:none;">

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Study Material Fee</span>
                                <strong id="modal_course_fee">₹0</strong>
                            </div>

                            <div class="d-flex justify-content-between mb-3" id="walletBalanceRow">
                                <span class="text-muted">Your Wallet Balance</span>
                                <strong id="modal_wallet_balance" class="text-success">₹0</strong>
                            </div>

                            <div id="noBalanceNotice" class="alert alert-light border"
                                style="display:none; font-size: 14px;">
                                You don't have any wallet balance yet. You'll pay the full study material fee.
                            </div>

                            <div id="redeemSection" style="display:none;">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="redeemToggle">
                                    <label class="form-check-label fw-bold ms-2" for="redeemToggle">
                                        Redeem wallet points for this order
                                    </label>
                                </div>

                                <div id="redeemAmountBox" style="display:none;">
                                    <label for="redeemAmountInput" class="form-label">
                                        Amount to redeem (max ₹<span id="max_redeem_display">0</span>)
                                    </label>
                                    <input type="number" class="form-control" id="redeemAmountInput" min="0" step="1">
                                    <span id="redeemAmountError" class="text-danger"
                                        style="display:none; font-size: 13px;"></span>
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold" style="font-size: 15px;">Amount Payable Now</span>
                                <strong id="modal_payable_amount" class="text-primary" style="font-size: 22px;">₹0</strong>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmEnrollBtn" style="display:none;">
                            Proceed to Pay <span id="confirmEnrollAmount"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden form that actually submits to process-order -->
        <form id="processOrderForm" method="POST" action="" style="display:none;">
            @csrf
            <input type="hidden" name="wallet_redeem_amount" id="form_redeem_amount" value="0">
        </form>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
         <script>
        let currentPackage = { type: null, id: null };
        let walletData = { balance: 0, maxRedeemable: 0, fee: 0 };

        function openEnrollModal(btn) {
            currentPackage = { type: $(btn).data('type'), id: $(btn).data('id') };

            $('#checkoutModalCourseName').text('Confirm Enrollment');
            $('#walletLoadingState').show();
            $('#walletCheckoutBody').hide();
            $('#confirmEnrollBtn').hide();
            $('#redeemToggle').prop('checked', false);
            $('#redeemAmountBox').hide();
            $('#redeemAmountInput').val('');
            $('#redeemAmountError').hide();

            $('#walletCheckoutModal').modal('show');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                url: "{{ route('user.wallet.check-balance') }}",
                type: 'POST',
                data: {
                    type: currentPackage.type,
                    id: currentPackage.id,
                },
                success: function (res) {
                    $('#walletLoadingState').hide();
                    $('#walletCheckoutBody').show();
                    $('#confirmEnrollBtn').show();

                    if (!res.success) {
                        $('#walletCheckoutBody').html('<p class="text-danger mb-0">' + res.message + '</p>');
                        $('#confirmEnrollBtn').hide();
                        return;
                    }

                    walletData = {
                        balance: res.wallet_balance,
                        maxRedeemable: res.max_redeemable,
                        fee: res.course_fee
                    };

                    $('#modal_course_fee').text('₹' + res.course_fee);
                    $('#modal_wallet_balance').text('₹' + res.wallet_balance);

                    if (res.has_balance) {
                        $('#walletBalanceRow').show();
                        $('#noBalanceNotice').hide();
                        $('#redeemSection').show();
                        $('#max_redeem_display').text(res.max_redeemable);
                        $('#redeemAmountInput').attr('max', res.max_redeemable).val('');
                    } else {
                        $('#walletBalanceRow').show();
                        $('#noBalanceNotice').show();
                        $('#redeemSection').hide();
                    }

                    updatePayable(0);
                },
                error: function () {
                    $('#walletLoadingState').html('<p class="text-danger mb-0">Something went wrong. Please try again.</p>');
                }
            });
        }

        $(document).on('click', '#openEnrollModalBtn, #openEnrollModalBtnMobile', function () {
            openEnrollModal(this);
        });

        $('#redeemToggle').on('change', function () {
            if ($(this).is(':checked')) {
                $('#redeemAmountBox').show();
                $('#redeemAmountInput').val(walletData.maxRedeemable).trigger('input');
            } else {
                $('#redeemAmountBox').hide();
                $('#redeemAmountError').hide();
                updatePayable(0);
            }
        });

        $('#redeemAmountInput').on('input', function () {
            let val = parseFloat($(this).val()) || 0;

            if (val > walletData.maxRedeemable) {
                $('#redeemAmountError').show().text('You can redeem up to ₹' + walletData.maxRedeemable + ' only.');
                val = walletData.maxRedeemable;
                $(this).val(val);
            } else if (val < 0) {
                $('#redeemAmountError').show().text('Amount cannot be negative.');
                val = 0;
                $(this).val(val);
            } else {
                $('#redeemAmountError').hide();
            }

            updatePayable(val);
        });

        function updatePayable(redeemAmount) {
            let payable = Math.max(walletData.fee - redeemAmount, 0);
            $('#modal_payable_amount').text('₹' + payable.toFixed(2));
            $('#confirmEnrollAmount').text(payable > 0 ? '(₹' + payable.toFixed(2) + ')' : '(Free)');
        }

        $('#confirmEnrollBtn').on('click', function () {
            let redeemAmount = $('#redeemToggle').is(':checked')
                ? (parseFloat($('#redeemAmountInput').val()) || 0)
                : 0;

            $('#form_redeem_amount').val(redeemAmount);
            $('#processOrderForm').attr(
                'action',
                "{{ url('/order/process') }}/" + currentPackage.type + "/" + currentPackage.id
            );
            $('#processOrderForm').submit();
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            function applyFilters(section) {
                const bar = document.querySelector(`.filter-bar[data-section="${section}"]`);
                if (!bar) return;

                const selects = bar.querySelectorAll('.filter-select');
                const filters = {};

                selects.forEach(sel => {
                    filters[sel.dataset.type] = sel.value;
                });

                const rowClass = section === 'mock' ? '.mock-test-row' : '.previous-test-row';
                const rows = document.querySelectorAll(rowClass);
                let visibleCount = 0;

                rows.forEach(row => {
                    let matches =
                        (!filters.subject || filters.subject === 'all' || row.dataset.subject === filters.subject) &&
                        (!filters.chapter || filters.chapter === 'all' || row.dataset.chapter === filters.chapter) &&
                        (!filters.topic || filters.topic === 'all' || row.dataset.topic === filters.topic);

                    if (filters.papertype !== undefined) {
                        matches = matches && (filters.papertype === 'all' || row.dataset.papertype === filters.papertype);
                    }

                    row.style.display = matches ? '' : 'none';
                    if (matches) visibleCount++;
                });

                const emptyState = document.querySelector(`[data-empty="${section}"]`);
                if (emptyState) {
                    emptyState.style.display = (visibleCount === 0 && rows.length > 0) ? 'block' : 'none';
                }
            }

            document.querySelectorAll('.filter-bar').forEach(bar => {
                const section = bar.dataset.section;

                bar.querySelectorAll('.filter-select').forEach(sel => {
                    sel.addEventListener('change', () => applyFilters(section));
                });

                const resetBtn = bar.querySelector('[data-reset]');
                if (resetBtn) {
                    resetBtn.addEventListener('click', () => {
                        bar.querySelectorAll('.filter-select').forEach(sel => sel.value = 'all');
                        applyFilters(section);
                    });
                }
            });
        });
    </script>

@endsection