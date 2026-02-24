<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CurrentNews;
use Illuminate\Support\Facades\Storage;

class CurrentNewsController extends Controller
{
    public function index()
    {
        $news = CurrentNews::latest()->paginate(15);
        return view('admin.cms.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.cms.news.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news','public');
        }

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('news','public');
        }

        CurrentNews::create($data);

        return redirect()->route('cm.current.news')
            ->with('success','News added successfully');
    }

    public function edit($id)
    {
        $news = CurrentNews::findOrFail($id);
        return view('admin.cms.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $news = CurrentNews::findOrFail($id);
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($news->image);
            $data['image'] = $request->file('image')->store('news','public');
        }

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($news->file);
            $data['file'] = $request->file('file')->store('news','public');
        }

        $news->update($data);

        return redirect()->route('cm.current.news')
            ->with('success','News updated');
    }

    public function destroy($id)
    {
        $news = CurrentNews::findOrFail($id);

        Storage::disk('public')->delete([$news->image, $news->file]);

        $news->delete();

        return back()->with('success','Deleted');
    }

    private function validateData($request)
    {
        return $request->validate([
            'title' => 'required',
            'type' => 'required|in:pdf,link,page',
            'short_description' => 'nullable',
            'detail_content' => 'nullable',
            'url' => 'nullable|url',
            'image' => 'nullable|image',
            'file' => 'nullable|mimes:pdf'
        ]);
    }
}