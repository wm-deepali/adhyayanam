<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Banner;
use App\Models\BatchProgramme;
use App\Models\Feature;
use App\Models\Marquee;
use App\Models\StudyMaterialCategory;
use App\Models\MainTopic;
use App\Models\StudyMaterialSection;
use App\Models\TestSeriesDetail;
use App\Models\ProgrammeFeature;
use App\Models\PopUp;
use App\Models\CourseTopic;
use App\Models\CallBack;
use App\Models\Career;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\PyqContent;
use App\Models\FeedTestimonial;
use App\Models\ContactUs;
use App\Models\Course;
use App\Models\CurrentAffair;
use App\Models\DailyBooster;
use App\Models\DirectEnquiry;
use App\Models\ExaminationCommission;
use App\Models\HeaderSetting;
use App\Models\SocialMedia;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Question;
use App\Models\QuestionBank;
use App\Models\QuestionDetail;
use App\Models\SEO;
use App\Models\StudyMaterial;
use App\Models\SubCategory;
use App\Models\Subject;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use App\Models\Team;
use App\Models\TestPlanner;
use App\Models\TestSeries;
use App\Models\Topic;
use App\Models\Teacher;
use App\Models\UpcomingExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Imports\QuestionsImport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PHPHtmlParser\Dom;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\HeadingRowImport;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\WalletTransaction;

class ContentManagementController extends Controller
{
    public function aboutUs()
    {
        $data['about'] = Page::first();
        $data['faqs'] = Faq::all();
        return view('content-management.about', $data);
    }
    public function aboutStore(Request $request)
    {
        $request->validate([
            'heading1' => 'required|string|max:255',
            'description1' => 'required|string',
            'youtube_url' => 'nullable|url',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only(['heading1', 'description1', 'youtube_url']);

        if ($request->hasFile('image1')) {
            $imagePath = $request->file('image1')->store('images', 'public');
            $data['image1'] = $imagePath;
        }
        Page::updateOrCreate(
            ['id' => 1], // Condition to match existing record
            $data
        );
        return redirect()->route('cm.about')->with('success', 'About us updated successfully!');

    }
    public function termAndCondition()
    {
        $data['term'] = Page::skip(1)->first();
        return view('content-management.term-and-condition', $data);
    }

    public function termStore(Request $request)
    {
        $request->validate([
            'heading1' => 'required|string|max:255',
            'description1' => 'required|string',
        ]);

        $data = $request->only(['heading1', 'description1']);
        Page::updateOrCreate(
            ['id' => 2], // Condition to match existing record
            $data
        );
        return redirect()->route('cm.term.condition')->with('success', 'Term and Conditions updated successfully!');
    }

    public function privacyPolicies()
    {
        $data['privacy'] = Page::skip(2)->first();
        return view('content-management.privacy-policies', $data);
    }

    public function privacyStore(Request $request)
    {
        $request->validate([
            'heading1' => 'required|string|max:255',
            'description1' => 'required|string',
        ]);

        $data = $request->only(['heading1', 'description1']);
        Page::updateOrCreate(
            ['id' => 3], // Condition to match existing record
            $data
        );
        return redirect()->route('cm.privacy.policy')->with('success', 'Privacy Policy updated successfully!');
    }
    public function refundCancellation()
    {
        $data['refund'] = Page::skip(3)->first();
        return view('content-management.refund-cancellation', $data);
    }

    public function refundCancellationStore(Request $request)
    {
        $request->validate([
            'heading1' => 'required|string|max:255',
            'description1' => 'required|string',
        ]);

        $data = $request->only(['heading1', 'description1']);
        Page::updateOrCreate(
            ['id' => 4], // Condition to match existing record
            $data
        );
        return redirect()->route('cm.refund.cancellation')->with('success', 'Refunds and Cancellation Policy updated successfully!');
    }
    public function cookiesPolicies()
    {
        $data['cookies'] = Page::skip(4)->first();
        return view('content-management.cookies-policies', $data);
    }
    public function cookiesPolicyStore(Request $request)
    {
        $request->validate([
            'heading1' => 'required|string|max:255',
            'description1' => 'required|string',
        ]);

        $data = $request->only(['heading1', 'description1']);
        Page::updateOrCreate(
            ['id' => 5], // Condition to match existing record
            $data
        );
        return redirect()->route('cm.cookies.policies')->with('success', 'Cookies Policy updated successfully!');
    }
    public function career(Request $request)
    {
        if ($request->ajax()) {
            $data = Career::orderBy('created_at', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="column_checkbox career_checkbox" id="' . $row->id . '" name="career_checkbox[]" />';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('cv', function ($row) {
                    $linkUrl = asset("storage/" . $row->cv);
                    $link = '<a href="' . $linkUrl . '" class="btn btn-primary" download>Download</a>';
                    return $link;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<form action="' . route('cm.career.delete', $row->id) . '" method="POST" style="display:inline">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>';
                    return $actionBtn;
                })
                ->rawColumns(['checkbox', 'created_at', 'cv', 'action'])
                ->make(true);
        }
        return view('content-management.career');
        //}
        //$data['careers'] = Career::orderBy('created_at','DESC')->get();
        //return view('content-management.career',$data);
    }
    public function careerDelete($id)
    {
        $career = Career::findOrFail($id);
        $career->delete();
        return redirect()->route('cm.career')->with('success', 'Career deleted successfully!');
    }
    public function blogArticles()
    {
        $data['blogs'] = Blog::all();
        return view('content-management.blog-articles', $data);
    }
    public function blogStore(Request $request)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'description' => 'required|string',
            'type' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Blog::create($data);

        return redirect()->route('cm.blog.articles')->with('success', 'Blog created successfully!');
    }
    public function blogDelete($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return redirect()->route('cm.blog.articles')->with('success', 'Blog deleted successfully!');
    }
    public function ourTeam()
    {
        $data['teams'] = Team::orderBy('created_at', 'DESC')->get();
        return view('content-management.our-team', $data);
    }

    public function ourTeamStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'experience' => 'nullable|string',
            'education' => 'nullable|string|max:255',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        }

        Team::create($data);

        return redirect()->back()->with('success', 'Team Member created successfully!');

    }

    public function ourTeamDelete($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();
        return redirect()->back()->with('success', 'Team Member deleted successfully!');
    }

    public function ourTeamEdit($id)
    {
        $data['team'] = Team::findOrFail($id);
        return view('content-management.ajax.edit-team', $data);
    }

    public function ourTeamUpdate(Request $request)
    {
        $team = Team::findOrFail($request->id);

        // Update the team member's details
        $team->name = $request->name;
        $team->designation = $request->designation;
        $team->experience = $request->experience;
        $team->education = $request->education;

        // Handle the file upload
        if ($request->hasFile('profile_image')) {
            // Delete the old profile image if exists
            if ($team->profile_image) {
                Storage::delete('public/profiles/' . $team->profile_image);
            }

            // Store the new profile image
            $imagePath = $request->file('profile_image')->store('profiles', 'public');
            $team->profile_image = $imagePath;
        }

        // Save the updates
        $team->save();

        // Redirect back with a success message
        return redirect()->route('cm.our.team')->with('success', 'Team member updated successfully!');
    }
    public function visionMission()
    {
        $data['vision'] = Page::skip(5)->first();
        return view('content-management.vision-mission', $data);
    }
    public function visionStore(Request $request)
    {
        $request->validate([
            'heading1' => 'required|string|max:255',
            'heading2' => 'required|string|max:255',
            'description1' => 'required|string',
            'description2' => 'required|string',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
        $data = $request->only(['heading1', 'description1', 'heading2', 'description2']);

        if ($request->hasFile('image1')) {
            $imagePath1 = $request->file('image1')->store('images', 'public');
            $data['image1'] = $imagePath1;
        }

        if ($request->hasFile('image2')) {
            $imagePath2 = $request->file('image2')->store('images', 'public');
            $data['image2'] = $imagePath2;
        }
        Page::updateOrCreate(
            ['id' => 6], // Condition to match existing record
            $data
        );
        return redirect()->route('cm.vision.mission')->with('success', 'Vision and Mission updated successfully!');
    }
    public function faq()
    {
        $data['faqs'] = Faq::all();
        return view('content-management.faq', $data);
    }

    public function faqStore(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'type' => 'nullable|string',
        ]);

        Faq::create($request->all());

        return redirect()->route('cm.faq')->with('success', 'FAQ added successfully!');
    }

    public function seoIndex()
    {
        $seos = SEO::all();
        return view('seo.index', compact('seos'));
    }

    public function seoCreate()
    {
        $pages = Page::all();
        return view('seo.create', compact('pages'));
    }

    public function seoStore(Request $request)
    {
        $request->validate([
            'page' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'keywords' => 'required|string|max:255',
            'canonical' => 'required|url|max:255',
        ]);

        SEO::create($request->all());

        return redirect()->route('seo.index')->with('success', 'SEO details saved successfully!');
    }

    public function examinationIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = ExaminationCommission::all();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="column_checkbox career_checkbox" id="' . $row->id . '" name="career_checkbox[]" />';
                })

                ->addColumn('meta_title', function ($row) {
                    return $row->meta_title ?? '';
                })
                ->addColumn('meta_description', function ($row) {
                    return $row->meta_description ?? '';
                })
                ->addColumn('meta_keyword', function ($row) {
                    return $row->meta_keyword ?? '';
                })
                ->addColumn('canonical_url', function ($row) {
                    return $row->canonical_url ?? '';
                })
                ->addColumn('alt_tag', function ($row) {
                    return $row->alt_tag ?? '';
                })
                ->addColumn('image', function ($row) {
                    $image = '<img style="width: 35px" src="' . asset('storage/' . $row->image) . '" alt="">';
                    return $image;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        $status = '<span class="badge badge-success">Active</span>';
                    } else {
                        $status = '<span class="badge badge-secondary">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('cm.exam.edit', $row->id);
                    $actionBtn = ' <a href="' . $editUrl . '" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-file"></i></a>
                            <form action="' . route('cm.exam.destroy', $row->id) . '" method="POST" style="display:inline">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                            </form>';
                    return $actionBtn;
                })
                ->rawColumns(['checkbox', 'image', 'status', 'meta_title', 'meta_description', 'meta_keyword', 'canonical_url', 'alt_tag', 'action'])
                ->make(true);
        }
        return view('content-management.exam-commission');
    }

    public function examinationCreate()
    {
        return view('content-management.ajax.create-exam-com');
    }

    public function examinationStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:512',
            'canonical_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'alt_tag' => 'nullable|string|max:255',
            'status' => 'required|integer|in:0,1',
        ]);

        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('examination_commission_images', 'public');
        }

        // Create the examination_commission record
        ExaminationCommission::create([
            'name' => $request->name,
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'canonical_url' => $request->canonical_url,
            'image' => $imagePath,
            'alt_tag' => $request->alt_tag,
            'status' => $request->status,
        ]);
        return redirect()->back()->with('success', 'Examination Commission added successfully.');
    }
    public function examinationDelete($id)
    {
        $exam = ExaminationCommission::findOrFail($id);
        $exam->delete();
        return redirect()->back()->with('success', 'Examination Commission deleted successfully!');
    }
    public function examinationEdit($id)
    {
        $data['exam'] = ExaminationCommission::findOrFail($id);
        return view('content-management.ajax.edit-exam-commission', $data);
    }

    public function examinationUpdate(Request $request)
    {
        $id = $request->id;
        $exam = ExaminationCommission::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:512',
            'canonical_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alt_tag' => 'nullable|string|max:255',
            'status' => 'required|boolean'
        ]);

        // Handle the file upload if an image is present
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($exam->image && \Storage::exists('public/examination_commission_images/' . $exam->image)) {
                \Storage::delete('public/examination_commission_images' . $exam->image);
            }
            // Store the new image
            $exam->image = $request->image->store('uploads', 'public');
        }

        // Update the model with the request data
        $exam->name = $request->name;
        $exam->description = $request->description;
        $exam->meta_title = $request->meta_title;
        $exam->meta_keyword = $request->meta_keyword;
        $exam->meta_description = $request->meta_description;
        $exam->canonical_url = $request->canonical_url;
        $exam->alt_tag = $request->alt_tag;
        $exam->status = $request->status;

        // Save the updated model
        $exam->save();

        // Redirect back with a success message
        return redirect()->route('cm.exam')->with('success', 'Examination updated successfully!');

    }

    public function categoryIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::with('examinationCommission')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="column_checkbox career_checkbox" id="' . $row->id . '" name="career_checkbox[]" />';
                })

                ->addColumn('commission', function ($row) {
                    return $row->examinationCommission->name ?? '';
                })
                ->addColumn('meta_title', function ($row) {
                    return $row->meta_title ?? '--';
                })
                ->addColumn('meta_description', function ($row) {
                    return $row->meta_description ?? '--';
                })
                ->addColumn('meta_keyword', function ($row) {
                    return $row->meta_keyword ?? '--';
                })
                ->addColumn('canonical_url', function ($row) {
                    return $row->canonical_url ?? '--';
                })
                ->addColumn('alt_tag', function ($row) {
                    return $row->alt_tag ?? '--';
                })
                ->addColumn('image', function ($row) {
                    $image = '<img style="width: 35px" src="' . asset('storage/' . $row->image) . '" alt="">';
                    return $image;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        $status = '<span class="badge badge-success">Active</span>';
                    } else {
                        $status = '<span class="badge badge-secondary">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('cm.category.edit', $row->id);
                    $actionBtn = ' <a href="' . $editUrl . '" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-file"></i></a>
                        <form action="' . route('cm.category.delete', $row->id) . '" method="POST" style="display:inline">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                        </form>';
                    return $actionBtn;
                })
                ->rawColumns(['checkbox', 'commission', 'status', 'meta_title', 'meta_description', 'meta_keyword', 'canonical_url', 'alt_tag', 'image', 'action'])
                ->make(true);
        }
        return view('content-management.category');

    }

    public function categoryCreate()
    {
        $data['examinationCommissions'] = ExaminationCommission::all();
        return view('content-management.ajax.create-category', $data);
    }

    public function categoryEdit($id)
    {
        $data['category'] = Category::findOrFail($id);
        $data['examinationCommissions'] = ExaminationCommission::all();
        return view('content-management.ajax.edit-category', $data);
    }

    public function categoryUpdate(Request $request)
    {
        $id = $request->id;
        $category = Category::findOrFail($id);

        // Handle the file upload if an image is present
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($category->image && \Storage::exists('public/exam_commission_images/' . $category->image)) {
                \Storage::delete('public/exam_commission_images/' . $category->image);
            }
            // Store the new image
            $category->image = $request->image->store('uploads', 'public');
        }

        // Update the model with the request data
        $category->exam_com_id = $request->exam_com_id;
        $category->name = $request->name;
        $category->meta_title = $request->meta_title;
        $category->meta_keyword = $request->meta_keyword;
        $category->meta_description = $request->meta_description;
        $category->canonical_url = $request->canonical_url;
        $category->alt_tag = $request->alt_tag;
        $category->status = $request->status;

        // Save the updated model
        $category->save();

        // Redirect back with a success message
        return redirect()->route('cm.category')->with('success', 'Category updated successfully!');
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'exam_com_id' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'canonical_url' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048', // Assuming the image is optional and its maximum size is 2MB
            'alt_tag' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('exam_commission_images', 'public');
        } else {
            $imagePath = null;
        }

        // Create a new instance of ExaminationCommission model
        $examCommission = new Category();
        $examCommission->exam_com_id = $request->exam_com_id;
        $examCommission->name = $request->name;
        $examCommission->meta_title = $request->meta_title;
        $examCommission->meta_keyword = $request->meta_keyword;
        $examCommission->meta_description = $request->meta_description;
        $examCommission->canonical_url = $request->canonical_url;
        $examCommission->image = $imagePath;
        $examCommission->alt_tag = $request->alt_tag;
        $examCommission->status = $request->status;

        // Save the ExaminationCommission instance to the database
        $examCommission->save();
        return redirect()->back()->with('success', 'Category added successfully.');
    }
    public function categoryDelete($id)
    {
        // Find all test series associated with the category ID
        $test_series = TestSeries::where('category_id', $id)->get();

        // Iterate through the collection and delete each test series
        foreach ($test_series as $test) {
            $test->delete();
        }

        // Find the category by ID and delete it
        $category = Category::findOrFail($id);
        $category->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
    public function subCategoryIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = SubCategory::with('category')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="column_checkbox career_checkbox" id="' . $row->id . '" name="career_checkbox[]" />';
                })

                ->addColumn('category', function ($row) {
                    return $row->category->name ?? '';
                })
                ->addColumn('meta_title', function ($row) {
                    return $row->meta_title ?? '--';
                })
                ->addColumn('meta_description', function ($row) {
                    return $row->meta_description ?? '--';
                })
                ->addColumn('meta_keyword', function ($row) {
                    return $row->meta_keyword ?? '--';
                })
                ->addColumn('canonical_url', function ($row) {
                    return $row->canonical_url ?? '--';
                })
                ->addColumn('alt_tag', function ($row) {
                    return $row->alt_tag ?? '--';
                })
                ->addColumn('image', function ($row) {
                    $image = '<img style="width: 35px" src="' . asset('storage/' . $row->image) . '" alt="">';
                    return $image;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        $status = '<span class="badge badge-success">Active</span>';
                    } else {
                        $status = '<span class="badge badge-secondary">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('cm.sub.category.edit', $row->id);
                    $actionBtn = ' <a href="' . $editUrl . '" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-file"></i></a>
                        <form action="' . route('cm.sub-category.delete', $row->id) . '" method="POST" style="display:inline">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                        </form>';
                    return $actionBtn;
                })
                ->rawColumns(['checkbox', 'commission', 'status', 'meta_title', 'meta_description', 'meta_keyword', 'canonical_url', 'alt_tag', 'action'])
                ->make(true);
        }
        return view('content-management.sub-category');
    }
    public function subCategoryCreate()
    {
        $data['categories'] = Category::all();
        return view('content-management.ajax.create-sub-category', $data);
    }

    public function subCategoryStore(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'canonical_url' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048', // Assuming the image is optional and its maximum size is 2MB
            'alt_tag' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sub_category_images', 'public');
        } else {
            $imagePath = null;
        }

        // Create a new instance of ExaminationCommission model
        $examCommission = new SubCategory();
        $examCommission->category_id = $request->category_id;
        $examCommission->name = $request->name;
        $examCommission->meta_title = $request->meta_title;
        $examCommission->meta_keyword = $request->meta_keyword;
        $examCommission->meta_description = $request->meta_description;
        $examCommission->canonical_url = $request->canonical_url;
        $examCommission->image = $imagePath;
        $examCommission->alt_tag = $request->alt_tag;
        $examCommission->status = $request->status;

        // Save the ExaminationCommission instance to the database
        $examCommission->save();
        return redirect()->back()->with('success', 'Sub Category added successfully.');
    }

    public function subCategoryEdit($id)
    {
        $data['subCat'] = SubCategory::findOrFail($id);
        $data['categories'] = Category::all();
        return view('content-management.ajax.edit-sub-category', $data);
    }

    public function subCategoryUpdate(Request $request, $id)
    {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sub_category_images', 'public');
        } else {
            $imagePath = null;
        }

        // Create a new instance of ExaminationCommission model
        $examCommission = SubCategory::findOrFail($id);
        $examCommission->category_id = $request->category_id;
        $examCommission->name = $request->name;
        $examCommission->meta_title = $request->meta_title;
        $examCommission->meta_keyword = $request->meta_keyword;
        $examCommission->meta_description = $request->meta_description;
        $examCommission->canonical_url = $request->canonical_url;
        $examCommission->image = $imagePath;
        $examCommission->alt_tag = $request->alt_tag;
        $examCommission->status = $request->status;

        // Save the ExaminationCommission instance to the database
        $examCommission->save();
        return redirect()->back()->with('success', 'Sub Category Updated successfully.');
    }

    public function subCategoryDelete($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $subcategory->delete();
        return redirect()->back()->with('success', 'Sub-Category deleted successfully!');
    }
    public function subjectIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = Subject::all();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="column_checkbox career_checkbox" id="' . $row->id . '" name="career_checkbox[]" />';
                })

                ->addColumn('commission', function ($row) {
                    return $row->commission->name ?? '';
                })
                ->addColumn('category', function ($row) {
                    return $row->category->name ?? '';
                })
                ->addColumn('subcat', function ($row) {
                    return $row->subCategory->name ?? '';
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        $status = '<span class="badge badge-success">Active</span>';
                    } else {
                        $status = '<span class="badge badge-secondary">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('cm.subject.edit', $row->id);
                    $actionBtn = ' <a href="' . $editUrl . '" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-file"></i></a>
                            <form action="' . route('cm.subject.delete', $row->id) . '" method="POST" style="display:inline">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                            </form>';
                    return $actionBtn;
                })
                ->rawColumns(['checkbox', 'subcat', 'category', 'commission', 'status', 'action'])
                ->make(true);
        }
        return view('content-management.subject');
    }

    public function subjectCreate()
    {
        $data['commissions'] = ExaminationCommission::all();
        $lastsubject = Subject::orderBy('id', 'desc')->first();
        if (isset($lastsubject) && !empty($lastsubject)) {
            $data['subject_code'] = 'SUBJ-' . $lastsubject->id;
        } else {
            $data['subject_code'] = 'SUBJ-1';
        }
        return view('content-management.ajax.create-subject', $data);
    }

    public function subjectEdit($id)
    {
        $data['subject'] = Subject::findOrFail($id);
        $data['commissions'] = ExaminationCommission::all();
        $data['categories'] = Category::where('exam_com_id', $data['subject']->exam_com_id)->get();
        $data['subcategories'] = SubCategory::where('category_id', $data['subject']->category_id)->get();
        return view('content-management.ajax.edit-subject', $data);
    }

    public function subjectUpdate($id, Request $request)
    {
        $subject = Subject::findOrFail($id);

        // Update the subject with the request data
        $subject->update([
            'exam_com_id' => $request->input('exam_com_id'),
            'category_id' => $request->input('category_id'),
            'sub_category_id' => $request->input('sub_category_id'),
            'name' => $request->input('name'),
            'status' => $request->input('status'),
        ]);

        // Redirect back with a success message
        return redirect()->route('cm.subject')->with('success', 'Subject updated successfully.');
    }

    public function subjectStore(Request $request)
    {
        $request->validate([
            'exam_com_id' => 'required|exists:examination_commission,id',
            'category_id' => 'required|exists:category,id',
            'sub_category_id' => 'nullable|exists:sub_category,id',
            'name' => 'required|string|max:255',
            'subject_code' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        Subject::create([
            'exam_com_id' => $request->exam_com_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id ?? NULL,
            'name' => $request->name,
            'subject_code' => $request->subject_code,
            'status' => $request->status,
        ]);

        return redirect()->route('cm.subject')->with('success', 'Subject created successfully!');
    }

    public function subjectDelete($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return redirect()->back()->with('success', 'Subject deleted successfully!');
    }
    public function chapterIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = Chapter::all();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="column_checkbox career_checkbox" id="' . $row->id . '" name="career_checkbox[]" />';
                })

                ->addColumn('subject', function ($row) {
                    return $row->subject->name ?? '';
                })

                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        $status = '<span class="badge badge-success">Active</span>';
                    } else {
                        $status = '<span class="badge badge-secondary">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('cm.chapter.edit', $row->id);
                    $actionBtn = ' <a href="' . $editUrl . '" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-file"></i></a>
                            <form action="' . route('cm.chapter.delete', $row->id) . '" method="POST" style="display:inline">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                            </form>';
                    return $actionBtn;
                })
                ->rawColumns(['checkbox', 'subject', 'status', 'action'])
                ->make(true);
        }
        return view('content-management.chapter');

    }
    public function chapterCreate()
    {
        $data['commissions'] = ExaminationCommission::all();
        $data['subjects'] = Subject::all();
        return view('content-management.ajax.create-chapter', $data);
    }

    public function chapterStore(Request $request)
    {
        $request->validate([
            'exam_com_id' => 'required|exists:examination_commission,id',
            'category_id' => 'required|exists:category,id',
            'sub_category_id' => 'nullable|exists:sub_category,id',
            'subject_id' => 'required|exists:subject,id',
            'name' => 'required|string|max:255',
            'chapter_number' => 'nullable|string|max:255',
            'description' => 'required|string',
            'status' => 'required|boolean',
        ]);

        Chapter::create([
            'exam_com_id' => $request->exam_com_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id ?? NULL,
            'subject_id' => $request->subject_id,
            'name' => $request->name,
            'chapter_number' => $request->chapter_number,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('cm.chapter')->with('success', 'Chapter created successfully!');
    }

    public function chapterEdit($id)
    {
        $data['commissions'] = ExaminationCommission::all();
        $data['categories'] = Category::all();
        $data['subcategories'] = SubCategory::all();
        $data['subjects'] = Subject::all();
        $data['chapter'] = Chapter::where('id', $id)->first();
        return view('content-management.ajax.edit-chapter', $data);
    }
    public function chapterUpdate(Request $request, $id)
    {
        $request->validate([
            'exam_com_id' => 'required|exists:examination_commission,id',
            'category_id' => 'required|exists:category,id',
            'sub_category_id' => 'nullable|exists:sub_category,id',
            'subject_id' => 'required|exists:subject,id',
            'name' => 'required|string|max:255',
            'chapter_number' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|boolean',
        ]);

        Chapter::where('id', $id)->update([
            'exam_com_id' => $request->exam_com_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id ?? NULL,
            'subject_id' => $request->subject_id,
            'name' => $request->name,
            'chapter_number' => $request->chapter_number,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('cm.chapter')->with('success', 'Topic updated successfully!');
    }
    public function chapterDelete($id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->delete();
        return redirect()->back()->with('success', 'Chapter deleted successfully!');
    }

    public function courseIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = Course::with('examinationCommission', 'category', 'subCategory')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="column_checkbox career_checkbox" id="' . $row->id . '" name="career_checkbox[]" />';
                })
                ->addColumn('image', function ($row) {
                    $image = '<img style="width: 35px" src="' . asset('storage/' . $row->image) . '" alt="">';
                    return $image;
                })
                ->addColumn('fee', function ($row) {
                    return $row->course_fee ?? '--';
                })
                ->addColumn('duration', function ($row) {
                    return $row->duration ?? '0';
                })
                ->addColumn('commission', function ($row) {
                    return $row->examinationCommission->name ?? '--';
                })
                ->addColumn('category', function ($row) {
                    return $row->category->name ?? '--';
                })
                ->addColumn('subcat', function ($row) {
                    return $row->subCategory->name ?? '--';
                })
                 ->addColumn('type', function ($row) {
                    return $row->based_on ?? '--';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('courses.course.edit', $row->id);
                    $actionBtn = ' <a href="' . $editUrl . '" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-file"></i></a>
                            <form action="' . route('courses.course.delete', $row->id) . '" method="POST" style="display:inline">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                            </form>';
                    return $actionBtn;
                })
                ->rawColumns(['checkbox', 'fee', 'image', 'duration', 'category', 'subcat', 'commission', 'action'])
                ->make(true);
        }
        return view('content-management.course');

    }

    public function courseCreate()
    {
        $data['examinationCommissions'] = ExaminationCommission::all();
        $data['categories'] = Category::all();
        $data['subcategories'] = SubCategory::all();
        return view('content-management.ajax.create-course', $data);
    }

    public function courseEdit($id)
    {
        $data['examinationCommissions'] = ExaminationCommission::all();
        $data['course'] = Course::with('category', 'subCategory')->findOrFail($id);
        $data['subjects'] = !empty($data['course']->sub_category_id)
            ? Subject::where('sub_category_id', $data['course']->sub_category_id)->get()
            : collect();

        // Get decoded arrays automatically (Laravel cast handles this)
        $subjectIds = $data['course']->subject_id ?? [];
        $chapterIds = $data['course']->chapter_id ?? [];

        $data['chapters'] = !empty($subjectIds)
            ? Chapter::whereIn('subject_id', $subjectIds)->get()
            : collect();

        $data['topics'] = !empty($chapterIds)
            ? CourseTopic::whereIn('chapter_id', $chapterIds)->get()
            : collect();

        return view('content-management.ajax.edit-course', $data);
    }

    public function courseUpdate(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $course->examination_commission_id = $request->examination_commission_id;
        $course->category_id = $request->category_id;
        $course->sub_category_id = $request->sub_category_id;
        $course->name = $request->name;
        $course->duration = $request->duration;
        $course->course_fee = $request->course_fee;
        $course->feature = $request->feature ?? 'off';
        $course->discount = $request->discount;
        $course->offered_price = $request->offered_price;
        $course->num_classes = $request->num_classes;
        $course->num_topics = $request->num_topics;
        $course->language_of_teaching = implode(',', $request->language_of_teaching);
        $course->course_heading = $request->course_heading;
        $course->short_description = $request->short_description;
        $course->course_overview = $request->course_overview;
        $course->detail_content = $request->detail_content;
        $course->youtube_url = $request->youtube_url;
        $course->meta_title = $request->meta_title;
        $course->meta_keyword = $request->meta_keyword;
        $course->meta_description = $request->meta_description;
        $course->image_alt_tag = $request->image_alt_tag;
        $course->subject_id = $request->subject_id ?? [];
        $course->chapter_id = $request->chapter_id ?? [];
        $course->topic_id = $request->topic_id ?? [];
        // ✅ Course Type Logic (Based On)
        $basedOn = $request->based_on ?? 'general';
        $course->based_on = $basedOn;

        if ($request->hasFile('thumbnail_image')) {
            $thumbnailPath = $request->file('thumbnail_image')->store('thumbnails', 'public');
            $course->thumbnail_image = $thumbnailPath;
        }

        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('banners', 'public');
            $course->banner_image = $bannerPath;
        }

        $course->save();

        return redirect()->route('courses.course.index')->with('success', 'Course updated successfully');
    }

    public function courseStore(Request $request)
    {
        $request->validate([
            'examination_commission_id' => 'required|exists:examination_commission,id',
            'category_id' => 'nullable|exists:category,id',
            'sub_category_id' => 'nullable|exists:sub_category,id',
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'course_fee' => 'required|numeric',
            'discount' => 'required|integer',
            'offered_price' => 'required|numeric',
            'num_classes' => 'required|integer',
            'num_topics' => 'required|integer',

            'subject_id' => 'required|array',
            'subject_id.*' => 'integer',

            'chapter_id' => 'nullable|array',
            'chapter_id.*' => 'integer',

            'topic_id' => 'nullable|array',
            'topic_id.*' => 'integer',

            'language_of_teaching' => 'required|array',
            'language_of_teaching.*' => 'required|string',

            'based_on' => 'nullable|string|max:255', // 👈 new field

            'course_heading' => 'required|string|max:255',
            'short_description' => 'required|string',
            'course_overview' => 'required|string',
            'detail_content' => 'required|string',

            'thumbnail_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',

            'youtube_url' => 'nullable|url',
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'image_alt_tag' => 'nullable|string|max:255',
            'feature' => 'nullable',
        ]);

        // ✅ Handle file uploads
        $thumbnailImagePath = $request->file('thumbnail_image')->store('thumbnails', 'public');
        $bannerImagePath = $request->file('banner_image')->store('banners', 'public');

        // ✅ Create new course
        $course = new Course();
        $course->examination_commission_id = $request->examination_commission_id;
        $course->category_id = $request->category_id;
        $course->sub_category_id = $request->sub_category_id;
        $course->name = $request->name;
        $course->feature = $request->feature ?? 'off';
        $course->duration = $request->duration;
        $course->course_fee = $request->course_fee;
        $course->discount = $request->discount;
        $course->offered_price = $request->offered_price;
        $course->num_classes = $request->num_classes;
        $course->num_topics = $request->num_topics;

        // ✅ Store multi-select arrays as comma-separated strings
        $course->subject_id = $request->subject_id ?? [];
        $course->chapter_id = $request->chapter_id ?? [];
        $course->topic_id = $request->topic_id ?? [];
        $course->language_of_teaching = implode(',', $request->language_of_teaching);

        // ✅ Course Type Logic (Based On)
        $basedOn = $request->based_on ?? 'general';
        $course->based_on = $basedOn;

        $course->course_heading = $request->course_heading;
        $course->short_description = $request->short_description;
        $course->course_overview = $request->course_overview;
        $course->detail_content = $request->detail_content;
        $course->thumbnail_image = $thumbnailImagePath;
        $course->banner_image = $bannerImagePath;
        $course->youtube_url = $request->youtube_url;
        $course->meta_title = $request->meta_title;
        $course->meta_keyword = $request->meta_keyword;
        $course->meta_description = $request->meta_description;
        $course->image_alt_tag = $request->image_alt_tag;

        $course->save();

        return redirect()->route('courses.course.index')->with('success', 'Course created successfully');
    }


    public function courseDelete($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->back()->with('success', 'Course deleted successfully!');
    }

    public function currentAffairDelete($id)
    {
        $currentAffair = CurrentAffair::findOrFail($id);
        $currentAffair->delete();
        return redirect()->back()->with('success', 'Current Affair deleted successfully!');
    }

    public function directEnquiriesIndex()
    {
        $data['enquiries'] = DirectEnquiry::orderBy('created_at', 'DESC')->get();
        return view('enquiries.direct-enquiries', $data);
    }

    public function directEnquiriesDelete($id)
    {
        $direct = DirectEnquiry::findOrFail($id);
        $direct->delete();
        return redirect()->back()->with('success', 'Enquiry deleted successfully!');
    }

    public function contactUsIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = ContactUs::orderBy('created_at', 'DESC')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="column_checkbox career_checkbox" id="' . $row->id . '" name="career_checkbox[]" />';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at;
                })


                ->addColumn('action', function ($row) {
                    $actionBtn = ' <form action="' . route('enquiries.contact.delete', $row->id) . '" method="POST" style="display:inline">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                        </form>';
                    return $actionBtn;
                })
                ->rawColumns(['checkbox', 'created_at', 'action'])
                ->make(true);
        }
        return view('enquiries.contact-us');

    }

    public function contactUsDelete($id)
    {
        $contact = ContactUs::findOrFail($id);
        $contact->delete();
        return redirect()->back()->with('success', 'Contact Us deleted successfully!');
    }

    public function callRequestIndex()
    {
        $data['callbacks'] = CallBack::orderBy('created_at', 'DESC')->get();
        return view('enquiries.call-back-request', $data);
    }
    public function callRequestDelete($id)
    {
        $callback = CallBack::findOrFail($id);
        $callback->delete();
        return redirect()->back()->with('success', 'CallBack Request deleted successfully!');
    }

    public function topicIndex()
    {
        $data['topics'] = Topic::all();
        return view('current-affairs.topic', $data);
    }

    public function topicStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:1000',
        ]);

        Topic::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Topic added successfully.');
    }

    public function topicUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000', // optional field
        ]);

        $topic = Topic::findOrFail($id); // Get the topic or fail
        $topic->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Topic updated successfully.');
    }

    public function topicDelete($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();
        return redirect()->back()->with('success', 'Topic deleted successfully!');
    }

    public function currentAffairIndex()
    {
        $data['currentAffairs'] = CurrentAffair::with('topic')->get();
        return view('current-affairs.index', $data);
    }

    public function currentAffairCreate()
    {
        $data['topics'] = Topic::all();
        return view('current-affairs.create', $data);
    }

    public function currentAffairStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'details' => 'required|string',
            'publishing_date' => 'required',
            'thumbnail_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:10240', // max 10MB
            'image_alt_tag' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle file uploads
        $thumbnailPath = null;
        $bannerPath = null;

        if ($request->hasFile('thumbnail_image')) {
            $thumbnailPath = $request->file('thumbnail_image')->store('thumbnails', 'public');
        }

        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('banners', 'public');
        }

        $pdfPath = null;
        if ($request->hasFile('pdf_file')) {
            $pdfPath = $request->file('pdf_file')->store('pdfs', 'public');
        }

        // Create a new record in the database
        $currentAffair = CurrentAffair::create([
            'topic_id' => $request->topic_id,
            'title' => $request->title,
            'short_description' => $request->short_description,
            'details' => $request->details,
            'publishing_date' => $request->publishing_date,
            'thumbnail_image' => $thumbnailPath,
            'banner_image' => $bannerPath,
            'pdf_file' => $pdfPath,
            'image_alt_tag' => $request->image_alt_tag,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->route('current.affairs.index')->with('success', 'Current Affair added successfully!');
    }

    public function currentAffairShow($id)
    {
        $currentAffair = CurrentAffair::findOrFail($id);
        return view('current-affairs.show', compact('currentAffair'));
    }

    // Show edit form
    public function currentAffairEdit($id)
    {
        $currentAffair = CurrentAffair::findOrFail($id);
        $topics = Topic::all();
        return view('current-affairs.edit', compact('currentAffair', 'topics'));
    }

    // Update current affair
    public function currentAffairUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'topic_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'details' => 'required|string',
            'publishing_date' => 'required',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:10240', // max 10MB
            'image_alt_tag' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $currentAffair = CurrentAffair::findOrFail($id);

        // Handle file uploads
        if ($request->hasFile('thumbnail_image')) {
            $currentAffair->thumbnail_image = $request->file('thumbnail_image')->store('thumbnails', 'public');
        }

        if ($request->hasFile('banner_image')) {
            $currentAffair->banner_image = $request->file('banner_image')->store('banners', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $currentAffair->pdf_file = $request->file('pdf_file')->store('pdfs', 'public');
        }


        // Update other fields
        $currentAffair->topic_id = $request->topic_id;
        $currentAffair->title = $request->title;
        $currentAffair->short_description = $request->short_description;
        $currentAffair->details = $request->details;
        $currentAffair->publishing_date = $request->publishing_date;
        $currentAffair->image_alt_tag = $request->image_alt_tag;
        $currentAffair->meta_title = $request->meta_title;
        $currentAffair->meta_keyword = $request->meta_keyword;
        $currentAffair->meta_description = $request->meta_description;

        $currentAffair->save();

        return redirect()->route('current.affairs.index')->with('success', 'Current Affair updated successfully!');
    }

    public function studyMaterialIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = StudyMaterial::orderBy('created_at', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="column_checkbox career_checkbox" id="' . $row->id . '" name="career_checkbox[]" />';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d-m-Y H:i') : 'N/A';
                })

                // ✅ Title with Topic (BR tag)
                ->addColumn('title', function ($row) {
                    $topicName = $row->topic?->name ?? '';
                    return $row->title . ($topicName ? '<br><span>' . e($topicName) . '</span>' : '');
                })

                // ✅ Examination Detail (Commission, Category, Sub Category with BR tag)
                ->addColumn('examination_detail', function ($row) {
                    $commission = $row->commission->name ?? 'N/A';
                    $category = $row->category->name ?? 'N/A';
                    $subCat = $row->subCategory->name ?? 'N/A';

                    return $commission . '<br>' . $category . '<br>' . $subCat;
                })

                // ✅ Payment Type (Free / Paid)
                ->addColumn('payment_type', function ($row) {
                    return $row->IsPaid == 1
                        ? '<span class="badge badge-warning">Paid</span>'
                        : '<span class="badge badge-success">Free</span>';
                })

                // ✅ Package Type (material_type logic already there)
                ->addColumn('package_type', function ($row) {
                    return match ($row->material_type) {
                        'topic_based' => 'Topic Based',
                        'chapter_based' => 'Chapter Based',
                        'subject_based' => 'Subject Based',
                        'general' => 'General',
                        default => ucfirst(str_replace('_', ' ', $row->material_type)),
                    };
                })

                // ✅ Status
                ->addColumn('status', function ($row) {
                    return $row->status == 'Active'
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-secondary">Inactive</span>';
                })

                ->addColumn('action', function ($row) {
                    return '
    <div class="dropdown">
  <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="actionMenu' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">
    <span>Actions</span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="actionMenu' . $row->id . '">
    <li><a class="dropdown-item text-primary" href="' . route('study.material.show', $row->id) . '"><i class="fa fa-eye"></i> View Details</a></li>
    <li><a class="dropdown-item text-secondary" href="' . route('study.material.edit', $row->id) . '"><i class="fas fa-edit me-2"></i> Edit</a></li>
    <li><a class="dropdown-item text-info" href="' . route('study.material.download', $row->id) . '"><i class="fa fa-download"></i> Download PDF</a></li>
    <li>
      <form action="' . route('study.material.delete', $row->id) . '" method="POST" style="display:inline" onsubmit="return confirm(\'Are you sure?\')">
        ' . csrf_field() . '
        ' . method_field("DELETE") . '
        <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash me-2" style="color: red!important;"></i> Delete</button>
      </form>
    </li>
  </ul>
</div>';


                })

                ->rawColumns([
                    'checkbox',
                    'created_at',
                    'title',
                    'examination_detail',
                    'payment_type',
                    'status',
                    'action'
                ])

                ->make(true);

        }

        return view('study-material.index');
    }

    public function studyMaterialShow($id)
    {
        $material = StudyMaterial::with(['commission', 'category', 'subCategory', 'subject', 'chapter', 'topic'])->findOrFail($id);

        return view('study-material.show', compact('material'));
    }

    public function studyMaterialCreate()
    {
        $data['commissions'] = ExaminationCommission::get();
        $data['subjects'] = [];
        $data['topics'] = [];
        $data['categories'] = [];
        return view('study-material.create', $data);
    }

    public function studyMaterialStore(Request $request)
    {
        $validatedData = $request->validate([
            'commission_id' => 'required|integer',
            'category_id' => 'required|integer',
            'sub_category_id' => 'nullable|integer',
            'subject_id' => 'nullable|array',
            'subject_id.*' => 'integer',
            'chapter_id' => 'nullable|array',
            'chapter_id.*' => 'integer',
            'topic_id' => 'nullable|array',
            'topic_id.*' => 'integer',
            'is_pdf_downloadable' => 'required|boolean',
            'title' => 'required|string',
            'short_description' => 'required|string',
            'detail_content' => 'required|string',
            'status' => 'required|string',
            'pdf' => 'nullable|file|mimes:pdf|max:2048',
            'meta_title' => 'nullable|string',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'banner' => 'required|file|image|max:2048',
            'IsPaid' => 'required|boolean',
            'price' => 'nullable|numeric',
            'mrp' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'based_on' => 'nullable|string',

            // 🧩 New validation for Title & Description groups
            'titles' => 'required|array|min:1',
            'titles.*' => 'required|string',
            'descriptions' => 'required|array|min:1',
            'descriptions.*' => 'required|string',
        ]);

        // Upload PDF file (optional)
        $pdfPath = null;
        if ($request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store('pdfs', 'public');
        }

        // Upload Banner (required)
        $bannerPath = $request->file('banner')->store('banners', 'public');

        /**
         * 🧩 Determine Material Type
         */
        $basedOn = $validatedData['based_on'] ?? null;
        $materialType = 'general';

        if ($basedOn) {
            switch (true) {
                case str_contains($basedOn, 'Combined Topic'):
                    $materialType = 'combined_topic_based';
                    break;
                case str_contains($basedOn, 'Topic'):
                    $materialType = 'topic_based';
                    break;
                case str_contains($basedOn, 'Combined Chapter'):
                    $materialType = 'combined_chapter_based';
                    break;
                case str_contains($basedOn, 'Chapter'):
                    $materialType = 'chapter_based';
                    break;
                case str_contains($basedOn, 'Combined Subject'):
                    $materialType = 'combined_subject_based';
                    break;
                case str_contains($basedOn, 'Subject'):
                    $materialType = 'subject_based';
                    break;
                case str_contains($basedOn, 'Sub Category'):
                    $materialType = 'sub_category_based';
                    break;
            }
        }

        /**
         * 💾 Create Study Material
         */
        $studyMaterial = new StudyMaterial();
        $studyMaterial->commission_id = $validatedData['commission_id'];
        $studyMaterial->category_id = $validatedData['category_id'];
        $studyMaterial->sub_category_id = $validatedData['sub_category_id'] ?? null;
        $studyMaterial->subject_id = $validatedData['subject_id'] ?? [];
        $studyMaterial->chapter_id = $validatedData['chapter_id'] ?? [];
        $studyMaterial->topic_id = $validatedData['topic_id'] ?? [];
        $studyMaterial->is_pdf_downloadable = $validatedData['is_pdf_downloadable'];
        $studyMaterial->material_type = $materialType;
        $studyMaterial->title = $validatedData['title'];
        $studyMaterial->short_description = $validatedData['short_description'];
        $studyMaterial->detail_content = $validatedData['detail_content'];
        $studyMaterial->status = $validatedData['status'];
        $studyMaterial->pdf = $pdfPath;
        $studyMaterial->banner = $bannerPath;
        $studyMaterial->IsPaid = $validatedData['IsPaid'];
        $studyMaterial->price = $validatedData['price'] ?? null;
        $studyMaterial->mrp = $validatedData['mrp'] ?? null;
        $studyMaterial->discount = $validatedData['discount'] ?? null;
        $studyMaterial->meta_title = $validatedData['meta_title'] ?? null;
        $studyMaterial->meta_keyword = $validatedData['meta_keyword'] ?? null;
        $studyMaterial->meta_description = $validatedData['meta_description'] ?? null;
        $studyMaterial->based_on = $basedOn; // Optional, for reference
        $studyMaterial->save();

        if (!empty($validatedData['titles']) && !empty($validatedData['descriptions'])) {
            foreach ($validatedData['titles'] as $index => $title) {
                StudyMaterialSection::create([
                    'study_material_id' => $studyMaterial->id,
                    'title' => $title,
                    'description' => $validatedData['descriptions'][$index] ?? '',
                ]);
            }
        }

        return redirect()
            ->route('study.material.index')
            ->with('success', 'Study material has been created successfully.');
    }


    public function downloadPdf($id)
    {
        $material = StudyMaterial::with([
            'commission',
            'category',
            'subcategory',
        ])->findOrFail($id);

        // Define the PDF file path
        $pdfFileName = 'study_material_' . $material->id . '.pdf';
        $pdfFilePath = 'public/study_materials/' . $pdfFileName;

        // If PDF exists, delete it
        if (Storage::exists($pdfFilePath)) {
            Storage::delete($pdfFilePath);
        }

        // Generate new PDF and save
        $pdf = Pdf::loadView('study-material.pdf', compact('material'))
            ->setPaper('a4', 'portrait');
        Storage::put($pdfFilePath, $pdf->output());
        // Return the newly created PDF as download
        return response()->download(storage_path('app/' . $pdfFilePath));
    }

    public function studyMaterialEdit($id)
    {
        $material = StudyMaterial::with('sections')->findOrFail($id);

        $data['commissions'] = ExaminationCommission::all();

        $data['categories'] = !empty($material->commission_id)
            ? Category::where('exam_com_id', $material->commission_id)->get()
            : collect();

        $data['subcategories'] = !empty($material->category_id)
            ? SubCategory::where('category_id', $material->category_id)->get()
            : collect();

        $data['subjects'] = !empty($material->sub_category_id)
            ? Subject::where('sub_category_id', $material->sub_category_id)->get()
            : collect();

        // Get decoded arrays automatically (Laravel cast handles this)
        $subjectIds = $material->subject_id ?? [];
        $chapterIds = $material->chapter_id ?? [];

        $data['chapters'] = !empty($subjectIds)
            ? Chapter::whereIn('subject_id', $subjectIds)->get()
            : collect();

        $data['topics'] = !empty($chapterIds)
            ? CourseTopic::whereIn('chapter_id', $chapterIds)->get()
            : collect();

        $data['material'] = $material;

        // ✅ Include sections (title + description)
        $data['sections'] = $material->sections ?? collect();

        return view('study-material.edit', $data);
    }


    public function studyMaterialUpdate($id, Request $request)
    {
        $material = StudyMaterial::findOrFail($id);

        // Validation
        $validatedData = $request->validate([
            'commission_id' => 'required|integer',
            'category_id' => 'required|integer',
            'sub_category_id' => 'nullable|integer',
            'subject_id' => 'required|array',
            'subject_id.*' => 'integer',
            'chapter_id' => 'nullable|array',
            'chapter_id.*' => 'integer',
            'topic_id' => 'nullable|array',
            'topic_id.*' => 'integer',

            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'detail_content' => 'required|string',
            'status' => 'required|string',
            'IsPaid' => 'required|boolean',
            'price' => 'nullable|numeric',
            'mrp' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'is_pdf_downloadable' => 'required|boolean',

            'pdf' => 'nullable|file|mimes:pdf|max:2048',
            'banner' => 'nullable|file|image|max:2048',

            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'based_on' => 'nullable|string',

            // Section validation
            'section_ids' => 'nullable|array',
            'section_ids.*' => 'nullable|integer|exists:study_material_sections,id',
            'titles' => 'nullable|array',
            'titles.*' => 'nullable|string|max:255',
            'descriptions' => 'nullable|array',
            'descriptions.*' => 'nullable|string',
        ]);

        // Update main material
        $material->fill([
            'commission_id' => $validatedData['commission_id'],
            'category_id' => $validatedData['category_id'],
            'sub_category_id' => $validatedData['sub_category_id'] ?? null,
            'subject_id' => $validatedData['subject_id'] ?? [],
            'chapter_id' => $validatedData['chapter_id'] ?? [],
            'topic_id' => $validatedData['topic_id'] ?? [],
            'title' => $validatedData['title'],
            'short_description' => $validatedData['short_description'],
            'detail_content' => $validatedData['detail_content'],
            'IsPaid' => $validatedData['IsPaid'],
            'mrp' => $validatedData['mrp'] ?? null,
            'discount' => $validatedData['discount'] ?? null,
            'price' => $validatedData['price'] ?? null,
            'status' => $validatedData['status'],
            'meta_title' => $validatedData['meta_title'] ?? null,
            'meta_keyword' => $validatedData['meta_keyword'] ?? null,
            'meta_description' => $validatedData['meta_description'] ?? null,
            'is_pdf_downloadable' => $validatedData['is_pdf_downloadable'],
        ]);

        // Determine material type
        $basedOn = $validatedData['based_on'] ?? null;
        $material->material_type = 'general';
        if ($basedOn) {
            switch (true) {
                case str_contains($basedOn, 'Combined Topic'):
                    $material->material_type = 'combined_topic_based';
                    break;
                case str_contains($basedOn, 'Topic'):
                    $material->material_type = 'topic_based';
                    break;
                case str_contains($basedOn, 'Combined Chapter'):
                    $material->material_type = 'combined_chapter_based';
                    break;
                case str_contains($basedOn, 'Chapter'):
                    $material->material_type = 'chapter_based';
                    break;
                case str_contains($basedOn, 'Combined Subject'):
                    $material->material_type = 'combined_subject_based';
                    break;
                case str_contains($basedOn, 'Subject'):
                    $material->material_type = 'subject_based';
                    break;
                case str_contains($basedOn, 'Sub Category'):
                    $material->material_type = 'sub_category_based';
                    break;
            }
        }

        // Handle file updates
        if ($request->hasFile('banner')) {
            if ($material->banner)
                Storage::disk('public')->delete($material->banner);
            $material->banner = $request->file('banner')->store('banners', 'public');
        }
        if ($request->hasFile('pdf')) {
            if ($material->pdf)
                Storage::disk('public')->delete($material->pdf);
            $material->pdf = $request->file('pdf')->store('pdfs', 'public');
        }

        $material->save();

        /**
         * ✅ Handle Sections (Update / Create / Delete missing)
         */
        $sectionIds = $request->input('section_ids', []);
        $titles = $request->input('titles', []);
        $descriptions = $request->input('descriptions', []);

        $existingSectionIds = $material->sections()->pluck('id')->toArray();
        $submittedSectionIds = array_filter($sectionIds);

        // 🔸 Delete sections that are no longer submitted
        $toDelete = array_diff($existingSectionIds, $submittedSectionIds);
        if (!empty($toDelete)) {
            StudyMaterialSection::whereIn('id', $toDelete)->delete();
        }

        // 🔸 Loop through and update or create
        foreach ($titles as $index => $title) {
            $sectionId = $sectionIds[$index] ?? null;
            $description = $descriptions[$index] ?? '';

            if ($sectionId && in_array($sectionId, $existingSectionIds)) {
                // Update existing section
                $section = StudyMaterialSection::find($sectionId);
                if ($section) {
                    $section->update([
                        'title' => $title,
                        'description' => $description,
                    ]);
                }
            } else {
                // Create new section
                if (!empty($title) || !empty($description)) {
                    StudyMaterialSection::create([
                        'study_material_id' => $material->id,
                        'title' => $title,
                        'description' => $description,
                    ]);
                }
            }
        }

        return redirect()
            ->route('study.material.index')
            ->with('success', 'Study Material updated successfully with sections');
    }



    public function studyMaterialDelete($id)
    {
        $studyMaterial = StudyMaterial::findOrFail($id);
        $studyMaterial->delete();
        return redirect()->back()->with('success', 'Study Material deleted successfully.');
    }

    public function dailyBoostIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = DailyBooster::orderBy('created_at', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="column_checkbox career_checkbox" id="' . $row->id . '" name="career_checkbox[]" />';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('image', function ($row) {
                    $linkUrl = asset("storage/" . $row->thumbnail);
                    $link = '<img src="' . $linkUrl . '" alt="Image" width="50">';
                    return $link;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('daily.boost.edit', $row->id);
                    $actionBtn = ' <a href="' . $editUrl . '" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-file"></i></a>
                            <form action="' . route('daily.boost.delete', $row->id) . '" method="POST" style="display:inline">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                            </form>';
                    return $actionBtn;
                })
                ->rawColumns(['checkbox', 'created_at', 'image', 'action'])
                ->make(true);
        }
        return view('daily-booster.index');
    }

    public function dailyBoostCreate()
    {
        return view('daily-booster.create');
    }

    public function dailyBoostEdit($id)
    {
        $data['dailyBooster'] = DailyBooster::findOrFail($id);
        return view('daily-booster.edit', $data);
    }

    public function dailyBoostUpdate($id, Request $request)
    {
        $dailyBooster = DailyBooster::findOrFail($id);
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($dailyBooster->thumbnail) {
                Storage::disk('public')->delete($dailyBooster->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        } else {
            $thumbnailPath = $dailyBooster->thumbnail;
        }

        // Update Daily Booster
        $dailyBooster->update([
            'title' => $request->input('title'),
            'start_date' => $request->input('start_date'),
            'youtube_url' => $request->input('youtube_url'),
            'short_description' => $request->input('short_description'),
            'detail_content' => $request->input('detail_content'),
            'thumbnail' => $thumbnailPath,
            'image_alt_tag' => $request->input('image_alt_tag'),
            'meta_title' => $request->input('meta_title'),
            'meta_keyword' => $request->input('meta_keyword'),
            'meta_description' => $request->input('meta_description'),
        ]);

        // Redirect with success message
        return redirect()->route('daily.boost.index')->with('success', 'Daily Booster updated successfully.');
    }

    public function dailyBoostStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'youtube_url' => 'nullable|url',
            'short_description' => 'required|string',
            'detail_content' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_alt_tag' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'title',
            'start_date',
            'youtube_url',
            'short_description',
            'detail_content',
            'image_alt_tag',
            'meta_title',
            'meta_keyword',
            'meta_description'
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        DailyBooster::create($data);

        return redirect()->route('daily.boost.index')->with('success', 'Daily Booster created successfully.');
    }

    public function dailyBoostDelete($id)
    {
        $dailyBooster = DailyBooster::findOrFail($id);
        $dailyBooster->delete();
        return redirect()->back()->with('success', 'Daily Booster deleted successfully.');
    }

    public function testPlannerIndex(Request $request)
    {

        if ($request->ajax()) {
            $data = TestPlanner::orderBy('created_at', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="column_checkbox career_checkbox" id="' . $row->id . '" name="career_checkbox[]" />';
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        $status = '<span class="badge badge-success">Active</span>';
                    } else {
                        $status = '<span class="badge badge-secondary">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('test.planner.edit', $row->id);
                    $actionBtn = ' <a href="' . $editUrl . '" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-file"></i></a>
                            <form action="' . route('test.planner.delete', $row->id) . '" method="POST" style="display:inline">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                            </form>';
                    return $actionBtn;
                })
                ->rawColumns(['checkbox', 'created_at', 'status', 'action'])
                ->make(true);
        }
        return view('test-planner.index');
        //$data['test_planners'] = TestPlanner::orderBy('created_at','DESC')->get();
        //return view('test-planner.index',$data);
    }

    public function testPlannerCreate()
    {
        return view('test-planner.create');
    }

    public function testPlannerEdit($id)
    {
        $data['testPlanner'] = TestPlanner::findOrFail($id);
        return view('test-planner.edit', $data);
    }

    public function testPlannerUpdate(Request $request, $id)
    {
        $testPlanner = TestPlanner::findOrFail($id);
        $testPlanner->title = $request->input('title');
        $testPlanner->start_date = $request->input('start_date');
        $testPlanner->short_description = $request->input('short_description');
        $testPlanner->detail_content = $request->input('detail_content');
        $testPlanner->status = $request->input('status');

        if ($request->hasFile('pdf')) {
            $testPlanner->pdf = $request->file('pdf')->store('pdfs', 'public');
        }

        $testPlanner->save();

        return redirect()->route('test.planner.index')->with('success', 'Test Planner updated successfully');
    }

    public function testPlannerStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'short_description' => 'required|string',
            'detail_content' => 'required',
            'pdf' => 'required|mimes:pdf|max:2048',
            'status' => 'required|integer',
        ]);

        $data = $request->only([
            'title',
            'start_date',
            'short_description',
            'detail_content',
            'status'
        ]);

        if ($request->hasFile('pdf')) {
            $data['pdf'] = $request->file('pdf')->store('pdfs', 'public');
        }

        TestPlanner::create($data);

        return redirect()->back()->with('success', 'Test Planner created successfully.');
    }
    public function testPlannerDelete($id)
    {
        $test = TestPlanner::findOrFail($id);
        $test->delete();
        return redirect()->back()->with('success', 'Test Planner deleted successfully.');
    }

    public function testSeriesIndex()
    {
        $data['test_series'] = TestSeries::with('category')->get();
        return view('test-series.index', $data);
    }
    public function testSeriesCreate()
    {
        $data['commissions'] = ExaminationCommission::get();
        $data['subjects'] = [];
        $data['topics'] = [];
        $data['categories'] = [];
        return view('test-series.create', $data);
    }
    public function testSeriesStore(Request $request)
    {
        // ✅ Validate main test series fields
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:512',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'price' => 'required|numeric',
            'mrp' => 'required|numeric',
            'discount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }

        // ✅ Prepare data for saving Test Series
        $data = $request->except(['_token', 'additionalData']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // ✅ Create Test Series record
        $testseries = TestSeries::create($data);

        // ✅ Decode additionalData JSON
        $additionalData = json_decode($request->input('additionalData'), true);

        // ✅ Define test type names
        $typeNames = [
            1 => "Full Test",
            2 => "Subject Wise",
            3 => "Chapter Wise",
            4 => "Topic Wise",
            5 => "Current Affair",
            6 => "Previous Year",
        ];

        // ✅ Counter for total papers
        $totalPaperCount = 0;

        if (!empty($additionalData['testType'])) {
            foreach ($additionalData['testType'] as $index => $testType) {
                $testType = (int) $testType;
                $testTypeName = $typeNames[$testType] ?? "Unknown Type";

                $testGeneratedBy = $additionalData['testSelections'][$index] ?? ($data['test_generated_by'] ?? 'manual');

                // ✅ Helper closure to save papers by type
                $savePapers = function ($papers, $paperType) use ($testType, $testTypeName, $testGeneratedBy, $testseries, &$totalPaperCount) {
                    if (isset($papers) && is_array($papers) && !empty($papers)) {
                        foreach ($papers as $paperId) {
                            TestSeriesDetail::create([
                                'test_series_id' => $testseries->id,
                                'type' => $testType,
                                'type_name' => $testTypeName,
                                'test_id' => $paperId,
                                'test_paper_type' => $paperType,
                                'test_generated_by' => $testGeneratedBy, // ✅ Added field
                            ]);
                            $totalPaperCount++; // ✅ Count total papers
                        }
                    }
                };

                // ✅ Save all types of papers dynamically
                $savePapers($additionalData['mcqselectedtestpaper'][$index] ?? [], 'MCQ');
                $savePapers($additionalData['passageselectedtestpaper'][$index] ?? [], 'Passage');
                $savePapers($additionalData['subjectiveselectedtestpaper'][$index] ?? [], 'Subjective');
                $savePapers($additionalData['combinedselectedtestpaper'][$index] ?? [], 'Combined');
            }
        }

        // ✅ Update total_paper after saving details
        $testseries->total_paper = $totalPaperCount;
        $testseries->save();

        return response()->json([
            'success' => true,
            'msgText' => 'Test Series Created Successfully!',
        ]);
    }

    public function testSeriesEdit($id)
    {
        $series = TestSeries::with('category')->findOrFail($id);
        $data['test_series'] = $series;
        $data['test_series_details'] = TestSeriesDetail::where('test_series_id', $id)->get();
        $data['commissions'] = ExaminationCommission::get();
        $data['subjects'] = [];
        $data['topics'] = [];

        if ($series->exam_com_id != '' && $series->exam_com_id > 0) {

            $data['categories'] = Category::where('exam_com_id', $series->exam_com_id)->get();
        } else {
            $data['categories'] = [];
        }

        if ($series->sub_category_id != NULL && $series->category_id != NULL) {
            $subcategories = SubCategory::where('category_id', $series->category_id)->get();
        } else {
            $subcategories = array();
        }
        $data['subcategories'] = $subcategories;
        return view('test-series.edit', $data);
    }

    public function testSeriesView($id)
    {
        $series = TestSeries::with('category', 'subcategory', 'commission', 'testseries', 'tests')->findOrFail($id);
        $data['test_series'] = $series;

        return view('test-series.view-test-series', $data);
    }

    public function testSeriesUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:512',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'price' => 'required',
            'mrp' => 'required',
            'discount' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'errors' => $validator->errors(),
            ]);
        }

        $test = TestSeries::findOrFail($id);
        $data = $request->all();

        // ✅ Handle logo upload
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        } else {
            $data['logo'] = $test->logo;
        }

        // ✅ Decode JSON
        $additionalData = json_decode($request->input('additionalData'), true);

        // ✅ Type mapping
        $typeNames = [
            1 => "Full Test",
            2 => "Subject Wise",
            3 => "Chapter Wise",
            4 => "Topic Wise",
            5 => "Current Affair",
            6 => "Previous Year",
        ];

        // ✅ Paper types
        $paperTypes = [
            'mcqselectedtestpaper' => 'MCQ',
            'passageselectedtestpaper' => 'Passage',
            'subjectiveselectedtestpaper' => 'Subjective',
            'combinedselectedtestpaper' => 'Combined',
        ];

        $keptIds = [];
        $totalPaperCount = 0;

        if (!empty($additionalData['testType'])) {
            foreach ($additionalData['testType'] as $index => $testType) {
                $testType = (int) $testType;
                $testTypeName = $typeNames[$testType] ?? 'Unknown Type';
                $testGeneratedBy = $additionalData['testSelections'][$index] ?? ($data['test_generated_by'][$index] ?? 'manual');

                foreach ($paperTypes as $key => $paperType) {
                    if (!empty($additionalData[$key][$index])) {
                        foreach ($additionalData[$key][$index] as $testPaperId) {

                            // ✅ Either update or create
                            $detail = TestSeriesDetail::firstOrNew([
                                'test_series_id' => $id,
                                'test_id' => $testPaperId,
                                'test_paper_type' => $paperType,
                                'type' => $testType,
                            ]);

                            $detail->type_name = $testTypeName;
                            $detail->test_generated_by = $testGeneratedBy;
                            $detail->save();

                            $keptIds[] = $detail->id;
                            $totalPaperCount++;
                        }
                    }
                }
            }
        }

        // ✅ Delete only removed ones
        if (!empty($keptIds)) {
            TestSeriesDetail::where('test_series_id', $id)
                ->whereNotIn('id', $keptIds)
                ->delete();
        } else {
            TestSeriesDetail::where('test_series_id', $id)->delete();
        }

        // ✅ Update TestSeries main table
        $test->update([
            'language' => $data['language'],
            'exam_com_id' => $data['exam_com_id'],
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'sub_category_id' => $data['sub_category_id'],
            'slug' => $data['slug'],
            'short_description' => $data['short_description'],
            'mrp' => $data['mrp'],
            'discount' => $data['discount'],
            'price' => $data['price'],
            'description' => $data['description'],
            'logo' => $data['logo'],
            'fee_type' => $data['fee_type'],
            'test_generated_by' => $data['test_generated_by'][0] ?? 'manual',
            'total_paper' => $totalPaperCount,
        ]);

        return response()->json([
            'success' => true,
            'msgText' => 'Test Series Updated Successfully!',
        ]);
    }




    public function testSeriesDelete($id)
    {
        $test_series = TestSeries::findOrFail($id);
        TestSeriesDetail::where('test_series_id', $id)->delete();
        $test_series->delete();
        return redirect()->back()->with('success', 'Test series deleted successfully!');
    }

    public function testSeriesQuestion()
    {
        return view('test-series.question');
    }

    public function testSeriesQuestionCreate()
    {
        return view('test-series.add-question');
    }

    public function upcomingExamIndex(Request $request)
    {
        if ($request->ajax()) {
            $data = UpcomingExam::with('exam_commission')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="column_checkbox career_checkbox" id="' . $row->id . '" name="career_checkbox[]" />';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('commission', function ($row) {
                    return $row->exam_commission->name;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        $status = '<span class="badge badge-success">Active</span>';
                    } else {
                        $status = '<span class="badge badge-secondary">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('upcoming.exam.edit', $row->id);
                    $actionBtn = ' <a href="' . $editUrl . '" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-file"></i></a>
                            <form action="' . route('upcoming.exam.delete', $row->id) . '" method="POST" style="display:inline">
                                ' . csrf_field() . '
                                ' . method_field("DELETE") . '
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                            </form>';
                    return $actionBtn;
                })
                ->rawColumns(['checkbox', 'created_at', 'commission', 'status', 'action'])
                ->make(true);
        }
        return view('upcoming-exams.index');
    }

    public function upcomingExamCreate()
    {
        $data['commissions'] = ExaminationCommission::get();
        return view('upcoming-exams.create', $data);
    }

    public function upcomingExamEdit($id)
    {
        $data['exam'] = UpcomingExam::findOrFail($id);
        $data['commissions'] = ExaminationCommission::get();
        return view('upcoming-exams.edit', $data);
    }

    public function upcomingExamUpdate($id, Request $request)
    {
        $exam = UpcomingExam::findOrFail($id);

        // Update the exam attributes with new data
        $exam->commission_id = $request->input('commission_id');
        $exam->examination_name = $request->input('examination_name');
        $exam->advertisement_date = $request->input('advertisement_date');
        $exam->form_distribution_date = $request->input('form_distribution_date');
        $exam->submission_last_date = $request->input('submission_last_date');
        $exam->examination_date = $request->input('examination_date');
        $exam->link = $request->input('link');

        // Handle file upload if a new PDF is uploaded
        if ($request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store('pdfs', 'public');
            $exam->pdf = $pdfPath;
        }

        // Save the updated exam record
        $exam->save();

        // Redirect to the index page with a success message
        return redirect()->route('upcoming.exam.index')->with('success', 'Exam updated successfully.');
    }

    public function upcomingExamStore(Request $request)
    {
        $request->validate([
            'commission_id' => 'required',
            'examination_name' => 'required|string|max:255',
            'advertisement_date' => 'required|date',
            'form_distribution_date' => 'required|date',
            'submission_last_date' => 'required|date',
            'examination_date' => 'required|date',
            'link' => 'nullable|url',
            'pdf' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('pdf')) {
            $data['pdf'] = $request->file('pdf')->store('examinations');
        }

        UpcomingExam::create($data);

        return redirect()->back()->with('success', 'Upcoming created successfully.');
    }

    public function upcomingExamDelete($id)
    {
        $exam = UpcomingExam::findOrFail($id);
        $exam->delete();
        return redirect()->back()->with('success', 'Upcoming Exam deleted successfully.');
    }

    public function questionBankIndex(Request $request)
    {
        try {
            $teacherId = $request->teacher_id; // 🔹 Added teacher filter

            // 🔹 Count stats for cards
            $totalQuestions = Question::count();
            $approvedQuestions = Question::where('status', 'Done')->count();
            $pendingQuestions = Question::where('status', 'Pending')->count();
            $rejectedQuestions = Question::where('status', 'Rejected')->count();


            if ($request->ajax()) {
                $language = $request->language;
                $question_type = $request->question_type;
                $fee_type = $request->fee_type;
                $question_category = $request->question_category;
                $exam_com_id = $request->exam_com_id;
                $category_id = $request->category_id;
                $sub_category_id = $request->sub_category_id;
                $subject_id = $request->subject_id;
                $chapter_id = $request->chapter_id;
                $topic_id = $request->topic_id;
                $year = $request->question_category == 1 ? $request->previous_year : "";

                // dd($request->all(), $teacherId);
                $questions = Question::query()
                    ->when($request->language, function ($query, $language) {
                        return $query->where('language', $language);
                    })
                    ->when($request->question_type, function ($query, $question_type) {
                        return $query->where('question_type', $question_type);
                    })
                    ->when($request->fee_type, function ($query, $fee_type) {
                        return $query->where('fee_type', $fee_type);
                    })
                    ->when($request->exam_com_id, function ($query, $exam_com_id) {
                        return $query->where('commission_id', $exam_com_id);
                    })
                    ->when($request->category_id, function ($query, $category_id) {
                        return $query->where('category_id', $category_id);
                    })
                    ->when($request->sub_category_id, function ($query, $sub_category_id) {
                        return $query->where('sub_category_id', $sub_category_id);
                    })
                    ->when($request->subject_id, function ($query, $subject_id) {
                        return $query->where('subject_id', $subject_id);
                    })
                    ->when($request->chapter_id, function ($query, $chapter_id) {
                        return $query->where('chapter_id', $chapter_id);
                    })
                    ->when($request->topic_id, function ($query, $topic_id) {
                        return $query->where('topic', $topic_id);
                    })
                    ->when($year, function ($query, $year) {
                        return $query->where('previous_year', $year);
                    })
                    ->when($request->teacher_id, function ($query, $teacherId) {
                        return $query->where('added_by_id', $teacherId);
                    }) // 🔹 Teacher filter added
                    ->where('status', '=', 'Done')
                    ->latest()
                    ->paginate(10);

                return view('question-bank.question-table')->with([
                    'questionBanks' => $questions
                ]);
            } else {
                $data['commissions'] = ExaminationCommission::get();

                $data['teachers'] = Teacher::where('status', 1)->get();

                $data['questionBanks'] = Question::when($teacherId, function ($query, $teacherId) {
                    return $query->where('added_by_id', $teacherId);
                })
                    ->where('status', '=', 'Done')
                    ->latest()
                    ->paginate(10);

                // 🔹 Pass count stats to Blade
                $data['totalQuestions'] = $totalQuestions;
                $data['approvedQuestions'] = $approvedQuestions;
                $data['pendingQuestions'] = $pendingQuestions;
                $data['rejectedQuestions'] = $rejectedQuestions;

                return view('question-bank.index', $data);
            }
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }

    }

    public function rejectQuestionBankIndex(Request $request)
    {
        $query = Question::where('status', 'Rejected');
        if ($request->ajax()) {
            // ✅ Filter by teacher or admin
            if ($request->filled('teacher_id')) {
                if ($request->teacher_id === 'admin') {
                    // Admin-added questions (added_by_type = 'user')
                    $query->where('added_by_type', '!=', 'teacher');
                } else {
                    // Teacher-added questions
                    $query->where('added_by_type', 'teacher')
                        ->where('added_by_id', $request->teacher_id);
                }
            }
            $questions = $query->paginate(10);
            return view('question-bank.rejected-question-table')->with([
                'questionBanks' => $questions
            ]);
        }

        $questions = $query->paginate(10);
        $teachers = \App\Models\Teacher::where('status', 1)->get();
        return view('question-bank.rejected')->with([
            'questionBanks' => $questions,
            'teachers' => $teachers,
        ]);
    }

    public function pendingQuestionBankIndex(Request $request)
    {
        // dd('here');
        $query = Question::whereIn('status', ['Pending', 'resubmitted']);

        if ($request->ajax()) {
            // ✅ Filter by teacher or admin
            if ($request->filled('teacher_id')) {
                if ($request->teacher_id === 'admin') {
                    // Admin-added questions (added_by_type = 'user')
                    $query->where('added_by_type', 'user');
                } else {
                    // Teacher-added questions
                    $query->where('added_by_type', 'teacher')
                        ->where('added_by_id', $request->teacher_id);
                }
            }
            $questions = $query->paginate(10);
            return view('question-bank.pending-question-table')->with([
                'questionBanks' => $questions
            ]);
        }

        $questions = $query->paginate(10);
        $teachers = \App\Models\Teacher::where('status', 1)->get();

        return view('question-bank.pending')->with([
            'questionBanks' => $questions,
            'teachers' => $teachers,
        ]);
    }




    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Done,Rejected',
            'note' => 'nullable|string|max:255',
        ]);

        $question = Question::findOrFail($id);
        $question->status = $request->status;
        $question->note = $request->status === 'Rejected' ? $request->note : null;

        // 🧩 Store who rejected (if applicable)
        if ($request->status === 'Rejected') {
            $question->rejected_by = auth()->id(); // admin who rejected
        } else {
            $question->rejected_by = null; // reset if approved
        }

        $question->save();

        // 🟢 If approved, credit wallet
        if ($request->status === 'Done' && $question->added_by_type === 'teacher') {
            $teacher = $question->addedBy;

            if ($teacher) {
                switch ($question->question_type) {
                    case 'MCQ':
                        $amount = $teacher->pay_per_mcq;
                        break;
                    case 'Subjective':
                        $amount = $teacher->pay_per_subjective;
                        break;
                    case 'Story Based':
                        $amount = $teacher->pay_per_story;
                        break;
                    default:
                        $amount = 0;
                }

                if ($amount > 0) {
                    WalletTransaction::create([
                        'teacher_id' => $teacher->id,
                        'type' => 'credit',
                        'amount' => $amount,
                        'source' => $question->question_type,
                        'details' => 'Approved Question ID: ' . $question->id,
                    ]);

                    $teacher->increment('wallet_balance', $amount);
                }
            }
        }

        return redirect()->back()->with('success', 'Question status updated successfully.');
    }




    public function questionBankCreate()
    {
        $data['commissions'] = ExaminationCommission::get();
        $data['subjects'] = [];
        $data['topics'] = [];
        $data['categories'] = [];
        return view('question-bank.create', $data);
    }

    public function questionBankEdit($id)
    {
        $question = Question::where('id', $id)->with('questionDeatils')->first();
        //dd($question);
        $data['commissions'] = ExaminationCommission::get();

        if ($question->commission_id != "") {
            $data['categories'] = Category::where('exam_com_id', $question->commission_id)->get();
        } else {
            $data['categories'] = [];
        }

        if ($question->category_id != "") {
            $data['subcategories'] = SubCategory::where('category_id', $question->category_id)->get();
        } else {
            $data['subcategories'] = [];
        }

        if ($question->sub_category_id != "") {
            $data['subjects'] = Subject::where('sub_category_id', $question->sub_category_id)->get();
        } else {
            $data['subjects'] = [];
        }

        if ($question->subject_id != "") {
            $data['chapters'] = Chapter::where('subject_id', $question->subject_id)->get();
        } else {
            $data['chapters'] = [];
        }

        if ($question->chapter_id != "") {
            $data['topics'] = CourseTopic::where('chapter_id', $question->chapter_id)->get();
        } else {
            $data['topics'] = [];
        }

        $data['question'] = $question;

        return view('question-bank.edit', $data);
    }
    public function questionBankView($id)
    {
        $question = Question::where('id', $id)->with('questionDeatils')->first();
        $data['question'] = $question;
        return view('question-bank.view', $data);
    }

    public function questionBankBulkUpload()
    {
        $data['commissions'] = ExaminationCommission::get();
        $data['subjects'] = [];
        $data['topics'] = [];
        $data['categories'] = [];
        return view('question-bank.bulk-upload', $data);
    }

    public function questionBankStore(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'language' => 'required',
            'question_category' => 'required',
            'question_type' => 'required',
            'fee_type' => 'required',
            'previous_year' => 'nullable|integer',
            'commission_id' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'nullable',
            'subject_id' => 'required',
            'chapter_id' => 'nullable',
            'topic' => 'nullable',
            'has_instruction' => 'nullable',
            'instruction' => 'nullable',
            'has_option_e' => 'nullable',
            'question.*' => 'required_if:question_type,MCQ',
            'answer.*' => 'required_if:question_type,MCQ',
            'option_a.*' => 'required_if:question_type,MCQ',
            'option_b.*' => 'required_if:question_type,MCQ',
            'option_c.*' => 'required_if:question_type,MCQ',
            'option_d.*' => 'required_if:question_type,MCQ',
            'option_e.*' => 'nullable|string',
            'passage_question_type' => 'required_if:question_type,Story Based',
        ]);

        // Create a new instance of QuestionBank model
        // $questionBank = new QuestionBank();

        // // Assign values to the model properties
        // $questionBank->language = $request->language;
        // $questionBank->question_category = $request->question_category;
        // $questionBank->commission_id = $request->commission_id;
        // $questionBank->previous_year = $request->previous_year;
        // $questionBank->category_id = $request->category_id;
        // $questionBank->sub_category_id = $request->sub_category_id;
        // $questionBank->chapter_id = $request->chapter_id;
        // $questionBank->subject_id = $request->subject_id;
        // $questionBank->topic = $request->topic;
        // $questionBank->has_instruction = $request->has_instruction ? true : false;
        // $questionBank->instruction = $request->has_instruction ? $request->instruction : null;
        // $questionBank->has_option_e = $request->has_option_e ? true : false;

        // // Save the question bank to the database
        // $questionBank->save();

        // Process and save each question associated with this question bank
        foreach ($request->question as $key => $questionData) {
            if (isset($questionData) && $questionData != "") {


                // QuestionBank::where('id',$questionBank->id)->update(['question' => $questionData]);
                // Create a new instance of Question model
                $question = new Question();

                // Assign values to the model properties
                $question->language = $request->language;
                $question->question_category = $request->question_category;
                $question->question_type = $request->question_type;
                $question->fee_type = $request->fee_type;
                $question->previous_year = $request->previous_year;
                $question->commission_id = $request->commission_id;
                $question->category_id = $request->category_id;
                $question->sub_category_id = $request->sub_category_id;
                $question->chapter_id = $request->chapter_id;
                $question->subject_id = $request->subject_id;
                $question->topic = $request->topic;
                $question->has_instruction = $request->has_instruction ? true : false;
                $question->instruction = $request->has_instruction ? $request->instruction : null;
                $question->has_option_e = $request->has_option_e ? true : false;
                $question->show_on_pyq = $request->show_on_pyq == "yes" ? "yes" : "no";
                // $question->question_bank_id = $questionBank->id; // Assign the question bank ID
                $question->question = $questionData;
                $question->answer = $request->answer[$key] ?? NULL;
                $question->option_a = $request->option_a[$key] ?? NULL;
                $question->option_b = $request->option_b[$key] ?? NULL;
                $question->option_c = $request->option_c[$key] ?? NULL;
                $question->option_d = $request->option_d[$key] ?? NULL;
                $question->option_e = $request->has_option_e ? $request->option_e[$key] ?? null : null;

                $question->passage_question_type = $request->passage_question_type ?? NULL;
                $question->answer_format = $request->answer_format[$key] ?? NULL;
                // Save solution from text editor instead of file upload
                $solutionText = $request->solution[$key] ?? null;
                $question->has_solution = (!empty($request->has_solution) && !empty($solutionText)) ? 'yes' : 'no';
                $question->solution = $solutionText;
                // Save the question to the database
                $question->added_by_id = auth()->id(); // teacher's ID
                $question->added_by_type = 'user';

                $question->save();

                if (isset($request->question_type) && $request->question_type == 'Story Based') {

                    if ($request->passage_question_type == 'reasoning_subjective') {
                        foreach ($request->reasoning_passage_questions as $t => $passagequestionData) {
                            if (isset($passagequestionData) && $passagequestionData != "") {
                                $detailData = [
                                    'question_id' => $question->id,
                                    'question' => $passagequestionData,
                                ];
                                // Optional per-subquestion solution
                                if (isset($request->reasoning_passage_solution[$t]) && $request->reasoning_passage_solution[$t] !== null) {
                                    $detailData['solution'] = $request->reasoning_passage_solution[$t];
                                }
                                QuestionDetail::create($detailData);
                            }

                        }
                    }
                    if ($request->passage_question_type == 'multiple_choice') {

                        foreach ($request->passage_mcq_questions as $k => $passagemcqquestionData) {
                            if (isset($passagemcqquestionData) && $passagemcqquestionData != "") {
                                $detailData = [
                                    'question_id' => $question->id,
                                    'question' => $passagemcqquestionData,
                                    'answer' => strtoupper($request->multiple_choice_passage_answer[$k]) ?? NULL,
                                    'option_a' => $request->multiple_choice_passage_option_a[$k],
                                    'option_b' => $request->multiple_choice_passage_option_b[$k],
                                    'option_c' => $request->multiple_choice_passage_option_c[$k],
                                    'option_d' => $request->multiple_choice_passage_option_d[$k],
                                ];
                                // Optional per-subquestion solution
                                if (isset($request->passage_mcq_solution[$k]) && $request->passage_mcq_solution[$k] !== null) {
                                    $detailData['solution'] = $request->passage_mcq_solution[$k];
                                }
                                QuestionDetail::create($detailData);
                            }
                        }
                    }

                }
            }

        }

        // Optionally, you can redirect the user after successful submission
        return redirect()->route('question.bank.index')->with('success', 'Questions created successfully.');
    }

    public function questionBankUpdate(Request $request, $id)
    {
        //dd($request->all());
        $validatedData = $request->validate([
            'language' => 'required',
            'question_category' => 'required',
            'question_type' => 'required',
            'fee_type' => 'required',
            'commission_id' => 'required',
            'previous_year' => 'nullable|integer',
            'category_id' => 'required',
            'sub_category_id' => 'nullable',
            'subject_id' => 'required',
            'chapter_id' => 'nullable',
            'topic' => 'nullable',
            'has_instruction' => 'nullable',
            'instruction' => 'nullable',
            'has_option_e' => 'nullable',
            'question.*' => 'required_if:question_type,MCQ',
            'answer.*' => 'required_if:question_type,MCQ',
            'option_a.*' => 'required_if:question_type,MCQ',
            'option_b.*' => 'required_if:question_type,MCQ',
            'option_c.*' => 'required_if:question_type,MCQ',
            'option_d.*' => 'required_if:question_type,MCQ',
            'option_e.*' => 'nullable|string',
            'passage_question_type' => 'required_if:question_type,Story Based',
        ]);

        // Create a new instance of QuestionBank model
        // $questionBank = new QuestionBank();

        // // Assign values to the model properties
        // $questionBank->language = $request->language;
        // $questionBank->question_category = $request->question_category;
        // $questionBank->commission_id = $request->commission_id;
        // $questionBank->previous_year = $request->previous_year;
        // $questionBank->category_id = $request->category_id;
        // $questionBank->sub_category_id = $request->sub_category_id;
        // $questionBank->chapter_id = $request->chapter_id;
        // $questionBank->subject_id = $request->subject_id;
        // $questionBank->topic = $request->topic;
        // $questionBank->has_instruction = $request->has_instruction ? true : false;
        // $questionBank->instruction = $request->has_instruction ? $request->instruction : null;
        // $questionBank->has_option_e = $request->has_option_e ? true : false;

        // // Save the question bank to the database
        // $questionBank->save();

        // Process and save each question associated with this question bank
        foreach ($request->question as $key => $questionData) {
            if (isset($questionData) && $questionData != "") {
                // QuestionBank::where('id',$questionBank->id)->update(['question' => $questionData]);
                // Create a new instance of Question model
                $question = Question::find($id);

                // Assign values to the model properties
                $question->language = $request->language;
                $question->question_category = $request->question_category;
                $question->question_type = $request->question_type;
                $question->fee_type = $request->fee_type;
                $question->commission_id = $request->commission_id;
                $question->previous_year = $request->previous_year;
                $question->category_id = $request->category_id;
                $question->sub_category_id = $request->sub_category_id;
                $question->chapter_id = $request->chapter_id;
                $question->subject_id = $request->subject_id;
                $question->topic = $request->topic;
                $question->has_instruction = $request->has_instruction ? true : false;
                $question->instruction = $request->has_instruction ? $request->instruction : null;
                $question->has_option_e = $request->has_option_e ? true : false;
                $question->show_on_pyq = $request->show_on_pyq == "yes" ? "yes" : "no";
                // $question->question_bank_id = $questionBank->id; // Assign the question bank ID
                $question->question = $questionData;
                $question->answer = $request->answer[$key] ?? NULL;
                $question->option_a = $request->option_a[$key] ?? NULL;
                $question->option_b = $request->option_b[$key] ?? NULL;
                $question->option_c = $request->option_c[$key] ?? NULL;
                $question->option_d = $request->option_d[$key] ?? NULL;
                $question->option_e = $request->has_option_e ? $request->option_e[$key] ?? null : null;
                $question->passage_question_type = $request->passage_question_type ?? NULL;
                $question->answer_format = $request->answer_format[$key] ?? NULL;
                // Save solution from text editor instead of file upload
                $solutionText = $request->solution[$key] ?? null;
                $question->has_solution = (!empty($request->has_solution) && !empty($solutionText)) ? 'yes' : 'no';
                $question->solution = $solutionText;

                // Save the question to the database
                $question->save();


                if (isset($request->question_type) && $request->question_type == 'Story Based') {
                    QuestionDetail::where('question_id', $question->id)->delete();
                    if ($request->passage_question_type == 'reasoning_subjective') {
                        foreach ($request->reasoning_passage_questions as $t => $passagequestionData) {
                            if (isset($passagequestionData) && $passagequestionData != "") {
                                $detailData = [
                                    'question_id' => $question->id,
                                    'question' => $passagequestionData,
                                ];
                                if (isset($request->reasoning_passage_solution[$t]) && $request->reasoning_passage_solution[$t] !== null) {
                                    $detailData['solution'] = $request->reasoning_passage_solution[$t];
                                }
                                QuestionDetail::create($detailData);
                            }

                        }
                    }
                    if ($request->passage_question_type == 'multiple_choice') {

                        foreach ($request->passage_mcq_questions as $k => $passagemcqquestionData) {
                            if (isset($passagemcqquestionData) && $passagemcqquestionData != "") {
                                $detailData = [
                                    'question_id' => $question->id,
                                    'question' => $passagemcqquestionData,
                                    'answer' => strtoupper($request->multiple_choice_passage_answer[$k]) ?? NULL,
                                    'option_a' => $request->multiple_choice_passage_option_a[$k],
                                    'option_b' => $request->multiple_choice_passage_option_b[$k],
                                    'option_c' => $request->multiple_choice_passage_option_c[$k],
                                    'option_d' => $request->multiple_choice_passage_option_d[$k],
                                ];
                                if (isset($request->passage_mcq_solution[$k]) && $request->passage_mcq_solution[$k] !== null) {
                                    $detailData['solution'] = $request->passage_mcq_solution[$k];
                                }
                                QuestionDetail::create($detailData);
                            }
                        }
                    }

                }
                // QuestionBank::where('id', $questionBank->id)->update(['question' => $questionData]);
            }
        }

        // Optionally, you can redirect the user after successful submission
        return redirect()->route('question.bank.index')->with('success', 'Questions updated successfully.');
    }

    public function ImportQuestions(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'language' => 'required',
            'question_category' => 'required',
            'question_type' => 'required',
            'fee_type' => 'required',
            'commission_id' => 'required',
            'previous_year' => 'nullable|integer',
            'category_id' => 'required',
            'subject_id' => 'required',
            'topic' => 'nullable',

            'file' => 'required|mimes:docx,xlsx',
        ]);

        // Create a new instance of QuestionBank model
        // $questionBank = new QuestionBank();

        // // Assign values to the model properties
        // $questionBank->language = $request->language;
        // $questionBank->question_category = $request->question_category;
        // $questionBank->commission_id = $request->commission_id;
        // $questionBank->previous_year = $request->previous_year;
        // $questionBank->category_id = $request->category_id;
        // $questionBank->sub_category_id = $request->sub_category_id;
        // $questionBank->chapter_id = $request->chapter_id;
        // $questionBank->subject_id = $request->subject_id;
        // $questionBank->topic = $request->topic;



        try {
            $questionData = array();
            if ($request->file->getClientOriginalExtension() == 'docx') {
                $filename = $request->file;
                $time = microtime();
                $outputPath = storage_path($time . '.html');

                $phpWord = \PhpOffice\PhpWord\IOFactory::load($filename);
                $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
                $htmlWriter->save($outputPath);
                $this->replaceThWithTd($outputPath);
                $dom = new Dom;
                $dom->loadFromFile($outputPath);


                $tables = $dom->find('table');
                $successCount = 0;
                $pendingCount = 0;
                $rejectedCount = 0;
                $successdata = [];
                $pendingdata = [];
                $rejecteddata = [];
                $option_a = NULL;
                $option_b = NULL;
                $option_c = NULL;
                $option_d = NULL;
                $option_e = NULL;
                $image = NULL;
                $solution = NULL;
                $answer = NULL;
                $instruction = NULL;
                $has_option_e = false;
                $has_solution = "no";
                $has_instruction = false;
                if ($request->question_type == 'MCQ') {
                    for ($i = 0; $i < count($tables); $i++) {
                        try {
                            $question = $tables[$i]->find('tr', 0)->find('td', 1)->innerHtml;
                            if ($tables[$i]->find('tr', 1)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $option_a = NULL;
                            } else {
                                $option_a = $tables[$i]->find('tr', 1)->find('td', 1)->find('p')->innerHtml;
                            }
                            if ($tables[$i]->find('tr', 2)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $option_b = NULL;
                            } else {
                                $option_b = $tables[$i]->find('tr', 2)->find('td', 1)->find('p')->innerHtml;
                            }
                            if ($tables[$i]->find('tr', 3)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $option_c = NULL;
                            } else {
                                $option_c = $tables[$i]->find('tr', 3)->find('td', 1)->find('p')->innerHtml;
                            }
                            if ($tables[$i]->find('tr', 4)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $option_d = NULL;
                            } else {
                                $option_d = $tables[$i]->find('tr', 4)->find('td', 1)->find('p')->innerHtml;
                            }

                            $rejectQuestion = false;
                            $rejectNote = '';

                            // Option E (optional)
                            $tr5 = $tables[$i]->find('tr', 5);
                            $td5 = $tr5 ? $tr5->find('td', 1) : null;
                            $p5 = $td5 ? $td5->find('p') : null;
                            if ($p5 === null || $p5->innerHtml === '&nbsp;') {
                                $option_e = null;
                                $has_option_e = false;
                            } else {
                                $option_e = $p5->innerHtml;
                                $has_option_e = true;
                            }

                            // Answer (mandatory)
                            $tr6 = $tables[$i]->find('tr', 6);
                            $td6 = $tr6 ? $tr6->find('td', 1) : null;
                            $p6 = $td6 ? $td6->find('p') : null;
                            if ($p6 === null) {
                                $answer = null;
                                $rejectQuestion = true;
                                $rejectNote = 'Question Format Issue';
                            } else {
                                $span = $p6->find('span');
                                $answer = $span ? $span->innerHtml : null;
                                if (!$answer) {
                                    $rejectQuestion = true;
                                    $rejectNote = 'Question Format Issue';
                                }
                            }

                            // Instruction (optional)
                            $tr7 = $tables[$i]->find('tr', 7);
                            $td7 = $tr7 ? $tr7->find('td', 1) : null;
                            $p7 = $td7 ? $td7->find('p') : null;
                            if ($p7 === null || $p7->innerHtml === '&nbsp;') {
                                $instruction = null;
                                $has_instruction = false;
                            } else {
                                $instruction = $td7->innerHtml;
                                $has_instruction = true;
                            }

                            // Solution (optional) - try next rows after instruction
                            $solution = null;
                            $has_solution = 'no';
                            $tryRows = [8, 9];
                            foreach ($tryRows as $rowIdx) {
                                $tr = $tables[$i]->find('tr', $rowIdx);
                                $td = $tr ? $tr->find('td', 1) : null;
                                if ($td) {
                                    $content = $td->innerHtml;
                                    if ($content !== null && trim($content) !== '' && $content !== '&nbsp;') {
                                        $solution = $content;
                                        $has_solution = 'yes';
                                        break;
                                    }
                                }
                            }

                            // Finally, set status once
                            if ($rejectQuestion) {
                                $questionData['status'] = 'Rejected';
                                $questionData['note'] = $rejectNote;
                            } else {
                                $questionData['status'] = 'Done'; // or success after insert
                            }

                            // $que =   QuestionBank::where('question',$question)
                            // // ->where('question_category',$request->question_category)
                            // // ->where('commission_id',$request->commission_id)
                            // // ->where('category_id',$request->category_id)
                            //  ->where('subject_id',$request->subject_id)
                            // ->where('topic',$request->topic);

                            // $que = $que->first();

                            // Create a new instance of QuestionBank model
                            // $questionBank = new QuestionBank();

                            // // Assign values to the model properties
                            // $questionBank->language = $request->language;
                            // $questionBank->question_category = $request->question_category;
                            // $questionBank->commission_id = $request->commission_id;
                            // $questionBank->previous_year = $request->previous_year;
                            // $questionBank->category_id = $request->category_id;
                            // $questionBank->subject_id = $request->subject_id;
                            // $questionBank->topic = $request->topic;
                            // $questionBank->has_instruction = $has_instruction;
                            // $questionBank->instruction = $instruction;
                            // $questionBank->has_option_e = $has_option_e;
                            // $questionBank->question = $question;
                            // // Save the question bank to the database
                            // $questionBank->save();



                            $questionData['language'] = $request->language;
                            $questionData['question_category'] = $request->question_category;
                            $questionData['question_type'] = $request->question_type;
                            $questionData['fee_type'] = $request->fee_type;
                            $questionData['commission_id'] = $request->commission_id;
                            $questionData['previous_year'] = $request->previous_year;
                            $questionData['category_id'] = $request->category_id;
                            $questionData['sub_category_id'] = $request->sub_category_id;
                            $questionData['chapter_id'] = $request->chapter_id;
                            $questionData['subject_id'] = $request->subject_id;
                            $questionData['topic'] = $request->topic;
                            //$questionData['question_bank_id'] = $questionBank->id ?? 0;
                            $questionData['question'] = $question;
                            $questionData['option_a'] = $option_a;
                            $questionData['option_b'] = $option_b;
                            $questionData['option_c'] = $option_c;
                            $questionData['option_d'] = $option_d;
                            $questionData['option_e'] = $option_e;
                            $questionData['image'] = $image;
                            $questionData['answer'] = strtoupper(Str::of($answer)->trim());
                            $questionData['has_solution'] = $has_solution;
                            $questionData['solution'] = $solution;

                            $questionData['added_by_id'] = auth()->id(); // Logged in teacher/user
                            $questionData['added_by_type'] = 'user';

                            $que = Question::where('question', $question)->where('commission_id', $request->commission_id)->where('category_id', $request->category_id)
                                ->where('sub_category_id', $request->sub_category_id)
                                ->where('chapter_id', $request->chapter_id);
                            if ($request->previous_year) {
                                $que = $que->where('previous_year', $request->previous_year);
                            }
                            $que = $que->first();

                            if ($que) {
                                $rejectedCount = $rejectedCount + 1;
                                $questionData['status'] = "Rejected";
                                $questionData['note'] = "Already Exists Question.";
                                $qsave = Question::create($questionData);

                            } else {

                                $insert = Question::create($questionData);
                                if ($insert) {
                                    $successCount = $successCount + 1;
                                    $successdata[] = $questionData;
                                }

                            }
                        } catch (\Exception $ex) {
                            $question = $tables[$i]->find('tr', 0)->find('td', 1)->innerHtml ?? NULL;
                            $rejectedCount = $rejectedCount + 1;
                            $questionData['status'] = "Rejected";
                            $questionData['question_type'] = $request->question_type;
                            $questionData['question'] = $question;
                            $questionData['note'] = 'Question Format Issue';
                            Question::create($questionData);

                        }

                    }
                } elseif ($request->question_type == 'Subjective') {

                    for ($i = 1; $i < count($tables); $i++) {
                        try {
                            $question = $tables[$i]->find('tr', 0)->find('td', 1)->innerHtml;
                            if ($tables[$i]->find('tr', 1)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $image = NULL;
                            } else {
                                $imageElement = $tables[$i]->find('tr', 1)->find('td', 1)->find('p')->find('img');

                                if (count($imageElement) > 0) {
                                    $image_64 = $tables[$i]->find('tr', 1)->find('td', 1)->find('p')->find('img')->src;
                                    $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                                    $image = 'question/' . Str::random(40) . '.' . $extension;
                                    Storage::put($image, file_get_contents($image_64));
                                } else {
                                    $image = NULL;
                                }


                            }
                            $answer_format = NULL;
                            if ($tables[$i]->find('tr', 2)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $answer_format = NULL;
                            } else {
                                $answer_format = $tables[$i]->find('tr', 2)->find('td', 1)->find('p')->innerHtml;
                            }
                            if ($tables[$i]->find('tr', 3)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $solution = NULL;
                                $has_solution = 'no';
                            } else {
                                $solution = $tables[$i]->find('tr', 3)->find('td', 1)->innerHtml;
                                $has_solution = 'yes';
                            }
                            if ($tables[$i]->find('tr', 4)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                $instruction = NULL;
                                $has_instruction = false;
                            } else {
                                $instruction = $tables[$i]->find('tr', 4)->find('td', 1)->innerHtml;
                                $has_instruction = true;
                            }
                            $questionData['language'] = $request->language;
                            $questionData['question_category'] = $request->question_category;
                            $questionData['question_type'] = $request->question_type;
                            $questionData['fee_type'] = $request->fee_type;
                            $questionData['commission_id'] = $request->commission_id;
                            $questionData['previous_year'] = $request->previous_year;
                            $questionData['category_id'] = $request->category_id;
                            $questionData['sub_category_id'] = $request->sub_category_id;
                            $questionData['chapter_id'] = $request->chapter_id;
                            $questionData['subject_id'] = $request->subject_id;
                            $questionData['topic'] = $request->topic;
                            $questionData['question'] = $question;
                            $questionData['solution'] = $solution;
                            $questionData['image'] = $image;
                            $questionData['answer_format'] = strip_tags($answer_format);
                            $questionData['has_solution'] = $has_solution;
                            $questionData['instruction'] = $instruction;
                            $questionData['has_instruction'] = $has_instruction;

                            $que = Question::where('question', $question)->where('commission_id', $request->commission_id)->where('category_id', $request->category_id)
                                ->where('sub_category_id', $request->sub_category_id)
                                ->where('chapter_id', $request->chapter_id);
                            if ($request->previous_year) {
                                $que = $que->where('previous_year', $request->previous_year);
                            }
                            $que = $que->first();
                            if (!$answer_format) {
                                $rejectedCount = $rejectedCount + 1;
                                $questionData['status'] = "Rejected";
                                $questionData['note'] = "Please enter Answer format";
                                $qsave = Question::create($questionData);

                            } elseif ($que) {
                                $rejectedCount = $rejectedCount + 1;
                                $questionData['status'] = "Rejected";
                                $questionData['note'] = "Already Exists Question.";
                                $qsave = Question::create($questionData);
                            } else {
                                $successCount = $successCount + 1;
                                $insert = Question::create($questionData);
                                $successdata[] = $questionData;
                            }

                        } catch (\Exception $ex) {

                            $question = $tables[$i]->find('tr', 0)->find('td', 1)->innerHtml;
                            $rejectedCount = $rejectedCount + 1;

                            $questionData['question_type'] = $request->question_type;
                            $questionData['question'] = $question;
                            $questionData['note'] = 'Question Format Issue';

                            $questionData['status'] = "Rejected";
                            Question::create($questionData);
                        }
                    }
                } elseif ($request->question_type == 'Story Based') {
                    // try {

                    $question = $tables[1]->find('tr', 0)->find('td', 1)->innerHtml;
                    if ($tables[1]->find('tr', 1)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                        $image = NULL;
                    } else {
                        $imageElement = $tables[1]->find('tr', 1)->find('td', 1)->find('p')->find('img');

                        if (count($imageElement) > 0) {
                            $image_64 = $tables[1]->find('tr', 1)->find('td', 1)->find('p')->find('img')->src;
                            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                            $image = 'question/' . Str::random(40) . '.' . $extension;
                            Storage::put($image, file_get_contents($image_64));
                        } else {
                            $image = NULL;
                        }


                    }
                    // if ($tables[1]->find('tr', 2)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                    $solution = NULL;
                    $has_solution = 'no';
                    // } else {
                    //     $solution = $tables[1]->find('tr', 2)->find('td', 1)->innerHtml;
                    //     $has_solution = 'yes';
                    // }
                    if ($tables[1]->find('tr', 2)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                        $instruction = NULL;
                        $has_instruction = false;
                    } else {
                        $instruction = $tables[1]->find('tr', 2)->find('td', 1)->innerHtml;
                        $has_instruction = true;
                    }
                    $answer_format = NULL;
                    if ($request->passage_question_type == 'reasoning_subjective') {
                        if ($tables[1]->find('tr', 3)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                            $answer_format = NULL;
                        } else {
                            $answer_format = $tables[1]->find('tr', 3)->find('td', 1)->find('p');
                        }
                    }


                    $questionData['language'] = $request->language;
                    $questionData['question_category'] = $request->question_category;
                    $questionData['question_type'] = $request->question_type;
                    $questionData['passage_question_type'] = $request->passage_question_type;
                    $questionData['fee_type'] = $request->fee_type;
                    $questionData['commission_id'] = $request->commission_id;
                    $questionData['previous_year'] = $request->previous_year;
                    $questionData['category_id'] = $request->category_id;
                    $questionData['sub_category_id'] = $request->sub_category_id;
                    $questionData['chapter_id'] = $request->chapter_id;
                    $questionData['subject_id'] = $request->subject_id;
                    $questionData['topic'] = $request->topic;
                    $questionData['question'] = $question;
                    $questionData['solution'] = $solution;
                    $questionData['answer_format'] = $answer_format;
                    $questionData['has_solution'] = $has_solution;
                    $questionData['instruction'] = $instruction;
                    $questionData['has_instruction'] = $has_instruction;

                    $que = Question::where('question', $question)->where('commission_id', $request->commission_id)->where('category_id', $request->category_id)
                        ->where('sub_category_id', $request->sub_category_id)
                        ->where('chapter_id', $request->chapter_id);
                    if ($request->previous_year) {
                        $que = $que->where('previous_year', $request->previous_year);
                    }
                    $que = $que->first();
                    if ($que) {
                        $rejectedCount = $rejectedCount + 1;
                        $questionData['status'] = "Rejected";
                        $questionData['note'] = "Already Exists Question.";
                        $ques = Question::create($questionData);

                    } else {
                        $successCount = $successCount + 1;
                        $successdata[] = $questionData;
                        $ques = Question::create($questionData);
                    }

                    if ($ques) {
                        //if($request->passage_question_type == 'reasoning_subjective') {
                        for ($i = 2; $i < count($tables); $i++) {

                            $option_c = $tables[$i]->find('tr', 3);
                            if (!isset($option_c) && $option_c == "") {
                                $passage_question = $tables[$i]->find('tr', 0)->find('td', 1)->innerHtml;
                                $passage_answer_format = NULL;
                                if ($tables[$i]->find('tr', 1)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                    $passage_answer_format = NULL;
                                } else {
                                    $passage_answer_format = $tables[$i]->find('tr', 1)->find('td', 1)->find('p');
                                }
                                // Try to read per-subquestion solution at row 2
                                $detail_solution = NULL;
                                $solTr = $tables[$i]->find('tr', 2);
                                $solTd = $solTr ? $solTr->find('td', 1) : null;
                                if ($solTd && trim($solTd->innerHtml) !== '' && $solTd->innerHtml !== '&nbsp;') {
                                    $detail_solution = $solTd->innerHtml;
                                }
                                $question_detail = ([
                                    'question_id' => $ques->id,
                                    'question' => $passage_question,
                                    'answer_format' => $passage_answer_format,
                                ]);
                                if ($detail_solution !== NULL) {
                                    $question_detail['solution'] = $detail_solution;
                                }
                                QuestionDetail::create($question_detail);
                            } else {
                                $passage_question = $tables[$i]->find('tr', 0)->find('td', 1)->innerHtml;
                                $option_a = $tables[$i]->find('tr', 1)->find('td', 1)->find('p')->innerHtml;
                                $option_b = $tables[$i]->find('tr', 2)->find('td', 1)->find('p')->innerHtml;
                                $option_c = $tables[$i]->find('tr', 3)->find('td', 1)->find('p')->innerHtml;
                                $option_d = $tables[$i]->find('tr', 4)->find('td', 1)->find('p')->innerHtml;
                                if ($tables[$i]->find('tr', 5)->find('td', 1)->find('p')->innerHtml == '&nbsp;') {
                                    $option_e = NULL;
                                    $has_option_e = false;
                                } else {
                                    $option_e = $tables[$i]->find('tr', 5)->find('td', 1)->find('p')->innerHtml;
                                    $has_option_e = true;
                                }
                                $passage_answer = $tables[$i]->find('tr', 6)->find('td', 1)->find('p')->innerHtml;
                                // Try to read per-subquestion solution at row 7 or 8
                                $detail_solution = NULL;
                                $solTr = $tables[$i]->find('tr', 7);
                                $solTd = $solTr ? $solTr->find('td', 1) : null;
                                if ($solTd && trim($solTd->innerHtml) !== '' && $solTd->innerHtml !== '&nbsp;') {
                                    $detail_solution = $solTd->innerHtml;
                                } else {
                                    $solTr2 = $tables[$i]->find('tr', 8);
                                    $solTd2 = $solTr2 ? $solTr2->find('td', 1) : null;
                                    if ($solTd2 && trim($solTd2->innerHtml) !== '' && $solTd2->innerHtml !== '&nbsp;') {
                                        $detail_solution = $solTd2->innerHtml;
                                    }
                                }
                                $question_detail = ([
                                    'question_id' => $ques->id,
                                    'question' => $passage_question,
                                    'answer' => strtoupper(Str::of(strip_tags($passage_answer))->trim()),
                                    'option_a' => $option_a,
                                    'option_b' => $option_b,
                                    'option_c' => $option_c,
                                    'option_d' => $option_d,
                                    'option_e' => $option_e,
                                    'has_option_e' => $has_option_e,
                                ]);
                                if ($detail_solution !== NULL) {
                                    $question_detail['solution'] = $detail_solution;
                                }
                                QuestionDetail::create($question_detail);
                            }

                        }




                        // } elseif($request->passage_question_type == 'multiple_choice') {

                        // }
                    }

                    // } catch (\Exception $ex) {
                    //     $question = $tables[1]->find('tr', 0)->find('td', 1)->innerHtml;
                    //     $rejectedCount = $rejectedCount + 1;
                    //     $questionData = [];
                    //     $questionData['question'] = $question;
                    //     $questionData['note'] = 'Question Format Issue';
                    //     $questionData['question_type'] = $request->question_type;
                    //     $questionData['status'] = "Rejected";
                    //     $ques = Question::create($questionData);
                    // }
                }

                DB::commit();
                return redirect()->route('question.bank.index')->with('success', 'Questions created successfully.');
                // session(['success_data' => $successdata]);
                // session(['pending_data' => $pendingdata]);
                // session(['rejected_data' => $rejecteddata]);
                // return response()->json([
                //     'success' => true,
                //     'successCount' => $successCount,
                //     'rejectedCount' => $rejectedCount,
                //     'pendingCount' => count($tables) - $successCount - $rejectedCount - 1,
                //     'msgText' => 'Upload Successfull',
                // ]);
                // return redirect(route('admin.upload-question','type='.$exam_type))->with('success','Upload Successfull');
            } else {
                $import = new QuestionsImport($request->all());

                $import->import($request->file);
                // dd($import);
                $file = $request->file('file');

                $successCount = $import->getSuccessCount();
                $rejectedCount = $import->getRejectedCount();
                $pendingCount = $import->getRowCount() - $successCount - $rejectedCount;
                DB::commit();
                // return response()->json([
                //     'success' => true,
                //     'successCount' => $successCount,
                //     'rejectedCount' => $rejectedCount,
                //     'pendingCount' => $pendingCount,
                //     'msgText' => 'Question Updated Successfully',
                // ]);
                return redirect()->route('question.bank.index')->with('success', 'Questions created successfully.');
                // return redirect(route('admin.upload-question','type='.$exam_type))->with('success','Upload Successfull');
            }
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            return redirect()->route('question.bank.bulk-upload')->with('success', 'Something went wrong.');
        }


    }

    public function questionBankDelete(Request $request, $id)
    {
        try {
            $question = Question::findOrFail($id);
            $question->delete();

            // If AJAX request → return JSON
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Question deleted successfully.'
                ]);
            }

            // Normal (non-AJAX) delete
            return redirect()->back()->with('success', 'Question Bank deleted successfully.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Something went wrong while deleting the question.',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Something went wrong while deleting the question.');
        }
    }



    public function batchesProgrammeIndex()
    {
        $data['batches'] = BatchProgramme::all();
        return view('batches-programme.index', $data);
    }

    public function batchesProgrammeCreate()
    {
        return view('batches-programme.create');
    }

    public function batchesProgrammeStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'start_date' => 'required|date',
            'mrp' => 'required|numeric',
            'discount' => 'nullable|integer',
            'offered_price' => 'required|numeric',
            'batch_heading' => 'required|string|max:255',
            'short_description' => 'required|string',
            'batch_overview' => 'required|string',
            'detail_content' => 'required|string',
            'thumbnail_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'youtube_url' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'image_alt_tag' => 'nullable|string|max:255',
        ]);

        // Handle file uploads
        if ($request->hasFile('thumbnail_image')) {
            $thumbnailPath = $request->file('thumbnail_image')->store('uploads/thumbnails', 'public');
            $validatedData['thumbnail_image'] = $thumbnailPath;
        }

        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('uploads/banners', 'public');
            $validatedData['banner_image'] = $bannerPath;
        }

        // Create a new BatchAndProgramme instance and save the data
        BatchProgramme::create($validatedData);

        // Redirect back with a success message
        return redirect()->route('batches-programme.index')->with('success', 'Batch and Programme created successfully!');
    }

    public function batchesProgrammeDelete($id)
    {
        $batch = BatchProgramme::findOrFail($id);
        $batch->delete();
        return redirect()->back()->with('success', 'Batch and Programme deleted successfully!');
    }

    public function headerSettingsIndex()
    {
        $data['settings'] = HeaderSetting::first();
        return view('admin-settings.header', $data);
    }

    public function headerSettingsStore(Request $request)
    {
        $request->validate([
            'script' => 'nullable|string',
            'twitter_card' => 'nullable|string',
            'og_tags' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'canonical_url' => 'nullable|string',
            'company_logo' => 'nullable|image',
            'contact_number' => 'nullable|string',
            'email_id' => 'nullable|email',
            'whatsapp_number' => 'nullable|string',
            'address' => 'nullable|string',
            'map_embbed' => 'nullable',
        ]);

        $data = $request->all();
        if ($request->hasFile('company_logo')) {
            $data['company_logo'] = $request->file('company_logo')->store('uploads', 'public');
        }

        HeaderSetting::updateOrCreate(['id' => 1], $data);

        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    public function socialMediaIndex()
    {
        $data['settings'] = SocialMedia::first();
        return view('admin-settings.social-media', $data);
    }

    public function socialMediaStore(Request $request)
    {
        $validatedData = $request->validate([
            'youtube' => 'nullable|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'linkdin' => 'nullable|string',
            'twitter' => 'nullable|string',
            'whatsapp' => 'nullable|string',
        ]);

        SocialMedia::updateOrCreate(['id' => 1], $validatedData);

        return redirect()->back()->with('success', 'Social media settings updated successfully!');
    }

    public function feedIndex()
    {
        $data['feeds'] = FeedTestimonial::where('type', 1)->get();
        return view('enquiries.feedback', $data);
    }

    public function testimonialsIndex()
    {
        $data['feeds'] = FeedTestimonial::where('type', 2)->get();
        return view('enquiries.testimonial', $data);
    }

    public function testimonialView($id)
    {
        $data['testimonial'] = FeedTestimonial::where('type', 2)->where('id', $id)->first();
        return view('enquiries.testimonial-view', $data);
    }

    public function feedDelete($id)
    {
        $feeds = FeedTestimonial::find($id);
        $feeds->delete();
        return redirect()->back()->with('success', 'Record deleted successfully!');
    }

    public function updateFeedStatus(Request $request, $id)
    {
        $feed = FeedTestimonial::findOrFail($id);
        $feed->status = $request->input('status');
        $feed->save();

        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function updateapproveStatus(Request $request, $id)
    {
        $feed = FeedTestimonial::findOrFail($id);
        $feed->is_approved = 1;
        $feed->save();

        return redirect()->back()->with('success', 'Approved successfully');
    }

    public function bannerSettingsIndex()
    {
        $data['banners'] = Banner::all();
        return view('admin-settings.banner', $data);
    }

    public function bannerSettingsEdit($id)
    {
        $data['banner'] = Banner::findOrFail($id);
        return view('admin-settings.ajax.edit-banner', $data);
    }

    public function bannerSettingsUpdate(Request $request)
    {
        $banner = Banner::findOrFail($request->id);
        $banner->position = $request->position;
        $banner->name = $request->name;
        $banner->link = $request->link;

        // Handle the file upload
        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($banner->image) {
                Storage::delete('public/' . $banner->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('front-banners', 'public');
            $banner->image = $imagePath;
        }

        // Save the updates
        $banner->save();

        // Redirect back with a success message
        return redirect()->route('settings.banner.index')->with('success', 'Banner updated successfully!');
    }

    public function bannerSettingsStore(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|max:204800', // 200KB max
            'position' => 'required|integer|min:1|max:10',
            'name' => 'required|string|max:255',
            'link' => 'nullable|url|max:255',
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->image->store('front-banners', 'public');
        }

        // Create a new banner
        $banner = new Banner();
        $banner->image = $imagePath;
        $banner->position = $request->input('position');
        $banner->name = $request->input('name');
        $banner->link = $request->input('link', '');
        $banner->save();

        return redirect()->route('settings.banner.index')->with('success', 'Banner added successfully.');
    }

    public function bannerSettingsDelete($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return redirect()->route('settings.banner.index')->with('success', 'Banner deleted successfully.');
    }

    public function programmeSettingsIndex()
    {
        $data['programmeFeature'] = ProgrammeFeature::first();
        return view('admin-settings.programme-feature', $data);
    }

    public function programmeSettingsStore(Request $request)
    {

        $programmeFeature = ProgrammeFeature::firstOrNew();

        if ($request->hasFile('banner')) {
            $programmeFeature->banner = $request->banner->store('uploads', 'public');
        }

        $programmeFeature->title = $request->title;
        $programmeFeature->short_description = $request->short_description;
        $programmeFeature->heading = $request->heading;
        $programmeFeature->feature = $request->feature;

        if ($request->hasFile('icon1')) {
            $programmeFeature->icon1 = $request->icon1->store('uploads', 'public');
        }

        if ($request->hasFile('icon2')) {
            $programmeFeature->icon2 = $request->icon2->store('uploads', 'public');
        }

        if ($request->hasFile('icon3')) {
            $programmeFeature->icon3 = $request->icon3->store('uploads', 'public');
        }

        if ($request->hasFile('icon4')) {
            $programmeFeature->icon4 = $request->icon4->store('uploads', 'public');
        }

        $programmeFeature->icon_title1 = $request->icon_title1;
        $programmeFeature->icon_title2 = $request->icon_title2;
        $programmeFeature->icon_title3 = $request->icon_title3;
        $programmeFeature->icon_title4 = $request->icon_title4;

        $programmeFeature->save();

        return redirect()->route('settings.programme_feature.index')->with('success', 'Programme Feature created successfully.');
    }

    public function marqueeSettingsIndex()
    {
        $data['marquees'] = Marquee::all();
        return view('admin-settings.marquee', $data);
    }

    public function marqueeSettingsStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:255',
        ]);

        $data = $request->only([
            'title',
            'link',
        ]);

        Marquee::create($data);

        return redirect()->route('settings.marquee.index')->with('success', 'Marquee created successfully.');
    }

    public function marqueeSettingsDelete($id)
    {
        $marquee = Marquee::findOrFail($id);
        $marquee->delete();

        return redirect()->route('settings.marquee.index')->with('success', 'Marquee deleted successfully.');
    }

    public function marqueeSettingsEdit($id)
    {
        $data['marquee'] = Marquee::findOrFail($id);
        return view('admin-settings.ajax.edit-marquee', $data);
    }

    public function marqueeSettingsUpdate(Request $request)
    {
        $marquee = Marquee::findOrFail($request->id);
        $marquee->title = $request->title;
        $marquee->link = $request->link;
        $marquee->save();
        return redirect()->route('settings.marquee.index')->with('success', 'Marquee updated successfully.');
    }

    public function popSettingsIndex()
    {
        $data['popUp'] = PopUp::first();
        return view('admin-settings.pop-up', $data);
    }

    public function popSettingsStore(Request $request)
    {
        $pop = PopUp::firstOrNew();

        if ($request->hasFile('pop_image')) {
            $pop_image = $request->file('pop_image')->store('uploads', 'public');
        }
        $pop->pop_image = $pop_image;
        $pop->title = $request->title;
        $pop->link = $request->link;
        $pop->save();

        return redirect()->back()->with('success', 'PopUp created successfully.');
    }

    public function featureSettingsIndex()
    {
        $data['feature'] = Feature::first();
        return view('admin-settings.feature', $data);
    }

    public function featureSettingsStore(Request $request)
    {
        $feature = Feature::firstOrNew();

        // Assign the request data to the model attributes
        $feature->heading = $request->input('heading');
        $feature->title1 = $request->input('title1');
        $feature->title2 = $request->input('title2');
        $feature->title3 = $request->input('title3');
        $feature->short_description1 = $request->input('short_description1');
        $feature->short_description2 = $request->input('short_description2');
        $feature->short_description3 = $request->input('short_description3');

        // Handle image upload for icon1
        if ($request->hasFile('icon1')) {
            $icon1Path = $request->file('icon1')->store('uploads', 'public');
            $feature->icon1 = $icon1Path;
        }

        // Handle image upload for icon2
        if ($request->hasFile('icon2')) {
            $icon2Path = $request->file('icon2')->store('uploads', 'public');
            $feature->icon2 = $icon2Path;
        }

        // Handle image upload for icon3
        if ($request->hasFile('icon3')) {
            $icon3Path = $request->file('icon3')->store('uploads', 'public');
            $feature->icon3 = $icon3Path;
        }

        // Save the feature
        $feature->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Feature updated successfully!');
    }

    public function getCategories($id)
    {
        $categories = Category::where('exam_com_id', $id)->get();
        return response()->json(['categories' => $categories]);
    }

    public function getSubCategories($id)
    {
        $subcategories = SubCategory::where('category_id', $id)->get();
        return response()->json(['subcategories' => $subcategories]);
    }

    public function pyqContentIndex()
    {
        $data['pyqContents'] = PyqContent::with('examinationCommission', 'category', 'subCategory')->orderBy('created_at', 'DESC')->get();
        return view('pyq.pyq-content-index', $data);
    }

    public function pyqContentCreate()
    {
        $data['commissions'] = ExaminationCommission::all();
        return view('pyq.pyq-content-create', $data);
    }

    public function pyqContentEdit($id)
    {
        $data['pyqContent'] = PyqContent::findOrFail($id);
        $data['commissions'] = ExaminationCommission::all();
        $data['categories'] = Category::where('exam_com_id', $data['pyqContent']->commission_id)->get();
        $data['subCategories'] = SubCategory::where('category_id', $data['pyqContent']->category_id)->get();
        $data['subjects'] = Subject::where('sub_category_id', $data['pyqContent']->sub_category_id)->get();
        return view('pyq.pyq-content-edit', $data);
    }

    public function pyqContentStore(Request $request)
    {
        $request->validate([
            'commission_id' => 'required',
            'category_id' => 'required',
            'subject_id' => 'required',
            'sub_category_id' => 'required',
            'heading' => 'required|string|max:255',
            'detail_content' => 'required',
        ]);

        // Create a new PyqContent
        $pyqContent = new PyqContent([
            'commission_id' => $request->input('commission_id'),
            'category_id' => $request->input('category_id'),
            'sub_category_id' => $request->input('sub_category_id'),
            'subject_id' => $request->input('subject_id'),
            'heading' => $request->input('heading'),
            'detail_content' => $request->input('detail_content'),
        ]);

        // Save the PyqContent
        $pyqContent->save();

        // Redirect with success message
        return redirect()->route('pyq.content.index')->with('success', 'Content added successfully.');
    }

    public function pyqContentUpdate(Request $request, $id)
    {
        $pyqContent = PyqContent::findOrFail($id);

        // Update the PyqContent with new data
        $pyqContent->update([
            'commission_id' => $request->commission_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'heading' => $request->heading,
            'subject_id' => $request->subject_id ?? '',
            'detail_content' => $request->detail_content,
        ]);

        // Redirect to the index page with a success message
        return redirect()->route('pyq.content.index')->with('success', 'Pyq Content updated successfully.');
    }

    public function pyqContentDelete($id)
    {
        $pyqContent = PyqContent::findOrFail($id);
        $pyqContent->delete();
        return redirect()->back()->with('success', 'Pyq content deleted successfully');
    }


    function careerBulkDelete(Request $request)
    {
        $career_id_array = $request->input('id');
        $career = Career::whereIn('id', $career_id_array);
        if ($career->delete()) {
            echo 'Records Deleted';
        }
    }
    function boosterBulkDelete(Request $request)
    {
        $booster_id_array = $request->input('id');
        $booster = DailyBooster::whereIn('id', $booster_id_array);
        if ($booster->delete()) {
            echo 'Records Deleted';
        }
    }

    function testPlannerBulkDelete(Request $request)
    {
        $test_id_array = $request->input('id');
        $test = TestPlanner::whereIn('id', $test_id_array);
        if ($test->delete()) {
            echo 'Records Deleted';
        }
    }
    function studyMaterialBulkDelete(Request $request)
    {
        $material_id_array = $request->input('id');
        $material = StudyMaterial::whereIn('id', $material_id_array);
        if ($material->delete()) {
            echo 'Records Deleted';
        }
    }
    function upcomingExamBulkDelete(Request $request)
    {
        $exam_id_array = $request->input('id');
        $exam = UpcomingExam::whereIn('id', $exam_id_array);
        if ($exam->delete()) {
            echo 'Records Deleted';
        }
    }
    function contactUsBulkDelete(Request $request)
    {
        $contact_id_array = $request->input('id');
        $contact = ContactUs::whereIn('id', $contact_id_array);
        if ($contact->delete()) {
            echo 'Records Deleted';
        }
    }
    function subjectBulkDelete(Request $request)
    {
        $subject_id_array = $request->input('id');
        $subject = Subject::whereIn('id', $subject_id_array);
        if ($subject->delete()) {
            echo 'Records Deleted';
        }
    }

    function categoryBulkDelete(Request $request)
    {
        $category_id_array = $request->input('id');
        $category = Category::whereIn('id', $category_id_array);
        if ($category->delete()) {
            echo 'Records Deleted';
        }
    }
    function chapterBulkDelete(Request $request)
    {
        $chapter_id_array = $request->input('id');
        $chapter = Chapter::whereIn('id', $chapter_id_array);
        if ($chapter->delete()) {
            echo 'Records Deleted';
        }
    }
    function subCatBulkDelete(Request $request)
    {
        $subcat_id_array = $request->input('id');
        $subcat = SubCategory::whereIn('id', $subcat_id_array);
        if ($subcat->delete()) {
            echo 'Records Deleted';
        }
    }

    function courseBulkDelete(Request $request)
    {
        $course_id_array = $request->input('id');
        $course = Course::whereIn('id', $course_id_array);
        if ($course->delete()) {
            echo 'Records Deleted';
        }
    }

    public function replaceThWithTd($htmlFilePath)
    {
        // Load the HTML
        $html = file_get_contents($htmlFilePath);

        // Create DOMDocument and load HTML
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true); // Suppress warnings
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        // Get all <th> elements
        $thElements = $dom->getElementsByTagName('th');

        // We need to loop backwards because we'll be replacing nodes in-place
        for ($i = $thElements->length - 1; $i >= 0; $i--) {
            $th = $thElements->item($i);

            // Create new <td> element
            $td = $dom->createElement('td');

            // Copy attributes
            if ($th->hasAttributes()) {
                foreach ($th->attributes as $attr) {
                    $td->setAttribute($attr->nodeName, $attr->nodeValue);
                }
            }

            // Copy child nodes (text, formatting, etc.)
            foreach (iterator_to_array($th->childNodes) as $child) {
                $td->appendChild($child->cloneNode(true));
            }

            // Replace <th> with <td>
            $th->parentNode->replaceChild($td, $th);
        }

        // Save the updated HTML
        file_put_contents($htmlFilePath, $dom->saveHTML());
    }
}
