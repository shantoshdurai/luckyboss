<x-admin-layout title="{{ $record ? 'Edit Record' : 'New Record' }} | Lucky Boss Admin" heading="{{ str($module)->headline() }}">
    <div class="max-w-3xl mx-auto space-y-6">
        {{-- Top Navigation --}}
        <div>
            <a href="{{ route('admin.records.index', $module) }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-navy transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Back to {{ str($module)->headline() }}</span>
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 md:p-8">
            <h3 class="text-lg font-heading font-bold text-navy mb-1">{{ $record ? 'Edit Master Record' : 'Add New Master Record' }}</h3>
            <p class="text-xs text-slate-500 mb-6">Configure data options and metadata used by the platform.</p>

            <form method="POST" enctype="multipart/form-data" action="{{ $record ? route('admin.records.update', [$module, $record]) : route('admin.records.store', $module) }}" class="space-y-5">
                @csrf
                @if($record) @method('PUT') @endif

                {{-- Record Name --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Record Name *</label>
                    <input type="text" name="name" value="{{ old('name', $record?->name) }}" required placeholder="e.g. Remote, Information Technology, Senior Level" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-navy focus:ring-2 focus:ring-navy/10 text-xs text-slate-800 outline-none transition-all">
                    @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Description</label>
                    <textarea name="description" rows="3" placeholder="Brief description of this master record option" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-navy focus:ring-2 focus:ring-navy/10 text-xs text-slate-800 outline-none transition-all">{{ old('description', $record?->description) }}</textarea>
                    @error('description') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                @if($module === 'job-master-industries')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Sort Order</label>
                            <input type="number" name="sort_order" min="0" value="{{ old('sort_order', data_get($record?->payload, 'sort_order', 0)) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-navy focus:ring-2 focus:ring-navy/10 text-xs text-slate-800 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Icon Image</label>
                            <input type="file" name="icon_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-navy/10 file:text-navy hover:file:bg-navy/20 cursor-pointer">
                            @if(data_get($record?->payload, 'icon_image_url'))
                                <div class="mt-2 flex items-center gap-2">
                                    <img src="{{ data_get($record->payload, 'icon_image_url') }}" alt="Current Icon" class="w-10 h-10 rounded-lg object-contain border border-slate-200 p-1 bg-white">
                                    <span class="text-[11px] text-slate-400">Current active icon</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- JSON Configuration Payload --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Advanced JSON Payload (Optional)</label>
                        <span class="text-[11px] text-slate-400 font-mono">Valid JSON object</span>
                    </div>
                    <textarea name="payload" rows="4" placeholder='{"sort_order": 1, "badge_color": "emerald"}' class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-navy focus:ring-2 focus:ring-navy/10 text-xs font-mono text-slate-800 bg-slate-50/50 outline-none transition-all">{{ old('payload', $record?->payload ? json_encode($record->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '{}') }}</textarea>
                    @error('payload') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Active Toggle --}}
                <div class="flex items-center gap-3 pt-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $record?->is_active ?? true)) class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-navy"></div>
                    </label>
                    <span class="text-xs font-bold text-slate-700">Record Active & Enabled</span>
                </div>

                {{-- Form Actions --}}
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.records.index', $module) }}" class="px-5 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-xs font-semibold text-slate-600 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-navy hover:bg-navy-light text-white text-xs font-bold shadow-sm transition-all cursor-pointer">
                        {{ $record ? 'Save Changes' : 'Create Record' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>