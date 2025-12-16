@extends('layouts.app')

@section('title', 'User Wallet Setting')

@section('content')
    <div class="bg-light rounded p-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">User Wallet Setting</h5>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Setting</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Wallet Setting</li>
                    </ol>
                </nav>

                <div class="mt-3">
                    @include('layouts.includes.messages')
                </div>

                <form action="{{ route('settings.user-wallet.store') }}" method="POST" id="walletSettingForm">
                    @csrf

                    {{-- Welcome Bonus --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Welcome Bonus</label>
                        <input type="number" class="form-control" name="welcome_bonus"
                            placeholder="Enter welcome bonus amount"
                            value="{{ old('welcome_bonus', $settings->welcome_bonus ?? 0) }}" required>
                        <small class="text-muted">
                            This amount will be credited to a new user's wallet upon registration.
                        </small>
                    </div>

                    {{-- Minimum Deposit Rules --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Minimum Deposit & Extra Bonus</label>

                        <div id="bonusRulesContainer">
                            @forelse($settings->bonusRules ?? [] as $rule)
                                <div class="row g-2 bonus-rule mb-2 align-items-center">
                                    <input type="hidden" name="rule_id[]" value="{{ $rule->id }}">

                                    <div class="col-md-3">
                                        <input type="number" name="min_deposit[]" class="form-control"
                                            value="{{ $rule->min_deposit }}" placeholder="Minimum Deposit" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="extra_bonus_value[]" class="form-control"
                                            value="{{ $rule->extra_bonus_value }}" placeholder="Bonus Value" required>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="bonus_type[]" class="form-select" required>
                                            <option value="percentage" @selected($rule->bonus_type === 'percentage')>Percentage
                                                (%)</option>
                                            <option value="fixed" @selected($rule->bonus_type === 'fixed')>Fixed Amount</option>
                                        </select>
                                    </div>
                                    @if(\App\Helpers\Helper::canAccess('manage_user_wallet_add'))
                                        <div class="col-md-3 text-end">
                                            <button type="button" class="btn btn-danger btn-sm removeRule">Remove</button>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                {{-- Show one blank rule if no data --}}
                                <div class="row g-2 bonus-rule mb-2 align-items-center">
                                    <input type="hidden" name="rule_id[]" value="">
                                    <div class="col-md-3">
                                        <input type="number" name="min_deposit[]" class="form-control"
                                            placeholder="Minimum Deposit" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="extra_bonus_value[]" class="form-control"
                                            placeholder="Bonus Value" required>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="bonus_type[]" class="form-select" required>
                                            <option value="percentage">Percentage (%)</option>
                                            <option value="fixed">Fixed Amount</option>
                                        </select>
                                    </div>
                                    @if(\App\Helpers\Helper::canAccess('manage_user_wallet_add'))
                                        <div class="col-md-3 text-end">
                                            <button type="button" class="btn btn-danger btn-sm removeRule">Remove</button>
                                        </div>
                                    @endif
                                </div>
                            @endforelse
                        </div>
                        
                        @if(\App\Helpers\Helper::canAccess('manage_user_wallet_add'))
                            <button type="button" class="btn btn-primary btn-sm mt-2" id="addMoreRule">
                                + Add More
                            </button>
                        @endif

                        <small class="text-muted d-block mt-1">
                            Example: Deposit ₹5000 → Get ₹500 extra OR 5% extra bonus.
                        </small>
                    </div>

                    @if(\App\Helpers\Helper::canAccess('manage_user_wallet_add'))
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Save Settings</button>
                        </div>
                    @endif

                </form>
            </div>
        </div>
    </div>

    {{-- JavaScript for Add/Remove dynamic bonus rules --}}
    <script>
        document.getElementById('addMoreRule').addEventListener('click', function () {
            const container = document.getElementById('bonusRulesContainer');
            const newRule = document.createElement('div');
            newRule.classList.add('row', 'g-2', 'bonus-rule', 'mb-2', 'align-items-center');
            newRule.innerHTML = `
                    <input type="hidden" name="rule_id[]" value="">
                    <div class="col-md-3">
                        <input type="number" name="min_deposit[]" class="form-control" placeholder="Minimum Deposit" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="extra_bonus_value[]" class="form-control" placeholder="Bonus Value" required>
                    </div>
                    <div class="col-md-3">
                        <select name="bonus_type[]" class="form-select" required>
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed Amount</option>
                        </select>
                    </div>
                    <div class="col-md-3 text-end">
                        <button type="button" class="btn btn-danger btn-sm removeRule">Remove</button>
                    </div>
                `;
            container.appendChild(newRule);
        });

        // Handle removing rows
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('removeRule')) {
                const row = e.target.closest('.bonus-rule');
                row.remove();
            }
        });
    </script>
@endsection