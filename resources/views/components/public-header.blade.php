<header 
    x-data="{ 
        open: false,
        registerOpen: false
    }" 
    class="sticky top-0 z-50 bg-[#031533] border-b border-white/10 text-white shadow-md"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-18 lg:h-20 gap-3">
            {{-- Brand Logo --}}
            <a href="{{ route('home') }}" class="flex items-center py-1 flex-shrink-0 group">
                <div class="relative py-1 flex items-center">
                    <img 
                        src="{{ asset('images/lucky-boss-logo-transparent.png') }}" 
                        alt="Lucky Boss" 
                        class="h-10 sm:h-12 w-auto object-contain transition-transform duration-200 group-hover:scale-102 filter drop-shadow-sm"
                    >
                </div>
            </a>

            {{-- Clean Desktop Navigation (Specializations tab removed as requested) --}}
            <nav class="hidden xl:flex items-center gap-1 p-1 rounded-2xl border border-white/15 bg-white/10 backdrop-blur-md text-slate-200">
                {{-- 1. Home --}}
                <a href="{{ route('home') }}" 
                   class="px-3.5 py-1.5 text-xs font-semibold rounded-xl transition-all duration-150 {{ request()->routeIs('home') ? 'bg-white/20 text-white shadow-xs font-bold' : 'hover:text-white hover:bg-white/15' }}">
                    Home
                </a>

                {{-- 2. Find Jobs --}}
                <a href="{{ route('jobs.index') }}" 
                   class="px-3.5 py-1.5 text-xs font-semibold rounded-xl transition-all duration-150 {{ request()->routeIs('jobs.*') ? 'bg-white/20 text-white shadow-xs font-bold' : 'hover:text-white hover:bg-white/15' }}">
                    Find Jobs
                </a>

                {{-- 3. Job Categories --}}
                <a href="{{ route('categories.index') }}" 
                   class="px-3.5 py-1.5 text-xs font-semibold rounded-xl transition-all duration-150 {{ request()->routeIs('categories.*') ? 'bg-white/20 text-white shadow-xs font-bold' : 'hover:text-white hover:bg-white/15' }}">
                    Job Categories
                </a>

                {{-- 4. Employers --}}
                <a href="{{ route('employers.public') }}" 
                   class="px-3.5 py-1.5 text-xs font-semibold rounded-xl transition-all duration-150 {{ request()->routeIs('employers.*') ? 'bg-white/20 text-white shadow-xs font-bold' : 'hover:text-white hover:bg-white/15' }}">
                    Employers
                </a>

                {{-- 5. Job Seekers --}}
                <a href="{{ route('seekers.public') }}" 
                   class="px-3.5 py-1.5 text-xs font-semibold rounded-xl transition-all duration-150 {{ request()->routeIs('seekers.*') ? 'bg-white/20 text-white shadow-xs font-bold' : 'hover:text-white hover:bg-white/15' }}">
                    Job Seekers
                </a>

                {{-- 6. Blog --}}
                <a href="{{ route('blogs.index') }}" 
                   class="px-3.5 py-1.5 text-xs font-semibold rounded-xl transition-all duration-150 {{ request()->routeIs('blogs.*') ? 'bg-white/20 text-white shadow-xs font-bold' : 'hover:text-white hover:bg-white/15' }}">
                    Blog
                </a>
            </nav>

            {{-- Right Actions: Sign In / Register / Dashboard --}}
            <div class="hidden sm:flex items-center gap-3 shrink-0">
                @auth
                    @php $user = auth()->user(); @endphp
                    <a href="{{ $user->hasRole('super-admin') ? route('admin.dashboard') : ($user->hasRole('employer') ? route('employer.dashboard') : route('seeker.dashboard')) }}"
                       class="btn btn-primary btn-sm shadow-md flex items-center gap-1.5 text-xs font-bold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Dashboard</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-400 hover:text-white hover:bg-white/10 transition-colors cursor-pointer">
                            Sign Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" 
                       class="text-xs font-bold px-2 py-1.5 text-slate-200 hover:text-white transition-colors">
                        Sign In
                    </a>

                    {{-- Register Dropdown Menu --}}
                    <div class="relative" @click.away="registerOpen = false">
                        <button @click="registerOpen = !registerOpen" 
                                type="button"
                                class="btn btn-primary btn-sm py-1.5 px-4 font-bold text-xs shadow-md flex items-center gap-1.5 cursor-pointer">
                            <span>Register</span>
                            <svg :class="registerOpen ? 'rotate-180' : ''" class="w-3.5 h-3.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="registerOpen" x-cloak class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-2xl border border-border py-2 z-50">
                            <a href="{{ route('register.seeker') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-bold text-navy hover:bg-slate-50 hover:text-secondary-600 transition-colors">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span>Job Seeker Register</span>
                            </a>
                            <a href="{{ route('register.employer') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-bold text-navy hover:bg-slate-50 hover:text-secondary-600 transition-colors">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span>Employer Register</span>
                            </a>
                        </div>
                    </div>
                @endauth
            </div>

            {{-- Mobile / Tablet Hamburger --}}
            <button 
                @click="open = !open" 
                class="xl:hidden p-2 rounded-xl transition-colors border border-white/20 text-white hover:bg-white/10 cursor-pointer" 
                aria-label="Menu"
            >
                <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                <svg x-show="open" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{-- Mobile Dropdown Menu --}}
        <div 
            x-show="open" 
            x-cloak 
            x-transition:enter="transition ease-out duration-150" 
            x-transition:enter-start="opacity-0 -translate-y-2" 
            x-transition:enter-end="opacity-100 translate-y-0" 
            x-transition:leave="transition ease-in duration-100" 
            x-transition:leave-start="opacity-100 translate-y-0" 
            x-transition:leave-end="opacity-0 -translate-y-2" 
            class="xl:hidden border-t border-white/10 bg-[#031533] text-white py-5 space-y-1 rounded-b-2xl shadow-xl"
        >
            <a href="{{ route('home') }}" class="block px-4 py-2 text-sm font-bold text-slate-200 hover:bg-white/10 rounded-xl">Home</a>
            <a href="{{ route('jobs.index') }}" class="block px-4 py-2 text-sm font-bold text-slate-200 hover:bg-white/10 rounded-xl">Find Jobs</a>
            <a href="{{ route('categories.index') }}" class="block px-4 py-2 text-sm font-bold text-slate-200 hover:bg-white/10 rounded-xl">Job Categories</a>
            <a href="{{ route('employers.public') }}" class="block px-4 py-2 text-sm font-bold text-slate-200 hover:bg-white/10 rounded-xl">Employers</a>
            <a href="{{ route('seekers.public') }}" class="block px-4 py-2 text-sm font-bold text-slate-200 hover:bg-white/10 rounded-xl">Job Seekers</a>
            <a href="{{ route('blogs.index') }}" class="block px-4 py-2 text-sm font-bold text-slate-200 hover:bg-white/10 rounded-xl">Blog</a>
            
            <div class="border-t border-white/10 pt-3 mt-3 px-4 flex flex-col gap-2">
                @auth
                    @php $user = auth()->user(); @endphp
                    <a href="{{ $user->hasRole('super-admin') ? route('admin.dashboard') : ($user->hasRole('employer') ? route('employer.dashboard') : route('seeker.dashboard')) }}" class="btn btn-primary btn-sm w-full text-center font-bold">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline btn-sm w-full text-center border-white/30 text-white font-bold">
                        Sign In
                    </a>
                    <a href="{{ route('register.seeker') }}" class="btn btn-primary btn-sm w-full text-center font-bold">
                        Create Candidate Profile
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>