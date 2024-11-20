<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    public function getAllSettings(): array
    {
        return Cache::remember('settings', 3600, function() {
            return Setting::pluck('value', 'key')->toArray();
        });
    }

    public function getSetting(string $key, $default = null)
    {
        $settings = $this->getAllSettings();
        return $settings[$key] ?? $default;
    }

    public function updateSettings(array $settings)
    {
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        Cache::forget('settings');
    }

    public function getNotificationSettings(): array
    {
        return [
            'email' => $this->getSetting('notifications.email', true),
            'sms' => $this->getSetting('notifications.sms', false),
            'push' => $this->getSetting('notifications.push', false),
            'templates' => $this->getNotificationTemplates()
        ];
    }

    protected function getNotificationTemplates(): array
    {
        return [
            'shipment_created' => $this->getSetting('templates.shipment_created'),
            'shipment_updated' => $this->getSetting('templates.shipment_updated'),
            'quote_processed' => $this->getSetting('templates.quote_processed'),
            // Add more templates as needed
        ];
    }
}
