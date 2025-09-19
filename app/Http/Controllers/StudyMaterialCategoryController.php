<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudyMaterialCategory;
use App\Models\MainTopic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class StudyMaterialCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['categories'] = StudyMaterialCategory::get();
 
        return view('study-material.category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('study-material.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'meta_title' => 'required|string|max:255',
            'meta_keyword' => 'required|string|max:255',
            'meta_description' => 'required|string',
            'canonical_url' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048', // Assuming the image is optional and its maximum size is 2MB
            'alt_tag' => 'nullable|string|max:255',
            'status' => 'required',
        ]);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $getFileExt   = $request->file('image')->getClientOriginalExtension();
            $imagename = time().'-cat.'.$getFileExt;
            $imagePath = $request->file('image')->storeAs('study-material/category', $imagename, 'public');
        } else {
            $imagePath = null;
        }
    
        // Create a new instance of ExaminationCommission model
        $category = new StudyMaterialCategory();
        $category->name = $request->name;
        $category->meta_title = $request->meta_title;
        $category->meta_keyword = $request->meta_keyword;
        $category->meta_description = $request->meta_description;
        $category->canonical_url = $request->canonical_url;
        $category->image = $imagePath;
        $category->alt_tag = $request->alt_tag;
        $category->status = $request->status;
        
        // Save the ExaminationCommission instance to the database
        $category->save();
        return redirect()->route('category.index')->with('success', 'Category added successfully.');
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
        $category = StudyMaterialCategory::findOrFail($id);
        return view('study-material.category.edit')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $category = StudyMaterialCategory::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'meta_title' => 'required|string|max:255',
            'meta_keyword' => 'required|string|max:255',
            'meta_description' => 'required|string',
            'canonical_url' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048', // Assuming the image is optional and its maximum size is 2MB
            'alt_tag' => 'nullable|string|max:255',
            'status' => 'required',
        ]);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $getFileExt   = $request->file('image')->getClientOriginalExtension();
            $imagename = time().'-cat.'.$getFileExt;
            $imagePath = $request->file('image')->storeAs('study-material/category', $imagename, 'public');
        } else {
            $imagePath = $category->image;
        }
    
        $categoryData = array (
            'name' => $request->name,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'canonical_url' => $request->canonical_url,
            'alt_tag' => $request->alt_tag,
            'image' => $imagePath,
            'status' => $request->status,
        );
        $category->update($categoryData);
        
        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = StudyMaterialCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
    }
}
