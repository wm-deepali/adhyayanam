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


                <form method="POST" action="{{route('paper.checkout')}}">
                    @csrf

                    <button type="submit" class="checkout-btn">
                        Proceed To Checkout
                    </button>

                </form>

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

@endsection