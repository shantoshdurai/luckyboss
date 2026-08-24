<x-layouts.app title="Sign In — Lucky Boss Portal">
    <div class="min-h-[calc(100vh-72px)] flex" x-data="{ 
        fillCredentials(email, pass) {
            const emailInput = document.querySelector('input[name=email]');
            const passInput = document.querySelector('input[name=password]');
            if(emailInput) emailInput.value = email;
            if(passInput) passInput.value = pass;
        }
    }">
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
                    Don't have an account?
                    <a href="{{ route('register.seeker') }}" class="text-accent font-semibold hover:underline">Create one free</a>
                </p>

                {{-- Quick Demo Login Shortcuts --}}
                <div class="mb-6 p-4 rounded-2xl bg-surface-sunken border border-border">
                    <div class="text-xs font-bold uppercase tracking-wider text-text-muted mb-2.5">
                        ⚡ Quick Demo Sign In
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" @click="fillCredentials('admin@luckyboss.test', 'password')" class="px-2.5 py-1.5 rounded-lg bg-white border border-border text-xs font-semibold text-navy hover:border-navy transition-colors shadow-2xs">
                            👑 Admin
                        </button>
                        <button type="button" @click="fillCredentials('employer@luckyboss.test', 'password')" class="px-2.5 py-1.5 rounded-lg bg-white border border-border text-xs font-semibold text-secondary-600 hover:border-secondary-500 transition-colors shadow-2xs">
                            🏢 Employer
                        </button>
                        <button type="button" @click="fillCredentials('candidate@luckyboss.test', 'password')" class="px-2.5 py-1.5 rounded-lg bg-white border border-border text-xs font-semibold text-accent hover:border-accent transition-colors shadow-2xs">
                            👤 Candidate
                        </button>
                    </div>
                </div>

                <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                    @csrf

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

                <div class="mt-8 text-center pt-6 border-t border-border">
                    <p class="text-sm text-text-muted">
                        Are you an employer?
                        <a href="{{ route('register.employer') }}" class="text-secondary-500 font-semibold hover:underline">Register your company</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>