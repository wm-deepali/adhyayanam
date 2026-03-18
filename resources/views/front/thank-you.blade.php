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

    .success-icon {
        background: #22c55e;
    }

    .failed-icon {
        background: #ef4444;
    }

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
        margin-bottom: 25px;
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


    /* BUTTONS */

    .thank-btns {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .start-btn {
        background: #2563eb;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
    }

    .start-btn:hover {
        background: #1e4fd1;
    }

    .dashboard-btn {
        background: #e5e7eb;
        color: #111;
        padding: 10px 20px;
        border-radius:
</style>

<section class="thankyou-section">

    <div class="container">

        <div class="thankyou-card">

            <div class="thank-icon {{ $order->payment_status == 'PAID' ? 'success-icon' : 'failed-icon' }}">
                @if($order->payment_status == 'PAID')
                    ✔
                @else
                    ✖
                @endif
            </div>


            <h2 class="thank-title">
                @if($order->payment_status == 'PAID')
                    Thank You For Your Purchase!
                @else
                    Payment Failed
                @endif
            </h2>

            <p class="thank-text">
                @if($order->payment_status == 'PAID')
                    Your {{ $order->order_type ?? 'Package'}} has been activated successfully.
                    You can now access your content anytime from your dashboard.
                @else
                    Unfortunately your payment was not successful.
                    If the amount was deducted it will be refunded automatically.
                @endif
            </p>

            <div class="order-info">

                <div class="info-box">
                    <span>Order ID</span>
                    <strong>#{{ $order->order_code ?? 'TS1024' }}</strong>
                </div>

                <div class="info-box">
                    <span>{{ $order->order_type ?? 'Package'}}</span>
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
                    <strong>₹{{$order->total ?? '499'}}</strong>
                </div>

            </div>

            @if(isset($papers) && $papers->count())

                <div style="margin-top:20px;text-align:left">

                    <h4 style="margin-bottom:10px;">Purchased Papers</h4>

                    <ul style="padding-left:18px">

                        @foreach($papers as $paper)

                            <li style="margin-bottom:6px">
                                {{ $paper->name }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <div class="thank-btns">

                @if($order->order_type == 'Test Series')

                    <a href="{{ route('user.test-series-detail', $testSeries->slug) }}" class="start-btn">
                        Start Your Test
                    </a>

                @elseif($order->order_type == 'Course')

                    <a href="{{ route('course.detail', $course->id) }}" class="start-btn">
                        Start Learning
                    </a>

                @elseif($order->order_type == 'Study Material')

                    <a href="{{ route('study.material.details', $studyMaterial->id) }}" class="start-btn">
                        View Study Material
                    </a>

                @elseif($order->order_type == 'Paper')

                    <a href="{{ route('user.test-papers') }}" class="start-btn">
                        View Purchased Papers
                    </a>

                @endif

                <a href="{{route('user.dashboard')}}" class="dashboard-btn">
                    Go To Dashboard
                </a>

            </div>

        </div>

    </div>

</section>