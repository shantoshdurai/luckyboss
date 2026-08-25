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
            <nav class="flex-1 overflow-y-auto py-2 px-3 space-y-1 scrollbar-thin">
                
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                   @class([
                       'flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all group',
                       'bg-navy text-white shadow-xs' => request()->routeIs('admin.dashboard'),
                       'text-slate-700 hover:text-navy hover:bg-slate-100 font-semibold' => !request()->routeIs('admin.dashboard'),
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
                @php $isEmployers = request()->routeIs('admin.companies.*', 'admin.employer-*') || request()->is('admin/command/employers*'); @endphp
                <div>
                    <button @click="toggleDropdown('employers')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition-all group cursor-pointer', 'bg-navy text-white shadow-xs' => $isEmployers, 'text-slate-700 hover:text-navy hover:bg-slate-100 font-semibold' => !$isEmployers])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 {{ $isEmployers ? 'text-white' : 'text-slate-500 group-hover:text-navy' }}" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Employers</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.employers ? 'rotate-180' : ''" class="w-3.5 h-3.5 {{ $isEmployers ? 'text-white/80' : 'text-slate-400' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.employers && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.companies.index') }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request()->routeIs('admin.companies.index') && !request('status'), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !(request()->routeIs('admin.companies.index') && !request('status'))])>All Companies</a>
                        <a href="{{ route('admin.companies.index', ['status' => 'pending']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('status') === 'pending', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('status') !== 'pending'])>Pending Approval</a>
                        <a href="{{ route('admin.companies.index', ['status' => 'verified']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('status') === 'verified', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('status') !== 'verified'])>Approved Companies</a>
                        <a href="{{ route('admin.employer-users.index') }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request()->routeIs('admin.employer-users.*'), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !request()->routeIs('admin.employer-users.*')])>Employer Users</a>
                        <a href="{{ route('admin.employer-documents.index') }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request()->routeIs('admin.employer-documents.*'), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !request()->routeIs('admin.employer-documents.*')])>Employer Documents</a>
                        <a href="{{ route('admin.employer-notes.index') }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request()->routeIs('admin.employer-notes.*'), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !request()->routeIs('admin.employer-notes.*')])>Employer Notes</a>
                    </div>
                </div>

                {{-- Job Seekers --}}
                @php $isSeekers = request()->routeIs('admin.candidates.*', 'admin.candidate-*') || request()->is('admin/command/job-seekers*'); @endphp
                <div>
                    <button @click="toggleDropdown('jobSeekers')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition-all group cursor-pointer', 'bg-navy text-white shadow-xs' => $isSeekers, 'text-slate-700 hover:text-navy hover:bg-slate-100 font-semibold' => !$isSeekers])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 {{ $isSeekers ? 'text-white' : 'text-slate-500 group-hover:text-navy' }}" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Job Seekers</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.jobSeekers ? 'rotate-180' : ''" class="w-3.5 h-3.5 {{ $isSeekers ? 'text-white/80' : 'text-slate-400' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.jobSeekers && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.candidates.index', ['view' => 'all-job-seekers']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('view') === 'all-job-seekers' || (request()->routeIs('admin.candidates.index') && !request('view')), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !(request('view') === 'all-job-seekers' || (request()->routeIs('admin.candidates.index') && !request('view')))])>All Job Seekers</a>
                        <a href="{{ route('admin.candidates.index', ['view' => 'verified-candidates']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('view') === 'verified-candidates', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('view') !== 'verified-candidates'])>Verified Candidates</a>
                        <a href="{{ route('admin.candidates.index', ['view' => 'incomplete-profiles']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('view') === 'incomplete-profiles', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('view') !== 'incomplete-profiles'])>Incomplete Profiles</a>
                        <a href="{{ route('admin.candidates.index', ['view' => 'candidate-resumes']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('view') === 'candidate-resumes', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('view') !== 'candidate-resumes'])>Candidate Resumes</a>
                        <a href="{{ route('admin.candidates.index', ['view' => 'candidate-skills']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('view') === 'candidate-skills', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('view') !== 'candidate-skills'])>Candidate Skills</a>
                    </div>
                </div>

                {{-- Jobs --}}
                @php $isJobs = request()->routeIs('admin.jobs.*') || request()->is('admin/command/jobs*'); @endphp
                <div>
                    <button @click="toggleDropdown('jobs')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition-all group cursor-pointer', 'bg-navy text-white shadow-xs' => $isJobs, 'text-slate-700 hover:text-navy hover:bg-slate-100 font-semibold' => !$isJobs])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 {{ $isJobs ? 'text-white' : 'text-slate-500 group-hover:text-navy' }}" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Jobs</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.jobs ? 'rotate-180' : ''" class="w-3.5 h-3.5 {{ $isJobs ? 'text-white/80' : 'text-slate-400' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.jobs && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.jobs.index') }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request()->routeIs('admin.jobs.index') && !request('view'), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !(request()->routeIs('admin.jobs.index') && !request('view'))])>All Jobs</a>
                        <a href="{{ route('admin.jobs.index', ['view' => 'pending-approval']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('view') === 'pending-approval', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('view') !== 'pending-approval'])>Pending Approval</a>
                        <a href="{{ route('admin.jobs.index', ['view' => 'featured-jobs']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('view') === 'featured-jobs', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('view') !== 'featured-jobs'])>Featured Jobs</a>
                        <a href="{{ route('admin.jobs.create') }}" class="block py-1.5 px-2 rounded-lg text-secondary-600 hover:text-navy font-bold">+ Post New Job</a>
                    </div>
                </div>

                {{-- Recruitment --}}
                @php $isRecruit = request()->routeIs('admin.recruitment.*') || request()->is('admin/command/recruitment*'); @endphp
                <div>
                    <button @click="toggleDropdown('recruitment')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition-all group cursor-pointer', 'bg-navy text-white shadow-xs' => $isRecruit, 'text-slate-700 hover:text-navy hover:bg-slate-100 font-semibold' => !$isRecruit])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 {{ $isRecruit ? 'text-white' : 'text-slate-500 group-hover:text-navy' }}" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Recruitment</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.recruitment ? 'rotate-180' : ''" class="w-3.5 h-3.5 {{ $isRecruit ? 'text-white/80' : 'text-slate-400' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.recruitment && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.recruitment.index') }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request()->routeIs('admin.recruitment.index') && !request('tab'), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !(request()->routeIs('admin.recruitment.index') && !request('tab'))])>All Applications</a>
                        <a href="{{ route('admin.recruitment.index', ['tab' => 'pipeline']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('tab') === 'pipeline', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('tab') !== 'pipeline'])>Kanban Board</a>
                        <a href="{{ route('admin.recruitment.index', ['tab' => 'interviews']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('tab') === 'interviews', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('tab') !== 'interviews'])>Interview Scheduled</a>
                        <a href="{{ route('admin.recruitment.index', ['tab' => 'offers']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('tab') === 'offers', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('tab') !== 'offers'])>Offer Letters</a>
                    </div>
                </div>

                {{-- Subscriptions --}}
                @php $isSubs = request()->routeIs('admin.subscriptions.*', 'admin.operations.*') || request()->is('admin/command/subscriptions*'); @endphp
                <div>
                    <button @click="toggleDropdown('subscriptions')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition-all group cursor-pointer', 'bg-navy text-white shadow-xs' => $isSubs, 'text-slate-700 hover:text-navy hover:bg-slate-100 font-semibold' => !$isSubs])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 {{ $isSubs ? 'text-white' : 'text-slate-500 group-hover:text-navy' }}" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Subscriptions</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.subscriptions ? 'rotate-180' : ''" class="w-3.5 h-3.5 {{ $isSubs ? 'text-white/80' : 'text-slate-400' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.subscriptions && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.operations.index', 'packages') }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request()->is('admin/operations/packages*'), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !request()->is('admin/operations/packages*')])>Packages</a>
                        <a href="{{ route('admin.subscriptions.index') }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request()->routeIs('admin.subscriptions.index') && !request('view'), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !(request()->routeIs('admin.subscriptions.index') && !request('view'))])>Active Subscriptions</a>
                    </div>
                </div>

                {{-- Payments --}}
                @php $isPayments = request()->routeIs('admin.payments.*', 'admin.invoices.*') || request()->is('admin/command/payments*'); @endphp
                <div>
                    <button @click="toggleDropdown('payments')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition-all group cursor-pointer', 'bg-navy text-white shadow-xs' => $isPayments, 'text-slate-700 hover:text-navy hover:bg-slate-100 font-semibold' => !$isPayments])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 {{ $isPayments ? 'text-white' : 'text-slate-500 group-hover:text-navy' }}" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 002.25 19.5z" /></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Payments</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.payments ? 'rotate-180' : ''" class="w-3.5 h-3.5 {{ $isPayments ? 'text-white/80' : 'text-slate-400' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.payments && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.payments.index') }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request()->routeIs('admin.payments.index') && !request('view'), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !(request()->routeIs('admin.payments.index') && !request('view'))])>All Transactions</a>
                        <a href="{{ route('admin.payments.index', ['view' => 'employer-payments']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('view') === 'employer-payments', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('view') !== 'employer-payments'])>Employer Payments</a>
                        <a href="{{ route('admin.payments.index', ['view' => 'job-seeker-payments']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('view') === 'job-seeker-payments', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('view') !== 'job-seeker-payments'])>Job Seeker Payments</a>
                    </div>
                </div>

                {{-- AI & API --}}
                @php $isAiApi = request()->routeIs('admin.ai-api.*') || request()->is('admin/command/ai-api*'); @endphp
                <div>
                    <button @click="toggleDropdown('aiApi')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition-all group cursor-pointer', 'bg-navy text-white shadow-xs' => $isAiApi, 'text-slate-700 hover:text-navy hover:bg-slate-100 font-semibold' => !$isAiApi])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 {{ $isAiApi ? 'text-white' : 'text-slate-500 group-hover:text-navy' }}" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">AI & API</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.aiApi ? 'rotate-180' : ''" class="w-3.5 h-3.5 {{ $isAiApi ? 'text-white/80' : 'text-slate-400' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.aiApi && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.ai-api.index', ['view' => 'global-ai-settings']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('view') === 'global-ai-settings', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('view') !== 'global-ai-settings'])>Feature Flags</a>
                        <a href="{{ route('admin.ai-api.index', ['view' => 'platform-ai']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('view') === 'platform-ai', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('view') !== 'platform-ai'])>Platform AI</a>
                        <a href="{{ route('admin.ai-api.index', ['view' => 'employer-byoai']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('view') === 'employer-byoai', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('view') !== 'employer-byoai'])>Employer BYOAI</a>
                        <a href="{{ route('admin.ai-api.index', ['view' => 'resume-parser']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('view') === 'resume-parser', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('view') !== 'resume-parser'])>Resume Parser</a>
                        <a href="{{ route('admin.ai-api.index', ['view' => 'api-usage']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('view') === 'api-usage', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('view') !== 'api-usage'])>API Usage</a>
                        <a href="{{ route('admin.ai-api.index', ['view' => 'api-errors']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('view') === 'api-errors', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('view') !== 'api-errors'])>API Errors</a>
                        <a href="{{ route('admin.ai-api.index', ['view' => 'cost-monitoring']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request('view') === 'cost-monitoring', 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => request('view') !== 'cost-monitoring'])>Cost Monitoring</a>
                    </div>
                </div>

                {{-- Mobile Apps --}}
                @php $isMobileApps = request()->is('admin/command/mobile-apps*'); @endphp
                <div>
                    <button @click="toggleDropdown('mobileApps')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition-all group cursor-pointer', 'bg-navy text-white shadow-xs' => $isMobileApps, 'text-slate-700 hover:text-navy hover:bg-slate-100 font-semibold' => !$isMobileApps])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 {{ $isMobileApps ? 'text-white' : 'text-slate-500 group-hover:text-navy' }}" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Mobile Apps</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.mobileApps ? 'rotate-180' : ''" class="w-3.5 h-3.5 {{ $isMobileApps ? 'text-white/80' : 'text-slate-400' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.mobileApps && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.command.show', ['mobile-apps', 'job-seeker-app-settings']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request()->is('admin/command/mobile-apps/job-seeker-app-settings'), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !request()->is('admin/command/mobile-apps/job-seeker-app-settings')])>Job Seeker App</a>
                        <a href="{{ route('admin.command.show', ['mobile-apps', 'employer-app-settings']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request()->is('admin/command/mobile-apps/employer-app-settings'), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !request()->is('admin/command/mobile-apps/employer-app-settings')])>Employer App</a>
                        <a href="{{ route('admin.command.show', ['mobile-apps', 'minimum-app-version']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request()->is('admin/command/mobile-apps/minimum-app-version'), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !request()->is('admin/command/mobile-apps/minimum-app-version')])>App Version</a>
                        <a href="{{ route('admin.command.show', ['mobile-apps', 'maintenance-mode']) }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request()->is('admin/command/mobile-apps/maintenance-mode'), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !request()->is('admin/command/mobile-apps/maintenance-mode')])>Maintenance Mode</a>
                    </div>
                </div>

                {{-- Interviews --}}
                @php $isInterviews = request()->routeIs('admin.interviews.*') || request()->is('admin/command/interviews*'); @endphp
                <div>
                    <button @click="toggleDropdown('interviews')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition-all group cursor-pointer', 'bg-navy text-white shadow-xs' => $isInterviews, 'text-slate-700 hover:text-navy hover:bg-slate-100 font-semibold' => !$isInterviews])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 {{ $isInterviews ? 'text-white' : 'text-slate-500 group-hover:text-navy' }}" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Interviews</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.interviews ? 'rotate-180' : ''" class="w-3.5 h-3.5 {{ $isInterviews ? 'text-white/80' : 'text-slate-400' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.interviews && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.interviews.index') }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request()->routeIs('admin.interviews.index') && !request('view'), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !(request()->routeIs('admin.interviews.index') && !request('view'))])>All Interviews</a>
                    </div>
                </div>

                {{-- Notifications --}}
                @php $isNotifs = request()->routeIs('admin.notifications.*') || request()->is('admin/command/notifications*'); @endphp
                <div>
                    <button @click="toggleDropdown('notifications')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition-all group cursor-pointer', 'bg-navy text-white shadow-xs' => $isNotifs, 'text-slate-700 hover:text-navy hover:bg-slate-100 font-semibold' => !$isNotifs])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 {{ $isNotifs ? 'text-white' : 'text-slate-500 group-hover:text-navy' }}" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Notifications</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.notifications ? 'rotate-180' : ''" class="w-3.5 h-3.5 {{ $isNotifs ? 'text-white/80' : 'text-slate-400' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.notifications && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.notifications.index') }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request()->routeIs('admin.notifications.index'), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !request()->routeIs('admin.notifications.index')])>Notification History</a>
                    </div>
                </div>

                {{-- Settings --}}
                @php $isSettings = request()->routeIs('admin.site-settings.*') || request()->is('admin/command/settings*') || request()->is('admin/control-center*settings*'); @endphp
                <div>
                    <button @click="toggleDropdown('settings')" type="button" @class(['w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition-all group cursor-pointer', 'bg-navy text-white shadow-xs' => $isSettings, 'text-slate-700 hover:text-navy hover:bg-slate-100 font-semibold' => !$isSettings])>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 {{ $isSettings ? 'text-white' : 'text-slate-500 group-hover:text-navy' }}" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><circle cx="12" cy="12" r="3"/></svg>
                            <span x-show="sidebarOpen" class="whitespace-nowrap">Settings</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="openDropdowns.settings ? 'rotate-180' : ''" class="w-3.5 h-3.5 {{ $isSettings ? 'text-white/80' : 'text-slate-400' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openDropdowns.settings && sidebarOpen" x-cloak class="mt-1 pl-9 pr-2 space-y-0.5 text-xs border-l-2 border-slate-200 ml-5">
                        <a href="{{ route('admin.site-settings.edit') }}" @class(['block py-1.5 px-2 rounded-lg text-xs transition-all', 'text-navy font-bold bg-slate-100/90' => request()->routeIs('admin.site-settings.*'), 'text-slate-600 hover:text-navy hover:bg-slate-50 font-medium' => !request()->routeIs('admin.site-settings.*')])>Branding & Contact</a>
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
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-white/20 text-white" x-text="notifications.length > 0 ? (notifications.length + ' new') : '0 new'"></span>
                                </div>
                                <button x-show="notifications.length > 0" @click="clearAllNotifications()" class="text-xs text-secondary-300 hover:text-white transition-colors cursor-pointer">
                                    Clear all
                                </button>
                            </div>
                            <div class="max-h-80 overflow-y-auto divide-y divide-border">
                                <template x-if="notifications.length === 0">
                                    <div class="py-8 px-4 text-center">
                                        <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-2.5">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <p class="text-xs font-bold text-navy">All Caught Up!</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">No unread notifications. History is recorded in Admin logs.</p>
                                    </div>
                                </template>
                                <template x-for="n in notifications" :key="n.id">
                                    <div @click="playChime(n.type)" class="p-4 hover:bg-slate-50 transition-colors cursor-pointer flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 bg-secondary-100 text-secondary-700">
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
                            <div class="p-3 bg-slate-50 border-t border-border flex items-center justify-between gap-2">
                                <button @click="clearAllNotifications()" :disabled="notifications.length === 0" type="button" class="flex-1 py-2 px-3 rounded-xl text-xs font-bold bg-white hover:bg-rose-50 text-slate-700 hover:text-rose-600 border border-slate-200 hover:border-rose-200 transition-all flex items-center justify-center gap-1.5 cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    <span x-text="notifications.length > 0 ? 'Clear All Notifications' : 'All Notifications Cleared'"></span>
                                </button>
                                <a href="{{ route('admin.notifications.index') }}" title="Open Admin Notification Logs" class="py-2 px-3 rounded-xl text-xs font-bold text-slate-600 hover:text-navy hover:bg-slate-200/70 border border-slate-200 transition-all shrink-0">
                                    Logs ↗
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