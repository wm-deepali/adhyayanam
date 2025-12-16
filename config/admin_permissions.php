<?php

return [

    // ---------------- MASTER ----------------
    'Master' => [
        'manage_exam' => [
            'label' => 'Examinations Type',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ],
        'manage_category' => [
            'label' => 'Category',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ],
        'manage_subcategory' => [
            'label' => 'Sub Category',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ],
        'manage_subject' => [
            'label' => 'Subject',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ],
        'manage_chapter' => [
            'label' => 'Chapter',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ],
        'manage_topic' => [
            'label' => 'Topic',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ],
    ],

    // ---------------- TEST SERIES ----------------
    'Test Series' => [
        'manage_test_series_package' => [
            'label' => 'Test Series Package',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ],
        'manage_question_bank' => [
            'label' => 'Question Bank',
            'actions' => ['manage', 'add', 'edit', 'status', 'delete']
        ],
        'manage_test_bank' => [
            'label' => 'Test Papers',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ],
    ],

    // ---------------- TEST RESULTS ----------------
    'Test Results' => [
        'manage_test_attempts' => [
            'label' => 'Test Attempts',
            'actions' => ['manage', 'edit', 'delete']   // ONLY LISTING
        ],
    ],

    // ---------------- COURSES ----------------
    'Courses' => [
        'manage_courses' => [
            'label' => 'Courses',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ]
    ],

    // ---------------- STUDY MATERIAL ----------------
    'Study Material' => [
        'manage_study_material' => [
            'label' => 'Study Material',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ]
    ],

    // ---------------- TEACHER MANAGEMENT ----------------
    'Teacher Management' => [
        'manage_teachers' => [
            'label' => 'Manage Teachers',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ],
        'manage_teacher_wallet' => [
            'label' => 'Teacher Wallet',
            'actions' => ['manage']
        ],
        'manage_teacher_transactions' => [
            'label' => 'Transactions',
            'actions' => ['manage']
        ],
        'manage_withdrawal_requests' => [
            'label' => 'Withdrawal Requests',
            'actions' => ['manage', 'status']
        ],
    ],

    // ---------------- VIDEOS ----------------
    'Videos' => [
        'manage_videos' => [
            'label' => 'Manage Videos / Live Class',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ]
    ],

    // ---------------- PYQ ----------------
    'PYQ' => [
        'manage_pyq' => [
            'label' => 'Manage PYQ',
            'actions' => ['manage']
        ],
        'manage_pyq_content' => [
            'label' => 'Manage PYQ Content',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ],
    ],

    // ---------------- SYLLABUS ----------------
    'Syllabus' => [
        'manage_syllabus' => [
            'label' => 'Manage Syllabus',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ]
    ],

    // ---------------- CURRENT AFFAIRS ----------------
    'Current Affairs' => [
        'manage_ca_categories' => [
            'label' => 'CA Categories',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ],
        'manage_ca' => [
            'label' => 'Current Affair',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ],
    ],

    // ---------------- BATCHES AND PROGRAMME ----------------
    'Batches' => [
        'manage_batches' => [
            'label' => 'Batches & Programme',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ]
    ],

    // ---------------- TEST PLANNER ----------------
    'Test Planner' => [
        'manage_test_planner' => [
            'label' => 'Test Planner',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ]
    ],

    // ---------------- DAILY BOOSTER ----------------
    'Daily Booster' => [
        'manage_daily_booster' => [
            'label' => 'Daily Booster',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ]
    ],

    // ---------------- UPCOMING EXAMS ----------------
    'Upcoming Exams' => [
        'manage_upcoming_exams' => [
            'label' => 'Upcoming Exams',
            'actions' => ['manage', 'add', 'edit', 'delete']
        ]
    ],

    // ---------------- CONTENT MANAGEMENT ----------------
    'Content Management' => [
        'manage_about' => ['label' => 'About Us', 'actions' => ['manage', 'edit']],
        'manage_terms' => ['label' => 'Term & Conditions', 'actions' => ['manage', 'edit']],
        'manage_privacy' => ['label' => 'Privacy Policy', 'actions' => ['manage', 'edit']],
        'manage_refund' => ['label' => 'Refund & Cancellation', 'actions' => ['manage', 'edit']],
        'manage_cookies' => ['label' => 'Cookies Policy', 'actions' => ['manage', 'edit']],
        'manage_career' => ['label' => 'Career', 'actions' => ['manage', 'delete']],
        'manage_blog' => ['label' => 'Blog & Articles', 'actions' => ['manage', 'add', 'edit', 'delete']],
        'manage_team' => ['label' => 'Our Team', 'actions' => ['manage', 'add', 'edit', 'delete']],
        'manage_vision' => ['label' => 'Vision & Mission', 'actions' => ['manage', 'edit']],
        'manage_faq' => ['label' => 'FAQ', 'actions' => ['manage', 'add', 'edit', 'delete']],
    ],

    // ---------------- ORDERS ----------------
    'Orders & Subscriptions' => [
        'manage_all_orders' => ['label' => 'All Orders', 'actions' => ['manage']],
        'manage_test_series_orders' => ['label' => 'Test Series Orders', 'actions' => ['manage']],
        'manage_course_orders' => ['label' => 'Course Orders', 'actions' => ['manage']],
        'manage_study_material_orders' => ['label' => 'Study Material Orders', 'actions' => ['manage']],
        'manage_transactions' => ['label' => 'All Transactions', 'actions' => ['manage']],
        'manage_failed_payments' => ['label' => 'Failed Payments', 'actions' => ['manage']],
    ],

    // ---------------- ENQUIRIES ----------------
    'Enquiries' => [
        'manage_direct_enquiries' => ['label' => 'Direct Enquiries', 'actions' => ['manage', 'delete']],
        'manage_contact_inquiries' => ['label' => 'Contact Us Inquiries', 'actions' => ['manage', 'delete']],
        'manage_call_requests' => ['label' => 'Call Back Requests', 'actions' => ['manage', 'delete']],
        'manage_feedback' => ['label' => 'Feedback', 'actions' => ['manage', 'delete']],
        'manage_testimonials' => ['label' => 'Testimonials', 'actions' => ['manage', 'status', 'delete']],
    ],

    // ---------------- STUDENTS ----------------
    'Students' => [
        'manage_students' => ['label' => 'Manage Students', 'actions' => ['manage', 'status','update']],
        'manage_student_test_summary' => ['label' => 'Test Series Summary', 'actions' => ['manage']],
        'manage_student_course_summary' => ['label' => 'Courses Summary', 'actions' => ['manage']],
        'manage_student_videos' => ['label' => 'All Videos', 'actions' => ['manage']],
    ],

    // ---------------- SUB ADMIN ----------------
    'Sub Admin Management' => [
        'manage_role_groups' => ['label' => 'Role Groups', 'actions' => ['manage', 'add', 'edit', 'delete']],
        'manage_sub_admins' => ['label' => 'Sub Admins', 'actions' => ['manage', 'add', 'edit', 'delete']],
    ],

    // ---------------- SETTINGS ----------------
    'Settings' => [
        'manage_user_wallet' => ['label' => 'User Wallet', 'actions' => ['manage', 'add']],
        'manage_percentage' => ['label' => 'Manage Percentage', 'actions' => ['manage', 'add', 'edit', 'delete']],
        'manage_users' => ['label' => 'Users', 'actions' => ['manage', 'add', 'edit', 'delete']],
        // 'manage_roles' => ['label' => 'Roles', 'actions' => ['manage', 'add', 'edit', 'status', 'delete']],
        // 'manage_permissions' => ['label' => 'Permissions', 'actions' => ['manage']],
        'manage_seo' => ['label' => 'SEO', 'actions' => ['manage', 'add']],
        'manage_header' => ['label' => 'Header Settings', 'actions' => ['manage', 'add']],
        'manage_social' => ['label' => 'Social Media Settings', 'actions' => ['manage', 'add']],
        'manage_banner' => ['label' => 'Banner Settings', 'actions' => ['manage', 'add', 'edit', 'delete']],
        'manage_programme_feature' => ['label' => 'Programme Feature', 'actions' => ['manage', 'add']],
        'manage_marquee' => ['label' => 'Marquee Settings', 'actions' => ['manage', 'add', 'edit', 'delete']],
        'manage_popup' => ['label' => 'Popup Settings', 'actions' => ['manage', 'add']],
        'manage_feature' => ['label' => 'Feature Settings', 'actions' => ['manage', 'add']],
    ],

];
