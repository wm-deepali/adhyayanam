<?php

namespace App\Http\Controllers;

use App\Models\OfficeAddress;
use Illuminate\Http\Request;

class OfficeAddressController extends Controller
{
    public function index()
    {
        $addresses = OfficeAddress::latest()->get();

        return view('office-address.index', compact('addresses'));
    }

    public function create()
    {
        return view('office-address.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'office_type' => 'required',
            'address' => 'required',
        ]);

        OfficeAddress::create($request->all());

        return redirect()
            ->route('office-address.index')
            ->with('success', 'Office Address Added');
    }

    public function edit($id)
    {
        $address = OfficeAddress::findOrFail($id);

        return view('office-address.edit', compact('address'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'office_type' => 'required',
            'address' => 'required',
        ]);

        $address = OfficeAddress::findOrFail($id);

        $address->update($request->all());

        return redirect()
            ->route('office-address.index')
            ->with('success', 'Office Address Updated');
    }

    public function delete($id)
    {
        $address = OfficeAddress::findOrFail($id);

        $address->delete();

        return back()->with('success', 'Deleted Successfully');
    }
}