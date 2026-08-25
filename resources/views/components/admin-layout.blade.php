@props(['title' => 'Admin', 'heading' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — Lucky Boss Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f8fafc] text-text-primary antialiased" x-data="{ 
    sidebarOpen: true, 
    mobileSidebarOpen: false,
    openDropdowns: {
        employers: {{ request()->routeIs('admin.companies.*', 'admin.employer-*') || request()->is('admin/command/employers*') ? 'true' : 'false' }},
        jobSeekers: {{ request()->routeIs('admin.candidates.*', 'admin.candidate-*') || request()->is('admin/command/job-seekers*') ? 'true' : 'false' }},
        jobs: {{ request()->routeIs('admin.jobs.*') || request()->is('admin/command/jobs*') ? 'true' : 'false' }},
        recruitment: {{ request()->routeIs('admin.recruitment.*') || request()->is('admin/command/recruitment*') ? 'true' : 'false' }},
        jobMasters: {{ request()->routeIs('admin.masters.*', 'admin.records.*') || request()->is('admin/command/job-masters*') ? 'true' : 'false' }},
        externalData: {{ request()->routeIs('admin.external-data.*') || request()->is('admin/command/external-data*') ? 'true' : 'false' }},
        subscriptions: {{ request()->routeIs('admin.subscriptions.*', 'admin.operations.*') || request()->is('admin/command/subscriptions*') ? 'true' : 'false' }},
        payments: {{ request()->routeIs('admin.payments.*', 'admin.invoices.*') || request()->is('admin/command/payments*') ? 'true' : 'false' }},
        aiApi: {{ request()->routeIs('admin.ai-api.*') || request()->is('admin/command/ai-api*') ? 'true' : 'false' }},
        interviews: {{ request()->routeIs('admin.interviews.*') || request()->is('admin/command/interviews*') ? 'true' : 'false' }},
        offers: {{ request()->is('admin/command/offers*') ? 'true' : 'false' }},
        communication: {{ request()->routeIs('admin.communication.*') || request()->is('admin/command/communication*') ? 'true' : 'false' }},
        notifications: {{ request()->routeIs('admin.notifications.*') || request()->is('admin/command/notifications*') ? 'true' : 'false' }},
        cms: {{ request()->routeIs('admin.cms.*', 'admin.blogs.*') || request()->is('admin/command/cms*') ? 'true' : 'false' }},
        mobileApps: {{ request()->is('admin/command/mobile-apps*') ? 'true' : 'false' }},
        support: {{ request()->routeIs('admin.support-center.*') || request()->is('admin/command/support*') ? 'true' : 'false' }},
        reports: {{ request()->routeIs('admin.reports.*') || request()->is('admin/command/reports*') ? 'true' : 'false' }},
        analytics: {{ request()->is('admin/command/analytics*') || request()->is('admin/control-center*analytics*') ? 'true' : 'false' }},
        usersPermissions: {{ request()->is('admin/control-center*users-permissions*') || request()->is('admin/command/users-permissions*') ? 'true' : 'false' }},
        auditLogs: {{ request()->is('admin/control-center*audit-logs*') || request()->is('admin/command/audit-logs*') ? 'true' : 'false' }},
        settings: {{ request()->routeIs('admin.site-settings.*') || request()->is('admin/command/settings*') || request()->is('admin/control-center*settings*') ? 'true' : 'false' }},
        system: {{ request()->is('admin/control-center*system*') || request()->is('admin/command/system*') ? 'true' : 'false' }}
    },
    toggleDropdown(name) {
        this.openDropdowns[name] = !this.openDropdowns[name];
    }
}">
    <div class="flex min-h-screen">
        {{-- Desktop Sidebar (Clean White with High-Contrast Slate/Navy Styling) --}}
        <aside
            :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="hidden lg:flex flex-col fixed inset-y-0 left-0 z-30 bg-white border-r border-border overflow-hidden shadow-xs transition-all duration-200"
        >
            {{-- Logo Header --}}
            <div class="flex items-center justify-between h-20 px-5 border-b border-border shrink-0 bg-white">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <img 
                        src="{{ asset('images/lucky-boss-logo-transparent.png') }}" 
                        alt="Lucky Boss" 
                        class="h-11 w-auto max-h-12 object-contain"
                    >
                    <span class="text-[10px] bg-navy text-white px-1.5 py-0.5 rounded font-bold uppercase tracking-wider">Admin</span>
                </a>
            </div>

            {{-- COMMAND CENTER Label --}}
            <div x-show="sidebarOpen" class="px-5 pt-4 pb-1">
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Command Center</p>
            </div>

            {{-- Search Menu --}}
            <div x-show="sidebarOpen" class="px-3 pb-2">
                <div class="relative">
                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-200 bg-slate-50/80 text-xs">
                        <input type="text" placeholder="Search menu" class="flex-1 bg-transparent outline-none text-slate-700 placeholder-slate-400 text-xs">
                        <span class="text-slate-400 text-[10px]">X</span>
                    </div>
                </div>
            </div>

            {{-- Navigation Items --}}
            <nav class="flex-1 overflow-y-auto py-2 px-3 space-y-0.5 scrollbar-thin">
                
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                   @class([
                       'flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group',
                       'bg-navy text-white font-bold shadow-xs' => request()->routeIs('admin.dashboard'),
                       'text-slate-700 hover:text-navy hover:bg-slate-100' => !request()->routeIs('admin.dashboard'),
                   ])
                >
                    <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-navy' }}" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                        <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                        <rect x="14" y="14" width="7" height="7" rx="1.5"/>
                        <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Dashboard</span>
                </a>
                {{-- Employers --}}
                <div>
                    <button @click="toggleDropdown('employers')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->routeIs('admin.companies.*', 'admin.employer-*') || request()->is('admin/command/employers*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->routeIs('admin.companies.*', 'admin.employer-*') || request()->is('admin/command/employers*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Employers</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.employers ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.employers && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.companies.index') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">All Companies</a>
                        <a href="{{ route('admin.companies.index', ['status' => 'pending']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Pending Approval</a>
                        <a href="{{ route('admin.companies.index', ['status' => 'verified']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Approved Companies</a>
                        <a href="{{ route('admin.companies.index', ['status' => 'suspended']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Suspended Companies</a>
                        <a href="{{ route('admin.companies.index', ['status' => 'expired']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Expired Companies</a>
                        <a href="{{ route('admin.masters.index', 'company-types') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Company Types</a>
                        <a href="{{ route('admin.masters.index', 'company-grades') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Company Grades</a>
                        <a href="{{ route('admin.employer-users.index') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Employer Users</a>
                        <a href="{{ route('admin.companies.index', ['status' => 'pending']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Employer Verification</a>
                        <a href="{{ route('admin.employer-documents.index') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Employer Documents</a>
                        <a href="{{ route('admin.employer-activity.index') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Employer Activity</a>
                        <a href="{{ route('admin.employer-notes.index') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Employer Notes</a>
                    </div>
                </div>

                {{-- Job Seekers --}}
                <div>
                    <button @click="toggleDropdown('jobSeekers')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->routeIs('admin.candidates.*', 'admin.candidate-*') || request()->is('admin/command/job-seekers*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->routeIs('admin.candidates.*', 'admin.candidate-*') || request()->is('admin/command/job-seekers*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Job Seekers</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.jobSeekers ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.jobSeekers && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.candidates.index', ['view' => 'all-job-seekers']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">All Job Seekers</a>
                        <a href="{{ route('admin.candidates.index', ['view' => 'new-registrations']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">New Registrations</a>
                        <a href="{{ route('admin.candidates.index', ['view' => 'verified-candidates']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Verified Candidates</a>
                        <a href="{{ route('admin.candidates.index', ['view' => 'incomplete-profiles']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Incomplete Profiles</a>
                        <a href="{{ route('admin.candidates.index', ['view' => 'complete-profiles']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Complete Profiles</a>
                        <a href="{{ route('admin.candidates.index', ['view' => 'blocked-candidates']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Blocked Candidates</a>
                        <a href="{{ route('admin.candidates.index', ['view' => 'candidate-resumes']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Candidate Resumes</a>
                        <a href="{{ route('admin.candidates.index', ['view' => 'candidate-skills']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Candidate Skills</a>
                    </div>
                </div>

                {{-- Jobs --}}
                <div>
                    <button @click="toggleDropdown('jobs')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->routeIs('admin.jobs.*') || request()->is('admin/command/jobs*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->routeIs('admin.jobs.*') || request()->is('admin/command/jobs*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Jobs</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.jobs ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.jobs && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.jobs.index') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">All Jobs</a>
                        <a href="{{ route('admin.jobs.index', ['view' => 'pending-approval']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Pending Approval</a>
                        <a href="{{ route('admin.jobs.index', ['view' => 'featured-jobs']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Featured Jobs</a>
                        <a href="{{ route('admin.jobs.index', ['view' => 'expired-jobs']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Expired Jobs</a>
                        <a href="{{ route('admin.jobs.index', ['view' => 'archived-jobs']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Archived Jobs</a>
                        <a href="{{ route('admin.jobs.create') }}" class="block py-1.5 px-2 rounded-lg text-secondary-600 hover:text-navy font-bold">+ Post New Job</a>
                    </div>
                </div>

                {{-- Recruitment --}}
                <div>
                    <button @click="toggleDropdown('recruitment')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->routeIs('admin.recruitment.*') || request()->is('admin/command/recruitment*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->routeIs('admin.recruitment.*') || request()->is('admin/command/recruitment*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Recruitment</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.recruitment ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.recruitment && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.recruitment.index') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">All Applications</a>
                        <a href="{{ route('admin.recruitment.index', ['tab' => 'pipeline']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Kanban Board</a>
                        <a href="{{ route('admin.recruitment.index', ['tab' => 'interviews']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Interview Scheduled</a>
                        <a href="{{ route('admin.recruitment.index', ['tab' => 'offers']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Offer Letters</a>
                    </div>
                </div>

                {{-- Job Masters --}}
                <div>
                    <button @click="toggleDropdown('jobMasters')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->routeIs('admin.masters.*', 'admin.records.*') || request()->is('admin/command/job-masters*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->routeIs('admin.masters.*', 'admin.records.*') || request()->is('admin/command/job-masters*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Job Masters</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.jobMasters ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.jobMasters && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.masters.index', 'job-categories') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Job Categories</a>
                        <a href="{{ route('admin.records.index', 'job-master-industries') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Industries</a>
                        <a href="{{ route('admin.records.index', 'job-master-skills') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Skills</a>
                        <a href="{{ route('admin.records.index', 'job-master-experience-levels') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Experience Levels</a>
                        <a href="{{ route('admin.records.index', 'job-master-education-levels') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Education Levels</a>
                        <a href="{{ route('admin.records.index', 'job-master-job-types') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Job Types</a>
                        <a href="{{ route('admin.records.index', 'job-master-work-modes') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Work Modes</a>
                        <a href="{{ route('admin.records.index', 'job-master-shifts') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Shifts</a>
                        <a href="{{ route('admin.records.index', 'job-master-certifications') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Certifications</a>
                        <a href="{{ route('admin.records.index', 'job-master-salary-types') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Salary Types</a>
                        <a href="{{ route('admin.records.index', 'job-master-notice-periods') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Notice Period</a>
                        <a href="{{ route('admin.records.index', 'job-master-visa-work-permit-types') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Visa Work Permit Types</a>
                    </div>
                </div>

                {{-- External Data --}}
                <div>
                    <button @click="toggleDropdown('externalData')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->routeIs('admin.external-data.*') || request()->is('admin/command/external-data*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->routeIs('admin.external-data.*') || request()->is('admin/command/external-data*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">External Data</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.externalData ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.externalData && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.external-data.index') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">External Candidates</a>
                        <a href="{{ route('admin.external-data.index', ['view' => 'external-jobs']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">External Jobs</a>
                        <a href="{{ route('admin.external-data.index', ['view' => 'partner-sources']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Partner Sources</a>
                        <a href="{{ route('admin.external-data.index', ['view' => 'import-history']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Import History</a>
                        <a href="{{ route('admin.external-data.index', ['view' => 'sync-history']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Sync History</a>
                        <a href="{{ route('admin.external-data.index', ['view' => 'failed-imports']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Failed Imports</a>
                    </div>
                </div>

                {{-- Subscriptions --}}
                <div>
                    <button @click="toggleDropdown('subscriptions')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->routeIs('admin.subscriptions.*', 'admin.operations.*') || request()->is('admin/command/subscriptions*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->routeIs('admin.subscriptions.*', 'admin.operations.*') || request()->is('admin/command/subscriptions*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Subscriptions</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.subscriptions ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.subscriptions && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.operations.index', 'packages') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Packages</a>
                        <a href="{{ route('admin.subscriptions.index') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Active Subscriptions</a>
                        <a href="{{ route('admin.subscriptions.index', ['view' => 'expired-subscriptions']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Expired Subscriptions</a>
                        <a href="{{ route('admin.subscriptions.index', ['view' => 'expiring-soon']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Expiring Soon</a>
                        <a href="{{ route('admin.subscriptions.index', ['view' => 'free-trials']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Free Trials</a>
                        <a href="{{ route('admin.subscriptions.index', ['view' => 'usage-credits']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Usage Credits</a>
                    </div>
                </div>

                {{-- Payments --}}
                <div>
                    <button @click="toggleDropdown('payments')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->routeIs('admin.payments.*', 'admin.invoices.*') || request()->is('admin/command/payments*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->routeIs('admin.payments.*', 'admin.invoices.*') || request()->is('admin/command/payments*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 002.25 19.5z" /></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Payments</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.payments ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.payments && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.payments.index') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">All Transactions</a>
                        <a href="{{ route('admin.payments.index', ['view' => 'employer-payments']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Employer Payments</a>
                        <a href="{{ route('admin.payments.index', ['view' => 'job-seeker-payments']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Job Seeker Payments</a>
                        <a href="{{ route('admin.payments.index', ['view' => 'failed-payments']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Failed Payments</a>
                        <a href="{{ route('admin.payments.index', ['view' => 'refunds']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Refunds</a>
                        <a href="{{ route('admin.payments.index', ['view' => 'invoices']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Invoices</a>
                        <a href="{{ route('admin.payments.index', ['view' => 'payment-logs']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Payment Logs</a>
                    </div>
                </div>

                {{-- AI & API --}}
                <div>
                    <button @click="toggleDropdown('aiApi')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->routeIs('admin.ai-api.*') || request()->is('admin/command/ai-api*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->routeIs('admin.ai-api.*') || request()->is('admin/command/ai-api*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">AI & API</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.aiApi ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.aiApi && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.ai-api.index', ['view' => 'global-ai-settings']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Feature Flags</a>
                        <a href="{{ route('admin.ai-api.index', ['view' => 'platform-ai']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Platform AI</a>
                        <a href="{{ route('admin.ai-api.index', ['view' => 'employer-byoai']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Employer BYOAI</a>
                        <a href="{{ route('admin.ai-api.index', ['view' => 'resume-parser']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Resume Parser</a>
                        <a href="{{ route('admin.ai-api.index', ['view' => 'api-usage']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">API Usage</a>
                        <a href="{{ route('admin.ai-api.index', ['view' => 'api-errors']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">API Errors</a>
                        <a href="{{ route('admin.ai-api.index', ['view' => 'cost-monitoring']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Cost Monitoring</a>
                    </div>
                </div>

                {{-- Interviews --}}
                <div>
                    <button @click="toggleDropdown('interviews')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->routeIs('admin.interviews.*') || request()->is('admin/command/interviews*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->routeIs('admin.interviews.*') || request()->is('admin/command/interviews*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Interviews</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.interviews ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.interviews && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.interviews.index') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">All Interviews</a>
                        <a href="{{ route('admin.interviews.index', ['view' => 'today-interviews']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Today Interviews</a>
                        <a href="{{ route('admin.interviews.index', ['view' => 'upcoming-interviews']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Upcoming Interviews</a>
                        <a href="{{ route('admin.interviews.index', ['view' => 'completed-interviews']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Completed Interviews</a>
                        <a href="{{ route('admin.interviews.index', ['view' => 'cancelled-interviews']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Cancelled Interviews</a>
                        <a href="{{ route('admin.interviews.index', ['view' => 'interview-modes']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Interview Modes</a>
                        <a href="{{ route('admin.interviews.index', ['view' => 'calendar-connections']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Calendar Connections</a>
                    </div>
                </div>

                {{-- Offers --}}
                <div>
                    <button @click="toggleDropdown('offers')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->is('admin/command/offers*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->is('admin/command/offers*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Offers</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.offers ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.offers && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.command.show', ['section' => 'offers', 'view' => 'all-offers']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">All Offers</a>
                        <a href="{{ route('admin.command.show', ['section' => 'offers', 'view' => 'sent-offers']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Sent Offers</a>
                        <a href="{{ route('admin.command.show', ['section' => 'offers', 'view' => 'accepted-offers']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Accepted Offers</a>
                        <a href="{{ route('admin.command.show', ['section' => 'offers', 'view' => 'rejected-offers']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Rejected Offers</a>
                        <a href="{{ route('admin.command.show', ['section' => 'offers', 'view' => 'expired-offers']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Expired Offers</a>
                    </div>
                </div>

                {{-- Communication --}}
                <div>
                    <button @click="toggleDropdown('communication')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->routeIs('admin.communication.*') || request()->is('admin/command/communication*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->routeIs('admin.communication.*') || request()->is('admin/command/communication*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Communication</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.communication ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.communication && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.communication.index', ['view' => 'email-templates']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Email Templates</a>
                        <a href="{{ route('admin.communication.index', ['view' => 'whatsapp-templates']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">WhatsApp Templates</a>
                        <a href="{{ route('admin.communication.index', ['view' => 'interview-templates']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Interview Templates</a>
                        <a href="{{ route('admin.communication.index', ['view' => 'offer-templates']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Offer Templates</a>
                        <a href="{{ route('admin.communication.index', ['view' => 'communication-history']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Communication History</a>
                        <a href="{{ route('admin.communication.index', ['view' => 'scheduled-messages']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Scheduled Messages</a>
                    </div>
                </div>

                {{-- Notifications --}}
                <div>
                    <button @click="toggleDropdown('notifications')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->routeIs('admin.notifications.*') || request()->is('admin/command/notifications*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->routeIs('admin.notifications.*') || request()->is('admin/command/notifications*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Notifications</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.notifications ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.notifications && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.notifications.index') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Notification Dashboard</a>
                        <a href="{{ route('admin.notifications.index', ['view' => 'push-notifications']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Push Notifications</a>
                        <a href="{{ route('admin.notifications.index', ['view' => 'email-notifications']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Email Notifications</a>
                        <a href="{{ route('admin.notifications.index', ['view' => 'admin-alerts']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Admin Alerts</a>
                        <a href="{{ route('admin.notifications.index', ['view' => 'employer-alerts']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Employer Alerts</a>
                        <a href="{{ route('admin.notifications.index', ['view' => 'job-seeker-alerts']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Job Seeker Alerts</a>
                        <a href="{{ route('admin.notifications.index', ['view' => 'notification-sounds']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Notification Sounds</a>
                        <a href="{{ route('admin.notifications.index', ['view' => 'notification-history']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Notification History</a>
                    </div>
                </div>

                {{-- CMS --}}
                <div>
                    <button @click="toggleDropdown('cms')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->routeIs('admin.cms.*', 'admin.blogs.*') || request()->is('admin/command/cms*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->routeIs('admin.cms.*', 'admin.blogs.*') || request()->is('admin/command/cms*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">CMS</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.cms ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.cms && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.blogs.index') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Blog</a>
                        <a href="{{ route('admin.operations.index', 'sliders') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Sliders</a>
                        <a href="{{ route('admin.cms.index') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Home Page</a>
                        <a href="{{ route('admin.cms.index', ['view' => 'specializations']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Specializations</a>
                        <a href="{{ route('admin.cms.index', ['view' => 'testimonials']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Testimonials</a>
                        <a href="{{ route('admin.cms.index', ['view' => 'faq']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">FAQ</a>
                        <a href="{{ route('admin.cms.index', ['view' => 'pages']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Pages</a>
                        <a href="{{ route('admin.cms.index', ['view' => 'app-links']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">App Links</a>
                    </div>
                </div>

                {{-- Mobile Apps --}}
                <div>
                    <button @click="toggleDropdown('mobileApps')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->is('admin/command/mobile-apps*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->is('admin/command/mobile-apps*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Mobile Apps</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.mobileApps ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.mobileApps && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.command.show', ['section' => 'mobile-apps', 'view' => 'job-seeker-app-settings']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Job Seeker App</a>
                        <a href="{{ route('admin.command.show', ['section' => 'mobile-apps', 'view' => 'employer-app-settings']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Employer App</a>
                        <a href="{{ route('admin.command.show', ['section' => 'mobile-apps', 'view' => 'minimum-app-version']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">App Version</a>
                        <a href="{{ route('admin.command.show', ['section' => 'mobile-apps', 'view' => 'maintenance-mode']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Maintenance Mode</a>
                    </div>
                </div>

                {{-- Support --}}
                <div>
                    <button @click="toggleDropdown('support')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->routeIs('admin.support-center.*') || request()->is('admin/command/support*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->routeIs('admin.support-center.*') || request()->is('admin/command/support*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.712 4.33a9.027 9.027 0 011.652 1.306c.51.51.944 1.064 1.306 1.652M16.712 4.33l-3.448 4.138m3.448-4.138a9.014 9.014 0 00-9.424 0M19.67 7.288l-4.138 3.448m4.138-3.448a9.014 9.014 0 010 9.424m-4.138-5.976a3.736 3.736 0 00-.88-1.388 3.737 3.737 0 00-1.388-.88m2.268 2.268a3.765 3.765 0 010 2.528m-2.268-4.796a3.765 3.765 0 00-2.528 0m4.796 4.796c-.181.506-.475.982-.88 1.388a3.736 3.736 0 01-1.388.88m2.268-2.268l4.138 3.448m0 0a9.027 9.027 0 01-1.306 1.652 9.027 9.027 0 01-1.652 1.306m2.958-2.958a9.014 9.014 0 010-9.424m-4.138 12.372l-3.448-4.138m3.448 4.138a9.014 9.014 0 01-9.424 0m5.976-4.138a3.765 3.765 0 01-2.528 0m0 0a3.736 3.736 0 01-1.388-.88 3.737 3.737 0 01-.88-1.388m0 0a3.765 3.765 0 010-2.528m2.268 4.796l-4.138 3.448M4.33 16.712a9.014 9.014 0 010-9.424m4.138 5.976l-4.138-3.448m0 0a9.027 9.027 0 011.306-1.652 9.027 9.027 0 011.652-1.306"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Support</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.support ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.support && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.support-center.index') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">All Queries</a>
                        <a href="{{ route('admin.support-center.index', ['view' => 'new-queries']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">New Queries</a>
                        <a href="{{ route('admin.support-center.index', ['view' => 'open']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Open</a>
                        <a href="{{ route('admin.support-center.index', ['view' => 'in-progress']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">In Progress</a>
                        <a href="{{ route('admin.support-center.index', ['view' => 'resolved']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Resolved</a>
                        <a href="{{ route('admin.support-center.index', ['view' => 'closed']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Closed</a>
                    </div>
                </div>

                {{-- Reports --}}
                <div>
                    <button @click="toggleDropdown('reports')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->routeIs('admin.reports.*') || request()->is('admin/command/reports*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->routeIs('admin.reports.*') || request()->is('admin/command/reports*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Reports</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.reports ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.reports && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.reports.index') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Employer Reports</a>
                        <a href="{{ route('admin.reports.index', ['view' => 'job-seeker-reports']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Job Seeker Reports</a>
                        <a href="{{ route('admin.reports.index', ['view' => 'job-reports']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Job Reports</a>
                        <a href="{{ route('admin.reports.index', ['view' => 'application-reports']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Application Reports</a>
                        <a href="{{ route('admin.reports.index', ['view' => 'interview-reports']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Interview Reports</a>
                        <a href="{{ route('admin.reports.index', ['view' => 'offer-reports']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Offer Reports</a>
                        <a href="{{ route('admin.reports.index', ['view' => 'hiring-reports']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Hiring Reports</a>
                        <a href="{{ route('admin.reports.index', ['view' => 'subscription-reports']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Subscription Reports</a>
                        <a href="{{ route('admin.reports.index', ['view' => 'payment-reports']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Payment Reports</a>
                        <a href="{{ route('admin.reports.index', ['view' => 'revenue-reports']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Revenue Reports</a>
                        <a href="{{ route('admin.reports.index', ['view' => 'ai-usage-reports']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">AI Usage Reports</a>
                        <a href="{{ route('admin.reports.index', ['view' => 'country-reports']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Country Reports</a>
                    </div>
                </div>

                {{-- Analytics --}}
                <div>
                    <button @click="toggleDropdown('analytics')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->is('admin/command/analytics*') || request()->is('admin/control-center*analytics*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->is('admin/command/analytics*') || request()->is('admin/control-center*analytics*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Analytics</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.analytics ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.analytics && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.control-center.index', ['section' => 'analytics', 'view' => 'hiring-funnel']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Hiring Funnel</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'analytics', 'view' => 'application-conversion']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Application Conversion</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'analytics', 'view' => 'interview-conversion']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Interview Conversion</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'analytics', 'view' => 'offer-acceptance-rate']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Offer Acceptance Rate</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'analytics', 'view' => 'employer-activity']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Employer Activity</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'analytics', 'view' => 'candidate-growth']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Candidate Growth</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'analytics', 'view' => 'revenue-by-country']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Revenue by Country</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'analytics', 'view' => 'ai-usage-by-employer']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">AI Usage by Employer</a>
                    </div>
                </div>

                {{-- Users & Permissions --}}
                <div>
                    <button @click="toggleDropdown('usersPermissions')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->is('admin/control-center*users-permissions*') || request()->is('admin/command/users-permissions*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->is('admin/control-center*users-permissions*') || request()->is('admin/command/users-permissions*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Users & Permissions</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.usersPermissions ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.usersPermissions && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.control-center.index', ['section' => 'users-permissions', 'view' => 'admin-users']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Admin Users</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'users-permissions', 'view' => 'admin-roles']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Admin Roles</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'users-permissions', 'view' => 'permissions']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Permissions</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'users-permissions', 'view' => 'activity-logs']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Activity Logs</a>
                    </div>
                </div>

                {{-- Audit Logs --}}
                <div>
                    <button @click="toggleDropdown('auditLogs')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->is('admin/control-center*audit-logs*') || request()->is('admin/command/audit-logs*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->is('admin/control-center*audit-logs*') || request()->is('admin/command/audit-logs*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Audit Logs</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.auditLogs ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.auditLogs && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.control-center.index', ['section' => 'audit-logs', 'view' => 'admin-activity']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Admin Activity</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'audit-logs', 'view' => 'employer-activity']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Employer Activity</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'audit-logs', 'view' => 'candidate-activity']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Candidate Activity</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'audit-logs', 'view' => 'api-changes']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">API Changes</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'audit-logs', 'view' => 'payment-changes']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Payment Changes</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'audit-logs', 'view' => 'security-logs']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Security Logs</a>
                    </div>
                </div>

                {{-- Settings --}}
                <div>
                    <button @click="toggleDropdown('settings')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->routeIs('admin.site-settings.*') || request()->is('admin/command/settings*') || request()->is('admin/control-center*settings*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->routeIs('admin.site-settings.*') || request()->is('admin/command/settings*') || request()->is('admin/control-center*settings*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><circle cx="12" cy="12" r="3"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Settings</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.settings ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.settings && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.site-settings.edit') }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Branding & Contact</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'settings', 'view' => 'seo']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">SEO</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'settings', 'view' => 'currency']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Currency</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'settings', 'view' => 'email-configuration']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Email Configuration</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'settings', 'view' => 'maintenance-mode']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Maintenance Mode</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'settings', 'view' => 'terms']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Terms</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'settings', 'view' => 'privacy']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Privacy</a>
                    </div>
                </div>

                {{-- System --}}
                <div>
                    <button @click="toggleDropdown('system')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold transition-all group cursor-pointer', 'bg-slate-100 text-navy font-bold' => request()->is('admin/control-center*system*') || request()->is('admin/command/system*'), 'text-slate-700 hover:text-navy hover:bg-slate-100' => !(request()->is('admin/control-center*system*') || request()->is('admin/command/system*'))])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-500 group-hover:text-navy" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">System</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.system ? 'rotate-180' : ''" class="w-3.5 h-3.5 text-slate-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.system && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.control-center.index', ['section' => 'system', 'view' => 'login-security']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Login Security</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'system', 'view' => 'password-policy']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Password Policy</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'system', 'view' => 'session-settings']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Session Settings</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'system', 'view' => 'ip-blocking']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">IP Blocking</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'system', 'view' => 'api-rate-limits']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">API Rate Limits</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'system', 'view' => 'import-export']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Import Export</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'system', 'view' => 'system-logs']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">System Logs</a>
                        <a href="{{ route('admin.control-center.index', ['section' => 'system', 'view' => 'backup']) }}" class="block py-1.5 px-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 font-medium">Backup</a>
                    </div>
                </div>

            </nav>

            {{-- ACTIONS Section --}}
            <div class="border-t border-border bg-slate-50/80">
                <div x-show="sidebarOpen" class="px-5 pt-3 pb-1">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Actions</p>
                </div>
                <div class="px-3 pb-2 space-y-0.5">
                    <a href="{{ route('admin.site-settings.edit') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold text-slate-600 hover:text-navy hover:bg-slate-100 transition-colors">
                        <svg class="w-4 h-4 shrink-0 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.764m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/></svg>
                        <span x-show="sidebarOpen">Branding & Contact</span>
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold text-slate-600 hover:text-navy hover:bg-slate-100 transition-colors">
                        <svg class="w-4 h-4 shrink-0 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                        <span x-show="sidebarOpen">View Website</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2.5 w-full px-3 py-2 rounded-lg text-xs font-semibold text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                            <span x-show="sidebarOpen">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
{{-- Collapse Toggle Button --}}
            <button @click="sidebarOpen = !sidebarOpen" class="absolute top-18 -right-3 w-6 h-6 rounded-full bg-white border border-border shadow-md flex items-center justify-center hover:bg-surface transition-colors cursor-pointer">
                <svg :class="sidebarOpen ? '' : 'rotate-180'" class="w-3.5 h-3.5 text-navy transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
        </aside>

        {{-- Main Page Container --}}
        <div class="flex-1 lg:ml-64 flex flex-col min-w-0">
            {{-- Top Bar --}}
            <header class="sticky top-0 z-20 bg-white/95 backdrop-blur-md border-b border-border h-16 flex items-center justify-between px-6 shadow-2xs">
                <div class="flex items-center gap-4">
                    <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="lg:hidden p-2 rounded-lg hover:bg-surface-sunken">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>

                    <div>
                        <h1 class="text-lg font-heading font-bold text-navy leading-tight">
                            {{ $heading ?? $title }}
                        </h1>
                    </div>
                </div>

                {{-- Header Actions --}}
                <div class="flex items-center gap-4">
                    {{-- Notification Bell with Live Database Feed & Audio Chimes --}}
                    <div class="relative" x-data="notificationCenter()">
                        <button @click="toggle()" @mouseenter="playChime('system_alert')" type="button" class="relative p-2 rounded-xl text-slate-600 hover:text-navy hover:bg-slate-100 transition-colors cursor-pointer" title="Platform Notifications">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span x-show="unreadCount > 0" class="absolute top-1 right-1 flex h-4 w-4">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-4 w-4 bg-rose-500 text-[10px] font-bold text-white items-center justify-center" x-text="unreadCount"></span>
                            </span>
                        </button>

                        {{-- Dropdown Panel --}}
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-border z-50 overflow-hidden">
                            <div class="p-4 bg-navy text-white flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <h4 class="text-sm font-bold">Platform Notifications</h4>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-white/20 text-white" x-text="unreadCount + ' new'"></span>
                                </div>
                                <button @click="markAllAsRead()" class="text-xs text-secondary-300 hover:text-white transition-colors cursor-pointer">
                                    Mark all read
                                </button>
                            </div>
                            <div class="max-h-80 overflow-y-auto divide-y divide-border">
                                <template x-for="n in notifications" :key="n.id">
                                    <div @click="playChime(n.type)" class="p-4 hover:bg-slate-50 transition-colors cursor-pointer flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" :class="n.unread ? 'bg-secondary-100 text-secondary-700' : 'bg-slate-100 text-slate-500'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-xs font-bold text-navy" x-text="n.title"></p>
                                            <p class="text-xs text-text-secondary mt-0.5 line-clamp-2" x-text="n.body"></p>
                                            <span class="text-[10px] text-text-muted mt-1 block" x-text="n.time"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <div class="p-3 bg-slate-50 border-t border-border text-center">
                                <a href="{{ route('admin.notifications.index') }}" class="text-xs font-bold text-accent hover:underline">
                                    Open Full Notification Hub →
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-border hover:border-accent text-xs font-semibold text-text-secondary hover:text-accent transition-colors">
                        <span>View Public Website</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>

                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-bold text-text-secondary hidden md:inline">Live Production</span>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="m-6 mb-0 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="m-6 mb-0 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm font-semibold flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- Page Content Slot --}}
            <main class="p-6 md:p-8 flex-1 overflow-x-hidden">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>