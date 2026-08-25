<x-admin-layout title="{{ str($view)->headline() }} — {{ str($section)->headline() }} | Lucky Boss Admin" heading="{{ str($view)->headline() }}">
    <div class="space-y-6 max-w-7xl mx-auto">
        {{-- Section Breadcrumb & Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ str($section)->headline() }}</span>
                    <span class="text-slate-300">/</span>
                    <h2 class="text-xl font-heading font-bold text-navy">{{ str($view)->headline() }}</h2>
                </div>
                <p class="text-xs text-slate-500 mt-1">Live configuration, administrative controls, and system telemetry records.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Live Operational
                </span>
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

        {{-- Analytics / Metrics Grid (if present) --}}
        @if(!empty($data['metrics']))
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($data['metrics'] as $label => $value)
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">{{ str($label)->headline() }}</span>
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

        {{-- Users View --}}
        @if(isset($data['users']))
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-navy">System Administrators & Roles</h3>
                    <span class="text-xs text-slate-400">{{ count($data['users']) }} Users Configured</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                            <tr>
                                <th class="py-3.5 px-4">User</th>
                                <th class="py-3.5 px-4">Email</th>
                                <th class="py-3.5 px-4">Assigned Roles</th>
                                <th class="py-3.5 px-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @foreach($data['users'] as $user)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-3.5 px-4">
                                        <div class="font-bold text-navy">{{ $user->name }}</div>
                                        <div class="text-[10px] text-slate-400">ID #{{ $user->id }}</div>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-slate-600">{{ $user->email }}</td>
                                    <td class="py-3.5 px-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($user->roles as $role)
                                                <span class="px-2 py-0.5 rounded-md bg-navy/10 text-navy font-bold text-[11px]">{{ $role->name }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        @if($user->is_active)
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Active</span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">Blocked</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        {{-- Permissions View --}}
        @elseif(isset($data['permissions']) || (isset($data['records']) && $section === 'users-permissions'))
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-navy">Module Permissions & Access Rights</h3>
                    <span class="text-xs text-slate-400">{{ count($data['records'] ?? []) }} Definitions</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                            <tr>
                                <th class="py-3.5 px-4">Permission Name</th>
                                <th class="py-3.5 px-4">Module / Slug</th>
                                <th class="py-3.5 px-4">Description / Users</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @foreach($data['records'] ?? [] as $record)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-3.5 px-4 font-bold text-navy">{{ $record->name }}</td>
                                    <td class="py-3.5 px-4 font-mono text-slate-600">{{ $record->module ?? ($record->slug ?? '—') }}</td>
                                    <td class="py-3.5 px-4 text-slate-500">{{ $record->description ?? ($record->users_count ? "{$record->users_count} assigned users" : '—') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        {{-- Security Logs View --}}
        @elseif(isset($data['security']))
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-navy">Security & Authentication Logs</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                            <tr>
                                <th class="py-3.5 px-4">User</th>
                                <th class="py-3.5 px-4">Event</th>
                                <th class="py-3.5 px-4">IP Address</th>
                                <th class="py-3.5 px-4 text-right">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($data['security'] as $log)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-3.5 px-4 font-bold text-navy">{{ $log->user?->name ?: 'System' }}</td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2 py-0.5 rounded-md bg-slate-100 font-mono text-slate-700 border border-slate-200">{{ $log->event }}</span>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-slate-500">{{ $log->ip_address ?: '—' }}</td>
                                    <td class="py-3.5 px-4 text-right text-slate-400">{{ $log->created_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-8 text-center text-slate-400">No security logs recorded.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if(method_exists($data['security'], 'links'))
                    <div class="p-4 border-t border-slate-100">{{ $data['security']->links() }}</div>
                @endif
            </div>

        {{-- Audit Logs View --}}
        @elseif(isset($data['audit']))
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-navy">Audit Trail & Entity Changes</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                            <tr>
                                <th class="py-3.5 px-4">Action</th>
                                <th class="py-3.5 px-4">Actor</th>
                                <th class="py-3.5 px-4">Company</th>
                                <th class="py-3.5 px-4">Entity</th>
                                <th class="py-3.5 px-4 text-right">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($data['audit'] as $log)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-3.5 px-4 font-bold text-navy">{{ $log->action }}</td>
                                    <td class="py-3.5 px-4 text-slate-600">{{ $log->user?->name ?: 'System' }}</td>
                                    <td class="py-3.5 px-4 text-slate-500">{{ $log->company?->name ?: '—' }}</td>
                                    <td class="py-3.5 px-4 font-mono text-slate-500">{{ $log->entity_type ?: '—' }} #{{ $log->entity_id }}</td>
                                    <td class="py-3.5 px-4 text-right text-slate-400">{{ $log->created_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="py-8 text-center text-slate-400">No audit events recorded yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if(method_exists($data['audit'], 'links'))
                    <div class="p-4 border-t border-slate-100">{{ $data['audit']->links() }}</div>
                @endif
            </div>

        {{-- Generic Control Records View (Settings / System) --}}
        @else
            {{-- Quick Add Record Form --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
                <h3 class="text-sm font-bold text-navy mb-4">Add Control Record</h3>
                <form method="POST" action="{{ route('admin.control-center.records.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="section" value="{{ $section }}">
                    <input type="hidden" name="view" value="{{ $view }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Record Key / Name *</label>
                            <input type="text" name="name" placeholder="e.g. SEO Meta Title, Rate Limit" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-navy focus:ring-2 focus:ring-navy/10 text-xs text-slate-800 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Description</label>
                            <input type="text" name="description" placeholder="Brief description of this setting" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-navy focus:ring-2 focus:ring-navy/10 text-xs text-slate-800 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">JSON Payload / Configuration Value</label>
                        <textarea name="payload" rows="3" placeholder='{"value": "Your configuration value here", "enabled": true}' class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-navy focus:ring-2 focus:ring-navy/10 text-xs font-mono text-slate-800 bg-slate-50/50 outline-none"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-navy hover:bg-navy-light text-white text-xs font-bold shadow-sm transition-all cursor-pointer">
                            + Save Record
                        </button>
                    </div>
                </form>
            </div>

            {{-- Configured Records Table --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-navy">Active Configuration Records</h3>
                    <span class="text-xs text-slate-400">{{ count($data['records'] ?? []) }} Records</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                            <tr>
                                <th class="py-3.5 px-4 w-64">Record Name</th>
                                <th class="py-3.5 px-4">Description</th>
                                <th class="py-3.5 px-4">Configured Value / Payload</th>
                                <th class="py-3.5 px-4 text-center w-24">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($data['records'] ?? [] as $record)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-3.5 px-4 font-bold text-navy">{{ $record->name }}</td>
                                    <td class="py-3.5 px-4 text-slate-600">{{ $record->description ?: '—' }}</td>
                                    <td class="py-3.5 px-4">
                                        <code class="px-2 py-1 rounded bg-slate-100 text-slate-700 font-mono text-[11px] block max-w-md overflow-x-auto">
                                            {{ json_encode($record->payload, JSON_UNESCAPED_SLASHES) }}
                                        </code>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Active</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-slate-400">
                                        No custom records configured. Use the form above to add a new configuration record.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-admin-layout>