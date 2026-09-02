<?php

namespace App\Services;

use App\Models\AdminRecord;

class SiteSettingsService
{
    public function branding(): array
    {
        $defaults = [
            'logo_url' => asset('images/luckyboss-logo.svg'), 'favicon_url' => asset('images/lucky-boss-logo.png'), 'site_name' => 'Luckyboss Employment Agency Pte. Ltd', 'seo_title' => 'Luckyboss Employment Agency Pte. Ltd | AI-Powered Recruitment', 'seo_description' => 'Find jobs, build your career, and manage recruitment with Luckyboss Employment Agency Pte. Ltd.', 'primary_color' => '#1769e0', 'secondary_color' => '#18a66a',
        ];

        $payload = AdminRecord::where('module', 'branding')->where('slug', 'website-branding')->value('payload') ?? [];

        if (is_string($payload)) {
            $payload = json_decode($payload, true) ?: [];
        }

        if (! is_array($payload)) {
            $payload = [];
        }

        $branding = array_merge($defaults, $payload);
        foreach (['logo_url', 'favicon_url'] as $key) {
            if (is_string($branding[$key] ?? null) && str_starts_with($branding[$key], 'http://localhost/')) {
                $branding[$key] = ltrim(parse_url($branding[$key], PHP_URL_PATH) ?: '', '/');
            }
        }

        return $branding;
    }

    public function contact(): array
    {
        $payload = AdminRecord::where('module', 'contact-information')->where('slug', 'official-contact')->value('payload') ?? [
            'office_address' => 'Singapore', 'official_email' => 'hello@luckyboss.test', 'official_phone' => '', 'facebook_url' => 'https://www.facebook.com/', 'instagram_url' => 'https://www.instagram.com/', 'linkedin_url' => 'https://www.linkedin.com/', 'youtube_url' => 'https://www.youtube.com/', 'whatsapp_url' => 'https://wa.me/',
        ];

        if (is_string($payload)) {
            $payload = json_decode($payload, true) ?: [];
        }

        if (! is_array($payload)) {
            $payload = [];
        }

        return array_merge([
            'office_address' => 'Singapore', 'official_email' => 'hello@luckyboss.test', 'official_phone' => '', 'facebook_url' => 'https://www.facebook.com/', 'instagram_url' => 'https://www.instagram.com/', 'linkedin_url' => 'https://www.linkedin.com/', 'youtube_url' => 'https://www.youtube.com/', 'whatsapp_url' => 'https://wa.me/',
        ], $payload);
    }
}