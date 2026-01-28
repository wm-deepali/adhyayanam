<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoleGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleGroupController extends Controller
{
    /** List all role groups */
    public function index()
    {
        $groups = RoleGroup::with(['creator', 'approver'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        return view('admin.role-groups.index', compact('groups'));
    }

    /** Show create form */
    public function create()
    {
        return view('admin.role-groups.create');
    }

    /**
     * STORE ROLE GROUP (SUB-ADMIN → PENDING APPROVAL)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array',
        ]);


        RoleGroup::create([
            'name' => $request->name,
            'permissions' => $request->permissions,
            'type' => 'custom',
            'created_by' => Auth::id(),


            // 🔴 IMPORTANT
            'status' => Auth::user()->type === 'admin'
                ? 'published'
                : 'pending_approval',
        ]);


        return redirect()
            ->route('role-groups.index')
            ->with('success', 'Role group created successfully.');
    }

    /** Edit role group */
    public function edit($id)
    {
        $group = RoleGroup::findOrFail($id);
        return view('admin.role-groups.edit', compact('group'));
    }

    /** Update role group */
    public function update(Request $request, $id)
    {
        $group = RoleGroup::findOrFail($id);
        $group->update([
            'name' => $request->name,
            'type' => $request->type,
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()->route('role-groups.index')->with('success', 'Role Group updated successfully.');
    }

    /** Delete role group */
    public function destroy($id)
    {
        RoleGroup::findOrFail($id)->delete();

        return redirect()->route('role-groups.index')->with('success', 'Role Group deleted successfully.');
    }

    /**
     * VIEW ROLE GROUP
     */
    public function show($id)
    {
        $roleGroup = RoleGroup::findOrFail($id);
        return view('admin.role-groups.show', compact('roleGroup'));
    }


    /**
     * ADMIN → APPROVE & PUBLISH
     */
    public function approve(RoleGroup $roleGroup)
    {
        // Only admin
        if (Auth::user()->type !== 'admin') {
            abort(403);
        }


        $roleGroup->update([
            'status' => 'published',
            'approved_by' => Auth::id(),
        ]);


        return redirect()
            ->back()
            ->with('success', 'Role group approved & published.');
    }
}
