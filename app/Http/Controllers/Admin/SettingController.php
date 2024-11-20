<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        $settings = $this->settingService->getAllSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $this->settingService->updateSettings($request->all());
        return back()->with('success', 'Settings updated successfully');
    }

    public function notifications()
    {
        $settings = $this->settingService->getNotificationSettings();
        return view('admin.settings.notifications', compact('settings'));
    }

    public function updateNotifications(Request $request)
    {
        $this->settingService->updateNotificationSettings($request->all());
        return back()->with('success', 'Notification settings updated successfully');
    }
}
