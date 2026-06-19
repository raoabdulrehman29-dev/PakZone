<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Address;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AddressController extends Controller
{
    /**
     * Display a listing of addresses.
     */
    public function index()
    {
        $addresses = Address::where('user_id', auth()->id())
            ->orderBy('is_default', 'desc')
            ->get();

        return Inertia::render('Customers/Addresses/Index', [
            'addresses' => $addresses,
        ]);
    }

    /**
     * Show the form for creating a new address.
     */
    public function create()
    {
        return Inertia::render('Customers/Addresses/Create');
    }

    /**
     * Store a newly created address.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'pincode' => 'required|string|max:20',
            'type' => 'required|in:shipping,billing',
            'is_default' => 'nullable|boolean',
        ]);

        // If this is set as default, remove default from other addresses
        if ($request->has('is_default') && $request->is_default) {
            Address::where('user_id', auth()->id())
                ->where('type', $validated['type'])
                ->update(['is_default' => false]);
        }

        $validated['user_id'] = auth()->id();
        Address::create($validated);

        return redirect()->route('addresses.index')
            ->with('success', 'Address added successfully!');
    }

    /**
     * Show the form for editing the specified address.
     */
    public function edit($id)
    {
        $address = Address::where('user_id', auth()->id())->findOrFail($id);

        return Inertia::render('Customers/Addresses/Edit', [
            'address' => $address,
        ]);
    }

    /**
     * Update the specified address.
     */
    public function update(Request $request, $id)
    {
        $address = Address::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'pincode' => 'required|string|max:20',
            'type' => 'required|in:shipping,billing',
            'is_default' => 'nullable|boolean',
        ]);

        // If this is set as default, remove default from other addresses
        if ($request->has('is_default') && $request->is_default) {
            Address::where('user_id', auth()->id())
                ->where('type', $validated['type'])
                ->where('id', '!=', $id)
                ->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('addresses.index')
            ->with('success', 'Address updated successfully!');
    }

    /**
     * Remove the specified address.
     */
    public function destroy($id)
    {
        $address = Address::where('user_id', auth()->id())->findOrFail($id);

        // Check if it's the only address
        $count = Address::where('user_id', auth()->id())->count();
        if ($count <= 1) {
            return back()->with('error', 'You must have at least one address.');
        }

        $address->delete();

        return redirect()->route('addresses.index')
            ->with('success', 'Address deleted successfully!');
    }

    /**
     * Set address as default.
     */
    public function setDefault($id)
    {
        $address = Address::where('user_id', auth()->id())->findOrFail($id);

        // Remove default from other addresses of same type
        Address::where('user_id', auth()->id())
            ->where('type', $address->type)
            ->update(['is_default' => false]);

        $address->is_default = true;
        $address->save();

        return back()->with('success', 'Default address updated!');
    }
}
