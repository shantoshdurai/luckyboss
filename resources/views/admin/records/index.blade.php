<x-admin-layout title="{{ str($module)->headline() }} | Lucky Boss Admin" heading="{{ str($module)->headline() }}">
    <div class="space-y-6 max-w-7xl mx-auto">
        {{-- Header & Actions --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-xl font-heading font-bold text-navy">{{ str($module)->headline() }}</h2>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-navy/10 text-navy">
                        {{ $records->count() }} {{ Str::plural('record', $records->count()) }}
                    </span>
                </div>
                <p class="text-sm text-slate-500 mt-1">Reusable platform master configuration records used across portal and mobile apps.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.records.create', $module) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-navy hover:bg-navy-light text-white text-xs font-bold shadow-sm transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    <span>Add New Record</span>
                </a>
            </div>
        </div>

        {{-- Success Notification --}}
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- Master Data Table --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 w-16 text-center">#</th>
                            @if($module === 'job-master-industries')
                                <th scope="col" class="py-3.5 px-4 w-16">Icon</th>
                            @endif
                            <th scope="col" class="py-3.5 px-4">Name</th>
                            <th scope="col" class="py-3.5 px-4">Description</th>
                            <th scope="col" class="py-3.5 px-4">Configuration Data</th>
                            <th scope="col" class="py-3.5 px-4 w-28 text-center">Status</th>
                            <th scope="col" class="py-3.5 px-4 w-32 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($records as $index => $record)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3.5 px-4 text-center font-bold text-slate-400">
                                    {{ data_get($record->payload, 'sort_order', $index + 1) }}
                                </td>

                                @if($module === 'job-master-industries')
                                    <td class="py-3.5 px-4">
                                        @if(data_get($record->payload, 'icon_image_url'))
                                            <img src="{{ data_get($record->payload, 'icon_image_url') }}" alt="{{ $record->name }}" class="w-8 h-8 rounded-lg object-contain border border-slate-200 p-1 bg-white">
                                        @else
                                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-[10px]">
                                                {{ substr($record->name, 0, 2) }}
                                            </div>
                                        @endif
                                    </td>
                                @endif

                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-navy text-sm">{{ $record->name }}</div>
                                    <div class="text-[11px] text-slate-400 font-mono">{{ $record->slug }}</div>
                                </td>

                                <td class="py-3.5 px-4 text-slate-600 max-w-xs">
                                    {{ $record->description ?: '—' }}
                                </td>

                                <td class="py-3.5 px-4">
                                    @php
                                        $payload = is_array($record->payload) ? $record->payload : [];
                                    @endphp
                                    <div class="flex flex-wrap gap-1.5 max-w-sm">
                                        @forelse($payload as $k => $v)
                                            @if($k !== 'sort_order' && $k !== 'icon_image_url')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[11px] font-mono border border-slate-200">
                                                    <strong class="text-slate-700">{{ str($k)->headline() }}:</strong>
                                                    <span>{{ is_array($v) ? json_encode($v) : Str::limit((string)$v, 25) }}</span>
                                                </span>
                                            @endif
                                        @empty
                                            <span class="text-slate-400 italic text-[11px]">Default configuration</span>
                                        @endforelse
                                    </div>
                                </td>

                                <td class="py-3.5 px-4 text-center">
                                    @if($record->is_active)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.records.edit', [$module, $record]) }}" class="px-2.5 py-1.5 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 text-xs font-semibold transition-colors cursor-pointer" title="Edit Record">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.records.destroy', [$module, $record]) }}" onsubmit="return confirm('Are you sure you want to delete this master record?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg text-rose-600 hover:bg-rose-50 text-xs font-semibold transition-colors cursor-pointer" title="Delete Record">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <div class="max-w-sm mx-auto">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                        </div>
                                        <h4 class="text-sm font-bold text-navy">No records configured yet</h4>
                                        <p class="text-xs text-slate-500 mt-1">Get started by creating your first master record for this module.</p>
                                        <a href="{{ route('admin.records.create', $module) }}" class="mt-4 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-navy text-white text-xs font-bold">
                                            + Add New Record
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>