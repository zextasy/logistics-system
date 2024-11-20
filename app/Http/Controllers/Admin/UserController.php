<?php

// app/Http/Controllers/Admin/UserController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = User::withCount(['shipments', 'quotes'])
            ->when($request->search, function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->when($request->role, function($query, $role) {
                if ($role === 'admin') {
                    $query->where('is_admin', true);
                } else {
                    $query->where('is_admin', false);
                }
            })
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load([
            'shipments' => fn($query) => $query->latest()->take(5),
            'quotes' => fn($query) => $query->latest()->take(5)
        ]);

        $stats = [
            'total_shipments' => $user->shipments()->count(),
            'active_shipments' => $user->shipments()->whereNotIn('status', ['delivered', 'cancelled'])->count(),
            'total_quotes' => $user->quotes()->count(),
            'pending_quotes' => $user->quotes()->where('status', 'pending')->count()
        ];

        return view('admin.users.show', compact('user', 'stats'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $this->userService->updateUser($user, $request->validated());
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

