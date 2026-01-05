<?php

use App\Models\Blog;
use App\Models\Course;
use App\Models\PopUp;
use App\Models\Team;
use App\Models\Banner;
use App\Models\Topic;
use App\Models\Feature;
use App\Models\TestSeries;
use App\Models\UpcomingExam;
use App\Models\DailyBooster;
use App\Models\FeedTestimonial;
use App\Models\ProgrammeFeature;
use App\Models\StudyMaterialCategory;
use App\Http\Controllers\TestController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\PYQController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontUserController;
use App\Http\Controllers\LiveTestController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CourseTopicController;
use App\Http\Controllers\ContentManagementController;
use App\Http\Controllers\Auth\TeacherLoginController;
use App\Http\Controllers\Admin\RoleGroupController;
use App\Http\Controllers\Admin\SubAdminController;
use App\Http\Controllers\Admin\TestResultController;
use App\Http\Controllers\Admin\TeacherWalletController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Teacher\QuestionBankController;
use App\Http\Controllers\Teacher\TeacherResultController;
use App\Http\Controllers\Admin\PercentageSystemController;
use App\Http\Controllers\Admin\AdminHomeworkController;
use \App\Http\Controllers\Teacher\TeacherHomeworkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    return '<h1>Clear Config cleared</h1>';
});

Route::get('/', function () {
    $data['courses'] = Course::with('examinationCommission', 'category', 'subCategory')->where('feature', 'on')->orderBy('created_at', 'DESC')->get();
    $data['topics'] = Topic::with('currentAffair')->get();
    $data['testSeries'] = TestSeries::all();
    $data['dailyBoosts'] = DailyBooster::all();
    $data['teams'] = Team::all();
    $data['banners'] = Banner::all();
    $data['studyCategories'] = StudyMaterialCategory::all();
    $data['programmeFeautre'] = ProgrammeFeature::first();
    $data['feature'] = Feature::first();
    $data['upcomingExams'] = UpcomingExam::with('exam_commission')->orderBy('created_at', 'DESC')->limit('5')->get();
    $data['blogs'] = Blog::with('user')->get();
    $data['testimonials'] = FeedTestimonial::where('type', 2)->orderBy('created_at', 'DESC')->limit(10)->get();

    // Check if the popup has been shown in this session
    if (!session()->has('popup_shown')) {
        $data['popup'] = PopUp::first();
        session(['popup_shown' => true]);
    } else {
        $data['popup'] = null;
    }

    return view('front.user.index', $data);
});

Route::get('/about', function () {
    return view('about');
});

Route::get('pyq-papers/{examid}/{catid}/{subcat}', [FrontController::class, 'pyqPapers'])->name('pyq-papers');
Route::get('test-series/{examid}/{catid}/{subcat}', [FrontController::class, 'testseries'])->name('test-series');
Route::get('test-series-detail/{slug}', [FrontController::class, 'testseriesDetail'])->name('test-series-detail');

Route::get('live-test/{id}', [LiveTestController::class, 'livetest'])->name('live-test');
Route::post('/fetch-question', [LiveTestController::class, 'fetchQuestion']);
Route::post('/save-answer', [LiveTestController::class, 'saveAttemptAnswer']);
Route::post('/finalize-test', [LiveTestController::class, 'finalizeStudentTest']);
Route::get('/test-result/{id}', [LiveTestController::class, 'viewTestResult'])->name('user.test-result');
Route::post('/clear-answer', [LiveTestController::class, 'clearAnswer']);

Route::get('subject-pyqs/{id}', [FrontController::class, 'subjectPapers'])->name('subject-pyqs');
Route::post('/sendotopstudent', [FrontController::class, 'sendotopstudent'])->name('sendotopstudent');
Route::post('/verifymobilenumberstudent', [FrontController::class, 'verifymobilenumberstudent'])->name('verifymobilenumberstudent');
Route::get('/logout', [FrontController::class, 'logout'])->name('logouts');
Route::get('about-us', [FrontController::class, 'aboutIndex'])->name('about');
Route::get('term-and-conditions', [FrontController::class, 'termIndex'])->name('term.conditions');
Route::get('privacy-policy', [FrontController::class, 'privacyIndex'])->name('privacy.policy');
Route::get('refund-policy', [FrontController::class, 'refundCancellationIndex'])->name('refund.policy');
Route::get('cookies-policy', [FrontController::class, 'cookiesIndex'])->name('cookies.policy');
Route::get('faq', [FrontController::class, 'faqIndex'])->name('faq');
Route::get('vision-mission', [FrontController::class, 'visionIndex'])->name('vision.mission');

Route::get('blog-articles', [FrontController::class, 'blogIndex'])->name('blog.articles');
Route::get('blog-details/{id}', [FrontController::class, 'blogDetailsIndex'])->name('blog.details');
Route::get('career', [FrontController::class, 'careerIndex'])->name('career');
Route::post('career/store', [FrontController::class, 'careerStore'])->name('career.store');
Route::get('courses', [FrontController::class, 'courseIndex'])->name('courses');
Route::get('courses/category/{id}', [FrontController::class, 'courseFilter'])->name('courses.filter');
Route::get('courses/details/{id}', [FrontController::class, 'courseDetails'])->name('courses.detail');
Route::get('direct-enquiry', [FrontController::class, 'enquiryIndex'])->name('enquiry.direct');
Route::post('direct-enquiry/store', [FrontController::class, 'enquiryStore'])->name('enquiry.store');
Route::get('contact-us-inquiry', [FrontController::class, 'contactUsIndex'])->name('contact.inquiry');
Route::post('contact-us-inquiry/store', [FrontController::class, 'contactUsStore'])->name('contact.inquiry.store');
Route::get('callback-inquiry', [FrontController::class, 'callbackIndex'])->name('callback.inquiry');
Route::post('callback-inquiry/store', [FrontController::class, 'callbackStore'])->name('callback.inquiry.store');
Route::get('our-team', [FrontController::class, 'ourTeamIndex'])->name('our.team.index');
Route::get('current-affair', [FrontController::class, 'currentAffairsIndex'])->name('current.index');
Route::get('current-affair/details/{id}', [FrontController::class, 'currentAffairsDetail'])->name('current.details');
Route::get('daily-boost', [FrontController::class, 'dailyBoostIndex'])->name('daily.boost.front');
Route::get('/daily-booster/detail/{id}', [FrontController::class, 'dailyBoostDetail'])->name('daily.booster.detail');

Route::get('user/test-planner', [FrontController::class, 'testPlannerIndex'])->name('test.planner.front');
Route::get('user/test-planner/details/{id}', [FrontController::class, 'testPlannerDetails'])->name('test.planner.details');
Route::get('user/study-material/details/{id}', [FrontController::class, 'studyMaterialDetails'])->name('study.material.details');
Route::get('user/study-material/{examid?}/{catid?}/{subcat?}', [FrontController::class, 'studyMaterialIndex'])->name('study.material.front');
Route::post('user/study-material/filter', [FrontController::class, 'studyMaterialFilter'])->name('study.material.filter');
Route::post('user/study-material/search', [FrontController::class, 'studyMaterialSearch'])->name('study.material.search');
Route::get('user/study-material/all-topics/{id}', [FrontController::class, 'studyMaterialAllTopics'])->name('study.material.topics');
Route::get('user/upcoming-exams', [FrontController::class, 'upcomingExamsIndex'])->name('upcoming.exam.front');
Route::get('user/adhyayanam-corner', [FrontController::class, 'netiCornerIndex'])->name('neti.corner.index');
Route::get('user/feed-back-testimonial', [FrontController::class, 'feedBackIndex'])->name('feed.back.index');
Route::post('user/feed-back-testimonial/store', [FrontController::class, 'feedBackStore'])->name('feed.back.store');
Route::get('user/batches-and-programme', [FrontController::class, 'batchesIndex'])->name('batches.index');
Route::get('user/syllabus/{examid?}/{catid?}/{subcat?}', [FrontController::class, 'syllabusIndex'])->name('syllabus.front');
/**
 * Auth Routes
 */
Auth::routes(['verify' => false]);


Route::group(['namespace' => 'App\Http\Controllers'], function () {

    // teacher panel routes
    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/login', [TeacherLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [TeacherLoginController::class, 'login']);
        Route::post('/logout', [TeacherLoginController::class, 'logout'])->name('logout');
        Route::get('password/reset', [TeacherLoginController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [TeacherLoginController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [TeacherLoginController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [TeacherLoginController::class, 'reset'])->name('password.update');
        // Other teacher-authenticated routes using 'auth:teacher' middleware
        Route::middleware(['auth:teacher'])->group(function () {
            // teacher home route
            Route::get('/dashboard', function () {
                return view('teachers.home');
            })->name('dashboard');

            // teacher profile routes
            Route::get('/{teacher}/show', [TeacherController::class, 'show'])->name('show');
            Route::patch('/change-password', [TeacherController::class, 'changePassword'])->name('change-password');

            // teacher question bank routes
            Route::get('question-bank', [QuestionBankController::class, 'index'])->name('question.bank.index');
            Route::get('rejected-question-bank', [QuestionBankController::class, 'rejectQuestionBankIndex'])->name('question.bank.rejected');
            Route::get('question-bank/pending', [QuestionBankController::class, 'pendingQuestionBankIndex'])->name('question.bank.pending');
            Route::get('question-bank/create', [QuestionBankController::class, 'create'])->name('question.bank.create');
            Route::post('question-bank/store', [QuestionBankController::class, 'store'])->name('question.bank.store');
            Route::post('question-bank/import-questions', [QuestionBankController::class, 'ImportQuestions'])->name('question.bank.import-questions');
            Route::get('question-bank/bulk-upload', [QuestionBankController::class, 'questionBankBulkUpload'])->name('question.bank.bulk-upload');
            Route::delete('question-bank/delete/{id}', [QuestionBankController::class, 'questionBankDelete'])->name('question.bank.delete');
            Route::get('question-bank/edit/{id}', [QuestionBankController::class, 'questionBankEdit'])->name('question.bank.edit');
            Route::post('question-bank/update/{id}', [QuestionBankController::class, 'questionBankUpdate'])->name('question.bank.update');
            Route::get('question-bank/view/{id}', [QuestionBankController::class, 'questionBankView'])->name('question.bank.view');

            // filter teacher mapped data
            Route::get('/fetch-categories-by-commission/{commission}', [QuestionBankController::class, 'fetchCategoriesByCommission'])
                ->name('question.bank.fetch-categories');
            Route::get('/fetch-subcategories-by-category/{category}', [QuestionBankController::class, 'fetchSubcategoriesByCategory'])
                ->name('question.bank.fetch-subcategories');
            Route::get('/fetch-subjects-by-subcategory/{sub_category}', [QuestionBankController::class, 'fetchSubjectsBySubcategory'])
                ->name('question.bank.fetch-subjects');
            Route::get('fetch-chapter-by-subject/{subject}', 'TestController@fetchchapterbySubject')->name('fetch-chapter-by-subject');
            Route::get('fetch-topic-by-chapter/{subject}', 'TestController@fetchtopicbychapter')->name('fetch-topic-by-chapter');


            // show walllet transaction 
            Route::get('wallet/transactions', [TeacherController::class, 'TransactionsIndex'])
                ->name('wallet.transactions.index');
            Route::post('/withdraw-request', [TeacherController::class, 'withdrawRequest'])
                ->name('withdraw.request');

            // Withdrawal Requests page for teachers
            Route::get('/wallet/withdrawals', [TeacherController::class, 'withdrawalsIndex'])
                ->name('wallet.withdrawals.index');

            Route::get('/assigned', [TeacherResultController::class, 'assigned'])->name('results.assigned');

            Route::get('/completed', [TeacherResultController::class, 'completed'])
                ->name('results.completed');

            Route::get('/evaluate/{id}', [TeacherResultController::class, 'evaluate'])
                ->name('results.evaluate');

            Route::post('/assign-marks', [TeacherResultController::class, 'assignMarks'])
                ->name('results.assign-marks');

            Route::post('/evaluate-attempt/save', [
                App\Http\Controllers\Teacher\TeacherResultController::class,
                'saveEvaluation'
            ])->name('save-evaluation');

            // 📋 List all submitted assignments for teacher
            Route::get('homework', [TeacherHomeworkController::class, 'index'])
                ->name('homework.index');

            // ✏️ Edit / Evaluate a submission
            Route::get('homework/{id}/edit', [TeacherHomeworkController::class, 'edit'])
                ->name('homework.edit');

            // ✅ Update evaluation (marks, remark, status)
            Route::patch('homework/{id}', [TeacherHomeworkController::class, 'update'])
                ->name('homework.update');

        });
    });

    // student panel routes
    Route::middleware('auth')->group(function () {

        Route::get('/user/dashboard', function () {
            return view('front-users.dashboard');
        })->name('user.dashboard');

        Route::get('/user-test-planner', function () {
            return view('front-users.test-planner');
        })->name('user-test-planner');

        // order routes
        Route::get('/user/orders', [FrontUserController::class, 'studentAllOrder'])->name('user.orders');
        Route::get('/user/order-details/{id}', [FrontUserController::class, 'orderDetails'])->name('user.order-details');
        Route::get('/user/generate-pdf/{id}', [FrontUserController::class, 'generatePDF'])->name('user.generate-pdf');
        Route::get('/user/print-invoice/{id}', [FrontUserController::class, 'printInvoice'])->name('user.print-invoice');
        // my course routes
        Route::get('/my-courses', [FrontUserController::class, 'myCourses'])->name('user.mycourses');
        Route::get('/my-course/{id}', [FrontUserController::class, 'courseDetail'])->name('course.detail');
        Route::post('/video/{id}/watch', [FrontUserController::class, 'watch']);
        Route::post('/student/homework/upload', [FrontUserController::class, 'uploadAssignment'])->name('student.homework.upload');

        // my study material routes
        Route::get('/my-study-material', [FrontUserController::class, 'StudyMaterial'])->name('user.study-material');
        Route::delete('/user/user-activity/delete/{id}', [FrontUserController::class, 'activityDelete'])->name('user-activity.destroy');
        // test series routes
        Route::get('/user/test-series', [FrontUserController::class, 'myTestSeries'])->name('user.test-series');
        Route::get('user/test-series-detail/{slug}', [FrontUserController::class, 'testSeriesDetail'])->name('user.test-series-detail');
        Route::get('/user/test-papers', [FrontUserController::class, 'listUserTestPapers'])->name('user.test-papers');

        Route::get('/user/setting', [FrontUserController::class, 'setting'])->name('user.setting');
        Route::post('user/register-student', [FrontUserController::class, 'studentRegister'])->name('register-student');
        Route::post('user/change-student-password', [FrontUserController::class, 'studentChangePassword'])->name('change-student-password');
        Route::get('user/process-order/{type}/{id}', [App\Http\Controllers\PaymentController::class, 'orderProcess'])->name('user.process-order');
        Route::any('order/status', [App\Http\Controllers\PaymentController::class, 'orderStatus'])->name('order.status');
        Route::get('student/wallet', [App\Http\Controllers\StudentWalletController::class, 'index'])->name('student.wallet');

    });

    // admin panel routes
    Route::middleware(['auth', 'isAdmin'])->group(function () {
        Route::get('admin-login', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

        //Content Management
        Route::prefix('content-management')->group(function () {
            //About Us
            Route::get('/about', [ContentManagementController::class, 'aboutUs'])->name('cm.about')->middleware('custom.permission:manage_about');
            Route::post('/about/store', [ContentManagementController::class, 'aboutStore'])->name('about.store')->middleware('custom.permission:manage_about_edit');

            // Privacy Policies
            Route::get('/privacy-policies', [ContentManagementController::class, 'privacyPolicies'])->name('cm.privacy.policy')->middleware('custom.permission:manage_privacy');
            Route::post('/privacy-policies/store', [ContentManagementController::class, 'privacyStore'])->name('privacy.policies.store')->middleware('custom.permission:manage_privacy_edit');

            // ---------------- OUR TEAM ----------------
            Route::get('/our-team', [ContentManagementController::class, 'ourTeam'])->name('cm.our.team')->middleware('custom.permission:manage_team');
            Route::post('/our-team/store', [ContentManagementController::class, 'ourTeamStore'])->name('cm.our.team.store')->middleware('custom.permission:manage_team_add');
            Route::get('/our-team/edit/{id}', [ContentManagementController::class, 'ourTeamEdit'])->name('cm.our.team.edit')->middleware('custom.permission:manage_team_edit');
            Route::post('/our-team/update', [ContentManagementController::class, 'ourTeamUpdate'])->name('cm.our.team.update')->middleware('custom.permission:manage_team_edit');
            Route::delete('/our-team/delete/{id}', [ContentManagementController::class, 'ourTeamDelete'])->name('cm.our.team.delete')->middleware('custom.permission:manage_team_delete');

            // Terms & Conditions
            Route::get('/term-and-condition', [ContentManagementController::class, 'termAndCondition'])->name('cm.term.condition')->middleware('custom.permission:manage_terms');
            Route::post('/term-and-conditions/store', [ContentManagementController::class, 'termStore'])->name('term.conditions.store')->middleware('custom.permission:manage_terms_edit');

            // Refund & Cancellation
            Route::get('/refund-and-cancellation', [ContentManagementController::class, 'refundCancellation'])->name('cm.refund.cancellation')->middleware('custom.permission:manage_refund');
            Route::post('/refund-and-cancellation/store', [ContentManagementController::class, 'refundCancellationStore'])->name('refund.cancellation.store')->middleware('custom.permission:manage_refund_edit');

            // Cookies Policies
            Route::get('/cookies-policies', [ContentManagementController::class, 'cookiesPolicies'])->name('cm.cookies.policies')->middleware('custom.permission:manage_cookies');
            Route::post('/cookies-policies/store', [ContentManagementController::class, 'cookiesPolicyStore'])->name('cookies.policy.store')->middleware('custom.permission:manage_cookies_edit');

            // Vision & Mission
            Route::get('/vision-and-mission', [ContentManagementController::class, 'visionMission'])->name('cm.vision.mission')->middleware('custom.permission:manage_vision');
            Route::post('/vision-and-mission/store', [ContentManagementController::class, 'visionStore'])->name('vision.store')->middleware('custom.permission:manage_vision_edit');

            // ---------------- CAREER ----------------
            Route::get('/career', [ContentManagementController::class, 'career'])->name('cm.career')->middleware('custom.permission:manage_career');
            Route::delete('/career/delete/{id}', [ContentManagementController::class, 'careerDelete'])->name('cm.career.delete')->middleware('custom.permission:manage_career_delete');
            Route::get('/career/bulk-delete', [ContentManagementController::class, 'careerBulkDelete'])->name('ajaxdata.bulk-delete')->middleware('custom.permission:manage_career_delete');

            // ---------------- BLOGS & ARTICLES ----------------
            Route::get('blog-and-articles', [ContentManagementController::class, 'blogArticles'])->name('cm.blog.articles')->middleware('custom.permission:manage_blog');
            Route::post('blog-and-articles/store', [ContentManagementController::class, 'blogStore'])->name('blog.store')->middleware('custom.permission:manage_blog_add');
            Route::get('blog-and-articles/edit/{id}', [ContentManagementController::class, 'blogEdit'])->name('blog.edit')->middleware('custom.permission:manage_blog_edit');
            Route::put('blog-and-articles/update/{id}', [ContentManagementController::class, 'blogUpdate'])->name('blog.update')->middleware('custom.permission:manage_blog_edit');
            Route::delete('blog-and-articles/delete/{id}', [ContentManagementController::class, 'blogDelete'])->name('blog.destroy')->middleware('custom.permission:manage_blog_delete');

            // ---------------- FAQ ----------------
            Route::get('faq', [ContentManagementController::class, 'faq'])->name('cm.faq')->middleware('custom.permission:manage_faq');
            Route::post('faq/store', [ContentManagementController::class, 'storeFaq'])->name('faq.store')->middleware('custom.permission:manage_faq_add');
            Route::get('faq/edit/{id}', [ContentManagementController::class, 'editFaq'])->name('faq.edit')->middleware('custom.permission:manage_faq_edit');
            Route::put('faq/update/{id}', [ContentManagementController::class, 'updateFaq'])->name('faq.update')->middleware('custom.permission:manage_faq_edit');
            Route::delete('faq/destroy/{id}', [ContentManagementController::class, 'destroyFaq'])->name('faq.destroy')->middleware('custom.permission:manage_faq_delete');
        });

        // examination commission route
        Route::prefix('manage-courses/examination-commission')->group(function () {
            Route::get('/', [ContentManagementController::class, 'examinationIndex'])->name('cm.exam')->middleware('custom.permission:manage_exam');
            Route::get('/create', [ContentManagementController::class, 'examinationCreate'])->name('cm.exam.create')->middleware('custom.permission:manage_exam_add');
            Route::get('/edit/{id}', [ContentManagementController::class, 'examinationEdit'])->name('cm.exam.edit')->middleware('custom.permission:manage_exam_edit');
            Route::post('/update', [ContentManagementController::class, 'examinationUpdate'])->name('cm.exam.update')->middleware('custom.permission:manage_exam_edit');
            Route::post('/create/store', [ContentManagementController::class, 'examinationStore'])->name('cm.exam.store')->middleware('custom.permission:manage_exam_add');
            Route::delete('/delete/{id}', [ContentManagementController::class, 'examinationDelete'])->name('cm.exam.destroy')->middleware('custom.permission:manage_exam_delete');
            Route::get('/bulk-delete', [ContentManagementController::class, 'examinationBulkDelete'])->name('cm.exam.bulk-delete')->middleware('custom.permission:manage_exam_delete');
        });

        // CATEGORY ROUTES
        Route::prefix('manage-courses/category')->group(function () {
            Route::get('/', [ContentManagementController::class, 'categoryIndex'])->name('cm.category')->middleware('custom.permission:manage_category');
            Route::get('/create', [ContentManagementController::class, 'categoryCreate'])->name('cm.category.create')->middleware('custom.permission:manage_category_add');
            Route::get('/edit/{id}', [ContentManagementController::class, 'categoryEdit'])->name('cm.category.edit')->middleware('custom.permission:manage_category_edit');
            Route::post('/update', [ContentManagementController::class, 'categoryUpdate'])->name('cm.category.update')->middleware('custom.permission:manage_category_edit');
            Route::post('/create/store', [ContentManagementController::class, 'categoryStore'])->name('cm.category.store')->middleware('custom.permission:manage_category_add');
            Route::delete('/delete/{id}', [ContentManagementController::class, 'categoryDelete'])->name('cm.category.delete')->middleware('custom.permission:manage_category_delete');
            Route::get('/bulk-delete', [ContentManagementController::class, 'categoryBulkDelete'])->name('cm.category.bulk-delete')->middleware('custom.permission:manage_category_delete');
        });

        // SUB CATEGORY ROUTES
        Route::prefix('manage-courses/sub-category')->group(function () {
            Route::get('/', [ContentManagementController::class, 'subCategoryIndex'])->name('cm.sub.category')->middleware('custom.permission:manage_subcategory');
            Route::get('/create', [ContentManagementController::class, 'subCategoryCreate'])->name('cm.sub-category.create')->middleware('custom.permission:manage_subcategory_add');
            Route::post('/create/store', [ContentManagementController::class, 'subCategoryStore'])->name('cm.sub-category.store')->middleware('custom.permission:manage_subcategory_add');
            Route::get('/show/{id}', [ContentManagementController::class, 'subCategoryShow'])->name('cm.sub.category.show');
            Route::get('/edit/{id}', [ContentManagementController::class, 'subCategoryEdit'])->name('cm.sub.category.edit')->middleware('custom.permission:manage_subcategory_edit');
            Route::post('/update/{id}', [ContentManagementController::class, 'subCategoryUpdate'])->name('cm.sub-category.update')->middleware('custom.permission:manage_subcategory_edit');
            Route::delete('/delete/{id}', [ContentManagementController::class, 'subCategoryDelete'])->name('cm.sub-category.delete')->middleware('custom.permission:manage_subcategory_delete');
            Route::get('/bulk-delete', [ContentManagementController::class, 'subCatBulkDelete'])->name('cm.sub-category.bulk-delete')->middleware('custom.permission:manage_subcategory_delete');
        });

        // SUBJECT ROUTES
        Route::prefix('manage-courses/subject')->group(function () {
            Route::get('/', [ContentManagementController::class, 'subjectIndex'])->name('cm.subject')->middleware('custom.permission:manage_subject');
            Route::get('/create', [ContentManagementController::class, 'subjectCreate'])->name('cm.subject.create')->middleware('custom.permission:manage_subject_add');
            Route::post('/store', [ContentManagementController::class, 'subjectStore'])->name('cm.subject.store')->middleware('custom.permission:manage_subject_add');
            Route::get('/edit/{id}', [ContentManagementController::class, 'subjectEdit'])->name('cm.subject.edit')->middleware('custom.permission:manage_subject_edit');
            Route::post('/update/{id}', [ContentManagementController::class, 'subjectUpdate'])->name('cm.subject.update')->middleware('custom.permission:manage_subject_edit');
            Route::delete('/delete/{id}', [ContentManagementController::class, 'subjectDelete'])->name('cm.subject.delete')->middleware('custom.permission:manage_subject_delete');
            Route::get('/bulk-delete', [ContentManagementController::class, 'subjectBulkDelete'])->name('cm.subject.bulk-delete')->middleware('custom.permission:manage_subject_delete');
        });

        // CHAPTER ROUTES
        Route::prefix('manage-courses/chapter')->group(function () {
            Route::get('/', [ContentManagementController::class, 'chapterIndex'])->name('cm.chapter')->middleware('custom.permission:manage_chapter');
            Route::get('/create', [ContentManagementController::class, 'chapterCreate'])->name('cm.chapter.create')->middleware('custom.permission:manage_chapter_add');
            Route::post('/store', [ContentManagementController::class, 'chapterStore'])->name('cm.chapter.store')->middleware('custom.permission:manage_chapter_add');
            Route::get('/edit/{id}', [ContentManagementController::class, 'chapterEdit'])->name('cm.chapter.edit')->middleware('custom.permission:manage_chapter_edit');
            Route::post('/update/{id}', [ContentManagementController::class, 'chapterUpdate'])->name('cm.chapter.update')->middleware('custom.permission:manage_chapter_edit');
            Route::delete('/delete/{id}', [ContentManagementController::class, 'chapterDelete'])->name('cm.chapter.delete')->middleware('custom.permission:manage_chapter_delete');
            Route::get('/bulk-delete', [ContentManagementController::class, 'chapterBulkDelete'])->name('cm.chapter.bulk-delete')->middleware('custom.permission:manage_chapter_delete');
        });

        // TOPIC ROUTES
        Route::prefix('manage-courses/topic')->group(function () {
            Route::get('/', [CourseTopicController::class, 'index'])->name('topic.index')->middleware('custom.permission:manage_topic');
            Route::get('/create', [CourseTopicController::class, 'create'])->name('topic.create')->middleware('custom.permission:manage_topic_add');
            Route::post('/', [CourseTopicController::class, 'store'])->name('topic.store')->middleware('custom.permission:manage_topic_add');
            Route::get('/{id}/edit', [CourseTopicController::class, 'edit'])->name('topic.edit')->middleware('custom.permission:manage_topic_edit');
            Route::put('/{id}', [CourseTopicController::class, 'update'])->name('topic.update')->middleware('custom.permission:manage_topic_edit');
            Route::delete('/{id}', [CourseTopicController::class, 'destroy'])->name('topic.destroy')->middleware('custom.permission:manage_topic_delete');
        });

        // ---------------- COURSES ----------------
        Route::prefix('manage-courses/course')->group(function () {
            Route::get('/', [ContentManagementController::class, 'courseIndex'])->name('courses.course.index')->middleware('custom.permission:manage_courses');
            Route::get('/create', [ContentManagementController::class, 'courseCreate'])->name('courses.course.create')->middleware('custom.permission:manage_courses_add');
            Route::post('/store', [ContentManagementController::class, 'courseStore'])->name('courses.course.store')->middleware('custom.permission:manage_courses_add');
            Route::get('/edit/{id}', [ContentManagementController::class, 'courseEdit'])->name('courses.course.edit')->middleware('custom.permission:manage_courses_edit');
            Route::post('/update/{id}', [ContentManagementController::class, 'courseUpdate'])->name('courses.course.update')->middleware('custom.permission:manage_courses_edit');
            Route::delete('/delete/{id}', [ContentManagementController::class, 'courseDelete'])->name('courses.course.delete')->middleware('custom.permission:manage_courses_delete');
            Route::get('/bulk-delete', [ContentManagementController::class, 'courseBulkDelete'])->name('courses.course.bulk-delete')->middleware('custom.permission:manage_courses_delete');
            Route::get('/{course}', [ContentManagementController::class, 'courseShow'])->name('courses.course.show')->middleware('custom.permission:manage_courses');
        });

        // ---------------- ENQUIRIES & CALL ----------------

        // Direct Enquiries
        Route::get('enquiries-and-call/direct-enquiries', [ContentManagementController::class, 'directEnquiriesIndex'])->name('enquiries.direct.call')->middleware('custom.permission:manage_direct_enquiries');
        Route::delete('enquiries-and-call/direct-enquiries/delete/{id}', [ContentManagementController::class, 'directEnquiriesDelete'])->name('enquiries.direct.delete')->middleware('custom.permission:manage_direct_enquiries_delete');
        // Contact Us Enquiries
        Route::get('enquiries-and-call/contact-us', [ContentManagementController::class, 'contactUsIndex'])->name('enquiries.contact.us')->middleware('custom.permission:manage_contact_inquiries');
        Route::delete('enquiries-and-call/contact-us/delete/{id}', [ContentManagementController::class, 'contactUsDelete'])->name('enquiries.contact.delete')->middleware('custom.permission:manage_contact_inquiries_delete');
        Route::get('enquiries-and-call/contact-us/bulk-delete', [ContentManagementController::class, 'contactUsBulkDelete'])->name('enquiries.contact.bulk-delete')->middleware('custom.permission:manage_contact_inquiries_delete');
        // Call Back Request
        Route::get('enquiries-and-call/call-back-request', [ContentManagementController::class, 'callRequestIndex'])->name('enquiries.call.request')->middleware('custom.permission:manage_call_requests');
        Route::delete('enquiries-and-call/call-back-request/delete/{id}', [ContentManagementController::class, 'callRequestDelete'])->name('enquiries.call.delete')->middleware('custom.permission:manage_call_requests_delete');
        // Feedback
        Route::get('feedback', [ContentManagementController::class, 'feedIndex'])->name('feed.index')->middleware('custom.permission:manage_feedback');
        Route::delete('feedback-testimonial/delete/{id}', [ContentManagementController::class, 'feedDelete'])->name('feed.delete')->middleware('custom.permission:manage_feedback_delete');
        // Testimonials
        Route::get('testimonials', [ContentManagementController::class, 'testimonialsIndex'])->name('testimonials.index')->middleware('custom.permission:manage_testimonials');
        Route::get('testimonial/view/{id}', [ContentManagementController::class, 'testimonialView'])->name('testimonial.view')->middleware('custom.permission:manage_testimonials');
        Route::patch('testimonial/{id}/approveStatus', [ContentManagementController::class, 'updateapproveStatus'])->name('testimonial.approveStatus')->middleware('custom.permission:manage_testimonials_status');
        Route::patch('/feed/{id}/updateStatus', [ContentManagementController::class, 'updateFeedStatus'])->name('feed.updateStatus')->middleware('custom.permission:manage_testimonials_status');


        // ---------------- STUDY MATERIAL ----------------
        Route::prefix('study-material')->group(function () {
            Route::get('/', [ContentManagementController::class, 'studyMaterialIndex'])->name('study.material.index')->middleware('custom.permission:manage_study_material');
            Route::get('/create', [ContentManagementController::class, 'studyMaterialCreate'])->name('study.material.create')->middleware('custom.permission:manage_study_material_add');
            Route::post('/store', [ContentManagementController::class, 'studyMaterialStore'])->name('study.material.store')->middleware('custom.permission:manage_study_material_add');
            Route::get('/edit/{id}', [ContentManagementController::class, 'studyMaterialEdit'])->name('study.material.edit')->middleware('custom.permission:manage_study_material_edit');
            Route::post('/update/{id}', [ContentManagementController::class, 'studyMaterialUpdate'])->name('study.material.update')->middleware('custom.permission:manage_study_material_edit');
            Route::delete('/delete/{id}', [ContentManagementController::class, 'studyMaterialDelete'])->name('study.material.delete')->middleware('custom.permission:manage_study_material_delete');
            Route::get('/bulk-delete', [ContentManagementController::class, 'studyMaterialBulkDelete'])->name('study.material.bulk-delete')->middleware('custom.permission:manage_study_material_delete');
            Route::get('/show/{id}', [ContentManagementController::class, 'studyMaterialShow'])->name('study.material.show');
            Route::get('/{id}/download', [ContentManagementController::class, 'downloadPdf'])->name('study.material.download');
        });

        // Daily Booster
        Route::prefix('daily-booster')->name('daily.boost.')->group(function () {
            Route::get('/', [ContentManagementController::class, 'dailyBoostIndex'])->name('index')->middleware('custom.permission:manage_daily_booster');
            Route::get('/show/{id}', [ContentManagementController::class, 'dailyBoostShow'])->name('show')->middleware('custom.permission:manage_daily_booster');
            Route::get('/create', [ContentManagementController::class, 'dailyBoostCreate'])->name('create')->middleware('custom.permission:manage_daily_booster_add');
            Route::post('/store', [ContentManagementController::class, 'dailyBoostStore'])->name('store')->middleware('custom.permission:manage_daily_booster_add');
            Route::get('/edit/{id}', [ContentManagementController::class, 'dailyBoostEdit'])->name('edit')->middleware('custom.permission:manage_daily_booster_edit');
            Route::post('/update/{id}', [ContentManagementController::class, 'dailyBoostUpdate'])->name('update')->middleware('custom.permission:manage_daily_booster_edit');
            Route::delete('/delete/{id}', [ContentManagementController::class, 'dailyBoostDelete'])->name('delete')->middleware('custom.permission:manage_daily_booster_delete');
        });
        // Bulk delete
        Route::get('booster/bulk-delete', [ContentManagementController::class, 'boosterBulkDelete'])->name('booster.bulk-delete')->middleware('custom.permission:manage_daily_booster_delete');

        // Test Planner
        Route::prefix('test-planner')->name('test.planner.')->group(function () {
            Route::get('/', [ContentManagementController::class, 'testPlannerIndex'])->name('index')->middleware('custom.permission:manage_test_planner');
            Route::get('/show/{id}', [ContentManagementController::class, 'testPlannerShow'])->name('show')->middleware('custom.permission:manage_test_planner');
            Route::get('/create', [ContentManagementController::class, 'testPlannerCreate'])->name('create')->middleware('custom.permission:manage_test_planner_add');
            Route::post('/store', [ContentManagementController::class, 'testPlannerStore'])->name('store')->middleware('custom.permission:manage_test_planner_add');
            Route::get('/edit/{id}', [ContentManagementController::class, 'testPlannerEdit'])->name('edit')->middleware('custom.permission:manage_test_planner_edit');
            Route::post('/update/{id}', [ContentManagementController::class, 'testPlannerUpdate'])->name('update')->middleware('custom.permission:manage_test_planner_edit');
            Route::delete('/delete/{id}', [ContentManagementController::class, 'testPlannerDelete'])->name('delete')->middleware('custom.permission:manage_test_planner_delete');
            Route::get('/bulk-delete', [ContentManagementController::class, 'testPlannerBulkDelete'])->name('bulk-delete')->middleware('custom.permission:manage_test_planner_delete');
        });

        // CURRENT AFFAIRS - TOPIC
        Route::prefix('current-affairs/topic')->name('current.affairs.topic.')->group(function () {
            Route::get('/', [ContentManagementController::class, 'topicIndex'])->name('index')->middleware('custom.permission:manage_ca_categories');
            Route::post('/store', [ContentManagementController::class, 'topicStore'])->name('store')->middleware('custom.permission:manage_ca_categories_add');
            Route::put('/update/{id}', [ContentManagementController::class, 'topicUpdate'])->name('update')->middleware('custom.permission:manage_ca_categories_edit');
            Route::delete('/delete/{id}', [ContentManagementController::class, 'topicDelete'])->name('delete')->middleware('custom.permission:manage_ca_categories_delete');
        });

        // CURRENT AFFAIRS
        Route::prefix('current-affairs')->name('current.affairs.')->group(function () {
            Route::get('/', [ContentManagementController::class, 'currentAffairIndex'])->name('index')->middleware('custom.permission:manage_ca');
            Route::get('/create', [ContentManagementController::class, 'currentAffairCreate'])->name('create')->middleware('custom.permission:manage_ca_add');
            Route::post('/store', [ContentManagementController::class, 'currentAffairStore'])->name('store')->middleware('custom.permission:manage_ca_add');
            Route::get('/edit/{id}', [ContentManagementController::class, 'currentAffairEdit'])->name('edit')->middleware('custom.permission:manage_ca_edit');
            Route::put('/update/{id}', [ContentManagementController::class, 'currentAffairUpdate'])->name('update')->middleware('custom.permission:manage_ca_edit');
            Route::get('/show/{id}', [ContentManagementController::class, 'currentAffairShow'])->name('show')->middleware('custom.permission:manage_ca');
            Route::delete('/delete/{id}', [ContentManagementController::class, 'currentAffairDelete'])->name('delete')->middleware('custom.permission:manage_ca_delete');
        });

        // TEST SERIES PACKAGE ROUTES
        Route::prefix('test-series')->group(function () {
            Route::get('/', [ContentManagementController::class, 'testSeriesIndex'])->name('test.series.index')->middleware('custom.permission:manage_test_series_package');
            Route::get('/filter', [ContentManagementController::class, 'testSeriesFilter'])->name('test.series.filter')->middleware('custom.permission:manage_test_series_package');
            Route::get('/create', [ContentManagementController::class, 'testSeriesCreate'])->name('test.series.create')->middleware('custom.permission:manage_test_series_package_add');
            Route::post('/store', [ContentManagementController::class, 'testSeriesStore'])->name('test.series.store')->middleware('custom.permission:manage_test_series_package_add');
            Route::get('/edit/{id}', [ContentManagementController::class, 'testSeriesEdit'])->name('test.series.edit')->middleware('custom.permission:manage_test_series_package_edit');
            Route::post('/update/{id}', [ContentManagementController::class, 'testSeriesUpdate'])->name('test.series.update')->middleware('custom.permission:manage_test_series_package_edit');
            Route::delete('/delete/{id}', [ContentManagementController::class, 'testSeriesDelete'])->name('test.series.delete')->middleware('custom.permission:manage_test_series_package_delete');
            Route::get('/view/{id}', [ContentManagementController::class, 'testSeriesView'])->name('test.series.view')->middleware('custom.permission:manage_test_series_package');
            // ---------------- QUESTION ROUTES ----------------
            Route::get('/question', [ContentManagementController::class, 'testSeriesQuestion'])->name('test.series.question');
            Route::get('/question/create', [ContentManagementController::class, 'testSeriesQuestionCreate'])->name('test.series.question.create');
        });

        // ---------------- TEST RESULTS ----------------
        Route::prefix('results')->group(function () {
            Route::get('/', [TestResultController::class, 'results'])->name('admin.results.all')->middleware('custom.permission:manage_test_attempts');
            Route::get('/evaluate-attempt/{id}', [TestResultController::class, 'showEvaluation'])->name('admin.evaluate-attempt')->middleware('custom.permission:manage_test_attempts_edit');
            Route::post('/evaluate-attempt/save', [TestResultController::class, 'saveEvaluation'])->name('admin.save-evaluation')->middleware('custom.permission:manage_test_attempts_edit');
            Route::post('/attempt/assign-teacher', [TestResultController::class, 'assignTeacherSave'])->name('admin.assign-teacher-save')->middleware('custom.permission:manage_test_attempts_edit');
            Route::post('/assign-marks', [TestResultController::class, 'assignMarks'])->name('admin.assign-marks')->middleware('custom.permission:manage_test_attempts_edit');
            Route::delete('/attempt/{id}', [TestResultController::class, 'deleteAttempt'])->name('admin.delete-attempt')->middleware('custom.permission:manage_test_attempts_delete');
        });

        // Upcoming Exams
        Route::prefix('upcoming-exams')->name('upcoming.exam.')->group(function () {
            Route::get('/', [ContentManagementController::class, 'upcomingExamIndex'])->name('index')->middleware('custom.permission:manage_upcoming_exams');
            Route::get('/create', [ContentManagementController::class, 'upcomingExamCreate'])->name('create')->middleware('custom.permission:manage_upcoming_exams_add');
            Route::get('/show/{id}', [ContentManagementController::class, 'upcomingExamShow'])->name('show')->middleware('custom.permission:manage_upcoming_exams');
            Route::get('/edit/{id}', [ContentManagementController::class, 'upcomingExamEdit'])->name('edit')->middleware('custom.permission:manage_upcoming_exams_edit');
            Route::post('/store', [ContentManagementController::class, 'upcomingExamStore'])->name('store')->middleware('custom.permission:manage_upcoming_exams_add');
            Route::post('/update/{id}', [ContentManagementController::class, 'upcomingExamUpdate'])->name('update')->middleware('custom.permission:manage_upcoming_exams_edit');
            Route::delete('/delete/{id}', [ContentManagementController::class, 'upcomingExamDelete'])->name('delete')->middleware('custom.permission:manage_upcoming_exams_delete');
            Route::delete('/bulk-delete', [ContentManagementController::class, 'upcomingExamBulkDelete'])->name('bulk-delete')->middleware('custom.permission:manage_upcoming_exams_delete');
        });

        // QUESTION BANK ROUTES
        Route::prefix('question-bank')->group(function () {
            Route::get('/', [ContentManagementController::class, 'questionBankIndex'])->name('question.bank.index')->middleware('custom.permission:manage_question_bank');
            Route::get('/rejected', [ContentManagementController::class, 'rejectQuestionBankIndex'])->name('question.bank.rejected')->middleware('custom.permission:manage_question_bank');
            Route::get('/pending', [ContentManagementController::class, 'pendingQuestionBankIndex'])->name('question.bank.pending')->middleware('custom.permission:manage_question_bank');
            Route::get('/create', [ContentManagementController::class, 'questionBankCreate'])->name('question.bank.create')->middleware('custom.permission:manage_question_bank_add');
            Route::post('/store', [ContentManagementController::class, 'questionBankStore'])->name('question.bank.store')->middleware('custom.permission:manage_question_bank_add');
            Route::get('/bulk-upload', [ContentManagementController::class, 'questionBankBulkUpload'])->name('question.bank.bulk-upload')->middleware('custom.permission:manage_question_bank_add');
            Route::post('/import-questions', [ContentManagementController::class, 'ImportQuestions'])->name('question.bank.import-questions')->middleware('custom.permission:manage_question_bank_add');
            Route::get('/edit/{id}', [ContentManagementController::class, 'questionBankEdit'])->name('question.bank.edit')->middleware('custom.permission:manage_question_bank_edit');
            Route::post('/update/{id}', [ContentManagementController::class, 'questionBankUpdate'])->name('question.bank.update')->middleware('custom.permission:manage_question_bank_edit');
            Route::get('/view/{id}', [ContentManagementController::class, 'questionBankView'])->name('question.bank.view')->middleware('custom.permission:manage_question_bank');
            Route::post('/update-status/{id}', [ContentManagementController::class, 'updateStatus'])->name('question.bank.update-status')->middleware('custom.permission:manage_question_bank_status');
            Route::delete('/delete/{id}', [ContentManagementController::class, 'questionBankDelete'])->name('question.bank.delete')->middleware('custom.permission:manage_question_bank_delete');
        });

        // ---------------- TEACHER MANAGEMENT ----------------
        Route::prefix('manage-teachers')->name('manage-teachers.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\TeacherController::class, 'index'])->name('index')->middleware('custom.permission:manage_teachers');
            Route::get('/create', [App\Http\Controllers\Admin\TeacherController::class, 'create'])->name('create')->middleware('custom.permission:manage_teachers_add');
            Route::post('/store', [App\Http\Controllers\Admin\TeacherController::class, 'store'])->name('store')->middleware('custom.permission:manage_teachers_add');
            Route::get('/{teacher}', [App\Http\Controllers\Admin\TeacherController::class, 'show'])->name('show')->middleware('custom.permission:manage_teachers');
            Route::post('/{teacher}/change-password', [App\Http\Controllers\Admin\TeacherController::class, 'changePassword'])->name('change-password')->middleware('custom.permission:manage_teachers_edit');
            Route::get('/{teacher}/edit', [App\Http\Controllers\Admin\TeacherController::class, 'edit'])->name('edit')->middleware('custom.permission:manage_teachers_edit');
            Route::put('/{teacher}', [App\Http\Controllers\Admin\TeacherController::class, 'update'])->name('update')->middleware('custom.permission:manage_teachers_edit');
            Route::delete('/delete/{teacher}', [App\Http\Controllers\Admin\TeacherController::class, 'destroy'])->name('delete')->middleware('custom.permission:manage_teachers_delete');
            Route::post('/bulk-delete', [App\Http\Controllers\Admin\TeacherController::class, 'bulkDelete'])->name('bulk-delete')->middleware('custom.permission:manage_teachers_delete');
        });

        // ---------------- TEACHER WALLET ----------------
        Route::get('teacher-wallet', [TeacherWalletController::class, 'index'])->name('teacher.wallet.index')->middleware('custom.permission:manage_teacher_wallet');
        // ---------------- TEACHER TRANSACTIONS ----------------
        Route::get('teacher-transactions', [TeacherWalletController::class, 'transactions'])->name('teacher.transactions.index')->middleware('custom.permission:manage_teacher_transactions');
        // ---------------- WITHDRAWAL REQUESTS ----------------
        Route::get('withdrawal-requests', [TeacherWalletController::class, 'withdrawalRequests'])->name('withdrawal.requests.index')->middleware('custom.permission:manage_withdrawal_requests');
        // UPDATE STATUS (Approve/Reject withdrawal)
        Route::post('teacher-withdrawal/{withdrawal}/update', [TeacherWalletController::class, 'updateWithdrawalStatus'])->name('teacher.withdrawal.update')->middleware('custom.permission:manage_withdrawal_requests_status');

        // TEST PAPER ROUTES
        Route::prefix('test-paper')->group(function () {
            Route::get('/', [TestController::class, 'TestBankIndex'])->name('test.bank.index')->middleware('custom.permission:manage_test_bank');
            Route::get('/filter', [TestController::class, 'filter'])->name('test.paper.filter');
            Route::get('/create', [TestController::class, 'testPaperCreate'])->name('test.paper.create')->middleware('custom.permission:manage_test_bank_add');
            Route::post('/store', [TestController::class, 'store'])->name('manage-test')->middleware('custom.permission:manage_test_bank_add');
            Route::get('/view/{id}', [TestController::class, 'view'])->name('test.paper.view')->middleware('custom.permission:manage_test_bank');
            Route::get('/edit/{id}', [TestController::class, 'edit'])->name('test.paper.edit')->middleware('custom.permission:manage_test_bank_edit');
            Route::post('/update/{id}', [TestController::class, 'update'])->name('test.paper.update')->middleware('custom.permission:manage_test_bank_edit');
            Route::delete('/delete/{id}', [TestController::class, 'destroy'])->name('test.paper.delete')->middleware('custom.permission:manage_test_bank_delete');
            Route::get('/{id}/download', [TestController::class, 'download'])->name('test-papers.download')->middleware('custom.permission:manage_test_bank');
        });

        Route::post('/generate-test-paper-by-selections', 'TestController@generatetestpaperbyselections')->name('generate-test-paper-by-selections');
        Route::post('/generate-test-questions-by-selections', 'TestController@generatetestquestionsbyselections')->name('generate-test-questions-by-selections');
        Route::get('test-papers/{id}/download', [TestController::class, 'download'])->name('test-papers.download');
        Route::get('fetch-exam-category-by-commission/{commission}', 'TestController@fetchExamCategoryByCommission')->name('fetch-exam-category-by-commission');
        Route::get('fetch-sub-category-by-exam-category/{exam_category}', 'TestController@fetchSubCategoryByExamCategory')->name('fetch-sub-category-by-exam-category');
        Route::get('fetch-subject-by-subcategory/{sub_category}', 'TestController@fetchSubjectBySubCategory')->name('fetch-subject-by-subcategory');
        Route::post('preview-test', 'TestController@previewTest')->name('preview-test');
        Route::get('fetch-subject/{commission}/{category?}/{sub_category?}', 'TestController@fetchSubject')->name('fetch-subject');
        Route::get('fetch-chapter-by-subject/{subject}', 'TestController@fetchchapterbySubject')->name('fetch-chapter-by-subject');
        Route::get('fetch-topic-by-chapter/{subject}', 'TestController@fetchtopicbychapter')->name('fetch-topic-by-chapter');
        Route::post('get-all-subjects', 'TestController@allSubject')->name('get-all-subjects');
        Route::post('get-all-subjects-multi', 'TestController@allSubjectMulti')->name('get-all-subjects-multi');

        // SYLLABUS MANAGEMENT
        Route::prefix('syllabus')->name('syllabus.')->group(function () {
            Route::get('/', 'SyllabusController@index')->name('index')->middleware('custom.permission:manage_syllabus');
            Route::get('/create', 'SyllabusController@create')->name('create')->middleware('custom.permission:manage_syllabus_add');
            Route::post('/', 'SyllabusController@store')->name('store')->middleware('custom.permission:manage_syllabus_add');
            Route::get('/{syllabus}/edit', 'SyllabusController@edit')->name('edit')->middleware('custom.permission:manage_syllabus_edit');
            Route::put('/{syllabus}', 'SyllabusController@update')->name('update')->middleware('custom.permission:manage_syllabus_edit');
            Route::get('/{syllabus}', 'SyllabusController@show')->name('show')->middleware('custom.permission:manage_syllabus');
            Route::delete('/{syllabus}', 'SyllabusController@destroy')->name('destroy')->middleware('custom.permission:manage_syllabus_delete');
        });

        // PYQ MANAGEMENT
        Route::prefix('pyq')->name('pyq.')->group(function () {
            Route::get('/filter', [PYQController::class, 'filter'])->name('filter')->middleware('custom.permission:manage_pyq');
            Route::get('/', [PYQController::class, 'index'])->name('index')->middleware('custom.permission:manage_pyq');
        });

        // PYQ CONTENT MANAGEMENT
        Route::prefix('pyq-content')->name('pyq.content.')->group(function () {
            Route::get('/', [ContentManagementController::class, 'pyqContentIndex'])->name('index')->middleware('custom.permission:manage_pyq_content');
            Route::get('/create', [ContentManagementController::class, 'pyqContentCreate'])->name('create')->middleware('custom.permission:manage_pyq_content_add');
            Route::post('/store', [ContentManagementController::class, 'pyqContentStore'])->name('store')->middleware('custom.permission:manage_pyq_content_add');
            Route::get('/show/{id}', [ContentManagementController::class, 'pyqContentShow'])->name('show')->middleware('custom.permission:manage_pyq_content');
            Route::get('/edit/{id}', [ContentManagementController::class, 'pyqContentEdit'])->name('edit')->middleware('custom.permission:manage_pyq_content_edit');
            Route::post('/update/{id}', [ContentManagementController::class, 'pyqContentUpdate'])->name('update')->middleware('custom.permission:manage_pyq_content_edit');
            Route::delete('/delete/{id}', [ContentManagementController::class, 'pyqContentDelete'])->name('delete')->middleware('custom.permission:manage_pyq_content_delete');
        });

        Route::resource('study-material/category', 'StudyMaterialCategoryController');
        Route::resource('study-material/main-topic', 'MainTopicController');
        Route::get('study-material/main-topic/fetch-topic-by-category/{category}', 'MainTopicController@fetchCategory')->name('fetch-topic-by-category');

        // VIDEO / LIVE CLASS MANAGEMENT
        Route::prefix('video')->name('video.')->group(function () {
            Route::get('/', [VideoController::class, 'index'])->name('index')->middleware('custom.permission:manage_videos');
            Route::get('/create', [VideoController::class, 'create'])->name('create')->middleware('custom.permission:manage_videos_add');
            Route::post('/store', [VideoController::class, 'store'])->name('store')->middleware('custom.permission:manage_videos_add');
            Route::get('/{video}/edit', [VideoController::class, 'edit'])->name('edit')->middleware('custom.permission:manage_videos_edit');
            Route::post('/{video}/update', [VideoController::class, 'update'])->name('update')->middleware('custom.permission:manage_videos_edit');
            Route::delete('/{video}/delete', [VideoController::class, 'destroy'])->name('destroy')->middleware('custom.permission:manage_videos_delete');
            Route::get('/{video}', [VideoController::class, 'show'])->name('show')->middleware('custom.permission:manage_videos');
        });

        Route::get('homework', [AdminHomeworkController::class, 'index'])
            ->name('homework.index');

        Route::get('homework/{id}/edit', [AdminHomeworkController::class, 'edit'])
            ->name('homework.edit');

        Route::patch('homework/{id}', [AdminHomeworkController::class, 'update'])
            ->name('homework.update');

        Route::get('chapter-video/{id}', 'VideoController@chapter_topic')->name('chapter-video');
        Route::get('course-video/{id}', 'VideoController@course_topic')->name('course-video');
        Route::get('chapter-course/{id}', 'VideoController@chapter_course')->name('chapter-course');
        Route::get('live-class-schedule', 'VideoController@live_class_schedule')->name('live-class-schedule');
        Route::get('fetch-category/{type}', 'VideoController@fetchcategory')->name('fetch-category');
        Route::get('fetch-course/{id}', 'VideoController@fetchcourse')->name('fetch-course');
        Route::get('fetch-chapter/{id}', 'VideoController@fetchchapter')->name('fetch-chapter');
        Route::get('fetch-teachers-by-filters', 'VideoController@fetchTeachersByFilters');

        // ORDER MANAGEMENT
        Route::prefix('order')->name('order.')->group(function () {
            Route::get('/student-all-orders', [App\Http\Controllers\OrderController::class, 'allOrder'])->name('student-all-orders')->middleware('custom.permission:manage_all_orders');
            Route::get('/test-series-orders', [App\Http\Controllers\OrderController::class, 'allTestSeriesOrder'])->name('test-series-orders')->middleware('custom.permission:manage_test_series_orders');
            Route::get('/course-orders', [App\Http\Controllers\OrderController::class, 'allCourseOrder'])->name('course-orders')->middleware('custom.permission:manage_course_orders');
            Route::get('/study-material-orders', [App\Http\Controllers\OrderController::class, 'allStudyMaterialOrder'])->name('study-material-orders')->middleware('custom.permission:manage_study_material_orders');
            Route::get('/student-transactions-list', [App\Http\Controllers\OrderController::class, 'allTransactions'])->name('student-transactions-list')->middleware('custom.permission:manage_transactions');
            Route::get('/student-failed-transactions', [App\Http\Controllers\OrderController::class, 'allFailedTransactions'])->name('student-failed-transactions')->middleware('custom.permission:manage_failed_payments');
        });


        // STUDENTS ROUTES
        Route::get('students/registered-student-list', [StudentController::class, 'RegisterStudentList'])->name('students.registered-student-list')->middleware('custom.permission:manage_students');
        Route::get('students/view-all-orders/{id}', [StudentController::class, 'ViewAllOrder'])->name('students.view-all-orders')->middleware('custom.permission:manage_students');
        Route::get('students/student-order-detail/{id}', [OrderController::class, 'studentOrderDetails'])->name('students.student-order-detail')->middleware('custom.permission:manage_students');
        Route::get('students/change-status', [StudentController::class, 'changeStatus'])->name('students.change-status')->middleware('custom.permission:manage_students_status');
        Route::get('students/change-password/{id}', [StudentController::class, 'studentChangePassword'])->name('students.change-password')->middleware('custom.permission:students.view-all-orders');
        Route::post('students/update-password/{id}', [StudentController::class, 'studentUpdatePassword'])->name('students.update-password')->middleware('custom.permission:manage_students_edit');

        // STUDENT PROFILE DETAIL
        Route::get('students/student-profile-detail/{id}', [StudentController::class, 'studentProfile'])->name('students.student-profile-detail')->middleware('custom.permission:manage_students');
        // TEST SERIES SUMMARY
        Route::get('students/student-test-series-summary', [StudentController::class, 'studentTestSummery'])->name('students.student-test-series-summary')->middleware('custom.permission:manage_student_test_summary');
        // COURSE SUMMARY
        Route::get('students/student-course-summary', [StudentController::class, 'studentCourseSummery'])->name('students.student-course-summary')->middleware('custom.permission:manage_student_course_summary');
        // ALL VIDEOS LIST (STATIC VIEW)
        Route::get('students/student-videos-list', function () {
            return view('students.student-videos-list');
        })->name('students.student-videos-list')
            ->middleware('custom.permission:manage_student_videos');
        // TEST RESULT DETAIL (STATIC VIEW)
        Route::get('students/student-test-result-detail', function () {
            return view('students.student-test-result-detail');
        })->name('students.student-test-result-detail')
            ->middleware('custom.permission:manage_student_tests');
        // WATCHED VIDEO LIST (STATIC VIEW)
        Route::get('students/student-watched-video-list', function () {
            return view('students.student-watched-video-list');
        })->name('students.student-watched-video-list')
            ->middleware('custom.permission:manage_student_videos');



        // Batches & Programme
        Route::prefix('batches-and-programme')->name('batches-programme.')->group(function () {
            Route::get('/', [ContentManagementController::class, 'batchesProgrammeIndex'])->name('index')->middleware('custom.permission:manage_batches');
            Route::get('/create', [ContentManagementController::class, 'batchesProgrammeCreate'])->name('create')->middleware('custom.permission:manage_batches_add');
            Route::post('/store', [ContentManagementController::class, 'batchesProgrammeStore'])->name('store')->middleware('custom.permission:manage_batches_add');
            Route::get('/show/{id}', [ContentManagementController::class, 'batchesProgrammeShow'])->name('show')->middleware('custom.permission:manage_batches');
            Route::get('/{id}/edit', [ContentManagementController::class, 'batchesProgrammeEdit'])->name('edit')->middleware('custom.permission:manage_batches_edit');
            Route::put('/{id}', [ContentManagementController::class, 'batchesProgrammeUpdate'])->name('update')->middleware('custom.permission:manage_batches_edit');
            Route::delete('/delete/{id}', [ContentManagementController::class, 'batchesProgrammeDelete'])->name('delete')->middleware('custom.permission:manage_batches_delete');
        });

        /** ------------------------
         *  ROLE GROUP MANAGEMENT
         * ------------------------*/
        Route::prefix('role-groups')->group(function () {
            Route::get('/', [RoleGroupController::class, 'index'])->name('role-groups.index')->middleware('custom.permission:manage_role_groups');
            Route::get('/create', [RoleGroupController::class, 'create'])->name('role-groups.create')->middleware('custom.permission:manage_role_groups_add');
            Route::post('/store', [RoleGroupController::class, 'store'])->name('role-groups.store')->middleware('custom.permission:manage_role_groups_add');
            Route::get('/{id}/edit', [RoleGroupController::class, 'edit'])->name('role-groups.edit')->middleware('custom.permission:manage_role_groups_edit');
            Route::post('/{id}/update', [RoleGroupController::class, 'update'])->name('role-groups.update')->middleware('custom.permission:manage_role_groups_edit');
            Route::delete('/{id}', [RoleGroupController::class, 'destroy'])->name('role-groups.destroy')->middleware('custom.permission:manage_role_groups_delete');
        });

        /** ------------------------
         *  SUB ADMIN MANAGEMENT
         * ------------------------*/
        Route::prefix('sub-admins')->group(function () {
            Route::get('/', [SubAdminController::class, 'index'])->name('sub-admins.index')->middleware('custom.permission:manage_sub_admins');
            Route::get('/create', [SubAdminController::class, 'create'])->name('sub-admins.create')->middleware('custom.permission:manage_sub_admins_add');
            Route::post('/store', [SubAdminController::class, 'store'])->name('sub-admins.store')->middleware('custom.permission:manage_sub_admins_add');
            Route::get('/{id}/edit', [SubAdminController::class, 'edit'])->name('sub-admins.edit')->middleware('custom.permission:manage_sub_admins_edit');
            Route::post('/{id}/update', [SubAdminController::class, 'update'])->name('sub-admins.update')->middleware('custom.permission:manage_sub_admins_edit');
            Route::delete('/{id}', [SubAdminController::class, 'destroy'])->name('sub-admins.destroy')->middleware('custom.permission:manage_sub_admins_delete');
            Route::get('/{id}/password', [SubAdminController::class, 'editPassword'])
                ->name('sub-admins.password.edit')->middleware('custom.permission:manage_sub_admins_edit');
            Route::post('/{id}/password', [SubAdminController::class, 'updatePassword'])
                ->name('sub-admins.password.update')->middleware('custom.permission:manage_sub_admins_edit');

        });

        // student wallet route
        Route::prefix('admin/settings/user-wallet')->group(function () {
            Route::get('/', [ContentManagementController::class, 'userWalletIndex'])->name('settings.user-wallet.index')->middleware('custom.permission:manage_user_wallet');
            Route::post('/store', [ContentManagementController::class, 'userWalletStore'])->name('settings.user-wallet.store')->middleware('custom.permission:manage_user_wallet_add');
        });

        // percentage system route
        Route::prefix('percentage-system')->group(function () {
            Route::get('/', [PercentageSystemController::class, 'index'])->name('percentage.system.index')->middleware('custom.permission:manage_percentage');
            Route::get('/create', [PercentageSystemController::class, 'create'])->name('percentage.system.create')->middleware('custom.permission:manage_percentage_add');
            Route::post('/store', [PercentageSystemController::class, 'store'])->name('percentage.system.store')->middleware('custom.permission:manage_percentage_add');
            Route::get('/edit/{id}', [PercentageSystemController::class, 'edit'])->name('percentage.system.edit')->middleware('custom.permission:manage_percentage_edit');
            Route::post('/update/{id}', [PercentageSystemController::class, 'update'])->name('percentage.system.update')->middleware('custom.permission:manage_percentage_edit');
            Route::delete('/delete/{id}', [PercentageSystemController::class, 'destroy'])->name('percentage.system.delete')->middleware('custom.permission:manage_percentage_delete');
        });

        //User Routes
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [App\Http\Controllers\UsersController::class, 'index'])->name('users.index')->middleware('custom.permission:manage_users');
            Route::get('/create', 'UsersController@create')->name('users.create')->middleware('custom.permission:manage_users_add');
            Route::post('/store', 'UsersController@store')->name('users.store')->middleware('custom.permission:manage_users_add');
            Route::get('/{user}/show', 'UsersController@show')->name('users.show')->middleware('custom.permission:manage_users');
            Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit')->middleware('custom.permission:manage_users_edit');
            Route::patch('/{user}/update', 'UsersController@update')->name('users.update')->middleware('custom.permission:manage_users_edit');
            Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy')->middleware('custom.permission:manage_users_delete');
        });


        // SEO Routes
        Route::group(['prefix' => 'seo'], function () {
            Route::get('/index', [ContentManagementController::class, 'seoIndex'])->name('seo.index')->middleware('custom.permission:manage_seo');
            Route::get('/create', [ContentManagementController::class, 'seoCreate'])->name('seo.create')->middleware('custom.permission:manage_seo_add');
            Route::post('/store', [ContentManagementController::class, 'seoStore'])->name('seo.store')->middleware('custom.permission:manage_seo_add');
        });

        /************************Page Url for design End***************/

        Route::prefix('admin/settings')->group(function () {

            /* ---------------- HEADER SETTINGS ---------------- */
            Route::get('/header-settings', [ContentManagementController::class, 'headerSettingsIndex'])->name('settings.header.index')->middleware('custom.permission:manage_header');
            Route::post('/header-settings/store', [ContentManagementController::class, 'headerSettingsStore'])->name('settings.header.store')->middleware('custom.permission:manage_header_add');

            /* ---------------- SOCIAL MEDIA ---------------- */
            Route::get('/social-media', [ContentManagementController::class, 'socialMediaIndex'])->name('settings.social.index')->middleware('custom.permission:manage_social');
            Route::post('/social-media/store', [ContentManagementController::class, 'socialMediaStore'])->name('settings.social.store')->middleware('custom.permission:manage_social_add');

            /* ---------------- BANNER SETTINGS ---------------- */
            Route::get('/banner-settings', [ContentManagementController::class, 'bannerSettingsIndex'])->name('settings.banner.index')->middleware('custom.permission:manage_banner');
            Route::get('/banner-settings/edit/{id}', [ContentManagementController::class, 'bannerSettingsEdit'])->name('settings.banner.edit')->middleware('custom.permission:manage_banner_edit');
            Route::post('/banner-settings/store', [ContentManagementController::class, 'bannerSettingsStore'])->name('settings.banner.store')->middleware('custom.permission:manage_banner_add');
            Route::post('/banner-settings/update', [ContentManagementController::class, 'bannerSettingsUpdate'])->name('settings.banner.update')->middleware('custom.permission:manage_banner_edit');
            Route::delete('/banner-settings/delete/{id}', [ContentManagementController::class, 'bannerSettingsDelete'])->name('settings.banner.delete')->middleware('custom.permission:manage_banner_delete');

            /* ---------------- PROGRAMME FEATURE ---------------- */
            Route::get('/programme-feature-settings', [ContentManagementController::class, 'programmeSettingsIndex'])->name('settings.programme_feature.index')->middleware('custom.permission:manage_programme_feature');
            Route::post('/programme-feature-settings/store', [ContentManagementController::class, 'programmeSettingsStore'])->name('settings.programme_feature.store')->middleware('custom.permission:manage_programme_feature_add');

            /* ---------------- MARQUEE SETTINGS ---------------- */
            Route::get('/marquee-settings', [ContentManagementController::class, 'marqueeSettingsIndex'])->name('settings.marquee.index')->middleware('custom.permission:manage_marquee');
            Route::get('/marquee-settings/edit/{id}', [ContentManagementController::class, 'marqueeSettingsEdit'])->name('settings.marquee.edit')->middleware('custom.permission:manage_marquee_edit');
            Route::post('/marquee-settings/store', [ContentManagementController::class, 'marqueeSettingsStore'])->name('settings.marquee.store')->middleware('custom.permission:manage_marquee_add');
            Route::post('/marquee-settings/update', [ContentManagementController::class, 'marqueeSettingsUpdate'])->name('settings.marquee.update')->middleware('custom.permission:manage_marquee_edit');
            Route::delete('/marquee-settings/delete/{id}', [ContentManagementController::class, 'marqueeSettingsDelete'])->name('settings.marquee.delete')->middleware('custom.permission:manage_marquee_delete');

            /* ---------------- POPUP SETTINGS ---------------- */
            Route::get('/pop-up-settings', [ContentManagementController::class, 'popSettingsIndex'])->name('settings.popup.index')->middleware('custom.permission:manage_popup');
            Route::post('/pop-up-settings/store', [ContentManagementController::class, 'popSettingsStore'])->name('settings.popup.store')->middleware('custom.permission:manage_popup_add');

            /* ---------------- FEATURE SETTINGS ---------------- */
            Route::get('/feature-settings', [ContentManagementController::class, 'featureSettingsIndex'])->name('settings.feature.index')->middleware('custom.permission:manage_feature');
            Route::post('/feature-settings/store', [ContentManagementController::class, 'featureSettingsStore'])->name('settings.feature.store')->middleware('custom.permission:manage_feature_add');

        });


        Route::get('admin/get-categories/{id}', [ContentManagementController::class, 'getCategories'])->name('settings.categories');
        Route::get('admin/get-subcategories/{id}', [ContentManagementController::class, 'getSubCategories'])->name('settings.subcategories');

        // Role Routes
        Route::resource('roles', App\Http\Controllers\RolesController::class);
        //Permission Routes
        Route::resource('permissions', App\Http\Controllers\PermissionsController::class);

    });
});
