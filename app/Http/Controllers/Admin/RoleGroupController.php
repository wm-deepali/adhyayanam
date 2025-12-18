<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoleGroup;
use Illuminate\Http\Request;

class RoleGroupController extends Controller
{
    /** List all role groups */
    public function index()
    {
        $groups = RoleGroup::latest()->paginate(20);
        return view('admin.role-groups.index', compact('groups'));
    }

    /** Show create form */
    public function create()
    {
        return view('admin.role-groups.create');
    }

    /** Store new role group */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        RoleGroup::create([
            'name' => $request->name,
            'type' => $request->type,
            'permissions' => $request->permissions ?? [],
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('role-groups.index')->with('success', 'Role Group created successfully.');
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
}
