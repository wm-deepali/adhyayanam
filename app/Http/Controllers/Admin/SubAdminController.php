<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RoleGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SubAdminController extends Controller
{
    /** List sub admins */
    public function index()
    {
        $users = User::where('type', 'admin')
            ->whereNotNull('role_group_id')
            ->latest()
            ->paginate(20);

        return view('admin.sub-admins.index', compact('users'));
    }

    /** Create form */
    public function create()
    {
        $groups = RoleGroup::all();
        return view('admin.sub-admins.create', compact('groups'));
    }

    /** Store sub admin */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'mobile' => 'nullable|string|max:15',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_group_id' => 'required|exists:role_groups,id',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => trim($request->first_name . ' ' . $request->last_name),
            'email' => $request->email,
            'mobile' => $request->mobile,
            'type' => 'admin',
            'password' => Hash::make($request->password),
            'role_group_id' => $request->role_group_id,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ]);

        $user->username = "10000" . $user->id;
        $user->save();

        return redirect()
            ->route('sub-admins.index')
            ->with('success', 'Sub Admin created successfully.');
    }

    /** Edit */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $groups = RoleGroup::all();

        return view('admin.sub-admins.edit', compact('user', 'groups'));
    }

    /** Update sub admin */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'mobile' => 'nullable|string|max:15',
            'role_group_id' => 'required|exists:role_groups,id',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'password' => 'nullable|string|min:6',
        ]);

        // Prepare update data
        $data = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'] ?? null,
            'name' => trim($validated['first_name'] . ' ' . ($validated['last_name'] ?? '')),
            'mobile' => $validated['mobile'] ?? null,
            'role_group_id' => $validated['role_group_id'],
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'gender' => $validated['gender'] ?? null,
        ];

        
        // Update password ONLY if provided
        if (!empty($validated['password'])) {
            $data['password'] = bcrypt($validated['password']);
        }
        
        $user->update($data);
        
        return redirect()
            ->route('sub-admins.index')
            ->with('success', 'Sub Admin updated successfully.');
    }


    /** Delete sub admin */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()
            ->route('sub-admins.index')
            ->with('success', 'Sub Admin deleted successfully.');
    }


    public function editPassword($id)
    {
        $user = User::findOrFail($id);
        return view('sub-admins.update-password', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        User::where('id', $id)->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('sub-admins.index')
            ->with('success', 'Password updated successfully');
    }

}
