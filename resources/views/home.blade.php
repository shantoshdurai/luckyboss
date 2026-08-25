<x-layouts.app title="Lucky Boss Portal | Elite AI-Powered Recruitment Platform">
    {{-- ═══════════════════════════════════════════════════════════
         1. HERO SECTION: Full-Screen 100vh Majestic Command Center
    ═══════════════════════════════════════════════════════════════ --}}
    <section class="min-h-[calc(100vh-80px)] flex flex-col justify-center text-white py-12 lg:py-16 relative overflow-hidden bg-cover bg-right bg-no-repeat"
             style="background-color: #031533; background-image: linear-gradient(to right, #031533 0%, rgba(3, 21, 51, 0.95) 45%, rgba(3, 21, 51, 0.82) 65%, rgba(3, 21, 51, 0.45) 100%), url('https://images.unsplash.com/photo-1596422846543-75c6fc197f07?q=80&w=2000&auto=format&fit=crop');">
        {{-- Ambient Soft Glow --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[450px] bg-gradient-to-b from-accent/15 to-secondary-500/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10 text-center max-w-5xl">
            {{-- Thoughtful Minimalist Tag --}}
            <div class="inline-flex items-center gap-2.5 py-1 px-4 rounded-full bg-white/10 border border-white/15 text-xs font-semibold tracking-wider text-slate-300 mb-6 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-secondary-400 animate-pulse"></span>
                <span>AI-Powered Cross-Border Recruitment</span>
            </div>

            {{-- Anthropic/Claude Style Editorial Headline --}}
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-serif font-normal tracking-tight leading-[1.18] mb-5 !text-white">
                <span class="text-white block mb-1.5 italic font-serif">Find the right job.</span>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 via-teal-200 to-sky-200 not-italic font-sans font-extrabold tracking-tight">
                    Build an exceptional career.
                </span>
            </h1>

            {{-- Subheading --}}
            <p class="text-base sm:text-lg text-blue-100/80 mb-8 max-w-2xl mx-auto font-sans font-normal leading-relaxed">
                Connect directly with verified corporate employers and leading recruitment agencies across Singapore, Malaysia, and India.
            </p>

            {{-- Dark Frosted Glass Search Command Bar --}}
            <div class="bg-[#062454]/80 backdrop-blur-2xl p-2.5 sm:p-3 rounded-3xl shadow-2xl border border-white/15 max-w-4xl mx-auto text-left text-white">
                <form action="{{ route('jobs.index') }}" method="GET" class="flex flex-col md:flex-row gap-2.5">
                    {{-- Keyword Input with Suggestions --}}
                    <div class="flex-1 relative" x-data="{ term: '', suggestions: [], show: false }">
                        <div class="flex items-center pl-4 bg-white/10 rounded-2xl h-13 border border-white/15 focus-within:border-secondary-400 focus-within:ring-2 focus-within:ring-secondary-400/30 focus-within:shadow-[0_0_15px_rgba(24,166,106,0.25)] transition-all duration-200">
                            <svg class="w-5 h-5 text-blue-200/70 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input 
                                type="text" 
                                name="keyword" 
                                placeholder="Job title, skills, keyword..." 
                                class="w-full bg-transparent border-0 outline-none focus:outline-none focus-visible:outline-none focus:ring-0 text-white placeholder:text-blue-200/60 px-3 text-sm h-full"
                                x-model="term"
                                @input.debounce.300ms="
                                    if(term.length > 1) {
                                        fetch('{{ route('jobs.suggestions') }}?field=title&q=' + encodeURIComponent(term))
                                            .then(res => res.json())
                                            .then(data => { suggestions = data; show = true; });
                                    } else {
                                        show = false;
                                    }
                                "
                                @click.away="show = false"
                                autocomplete="off"
                            >
                        </div>
                        <div x-show="show && suggestions.length > 0" class="absolute top-full left-0 right-0 bg-[#031533] border border-white/20 shadow-2xl rounded-2xl mt-1.5 z-50 overflow-hidden text-white" style="display: none;">
                            <template x-for="s in suggestions" :key="s">
                                <div @click="term = s; show = false;" class="px-4 py-3 hover:bg-white/10 cursor-pointer text-slate-200 text-sm font-semibold transition-colors" x-text="s"></div>
                            </template>
                        </div>
                    </div>
                    
                    {{-- Location Input --}}
                    <div class="flex-1 relative" x-data="{ loc: '', suggestions: [], show: false }">
                        <div class="flex items-center pl-4 bg-white/10 rounded-2xl h-13 border border-white/15 focus-within:border-secondary-400 focus-within:ring-2 focus-within:ring-secondary-400/30 focus-within:shadow-[0_0_15px_rgba(24,166,106,0.25)] transition-all duration-200">
                            <svg class="w-5 h-5 text-blue-200/70 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <input 
                                type="text" 
                                name="location" 
                                placeholder="City or Country (e.g. Singapore)" 
                                class="w-full bg-transparent border-0 outline-none focus:outline-none focus-visible:outline-none focus:ring-0 text-white placeholder:text-blue-200/60 px-3 text-sm h-full"
                                x-model="loc"
                                @input.debounce.300ms="
                                    if(loc.length > 1) {
                                        fetch('{{ route('jobs.suggestions') }}?field=location&q=' + encodeURIComponent(loc))
                                            .then(res => res.json())
                                            .then(data => { suggestions = data; show = true; });
                                    } else {
                                        show = false;
                                    }
                                "
                                @click.away="show = false"
                                autocomplete="off"
                            >
                        </div>
                        <div x-show="show && suggestions.length > 0" class="absolute top-full left-0 right-0 bg-[#031533] border border-white/20 shadow-2xl rounded-2xl mt-1.5 z-50 overflow-hidden text-white" style="display: none;">
                            <template x-for="s in suggestions" :key="s">
                                <div @click="loc = s; show = false;" class="px-4 py-3 hover:bg-white/10 cursor-pointer text-slate-200 text-sm font-semibold transition-colors" x-text="s"></div>
                            </template>
                        </div>
                    </div>

                    {{-- Search Submit --}}
                    <button type="submit" class="bg-secondary-500 hover:bg-secondary-600 text-white font-bold rounded-2xl px-9 h-13 transition-all duration-200 shadow-md hover:shadow-xl flex items-center justify-center gap-2 whitespace-nowrap cursor-pointer text-sm font-sans">
                        <span>Find Jobs</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>

            {{-- Popular Searches --}}
            <div class="mt-5 flex flex-wrap items-center justify-center gap-2 text-xs text-blue-200/75 font-sans">
                <span class="font-semibold text-secondary-300">Popular Searches:</span>
                <a href="{{ route('jobs.index', ['keyword' => 'Warehouse Supervisor']) }}" class="px-3 py-1 rounded-full bg-white/5 hover:bg-white/15 text-slate-300 hover:text-white border border-white/10 transition-colors">Warehouse Supervisor</a>
                <a href="{{ route('jobs.index', ['keyword' => 'Construction Safety Officer']) }}" class="px-3 py-1 rounded-full bg-white/5 hover:bg-white/15 text-slate-300 hover:text-white border border-white/10 transition-colors">Safety Officer</a>
                <a href="{{ route('jobs.index', ['keyword' => 'Quality Engineer']) }}" class="px-3 py-1 rounded-full bg-white/5 hover:bg-white/15 text-slate-300 hover:text-white border border-white/10 transition-colors">Quality Engineer</a>
                <a href="{{ route('jobs.index', ['keyword' => 'Logistics Operations']) }}" class="px-3 py-1 rounded-full bg-white/5 hover:bg-white/15 text-slate-300 hover:text-white border border-white/10 transition-colors">Logistics Executive</a>
            </div>

            {{-- Animated Platform Numbers Bar with Outline Icons --}}
            <div class="grid grid-cols-3 divide-x divide-white/10 mt-12 pt-8 border-t border-white/10 max-w-3xl mx-auto font-sans">
                {{-- 1. Verified Jobs (Outline Briefcase) --}}
                <div class="px-4 flex flex-col items-center justify-center text-center" x-data="counter(5240, 1800)" x-intersect.once="start()">
                    <svg class="w-6 h-6 text-slate-300 mb-2 mx-auto" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                    </svg>
                    <div class="text-2xl sm:text-3xl font-heading font-extrabold text-white" x-text="display">5,240+</div>
                    <div class="text-xs text-slate-300 font-medium mt-1">Verified Jobs</div>
                </div>

                {{-- 2. Top Employers (Outline Rosette Ribbon Badge) --}}
                <div class="px-4 flex flex-col items-center justify-center text-center" x-data="counter(1450, 1800)" x-intersect.once="start()">
                    <svg class="w-6 h-6 text-slate-300 mb-2 mx-auto" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <circle cx="12" cy="8.5" r="5" stroke-linecap="round" stroke-linejoin="round" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 8.5l1.5 1.5 3-3" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 13.5L7 20.5l5-2 5 2-1.5-7" />
                    </svg>
                    <div class="text-2xl sm:text-3xl font-heading font-extrabold text-white" x-text="display">1,450+</div>
                    <div class="text-xs text-slate-300 font-medium mt-1">Top Employers</div>
                </div>

                {{-- 3. Candidate Profiles (Outline 2 Users) --}}
                <div class="px-4 flex flex-col items-center justify-center text-center" x-data="counter(45000, 2000)" x-intersect.once="start()">
                    <svg class="w-6 h-6 text-slate-300 mb-2 mx-auto" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    <div class="text-2xl sm:text-3xl font-heading font-extrabold text-white" x-text="display">45,000+</div>
                    <div class="text-xs text-slate-300 font-medium mt-1">Candidate Profiles</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         2. EXPLORE JOBS BY CATEGORY (With Real Cover Imagery)
    ═══════════════════════════════════════════════════════════════ --}}
    <section class="py-20 lg:py-28 bg-white border-t border-border" x-data="{ visible: false }" x-intersect.threshold.15="visible = true">
        <div class="container mx-auto px-6 transition-all duration-700 transform" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs font-bold uppercase tracking-widest text-secondary-600 mb-2.5 block">Industry Sectors</span>
                <h2 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy mb-3 tracking-tight">
                    Explore Jobs by <span class="text-secondary-500">Category</span>
                </h2>
                <p class="text-text-secondary text-base">
                    Discover targeted openings tailored to your industry expertise and professional background.
                </p>
            </div>

            @php
                $categoryImages = [
                    'construction' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=600&q=80',
                    'manufacturing' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=600&q=80',
                    'warehouse' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=600&q=80',
                    'healthcare' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=600&q=80',
                    'health' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=600&q=80',
                    'logistics' => 'https://images.unsplash.com/photo-1519003722824-194d4455a60c?auto=format&fit=crop&w=600&q=80',
                    'hospitality' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=600&q=80',
                    'domestic' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&w=600&q=80',
                    'engineering' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=600&q=80',
                    'engineer' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=600&q=80',
                    'sales' => 'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?auto=format&fit=crop&w=600&q=80',
                    'admin' => 'https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&w=600&q=80',
                    'security' => 'https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=600&q=80',
                ];
            @endphp

            {{-- Category Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($categories as $category)
                    @php 
                        $slug = Str::slug($category->name);
                        $matchedImage = 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=600&q=80';
                        foreach($categoryImages as $key => $img) {
                            if(Str::contains($slug, $key) || Str::contains(strtolower($category->name), $key)) {
                                $matchedImage = $img;
                                break;
                            }
                        }
                        $jobCount = $category->jobs_count ?? ($category->jobs ? $category->jobs->count() : 0);
                    @endphp
                    <a href="{{ route('jobs.index', ['category' => $category->id]) }}" 
                       class="group bg-white rounded-2xl overflow-hidden border border-border hover:border-accent shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            {{-- Cover Image --}}
                            <div class="h-40 w-full relative overflow-hidden bg-surface-sunken">
                                <img src="{{ $matchedImage }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-700 ease-out" loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>
                                <div class="absolute bottom-3 left-4 right-4 flex items-center justify-between text-white">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 backdrop-blur-md border border-white/30 text-white">
                                        {{ number_format($jobCount) }} {{ Str::plural('role', $jobCount) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Category Title & Description --}}
                            <div class="p-5">
                                <h3 class="font-heading font-bold text-lg text-navy mb-1 group-hover:text-accent transition-colors">
                                    {{ $category->name }}
                                </h3>
                                <p class="text-xs text-text-muted leading-relaxed line-clamp-2">
                                    {{ $category->description ?? 'Explore verified employment openings and competitive salaries.' }}
                                </p>
                            </div>
                        </div>

                        {{-- Footer Link --}}
                        <div class="px-5 pb-4 pt-0 flex items-center justify-between text-xs font-bold text-accent group-hover:text-navy transition-colors">
                            <span>Browse Roles</span>
                            <div class="w-6 h-6 rounded-full bg-blue-50 group-hover:bg-accent group-hover:text-white flex items-center justify-center transition-colors">
                                <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12 text-text-muted">
                        No categories found.
                    </div>
                @endforelse
            </div>

            {{-- View All CTA --}}
            <div class="text-center mt-12">
                <a href="{{ route('categories.index') }}" class="btn btn-outline btn-md px-7 shadow-xs hover:shadow-md">
                    <span>View All Categories</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         3. FEATURED OPPORTUNITIES (Rich Animated Cards with Skills & Perks)
    ═══════════════════════════════════════════════════════════════ --}}
    <section class="py-24 lg:py-32 bg-[#f8fafc] border-y border-border" x-data="{ visible: false }" x-intersect.threshold.10="visible = true">
        <div class="container mx-auto px-6 transition-all duration-700 transform" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            {{-- Section Header --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 py-1 px-3.5 rounded-full bg-secondary-50 border border-secondary-200 text-xs font-bold text-secondary-700 uppercase tracking-widest mb-3">
                        <span class="w-2 h-2 rounded-full bg-secondary-500 animate-ping"></span>
                        <span>Direct Verified Vacancies</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-heading font-extrabold text-navy tracking-tight">
                        Featured <span class="text-secondary-500">Opportunities</span>
                    </h2>
                    <p class="text-text-secondary text-base sm:text-lg mt-2 max-w-2xl">
                        Hand-picked positions from actively hiring corporate employers with verified compensation packages.
                    </p>
                </div>
                <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-md shrink-0 shadow-md hover:shadow-xl hover:scale-102 transition-all">
                    <span>Explore All 5,000+ Jobs</span>
                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

            @php
                $jobProfiles = [
                    'cloud' => [
                        'sector' => 'Cloud & DevOps Tech',
                        'icon' => '☁️',
                        'skills' => ['AWS / Cloud Arch', 'Docker & K8s', 'CI/CD Pipelines'],
                        'perk' => 'Hybrid Work + Tech Allowances',
                        'flag' => '🇮🇳 India, Bengaluru',
                    ],
                    'supply chain & logistics' => [
                        'sector' => 'Freight & Multi-Modal',
                        'icon' => '🚢',
                        'skills' => ['Logistics ERP', 'Dispatch Control', 'Vendor Operations'],
                        'perk' => 'PF + Annual Performance Bonus',
                        'flag' => '🇮🇳 India, Chennai',
                    ],
                    'civil infrastructure' => [
                        'sector' => 'Civil & Infrastructure',
                        'icon' => '🏗️',
                        'skills' => ['Site Blueprints', 'AutoCAD', 'WSH Compliance'],
                        'perk' => 'Project Bonus + Medical Cover',
                        'flag' => '🇮🇳 India, Mumbai',
                    ],
                    'warehouse supervisor' => [
                        'sector' => 'Warehouse & Logistics',
                        'icon' => '📦',
                        'skills' => ['Inventory Systems', 'Forklift Certified', 'Team Leadership'],
                        'perk' => 'Shift Allowance + Full Medical',
                        'flag' => '🇸🇬 Singapore',
                    ],
                    'warehouse coordinator' => [
                        'sector' => 'Supply Chain',
                        'icon' => '📋',
                        'skills' => ['SAP Logistics', 'Stock Auditing', 'Dispatch Control'],
                        'perk' => 'Direct Employer + AWS Bonus',
                        'flag' => '🇸🇬 Singapore, Jurong',
                    ],
                    'construction' => [
                        'sector' => 'Civil & Infrastructure',
                        'icon' => '🏗️',
                        'skills' => ['WSH Safety Coordinator', 'Site Supervision', 'Blueprint Reading'],
                        'perk' => 'Project Completion Bonus',
                        'flag' => '🇸🇬 Singapore, Kallang',
                    ],
                    'logistics' => [
                        'sector' => 'Freight & Operations',
                        'icon' => '🚢',
                        'skills' => ['Supply Chain ERP', 'Freight Forwarding', 'Vendor Management'],
                        'perk' => '5-Day Work Week + Transport',
                        'flag' => '🇸🇬 Singapore, Tuas',
                    ],
                    'manufacturing' => [
                        'sector' => 'Precision Engineering',
                        'icon' => '⚙️',
                        'skills' => ['ISO 9001 / Six Sigma', 'QA Auditing', 'Root Cause Analysis'],
                        'perk' => 'High-Tech Lab + Health Coverage',
                        'flag' => '🇲🇾 Malaysia, Shah Alam',
                    ],
                    'healthcare' => [
                        'sector' => 'Healthcare & Clinical',
                        'icon' => '🏥',
                        'skills' => ['Patient Care', 'Vital Signs', 'First Aid Certified'],
                        'perk' => 'Hospital Allowance + Training Grants',
                        'flag' => '🇸🇬 Singapore',
                    ],
                    'hospitality' => [
                        'sector' => 'Luxury Hospitality',
                        'icon' => '🏨',
                        'skills' => ['Guest Experience', 'Opera PMS', 'Operations Management'],
                        'perk' => '5-Star Hotel Privileges + Meals',
                        'flag' => '🇸🇬 Singapore, Marina Bay',
                    ],
                ];
            @endphp

            {{-- Job Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                @forelse($featuredJobs as $job)
                    @php 
                        $companyName = $job->company->name ?? 'Corporate Partner';
                        $titleLower = strtolower($job->title);
                        
                        $matchedProfile = [
                            'sector' => 'Corporate Enterprise',
                            'icon' => '💼',
                            'skills' => ['Verified Vacancy', 'Full Time', 'Growth Track'],
                            'perk' => 'Comprehensive Benefits + Bonus',
                            'flag' => $job->location ?? ($job->country_code === 'IN' ? '🇮🇳 India' : '🇸🇬 Singapore'),
                        ];

                        foreach($jobProfiles as $key => $prof) {
                            if(str_contains($titleLower, $key)) {
                                $matchedProfile = $prof;
                                break;
                            }
                        }

                        if ($job->country_code === 'IN' && !str_contains($matchedProfile['flag'], '🇮🇳')) {
                            $matchedProfile['flag'] = '🇮🇳 ' . ($job->location ?: 'India');
                        }
                    @endphp
                    <article class="group relative bg-white rounded-3xl border border-slate-200/90 hover:border-slate-300 shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-200 p-7 flex flex-col justify-between overflow-hidden">
                        {{-- Top Accent Line on Hover --}}
                        <div class="absolute top-0 left-0 right-0 h-1 bg-secondary-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>

                        <div>
                            {{-- Top Header Row: Sector Pill & Status Tags --}}
                            <div class="flex items-center justify-between gap-3 mb-5">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-surface-sunken border border-border text-navy">
                                    <span>{{ $matchedProfile['icon'] }}</span>
                                    <span>{{ $matchedProfile['sector'] }}</span>
                                </span>

                                <div class="flex items-center gap-1.5 shrink-0">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        <span>Active</span>
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ Str::headline($job->work_mode ?? 'On-site') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Role Title (Crisp Navy Text, No Electric Blue) --}}
                            <h3 class="font-heading font-extrabold text-xl sm:text-2xl text-navy group-hover:text-secondary-600 transition-colors line-clamp-1 mb-2">
                                <a href="{{ route('jobs.index', ['keyword' => $job->title]) }}" class="hover:underline">{{ $job->title }}</a>
                            </h3>

                            {{-- Verified Company & Location --}}
                            <div class="flex items-center gap-2 text-sm font-semibold text-text-secondary mb-4">
                                <span class="truncate text-navy font-bold">{{ $companyName }}</span>
                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <span>•</span>
                                <span class="text-xs text-text-muted font-medium truncate">{{ $matchedProfile['flag'] }}</span>
                            </div>

                            {{-- Skill Tag Pills --}}
                            <div class="flex flex-wrap gap-1.5 mb-5">
                                @foreach($matchedProfile['skills'] as $skill)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-[#f8fafc] text-slate-700 border border-slate-200 group-hover:bg-slate-100 transition-colors">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>

                            {{-- Key Role Perk --}}
                            <div class="flex items-center gap-2 py-2 px-3 rounded-xl bg-surface-sunken text-xs text-text-secondary font-medium mb-6">
                                <svg class="w-4 h-4 text-secondary-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span class="truncate">{{ $matchedProfile['perk'] }}</span>
                            </div>
                        </div>

                        {{-- Card Footer: Compensation & Interactive CTA --}}
                        <div class="pt-5 border-t border-border flex items-center justify-between gap-3">
                            <div>
                                <span class="text-[10px] font-bold text-text-muted uppercase tracking-wider block">Monthly Compensation</span>
                                <span class="text-lg font-black text-secondary-600 font-heading">
                                    {{ $job->currency_code === 'INR' ? '₹' : $job->currency_code }} 
                                    @if($job->salary_min && $job->salary_max)
                                        {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}
                                    @elseif($job->salary_min)
                                        {{ number_format($job->salary_min) }}+
                                    @else
                                        Negotiable
                                    @endif
                                </span>
                            </div>

                            @if(in_array($job->id, $appliedJobIds ?? [], true))
                                <a href="{{ route('seeker.dashboard', ['tab' => 'applications']) }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-300 text-xs font-bold shadow-xs hover:bg-emerald-100 transition-all">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Applied</span>
                                </a>
                            @else
                                <a href="{{ route('jobs.index', ['keyword' => $job->title]) }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-navy hover:bg-slate-800 text-white text-xs font-bold shadow-xs hover:shadow-md transition-all">
                                    <span>Apply Now</span>
                                    <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-16 text-text-muted">
                        No featured jobs found.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         4. SIMPLE 3-STEP PROCESS
    ═══════════════════════════════════════════════════════════════ --}}
    <section class="py-20 lg:py-28 bg-white" x-data="{ visible: false, tab: 'seekers' }" x-intersect.threshold.15="visible = true">
        <div class="container mx-auto px-6 transition-all duration-700 transform" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-xs font-bold uppercase tracking-widest text-secondary-600 mb-2 block">Process Workflow</span>
                <h2 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy mb-3">How Lucky Boss Works</h2>
                <p class="text-text-secondary text-base">Designed for maximum speed, accuracy, and transparent communication.</p>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="flex justify-center mb-12">
                    <div class="inline-flex bg-surface-sunken rounded-2xl p-1.5 border border-border shadow-inner">
                        <button @click="tab = 'seekers'" :class="tab === 'seekers' ? 'bg-navy text-white shadow-md' : 'text-text-secondary hover:text-text-primary'" class="px-7 py-2.5 rounded-xl font-bold text-sm transition-all cursor-pointer">
                            For Job Seekers
                        </button>
                        <button @click="tab = 'employers'" :class="tab === 'employers' ? 'bg-navy text-white shadow-md' : 'text-text-secondary hover:text-text-primary'" class="px-7 py-2.5 rounded-xl font-bold text-sm transition-all cursor-pointer">
                            For Employers
                        </button>
                    </div>
                </div>

                {{-- Seekers Flow --}}
                <div x-show="tab === 'seekers'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="grid md:grid-cols-3 gap-6">
                    <div class="bg-surface-sunken p-7 rounded-2xl border border-border text-center relative pt-10 shadow-xs">
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-secondary-500 text-white flex items-center justify-center font-bold text-sm shadow-md border-2 border-white">1</div>
                        <div class="w-14 h-14 mx-auto bg-blue-50 text-accent rounded-xl flex items-center justify-center mb-5">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="text-lg font-heading font-bold text-navy mb-2">Create Profile</h3>
                        <p class="text-text-secondary text-xs leading-relaxed">Sign up and build your verified profile highlighting key certifications and experience.</p>
                    </div>
                    <div class="bg-surface-sunken p-7 rounded-2xl border border-border text-center relative pt-10 shadow-xs">
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-secondary-500 text-white flex items-center justify-center font-bold text-sm shadow-md border-2 border-white">2</div>
                        <div class="w-14 h-14 mx-auto bg-blue-50 text-accent rounded-xl flex items-center justify-center mb-5">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-lg font-heading font-bold text-navy mb-2">AI Smart Match</h3>
                        <p class="text-text-secondary text-xs leading-relaxed">Our AI ranking engine scores your profile against direct employer requirements.</p>
                    </div>
                    <div class="bg-surface-sunken p-7 rounded-2xl border border-border text-center relative pt-10 shadow-xs">
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-secondary-500 text-white flex items-center justify-center font-bold text-sm shadow-md border-2 border-white">3</div>
                        <div class="w-14 h-14 mx-auto bg-blue-50 text-accent rounded-xl flex items-center justify-center mb-5">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-heading font-bold text-navy mb-2">Apply & Get Hired</h3>
                        <p class="text-text-secondary text-xs leading-relaxed">Apply with one click, receive interview invites, and track job offers in real time.</p>
                    </div>
                </div>

                {{-- Employers Flow --}}
                <div x-show="tab === 'employers'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="grid md:grid-cols-3 gap-6">
                    <div class="bg-surface-sunken p-7 rounded-2xl border border-border text-center relative pt-10 shadow-xs">
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-navy text-white flex items-center justify-center font-bold text-sm shadow-md border-2 border-white">1</div>
                        <div class="w-14 h-14 mx-auto bg-blue-50 text-accent rounded-xl flex items-center justify-center mb-5">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-lg font-heading font-bold text-navy mb-2">Register Company</h3>
                        <p class="text-text-secondary text-xs leading-relaxed">Setup your corporate hiring profile and verify your organization in under 2 minutes.</p>
                    </div>
                    <div class="bg-surface-sunken p-7 rounded-2xl border border-border text-center relative pt-10 shadow-xs">
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-navy text-white flex items-center justify-center font-bold text-sm shadow-md border-2 border-white">2</div>
                        <div class="w-14 h-14 mx-auto bg-blue-50 text-accent rounded-xl flex items-center justify-center mb-5">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <h3 class="text-lg font-heading font-bold text-navy mb-2">Publish Roles</h3>
                        <p class="text-text-secondary text-xs leading-relaxed">Post open vacancies with customized skill rubrics to attract targeted applicants.</p>
                    </div>
                    <div class="bg-surface-sunken p-7 rounded-2xl border border-border text-center relative pt-10 shadow-xs">
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-navy text-white flex items-center justify-center font-bold text-sm shadow-md border-2 border-white">3</div>
                        <div class="w-14 h-14 mx-auto bg-blue-50 text-accent rounded-xl flex items-center justify-center mb-5">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-heading font-bold text-navy mb-2">Interview & Offer</h3>
                        <p class="text-text-secondary text-xs leading-relaxed">Review AI-ranked candidates, schedule video meetings, and issue offers.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         5. RECRUITMENT INTELLIGENCE & BLOG
    ═══════════════════════════════════════════════════════════════ --}}
    @if(isset($blogs) && $blogs->count() > 0)
    <section class="py-20 lg:py-28 bg-[#f8fafc] border-y border-border" x-data="{ visible: false }" x-intersect.threshold.15="visible = true">
        <div class="container mx-auto px-6 transition-all duration-700 transform" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-5">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-secondary-600 mb-2 block">Career Insights</span>
                    <h2 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy tracking-tight">
                        Career <span class="text-secondary-500">Knowledge</span>
                    </h2>
                    <p class="text-text-secondary text-base mt-1">Expert insights, advice, and trends in regional job recruitment.</p>
                </div>
                <a href="{{ route('blogs.index') }}" class="btn btn-outline btn-md shrink-0">View All Articles</a>
            </div>

            @php
                $editorialImages = [
                    'https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1578575437130-527eed3abbec?w=800&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=800&auto=format&fit=crop&q=80',
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($blogs as $blog)
                    @php $imgUrl = $editorialImages[$loop->index % count($editorialImages)]; @endphp
                    <article class="bg-white rounded-2xl overflow-hidden border border-border shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 group flex flex-col h-full">
                        <a href="{{ route('blogs.show', $blog->slug) }}" class="block aspect-[16/10] bg-surface-sunken relative overflow-hidden">
                            <img src="{{ $imgUrl }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/95 backdrop-blur-md text-navy px-3 py-1 rounded-full text-xs font-bold shadow-xs">
                                    {{ $blog->category ?? 'Career' }}
                                </span>
                            </div>
                        </a>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="text-xs text-text-muted mb-2.5 flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $blog->published_at ? $blog->published_at->format('M d, Y') : now()->format('M d, Y') }}
                                </div>
                                <h3 class="text-lg font-heading font-bold text-navy mb-2 group-hover:text-accent transition-colors leading-snug">
                                    <a href="{{ route('blogs.show', $blog->slug) }}">{{ $blog->title }}</a>
                                </h3>
                                <p class="text-text-secondary text-xs mb-5 line-clamp-3 leading-relaxed">
                                    {{ $blog->short_description ?? Str::limit(strip_tags($blog->content), 120) }}
                                </p>
                            </div>
                            <a href="{{ route('blogs.show', $blog->slug) }}" class="inline-flex items-center text-accent font-bold text-xs hover:text-navy group/link pt-3 border-t border-border">
                                <span>Read Full Guide</span> 
                                <svg class="w-3.5 h-3.5 ml-1.5 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════════════════════════════════════════════════════
         6. DUAL CALL-TO-ACTION BANNER
    ═══════════════════════════════════════════════════════════════ --}}
    <section class="py-20 lg:py-28 bg-white" x-data="{ visible: false }" x-intersect.threshold.15="visible = true">
        <div class="container mx-auto px-6 transition-all duration-700 transform" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <div class="bg-gradient-to-r from-[#031533] via-[#062454] to-[#031533] rounded-3xl p-8 md:p-14 shadow-2xl overflow-hidden relative text-white">
                <div class="absolute top-0 right-0 w-80 h-80 bg-secondary-500/15 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
                
                <div class="relative z-10 grid md:grid-cols-2 gap-10 divide-y md:divide-y-0 md:divide-x divide-white/15">
                    <div class="text-center md:text-left md:pr-8">
                        <span class="text-xs font-bold uppercase tracking-widest text-secondary-300 block mb-2 font-sans">Job Seekers</span>
                        <h2 class="text-2xl sm:text-3xl font-heading font-extrabold mb-3">Looking For Your Next Role?</h2>
                        <p class="text-blue-100/90 mb-7 text-sm leading-relaxed">Create your free profile to get discovered by verified employers and apply to open jobs with one click.</p>
                        <a href="{{ route('register.seeker') }}" class="btn bg-white text-navy hover:bg-surface font-bold border-0 px-8 py-3 text-sm shadow-lg hover:shadow-xl">
                            Start Free Job Search
                        </a>
                    </div>
                    <div class="text-center md:text-left pt-8 md:pt-0 md:pl-10">
                        <span class="text-xs font-bold uppercase tracking-widest text-secondary-300 block mb-2 font-sans">Corporate Employers</span>
                        <h2 class="text-2xl sm:text-3xl font-heading font-extrabold mb-3">Hiring Quality Talent?</h2>
                        <p class="text-blue-100/90 mb-7 text-sm leading-relaxed">Publish vacancies, review AI-scored candidate profiles, and build your team faster across the region.</p>
                        <a href="{{ route('register.employer') }}" class="btn bg-secondary-500 hover:bg-secondary-600 text-white font-bold border-0 px-8 py-3 text-sm shadow-lg hover:shadow-xl">
                            Post Jobs & Find Talent
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
