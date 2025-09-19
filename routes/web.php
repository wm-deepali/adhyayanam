<?php

use App\Models\Blog;
use App\Models\Course;
use App\Models\CurrentAffair;
use App\Models\DailyBooster;
use App\Models\FeedTestimonial;
use App\Models\ProgrammeFeature;
use App\Models\PopUp;
use App\Models\Team;
use App\Models\User;
use App\Models\Banner;
use App\Models\StudyMaterialCategory;
use App\Models\TestSeries;
use App\Models\Topic;
use App\Models\UpcomingExam;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Feature;

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

Route::get('clear-cache', function() {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
     return '<h1>Clear Config cleared</h1>';
 });

Route::get('/', function () {
    $data['courses'] = Course::with('examinationCommission','category','subCategory')->where('feature','on')->orderBy('created_at','DESC')->get();
    $data['topics'] = Topic::with('currentAffair')->get();
    $data['testSeries'] = TestSeries::all();
    $data['dailyBoosts'] = DailyBooster::all();
    $data['teams'] = Team::all();
    $data['banners'] = Banner::all();
    $data['studyCategories'] = StudyMaterialCategory::all();
    $data['programmeFeautre'] = ProgrammeFeature::first();
    $data['feature'] = Feature::first();
    $data['upcomingExams'] = UpcomingExam::with('exam_commission')->orderBy('created_at','DESC')->limit('5')->get();
    $data['blogs'] = Blog::with('user')->get();
    $data['testimonials'] = FeedTestimonial::where('type',2)->orderBy('created_at','DESC')->limit(10)->get();

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




Route::get('pyq-papers/{examid}/{catid}/{subcat}',[App\Http\Controllers\FrontController::class, 'pyqPapers'])->name('pyq-papers');
Route::get('test-series/{examid}/{catid}/{subcat}',[App\Http\Controllers\FrontController::class, 'testseries'])->name('test-series');
Route::post('test-series/filter', [App\Http\Controllers\FrontController::class, 'testseriesFilter'])->name('test-series.filter');
Route::post('test-series/search', [App\Http\Controllers\FrontController::class, 'testseriesSearch'])->name('test-series.search');
Route::get('live-test/{id}',[App\Http\Controllers\FrontController::class, 'livetest'])->name('live-test');
Route::get('result/{id}',[App\Http\Controllers\FrontController::class, 'result'])->name('result');
Route::post('submit-test',[App\Http\Controllers\FrontController::class, 'submittest'])->name('submit-test');
Route::get('test-series-detail/{slug}',[App\Http\Controllers\FrontController::class, 'testseriesDetail'])->name('test-series-detail');
Route::get('subject-pyqs/{id}',[App\Http\Controllers\FrontController::class, 'subjectPapers'])->name('subject-pyqs');
Route::post('/sendotopstudent', [App\Http\Controllers\FrontController::class, 'sendotopstudent'])->name('sendotopstudent');
Route::post('/verifymobilenumberstudent', [App\Http\Controllers\FrontController::class, 'verifymobilenumberstudent'])->name('verifymobilenumberstudent');
Route::get('/logout', [App\Http\Controllers\FrontController::class, 'logout'])->name('logouts');
Route::get('about-us', [App\Http\Controllers\FrontController::class, 'aboutIndex'])->name('about');
Route::get('term-and-conditions', [App\Http\Controllers\FrontController::class, 'termIndex'])->name('term.conditions');
Route::get('privacy-policy', [App\Http\Controllers\FrontController::class, 'privacyIndex'])->name('privacy.policy');
Route::get('refund-policy', [App\Http\Controllers\FrontController::class, 'refundCancellationIndex'])->name('refund.policy');
Route::get('cookies-policy', [App\Http\Controllers\FrontController::class, 'cookiesIndex'])->name('cookies.policy');
Route::get('faq', [App\Http\Controllers\FrontController::class, 'faqIndex'])->name('faq');
Route::get('vision-mission', [App\Http\Controllers\FrontController::class, 'visionIndex'])->name('vision.mission');
Route::get('blog-articles', [App\Http\Controllers\FrontController::class, 'blogIndex'])->name('blog.articles');
Route::get('blog-details/{id}', [App\Http\Controllers\FrontController::class, 'blogDetailsIndex'])->name('blog.details');
Route::get('career', [App\Http\Controllers\FrontController::class, 'careerIndex'])->name('career');
Route::post('career/store',[App\Http\Controllers\FrontController::class,'careerStore'])->name('career.store');
Route::get('courses',[App\Http\Controllers\FrontController::class,'courseIndex'])->name('courses');
Route::get('courses/category/{id}',[App\Http\Controllers\FrontController::class,'courseFilter'])->name('courses.filter');
Route::get('courses/details/{id}',[App\Http\Controllers\FrontController::class,'courseDetails'])->name('courses.detail');
Route::get('direct-enquiry', [App\Http\Controllers\FrontController::class, 'enquiryIndex'])->name('enquiry.direct');
Route::post('direct-enquiry/store',[App\Http\Controllers\FrontController::class,'enquiryStore'])->name('enquiry.store');
Route::get('contact-us-inquiry', [App\Http\Controllers\FrontController::class, 'contactUsIndex'])->name('contact.inquiry');
Route::post('contact-us-inquiry/store',[App\Http\Controllers\FrontController::class,'contactUsStore'])->name('contact.inquiry.store');
Route::get('callback-inquiry', [App\Http\Controllers\FrontController::class, 'callbackIndex'])->name('callback.inquiry');
Route::post('callback-inquiry/store',[App\Http\Controllers\FrontController::class,'callbackStore'])->name('callback.inquiry.store');
Route::get('our-team', [App\Http\Controllers\FrontController::class, 'ourTeamIndex'])->name('our.team.index');
Route::get('current-affair', [App\Http\Controllers\FrontController::class, 'currentAffairsIndex'])->name('current.index');
Route::get('current-affair/details/{id}', [App\Http\Controllers\FrontController::class, 'currentAffairsDetail'])->name('current.details');
Route::get('daily-boost', [App\Http\Controllers\FrontController::class, 'dailyBoostIndex'])->name('daily.boost.front');
Route::get('user/test-planner', [App\Http\Controllers\FrontController::class, 'testPlannerIndex'])->name('test.planner.front');
Route::get('user/test-planner/details/{id}', [App\Http\Controllers\FrontController::class, 'testPlannerDetails'])->name('test.planner.details');
Route::get('user/study-material', [App\Http\Controllers\FrontController::class, 'studyMaterialIndex'])->name('study.material.front');
Route::post('user/study-material/filter', [App\Http\Controllers\FrontController::class, 'studyMaterialFilter'])->name('study.material.filter');
Route::post('user/study-material/search', [App\Http\Controllers\FrontController::class, 'studyMaterialSearch'])->name('study.material.search');
Route::get('user/study-material/all-topics/{id}', [App\Http\Controllers\FrontController::class, 'studyMaterialAllTopics'])->name('study.material.topics');
Route::get('user/study-material/details/{id}', [App\Http\Controllers\FrontController::class, 'studyMaterialDetails'])->name('study.material.details');
Route::get('user/upcoming-exams', [App\Http\Controllers\FrontController::class, 'upcomingExamsIndex'])->name('upcoming.exam.front');
Route::get('user/adhyayanam-corner', [App\Http\Controllers\FrontController::class, 'netiCornerIndex'])->name('neti.corner.index');
Route::get('user/feed-back-testimonial', [App\Http\Controllers\FrontController::class, 'feedBackIndex'])->name('feed.back.index');
Route::post('user/feed-back-testimonial/store', [App\Http\Controllers\FrontController::class, 'feedBackStore'])->name('feed.back.store');
Route::get('user/batches-and-programme', [App\Http\Controllers\FrontController::class, 'batchesIndex'])->name('batches.index');
/**
 * Auth Routes
 */
Auth::routes(['verify' => false]);


Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    Route::middleware('auth')->group(function () {

        Route::get('/user/dashboard', function () {
            return view('front-users.dashboard');
        })->name('user.dashboard');
        
        Route::get('/user/orders',[App\Http\Controllers\FrontUserController::class,'studentAllOrder'])->name('user.orders');
        Route::get('/user/order-details/{id}',[App\Http\Controllers\FrontUserController::class,'orderDetails'])->name('user.order-details');
        Route::get('/user/generate-pdf/{id}',[App\Http\Controllers\FrontUserController::class,'generatePDF'])->name('user.generate-pdf');
        Route::get('/user/print-invoice/{id}',[App\Http\Controllers\FrontUserController::class,'printInvoice'])->name('user.print-invoice');
        
        
        Route::get('/user/test-papers', function () {
            return view('front-users.test-paper');
        })->name('user.test-papers');
        
        Route::get('/user/test-series', function () {
            return view('front-users.test-series');
        })->name('user.test-series');
        
        Route::get('/user/course-details', function () {
            return view('front-users.course-details');
        })->name('user.course-details');
        
        Route::get('/user-study-material', function () {
            return view('front-users.study-material');
        })->name('user-study-material');
        
        Route::get('/user-test-planner', function () {
            return view('front-users.test-planner');
        })->name('user-test-planner');
        
        Route::delete('/user/user-activity/delete/{id}',[App\Http\Controllers\FrontUserController::class,'activityDelete'])->name('user-activity.destroy');
        
        Route::get('/user/setting',[App\Http\Controllers\FrontUserController::class,'setting'])->name('user.setting');
        Route::post('user/register-student',[App\Http\Controllers\FrontUserController::class,'studentRegister'])->name('register-student');
        Route::post('user/change-student-password',[App\Http\Controllers\FrontUserController::class,'studentChangePassword'])->name('change-student-password');
        Route::get('user/process-order/{type}/{id}',[App\Http\Controllers\PaymentController::class,'orderProcess'])->name('user.process-order');
        Route::any('order/status', [App\Http\Controllers\PaymentController::class, 'orderStatus'])->name('order.status');

    });

    Route::middleware('auth', 'isAdmin')->group(function () {
        /**
         * Home Routes
         */
        //content management
       
        Route::get('admin-login', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
        Route::get('content-management/about',[App\Http\Controllers\ContentManagementController::class,'aboutUs'])->name('cm.about');
        Route::get('content-management/term-and-condition',[App\Http\Controllers\ContentManagementController::class,'termAndCondition'])->name('cm.term.condition');
        Route::get('content-management/privacy-policies',[App\Http\Controllers\ContentManagementController::class,'privacyPolicies'])->name('cm.privacy.policy');
        Route::get('content-management/refund-and-cancellation',[App\Http\Controllers\ContentManagementController::class,'refundCancellation'])->name('cm.refund.cancellation');
        Route::get('content-management/cookies-policies',[App\Http\Controllers\ContentManagementController::class,'cookiesPolicies'])->name('cm.cookies.policies');
        Route::get('content-management/career',[App\Http\Controllers\ContentManagementController::class,'career'])->name('cm.career');
        Route::get('ajaxdata/bulk-delete',[App\Http\Controllers\ContentManagementController::class,'careerBulkDelete'])->name('ajaxdata.bulk-delete');
        Route::delete('content-management/career/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'careerDelete'])->name('cm.career.delete');
        Route::get('content-management/blog-and-articles',[App\Http\Controllers\ContentManagementController::class,'blogArticles'])->name('cm.blog.articles');
        Route::get('content-management/our-team',[App\Http\Controllers\ContentManagementController::class,'ourTeam'])->name('cm.our.team');
        Route::delete('content-management/our-team/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'ourTeamDelete'])->name('cm.our.team.delete');
        Route::get('content-management/our-team/edit/{id}',[App\Http\Controllers\ContentManagementController::class,'ourTeamEdit'])->name('cm.our.team.edit');
        Route::post('content-management/our-team/store',[App\Http\Controllers\ContentManagementController::class,'ourTeamStore'])->name('cm.our.team.store');
        Route::post('content-management/our-team/update',[App\Http\Controllers\ContentManagementController::class,'ourTeamUpdate'])->name('cm.our.team.update');
        Route::get('content-management/vision-and-mission',[App\Http\Controllers\ContentManagementController::class,'visionMission'])->name('cm.vision.mission');
        Route::get('content-management/faq',[App\Http\Controllers\ContentManagementController::class,'faq'])->name('cm.faq');
        Route::get('manage-courses/examination-commission',[App\Http\Controllers\ContentManagementController::class,'examinationIndex'])->name('cm.exam');
        Route::get('manage-courses/examination-commission/create',[App\Http\Controllers\ContentManagementController::class,'examinationCreate'])->name('cm.exam.create');
        Route::get('manage-courses/examination-commission/edit/{id}',[App\Http\Controllers\ContentManagementController::class,'examinationEdit'])->name('cm.exam.edit');
        Route::post('manage-courses/examination-commission/update',[App\Http\Controllers\ContentManagementController::class,'examinationUpdate'])->name('cm.exam.update');
        Route::get('manage-courses/category',[App\Http\Controllers\ContentManagementController::class,'categoryIndex'])->name('cm.category');
        Route::get('manage-courses/category/create',[App\Http\Controllers\ContentManagementController::class,'categoryCreate'])->name('cm.category.create');
        Route::get('manage-courses/category/edit/{id}',[App\Http\Controllers\ContentManagementController::class,'categoryEdit'])->name('cm.category.edit');
        Route::post('manage-courses/category/update',[App\Http\Controllers\ContentManagementController::class,'categoryUpdate'])->name('cm.category.update');
        Route::get('manage-courses/sub-category',[App\Http\Controllers\ContentManagementController::class,'subCategoryIndex'])->name('cm.sub.category');
         Route::get('manage-courses/sub-category/edit/{id}',[App\Http\Controllers\ContentManagementController::class,'subCategoryEdit'])->name('cm.sub.category.edit');
         Route::post('manage-courses/sub-category/update/{id}',[App\Http\Controllers\ContentManagementController::class,'subCategoryUpdate'])->name('cm.sub-category.update');
        Route::get('manage-courses/sub-category/create',[App\Http\Controllers\ContentManagementController::class,'subCategoryCreate'])->name('cm.sub-category.create');
        Route::get('manage-courses/subject',[App\Http\Controllers\ContentManagementController::class,'subjectIndex'])->name('cm.subject');
        Route::get('manage-courses/subject/create',[App\Http\Controllers\ContentManagementController::class,'subjectCreate'])->name('cm.subject.create');
        Route::get('manage-courses/subject/edit/{id}',[App\Http\Controllers\ContentManagementController::class,'subjectEdit'])->name('cm.subject.edit');
        Route::get('manage-courses/chapter',[App\Http\Controllers\ContentManagementController::class,'chapterIndex'])->name('cm.chapter');
        Route::get('manage-courses/chapter/create',[App\Http\Controllers\ContentManagementController::class,'chapterCreate'])->name('cm.chapter.create');
        Route::get('manage-courses/chapter/edit/{id}',[App\Http\Controllers\ContentManagementController::class,'chapterEdit'])->name('cm.chapter.edit');
        Route::post('manage-courses/chapter/update/{id}',[App\Http\Controllers\ContentManagementController::class,'chapterUpdate'])->name('cm.chapter.update');
        Route::get('manage-courses/course',[App\Http\Controllers\ContentManagementController::class,'courseIndex'])->name('courses.course.index');
        Route::get('manage-courses/course/create',[App\Http\Controllers\ContentManagementController::class,'courseCreate'])->name('courses.course.create');
        Route::get('manage-courses/course/edit/{id}',[App\Http\Controllers\ContentManagementController::class,'courseEdit'])->name('courses.course.edit');
        Route::get('enquiries-and-call/direct-enquiries',[App\Http\Controllers\ContentManagementController::class,'directEnquiriesIndex'])->name('enquiries.direct.call');
        Route::get('enquiries-and-call/contact-us',[App\Http\Controllers\ContentManagementController::class,'contactUsIndex'])->name('enquiries.contact.us');
        Route::get('enquiries-and-call/call-back-request',[App\Http\Controllers\ContentManagementController::class,'callRequestIndex'])->name('enquiries.call.request');
        Route::get('current-affairs/topic',[App\Http\Controllers\ContentManagementController::class,'topicIndex'])->name('current.affairs.topic');
        Route::get('current-affairs',[App\Http\Controllers\ContentManagementController::class,'currentAffairIndex'])->name('current.affairs.index');
        Route::get('current-affairs/create',[App\Http\Controllers\ContentManagementController::class,'currentAffairCreate'])->name('current.affairs.create');
        Route::get('feedback',[App\Http\Controllers\ContentManagementController::class,'feedIndex'])->name('feed.index');
        Route::get('testimonials',[App\Http\Controllers\ContentManagementController::class,'testimonialsIndex'])->name('testimonials.index');
        Route::get('testimonial/view/{id}',[App\Http\Controllers\ContentManagementController::class,'testimonialView'])->name('testimonial.view');
        Route::patch('/testimonial/{id}/approveStatus', [App\Http\Controllers\ContentManagementController::class, 'updateapproveStatus'])->name('testimonial.approveStatus');
        Route::delete('feedback-testimonial/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'feedDelete'])->name('feed.delete');

        Route::post('content-management/our-team/store',[App\Http\Controllers\ContentManagementController::class,'ourTeamStore'])->name('cm.team.store');
        Route::post('content-management/about/store',[App\Http\Controllers\ContentManagementController::class,'aboutStore'])->name('about.store');
        Route::post('content-management/term-and-conditions/store',[App\Http\Controllers\ContentManagementController::class,'termStore'])->name('term.conditions.store');
        Route::post('content-management/privacy-policies/store',[App\Http\Controllers\ContentManagementController::class,'privacyStore'])->name('privacy.policies.store');
        Route::post('content-management/refund-and-cancellation/store',[App\Http\Controllers\ContentManagementController::class,'refundCancellationStore'])->name('refund.cancellation.store');
        Route::post('content-management/cookies-policies/store',[App\Http\Controllers\ContentManagementController::class,'cookiesPolicyStore'])->name('cookies.policy.store');
        Route::post('content-management/faq/store',[App\Http\Controllers\ContentManagementController::class,'faqStore'])->name('faq.store');
        Route::post('content-management/vision-and-mission/store',[App\Http\Controllers\ContentManagementController::class,'visionStore'])->name('vision.store');
        Route::post('content-management/blog-and-articles/store',[App\Http\Controllers\ContentManagementController::class,'blogStore'])->name('blog.store');
        Route::delete('content-management/blog-and-articles/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'blogDelete'])->name('blog.destroy');
        Route::post('manage-courses/examination-commission/create/store',[App\Http\Controllers\ContentManagementController::class,'examinationStore'])->name('cm.exam.store');
        Route::delete('manage-courses/examination-commission/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'examinationDelete'])->name('cm.exam.destroy');
        Route::get('manage-courses/examination-commission/bulk-delete',[App\Http\Controllers\ContentManagementController::class,'examinationBulkDelete'])->name('cm.exam.bulk-delete');
        Route::post('manage-courses/category/create/store',[App\Http\Controllers\ContentManagementController::class,'categoryStore'])->name('cm.category.store');
        Route::delete('manage-courses/category/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'categoryDelete'])->name('cm.category.delete');
        Route::get('manage-courses/category/bulk-delete',[App\Http\Controllers\ContentManagementController::class,'categoryBulkDelete'])->name('cm.category.bulk-delete');
        Route::post('manage-courses/sub-category/create/store',[App\Http\Controllers\ContentManagementController::class,'subCategoryStore'])->name('cm.sub-category.store');
        Route::delete('manage-courses/sub-category/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'subCategoryDelete'])->name('cm.sub-category.delete');
        Route::get('manage-courses/sub-category/bulk-delete',[App\Http\Controllers\ContentManagementController::class,'subCatBulkDelete'])->name('cm.sub-category.bulk-delete');
        Route::post('manage-courses/subject/store',[App\Http\Controllers\ContentManagementController::class,'subjectStore'])->name('cm.subject.store');
        Route::post('manage-courses/subject/update/{id}',[App\Http\Controllers\ContentManagementController::class,'subjectUpdate'])->name('cm.subject.update');
        Route::delete('manage-courses/subject/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'subjectDelete'])->name('cm.subject.delete');
        Route::get('manage-courses/subject/bulk-delete',[App\Http\Controllers\ContentManagementController::class,'subjectBulkDelete'])->name('cm.subject.bulk-delete');
        Route::post('manage-courses/chapter/store',[App\Http\Controllers\ContentManagementController::class,'chapterStore'])->name('cm.chapter.store');
        Route::delete('manage-courses/chapter/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'chapterDelete'])->name('cm.chapter.delete');
        Route::get('manage-courses/chapter/bulk-delete',[App\Http\Controllers\ContentManagementController::class,'chapterBulkDelete'])->name('cm.chapter.bulk-delete');
        Route::post('manage-courses/course/store',[App\Http\Controllers\ContentManagementController::class,'courseStore'])->name('courses.course.store');
         Route::post('manage-courses/course/update/{id}',[App\Http\Controllers\ContentManagementController::class,'courseUpdate'])->name('courses.course.update');
        Route::delete('manage-courses/course/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'courseDelete'])->name('courses.course.delete');
        Route::get('manage-courses/course/bulk-delete',[App\Http\Controllers\ContentManagementController::class,'courseBulkDelete'])->name('courses.course.bulk-delete');

        Route::delete('enquiries-and-call/direct-enquiries/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'directEnquiriesDelete'])->name('enquiries.direct.delete');
        Route::delete('enquiries-and-call/contact-us/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'contactUsDelete'])->name('enquiries.contact.delete');
        Route::get('enquiries-and-call/contact-us/bulk-delete',[App\Http\Controllers\ContentManagementController::class,'contactUsBulkDelete'])->name('enquiries.contact.bulk-delete');
        Route::delete('enquiries-and-call/call-back-request/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'callRequestDelete'])->name('enquiries.call.delete');

        Route::get('study-material',[App\Http\Controllers\ContentManagementController::class,'studyMaterialIndex'])->name('study.material.index');
        Route::get('study-material/create',[App\Http\Controllers\ContentManagementController::class,'studyMaterialCreate'])->name('study.material.create');
        Route::get('study-material/edit/{id}',[App\Http\Controllers\ContentManagementController::class,'studyMaterialEdit'])->name('study.material.edit');
        Route::post('study-material/store',[App\Http\Controllers\ContentManagementController::class,'studyMaterialStore'])->name('study.material.store');
        Route::post('study-material/update/{id}',[App\Http\Controllers\ContentManagementController::class,'studyMaterialUpdate'])->name('study.material.update');
        Route::delete('study-material/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'studyMaterialDelete'])->name('study.material.delete');
        Route::get('study-material/bulk-delete',[App\Http\Controllers\ContentManagementController::class,'studyMaterialBulkDelete'])->name('study.material.bulk-delete');

        Route::get('daily-booster',[App\Http\Controllers\ContentManagementController::class,'dailyBoostIndex'])->name('daily.boost.index');
        Route::get('daily-booster/create',[App\Http\Controllers\ContentManagementController::class,'dailyBoostCreate'])->name('daily.boost.create');
        Route::get('daily-booster/edit/{id}',[App\Http\Controllers\ContentManagementController::class,'dailyBoostEdit'])->name('daily.boost.edit');
        Route::post('daily-booster/store',[App\Http\Controllers\ContentManagementController::class,'dailyBoostStore'])->name('daily.boost.store');
        Route::post('daily-booster/update/{id}',[App\Http\Controllers\ContentManagementController::class,'dailyBoostUpdate'])->name('daily.boost.update');
        Route::delete('daily-booster/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'dailyBoostDelete'])->name('daily.boost.delete');
        Route::get('booster/bulk-delete',[App\Http\Controllers\ContentManagementController::class,'boosterBulkDelete'])->name('booster.bulk-delete');

        Route::get('test-planner',[App\Http\Controllers\ContentManagementController::class,'testPlannerIndex'])->name('test.planner.index');
        Route::get('test-planner/edit/{id}',[App\Http\Controllers\ContentManagementController::class,'testPlannerEdit'])->name('test.planner.edit');
        Route::get('test-planner/create',[App\Http\Controllers\ContentManagementController::class,'testPlannerCreate'])->name('test.planner.create');
        Route::post('test-planner/store',[App\Http\Controllers\ContentManagementController::class,'testPlannerStore'])->name('test.planner.store');
        Route::post('test-planner/update/{id}',[App\Http\Controllers\ContentManagementController::class,'testPlannerUpdate'])->name('test.planner.update');
        Route::delete('test-planner/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'testPlannerDelete'])->name('test.planner.delete');
        Route::get('test-planner/bulk-delete',[App\Http\Controllers\ContentManagementController::class,'testPlannerBulkDelete'])->name('test.planner.bulk-delete');

        Route::post('current-affairs/topic/store',[App\Http\Controllers\ContentManagementController::class,'topicStore'])->name('current.affairs.topic.store');
        Route::delete('current-affairs/topic/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'topicDelete'])->name('current.affairs.topic.delete');
        Route::post('current-affairs/store',[App\Http\Controllers\ContentManagementController::class,'currentAffairStore'])->name('current.affairs.store');
        Route::delete('current-affairs/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'currentAffairDelete'])->name('current.affairs.delete');

        Route::get('test-series',[App\Http\Controllers\ContentManagementController::class,'testSeriesIndex'])->name('test.series.index');
        Route::get('test-series/create',[App\Http\Controllers\ContentManagementController::class,'testSeriesCreate'])->name('test.series.create');
        Route::post('test-series/store',[App\Http\Controllers\ContentManagementController::class,'testSeriesStore'])->name('test.series.store');
        Route::get('test-series/edit/{id}',[App\Http\Controllers\ContentManagementController::class,'testSeriesEdit'])->name('test.series.edit');
        Route::post('test-series/update/{id}',[App\Http\Controllers\ContentManagementController::class,'testSeriesUpdate'])->name('test.series.update');
        Route::delete('test-series/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'testSeriesDelete'])->name('test.series.delete');
        Route::get('test-series/view/{id}',[App\Http\Controllers\ContentManagementController::class,'testSeriesView'])->name('test.series.view');

        Route::get('test-series/question',[App\Http\Controllers\ContentManagementController::class,'testSeriesQuestion'])->name('test.series.question');
        Route::get('test-series/question/create',[App\Http\Controllers\ContentManagementController::class,'testSeriesQuestionCreate'])->name('test.series.question.create');

        Route::get('upcoming-exams',[App\Http\Controllers\ContentManagementController::class,'upcomingExamIndex'])->name('upcoming.exam.index');
        Route::get('upcoming-exams/create',[App\Http\Controllers\ContentManagementController::class,'upcomingExamCreate'])->name('upcoming.exam.create');
        Route::get('upcoming-exams/edit/{id}',[App\Http\Controllers\ContentManagementController::class,'upcomingExamEdit'])->name('upcoming.exam.edit');
        Route::post('upcoming-exams/store',[App\Http\Controllers\ContentManagementController::class,'upcomingExamStore'])->name('upcoming.exam.store');
        Route::post('upcoming-exams/update/{id}',[App\Http\Controllers\ContentManagementController::class,'upcomingExamUpdate'])->name('upcoming.exam.update');
        Route::delete('upcoming-exams/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'upcomingExamDelete'])->name('upcoming.exam.delete');
        Route::delete('upcoming-exams/bulk-delete',[App\Http\Controllers\ContentManagementController::class,'upcomingExamBulkDelete'])->name('upcoming.exam.bulk-delete');

        Route::get('question-bank',[App\Http\Controllers\ContentManagementController::class,'questionBankIndex'])->name('question.bank.index');
        Route::get('rejected-question-bank',[App\Http\Controllers\ContentManagementController::class,'rejectQuestionBankIndex'])->name('question.bank.rejected');
        
        Route::post('question-bank/store',[App\Http\Controllers\ContentManagementController::class,'questionBankStore'])->name('question.bank.store');
        Route::post('question-bank/import-questions',[App\Http\Controllers\ContentManagementController::class,'ImportQuestions'])->name('question.bank.import-questions');
        Route::get('question-bank/create',[App\Http\Controllers\ContentManagementController::class,'questionBankCreate'])->name('question.bank.create');
        Route::get('question-bank/bulk-upload',[App\Http\Controllers\ContentManagementController::class,'questionBankBulkUpload'])->name('question.bank.bulk-upload');
        Route::delete('question-bank/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'questionBankDelete'])->name('question.bank.delete');
        Route::get('question-bank/edit/{id}',[App\Http\Controllers\ContentManagementController::class,'questionBankEdit'])->name('question.bank.edit');
        Route::post('question-bank/update/{id}',[App\Http\Controllers\ContentManagementController::class,'questionBankUpdate'])->name('question.bank.update');
        Route::get('question-bank/view/{id}',[App\Http\Controllers\ContentManagementController::class,'questionBankView'])->name('question.bank.view');


        Route::get('test-paper',[App\Http\Controllers\TestController::class,'TestBankIndex'])->name('test.bank.index');
        Route::get('test-paper/create',[App\Http\Controllers\TestController::class,'testPaperCreate'])->name('test.paper.create');
        Route::delete('test-paper/delete/{id}',[App\Http\Controllers\TestController::class,'destroy'])->name('test.paper.delete');
        Route::get('test-paper/view/{id}',[App\Http\Controllers\TestController::class,'view'])->name('test.paper.view');
        Route::get('test-paper/edit/{id}',[App\Http\Controllers\TestController::class,'edit'])->name('test.paper.edit');
        Route::post('test-paper/update/{id}',[App\Http\Controllers\TestController::class,'update'])->name('test.paper.update');
        Route::get('fetch-exam-category-by-commission/{commission}','TestController@fetchExamCategoryByCommission')->name('fetch-exam-category-by-commission');
        Route::get('fetch-sub-category-by-exam-category/{exam_category}','TestController@fetchSubCategoryByExamCategory')->name('fetch-sub-category-by-exam-category');
        Route::get('fetch-subject-by-subcategory/{sub_category}','TestController@fetchSubjectBySubCategory')->name('fetch-subject-by-subcategory');
        Route::post('generate-test-questions-by-selections','TestController@generatetestquestionsbyselections')->name('generate-test-questions-by-selections');
        Route::post('generate-test-paper-by-selections','TestController@generatetestpaperbyselections')->name('generate-test-paper-by-selections');

        Route::post('preview-test','TestController@previewTest')->name('preview-test');
         Route::get('fetch-subject/{commission}/{category?}/{sub_category?}','TestController@fetchSubject')->name('fetch-subject');
        Route::get('fetch-chapter-by-subject/{subject}','TestController@fetchchapterbySubject')->name('fetch-chapter-by-subject');
        Route::get('fetch-topic-by-chapter/{subject}','TestController@fetchtopicbychapter')->name('fetch-topic-by-chapter');
        Route::post('manage-test','TestController@store')->name('manage-test');
        Route::post('get-all-subjects','TestController@allSubject')->name('get-all-subjects');
        Route::post('get-all-subjects-multi','TestController@allSubjectMulti')->name('get-all-subjects-multi');

        Route::resource('pyq', 'PYQController');
        Route::resource('study-material/category', 'StudyMaterialCategoryController');
        Route::resource('study-material/main-topic', 'MainTopicController');
        Route::get('study-material/main-topic/fetch-topic-by-category/{category}','MainTopicController@fetchCategory')->name('fetch-topic-by-category');
        Route::get('pyq-content',[App\Http\Controllers\ContentManagementController::class,'pyqContentIndex'])->name('pyq.content.index');
        Route::get('pyq-content/create',[App\Http\Controllers\ContentManagementController::class,'pyqContentCreate'])->name('pyq.content.create');
         Route::get('pyq-content/edit/{id}',[App\Http\Controllers\ContentManagementController::class,'pyqContentEdit'])->name('pyq.content.edit');
        Route::post('pyq-content/store',[App\Http\Controllers\ContentManagementController::class,'pyqContentStore'])->name('pyq.content.store');
        Route::post('pyq-content/update/{id}',[App\Http\Controllers\ContentManagementController::class,'pyqContentUpdate'])->name('pyq.content.update');
        Route::delete('pyq-content/delete/{id}',[App\Http\Controllers\ContentManagementController::class,'pyqContentDelete'])->name('pyq.content.delete');
        
        Route::patch('/feed/{id}/updateStatus', [App\Http\Controllers\ContentManagementController::class, 'updateFeedStatus'])->name('feed.updateStatus');
        
         Route::resource('manage-courses/topic',CourseTopicController::class);
        //seo
        Route::get('seo/index',[App\Http\Controllers\ContentManagementController::class,'seoIndex'])->name('seo.index');
        Route::get('seo/create',[App\Http\Controllers\ContentManagementController::class,'seoCreate'])->name('seo.create');
        Route::post('seo/store',[App\Http\Controllers\ContentManagementController::class,'seoStore'])->name('seo.store');
        Route::resource('video', 'VideoController');
        Route::get('chapter-video/{id}', 'VideoController@chapter_topic')->name('chapter-video');
        Route::get('course-video/{id}', 'VideoController@course_topic')->name('course-video');
        Route::get('chapter-course/{id}', 'VideoController@chapter_course')->name('chapter-course');
        Route::get('live-class-schedule', 'VideoController@live_class_schedule')->name('live-class-schedule');
        Route::get('fetch-category/{type}','VideoController@fetchcategory')->name('fetch-category'); 
        Route::get('fetch-course/{id}','VideoController@fetchcourse')->name('fetch-course');
        Route::get('fetch-chapter/{id}','VideoController@fetchchapter')->name('fetch-chapter');

        /************************Page Url for design***************/
        Route::get('order/student-all-orders',[App\Http\Controllers\OrderController::class,'allOrder'])->name('order.student-all-orders');
        Route::get('order/test-series-orders',[App\Http\Controllers\OrderController::class,'allTestSeriesOrder'])->name('order.test-series-orders');
        Route::get('order/course-orders',[App\Http\Controllers\OrderController::class,'allCourseOrder'])->name('order.course-orders');

        Route::get('order/study-material-orders',[App\Http\Controllers\OrderController::class,'allStudyMaterialOrder'])->name('order.study-material-orders');
        Route::get('order/student-transactions-list',[App\Http\Controllers\OrderController::class,'allTransactions'])->name('order.student-transactions-list');
        Route::get('order/student-failed-transactions',[App\Http\Controllers\OrderController::class,'allFailedTransactions'])->name('order.student-failed-transactions');


        Route::get('students/registered-student-list',[App\Http\Controllers\StudentController::class,'RegisterStudentList'])->name('students.registered-student-list');
        Route::get('students/view-all-orders/{id}',[App\Http\Controllers\StudentController::class,'ViewAllOrder'])->name('students.view-all-orders');

        Route::get('students/change-status',[App\Http\Controllers\StudentController::class,'changeStatus'])->name('students.change-status');

        Route::get('students/student-test-series-summary',[App\Http\Controllers\StudentController::class,'studentTestSummery'])->name('students.student-test-series-summary');
        Route::get('students/student-course-summary',[App\Http\Controllers\StudentController::class,'studentCourseSummery'])->name('students.student-course-summary');

        Route::get('students/student-all-test-list', function () {
            return view('students.student-all-test-list');
        })->name('students.student-all-test-list');

        Route::get('students/student-videos-list', function () {
            return view('students.student-videos-list');
        })->name('students.student-videos-list');


        Route::get('students/student-profile-detail/{id}',[App\Http\Controllers\StudentController::class,'studentProfile'])->name('students.student-profile-detail');
        Route::get('students/change-password/{id}',[App\Http\Controllers\StudentController::class,'studentChangePassword'])->name('students.change-password');
        Route::post('students/update-password/{id}',[App\Http\Controllers\StudentController::class,'studentUpdatePassword'])->name('students.update-password');
        

        Route::get('students/student-test-result-detail', function () {
            return view('students.student-test-result-detail');
        })->name('students.student-test-result-detail');

        Route::get('students/student-watched-video-list', function () {
            return view('students.student-watched-video-list');
        })->name('students.student-watched-video-list');

        Route::get('students/student-order-detail/{id}',[App\Http\Controllers\OrderController::class,'studentOrderDetails'])->name('students.student-order-detail');
        
        /************************Page Url for design End***************/

        Route::get('batches-and-programme', [App\Http\Controllers\ContentManagementController::class, 'batchesProgrammeIndex'])->name('batches-programme.index');
        Route::get('batches-and-programme/create', [App\Http\Controllers\ContentManagementController::class, 'batchesProgrammeCreate'])->name('batches-programme.create');
        Route::post('batches-and-programme/store', [App\Http\Controllers\ContentManagementController::class, 'batchesProgrammeStore'])->name('batches-programme.store');
        Route::delete('batches-and-programme/delete/{id}', [App\Http\Controllers\ContentManagementController::class, 'batchesProgrammeDelete'])->name('batches-programme.delete');

        Route::get('admin/settings/header-settings', [App\Http\Controllers\ContentManagementController::class, 'headerSettingsIndex'])->name('settings.header.index');
        Route::post('admin/settings/header-settings/store', [App\Http\Controllers\ContentManagementController::class, 'headerSettingsStore'])->name('settings.header.store');
        Route::get('admin/settings/social-media', [App\Http\Controllers\ContentManagementController::class, 'socialMediaIndex'])->name('settings.social.index');
        Route::post('admin/settings/social-media/store', [App\Http\Controllers\ContentManagementController::class, 'socialMediaStore'])->name('settings.social.store');
        
        Route::get('admin/settings/banner-settings', [App\Http\Controllers\ContentManagementController::class, 'bannerSettingsIndex'])->name('settings.banner.index');
        Route::get('admin/settings/banner-settings/edit/{id}', [App\Http\Controllers\ContentManagementController::class, 'bannerSettingsEdit'])->name('settings.banner.edit');
        Route::post('admin/settings/banner-settings/store', [App\Http\Controllers\ContentManagementController::class, 'bannerSettingsStore'])->name('settings.banner.store');
        Route::post('admin/settings/banner-settings/update', [App\Http\Controllers\ContentManagementController::class, 'bannerSettingsUpdate'])->name('settings.banner.update');
        Route::delete('admin/settings/banner-settings/delete/{id}', [App\Http\Controllers\ContentManagementController::class, 'bannerSettingsDelete'])->name('settings.banner.delete');

        Route::get('admin/settings/programme-feature-settings', [App\Http\Controllers\ContentManagementController::class, 'programmeSettingsIndex'])->name('settings.programme_feature.index');
        Route::post('admin/settings/programme-feature-settings/store', [App\Http\Controllers\ContentManagementController::class, 'programmeSettingsStore'])->name('settings.programme_feature.store');

        Route::get('admin/settings/marquee-settings', [App\Http\Controllers\ContentManagementController::class, 'marqueeSettingsIndex'])->name('settings.marquee.index');
         Route::get('admin/settings/marquee-settings/edit/{id}', [App\Http\Controllers\ContentManagementController::class, 'marqueeSettingsEdit'])->name('settings.marquee.edit');
        Route::post('admin/settings/marquee-settings/store', [App\Http\Controllers\ContentManagementController::class, 'marqueeSettingsStore'])->name('settings.marquee.store');
         Route::post('admin/settings/marquee-settings/update', [App\Http\Controllers\ContentManagementController::class, 'marqueeSettingsUpdate'])->name('settings.marquee.update');
        Route::delete('admin/settings/marquee-settings/delete/{id}', [App\Http\Controllers\ContentManagementController::class, 'marqueeSettingsDelete'])->name('settings.marquee.delete');

        Route::get('admin/settings/pop-up-settings', [App\Http\Controllers\ContentManagementController::class, 'popSettingsIndex'])->name('settings.popup.index');
        Route::post('admin/settings/pop-up-settings/store', [App\Http\Controllers\ContentManagementController::class, 'popSettingsStore'])->name('settings.popup.store');

        Route::get('admin/settings/feature-settings', [App\Http\Controllers\ContentManagementController::class, 'featureSettingsIndex'])->name('settings.feature.index');
        Route::post('admin/settings/feature-settings/store', [App\Http\Controllers\ContentManagementController::class, 'featureSettingsStore'])->name('settings.feature.store');
        
        Route::get('admin/get-categories/{id}', [App\Http\Controllers\ContentManagementController::class, 'getCategories'])->name('settings.categories');
        
        Route::get('admin/get-subcategories/{id}', [App\Http\Controllers\ContentManagementController::class, 'getSubCategories'])->name('settings.subcategories');

        /**
         * Role Routes
         */    
        Route::resource('roles', App\Http\Controllers\RolesController::class);
        /**
         * Permission Routes
         */    
        Route::resource('permissions', App\Http\Controllers\PermissionsController::class);
        /**
         * User Routes
         */
        Route::group(['prefix' => 'users'], function() {
            Route::get('/', [App\Http\Controllers\UsersController::class, 'index'])->name('users.index');
            Route::get('/create', 'UsersController@create')->name('users.create');
            Route::post('/create', 'UsersController@store')->name('users.store');
            Route::get('/{user}/show', 'UsersController@show')->name('users.show');
            Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
            Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
            Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
        });
    });
});
