<style>
    .thankyou-section {
        padding: 60px 20px;
        background: #f4f7fb;
        display: flex;
        justify-content: center;
    }

    .thankyou-card {
        background: white;
        max-width: 600px;
        width: 100%;
        padding: 40px;
        border-radius: 14px;
        text-align: center;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.08);
    }

    /* ICON */

    .thank-icon {
        width: 70px;
        height: 70px;
        color: white;
        font-size: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto 15px;
        font-weight: bold;
    }

    .success-icon { background: #22c55e; }
    .failed-icon { background: #ef4444; }
    .cancelled-icon { background: #6b7280; }
    .pending-icon { background: #f59e0b; }

    /* TITLE */

    .thank-title {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 10px;
    }

    /* TEXT */

    .thank-text {
        color: #555;
        font-size: 15px;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    /* ORDER INFO */

    .order-info {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 15px;
    }

    .info-box {
        background: #f6f8ff;
        padding: 12px;
        border-radius: 8px;
        font-size: 13px;
    }

    .info-box span {
        display: block;
        color: #777;
    }

    .info-box strong {
        font-size: 15px;
        color: #111;
    }

    /* PAYMENT META (gateway / mode / wallet) */

    .payment-meta {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-bottom: 15px;
    }

    .payment-meta .info-box {
        background: #fafafa;
        border: 1px dashed #ddd;
    }

    .wallet-box {
        background: #fff7ed !important;
        border: 1px dashed #fdba74 !important;
        margin-bottom: 25px;
    }

    /* STATUS BADGE */

    .status-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.03em;
    }

    .status-PAID { background: #dcfce7; color: #15803d; }
    .status-FAILED { background: #fee2e2; color: #b91c1c; }
    .status-CANCELLED { background: #e5e7eb; color: #374151; }
    .status-PENDING { background: #fef3c7; color: #92400e; }

    /* BUTTONS */

    .thank-btns {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .start-btn {
        background: #2563eb;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
    }

    .start-btn:hover { background: #1e4fd1; }

    .retry-btn {
        background: #ef4444;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
    }

    .retry-btn:hover { background: #d33d3d; }

    .dashboard-btn {
        background: #e5e7eb;
        color: #111;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
    }

    .dashboard-btn:hover { background: #d1d5db; }
</style>

<section class="thankyou-section">

    <div class="container">

        <div class="thankyou-card">

            @php
                // payment_status coming from PaymentController is one of: PAID | FAILED | CANCELLED | PENDING
                $status = $order->payment_status;

                $iconClass = match($status) {
                    'PAID' => 'success-icon',
                    'CANCELLED' => 'cancelled-icon',
                    'PENDING' => 'pending-icon',
                    default => 'failed-icon',
                };

                $iconSymbol = match($status) {
                    'PAID' => '✔',
                    'CANCELLED' => '⊘',
                    'PENDING' => '⏳',
                    default => '✖',
                };

                $title = match($status) {
                    'PAID' => 'Thank You For Your Purchase!',
                    'CANCELLED' => 'Payment Cancelled',
                    'PENDING' => 'Payment Pending',
                    default => 'Payment Failed',
                };

                $text = match($status) {
                    'PAID' => 'Your ' . ($order->order_type ?? 'Package') . ' has been activated successfully. You can now access your content anytime from your dashboard.',
                    'CANCELLED' => 'You cancelled the payment before it was completed. No amount has been deducted. You can retry whenever you\'re ready.',
                    'PENDING' => 'Your payment is still being confirmed by the bank. We will update your order automatically once confirmed — please avoid retrying immediately.',
                    default => 'Your payment could not be completed. If any amount was deducted, it will be refunded automatically within 5-7 business days.',
                };
            @endphp

            <div class="thank-icon {{ $iconClass }}">
                {{ $iconSymbol }}
            </div>

            <h2 class="thank-title">{{ $title }}</h2>

            <p class="thank-text">{{ $text }}</p>

            <div class="order-info">

                <div class="info-box">
                    <span>Order ID</span>
                    <strong>#{{ $order->order_code ?? 'TS1024' }}</strong>
                </div>

                <div class="info-box">
                    <span>{{ $order->order_type ?? 'Package' }}</span>
                    <strong>
                        @if($order->order_type == 'Course')
                            {{ $course->name }}
                        @elseif($order->order_type == 'Study Material')
                            {{ $studyMaterial->title }}
                        @elseif($order->order_type == 'Test Series')
                            {{ $testSeries->title }}
                        @elseif($order->order_type == 'Paper')
                            PYQ Papers
                        @endif
                    </strong>
                </div>

                <div class="info-box">
                    <span>Amount Paid</span>
                    <strong>₹{{ number_format($order->total ?? 0, 2) }}</strong>
                </div>

            </div>

            {{-- Payment Method / Mode -- this is what support needs to resolve queries --}}
            <div class="payment-meta">

                <div class="info-box">
                    <span>Payment Method</span>
                    <strong>{{ $order->payment_gateway ?? 'CashFree' }}</strong>
                </div>

                <div class="info-box">
                    <span>Payment Mode</span>
                    <strong>{{ $order->payment_mode ?? '—' }}</strong>
                </div>

            </div>

            @if(($order->wallet_used ?? 0) > 0)
                <div class="info-box wallet-box">
                    <span>Wallet Amount Used</span>
                    <strong>
                        ₹{{ number_format($order->wallet_used, 2) }}
                        @if($status !== 'PAID' && ($order->wallet_refunded ?? false))
                            <span style="font-weight:400;color:#9a3412;">(refunded to wallet)</span>
                        @endif
                    </strong>
                </div>
            @endif

            <div style="margin-bottom: 25px;">
                <span class="status-badge status-{{ $status }}">{{ strtoupper($status) }}</span>
            </div>

            @if($status == 'PAID' && isset($papers) && $papers->count())

                <div style="margin-top:20px;text-align:left">
                    <h4 style="margin-bottom:10px;">Purchased Papers</h4>
                    <ul style="padding-left:18px">
                        @foreach($papers as $paper)
                            <li style="margin-bottom:6px">{{ $paper->name }}</li>
                        @endforeach
                    </ul>
                </div>

            @endif

            <div class="thank-btns">

                @if($status == 'PAID')

                    @if($order->order_type == 'Test Series')
                        <a href="{{ route('user.test-series-detail', $testSeries->slug) }}" class="start-btn">Start Your Test</a>
                    @elseif($order->order_type == 'Course')
                        <a href="{{ route('course.detail', $course->id) }}" class="start-btn">Start Learning</a>
                    @elseif($order->order_type == 'Study Material')
                        <a href="{{ route('study.material.details', $studyMaterial->id) }}" class="start-btn">View Study Material</a>
                    @elseif($order->order_type == 'Paper')
                        <a href="{{ route('user.test-papers') }}" class="start-btn">View Purchased Papers</a>
                    @endif

                @else

                    <a href="{{ url()->previous() }}" class="retry-btn">Retry Payment</a>

                @endif

                <a href="{{ route('user.dashboard') }}" class="dashboard-btn">Go To Dashboard</a>

            </div>

        </div>

    </div>

</section>