<?php

namespace App\Http\Controllers;

use App\Models\BatchProgramme;
use App\Models\Blog;
use App\Models\Chapter;
use App\Models\Syllabus;
use App\Models\Test;
use App\Models\CallBack;
use App\Models\Category;
use App\Models\TestSeries;
use App\Models\UserMobiileVerification;
use App\Models\User;
use App\Models\Career;
use App\Models\StudyMaterialCategory;
use App\Models\MainTopic;
use App\Models\ContactUs;
use App\Models\Course;
use App\Models\CurrentAffair;
use App\Models\DailyBooster;
use App\Models\PyqContent;
use App\Models\DirectEnquiry;
use App\Models\Faq;
use App\Models\HeaderSetting;
use App\Models\SubCategory;
use App\Models\FeedTestimonial;
use App\Models\Page;
use App\Models\SEO;
use App\Models\StudyMaterial;
use App\Models\Subject;
use App\Models\SocialMedia;
use App\Models\Team;
use App\Models\TestPlanner;
use App\Models\Topic;
use App\Models\CourseTopic;
use App\Models\UpcomingExam;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogActivity;

class FrontController extends Controller
{
    public function aboutIndex()
    {
        $data['about'] = Page::first();
        $data['faqs'] = Faq::all();
        $data['seo'] = SEO::where('page', $data['about']->heading1 . ' ' . $data['about']->heading2 ?? '')->first();
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

    public function courseIndex()
    {
        $data['courses'] = Course::with('examinationCommission', 'category', 'subCategory')->get();
        return view('front.user.courses', $data);
    }

    public function courseDetails($id)
    {
        $data['course'] = Course::findOrFail($id);
        // dd($data['course']->toArray());
        return view('front.user.course-detail', $data);
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
        return view('front.user.contact-us', $data);
    }

    public function contactUsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'website' => 'nullable|url|max:255',
            'message' => 'required|string',
        ]);

        ContactUs::create($request->all());

        return redirect()->back()->with('success', 'We`ll contact you soon!');
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

    public function currentAffairsIndex()
    {
        $data['topics'] = Topic::with('currentAffair')->get();
        return view('front.user.current-affair', $data);
    }

    public function currentAffairsDetail($id)
    {
        $data['current_affair'] = CurrentAffair::findOrFail($id);
        $relatedBlogs = Blog::where('id', '!=', $id)
            ->latest()
            ->take(3)
            ->get();

        // Check if additional blogs are needed to make up the difference
        $relatedCount = $relatedBlogs->count();

        if ($relatedCount < 3) {
            $additionalBlogs = Blog::latest()
                ->take(3 - $relatedCount)
                ->get();
            $relatedBlogs = $relatedBlogs->merge($additionalBlogs);
        }
        $data['relatedAffairs'] = CurrentAffair::where('id', '!=', $id)
            ->take(2)
            ->get();
        $data['relatedBlogs'] = $relatedBlogs;
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
        $data['testPlans'] = TestPlanner::all();
        return view('front.user.test-planner', $data);
    }

    public function testPlannerDetails($id)
    {
        $data['data'] = TestPlanner::findOrFail($id);
        return view('front.user.test-planner-details', $data);
    }
    public function studyMaterialIndex(Request $request, $examid = null, $catid = null, $subcat = null)
    {
        $subject_id = $request->query('subject_id');
        $chapter_id = $request->query('chapter_id');
        $topic_id = $request->query('topic_id');
        $search = $request->query('search');

        // ===== SUBJECT FILTERS =====
        $subjectQuery = Subject::with(['chapters']);
        if ($examid)
            $subjectQuery->where('exam_com_id', $examid);
        if ($catid)
            $subjectQuery->where('category_id', $catid);
        if ($subcat)
            $subjectQuery->where('sub_category_id', $subcat);
        $data['subjects'] = $subjectQuery->get();

        // ===== CHAPTER FILTERS =====
        $chapterQuery = Chapter::with(['subject']);
        if ($examid)
            $chapterQuery->where('exam_com_id', $examid);
        if ($catid)
            $chapterQuery->where('category_id', $catid);
        if ($subcat)
            $chapterQuery->where('sub_category_id', $subcat);
        $data['chapters'] = $chapterQuery->get();

        // ===== TOPIC FILTERS =====
        $topicQuery = CourseTopic::with(['subject', 'chapter']);
        if ($examid)
            $topicQuery->where('exam_com_id', $examid);
        if ($catid)
            $topicQuery->where('category_id', $catid);
        if ($subcat)
            $topicQuery->where('sub_category_id', $subcat);
        $data['topics'] = $topicQuery->get();

        // ===== STUDY MATERIALS =====
        $studyMaterialsQuery = StudyMaterial::with(['commission', 'category', 'subcategory']);

        if ($examid)
            $studyMaterialsQuery->where('commission_id', $examid);
        if ($catid)
            $studyMaterialsQuery->where('category_id', $catid);
        if ($subcat)
            $studyMaterialsQuery->where('sub_category_id', $subcat);

        // ---- FILTERS BASED ON MULTIPLE IDs ----
        if (!empty($subject_id)) {
            $studyMaterialsQuery->whereJsonContains('subject_id', (string) $subject_id);
        }

        if (!empty($chapter_id)) {
            $studyMaterialsQuery->whereJsonContains('chapter_id', (string) $chapter_id);
        }

        if (!empty($topic_id)) {
            $studyMaterialsQuery->whereJsonContains('topic_id', (string) $topic_id);
        }

        // ---- SAFE SEARCH ----
        if ($search) {
            $studyMaterialsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $data['studyMaterials'] = $studyMaterialsQuery->paginate(10)->withQueryString();

        // Keep the route parameters for pagination and filters
        $data['examid'] = $examid;
        $data['catid'] = $catid;
        $data['subcat'] = $subcat;

        return view('front.user.study-material', $data);
    }


    public function studyMaterialAllTopics($id)
    {
        $data['topic'] = MainTopic::with('studyMaterials')->findOrFail($id);
        return view('front.user.study-material-all-list', $data);

    }
    public function studyMaterialDetails($id)
    {
        // Get the main study material
        $studyMaterial = StudyMaterial::with('sections')->findOrFail($id);

        // Directly use arrays (since they're stored as arrays, not JSON)
        $topicIds = $studyMaterial->topic_id ?? [];
        $chapterIds = $studyMaterial->chapter_id ?? [];
        $subjectIds = $studyMaterial->subject_id ?? [];

        $related = StudyMaterial::where('id', '!=', $studyMaterial->id)
            ->where(function ($query) use ($studyMaterial, $topicIds, $chapterIds, $subjectIds) {

                // Match by topics
                if (!empty($topicIds)) {
                    $query->where(function ($q) use ($topicIds) {
                        foreach ($topicIds as $topicId) {
                            $q->orWhereJsonContains('topic_id', (string) $topicId);
                        }
                    });
                }

                // Match by chapters
                if (!empty($chapterIds)) {
                    $query->orWhere(function ($q) use ($chapterIds) {
                        foreach ($chapterIds as $chapterId) {
                            $q->orWhereJsonContains('chapter_id', (string) $chapterId);
                        }
                    });
                }

                // Match by subjects
                if (!empty($subjectIds)) {
                    $query->orWhere(function ($q) use ($subjectIds) {
                        foreach ($subjectIds as $subjectId) {
                            $q->orWhereJsonContains('subject_id', (string) $subjectId);
                        }
                    });
                }

                // Fallback: Same category
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

    public function syllabusIndex($commissionId = null, $categoryId = null, $subCategoryId = null, Request $request)
    {
        // Get subjects for sidebar, optionally filtered by category/subcategory
        $subjects = Subject::when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->when($subCategoryId, fn($q) => $q->where('sub_category_id', $subCategoryId))
            ->get();

        // Base query for syllabus
        $syllabusQuery = Syllabus::with(['commission', 'category', 'subcategory']);

        if ($commissionId) {
            $syllabusQuery->where('commission_id', $commissionId);
        }
        if ($categoryId) {
            $syllabusQuery->where('category_id', $categoryId);
        }
        if ($subCategoryId) {
            $syllabusQuery->where('sub_category_id', $subCategoryId);
        }

        // Optional filter by subject (from query string)
        if ($request->has('subject') && $request->subject != null) {
            $syllabusQuery->where('subject_id', $request->subject);
        }

        $syllabus = $syllabusQuery->get();

        return view('front.syllabus', compact('subjects', 'syllabus', 'commissionId', 'categoryId', 'subCategoryId'));
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
        $validatedData = $request->validate([
            'type' => 'required|integer',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'number' => 'required|string|max:20',
            'message' => 'nullable|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handle the photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/feed-photos'), $filename);
            $validatedData['photo'] = $filename;
        }

        // Create a new Feedback instance and save the data
        FeedTestimonial::create($validatedData);
        return redirect()->back()->with('success', 'Feedback & Testimonial submitted successfully!');
    }

    public function batchesIndex()
    {
        $data['batches'] = BatchProgramme::all();
        return view('front.user.batches-and-online-programme', $data);
    }

    public function pyqPapers($examid, $catid, $subcat)
    {
        $data['subcat'] = SubCategory::findOrFail($subcat);
        $data['papers'] = Test::where('paper_type', 1)->where('competitive_commission_id', $examid)->where('exam_category_id', $catid)->where('exam_subcategory_id', $subcat)->get();
        $data['subjects'] = Subject::where('sub_category_id', $subcat)->get();
        $data['pyq_content'] = PyqContent::where('commission_id', $examid)->where('category_id', $catid)->where('sub_category_id', $subcat)->first();
        // dd($data['papers']->toArray());
        return view('front.pyq-papers', $data);
    }

    public function testseries($examid, $catid, $subcat)
    {
        $data['subcat'] = SubCategory::findOrFail($subcat);
        $data['categories'] = Category::where('exam_com_id', $examid)->get();
        $data['testseries'] = TestSeries::where('exam_com_id', $examid)->where('category_id', $catid)->where('sub_category_id', $subcat)->paginate(10);
        return view('front.test-series', $data);
    }
    public function testseriesFilter(Request $request)
    {
        $data['subcat'] = array();
        $data['testseries'] = TestSeries::where('category_id', $request->category_id)->paginate(10);
        $data['categories'] = Category::get();
        $data['filter_selected'] = $request->category_id;
        return view('front.test-series', $data);
    }
    public function testseriesSearch(Request $request)
    {
        $search = $request->search_field;
        $data['subcat'] = array();
        $data['testseries'] = TestSeries::where('title', 'like', "%" . $search . "%")->paginate(10);
        $data['categories'] = Category::get();
        $data['search'] = $search;
        return view('front.test-series', $data);
    }
    public function testseriesDetail($slug)
    {
        $testseries = TestSeries::where('slug', $slug)->first();
        $data['testseries'] = $testseries;
        $data['relatedtestseries'] = TestSeries::where('exam_com_id', $testseries->exam_com_id)->where('id', '!=', $testseries->id)->get();
        return view('front.test-series-detail', $data);
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
            'authkey' => '133780AZGqc6gKWfh63da1812P1',
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
        $student = UserMobiileVerification::where('mobile_number', $request->mobile_number)->where('otp', $request->otp)->first();
        if ($student) {
            $student->update(['verified' => 'yes']);
            $student1 = User::updateOrCreate(['mobile' => $request->mobile_number, 'type' => 'student'], [
                'mobile' => $request->mobile_number,
            ]);
            Auth::login($student1);
            $profile = ($student1->email != '' && $student1->type == 'student') ? 1 : 0;
            \LogActivity::addToLog('Login', $student1);
            return response()->json([
                'profile' => $profile,
                'success' => true,
                'message' => 'Succesfully Verified Otp',
            ]);
        } else {
            return response()->json([
                'profile' => 0,
                'success' => false,
                'message' => 'Incorrect Otp',
            ]);
        }


    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
