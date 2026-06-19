<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display user profile.
     */
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_orders' => $user->orders()->count(),
            'total_spent' => $user->orders()->where('status', 'delivered')->sum('total_amount'),
            'wishlist_count' => $user->wishlists()->count(),
        ];

        $recentOrders = $user->orders()
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return Inertia::render('Customers/Profile/Index', [
            'user' => $user,
            'stats' => $stats,
            'recentOrders' => $recentOrders,
        ]);
    }

    /**
     * Show edit profile form.
     */
    public function edit()
    {
        return Inertia::render('Customers/Profile/Edit', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Update user profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('profile.index')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Show change password form.
     */
    public function changePassword()
    {
        return Inertia::render('Customers/Profile/ChangePassword');
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('profile.index')
            ->with('success', 'Password changed successfully!');
    }
}
