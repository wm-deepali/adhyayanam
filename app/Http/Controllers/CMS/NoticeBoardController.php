<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NoticeBoard;
use Illuminate\Support\Facades\Storage;

class NoticeBoardController extends Controller
{
    public function index()
    {
        $notices = NoticeBoard::latest()->paginate(15);
        return view('admin.cms.notice.index', compact('notices'));
    }

    public function create()
    {
        return view('admin.cms.notice.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('notice', 'public');
        }

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('notice', 'public');
        }

        NoticeBoard::create($data);

        return redirect()->route('cm.notice.board')
            ->with('success', 'Notice added');
    }

    public function edit($id)
    {
        $notice = NoticeBoard::findOrFail($id);
        return view('admin.cms.notice.edit', compact('notice'));
    }

    public function update(Request $request, $id)
    {
        $notice = NoticeBoard::findOrFail($id);
        $data = $this->validateData($request);

        // ✅ Image Upload
        if ($request->hasFile('image')) {

            // delete old image if exists
            if (!empty($notice->image) && Storage::disk('public')->exists($notice->image)) {
                Storage::disk('public')->delete($notice->image);
            }

            $data['image'] = $request->file('image')->store('notice', 'public');
        }

        // ✅ PDF/File Upload
        if ($request->hasFile('file')) {

            // delete old file if exists
            if (!empty($notice->file) && Storage::disk('public')->exists($notice->file)) {
                Storage::disk('public')->delete($notice->file);
            }

            $data['file'] = $request->file('file')->store('notice', 'public');
        }

        $notice->update($data);

        return redirect()->route('cm.notice.board')
            ->with('success', 'Notice updated');
    }

    public function destroy($id)
    {
        $notice = NoticeBoard::findOrFail($id);
        Storage::disk('public')->delete([$notice->image, $notice->file]);
        $notice->delete();

        return back()->with('success', 'Deleted');
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