<header class="header header-sticky mb-4">
    <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-menu') }}"></use>
            </svg>
        </button>
        <a class="header-brand d-md-none" href="#">
            <img style="width:118px; height:46px" src="{{ url('images/Neti-logo.png#full') }}" alt="Adhyayanam Logo">
        </a>
        <ul class="header-nav ms-auto">

        </ul>
        <ul class="header-nav ms-3">
            <li class="nav-item dropdown">
                <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="avatar">
                        <img class="avatar-img" src="{{ asset('img/default-avatar.jpg') }}"
                            alt="{{ Auth::guard('teacher')->user()-> email }}">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <a class="dropdown-item" href="{{ route('teacher.show', Auth::guard('teacher')->user()->id) }}">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                        </svg>
                        {{ __('My profile') }}
                    </a>
                    <form method="POST" action="{{ route('teacher.logout') }}">
                        @csrf
                        <a class="dropdown-item" href="{{ route('teacher.logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <svg class="icon me-2">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-account-logout') }}"></use>
                            </svg>
                            {{ __('Logout') }}
                        </a>
                    </form>
                </div>
            </li>
        </ul>
     
        @if (trim($__env->yieldContent('breadcrumbs')))
        <div class="header-divider"></div>
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    @yield('breadcrumbs')
                </ol>
            </nav>
        </div>
        @endif
    </div>
</header>