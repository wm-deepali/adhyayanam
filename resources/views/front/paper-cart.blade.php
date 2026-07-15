@extends('front.partials.app')

@section('content')

    <style>
        .cart-container {
            max-width: 800px;
            margin: 40px auto;
        }

        .cart-card {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .cart-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .cart-table {
            width: 100%;
        }

        .cart-table th {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .cart-table td {
            padding: 12px 10px;
        }

        .cart-total {
            font-size: 18px;
            font-weight: 600;
            text-align: right;
            margin-top: 15px;
        }

        .checkout-btn {
            background: #2563eb;
            color: #fff;
            padding: 10px 18px;
            border-radius: 6px;
            border: none;
            margin-top: 15px;
        }

        .checkout-btn:hover {
            background: #1e4fd1;
        }

        .remove-btn {
            color: #ef4444;
            cursor: pointer;
            font-size: 14px;
        }

        .empty-cart {
            text-align: center;
            padding: 40px;
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


    <div class="cart-container">

        <div class="cart-card">

            <h2 class="cart-title">Your Cart</h2>

            @if(count($cart))

                @php
                    $total = 0;
                @endphp

                <table class="cart-table">

                    <thead>
                        <tr>
                            <th>Paper</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($cart as $id => $item)

                            <tr>

                                <td>{{ $item['name'] }}</td>

                                <td>₹{{ $item['price'] }}</td>

                                <td>
                                    <a href="{{ route('paper.remove', $id) }}" class="remove-btn">
                                        Remove
                                    </a>
                                </td>

                            </tr>

                            @php
                                $total += $item['price'];
                            @endphp

                        @endforeach

                    </tbody>

                </table>

                <div class="cart-total">
                    Total : ₹{{ $total }}
                </div>

                {{-- ✅ Replaces the old plain "Proceed To Checkout" form-submit.
                     Now opens the wallet checkout modal, same pattern as test-series-detail. --}}
                <button type="button" class="checkout-btn" id="openPaperCheckoutBtn"
                    data-ids="{{ implode(',', array_keys($cart)) }}">
                    Proceed To Checkout
                </button>

            @else

                <div class="empty-cart">

                    <h3>Your Cart Is Empty</h3>

                    <p>Add papers to start your purchase.</p>

                    <a href="{{ route('user.test-papers') }}" class="checkout-btn">
                        Browse Papers
                    </a>

                </div>

            @endif

        </div>

    </div>

    <!-- ============ WALLET CHECKOUT MODAL ============ -->
    <div class="modal fade" id="walletCheckoutModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-content">
                   <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="checkoutModalCourseName">Confirm Enrollment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 24px;">

                    <div id="walletLoadingState" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="text-muted mt-2 mb-0">Checking your wallet balance...</p>
                    </div>

                    <div id="walletCheckoutBody" style="display:none;">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Papers Total</span>
                            <strong id="modal_course_fee">₹0</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-3" id="walletBalanceRow">
                            <span class="text-muted">Your Wallet Balance</span>
                            <strong id="modal_wallet_balance" class="text-success">₹0</strong>
                        </div>

                        <div id="noBalanceNotice" class="alert alert-light border"
                            style="display:none; font-size: 14px;">
                            You don't have any wallet balance yet. You'll pay the full amount.
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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

    <script>
        let currentPackage = { type: 'paper', id: null };
        let walletData = { balance: 0, maxRedeemable: 0, fee: 0 };

        $(document).on('click', '#openPaperCheckoutBtn', function () {
            currentPackage = { type: 'paper', id: $(this).data('ids') };

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
                    id: currentPackage.id, // comma-separated paper ids
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

@endsection