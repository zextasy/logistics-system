<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::withCount(['shipments', 'quotes'])
            ->when($request->search, function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['shipments', 'quotes']);
        return view('admin.users.show', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->validated());

        return back()->with('success', 'User updated successfully');
    }

    public function toggleAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot modify your own admin status');
        }

        $user->update(['is_admin' => !$user->is_admin]);

        return back()->with('success', 'User admin status updated successfully');
    }
}
