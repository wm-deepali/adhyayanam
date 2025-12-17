<style>
    .sidebar-nav::-webkit-scrollbar {
        display: none;
    }
</style>
<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-speedometer') }}"></use>
            </svg>
            {{ __('Dashboard') }}
        </a>
    </li>

    <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-notes') }}"></use>
            </svg>
            Test Series
        </a>
        <ul class="nav-group-items" style="height: 0px;">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('teacher.question.bank.index') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-av-timer') }}"></use>
                    </svg>
                    {{ __('Question Bank') }}
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-task') }}"></use>
            </svg>
            Test Evaluation
        </a>

        <ul class="nav-group-items" style="height: 0px;">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('teacher.results.assigned') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-list') }}"></use>
                    </svg>
                    Assigned Tests
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('teacher.results.completed') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-check-circle') }}"></use>
                    </svg>
                    Completed Evaluations
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->is('teacher/homework*') ? 'active' : '' }}"
            href="{{ route('teacher.homework.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-task') }}"></use>
            </svg>
            Submitted Assignments
        </a>
    </li>

    <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-cash') }}"></use>
            </svg>
            Wallet
        </a>
        <ul class="nav-group-items" style="height: 0px;">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('teacher.wallet.transactions.index') }}">
                    Transactions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('teacher.wallet.withdrawals.index') }}">
                    Withdrawal Requests
                </a>
            </li>
        </ul>
    </li>

</ul>