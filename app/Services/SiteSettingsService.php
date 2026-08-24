<?php

namespace App\Services;

use App\Models\AdminRecord;

class SiteSettingsService
{
    public function branding(): array
    {
        return AdminRecord::where('module', 'branding')->where('slug', 'website-branding')->value('payload') ?: [
            'logo_url' => asset('images/lucky-boss-logo.png'), 'favicon_url' => asset('images/lucky-boss-logo.png'), 'site_name' => 'Lucky Boss Portal', 'seo_title' => 'Lucky Boss Portal | AI-Powered Recruitment', 'seo_description' => 'Find jobs, build your career, and manage recruitment with Lucky Boss Portal.', 'primary_color' => '#1769e0', 'secondary_color' => '#18a66a',
        ];
    }

    public function contact(): array
    {
        return AdminRecord::where('module', 'contact-information')->where('slug', 'official-contact')->value('payload') ?: [
            'office_address' => 'Singapore', 'official_email' => 'hello@luckyboss.test', 'official_phone' => '', 'facebook_url' => 'https://www.facebook.com/', 'instagram_url' => 'https://www.instagram.com/', 'linkedin_url' => 'https://www.linkedin.com/', 'youtube_url' => 'https://www.youtube.com/', 'whatsapp_url' => 'https://wa.me/',
        ];
    }
}