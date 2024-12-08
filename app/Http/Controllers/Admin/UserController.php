<?php

// app/Http/Controllers/Admin/UserController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return view('admin.users.index');
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

    public function create()
    {
        return view('admin.users.create');
    }

}

