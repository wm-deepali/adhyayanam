@extends('front-users.layouts.app')

@section('title')
    Test Series
@endsection

@section('content')

    <style>
        /* ====================== DESKTOP TABLES (Unchanged) ====================== */
        .progress { height: 8px; }
        .table th { font-weight: 600; }

        /* ====================== MOBILE CARD STYLES ====================== */
        .test-mobile-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .test-mobile-header {
            padding: 18px 20px;
            border-bottom: 1px solid #f1f5f9;
        }

        .test-mobile-body {
            padding: 20px;
        }

        .test-title {
            font-size: 17px;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 12px;
        }

        .test-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .meta-box {
            background: #f8fafc;
            padding: 12px 14px;
            border-radius: 12px;
        }

        .meta-label {
            font-size: 12.5px;
            color: #64748b;
            display: block;
            margin-bottom: 4px;
        }

        .meta-value {
            font-weight: 500;
            color: #1e2937;
        }

        .progress-container {
            margin: 15px 0;
        }

        .mobile-progress {
            height: 10px;
            border-radius: 10px;
            background: #e2e8f0;
        }

        .mobile-progress-bar {
            height: 100%;
            border-radius: 10px;
            transition: width 0.4s ease;
        }

        .free-badge {
            background: #22c55e;
            color: white;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 20px;
        }

        /* ====================== FILTER BAR ====================== */
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: end;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 16px;
            border-radius: 14px;
            margin-bottom: 20px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 180px;
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

        @media (max-width: 740px) {

            .content {
                padding: 0px !important;
            }

            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                min-width: 100%;
            }
        }
    </style>

    <section class="content py-3">
        <div class="container">

            <!-- ==================== PURCHASED TEST SERIES ==================== -->
            <div class="mb-5">
                <h5 class="mb-3 fw-bold text-primary">
                    🎯 Purchased Test Series
                </h5>

                {{-- =============== PURCHASED FILTER BAR =============== --}}
                @if($purchasedCommissions->count() || $purchasedCategories->count() || $purchasedSubcategories->count())
                    <div class="filter-bar" data-section="purchased">

                        <div class="filter-group">
                            <label>Examination Commission</label>
                            <select class="filter-select" data-type="commission">
                                <option value="all">All Commissions</option>
                                @foreach($purchasedCommissions as $commission)
                                    <option value="{{ $commission->id }}">{{ $commission->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Category</label>
                            <select class="filter-select" data-type="category">
                                <option value="all">All Categories</option>
                                @foreach($purchasedCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Sub Category</label>
                            <select class="filter-select" data-type="subcategory">
                                <option value="all">All Sub Categories</option>
                                @foreach($purchasedSubcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="button" class="filter-reset-btn" data-reset="purchased">
                            Reset Filters
                        </button>

                    </div>
                @endif

                <!-- Desktop Table -->
                <div class="d-none d-lg-block">
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Test Series Name</th>
                                        <th>Commission</th>
                                        <th>Category</th>
                                        <th>Total Papers</th>
                                        <th>Attempted</th>
                                        <th>Progress</th>
                                        <th>Purchased On</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paidOrders as $order)
                                        @php
                                            $testSeries = $order->test_series;
                                            $tests = $testSeries ? $testSeries->tests : collect([]);
                                            $totalTests = $tests->count();
                                            $attemptedTests = $tests->whereIn('id', $studentAttempts)->count();
                                            $progress = $totalTests > 0 ? round(($attemptedTests / $totalTests) * 100) : 0;
                                        @endphp
                                        @if($testSeries)
                                        <tr class="purchased-series-row"
                                            data-commission="{{ $testSeries->exam_com_id ?? 'none' }}"
                                            data-category="{{ $testSeries->category_id ?? 'none' }}"
                                            data-subcategory="{{ $testSeries->sub_category_id ?? 'none' }}">
                                            <td class="fw-bold">{{ $testSeries->title }}</td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $testSeries->commission->name ?? 'Uncategorized' }}
                                                </span>
                                            </td>
                                            <td>{{ $testSeries->category->name ?? '-' }}</td>
                                            <td>{{ $totalTests }}</td>
                                            <td>{{ $attemptedTests }} / {{ $totalTests }}</td>
                                            <td style="width:180px">
                                                <div class="progress" style="height:8px;">
                                                    <div class="progress-bar {{ $progress == 100 ? 'bg-success' : 'bg-primary' }}"
                                                         style="width: {{ $progress }}%"></div>
                                                </div>
                                                <small class="text-muted">{{ $progress }}% Completed</small>
                                            </td>
                                            <td>{{ $order->created_at?->format('d M, Y') }}</td>
                                            <td>
                                                @if($progress == 100)
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">In Progress</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('user.test-series-detail', $testSeries->slug) }}"
                                                   class="btn btn-primary btn-sm">View Details</a>
                                            </td>
                                        </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4 text-muted">
                                                You have not purchased any Test Series yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="filter-empty-state text-center py-4 text-muted" data-empty="purchased-desktop">
                                No test series match the selected filters.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Card View -->
                <div class="d-lg-none" data-wrap="purchased-mobile">
                    @forelse($paidOrders as $order)
                        @php
                            $testSeries = $order->test_series;
                            $tests = $testSeries ? $testSeries->tests : collect([]);
                            $totalTests = $tests->count();
                            $attemptedTests = $tests->whereIn('id', $studentAttempts)->count();
                            $progress = $totalTests > 0 ? round(($attemptedTests / $totalTests) * 100) : 0;
                        @endphp
                        @if($testSeries)
                        <div class="test-mobile-card purchased-series-row"
                             data-commission="{{ $testSeries->exam_com_id ?? 'none' }}"
                             data-category="{{ $testSeries->category_id ?? 'none' }}"
                             data-subcategory="{{ $testSeries->sub_category_id ?? 'none' }}">
                            <div class="test-mobile-header">
                                <div class="test-title">{{ $testSeries->title }}</div>
                                <span class="badge bg-secondary">
                                    {{ $testSeries->commission->name ?? 'Uncategorized' }}
                                </span>
                                @if($testSeries->category)
                                    <span class="badge bg-light text-dark border">{{ $testSeries->category->name }}</span>
                                @endif
                            </div>
                            <div class="test-mobile-body">
                                <div class="test-meta">
                                    <div class="meta-box">
                                        <span class="meta-label">Total Papers</span>
                                        <span class="meta-value">{{ $totalTests }}</span>
                                    </div>
                                    <div class="meta-box">
                                        <span class="meta-label">Attempted</span>
                                        <span class="meta-value">{{ $attemptedTests }} / {{ $totalTests }}</span>
                                    </div>
                                </div>

                                <div class="progress-container">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">Progress</small>
                                        <small class="fw-medium">{{ $progress }}%</small>
                                    </div>
                                    <div class="mobile-progress">
                                        <div class="mobile-progress-bar bg-primary" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div>
                                        <small class="text-muted">Purchased On</small><br>
                                        <strong>{{ $order->created_at?->format('d M, Y') }}</strong>
                                    </div>
                                    <a href="{{ route('user.test-series-detail', $testSeries->slug) }}"
                                       class="btn btn-primary">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <div class="alert alert-info text-center py-4">
                            You have not purchased any Test Series yet.
                        </div>
                    @endforelse

                    <div class="alert alert-info text-center py-4 filter-empty-state" data-empty="purchased-mobile">
                        No test series match the selected filters.
                    </div>
                </div>
            </div>

            <!-- ==================== FREE TEST SERIES ==================== -->
            <div>
                <h5 class="mb-3 fw-bold text-success">
                    🆓 Free Test Series
                </h5>

                {{-- =============== FREE FILTER BAR =============== --}}
                @if($freeCommissions->count() || $freeCategories->count() || $freeSubcategories->count())
                    <div class="filter-bar" data-section="free">

                        <div class="filter-group">
                            <label>Examination Commission</label>
                            <select class="filter-select" data-type="commission">
                                <option value="all">All Commissions</option>
                                @foreach($freeCommissions as $commission)
                                    <option value="{{ $commission->id }}">{{ $commission->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Category</label>
                            <select class="filter-select" data-type="category">
                                <option value="all">All Categories</option>
                                @foreach($freeCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Sub Category</label>
                            <select class="filter-select" data-type="subcategory">
                                <option value="all">All Sub Categories</option>
                                @foreach($freeSubcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="button" class="filter-reset-btn" data-reset="free">
                            Reset Filters
                        </button>

                    </div>
                @endif

                <!-- Desktop Table -->
                <div class="d-none d-lg-block">
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <table class="table table-bordered table-striped align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Test Series Name</th>
                                        <th>Commission</th>
                                        <th>Category</th>
                                        <th>Total Papers</th>
                                        <th>Attempted</th>
                                        <th>Progress</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($freeSeries as $series)
                                        @php
                                            $tests = $series->tests ?? collect([]);
                                            $totalTests = $tests->count();
                                            $attemptedTests = $tests->whereIn('id', $studentAttempts)->count();
                                            $progress = $totalTests > 0 ? round(($attemptedTests / $totalTests) * 100) : 0;
                                        @endphp
                                        <tr class="free-series-row"
                                            data-commission="{{ $series->exam_com_id ?? 'none' }}"
                                            data-category="{{ $series->category_id ?? 'none' }}"
                                            data-subcategory="{{ $series->sub_category_id ?? 'none' }}">
                                            <td class="fw-bold">
                                                {{ $series->title }}
                                                <span class="badge bg-success ms-2">FREE</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $series->commission->name ?? 'Uncategorized' }}
                                                </span>
                                            </td>
                                            <td>{{ $series->category->name ?? '-' }}</td>
                                            <td>{{ $totalTests }}</td>
                                            <td>{{ $attemptedTests }} / {{ $totalTests }}</td>
                                            <td style="width:180px">
                                                <div class="progress" style="height:8px;">
                                                    <div class="progress-bar {{ $progress == 100 ? 'bg-success' : 'bg-primary' }}"
                                                         style="width: {{ $progress }}%"></div>
                                                </div>
                                                <small class="text-muted">{{ $progress }}% Completed</small>
                                            </td>
                                            <td>
                                                @if($progress == 100)
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">In Progress</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('user.test-series-detail', $series->slug) }}"
                                                   class="btn btn-outline-success btn-sm">View Details</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">
                                                No free test series available currently.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="filter-empty-state text-center py-4 text-muted" data-empty="free-desktop">
                                No test series match the selected filters.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Card View for Free Series -->
                <div class="d-lg-none" data-wrap="free-mobile">
                    @forelse($freeSeries as $series)
                        @php
                            $tests = $series->tests ?? collect([]);
                            $totalTests = $tests->count();
                            $attemptedTests = $tests->whereIn('id', $studentAttempts)->count();
                            $progress = $totalTests > 0 ? round(($attemptedTests / $totalTests) * 100) : 0;
                        @endphp
                        <div class="test-mobile-card free-series-row"
                             data-commission="{{ $series->exam_com_id ?? 'none' }}"
                             data-category="{{ $series->category_id ?? 'none' }}"
                             data-subcategory="{{ $series->sub_category_id ?? 'none' }}">
                            <div class="test-mobile-header bg-success bg-opacity-10">
                                <div class="test-title">
                                    {{ $series->title }}
                                    <span class="free-badge">FREE</span>
                                </div>
                                <span class="badge bg-secondary mt-2">
                                    {{ $series->commission->name ?? 'Uncategorized' }}
                                </span>
                                @if($series->category)
                                    <span class="badge bg-light text-dark border mt-2">{{ $series->category->name }}</span>
                                @endif
                            </div>
                            <div class="test-mobile-body">
                                <div class="test-meta">
                                    <div class="meta-box">
                                        <span class="meta-label">Total Papers</span>
                                        <span class="meta-value">{{ $totalTests }}</span>
                                    </div>
                                    <div class="meta-box">
                                        <span class="meta-label">Attempted</span>
                                        <span class="meta-value">{{ $attemptedTests }} / {{ $totalTests }}</span>
                                    </div>
                                </div>

                                <div class="progress-container">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">Progress</small>
                                        <small class="fw-medium">{{ $progress }}%</small>
                                    </div>
                                    <div class="mobile-progress">
                                        <div class="mobile-progress-bar bg-success" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('user.test-series-detail', $series->slug) }}"
                                       class="btn btn-outline-success w-100">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info text-center py-4">
                            No free test series available currently.
                        </div>
                    @endforelse

                    <div class="alert alert-info text-center py-4 filter-empty-state" data-empty="free-mobile">
                        No test series match the selected filters.
                    </div>
                </div>
            </div>

        </div>
    </section>

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

                const rowClass = section === 'purchased' ? '.purchased-series-row' : '.free-series-row';
                const rows = document.querySelectorAll(rowClass);
                let visibleCount = 0;

                rows.forEach(row => {
                    const matches =
                        (filters.commission === 'all' || row.dataset.commission === filters.commission) &&
                        (filters.category === 'all' || row.dataset.category === filters.category) &&
                        (filters.subcategory === 'all' || row.dataset.subcategory === filters.subcategory);

                    row.style.display = matches ? '' : 'none';
                    if (matches) visibleCount++;
                });

                const emptyDesktop = document.querySelector(`[data-empty="${section}-desktop"]`);
                const emptyMobile = document.querySelector(`[data-empty="${section}-mobile"]`);

                if (emptyDesktop) emptyDesktop.style.display = (visibleCount === 0 && rows.length > 0) ? 'block' : 'none';
                if (emptyMobile) emptyMobile.style.display = (visibleCount === 0 && rows.length > 0) ? 'block' : 'none';
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