<x-layouts.app title="Luckyboss Employment Agency Pte. Ltd | AI-Powered Recruitment Platform">
    {{-- ═══════════════════════════════════════════════════════════
         1. HERO — ASK, THEN ROUTE

         Rebuilt after sir shared tickbig.com. Their homepage does not open with
         a pitch; it asks the visitor what they came for and sends them there.
         That is the part worth taking, and it suits us better than it suits
         them, because Luckyboss has exactly two audiences who need completely
         different things.

         What is deliberately not copied: the near-black ground, which would
         fight a navy-and-emerald brand, and the empty stage. TickBig can afford
         a first screen with nothing on it. A jobs site cannot — the vacancies
         are the product, and they are what Google indexes.

         What went with the old hero: a 2,000px stock photograph pulled from
         unsplash.com on every page load. The most important page on the site
         depended on a third party we do not control, and it was a picture of
         nobody's warehouse.
    ═══════════════════════════════════════════════════════════════ --}}
    <section class="relative" style="background:#F7F9FC;">
        <div class="container mx-auto px-6 pt-16 pb-14 sm:pt-24 sm:pb-20 max-w-4xl text-center">

            <p class="text-xs font-bold uppercase tracking-[0.16em] mb-5" style="color:#18A66A;">
                Singapore &middot; Malaysia &middot; India
            </p>

            <h1 class="font-heading font-bold tracking-tight leading-[1.1] mb-4 text-[34px] sm:text-[46px] lg:text-[54px]" style="color:#031F49;">
                What brings you here today?
            </h1>

            <p class="text-base sm:text-lg mb-10 max-w-xl mx-auto" style="color:#5A6C82;">
                Pick one and we will take you straight to it.
            </p>

            {{-- One field, not the three-part glass console this replaced.
                 A jobs site without a search box on its front page is a worse
                 product however clean it looks, so the capability stays; only
                 the furniture around it went. --}}
            <form action="{{ route('jobs.index') }}" method="GET"
                  class="flex items-stretch gap-2 max-w-xl mx-auto mb-10">
                <label for="keyword" class="sr-only">Search jobs</label>
                <input id="keyword" name="keyword" type="search"
                       value="{{ request('keyword') }}"
                       placeholder="Job title, trade or skill"
                       class="flex-1 rounded-xl px-4 py-3.5 text-[15px] outline-none transition-all"
                       style="border:1px solid #E4EAF2;background:#fff;color:#031F49;"
                       onfocus="this.style.borderColor='#18A66A';this.style.boxShadow='0 0 0 3px rgba(24,166,106,.14)'"
                       onblur="this.style.borderColor='#E4EAF2';this.style.boxShadow='none'">
                <button type="submit"
                        class="rounded-xl px-6 font-bold text-[15px] transition-all"
                        style="background:#031F49;color:#fff;"
                        onmouseover="this.style.background='#052a63'"
                        onmouseout="this.style.background='#031F49'">
                    Search
                </button>
            </form>

            {{-- The four real doors into the product. Every one goes to a page
                 that exists; nothing here is a placeholder. --}}
            @php
                $doors = [
                    [
                        'label' => 'Find a job',
                        'note' => $stats['activeJobs'] . ' open now',
                        'href' => route('jobs.index'),
                        'icon' => 'M20.25 14.15v4.073a2.25 2.25 0 0 1-1.632 2.163l-1.32.377a12.06 12.06 0 0 1-6.596 0l-1.32-.377a2.25 2.25 0 0 1-1.632-2.163V14.15M3.75 8.25v10.5a2.25 2.25 0 0 0 2.25 2.25h12a2.25 2.25 0 0 0 2.25-2.25V8.25M3.75 8.25h16.5M9 5.25V4.5A1.5 1.5 0 0 1 10.5 3h3a1.5 1.5 0 0 1 1.5 1.5v.75',
                    ],
                    [
                        'label' => 'Hire workers',
                        'note' => 'Post a vacancy',
                        'href' => route('register.employer'),
                        'icon' => 'M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z',
                    ],
                    [
                        'label' => 'Browse by trade',
                        'note' => 'Construction, driving, care',
                        'href' => route('categories.index'),
                        'icon' => 'M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085',
                    ],
                    [
                        'label' => 'I have an account',
                        'note' => 'Sign in',
                        'href' => route('login'),
                        'icon' => 'M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-10">
                @foreach($doors as $door)
                    <a href="{{ $door['href'] }}"
                       class="group rounded-2xl px-4 py-6 sm:py-7 text-left transition-all"
                       style="background:#FFFFFF;border:1px solid #E4EAF2;box-shadow:0 1px 2px rgba(3,31,73,.04);"
                       onmouseover="this.style.borderColor='#18A66A';this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 28px -18px rgba(3,31,73,.4)'"
                       onmouseout="this.style.borderColor='#E4EAF2';this.style.transform='none';this.style.boxShadow='0 1px 2px rgba(3,31,73,.04)'">
                        <svg class="w-6 h-6 mb-3" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" style="color:#18A66A;" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $door['icon'] }}"/>
                        </svg>
                        <span class="block font-bold text-[15px] sm:text-base leading-snug" style="color:#031F49;">
                            {{ $door['label'] }}
                        </span>
                        <span class="block text-xs sm:text-[13px] mt-1" style="color:#8494A8;">
                            {{ $door['note'] }}
                        </span>
                    </a>
                @endforeach
            </div>

            {{-- Counted from the database, not written into the template. The
                 sign-in page used to advertise 5,000 jobs against a table
                 holding 14; whatever these say, they are true. --}}
            <p class="text-sm" style="color:#8494A8;">
                <strong style="color:#031F49;">{{ number_format($stats['activeJobs']) }}</strong>
                {{ Str::plural('live vacancy', $stats['activeJobs']) }}
                &middot;
                <strong style="color:#031F49;">{{ number_format($stats['employers']) }}</strong>
                verified {{ Str::plural('employer', $stats['employers']) }}
            </p>

            <a href="#browse" class="inline-flex flex-col items-center gap-1 mt-12 text-sm font-semibold" style="color:#5A6C82;">
                See the jobs
                <svg class="w-5 h-5 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </a>
        </div>
    </section>

    <span id="browse"></span>

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
                // Trade marks, drawn. Replaced a map of ten Unsplash URLs;
                // see the card below for why.
                $categoryIcons = [
                    'construction'  => 'M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085',
                    'manufacturing' => 'M42 42M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21',
                    'warehouse'     => 'M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z',
                    'healthcare'    => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z',
                    'health'        => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z',
                    'logistics'     => 'M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12',
                    'driving'       => 'M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25',
                    'hospitality'   => 'M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12.75 6.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z',
                    'domestic'      => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75',
                    'engineering'   => 'M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63',
                    'engineer'      => 'M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63',
                    'sales'         => 'M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z',
                ];

                // A trade with no mark of its own gets a generic one rather
                // than a broken image.
                $defaultIcon = 'M20.25 14.15v4.073a2.25 2.25 0 0 1-1.632 2.163l-1.32.377a12.06 12.06 0 0 1-6.596 0l-1.32-.377a2.25 2.25 0 0 1-1.632-2.163V14.15M3.75 8.25v10.5a2.25 2.25 0 0 0 2.25 2.25h12a2.25 2.25 0 0 0 2.25-2.25V8.25M3.75 8.25h16.5M9 5.25V4.5A1.5 1.5 0 0 1 10.5 3h3a1.5 1.5 0 0 1 1.5 1.5v.75';
            @endphp

            {{-- Category Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($categories as $category)
                    @php 
                        $slug = Str::slug($category->name);
                        $matchedIcon = $defaultIcon;
                        foreach($categoryIcons as $key => $ic) {
                            if(Str::contains($slug, $key) || Str::contains(strtolower($category->name), $key)) {
                                $matchedIcon = $ic;
                                break;
                            }
                        }
                        $jobCount = $category->jobs_count ?? ($category->jobs ? $category->jobs->count() : 0);
                    @endphp
                    <a href="{{ route('jobs.index', ['category' => $category->id]) }}" 
                       class="group bg-white rounded-2xl overflow-hidden border border-border hover:border-accent shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            {{-- A drawn mark, not a photograph.

                                 Each of these cards used to load a 600px stock
                                 photo from unsplash.com — ten external requests
                                 on the front page, of nobody's warehouse and
                                 nobody's building site. For candidates on a
                                 field worker's connection that is the slowest
                                 part of the page, and if Unsplash is blocked or
                                 slow the homepage looks broken.

                                 An icon in the brand's own colours always
                                 loads, weighs nothing, and is honest: a drawing
                                 does not pretend to be a photograph of our
                                 sites. When we have real photographs of real
                                 placements, those should replace these. --}}
                            <div class="h-28 w-full relative flex items-end px-5 pb-4"
                                 style="background:linear-gradient(135deg,#F2F7FF 0%,#EAF6F0 100%);border-bottom:1px solid #E4EAF2;">
                                <svg class="w-9 h-9 absolute top-4 left-5" fill="none" stroke="currentColor"
                                     stroke-width="1.5" viewBox="0 0 24 24" style="color:#18A66A;" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $matchedIcon }}"/>
                                </svg>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold"
                                      style="background:#FFFFFF;border:1px solid #E4EAF2;color:#031F49;">
                                    {{ number_format($jobCount) }} {{ Str::plural('job', $jobCount) }}
                                </span>
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
                <h2 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy mb-3">How Luckyboss Works</h2>
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
                // Was three Unsplash photographs cycled by loop index, used
                // for every article whether or not it had its own image — the
                // blogs.image column was never read. A post with a real
                // picture now shows it; one without gets a lettered tile
                // instead of a stock photo of somebody else's office.
                $editorialFallback = null;
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($blogs as $blog)
                    <article class="bg-white rounded-2xl overflow-hidden border border-border shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 group flex flex-col h-full">
                        <a href="{{ route('blogs.show', $blog->slug) }}" class="block aspect-[16/10] bg-surface-sunken relative overflow-hidden">
                            @if($blog->image)
                                <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center"
                                     style="background:linear-gradient(135deg,#F2F7FF 0%,#EAF6F0 100%);">
                                    <span class="font-heading font-bold text-4xl" style="color:#18A66A;opacity:.55;">
                                        {{ Str::upper(Str::substr($blog->category ?? $blog->title, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
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
