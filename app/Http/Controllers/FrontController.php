<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Validator;
use Carbon\Carbon;
use App\Models\SEO;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Blog;
use App\Models\Test;
use App\Models\User;
use App\Models\Team;
use App\Models\Topic;
use App\Models\PopUp;
use App\Models\Course;
use App\Models\Career;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\CallBack;
use App\Models\Syllabus;
use App\Models\MainTopic;
use App\Models\ContactUs;
use App\Models\HomeSlider;
use App\Models\TestSeries;
use App\Models\PyqContent;
use App\Models\SocialMedia;
use App\Models\CurrentNews;
use App\Models\NoticeBoard;
use App\Models\HomeEnquiry;
use App\Models\TestPlanner;
use App\Models\CourseTopic;
use App\Models\SubCategory;
use App\Models\UpcomingExam;
use App\Models\DailyBooster;
use Illuminate\Http\Request;
use App\Helpers\LogActivity;
use App\Models\DirectEnquiry;
use App\Models\CurrentAffair;
use App\Models\StudyMaterial;
use App\Models\HeaderSetting;
use App\Models\BatchProgramme;
use App\Models\FeedTestimonial;
use App\Models\InstituteFeature;
use Illuminate\Support\Facades\Auth;
use App\Models\StudyMaterialCategory;
use App\Models\ExaminationCommission;
use App\Models\UserMobiileVerification;
use App\Models\Category;
use App\Models\OfficeAddress;
use App\Models\AboutPageSection;
use App\Models\AboutPageCounter;
use App\Models\AboutPageHighlight;
use App\Models\AboutPageStrength;
use Spatie\Browsershot\Browsershot;


class FrontController extends Controller
{
    public function index()
    {
        $data['commissions'] = ExaminationCommission::with('categories')->where('status', 1)->get();
        $data['courses'] = Course::with('examinationCommission')->orderBy('created_at', 'DESC')->get();
        $data['topics'] = Topic::with('currentAffair')->get();
        $data['testSeries'] = TestSeries::with('commission')->get();
        $data['dailyBoosts'] = DailyBooster::take(8)->get();
        $data['teams'] = Team::all();

        // ADD THIS
        $data['teachers'] = Teacher::where('status', 1)
            ->latest()
            ->take(8)
            ->get();

        $data['upcomingExams'] = UpcomingExam::with('exam_commission')->orderBy('created_at', 'DESC')->limit('5')->get();
        $data['blogs'] = Blog::with('user')->get();
        $data['testimonials'] = FeedTestimonial::where('type', 2)->where('status', 2)->orderBy('created_at', 'DESC')->limit(10)->get();
        $data['notices'] = NoticeBoard::where('status', 1)->latest()->take(10)->get();
        $data['current_news'] = CurrentNews::where('status', 1)->latest()->take(10)->get();
        $data['features'] = InstituteFeature::where('status', 1)->get();
        $data['sliders'] = HomeSlider::where('status', 1)->get();
        $data['faqs'] = Faq::where('show_on_home', 1)->get();
        $data['studyMaterial'] = StudyMaterial::with('commission')->get();

        // Check if the popup has been shown in this session
        if (!session()->has('popup_shown')) {
            $data['popup'] = PopUp::first();
            session(['popup_shown' => true]);
        } else {
            $data['popup'] = null;
        }
        // dd($data['upcomingExams']->toArray());
        return view('front.user.index', $data);
    }

    public function noticeShow($id)
    {
        $notice = NoticeBoard::where('status', 1)->findOrFail($id);

        return view('front.user.notice_detail', compact('notice'));
    }

    public function newsShow($id)
    {
        $news = CurrentNews::where('status', 1)->findOrFail($id);

        return view('front.user.news_detail', compact('news'));
    }


    public function aboutIndex()
    {
        $data['heroSection'] = AboutPageSection::where('section_key', 'hero')->first();

        $data['whoWeAre'] = AboutPageSection::where('section_key', 'who_we_are')->first();

        $data['academicHighlights'] = AboutPageSection::where('section_key', 'academic_highlights')->first();

        $data['whyChooseUs'] = AboutPageSection::where('section_key', 'why_choose_us')->first();

        $data['commitments'] = AboutPageSection::where('section_key', 'commitments')->first();

        $data['joinUs'] = AboutPageSection::where('section_key', 'join_us')->first();

        $data['counters'] = AboutPageCounter::orderBy('sort_order')->get();

        $data['highlights'] = AboutPageHighlight::orderBy('sort_order')->get();

        $data['strengths'] = AboutPageStrength::orderBy('sort_order')->get();

        $seoTitle = $data['heroSection']->heading ?? 'About Us';

        $data['seo'] = SEO::where('page', $seoTitle)->first();
        $data['vision'] = Page::skip(5)->first();

        return view('front.user.about-us', $data);
    }

    public function termIndex()
    {
        $data['term'] = Page::skip(1)->first();
        $data['seo'] = SEO::where('page', $data['term']->heading1 . ' ' . $data['term']->heading2 ?? '')->first();
        return view('front.user.term-and-condition', $data);
    }

    public function ourTeamIndex()
    {
        $data['teams'] = Team::orderBy('created_at', 'DESC')->get();
        return view('front.user.our-team', $data);
    }

    public function privacyIndex()
    {
        $data['privacy'] = Page::skip(2)->first();
        $data['seo'] = SEO::where('page', $data['privacy']->heading1 . ' ' . $data['privacy']->heading2 ?? '')->first();
        return view('front.user.privacy-policy', $data);
    }

    public function refundCancellationIndex()
    {
        $data['refund'] = Page::skip(3)->first();
        $data['seo'] = SEO::where('page', $data['refund']->heading1 . ' ' . $data['refund']->heading2 ?? '')->first();
        return view('front.user.refunds-and-cancellation-policy', $data);
    }
    public function cookiesIndex()
    {
        $data['cookies'] = Page::skip(4)->first();
        $data['seo'] = SEO::where('page', $data['cookies']->heading1 . ' ' . $data['cookies']->heading2 ?? '')->first();
        return view('front.user.cookies-policy', $data);
    }

    public function faqIndex()
    {
        $data['faqs'] = Faq::all();
        return view('front.user.faq', $data);
    }

    public function visionIndex()
    {
        $data['vision'] = Page::skip(5)->first();
        $data['seo'] = SEO::where('page', $data['vision']->heading1 . ' ' . $data['vision']->heading2 ?? '')->first();
        return view('front.user.vision-mission', $data);
    }

    public function blogIndex()
    {
        $data['blogs'] = Blog::with('user')->get();
        return view('front.user.blog', $data);
    }

    public function blogDetailsIndex($id)
    {
        $data['blog'] = Blog::with('user')->findOrFail($id);
        $blogType = $data['blog']->type;

        // Retrieve the latest blogs of the same type, excluding the current blog
        $relatedBlogs = Blog::where('type', $blogType)
            ->where('id', '!=', $id)
            ->latest()
            ->take(3)
            ->get();

        // Check if additional blogs are needed to make up the difference
        $relatedCount = $relatedBlogs->count();

        if ($relatedCount < 3) {
            $additionalBlogs = Blog::where('id', '!=', $id) // Exclude the current blog
                ->where('type', '!=', $blogType) // Exclude blogs of the same type already fetched
                ->latest()
                ->take(3 - $relatedCount)
                ->get();

            // Merge the additional blogs into the related blogs collection
            $relatedBlogs = $relatedBlogs->merge($additionalBlogs);
        }
        $data['prevBlog'] = Blog::where('id', '<', $id)
            ->where('type', $blogType)
            ->latest('id')
            ->first();

        // Fetch the next blog
        $data['nextBlog'] = Blog::where('id', '>', $id)
            ->where('type', $blogType)
            ->oldest('id')
            ->first();
        $data['relatedBlogs'] = $relatedBlogs;


        return view('front.user.blog-detail', $data);
    }

    public function careerIndex()
    {
        return view('front.user.career');
    }

    public function careerStore(Request $request)
    {
        $request->validate([
            'position' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'mobile' => 'required|string|max:15',
            'gender' => 'required|string|max:10',
            'dob' => 'required|date',
            'experience' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'message' => 'nullable|string',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $cvPath = $request->file('cv')->store('cvs', 'public');

        Career::create([
            'position' => $request->position,
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'experience' => $request->experience,
            'qualification' => $request->qualification,
            'message' => $request->message,
            'cv' => $cvPath,
        ]);
        return redirect()->route('career')->with('success', 'Application submitted successfully!');
    }

    public function courseIndex(
        Request $request,
        $examSlug = null,
        $catSlug = null,
        $subCatSlug = null
    ) {

        $search = $request->query('search');
        $sort = $request->query('sort');

        // Resolve slugs
        $commission = null;
        $category = null;
        $subCategory = null;

        if ($examSlug) {
            $commission = ExaminationCommission::where('slug', $examSlug)->first();
        }

        if ($catSlug) {
            $category = Category::where('slug', $catSlug)->first();
        }

        if ($subCatSlug) {
            $subCategory = SubCategory::where('slug', $subCatSlug)->first();
        }

        $data['selectedCommission'] = $commission;
        $data['selectedCategory'] = $category;
        $data['selectedSubCategory'] = $subCategory;

        $data['commissions'] = ExaminationCommission::with(['categories.subCategories'])
            ->get();

        $data['subcategories'] = collect();

        if ($category) {
            $data['subcategories'] = SubCategory::where(
                'category_id',
                $category->id
            )->get();
        }

        // Course query
        $courseQuery = Course::with(['examinationCommission', 'category', 'subCategory']);

        // Filters using IDs resolved from slug
        if ($commission) {
            $courseQuery->where('examination_commission_id', $commission->id);
        }

        if ($category) {
            $courseQuery->where('category_id', $category->id);
        }

        if ($subCategory) {
            $courseQuery->where('sub_category_id', $subCategory->id);
        }

        // Search
        if ($search) {
            $courseQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('course_heading', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Sorting
        if ($sort == 'newest') {
            $courseQuery->latest();
        } elseif ($sort == 'price_low') {
            $courseQuery->orderBy('offered_price', 'asc');
        } elseif ($sort == 'price_high') {
            $courseQuery->orderBy('offered_price', 'desc');
        } else {
            // Default sorting
            $courseQuery->latest();
        }

        // Pagination
        $data['courses'] = $courseQuery
            ->paginate(9)
            ->appends($request->query());

        return view('front.user.courses', $data);
    }


    public function courseFilter(Request $request, $id)
    {
        $subject_id = $request->query('subject_id');
        $chapter_id = $request->query('chapter_id');
        $topic_id = $request->query('topic_id');
        $search = $request->query('search');

        // ===== SUBJECT FILTERS =====
        $subjectQuery = Subject::with(['chapters']);
        if ($id)
            $subjectQuery->where('sub_category_id', $id);
        $data['subjects'] = $subjectQuery->get();

        // ===== CHAPTER FILTERS =====
        $chapterQuery = Chapter::with(['subject']);
        if ($id)
            $chapterQuery->where('sub_category_id', $id);
        $data['chapters'] = $chapterQuery->get();

        // ===== TOPIC FILTERS =====
        $topicQuery = CourseTopic::with(['subject', 'chapter']);
        if ($id)
            $topicQuery->where('sub_category_id', $id);
        $data['topics'] = $topicQuery->get();

        // ===== STUDY MATERIALS =====
        $courseQuery = Course::with(['examinationCommission', 'category', 'subCategory']);

        if ($id)
            $courseQuery->where('sub_category_id', $id);

        // ---- FILTERS BASED ON MULTIPLE IDs ----
        if (!empty($subject_id)) {
            $courseQuery->whereJsonContains('subject_id', (string) $subject_id);
        }

        if (!empty($chapter_id)) {
            $courseQuery->whereJsonContains('chapter_id', (string) $chapter_id);
        }

        if (!empty($topic_id)) {
            $courseQuery->whereJsonContains('topic_id', (string) $topic_id);
        }

        // ---- SAFE SEARCH ----
        if ($search) {
            $courseQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orwhere('course_heading', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $data['courses'] = $courseQuery->paginate(10)->withQueryString();
        $data['subcat'] = $id;
        return view('front.user.courses', $data);
    }

    public function courseDetails($slug, $id)
    {
        $course = Course::where('id', $id)
            ->where('slug', $slug)
            ->withCount([
                'orders as orders_count' => function ($q) {
                    $q->where('order_status', 'PAID');
                }
            ])->firstOrFail();

        $avgRating = round($course->reviews->avg('rating'), 1);
        $totalReviews = $course->reviews->count();

        return view('front.user.course-detail', compact('course', 'avgRating', 'totalReviews'));
    }

    public function enquiryIndex()
    {
        $data['enquiries'] = DirectEnquiry::all();
        return view('front.user.enquire-now', $data);
    }

    public function enquiryStore(Request $request)
    {
        $request->validate([
            'query_for' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|string|email|max:255',
            'details' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif',
        ]);

        $data = $request->all();

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('enquiries', 'public');
        }

        DirectEnquiry::create($data);

        return redirect()->back()->with('success', 'Enquiry submitted successfully!');
    }

    public function contactUsIndex()
    {
        $data['header'] = HeaderSetting::first();

        $data['socialMedia'] = SocialMedia::first();

        $data['officeAddresses'] = OfficeAddress::where('status', 1)
            ->orderBy('sort_order')
            ->get();

        return view('front.user.contact-us', $data);
    }

    public function contactUsStore(Request $request)
    {
        $validatedData = $request->validate(

            [
                'name' => 'required|string|max:255',

                'email' => 'required|email|max:255',

                /*
                |--------------------------------------------------------------------------
                | Subject Field
                |--------------------------------------------------------------------------
                */

                'subject' => 'nullable|string|max:255',

                'message' => 'required|string|max:5000',
            ],

            /*
            |--------------------------------------------------------------------------
            | Custom Messages
            |--------------------------------------------------------------------------
            */

            [
                'name.required' =>
                    'Please enter your name.',

                'email.required' =>
                    'Please enter your email address.',

                'email.email' =>
                    'Please enter a valid email address.',

                'message.required' =>
                    'Please enter your message.',
            ]
        );

        try {

            /*
            |--------------------------------------------------------------------------
            | Save Data
            |--------------------------------------------------------------------------
            */

            ContactUs::create([

                'name' => $validatedData['name'],

                'email' => $validatedData['email'],

                /*
                |--------------------------------------------------------------------------
                | If DB column still named website
                |--------------------------------------------------------------------------
                */

                'website' => $validatedData['subject'] ?? null,

                'message' => $validatedData['message'],
            ]);

            return redirect()
                ->back()
                ->with(
                    'success',
                    'We’ll contact you soon!'
                );

        } catch (\Exception $e) {

            \Log::error(
                'Contact Form Error: ' . $e->getMessage()
            );

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Something went wrong. Please try again.'
                );
        }
    }
    public function callbackIndex()
    {
        return view('front.user.call-back');
    }

    public function callbackStore(Request $request)
    {
        $request->validate([
            'query_for' => 'required',
            'full_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|string|email|max:255',
        ]);

        CallBack::create($request->all());

        return redirect()->back()->with('success', 'Our representative will call you soon!');
    }

    public function currentAffairsIndex(Request $request)
    {
        $keyword = $request->keyword;
        $date = $request->search;
        $sort = $request->sort;

        $topics = Topic::whereHas('currentAffair', function ($q) use ($keyword, $date, $sort) {

            if ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%');
            }

            if ($date) {
                $q->whereDate('publishing_date', $date);
            }

            if ($sort == 'week') {
                $q->where('publishing_date', '>=', Carbon::now()->subWeek());
            }

            if ($sort == 'month') {
                $q->where('publishing_date', '>=', Carbon::now()->subMonth());
            }

        })->with([
                    'currentAffair' => function ($q) use ($keyword, $date, $sort) {

                        if ($keyword) {
                            $q->where('title', 'like', '%' . $keyword . '%');
                        }

                        if ($date) {
                            $q->whereDate('publishing_date', $date);
                        }

                        if ($sort == 'week') {
                            $q->where('publishing_date', '>=', Carbon::now()->subWeek());
                        }

                        if ($sort == 'month') {
                            $q->where('publishing_date', '>=', Carbon::now()->subMonth());
                        }

                        if ($sort == 'oldest') {
                            $q->orderBy('publishing_date', 'asc');
                        } else {
                            $q->orderBy('publishing_date', 'desc');
                        }

                        $q->limit(5);

                    }
                ])->paginate(5)->withQueryString();

        return view('front.user.current-affair', compact('topics'));
    }

    public function currentAffairsDetail($id)
    {
        $data['current_affair'] = CurrentAffair::findOrFail($id);

        $data['relatedAffairs'] = CurrentAffair::where('id', '!=', $id)
            ->take(2)
            ->get();

        return view('front.user.current-affair-detail', $data);
    }

    public function dailyBoostIndex()
    {
        $data['dailyBoosts'] = DailyBooster::all();
        return view('front.user.daily-booster', $data);
    }

    public function dailyBoostDetail($id)
    {
        $dailyBoost = DailyBooster::findOrFail($id);
        return view('front.user.daily-booster-detail', compact('dailyBoost'));
    }

    public function testPlannerIndex()
    {
        $data['testPlans'] = TestPlanner::latest()->get();
        return view('front.user.test-planner', $data);
    }

    public function testPlannerDetails($id)
    {
        $data['data'] = TestPlanner::findOrFail($id);
        return view('front.user.test-planner-details', $data);
    }


    public function studyMaterialIndex(
        Request $request,
        $examid = null,
        $catid = null,
        $subcat = null
    ) {

        $search = $request->query('search');
        $sort = $request->query('sort');

        // Resolve slugs
        $commission = null;
        $category = null;
        $subCategory = null;

        if ($examid) {
            $commission = ExaminationCommission::where('slug', $examid)->first();
        }

        if ($catid) {
            $category = Category::where('slug', $catid)->first();
        }

        if ($subcat) {
            $subCategory = SubCategory::where('slug', $subcat)->first();
        }

        $data['selectedCommission'] = $commission;
        $data['selectedCategory'] = $category;
        $data['selectedSubCategory'] = $subCategory;

        // Limit commission, categories, subcategories
        $data['commissions'] = ExaminationCommission::with(['categories.subCategories'])
            ->get();

        // Load subcategories when category selected
        $data['subcategories'] = collect();

        if ($category) {
            $data['subcategories'] = SubCategory::where(
                'category_id',
                $category->id
            )->get();
        }

        // Study Material Query
        $studyMaterialsQuery = StudyMaterial::with(['commission', 'category', 'subcategory']);

        // Filters using IDs resolved from slug
        if ($commission) {
            $studyMaterialsQuery->where('commission_id', $commission->id);
        }

        if ($category) {
            $studyMaterialsQuery->where('category_id', $category->id);
        }

        if ($subCategory) {
            $studyMaterialsQuery->where('sub_category_id', $subCategory->id);
        }

        // Search
        if ($search) {
            $studyMaterialsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Sorting
        if ($sort == 'newest') {
            $studyMaterialsQuery->latest();
        } elseif ($sort == 'price_low') {
            $studyMaterialsQuery->orderBy('price', 'asc');
        } elseif ($sort == 'price_high') {
            $studyMaterialsQuery->orderBy('price', 'desc');
        } else {
            // Default sorting
            $studyMaterialsQuery->latest();
        }

        // Pagination
        $data['studyMaterials'] = $studyMaterialsQuery
            ->paginate(9)
            ->appends($request->query());

        return view('front.user.study-material', $data);
    }


    public function studyMaterialAllTopics($id)
    {
        $data['topic'] = MainTopic::with('studyMaterials')->findOrFail($id);
        return view('front.user.study-material-all-list', $data);

    }
    public function studyMaterialDetails($slug, $id)
    {
        // Get the main study material
        $studyMaterial = StudyMaterial::with('sections')
            ->where('id', $id)
            ->where('slug', $slug)
            ->firstOrFail();

        // Directly use arrays (since they're stored as arrays, not JSON)
        $topicIds = $studyMaterial->topic_id ?? [];
        $chapterIds = $studyMaterial->chapter_id ?? [];
        $subjectIds = $studyMaterial->subject_id ?? [];

        $related = StudyMaterial::where('id', '!=', $studyMaterial->id)
            ->where(function ($query) use ($studyMaterial, $topicIds, $chapterIds, $subjectIds) {

                if (!empty($topicIds)) {
                    $query->where(function ($q) use ($topicIds) {
                        foreach ($topicIds as $topicId) {
                            $q->orWhereJsonContains('topic_id', (string) $topicId);
                        }
                    });
                }

                if (!empty($chapterIds)) {
                    $query->orWhere(function ($q) use ($chapterIds) {
                        foreach ($chapterIds as $chapterId) {
                            $q->orWhereJsonContains('chapter_id', (string) $chapterId);
                        }
                    });
                }

                if (!empty($subjectIds)) {
                    $query->orWhere(function ($q) use ($subjectIds) {
                        foreach ($subjectIds as $subjectId) {
                            $q->orWhereJsonContains('subject_id', (string) $subjectId);
                        }
                    });
                }

                $query->orWhere('category_id', $studyMaterial->category_id);
            })
            ->take(5)
            ->get();

        return view('front.user.study-material-details', [
            'studyMaterial' => $studyMaterial,
            'relatedMaterials' => $related,
        ]);
    }

    public function studyMaterialFilter(Request $request)
    {
        $data['topics'] = MainTopic::with('studyMaterials')->where('category_id', $request->category_id)->get();
        $data['categories'] = studyMaterialCategory::get();
        $data['filter_selected'] = $request->category_id;
        return view('front.user.study-material', $data);
    }

    public function studyMaterialSearch(Request $request)
    {
        $search = $request->search_field;
        $data['topics'] = MainTopic::with('studyMaterials')->where('name', 'like', "%" . $search . "%")->get();
        $data['categories'] = studyMaterialCategory::get();
        $data['search'] = $search;
        return view('front.user.study-material', $data);
    }

    public function syllabusIndex(Request $request, $commissionSlug = null, $categorySlug = null, $subCategorySlug = null)
    {
        // Resolve slugs
        $commission = $commissionSlug ? ExaminationCommission::where('slug', $commissionSlug)->first() : null;
        $category = $categorySlug ? Category::where('slug', $categorySlug)->first() : null;
        $subCategory = $subCategorySlug ? SubCategory::where('slug', $subCategorySlug)->first() : null;

        $selectedCommission = $commission;
        $selectedCategory = $category;
        $selectedSubCategory = $subCategory;

        // Get subjects for sidebar, optionally filtered by category/subcategory
        $subjects = Subject::when($category, fn($q) => $q->where('category_id', $category->id))
            ->when($subCategory, fn($q) => $q->where('sub_category_id', $subCategory->id))
            ->get();

        // Base query for syllabus
        $syllabusQuery = Syllabus::with(['commission', 'category', 'subcategory']);

        if ($commission) {
            $syllabusQuery->where('commission_id', $commission->id);
        }
        if ($category) {
            $syllabusQuery->where('category_id', $category->id);
        }
        if ($subCategory) {
            $syllabusQuery->where('sub_category_id', $subCategory->id);
        }

        // Optional filter by subject (from query string)
        if ($request->has('subject') && $request->subject != null) {
            $syllabusQuery->where('subject_id', $request->subject);
        }

        $syllabus = $syllabusQuery->get();

        return view('front.syllabus', compact(
            'subjects',
            'syllabus',
            'selectedCommission',
            'selectedCategory',
            'selectedSubCategory'
        ));
    }


    public function upcomingExamsIndex()
    {
        $data['upcomingExams'] = UpcomingExam::with('exam_commission')->orderBy('created_at', 'DESC')->get();
        return view('front.user.upcoming-exams', $data);
    }

    public function netiCornerIndex()
    {
        $data['testimonials'] = FeedTestimonial::where('type', 2)->orderBy('created_at', 'DESC')->get();
        return view('front.user.neti-corner', $data);
    }

    public function feedBackIndex()
    {
        return view('front.user.feedback-and-testinomial');
    }

    public function feedBackStore(Request $request)
    {
        $validatedData = $request->validate(

            [
                'type' => 'required|integer|in:1,2',

                'username' => 'required|string|max:255',

                'designation' => 'required|string|max:100',

                'email' => 'required|email|max:255',

                'number' => 'required|digits_between:10,15',

                'message' => 'nullable|string|max:2000',

                /*
                |--------------------------------------------------------------------------
                | Rating required only for testimonial
                |--------------------------------------------------------------------------
                */

                'rating' => 'required_if:type,2|nullable|integer|min:1|max:5',

                /*
                |--------------------------------------------------------------------------
                | Photo validation
                |--------------------------------------------------------------------------
                */

                'photo' => [
                    'required',
                    'image',
                    'mimes:jpeg,jpg,png,gif,webp',
                    'max:2048'
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Custom Error Messages
            |--------------------------------------------------------------------------
            */

            [
                'type.required' => 'Please select feedback type.',

                'username.required' => 'Please enter your name.',

                'email.required' => 'Please enter email address.',

                'email.email' => 'Please enter a valid email address.',

                'number.required' => 'Please enter mobile number.',

                'number.digits_between' =>
                    'Mobile number must be between 10 and 15 digits.',

                'rating.required_if' =>
                    'Please give rating for testimonial.',

                'photo.required' => 'Please upload a photo.',

                'photo.image' =>
                    'Uploaded file must be an image.',

                'photo.mimes' =>
                    'Photo must be jpeg, jpg, png, gif or webp format.',

                'photo.max' =>
                    'Photo size must not exceed 2MB.',
            ]
        );

        try {

            /*
            |--------------------------------------------------------------------------
            | Upload Photo
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('photo')) {

                $file = $request->file('photo');

                $filename =
                    time() . '_' .
                    preg_replace(
                        '/[^A-Za-z0-9\.\-_]/',
                        '',
                        $file->getClientOriginalName()
                    );

                $destinationPath =
                    public_path('uploads/feed-photos');

                /*
                |--------------------------------------------------------------------------
                | Create folder if not exists
                |--------------------------------------------------------------------------
                */

                if (!file_exists($destinationPath)) {

                    mkdir($destinationPath, 0777, true);
                }

                $file->move($destinationPath, $filename);

                $validatedData['photo'] = $filename;
            }

            /*
            |--------------------------------------------------------------------------
            | Save Data
            |--------------------------------------------------------------------------
            */

            FeedTestimonial::create($validatedData);

            return back()->with(
                'success',
                'Feedback & Testimonial submitted successfully!'
            );

        } catch (\Exception $e) {

            \Log::error(
                'Feedback Upload Error: ' . $e->getMessage()
            );

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Photo upload failed. Please try again.'
                );
        }
    }

    public function batchesIndex()
    {
        $data['batches'] = BatchProgramme::paginate(10);
        $data['batchMarquees'] = \App\Models\BatchMarquee::where('status', 1)
            ->latest()
            ->get();

        return view('front.user.batches-and-online-programme', $data);
    }

    public function batchDetail($id)
    {
        $batch = BatchProgramme::where('id', $id)
            ->firstOrFail();

        return view('front.user.batch-detail', compact('batch'));
    }

    public function pyqPapers($examid = null, $catid = null, $subcat = null)
    {
        // Resolve slugs
        $commission = $examid ? ExaminationCommission::where('slug', $examid)->first() : null;
        $category = $catid ? Category::where('slug', $catid)->first() : null;
        $subCategory = $subcat ? SubCategory::where('slug', $subcat)->first() : null;

        $data['selectedCommission'] = $commission;
        $data['selectedCategory'] = $category;
        $data['selectedSubCategory'] = $subCategory;

        $data['papers'] = Test::where('paper_type', 1)

            ->when($commission, function ($query) use ($commission) {
                $query->where('competitive_commission_id', $commission->id);
            })

            ->when($category, function ($query) use ($category) {
                $query->where('exam_category_id', $category->id);
            })

            ->when($subCategory, function ($query) use ($subCategory) {
                $query->where('exam_subcategory_id', $subCategory->id);
            })

            ->get();

        $data['subjects'] = Subject::when($subCategory, function ($query) use ($subCategory) {
            $query->where('sub_category_id', $subCategory->id);
        })->get();

        $data['pyq_content'] = PyqContent::query()
            ->when($commission, fn($q) => $q->where('commission_id', $commission->id))
            ->when($category, fn($q) => $q->where('category_id', $category->id))
            ->when($subCategory, fn($q) => $q->where('sub_category_id', $subCategory->id))
            ->first();

        return view('front.pyq-papers', $data);
    }

    public function testseriesIndex(
        Request $request,
        $examSlug = null,
        $catSlug = null,
        $subCatSlug = null
    ) {

        $search = $request->search;
        $sort = $request->sort;

        // Resolve slugs
        $commission = null;
        $category = null;
        $subCategory = null;

        if ($examSlug) {
            $commission = ExaminationCommission::where('slug', $examSlug)->first();
        }

        if ($catSlug) {
            $category = Category::where('slug', $catSlug)->first();
        }

        if ($subCatSlug) {
            $subCategory = SubCategory::where('slug', $subCatSlug)->first();
        }

        $data['selectedCommission'] = $commission;
        $data['selectedCategory'] = $category;
        $data['selectedSubCategory'] = $subCategory;

        $data['commissions'] = ExaminationCommission::with(['categories.subCategories'])
            ->get();

        $data['subcategories'] = collect();

        if ($category) {
            $data['subcategories'] = SubCategory::where(
                'category_id',
                $category->id
            )->get();
        }

        $testSeriesQuery = TestSeries::with(
            'testseries',
            'commission',
            'category',
            'subcategory'
        );

        // Filters using IDs resolved from slug
        if ($commission) {
            $testSeriesQuery->where('exam_com_id', $commission->id);
        }

        if ($category) {
            $testSeriesQuery->where('category_id', $category->id);
        }

        if ($subCategory) {
            $testSeriesQuery->where('sub_category_id', $subCategory->id);
        }

        // Search
        if ($search) {
            $testSeriesQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Sorting
        if ($sort == 'newest') {
            $testSeriesQuery->latest();
        } elseif ($sort == 'price_low') {
            $testSeriesQuery->orderBy('price', 'asc');
        } elseif ($sort == 'price_high') {
            $testSeriesQuery->orderBy('price', 'desc');
        } else {
            $testSeriesQuery->latest();
        }

        $data['testPackages'] = $testSeriesQuery
            ->paginate(9)
            ->appends($request->query());

        return view('front.user.test-series', $data);
    }

    public function testseriesDetail($slug, $id)
    {

        $testseries = TestSeries::where('id', $id)
            ->where('slug', $slug)->withCount([
                    'orders as orders_count' => function ($q) {
                        $q->where('order_status', 'PAID');
                    }
                ])->first();

        $data['testseries'] = $testseries;
        $data['relatedtestseries'] = TestSeries::where('exam_com_id', $testseries->exam_com_id)->where('id', '!=', $testseries->id)->get();
        // dd($testseries->toArray());
        return view('front.user.test-series-details', $data);
    }

    public function subjectPapers($id)
    {
        $data['subject'] = Subject::findOrFail($id);
        $data['papers'] = Test::where('paper_type', 1)->where('subject_id', $id)->get();
        $data['pyq_content'] = PyqContent::where('subject_id', $id)->first();
        return view('front.pyq-subjects', $data);
    }
    public function sendotopstudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|digits:10',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }
        $mobile_number = $request->mobile_number;

        $otp = substr(str_shuffle("0123456789"), 0, 4);
        $teacher = UserMobiileVerification::where('mobile_number', $request->mobile_number)->first();
        UserMobiileVerification::updateOrInsert(['mobile_number' => $mobile_number], ['mobile_number' => $mobile_number, 'otp' => $otp]);
        $message = "$otp is the One Time Password(OTP) to verify your MOB number at Web Mingo, This OTP is Usable only once and is valid for 10 min,PLS DO NOT SHARE THE OTP WITH ANYONE";
        $dlt_id = '1307161465983326774';
        $request_parameter = array(
            'authkey' => '133780AWLy8zZpC690b124aP1',
            'mobiles' => $mobile_number,
            'message' => urlencode($message),
            'sender' => 'WMINGO',
            'route' => '4',
            'country' => '91',
            'unicode' => '1',
        );
        $url = "http://sms.webmingo.in/api/sendhttp.php?";
        foreach ($request_parameter as $key => $val) {
            $url .= $key . '=' . $val . '&';
        }
        $url = $url . 'DLT_TE_ID=' . $dlt_id;
        $url = rtrim($url, "&");
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //get response
            $output = curl_exec($ch);
            curl_close($ch);
            return response()->json([
                'success' => true,
                'message' => 'Otp Successfully Send on Your mobile number!',
            ]);
            // return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function verifymobilenumberstudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|digits:10',
            'otp' => 'required',
        ], [
            'otp.exists' => 'Enter Correct Otp'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }

        $student = UserMobiileVerification::where('mobile_number', $request->mobile_number)
            ->where('otp', $request->otp)
            ->first();

        if (!$student) {
            return response()->json([
                'profile' => 0,
                'success' => false,
                'message' => 'Incorrect Otp',
            ]);
        }

        $student->update(['verified' => 'yes']);

        $student1 = User::updateOrCreate(
            [
                'mobile' => $request->mobile_number,
                'type' => 'student'
            ],
            [
                'mobile' => $request->mobile_number,
            ]
        );

        Auth::login($student1);

        $profile = (!empty($student1->email) && $student1->type == 'student') ? 1 : 0;

        \LogActivity::addToLog('Login', $student1);

        return response()->json([
            'success' => true,
            'profile' => $profile,
            'message' => 'Successfully Verified OTP',
            'redirect_url' => session('url.intended'),
        ]);
    }

    public function storeHomeEnquiry(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email_address' => 'nullable|email',
            'mobile_number' => 'required|digits_between:8,15',
            'message' => 'nullable|string',
        ]);

        // // Verify reCAPTCHA
        // $response = Http::asForm()->post(
        //     'https://www.google.com/recaptcha/api/siteverify',
        //     [
        //         'secret' => config('services.recaptcha.secret'),
        //         'response' => $request->input('g-recaptcha-response'),
        //         'remoteip' => $request->ip(),
        //     ]
        // );

        // if (!data_get($response->json(), 'success')) {
        //     return back()->withErrors(['captcha' => 'Captcha verification failed'])->withInput();
        // }

        HomeEnquiry::create([
            'full_name' => $request->full_name,
            'email_address' => $request->email_address,
            'country_code' => $request->country_code,
            'mobile_number' => $request->mobile_number,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Enquiry submitted successfully!');
    }

    public function testDownload($id)
    {
        set_time_limit(120);
        ini_set('memory_limit', '512M');

        $paper = Test::with([
            'category:id,name',
            'subcategory:id,name',
            'commission:id,name',
            'subject:id,name',
            'topic:id,name',
            'chapter:id,name',
            'testDetails.question'
        ])->findOrFail($id);


        $logoPath = public_path('images/Neti-logo.png');
        $logoBase64 = null;
        if (file_exists($logoPath)) {
            $type = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($logoPath));
        }

        $html = view('test-paper.pdf-view', compact('paper', 'logoBase64'))->render();

        $footerHtml = '
    <div style="width:100%; font-family: \'notodevanagari\', sans-serif; font-size:8px; color:#718096;
                padding:4px 30px 0 30px; border-top:1px solid #e2e8f0; display:flex; justify-content:space-between;">
        <span>© ' . date('Y') . ' ' . config('app.name') . '. All Rights Reserved.</span>
        <span>Confidential Assessment Document</span>
    </div>';

        $pdf = Browsershot::html($html)
            ->format('A4')
            ->margins(10, 12, 22, 12)
            ->showBackground()
            ->showBrowserHeaderAndFooter()
            ->hideHeader()
            ->footerHtml($footerHtml)
            ->pdf();

        return response($pdf, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $paper->name . '.pdf"');

    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
