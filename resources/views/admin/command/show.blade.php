<x-admin-layout title="{{ $definition['title'] }} — Command Center | Lucky Boss Admin" heading="{{ $definition['title'] }}">
    <div class="space-y-6 max-w-7xl mx-auto">
        {{-- 2-Column Command Center Workspace --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            {{-- Left Column: Submenu Navigation Panel --}}
            <div class="lg:col-span-4 xl:col-span-3 bg-white rounded-2xl border border-slate-200/80 shadow-xs p-4 sticky top-20">
                <div class="px-3 py-2 border-b border-slate-100 mb-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Command Navigation</span>
                    <h3 class="text-sm font-bold text-navy">{{ $definition['title'] }}</h3>
                </div>
                <nav class="space-y-1">
                    @foreach($definition['items'] as $item)
                        @php
                            $slug = Str::slug($item);
                            $isActive = ($slug === $activeView);
                        @endphp
                        <a href="{{ route('admin.command.show', [$section, $slug]) }}"
                           @class([
                               'flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all group',
                               'bg-navy text-white font-bold shadow-xs' => $isActive,
                               'text-slate-600 hover:text-navy hover:bg-slate-50' => !$isActive,
                           ])
                        >
                            <span>{{ $item }}</span>
                            @if($isActive)
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            @else
                                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-slate-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            @endif
                        </a>
                    @endforeach
                </nav>
            </div>

            {{-- Right Column: Active Module Workspace --}}
            <div class="lg:col-span-8 xl:col-span-9 space-y-6">
                
                {{-- Module Header Banner --}}
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-navy/10 text-navy uppercase tracking-wider">{{ $definition['title'] }}</span>
                                <span class="text-slate-300">/</span>
                                <span class="text-xs text-slate-500 font-medium">{{ $moduleSummary['title'] }}</span>
                            </div>
                            <h2 class="text-xl font-heading font-bold text-navy">
                                {{ collect($definition['items'])->first(fn($item) => Str::slug($item) === $activeView) ?? str($activeView)->headline() }}
                            </h2>
                            <p class="text-xs text-slate-500 mt-1 max-w-2xl">{{ $definition['description'] }}</p>
                        </div>
                        @if($managementLink)
                            <a href="{{ $managementLink['url'] }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-navy hover:bg-navy-light text-white text-xs font-bold shadow-sm transition-all shrink-0 cursor-pointer">
                                <span>{{ $managementLink['label'] }}</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Live Operational Metrics Grid --}}
                @if(!empty($metrics))
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @foreach($metrics as $label => $value)
                            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">{{ $label }}</span>
                                <div class="mt-2 flex items-baseline justify-between">
                                    <span class="text-2xl font-bold font-heading text-navy">
                                        {{ is_numeric($value) ? (floor($value) == $value ? number_format($value) : number_format($value, 2)) : $value }}
                                    </span>
                                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">Live</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Module Summary & Controls Status --}}
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-navy">{{ $moduleSummary['title'] }}</h3>
                                <span @class([
                                    'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold',
                                    'bg-emerald-50 text-emerald-700 border border-emerald-200' => ($moduleSummary['state'] === 'Live controls' || $moduleSummary['state'] === 'Live Controls'),
                                    'bg-slate-100 text-slate-600 border border-slate-200' => ($moduleSummary['state'] !== 'Live controls' && $moduleSummary['state'] !== 'Live Controls'),
                                ])>
                                    <span class="w-1.5 h-1.5 rounded-full {{ ($moduleSummary['state'] === 'Live controls' || $moduleSummary['state'] === 'Live Controls') ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    {{ $moduleSummary['state'] }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-600 mt-2 leading-relaxed">{{ $moduleSummary['body'] }}</p>
                        </div>
                    </div>

                    {{-- Actions Launchpad --}}
                    <div class="mt-6 pt-5 border-t border-slate-100 flex flex-wrap items-center gap-3">
                        @if($managementLink)
                            <a href="{{ $managementLink['url'] }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-navy hover:text-white text-slate-700 text-xs font-bold transition-all cursor-pointer">
                                <span>Launch Management Console</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        @endif
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-semibold transition-colors">
                            ← Return to Dashboard
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>