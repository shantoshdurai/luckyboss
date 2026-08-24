<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Blog;
use App\Models\CompanyGrade;
use App\Models\CompanyType;
use App\Models\FeatureFlag;
use App\Models\Job;
use App\Models\Package;
use App\Models\Payment;
use App\Models\ApiIntegration;
use App\Models\PlatformNotification;
use App\Models\Slider;
use App\Models\Subscription;
use App\Models\AdminRecord;
use App\Models\ExternalSource;
use App\Models\ImportBatch;
use App\Models\SupportTicket;
use App\Models\Invoice;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\Country;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = collect([
            ['name' => 'Super Admin', 'slug' => 'super-admin'],
            ['name' => 'Operations Admin', 'slug' => 'operations-admin'],
            ['name' => 'Recruitment Manager', 'slug' => 'recruitment-manager'],
            ['name' => 'Finance Admin', 'slug' => 'finance-admin'],
            ['name' => 'Content Manager', 'slug' => 'content-manager'],
            ['name' => 'Support Agent', 'slug' => 'support-agent'],
            ['name' => 'API Manager', 'slug' => 'api-manager'],
            ['name' => 'Employer', 'slug' => 'employer'],
            ['name' => 'Job Seeker', 'slug' => 'job-seeker'],
        ])->mapWithKeys(fn (array $role) => [$role['slug'] => Role::firstOrCreate(['slug' => $role['slug']], $role)]);

        $admin = User::firstOrCreate(['email' => 'admin@luckyboss.test'], ['name' => 'Lucky Boss Admin', 'password' => 'password', 'country_code' => 'SG']);
        $admin->roles()->syncWithoutDetaching([$roles['super-admin']->id]);

        $permissions = collect(['employers.manage','candidates.manage','jobs.manage','recruitment.manage','subscriptions.manage','payments.manage','cms.manage','support.manage','api.manage','reports.view','settings.manage','security.manage'])->mapWithKeys(function (string $slug) { $permission = Permission::firstOrCreate(['slug' => $slug], ['name' => str($slug)->replace('.', ' ')->headline(), 'module' => str($slug)->before('.')]); return [$slug => $permission]; });
        $rolePermissions = ['operations-admin'=>['employers.manage','candidates.manage','jobs.manage','recruitment.manage','reports.view'], 'recruitment-manager'=>['candidates.manage','jobs.manage','recruitment.manage','reports.view'], 'finance-admin'=>['subscriptions.manage','payments.manage','reports.view'], 'content-manager'=>['cms.manage'], 'support-agent'=>['support.manage'], 'api-manager'=>['api.manage','settings.manage']];
        foreach ($rolePermissions as $role => $permissionSlugs) { $roles[$role]->permissions()->syncWithoutDetaching($permissions->only($permissionSlugs)->pluck('id')->all()); }

        $types = collect(['Recruitment Agency', 'Construction', 'Manufacturing', 'Logistics', 'Warehouse', 'Healthcare', 'Hospitality', 'IT', 'Retail'])->map(fn (string $name) => CompanyType::firstOrCreate(['slug' => str($name)->slug()], ['name' => $name]));
        $grades = collect(['Standard', 'Silver', 'Gold', 'Premium', 'Corporate', 'Enterprise'])->map(fn (string $name) => CompanyGrade::firstOrCreate(['slug' => str($name)->slug()], ['name' => $name]));

        foreach ([
            ['key' => 'platform_ai_enabled', 'name' => 'Platform AI', 'is_enabled' => false],
            ['key' => 'employer_byoai_enabled', 'name' => 'Employer BYOAI', 'is_enabled' => true],
            ['key' => 'ai_matching_enabled', 'name' => 'AI Matching', 'is_enabled' => false],
            ['key' => 'external_jobs_enabled', 'name' => 'External Jobs', 'is_enabled' => false],
            ['key' => 'external_candidates_enabled', 'name' => 'External Candidates', 'is_enabled' => false],
            ['key' => 'candidate_monetization_enabled', 'name' => 'Candidate Monetization', 'is_enabled' => false],
            ['key' => 'google_calendar_enabled', 'name' => 'Google Calendar', 'is_enabled' => false],
        ] as $flag) {
            FeatureFlag::updateOrCreate(['key' => $flag['key']], $flag);
        }

        $company = Company::firstOrCreate(['name' => 'Lucky Boss Demo Recruitment'], ['email' => 'hello@luckyboss.test', 'country_code' => 'SG', 'status' => 'verified', 'industry' => 'Recruitment', 'company_type_id' => $types->firstWhere('name', 'Recruitment Agency')->id, 'company_grade_id' => $grades->firstWhere('name', 'Premium')->id]);
        foreach ([['code'=>'SGD','name'=>'Singapore Dollar','symbol'=>'S$'],['code'=>'INR','name'=>'Indian Rupee','symbol'=>'Rs'],['code'=>'MYR','name'=>'Malaysian Ringgit','symbol'=>'RM']] as $currency) { \App\Models\Currency::updateOrCreate(['code'=>$currency['code']],$currency); }
        foreach ([['code'=>'IN','name'=>'India'],['code'=>'SG','name'=>'Singapore']] as $country) { Country::updateOrCreate(['code'=>$country['code']], $country + ['sort_order' => 1, 'is_active' => true]); }
        $plans=[]; foreach ([['Starter',99,['job_posts'=>5,'candidate_views'=>50,'ai_matching'=>false,'byoai'=>true]],['Professional',299,['job_posts'=>25,'candidate_views'=>500,'ai_matching'=>true,'byoai'=>true]],['Enterprise',799,['job_posts'=>-1,'candidate_views'=>-1,'ai_matching'=>true,'external_candidates'=>true,'byoai'=>true]]] as [$name,$price,$entitlements]) { $plans[$name]=Package::updateOrCreate(['slug'=>str($name)->slug()],['name'=>$name,'description'=>"{$name} employer recruitment package",'validity_days'=>30,'entitlements'=>$entitlements,'is_active'=>true]); $plans[$name]->prices()->updateOrCreate(['currency_code'=>'SGD'],['amount'=>$price,'tax_rate'=>0]); }
        $subscription=Subscription::updateOrCreate(['company_id'=>$company->id,'package_id'=>$plans['Professional']->id],['status'=>'active','starts_at'=>today(),'expires_at'=>today()->addDays(90),'entitlements'=>$plans['Professional']->entitlements,'currency_code'=>'SGD','amount'=>299]);
        Payment::firstOrCreate(['reference'=>'LB-DEMO-001'],['company_id'=>$company->id,'subscription_id'=>$subscription->id,'purpose'=>'subscription','gateway'=>'manual','status'=>'paid','currency_code'=>'SGD','amount'=>299,'paid_at'=>now()]);
        $payment=Payment::where('reference','LB-DEMO-001')->first(); Invoice::firstOrCreate(['number'=>'INV-LB-0001'],['payment_id'=>$payment->id,'company_id'=>$company->id,'number'=>'INV-LB-0001','type'=>'employer','status'=>'issued','currency_code'=>'SGD','amount'=>299]);
        foreach ([['module'=>'email-templates','name'=>'Interview Invitation','description'=>'Default interview invitation template'],['module'=>'notification-sounds','name'=>'Application Update','description'=>'Job seeker sound payload'],['module'=>'mobile-app-settings','name'=>'Job Seeker Android','description'=>'Minimum version and store URL'],['module'=>'home-sections','name'=>'Featured Jobs','description'=>'Website and app home section'],['module'=>'location-masters','name'=>'Singapore','description'=>'Country master'],['module'=>'general-settings','name'=>'Portal Branding','description'=>'Logo and primary color settings']] as $record){AdminRecord::updateOrCreate(['module'=>$record['module'],'slug'=>str($record['name'])->slug()],$record+['slug'=>str($record['name'])->slug(),'payload'=>[],'is_active'=>true]);}
        $source=ExternalSource::firstOrCreate(['name'=>'Demo Recruitment Partner'],['source_type'=>'Recruitment Partner','feed_type'=>'manual','status'=>'active','contacts_visible'=>false,'import_limit'=>100]); ImportBatch::firstOrCreate(['external_source_id'=>$source->id,'data_type'=>'candidates'],['user_id'=>$admin->id,'status'=>'completed','records_received'=>10,'records_imported'=>8,'records_failed'=>2]);
        foreach ([['key'=>'platform_openai','name'=>'OpenAI GPT','provider'=>'OpenAI','is_enabled'=>false,'monthly_limit'=>10000000],['key'=>'resume_parser','name'=>'Resume Parser','provider'=>'Manual fallback','is_enabled'=>false,'monthly_limit'=>5000],['key'=>'payment_gateway','name'=>'Payment Gateway','provider'=>'Manual / Stripe ready','is_enabled'=>false,'monthly_limit'=>null],['key'=>'whatsapp','name'=>'WhatsApp','provider'=>'Cloud API','is_enabled'=>false,'monthly_limit'=>100000]] as $integration) { ApiIntegration::updateOrCreate(['key'=>$integration['key']],$integration); }
        Slider::updateOrCreate(['title'=>'Find the Right Job. Build a Better Career.'],['subtitle'=>'AI-powered recruitment for Singapore, Malaysia, India & More.','cta_text'=>'Search Jobs','cta_url'=>'/#jobs','sort_order'=>1,'web_enabled'=>true,'app_enabled'=>true,'is_active'=>true]);
        $categoryIcons = ['Construction' => 'hard-hat', 'Manufacturing' => 'factory', 'Warehouse' => 'warehouse', 'Healthcare' => 'heart-pulse', 'Logistics' => 'truck', 'Hospitality' => 'utensils', 'Domestic Worker' => 'house', 'Engineering' => 'settings-2', 'Sales' => 'handshake', 'Administration' => 'clipboard-list', 'Security' => 'shield-check'];
        $categories = collect(array_keys($categoryIcons))->map(function (string $name, int $index) use ($categoryIcons) {
            return JobCategory::updateOrCreate(['slug' => str($name)->slug()], ['name' => $name, 'icon' => $categoryIcons[$name], 'icon_image_path' => 'images/lucky-boss-logo.png', 'sort_order' => $index + 1, 'show_on_home' => true, 'is_active' => true]);
        });
        $job = Job::firstOrCreate(['company_id' => $company->id, 'title' => 'Warehouse Supervisor'], ['description' => 'Lead warehouse operations and coordinate a high-performing team.', 'country_code' => 'SG', 'location' => 'Singapore', 'job_category_id' => $categories->firstWhere('name', 'Warehouse')->id, 'experience_min' => 3, 'experience_max' => 5, 'salary_min' => 3000, 'salary_max' => 4500, 'currency_code' => 'SGD', 'status' => 'published', 'is_featured' => true, 'published_at' => now(), 'closing_date' => now()->addMonth()]);
                $dummyJobs = [
            ['title'=>'Warehouse Coordinator','category'=>'Warehouse','location'=>'Jurong East','country_code'=>'SG','salary_min'=>2800,'salary_max'=>3800],
            ['title'=>'Construction Site Supervisor','category'=>'Construction','location'=>'Kallang','country_code'=>'SG','salary_min'=>4200,'salary_max'=>5800],
            ['title'=>'Logistics Operations Executive','category'=>'Logistics','location'=>'Tuas','country_code'=>'SG','salary_min'=>3200,'salary_max'=>4600],
            ['title'=>'Manufacturing Quality Engineer','category'=>'Manufacturing','location'=>'Shah Alam','country_code'=>'MY','salary_min'=>4500,'salary_max'=>6500],
            ['title'=>'Healthcare Assistant','category'=>'Healthcare','location'=>'Singapore','country_code'=>'SG','salary_min'=>2400,'salary_max'=>3400],
            ['title'=>'Hospitality Front Office Manager','category'=>'Hospitality','location'=>'Orchard','country_code'=>'SG','salary_min'=>3600,'salary_max'=>5000],
            ['title'=>'Recruitment Consultant','category'=>'Recruitment Agency','location'=>'Chennai','country_code'=>'IN','salary_min'=>3000,'salary_max'=>5000],
            ['title'=>'Retail Store Manager','category'=>'Retail','location'=>'Kuala Lumpur','country_code'=>'MY','salary_min'=>3800,'salary_max'=>5600],
            ['title'=>'IT Support Specialist','category'=>'IT','location'=>'Paya Lebar','country_code'=>'SG','salary_min'=>3500,'salary_max'=>5200],
            ['title'=>'Warehouse Picker and Packer','category'=>'Warehouse','location'=>'Woodlands','country_code'=>'SG','salary_min'=>2200,'salary_max'=>3000],
        ];
        foreach ($dummyJobs as $index => $dummy) {
            $dummyCategory = JobCategory::where('name', $dummy['category'])->first() ?: $categories->first();
            Job::firstOrCreate(['company_id' => $company->id, 'title' => $dummy['title']], [
                'description' => "Test job listing for {$dummy['title']}.", 'image_path' => 'images/lucky-boss-logo.png', 'country_code' => $dummy['country_code'], 'location' => $dummy['location'], 'job_category_id' => $dummyCategory?->id, 'experience_min' => $index % 4, 'experience_max' => ($index % 4) + 3, 'salary_min' => $dummy['salary_min'], 'salary_max' => $dummy['salary_max'], 'currency_code' => $dummy['country_code'] === 'IN' ? 'INR' : ($dummy['country_code'] === 'MY' ? 'MYR' : 'SGD'), 'status' => 'published', 'is_featured' => $index < 3, 'is_urgent' => $index === 3, 'published_at' => now()->subDays($index), 'closing_date' => now()->addDays(30 + $index),
            ]);
        }
        Job::whereNull('image_path')->update(['image_path' => 'images/lucky-boss-logo.png']);
        $employer = User::firstOrCreate(['email' => 'employer@luckyboss.test'], ['name' => 'Arun Kumar', 'phone' => '+6591234567', 'country_code' => 'SG', 'password' => 'password']);
        $employer->roles()->syncWithoutDetaching([$roles['employer']->id]); $company->users()->syncWithoutDetaching([$employer->id => ['company_role' => 'company-admin', 'is_active' => true]]);
        $candidate = User::firstOrCreate(['email' => 'candidate@luckyboss.test'], ['name' => 'Maya Tan', 'phone' => '+6587654321', 'country_code' => 'SG', 'password' => 'password']);
        $candidate->roles()->syncWithoutDetaching([$roles['job-seeker']->id]); $candidate->candidateProfile()->firstOrCreate([], ['country_code' => 'SG', 'current_title' => 'Warehouse Coordinator', 'current_location' => 'Singapore', 'preferred_location' => 'Singapore', 'years_experience' => 4, 'profile_completion' => 65]);
        SupportTicket::firstOrCreate(['subject'=>'Need help with job application'],['user_id'=>$candidate->id,'source'=>'website','message'=>'Please advise on completing my profile.','status'=>'new','priority'=>'normal']);
        PlatformNotification::firstOrCreate(['user_id' => $candidate->id, 'title' => 'Your application was shortlisted'], [
            'type' => 'application_update',
            'body' => 'Lucky Boss Demo Recruitment shortlisted you for Warehouse Supervisor.',
            'sound' => 'application_update',
            'created_at' => now()->subMinutes(15),
        ]);
        PlatformNotification::firstOrCreate(['user_id' => $candidate->id, 'title' => 'Interview Scheduled'], [
            'type' => 'interview_alert',
            'body' => 'Tuas Port Logistics confirmed an interview for Warehouse Supervisor tomorrow at 10:00 AM.',
            'sound' => 'interview_alert',
            'created_at' => now()->subHours(2),
        ]);
        PlatformNotification::firstOrCreate(['user_id' => $candidate->id, 'title' => 'New Top Job Match (94%)'], [
            'type' => 'job_match',
            'body' => 'Jurong Global Freight posted a matching Logistics Lead position.',
            'sound' => 'job_match',
            'created_at' => now()->subHours(5),
        ]);

        // Employer Notifications
        PlatformNotification::firstOrCreate(['user_id' => $employer->id, 'title' => 'New Applicant: Maya Tan'], [
            'type' => 'applicant_alert',
            'body' => 'Maya Tan applied for Warehouse Supervisor (88% Match Score).',
            'sound' => 'applicant_alert',
            'created_at' => now()->subMinutes(25),
        ]);
        PlatformNotification::firstOrCreate(['user_id' => $employer->id, 'title' => 'Enterprise Package Active'], [
            'type' => 'payment_alert',
            'body' => 'Your 30-day Enterprise Recruitment subscription has been activated successfully.',
            'sound' => 'payment_alert',
            'created_at' => now()->subHours(3),
        ]);

        // Super Admin Notifications
        PlatformNotification::firstOrCreate(['user_id' => $admin->id, 'title' => 'Employer KYC Verification Needed'], [
            'type' => 'system_alert',
            'body' => 'Keppel Civil & Infrastructure submitted business registration for review.',
            'sound' => 'system_alert',
            'created_at' => now()->subMinutes(10),
        ]);
        PlatformNotification::firstOrCreate(['user_id' => $admin->id, 'title' => 'Subscription Renewal Received'], [
            'type' => 'payment_alert',
            'body' => 'Tuas Port Logistics renewed Enterprise Package ($1,299.00 SGD).',
            'sound' => 'payment_alert',
            'created_at' => now()->subHours(1),
        ]);
        PlatformNotification::firstOrCreate(['user_id' => $admin->id, 'title' => 'System Health Check Clean'], [
            'type' => 'system_alert',
            'body' => 'All background queues, AI models, and database connections are operating nominally.',
            'sound' => 'system_alert',
            'created_at' => now()->subHours(4),
        ]);
        foreach ([
            ['title' => 'How to Prepare for a Warehouse Supervisor Interview', 'category' => 'Interview Tips', 'short_description' => 'Practical preparation tips for leading warehouse teams and demonstrating operational confidence.', 'content' => 'A strong warehouse supervisor interview begins with specific examples. Prepare to explain how you improve safety, plan shifts, manage stock accuracy, and support your team through busy periods.', 'author' => 'Lucky Boss Team'],
            ['title' => 'Creating a Resume That Gets Noticed', 'category' => 'Resume Tips', 'short_description' => 'A clear, focused resume helps employers quickly understand your experience and potential.', 'content' => 'Lead with your most relevant experience, use measurable outcomes where possible, and tailor your skills to the role you want. Keep your contact details current and make your availability clear.', 'author' => 'Lucky Boss Team'],
            ['title' => 'Building a More Effective Hiring Pipeline', 'category' => 'Employer Guides', 'short_description' => 'Simple habits that help employers turn applications into confident hiring decisions.', 'content' => 'Define the outcome for every hiring stage, respond quickly to suitable applicants, and keep candidates informed. A consistent process improves both hiring quality and employer reputation.', 'author' => 'Lucky Boss Team'],
            ['title' => 'How to Write Better Job Descriptions', 'category' => 'Employer Guides', 'short_description' => 'Clear job descriptions attract better matched applicants.', 'content' => 'Describe the outcome of the role, the essential skills, the working arrangement, and the next step. Avoid long lists of vague requirements.', 'author' => 'Lucky Boss Team'],
            ['title' => 'Preparing for Your First Interview', 'category' => 'Interview Tips', 'short_description' => 'A practical checklist for confident job interviews.', 'content' => 'Review the role, prepare concise examples from your experience, test your meeting link, and prepare thoughtful questions for the interviewer.', 'author' => 'Lucky Boss Team'],
            ['title' => 'Skills That Stand Out in Logistics', 'category' => 'Industry News', 'short_description' => 'The capabilities modern logistics teams value most.', 'content' => 'Safety awareness, inventory accuracy, communication, and comfort with operational systems are increasingly valuable across logistics roles.', 'author' => 'Lucky Boss Team'],
            ['title' => 'Making Your Profile Searchable', 'category' => 'Resume Tips', 'short_description' => 'Small profile improvements that help employers find you.', 'content' => 'Use specific job titles, list your strongest skills, keep your location current, and explain measurable achievements in your work history.', 'author' => 'Lucky Boss Team'],
            ['title' => 'Interview Feedback That Improves Hiring', 'category' => 'Employer Guides', 'short_description' => 'Turn interview notes into consistent hiring decisions.', 'content' => 'Record evidence against the role requirements, separate facts from impressions, and capture a clear recommendation while the conversation is fresh.', 'author' => 'Lucky Boss Team'],
        ] as $post) {
            Blog::updateOrCreate(['slug' => str($post['title'])->slug()], $post + ['slug' => str($post['title'])->slug(), 'image_path' => 'images/lucky-boss-logo.png', 'is_published' => true, 'published_at' => now()->subDays(rand(1, 14))]);
        }
        Blog::whereNull('image_path')->update(['image_path' => 'images/lucky-boss-logo.png']);
    }
}
