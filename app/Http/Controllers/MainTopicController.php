<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MainTopic;
use App\Models\StudyMaterialCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class MainTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['topics'] = MainTopic::with('studycategory')->orderBy('created_at','DESC')->get();
        
        return view('study-material.main-topic.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['categories'] = StudyMaterialCategory::get();
        return view('study-material.main-topic.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048', // Assuming the image is optional and its maximum size is 2MB
            'alt_tag' => 'nullable|string|max:255',
            'status' => 'required',
        ]);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $getFileExt   = $request->file('image')->getClientOriginalExtension();
            $imagename = time().'-cat.'.$getFileExt;
            $imagePath = $request->file('image')->storeAs('study-material/topic', $imagename, 'public');
        } else {
            $imagePath = null;
        }
    
        // Create a new instance of ExaminationCommission model
        $topic = new MainTopic();
        $topic->category_id = $request->category_id;
        $topic->name = $request->name;
        $topic->image = $imagePath;
        $topic->alt_tag = $request->alt_tag;
        $topic->status = $request->status;
        
        // Save the ExaminationCommission instance to the database
        $topic->save();
        return redirect()->route('main-topic.index')->with('success', 'Topic added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $topic = MainTopic::findOrFail($id);
        $categories = StudyMaterialCategory::get();
        return view('study-material.main-topic.edit')->with('topic', $topic)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $topic = MainTopic::findOrFail($id);
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048', // Assuming the image is optional and its maximum size is 2MB
            'alt_tag' => 'nullable|string|max:255',
            'status' => 'required',
        ]);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $getFileExt   = $request->file('image')->getClientOriginalExtension();
            $imagename = time().'-cat.'.$getFileExt;
            $imagePath = $request->file('image')->storeAs('study-material/topic', $imagename, 'public');
        } else {
            $imagePath = $topic->image;
        }
    
        $topicData = array (
            'category_id' => $request->category_id,
            'name' => $request->name,
            'alt_tag' => $request->alt_tag,
            'image' => $imagePath,
            'status' => $request->status,
        );
        $topic->update($topicData);
        
        return redirect()->route('main-topic.index')->with('success', 'Topic updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $topic = MainTopic::findOrFail($id);
        $topic->delete();
        return redirect()->route('main-topic.index')->with('success', 'Topic deleted successfully!');
    }

    public function fetchCategory($category)
    {
        try{
            $category = StudyMaterialCategory::findOrFail($category);
            $topic = MainTopic::where('category_id',$category->id)->get();
            return response()->json([
                "success" => true,
                "html" => view('admin.ajax.topic-by-category')->with([
                    'topics' => $topic,
                ])->render(),
            ]);
        }catch(\Exception $ex){
            return response()->json([
                "success" => false,
                'msgText' =>$ex->getMessage(),
            ]);
        }
    }
}
