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
                <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
            </svg>
            {{ __('Master') }}
        </a>
        <ul class="nav-group-items" style="height: 0px;">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cm.exam') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('Examinations Type')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cm.category') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('Category')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cm.sub.category') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('Sub Category')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cm.subject') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('Subject')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cm.chapter') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('Chapter')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('topic.index') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('Topic')}}
                </a>
            </li>

        </ul>
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
                <a class="nav-link" href="{{route('test.series.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-note-add') }}"></use>
                    </svg>
                    {{ __('Test Series Package') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('question.bank.index') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-av-timer') }}"></use>
                    </svg>
                    {{ __('Question Bank') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('test.bank.index') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-av-timer') }}"></use>
                    </svg>
                    {{ __('Test Papers') }}
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('courses.course.*') ? 'active' : ''}}"
            href="{{ route('courses.course.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
            </svg>
            {{ __('Course') }}
        </a>
    </li>
    <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-notes') }}"></use>
            </svg>
            Study Material
        </a>
        <ul class="nav-group-items" style="height: 0px;">

            <li class="nav-item">
                <a class="nav-link {{ request()->is('study.material*') ? 'active' : ''}}"
                    href="{{route('study.material.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-note-add') }}"></use>
                    </svg>
                    {{ __('Study Material') }}
                </a>
            </li>

        </ul>
    </li>

    <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-people') }}"></use>
            </svg>
            {{ __('Teacher\'s Management') }}
        </a>
        <ul class="nav-group-items" style="height: 0px;">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('teachers*') ? 'active' : '' }}"
                    href="{{ route('manage-teachers.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                    </svg>
                    {{ __('Manage Teachers') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/teacher-wallet') ? 'active' : '' }}"
                    href="{{ route('teacher.wallet.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-cash') }}"></use>
                    </svg>
                    {{ __('Teacher Wallet') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/teacher-transactions') ? 'active' : '' }}"
                    href="{{ route('teacher.transactions.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-list') }}"></use>
                    </svg>
                    {{ __('Transactions') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/withdrawal-requests') ? 'active' : '' }}"
                    href="{{ route('withdrawal.requests.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-paper-plane') }}"></use>
                    </svg>
                    {{ __('Withdrawal Requests') }}
                </a>
            </li>
        </ul>
    </li>



    <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
            </svg>
            {{ __('LMS') }}
        </a>
        <ul class="nav-group-items" style="height: 0px;">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('video.index') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('Manage Videos')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('video.create') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('Add New Video')}}
                </a>
            </li>

        </ul>
    </li>
    <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-pencil') }}"></use>
            </svg>
            PYQ
        </a>
        <ul class="nav-group-items" style="height: 0px;">
            <li class="nav-item">
                <a class="nav-link" href="{{route('pyq.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    Manage PYQ
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('pyq.content.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    Manage PYQ Content
                </a>
            </li>

        </ul>
    </li>
    <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-school') }}"></use>
            </svg>
            Current Affairs
        </a>
        <ul class="nav-group-items" style="height: 0px;">
            <li class="nav-item">
                <a class="nav-link" href="{{route('current.affairs.topic')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    Categories
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('current.affairs.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    Current Affair
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('batches-programme*') ? 'active' : ''}}"
            href="{{ route('batches-programme.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-paperclip') }}"></use>
            </svg>
            {{ __('Batches and Programme') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('test-planner*') ? 'active' : ''}}"
            href="{{ route('test.planner.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-av-timer') }}"></use>
            </svg>
            {{ __('Test Planner') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('daily-booster*') ? 'active' : ''}}"
            href="{{ route('daily.boost.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-album') }}"></use>
            </svg>
            {{ __('Daily Booster') }}
        </a>
    </li>




    <li class="nav-item">
        <a class="nav-link {{ request()->is('upcoming-exams*') ? 'active' : ''}}"
            href="{{ route('upcoming.exam.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-av-timer') }}"></use>
            </svg>
            {{ __('Upcoming Exams') }}
        </a>
    </li>
    <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-pencil') }}"></use>
            </svg>
            {{ __('Content Management') }}
        </a>
        <ul class="nav-group-items" style="height: 0px;">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cm.about') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('About Us')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cm.term.condition') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('Term And Condition')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cm.privacy.policy') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('Privacy Policies')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cm.refund.cancellation') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('Refund and Cancellation Policies')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cm.cookies.policies') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('Cookies Policy')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cm.career') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('Career')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cm.blog.articles') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('Blog & Articles')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cm.our.team') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('Our Team')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cm.vision.mission') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('Our Vision And Mission')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cm.faq') }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    {{__('FAQ')}}
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-school') }}"></use>
            </svg>
            Orders & Subscriptions
        </a>
        <ul class="nav-group-items" style="height: 0px;">
            <li class="nav-item">
                <a class="nav-link" href="{{route('order.student-all-orders')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    All Orders
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('order.test-series-orders')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    Test Series Orders
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('order.course-orders')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    Courses Orders
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('order.study-material-orders')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    Study Material Orders
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('order.student-transactions-list')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    All Transactions
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('order.student-failed-transactions')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    Failed Payments
                </a>
            </li>

        </ul>
    </li>
    <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-info') }}"></use>
            </svg>
            Enquiries & Call Request
        </a>
        <ul class="nav-group-items" style="height: 0px;">
            <li class="nav-item">
                <a class="nav-link" href="{{route('enquiries.direct.call')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-speech') }}"></use>
                    </svg>
                    Direct Enquiries
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('enquiries.contact.us')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-contact') }}"></use>
                    </svg>
                    Contact Us Inquiries
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('enquiries.call.request')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-dialpad') }}"></use>
                    </svg>
                    Call Back Requests
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('feed.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-dialpad') }}"></use>
                    </svg>
                    Feedback
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('testimonials.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-dialpad') }}"></use>
                    </svg>
                    Testimonials
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-school') }}"></use>
            </svg>
            Students
        </a>
        <ul class="nav-group-items" style="height: 0px;">
            <li class="nav-item">
                <a class="nav-link" href="{{route('students.registered-student-list')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    Manage Students
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('students.student-test-series-summary')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    Test Series Summary
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('students.student-course-summary')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    Courses Summary
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('students.student-all-test-list')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    All Test Papers
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('students.student-videos-list')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    All Video's
                </a>
            </li>

        </ul>
    </li>




    <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-settings') }}"></use>
            </svg>
            Settings
        </a>
        <ul class="nav-group-items" style="height: 0px;">
            <li class="nav-item">
                <a class="nav-link" href="{{route('users.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                    </svg>
                    {{ __('Users') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('roles.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-group') }}"></use>
                    </svg>
                    {{ __('Roles') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('seo.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-search') }}"></use>
                    </svg>
                    {{ __('SEO') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('permissions.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-room') }}"></use>
                    </svg>
                    {{ __('Permissions') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('settings.header.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-header') }}"></use>
                    </svg>
                    Header Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('settings.social.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-header') }}"></use>
                    </svg>
                    Social Media Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('settings.banner.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-header') }}"></use>
                    </svg>
                    Banner Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('settings.programme_feature.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-header') }}"></use>
                    </svg>
                    Programme Feature Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('settings.marquee.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-header') }}"></use>
                    </svg>
                    Marquee Settings
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('settings.popup.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-header') }}"></use>
                    </svg>
                    Pop Up Settings
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('settings.feature.index')}}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-header') }}"></use>
                    </svg>
                    Feature Settings
                </a>
            </li>
        </ul>
    </li>
</ul>