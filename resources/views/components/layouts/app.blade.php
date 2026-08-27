<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Lucky Boss Portal | AI-Powered Recruitment' }}</title>
    <meta name="description" content="{{ $description ?? 'Find jobs, build your career, and manage recruitment with Lucky Boss Portal — your growth partner in hiring.' }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="{{ $title ?? 'Lucky Boss Portal' }}">
    <meta property="og:description" content="{{ $description ?? 'AI-Powered Recruitment Platform for Singapore, Malaysia, India and beyond.' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('uploads/branding/favicon-20260821075904.png') }}">

    {{-- Google Fonts: Anthropic/Claude Style Editorial Serif (Newsreader) + Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400..800;1,6..72,400..800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script defer src="{{ asset('js/app.js') }}"></script>
    @endif

    <style>
        @keyframes pageEntrance {
            0% { opacity: 0; transform: translateY(6px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .page-transition-wrap {
            animation: pageEntrance 0.22s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        #nav-loading-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, #f59e0b, #10b981, #031533);
            z-index: 99999;
            transition: width 0.3s ease, opacity 0.2s ease;
            pointer-events: none;
            opacity: 0;
        }
    </style>
    @stack('head')
</head>
<body class="min-h-screen flex flex-col bg-surface antialiased font-sans">
    {{-- Top Loading Indicator Bar --}}
    <div id="nav-loading-bar"></div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="fixed top-4 right-4 z-[100] animate-slide-down" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
            <x-ui.alert type="success" dismissible>{{ session('success') }}</x-ui.alert>
        </div>
    @endif
    @if(session('error'))
        <div class="fixed top-4 right-4 z-[100] animate-slide-down" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
            <x-ui.alert type="danger" dismissible>{{ session('error') }}</x-ui.alert>
        </div>
    @endif

    {{-- Header --}}
    <x-public-header />

    {{-- Page Content with Smooth Animated Transition --}}
    <main class="flex-1 page-transition-wrap">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <x-footer />

    {{-- Global AI Recruitment Copilot Drawer --}}
    <x-ai-chat-drawer />

    {{-- Instant Hover Preload & Transition Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bar = document.getElementById('nav-loading-bar');
            const preloaded = new Set();

            function preload(url) {
                if (!url || preloaded.has(url) || url.startsWith('#') || url.startsWith('javascript:')) return;
                try {
                    const parsed = new URL(url, window.location.origin);
                    if (parsed.origin !== window.location.origin) return;
                    preloaded.add(url);
                    const link = document.createElement('link');
                    link.rel = 'prefetch';
                    link.href = url;
                    document.head.appendChild(link);
                } catch(e) {}
            }

            document.querySelectorAll('a[href]').forEach(a => {
                const href = a.getAttribute('href');
                if (href && !href.startsWith('#') && !href.startsWith('mailto:') && !href.startsWith('tel:')) {
                    a.addEventListener('mouseenter', () => preload(href), { passive: true });
                    a.addEventListener('touchstart', () => preload(href), { passive: true });
                    a.addEventListener('click', function(e) {
                        if (e.metaKey || e.ctrlKey || e.shiftKey || a.target === '_blank') return;
                        if (bar) {
                            bar.style.opacity = '1';
                            bar.style.width = '70%';
                        }
                    });
                }
            });

            window.addEventListener('pageshow', () => {
                if (bar) {
                    bar.style.width = '100%';
                    setTimeout(() => {
                        bar.style.opacity = '0';
                        bar.style.width = '0%';
                    }, 200);
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>