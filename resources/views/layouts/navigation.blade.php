<style>
    .sidebar-nav::-webkit-scrollbar {
        display: none;
    }
</style>
<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>

    @php
        use App\Helpers\Helper;
    @endphp


    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-speedometer') }}"></use>
            </svg>
            {{ __('Dashboard') }}
        </a>
    </li>

    {{-- ================= MASTER ================= --}}
    @if(
            Helper::canAccess('manage_exam') ||
            Helper::canAccess('manage_category') ||
            Helper::canAccess('manage_subcategory') ||
            Helper::canAccess('manage_subject') ||
            Helper::canAccess('manage_chapter') ||
            Helper::canAccess('manage_topic')
        )
        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
                </svg>
                {{ __('Master') }}
            </a>
            <ul class="nav-group-items" style="height: 0px;">
                @if(Helper::canAccess('manage_exam'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cm.exam') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            {{__('Examinations Type')}}
                        </a>
                    </li>
                @endif
                @if(Helper::canAccess('manage_category'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cm.category') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            {{__('Category')}}
                        </a>
                    </li>
                @endif
                @if(Helper::canAccess('manage_subcategory'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cm.sub.category') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            {{__('Sub Category')}}
                        </a>
                    </li>
                @endif
                @if(Helper::canAccess('manage_subject'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cm.subject') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            {{__('Subject')}}
                        </a>
                    </li>
                @endif
                @if(Helper::canAccess('manage_chapter'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cm.chapter') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            {{__('Chapter')}}
                        </a>
                    </li>
                @endif
                @if(Helper::canAccess('manage_topic'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('topic.index') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            {{__('Topic')}}
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    {{-- ================= TEST SERIES ================= --}}
    @if(
            Helper::canAccess('manage_test_series_package') ||
            Helper::canAccess('manage_question_bank') ||
            Helper::canAccess('manage_test_bank')
        )
        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-notes') }}"></use>
                </svg>
                Test Series
            </a>
            <ul class="nav-group-items" style="height: 0px;">
                @if(Helper::canAccess('manage_test_series_package'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('test.series.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-note-add') }}"></use>
                            </svg>
                            {{ __('Test Series Package') }}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_question_bank'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('question.bank.index') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-av-timer') }}"></use>
                            </svg>
                            {{ __('Question Bank') }}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_test_bank'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('test.bank.index') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-av-timer') }}"></use>
                            </svg>
                            {{ __('Test Papers') }}
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    {{-- ================= TEST RESULTS ================= --}}
    @if(Helper::canAccess('manage_test_attempts'))
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin.results.*') ? 'active' : ''}}"
                href="{{ route('admin.results.all') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-check-circle') }}"></use>
                </svg>
                Test Results
            </a>
        </li>
    @endif

    {{-- ================= COURSES ================= --}}
    @if(Helper::canAccess('manage_courses'))
        <li class="nav-item">
            <a class="nav-link {{ request()->is('courses.course.*') ? 'active' : ''}}"
                href="{{ route('courses.course.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                </svg>
                {{ __('Course') }}
            </a>
        </li>
    @endif

    {{-- ================= STUDY MATERIAL ================= --}}
    @if(Helper::canAccess('manage_study_material'))
        <li class="nav-item">
            <a class="nav-link {{ request()->is('study.material*') ? 'active' : ''}}"
                href="{{route('study.material.index')}}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-notes') }}"></use>
                </svg>
                Study Material
            </a>
        </li>
    @endif

    {{-- ================= TEACHERS ================= --}}
    @if(
            Helper::canAccess('manage_teachers') ||
            Helper::canAccess('manage_teacher_wallet') ||
            Helper::canAccess('manage_teacher_transactions') ||
            Helper::canAccess('manage_withdrawal_requests')
        )
        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-people') }}"></use>
                </svg>
                {{ __('Teacher\'s Management') }}
            </a>
            <ul class="nav-group-items" style="height: 0px;">
                @if(Helper::canAccess('manage_teachers'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('teachers*') ? 'active' : '' }}"
                            href="{{ route('manage-teachers.index') }}">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                            </svg>
                            {{ __('Manage Teachers') }}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_teacher_wallet'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/teacher-wallet') ? 'active' : '' }}"
                            href="{{ route('teacher.wallet.index') }}">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-cash') }}"></use>
                            </svg>
                            {{ __('Teacher Wallet') }}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_teacher_transactions'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/teacher-transactions') ? 'active' : '' }}"
                            href="{{ route('teacher.transactions.index') }}">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-list') }}"></use>
                            </svg>
                            {{ __('Transactions') }}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_withdrawal_requests'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/withdrawal-requests') ? 'active' : '' }}"
                            href="{{ route('withdrawal.requests.index') }}">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-paper-plane') }}"></use>
                            </svg>
                            {{ __('Withdrawal Requests') }}
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    @if(Helper::canAccess('manage_videos'))
        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
                </svg>
                {{ __('Video/Live Class') }}
            </a>
            <ul class="nav-group-items" style="height: 0px;">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('video.index') }}" target="_top">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                        </svg>
                        {{__('Manage Videos/Live Class')}}
                    </a>
                </li>
            </ul>
        </li>
    @endif

    @if(
            Helper::canAccess('manage_pyq') ||
            Helper::canAccess('manage_pyq_content')
        )
        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-pencil') }}"></use>
                </svg>
                PYQ
            </a>
            <ul class="nav-group-items" style="height: 0px;">

                @if(Helper::canAccess('manage_pyq'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('pyq.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            Manage PYQ
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_pyq_content'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('pyq.content.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            Manage PYQ Content
                        </a>
                    </li>
                @endif

            </ul>
        </li>
    @endif

    @if(Helper::canAccess('manage_syllabus'))
        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-library') }}"></use>
                </svg>
                Syllabus
            </a>
            <ul class="nav-group-items" style="height: 0px;">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('syllabus.index') }}" target="_top">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-description') }}"></use>
                        </svg>
                        Manage Syllabus
                    </a>
                </li>
            </ul>
        </li>
    @endif

    @if(
            Helper::canAccess('manage_ca_categories') ||
            Helper::canAccess('manage_ca')
        )
        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-school') }}"></use>
                </svg>
                Current Affairs
            </a>
            <ul class="nav-group-items" style="height: 0px;">

                @if(Helper::canAccess('manage_ca_categories'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('current.affairs.topic.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            Categories
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_ca'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('current.affairs.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            Current Affair
                        </a>
                    </li>
                @endif

            </ul>
        </li>
    @endif

    @if(Helper::canAccess('manage_batches'))
        <li class="nav-item">
            <a class="nav-link {{ request()->is('batches-programme*') ? 'active' : ''}}"
                href="{{ route('batches-programme.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-paperclip') }}"></use>
                </svg>
                {{ __('Batches and Programme') }}
            </a>
        </li>
    @endif

    @if(Helper::canAccess('manage_test_planner'))
        <li class="nav-item">
            <a class="nav-link {{ request()->is('test-planner*') ? 'active' : ''}}"
                href="{{ route('test.planner.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-av-timer') }}"></use>
                </svg>
                {{ __('Test Planner') }}
            </a>
        </li>
    @endif

    @if(Helper::canAccess('manage_daily_booster'))
        <li class="nav-item">
            <a class="nav-link {{ request()->is('daily-booster*') ? 'active' : ''}}"
                href="{{ route('daily.boost.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-album') }}"></use>
                </svg>
                {{ __('Daily Booster') }}
            </a>
        </li>
    @endif

    @if(Helper::canAccess('manage_upcoming_exams'))
        <li class="nav-item">
            <a class="nav-link {{ request()->is('upcoming-exams*') ? 'active' : ''}}"
                href="{{ route('upcoming.exam.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-av-timer') }}"></use>
                </svg>
                {{ __('Upcoming Exams') }}
            </a>
        </li>
    @endif

    @if(
            Helper::canAccess('manage_about') ||
            Helper::canAccess('manage_terms') ||
            Helper::canAccess('manage_privacy') ||
            Helper::canAccess('manage_refund') ||
            Helper::canAccess('manage_cookies') ||
            Helper::canAccess('manage_career') ||
            Helper::canAccess('manage_blog') ||
            Helper::canAccess('manage_team') ||
            Helper::canAccess('manage_vision') ||
            Helper::canAccess('manage_faq')
        )
        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-pencil') }}"></use>
                </svg>
                {{ __('Content Management') }}
            </a>

            <ul class="nav-group-items" style="height: 0px;">

                @if(Helper::canAccess('manage_about'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cm.about') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            {{__('About Us')}}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_terms'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cm.term.condition') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            {{__('Term And Condition')}}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_privacy'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cm.privacy.policy') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            {{__('Privacy Policies')}}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_refund'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cm.refund.cancellation') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            {{__('Refund and Cancellation Policies')}}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_cookies'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cm.cookies.policies') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            {{__('Cookies Policy')}}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_career'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cm.career') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            {{__('Career')}}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_blog'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cm.blog.articles') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            {{__('Blog & Articles')}}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_team'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cm.our.team') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            {{__('Our Team')}}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_vision'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cm.vision.mission') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            {{__('Our Vision And Mission')}}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_faq'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cm.faq') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            {{__('FAQ')}}
                        </a>
                    </li>
                @endif

            </ul>
        </li>
    @endif

    @if(
            Helper::canAccess('manage_all_orders') ||
            Helper::canAccess('manage_test_series_orders') ||
            Helper::canAccess('manage_course_orders') ||
            Helper::canAccess('manage_study_material_orders') ||
            Helper::canAccess('manage_transactions') ||
            Helper::canAccess('manage_failed_payments')
        )
        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-school') }}"></use>
                </svg>
                Orders & Subscriptions
            </a>

            <ul class="nav-group-items" style="height: 0px;">

                @if(Helper::canAccess('manage_all_orders'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('order.student-all-orders')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            All Orders
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_test_series_orders'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('order.test-series-orders')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            Test Series Orders
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_course_orders'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('order.course-orders')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            Courses Orders
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_study_material_orders'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('order.study-material-orders')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            Study Material Orders
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_transactions'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('order.student-transactions-list')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            All Transactions
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_failed_payments'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('order.student-failed-transactions')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            Failed Payments
                        </a>
                    </li>
                @endif

            </ul>
        </li>
    @endif

    @if(
            Helper::canAccess('manage_direct_enquiries') ||
            Helper::canAccess('manage_contact_inquiries') ||
            Helper::canAccess('manage_call_requests') ||
            Helper::canAccess('manage_feedback') ||
            Helper::canAccess('manage_testimonials')
        )
        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-info') }}"></use>
                </svg>
                Enquiries & Call Request
            </a>

            <ul class="nav-group-items" style="height: 0px;">

                @if(Helper::canAccess('manage_direct_enquiries'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('enquiries.direct.call')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-speech') }}"></use>
                            </svg>
                            Direct Enquiries
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_contact_inquiries'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('enquiries.contact.us')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-contact') }}"></use>
                            </svg>
                            Contact Us Inquiries
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_call_requests'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('enquiries.call.request')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-dialpad') }}"></use>
                            </svg>
                            Call Back Requests
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_feedback'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('feed.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-dialpad') }}"></use>
                            </svg>
                            Feedback
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_testimonials'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('testimonials.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-dialpad') }}"></use>
                            </svg>
                            Testimonials
                        </a>
                    </li>
                @endif

            </ul>
        </li>
    @endif

    @if(
            Helper::canAccess('manage_students') ||
            Helper::canAccess('manage_student_test_summary') ||
            Helper::canAccess('manage_student_course_summary') ||
            Helper::canAccess('manage_student_videos')
        )
        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-school') }}"></use>
                </svg>
                Students
            </a>

            <ul class="nav-group-items" style="height: 0px;">

                @if(Helper::canAccess('manage_students'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('students.registered-student-list')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            Manage Students
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_student_test_summary'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('students.student-test-series-summary')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            Test Series Summary
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_student_course_summary'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('students.student-course-summary')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            Courses Summary
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_student_videos'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('students.student-videos-list')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                            </svg>
                            All Video's
                        </a>
                    </li>
                @endif

            </ul>
        </li>
    @endif

    @if(
            Helper::canAccess('manage_role_groups') ||
            Helper::canAccess('manage_sub_admins')
        )
        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-people') }}"></use>
                </svg>
                Sub Admin Management
            </a>

            <ul class="nav-group-items" style="height: 0px;">

                @if(Helper::canAccess('manage_role_groups'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('role-groups*') ? 'active' : '' }}"
                            href="{{ route('role-groups.index') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-group') }}"></use>
                            </svg>
                            Manage Role Groups
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_sub_admins'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('sub-admins*') ? 'active' : '' }}"
                            href="{{ route('sub-admins.index') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                            </svg>
                            Manage Sub Admins
                        </a>
                    </li>
                @endif

            </ul>
        </li>
    @endif

    @if(
            Helper::canAccess('manage_user_wallet') ||
            Helper::canAccess('manage_percentage') ||
            Helper::canAccess('manage_users') ||
            Helper::canAccess('manage_seo') ||
            Helper::canAccess('manage_header') ||
            Helper::canAccess('manage_social') ||
            Helper::canAccess('manage_banner') ||
            Helper::canAccess('manage_programme_feature') ||
            Helper::canAccess('manage_marquee') ||
            Helper::canAccess('manage_popup') ||
            Helper::canAccess('manage_feature')
        )
        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-settings') }}"></use>
                </svg>
                Settings
            </a>

            <ul class="nav-group-items" style="height: 0px;">

                @if(Helper::canAccess('manage_user_wallet'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('settings.user-wallet.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-header') }}"></use>
                            </svg>
                            User Wallet
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_percentage'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('percentage.system.index') }}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-list') }}"></use>
                            </svg>
                            {{ __('Manage Percentage') }}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_users'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('users.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                            </svg>
                            {{ __('Users') }}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_seo'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('seo.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-search') }}"></use>
                            </svg>
                            {{ __('SEO') }}
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_header'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('settings.header.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-header') }}"></use>
                            </svg>
                            Header Settings
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_social'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('settings.social.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-header') }}"></use>
                            </svg>
                            Social Media Settings
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_banner'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('settings.banner.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-header') }}"></use>
                            </svg>
                            Banner Settings
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_programme_feature'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('settings.programme_feature.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-header') }}"></use>
                            </svg>
                            Programme Feature Settings
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_marquee'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('settings.marquee.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-header') }}"></use>
                            </svg>
                            Marquee Settings
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_popup'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('settings.popup.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-header') }}"></use>
                            </svg>
                            Pop Up Settings
                        </a>
                    </li>
                @endif

                @if(Helper::canAccess('manage_feature'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('settings.feature.index')}}" target="_top">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-header') }}"></use>
                            </svg>
                            Feature Settings
                        </a>
                    </li>
                @endif

            </ul>
        </li>
    @endif

</ul>