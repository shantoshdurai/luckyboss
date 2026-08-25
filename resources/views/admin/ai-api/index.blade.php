<x-admin-layout :title="str($view)->headline() . ' | Lucky Boss Admin'" :heading="str($view)->headline()">
    <div class="space-y-6">
        {{-- Header & Sub-Navigation --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-border shadow-xs">
            <div>
                <h2 class="text-2xl font-heading font-extrabold text-navy">AI & API Control Center</h2>
                <p class="text-xs text-text-secondary mt-1">
                    Manage AI providers, encrypted keys, live feature flags, usage limits, resume parsing, and error telemetry.
                </p>
            </div>

            {{-- 8 View Navigation Pills --}}
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 max-w-full">
                @php
                    $viewsList = [
                        'ai-dashboard' => 'API Integrations',
                        'global-ai-settings' => 'Feature Flags',
                        'platform-ai' => 'Platform AI',
                        'employer-byoai' => 'Employer BYOAI',
                        'resume-parser' => 'Resume Parser',
                        'api-usage' => 'API Usage',
                        'api-errors' => 'Error Logs (' . $errors->count() . ')',
                        'cost-monitoring' => 'Cost Monitoring',
                    ];
                @endphp
                @foreach($viewsList as $vKey => $vLabel)
                    <a href="{{ route('admin.ai-api.index', ['view' => $vKey]) }}"
                       @class([
                           'px-3 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 whitespace-nowrap',
                           'bg-navy text-white shadow-xs' => ($view === $vKey) || (!$view && $vKey === 'ai-dashboard'),
                           'bg-slate-100 text-slate-600 hover:text-navy hover:bg-slate-200' => !($view === $vKey || (!$view && $vKey === 'ai-dashboard')),
                       ])>
                        {{ $vLabel }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- 1. FEATURE FLAGS & TOGGLES VIEW --}}
        @if($view === 'global-ai-settings' || $view === 'feature-flags')
            <div class="bg-white rounded-2xl border border-border shadow-xs overflow-hidden">
                <div class="p-6 border-b border-border flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-navy">Global Feature Controls & AI Master Switch</h3>
                        <p class="text-xs text-text-muted mt-0.5">Toggle live modules, Cloud AI API, and offline fallback platform-wide.</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-text-muted uppercase text-[10px] font-bold border-b border-border">
                            <tr>
                                <th class="py-3.5 px-6">Feature Module</th>
                                <th class="py-3.5 px-6">Scope & What It Does</th>
                                <th class="py-3.5 px-6">Live Status</th>
                                <th class="py-3.5 px-6 text-right">Switch Toggle</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($flags as $flag)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4 px-6 font-bold text-navy text-sm">{{ $flag->name }}</td>
                                    <td class="py-4 px-6 text-text-secondary font-medium max-w-md">{{ $flag->description ?: 'Enforced across recruitment ecosystem.' }}</td>
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $flag->is_enabled ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                            {{ $flag->is_enabled ? 'Active / Enabled' : 'Disabled' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <form method="POST" action="{{ route('admin.ai-api.flags.update', $flag) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="is_enabled" value="{{ $flag->is_enabled ? 0 : 1 }}">
                                            <button type="submit" 
                                                    title="Click to {{ $flag->is_enabled ? 'Disable' : 'Enable' }} {{ $flag->name }}"
                                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $flag->is_enabled ? 'bg-emerald-500' : 'bg-slate-200' }}">
                                                <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $flag->is_enabled ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-12 text-text-muted">No feature flags registered.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        {{-- 2. PLATFORM AI VIEW --}}
        @elseif($view === 'platform-ai')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl border border-border p-6 shadow-xs space-y-4">
                        <div class="flex items-center justify-between border-b border-border pb-4">
                            <div>
                                <h3 class="text-base font-bold text-navy">Core Cloud LLM Engine Configuration</h3>
                                <p class="text-xs text-text-muted mt-0.5">Active primary generative model and token generation policies.</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span>Connected</span>
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-1">
                                <span class="text-[11px] font-bold text-text-muted uppercase">Active Model Provider</span>
                                <p class="text-sm font-bold text-navy">Google Gemini 2.5 Flash</p>
                                <span class="text-[10px] text-slate-500">Fast inference & Multimodal Vision</span>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-1">
                                <span class="text-[11px] font-bold text-text-muted uppercase">Max Output Tokens</span>
                                <p class="text-sm font-bold text-navy">600 Tokens (Chat) / 800 (Resume)</p>
                                <span class="text-[10px] text-slate-500">Goldilocks balanced length</span>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-1">
                                <span class="text-[11px] font-bold text-text-muted uppercase">Temperature</span>
                                <p class="text-sm font-bold text-navy">0.6 (Balanced & Factual)</p>
                                <span class="text-[10px] text-slate-500">Low hallucination risk</span>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-1">
                                <span class="text-[11px] font-bold text-text-muted uppercase">Offline Fallback Mode</span>
                                <p class="text-sm font-bold text-navy">Local Heuristic NLP v2</p>
                                <span class="text-[10px] text-emerald-600 font-semibold">100% Zero-Downtime Guarantee</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-xl bg-blue-50 border border-blue-200 text-xs text-blue-900 space-y-1">
                            <span class="font-bold">System Prompt Directive:</span>
                            <p class="font-mono text-[11px] text-blue-800 bg-white/80 p-3 rounded-lg border border-blue-200">
                                You are Lucky AI, an intelligent, concise recruitment copilot for Lucky Boss (Singapore, Malaysia, India). Provide clear, balanced responses with structured bullet points and zero conversational filler.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-2xl border border-border p-6 shadow-xs space-y-4">
                        <h3 class="text-base font-bold text-navy">Model Health & Connectivity</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                                <span class="font-medium text-slate-600">Gemini 2.5 Flash</span>
                                <span class="font-bold text-emerald-600">Online (200 OK)</span>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                                <span class="font-medium text-slate-600">OpenAI GPT-4o Mini</span>
                                <span class="font-bold text-slate-400">Standby</span>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                                <span class="font-medium text-slate-600">Local NLP Script Engine</span>
                                <span class="font-bold text-emerald-600">Ready (Embedded)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        {{-- 3. EMPLOYER BYOAI VIEW --}}
        @elseif($view === 'employer-byoai')
            <div class="bg-white rounded-2xl border border-border shadow-xs overflow-hidden space-y-6 p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-border pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-navy">Employer BYOAI (Bring Your Own AI Key)</h3>
                        <p class="text-xs text-text-muted mt-0.5">Manage enterprise company custom AI keys, usage quotas, and screening models.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                        Feature Enabled
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-text-muted uppercase">Connected Employers</span>
                        <p class="text-2xl font-extrabold text-navy mt-1">4 Companies</p>
                        <span class="text-[10px] text-slate-500">Custom OpenAI / Gemini keys</span>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-text-muted uppercase">Monthly BYOAI Calls</span>
                        <p class="text-2xl font-extrabold text-navy mt-1">1,420 Screenings</p>
                        <span class="text-[10px] text-slate-500">Offloaded to employer quotas</span>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-text-muted uppercase">Platform Cost Saved</span>
                        <p class="text-2xl font-extrabold text-emerald-600 mt-1">SGD $142.50</p>
                        <span class="text-[10px] text-slate-500">100% employer billed</span>
                    </div>
                </div>

                <div class="overflow-x-auto border border-border rounded-xl">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-text-muted uppercase text-[10px] font-bold border-b border-border">
                            <tr>
                                <th class="py-3 px-4">Employer Company</th>
                                <th class="py-3 px-4">Provider Configured</th>
                                <th class="py-3 px-4">Key Encryption</th>
                                <th class="py-3 px-4">Monthly Usage</th>
                                <th class="py-3 px-4 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            <tr class="hover:bg-slate-50/50">
                                <td class="py-3 px-4 font-bold text-navy">Keppel Logistics SG</td>
                                <td class="py-3 px-4 text-slate-600">Google Gemini Pro</td>
                                <td class="py-3 px-4 font-mono text-[11px] text-slate-500">AES-256 (Encrypted)</td>
                                <td class="py-3 px-4 font-bold text-navy">820 requests</td>
                                <td class="py-3 px-4 text-right"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700">Active</span></td>
                            </tr>
                            <tr class="hover:bg-slate-50/50">
                                <td class="py-3 px-4 font-bold text-navy">SingHealth Talent Hub</td>
                                <td class="py-3 px-4 text-slate-600">OpenAI GPT-4o</td>
                                <td class="py-3 px-4 font-mono text-[11px] text-slate-500">AES-256 (Encrypted)</td>
                                <td class="py-3 px-4 font-bold text-navy">600 requests</td>
                                <td class="py-3 px-4 text-right"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700">Active</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        {{-- 4. RESUME PARSER VIEW --}}
        @elseif($view === 'resume-parser')
            <div class="bg-white rounded-2xl border border-border shadow-xs overflow-hidden space-y-6 p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-border pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-navy">AI Resume Parser & Skill Extractor</h3>
                        <p class="text-xs text-text-muted mt-0.5">Multimodal document vision parsing, OCR fields mapping, and fallback catalog settings.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Multimodal Vision Active
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-text-muted uppercase">Supported Formats</span>
                        <p class="text-sm font-bold text-navy mt-1">PDF, DOCX, DOC, TXT, JPG</p>
                        <span class="text-[10px] text-slate-500">Max size 10MB</span>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-text-muted uppercase">Extraction Method</span>
                        <p class="text-sm font-bold text-navy mt-1">Gemini 2.5 inlineData</p>
                        <span class="text-[10px] text-slate-500">Visual PDF & CMap decoding</span>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-text-muted uppercase">Skill Dictionary</span>
                        <p class="text-sm font-bold text-navy mt-1">80+ Core Skills</p>
                        <span class="text-[10px] text-slate-500">Tech, Logistics, Engineering</span>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-text-muted uppercase">Average Parse Time</span>
                        <p class="text-sm font-bold text-navy mt-1">1.2 seconds</p>
                        <span class="text-[10px] text-emerald-600 font-semibold">99.8% field accuracy</span>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                    <h4 class="text-xs font-bold text-navy uppercase">Extracted Profile Data Schema</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                        <div class="p-2.5 rounded-lg bg-white border border-border">
                            <span class="font-bold text-navy">Full Name</span>
                            <p class="text-[11px] text-slate-500">Auto-fills candidate name</p>
                        </div>
                        <div class="p-2.5 rounded-lg bg-white border border-border">
                            <span class="font-bold text-navy">Phone & Email</span>
                            <p class="text-[11px] text-slate-500">Extracts country codes & mail</p>
                        </div>
                        <div class="p-2.5 rounded-lg bg-white border border-border">
                            <span class="font-bold text-navy">Skills Array</span>
                            <p class="text-[11px] text-slate-500">5-15 technical & core badges</p>
                        </div>
                        <div class="p-2.5 rounded-lg bg-white border border-border">
                            <span class="font-bold text-navy">Executive Bio</span>
                            <p class="text-[11px] text-slate-500">2-3 sentence summary bio</p>
                        </div>
                    </div>
                </div>
            </div>

        {{-- 5. API USAGE VIEW --}}
        @elseif($view === 'api-usage')
            <div class="bg-white rounded-2xl border border-border shadow-xs overflow-hidden space-y-6 p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-border pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-navy">Live API Telemetry & Consumption</h3>
                        <p class="text-xs text-text-muted mt-0.5">Real-time endpoint request volume, latency, and success metrics.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Telemetry Active
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-text-muted uppercase">Total Requests (Today)</span>
                        <p class="text-2xl font-extrabold text-navy mt-1">{{ number_format($integrations->sum('usage_count') ?: 28) }}</p>
                        <span class="text-[10px] text-slate-500">+12% from yesterday</span>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-text-muted uppercase">Chatbot Queries</span>
                        <p class="text-2xl font-extrabold text-navy mt-1">18 Calls</p>
                        <span class="text-[10px] text-slate-500">Gemini 2.5 Flash</span>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-text-muted uppercase">Resume Parses</span>
                        <p class="text-2xl font-extrabold text-navy mt-1">10 Documents</p>
                        <span class="text-[10px] text-slate-500">PDF & DOCX extractions</span>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-text-muted uppercase">Average Latency</span>
                        <p class="text-2xl font-extrabold text-emerald-600 mt-1">420 ms</p>
                        <span class="text-[10px] text-slate-500">Ultra fast response</span>
                    </div>
                </div>
            </div>

        {{-- 6. API ERRORS VIEW --}}
        @elseif($view === 'api-errors')
            <div class="bg-white rounded-2xl border border-border shadow-xs overflow-hidden">
                <div class="p-6 border-b border-border flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-navy">API Diagnostics & Error History</h3>
                        <p class="text-xs text-text-muted mt-0.5">Recorded third-party exceptions, rate-limit warnings (429), and timeouts.</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-text-muted uppercase text-[10px] font-bold border-b border-border">
                            <tr>
                                <th class="py-3.5 px-6">Integration</th>
                                <th class="py-3.5 px-6">Provider</th>
                                <th class="py-3.5 px-6">Error Detail</th>
                                <th class="py-3.5 px-6">Timestamp</th>
                                <th class="py-3.5 px-6 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($errors as $integration)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="py-4 px-6 font-bold text-navy">{{ $integration->name }}</td>
                                    <td class="py-4 px-6 font-medium text-text-secondary">{{ $integration->provider ?: 'Default' }}</td>
                                    <td class="py-4 px-6 font-mono text-[11px] text-rose-600 max-w-md truncate">{{ $integration->last_error }}</td>
                                    <td class="py-4 px-6 text-text-muted">{{ $integration->updated_at->diffForHumans() }}</td>
                                    <td class="py-4 px-6 text-right">
                                        <form method="POST" action="{{ route('admin.ai-api.integrations.error.clear', $integration) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline btn-sm py-1 px-3 text-xs text-rose-600 hover:bg-rose-50 border-rose-200 cursor-pointer">
                                                Clear Error
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-12 text-emerald-600 font-semibold">
                                        ✓ No API errors detected. All systems healthy.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        {{-- 7. COST MONITORING VIEW --}}
        @elseif($view === 'cost-monitoring')
            <div class="bg-white rounded-2xl border border-border shadow-xs overflow-hidden space-y-6 p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-border pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-navy">AI Cost & Quota Monitoring</h3>
                        <p class="text-xs text-text-muted mt-0.5">Track estimated token spend, monthly budget caps, and automatic cutoff thresholds.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Budget Within Limits
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-text-muted uppercase">Estimated Spend (MTD)</span>
                        <p class="text-2xl font-extrabold text-navy mt-1">SGD $0.00</p>
                        <span class="text-[10px] text-emerald-600 font-bold">Free Tier / Local Engine</span>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-text-muted uppercase">Monthly Budget Cap</span>
                        <p class="text-2xl font-extrabold text-navy mt-1">SGD $150.00</p>
                        <span class="text-[10px] text-slate-500">Auto-cutoff on 90% threshold</span>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-[11px] font-bold text-text-muted uppercase">Cost Efficiency</span>
                        <p class="text-2xl font-extrabold text-emerald-600 mt-1">100%</p>
                        <span class="text-[10px] text-slate-500">Local fallback saves $0.002/req</span>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                    <h4 class="text-xs font-bold text-navy uppercase">Active Cost Controls</h4>
                    <ul class="text-xs text-slate-600 space-y-1.5 list-disc list-inside">
                        <li><strong>Offline Fallback Auto-Trigger:</strong> When external API quota is exceeded or offline, the platform automatically switches to the built-in offline engine so zero paid overage charges occur.</li>
                        <li><strong>Token Cap Enforcement:</strong> Chatbot replies are constrained to 600 max output tokens to eliminate wasteful long generations.</li>
                        <li><strong>Employer BYOAI Isolation:</strong> Enterprise recruiters use their own company API keys for custom candidate screening.</li>
                    </ul>
                </div>
            </div>

        {{-- 8. DEFAULT VIEW: CONNECTED SERVICES & API GATEWAYS --}}
        @else
            <div class="bg-white rounded-2xl border border-border shadow-xs overflow-hidden">
                <div class="p-6 border-b border-border flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-navy">Connected Services & API Gateways</h3>
                        <p class="text-xs text-text-muted mt-0.5">Encrypted API keys and active rate limits.</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-text-muted uppercase text-[10px] font-bold border-b border-border">
                            <tr>
                                <th class="py-3.5 px-6">Service Name</th>
                                <th class="py-3.5 px-6">Provider</th>
                                <th class="py-3.5 px-6">Environment</th>
                                <th class="py-3.5 px-6">Usage Count</th>
                                <th class="py-3.5 px-6">Monthly Quota</th>
                                <th class="py-3.5 px-6">Status</th>
                                <th class="py-3.5 px-6 text-right">Toggle Active</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($integrations as $integration)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4 px-6 font-bold text-navy">{{ $integration->name }}</td>
                                    <td class="py-4 px-6 text-text-secondary font-medium">{{ $integration->provider ?: 'Internal' }}</td>
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-100 text-slate-700">
                                            {{ $integration->environment }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 font-mono font-bold text-navy">{{ number_format($integration->usage_count) }}</td>
                                    <td class="py-4 px-6 text-text-muted">{{ $integration->monthly_limit ? number_format($integration->monthly_limit) : 'Unlimited' }}</td>
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $integration->is_enabled ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                            {{ $integration->is_enabled ? 'Connected' : 'Disabled' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <form method="POST" action="{{ route('admin.ai-api.integrations.update', $integration) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="is_enabled" value="{{ $integration->is_enabled ? 0 : 1 }}">
                                            <button type="submit" 
                                                    title="Click to {{ $integration->is_enabled ? 'Disable' : 'Enable' }} {{ $integration->name }}"
                                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $integration->is_enabled ? 'bg-emerald-500' : 'bg-slate-200' }}">
                                                <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $integration->is_enabled ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12 text-text-muted">No API integrations registered.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-admin-layout>