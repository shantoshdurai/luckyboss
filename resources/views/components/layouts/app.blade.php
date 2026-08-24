<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-[#031533]">
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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen flex flex-col bg-surface antialiased">
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

    {{-- Page Content --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <x-footer />

    {{-- Global AI Recruitment Copilot Drawer --}}
    <x-ai-chat-drawer />

    @stack('scripts')
</body>
</html>