<x-layouts.app title="{{ $adminLogin ?? false ? 'Administrator Sign In' : 'Sign In — Luckyboss Portal' }}">
    <div class="min-h-[calc(100vh-72px)] flex">
        {{-- Left: Brand Side --}}
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-navy via-primary-800 to-primary-900 relative overflow-hidden">
            <div class="relative z-10 flex flex-col justify-center px-12 xl:px-20 text-white">
                <span class="eyebrow text-secondary-300 mb-4 tracking-wider uppercase text-sm font-bold">Welcome back</span>
                <h1 class="text-4xl xl:text-5xl font-serif !text-white font-normal leading-tight mb-6">
                    <span class="italic text-white">Your next career</span><br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 via-teal-200 to-sky-200 font-sans font-extrabold not-italic">move starts here.</span>
                </h1>
                <p class="text-lg text-slate-300 max-w-md mb-10 leading-relaxed">
                    Sign in to access your customized dashboard, manage recruitment pipelines, and track job applications in real time.
                </p>

                {{-- Stats --}}
                <div class="flex gap-8">
                    <div>
                        <div class="text-3xl font-heading font-bold text-secondary-400">5,000+</div>
                        <div class="text-sm text-slate-400 mt-1">Active Jobs</div>
                    </div>
                    <div>
                        <div class="text-3xl font-heading font-bold text-secondary-400">2,500+</div>
                        <div class="text-sm text-slate-400 mt-1">Companies</div>
                    </div>
                    <div>
                        <div class="text-3xl font-heading font-bold text-secondary-400">50,000+</div>
                        <div class="text-sm text-slate-400 mt-1">Job Seekers</div>
                    </div>
                </div>
            </div>

            {{-- Decorative elements --}}
            <div class="absolute top-20 right-0 w-72 h-72 bg-secondary-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 left-10 w-48 h-48 bg-accent/10 rounded-full blur-2xl"></div>
        </div>

        {{-- Right: Form Side --}}
        <div class="flex-1 flex items-center justify-center px-6 py-12 bg-white">
            <div class="w-full max-w-md">
                {{-- Mobile Logo --}}
                <div class="lg:hidden text-center mb-8">
                    <a href="{{ route('home') }}" class="text-2xl font-heading font-bold">
                        <span class="text-secondary-500">Lucky</span><span class="text-navy">Boss</span>
                    </a>
                </div>

                <h2 class="text-3xl font-heading font-bold text-navy mb-2">Sign in to your account</h2>
                <p class="text-text-muted mb-6 text-base">
                    @if($adminLogin ?? false)
                        Administrator access only.
                    @else
                    Don't have an account?
                    <a href="{{ route('register.seeker') }}" class="text-accent font-semibold hover:underline">Create one free</a>
                    @endif
                </p>

                <form method="POST" action="{{ $adminLogin ?? false ? route('admin.login.store') : route('login.store') }}" class="space-y-5">
                    @csrf

                    @if(!($adminLogin ?? false))
                        @php $selectedRole = old('login_as', 'job-seeker'); @endphp

                        {{-- Inline styles: brand tokens are not in the prebuilt Tailwind bundle. --}}
                        <div x-data="{ role: '{{ $selectedRole }}' }">
                            <input type="hidden" name="login_as" :value="role">

                            <span class="block text-sm font-semibold text-text-primary mb-2">I am signing in as</span>

                            <div class="grid grid-cols-2 gap-3" role="group" aria-label="Select account type">
                                <button type="button"
                                        @click="role = 'job-seeker'"
                                        :aria-pressed="role === 'job-seeker'"
                                        :style="role === 'job-seeker'
                                            ? 'border-color:#2563eb; background:#eff6ff; color:#031f49; box-shadow:0 0 0 3px rgba(37,99,235,.18)'
                                            : 'border-color:#e2e8f0; background:#fff; color:#64748b'"
                                        class="flex items-center justify-center gap-2 rounded-xl border px-4 py-3 font-semibold text-sm transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"/>
                                    </svg>
                                    Job Seeker
                                </button>

                                <button type="button"
                                        @click="role = 'employer'"
                                        :aria-pressed="role === 'employer'"
                                        :style="role === 'employer'
                                            ? 'border-color:#18a66a; background:#ecfdf5; color:#031f49; box-shadow:0 0 0 3px rgba(24,166,106,.18)'
                                            : 'border-color:#e2e8f0; background:#fff; color:#64748b'"
                                        class="flex items-center justify-center gap-2 rounded-xl border px-4 py-3 font-semibold text-sm transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                                    </svg>
                                    Employer
                                </button>
                            </div>

                            <p class="mt-2 text-xs text-text-muted"
                               x-text="role === 'employer'
                                   ? 'Manage job postings, ATS pipelines and candidate applications.'
                                   : 'Track your applications, saved jobs and interview invitations.'"></p>
                        </div>
                    @endif

                    <x-ui.input
                        label="Email Address"
                        name="email"
                        type="email"
                        required
                        placeholder="you@example.com"
                        :value="old('email')"
                        autocomplete="email"
                    />

                    <x-ui.input
                        label="Password"
                        name="password"
                        type="password"
                        required
                        placeholder="Enter your password"
                        autocomplete="current-password"
                    />

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-border text-accent focus:ring-accent transition-colors cursor-pointer">
                            <span class="text-sm text-text-secondary group-hover:text-text-primary transition-colors">Remember me</span>
                        </label>
                        <a href="{{ Route::has('password.request') ? route('password.request') : '#' }}" class="text-sm text-accent font-medium hover:underline hover:text-accent-dark transition-colors">Forgot password?</a>
                    </div>

                    <x-ui.button type="submit" variant="primary" class="w-full" size="lg">
                        Sign In
                    </x-ui.button>
                </form>

                @if(!($adminLogin ?? false))
                <div class="mt-8 text-center pt-6 border-t border-border">
                    <p class="text-sm text-text-muted">
                        Are you an employer?
                        <a href="{{ route('register.employer') }}" class="text-secondary-500 font-semibold hover:underline">Register your company</a>
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>