<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', [
            'user' => auth()->user()
        ]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = auth()->user();

        if ($request->password) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
            }

            $user->password = Hash::make($request->password);
        }

        $user->fill($request->except('password', 'current_password'));
        $user->save();

        return back()->with('success', 'Profile updated successfully');
    }

    public function notifications()
    {
        $user = auth()->user();

        return view('profile.notifications', [
            'user' => $user,
            'preferences' => $user->preferences ?? []
        ]);
    }

    public function updateNotifications(Request $request)
    {
        $user = auth()->user();

        $user->preferences = array_merge($user->preferences ?? [], [
            'notifications_email' => $request->boolean('notifications_email'),
            'notifications_sms' => $request->boolean('notifications_sms'),
            'language' => $request->input('language', 'en'),
            'timezone' => $request->input('timezone', 'UTC')
        ]);

        $user->save();

        return back()->with('success', 'Notification preferences updated successfully');
    }
}
