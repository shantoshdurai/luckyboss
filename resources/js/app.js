import './bootstrap';
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

Alpine.plugin(intersect);

// ─── Web Audio API Notification Sound Synthesizer ──────────────
window.playLuckySound = function(soundType = 'system_alert') {
    try {
        const AudioCtx = window.AudioContext || window.webkitAudioContext;
        if (!AudioCtx) return;
        const ctx = new AudioCtx();
        if (ctx.state === 'suspended') {
            ctx.resume();
        }

        const now = ctx.currentTime;

        const playTone = (freq, startTime, duration, type = 'sine', gainVal = 0.25) => {
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type = type;
            osc.frequency.setValueAtTime(freq, startTime);
            gain.gain.setValueAtTime(gainVal, startTime);
            gain.gain.exponentialRampToValueAtTime(0.0001, startTime + duration);
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.start(startTime);
            osc.stop(startTime + duration);
        };

        switch (soundType) {
            case 'job_match':
            case 'applicant_alert':
                // Upbeat 3-note ascending chime
                playTone(523.25, now, 0.15);         // C5
                playTone(659.25, now + 0.12, 0.18);  // E5
                playTone(783.99, now + 0.24, 0.35);  // G5
                break;
            case 'interview_alert':
                // Elegant triple chime
                playTone(698.46, now, 0.14);         // F5
                playTone(880.00, now + 0.11, 0.16);  // A5
                playTone(1046.50, now + 0.22, 0.4);  // C6
                break;
            case 'offer_alert':
                // Celebration arpeggio
                playTone(523.25, now, 0.12);         // C5
                playTone(659.25, now + 0.09, 0.12);  // E5
                playTone(783.99, now + 0.18, 0.15);  // G5
                playTone(1046.50, now + 0.27, 0.45); // C6
                break;
            case 'payment_alert':
                // Dual coin register bell
                playTone(987.77, now, 0.12, 'triangle', 0.3); // B5
                playTone(1318.51, now + 0.08, 0.35, 'triangle', 0.25); // E6
                break;
            case 'application_update':
                // Soft double pulse
                playTone(587.33, now, 0.14);         // D5
                playTone(880.00, now + 0.12, 0.3);   // A5
                break;
            case 'system_alert':
            case 'approval_alert':
            default:
                // Crisp alert ping
                playTone(880.00, now, 0.1);          // A5
                playTone(1174.66, now + 0.08, 0.3);  // D6
                break;
        }
    } catch (e) {
        console.warn('Audio chime notice:', e);
    }
};

// ─── Alpine.js Real Database Notification Bell Component ───────────
Alpine.data('notificationCenter', () => ({
    open: false,
    unreadCount: 0,
    notifications: [],
    loading: false,
    async init() {
        await this.loadNotifications();
    },
    async loadNotifications() {
        try {
            const res = await fetch('/notifications/feed', {
                headers: { 'Accept': 'application/json' }
            });
            if (res.ok) {
                const data = await res.json();
                this.notifications = data.notifications || [];
                this.unreadCount = data.unreadCount || 0;
            }
        } catch (e) {
            console.warn('Live notification fetch:', e);
        }
    },
    toggle() {
        this.open = !this.open;
        if (this.open) {
            this.loadNotifications();
        }
    },
    async markAllAsRead() {
        this.unreadCount = 0;
        this.notifications.forEach(n => n.unread = false);
        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            await fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token || '',
                    'Accept': 'application/json'
                }
            });
        } catch (e) {}
    },
    playChime(type) {
        window.playLuckySound(type);
    }
}));

// ─── Alpine.js Animated Counter Component ──────────────────────
Alpine.data('counter', (target = 0, duration = 2000, suffix = '+') => ({
    display: '0' + suffix,
    target: target,
    duration: duration,
    suffix: suffix,
    hasAnimated: false,
    start() {
        if (this.hasAnimated) return;
        this.hasAnimated = true;
        
        const startTime = performance.now();
        const startVal = 0;
        const endVal = this.target;

        const update = (currentTime) => {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / this.duration, 1);
            // Ease out cubic
            const easeProgress = 1 - Math.pow(1 - progress, 3);
            const currentVal = Math.floor(startVal + (endVal - startVal) * easeProgress);
            
            this.display = currentVal.toLocaleString() + this.suffix;

            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                this.display = endVal.toLocaleString() + this.suffix;
            }
        };

        requestAnimationFrame(update);
    }
}));

// ─── AI Side Chat Assistant Component ──────────────────────────
Alpine.data('aiChat', () => ({
    open: false,
    input: '',
    loading: false,
    messages: [
        {
            sender: 'ai',
            text: 'Hello! I am Lucky AI, your intelligent recruitment copilot. How can I help your career or hiring journey today?',
            time: 'Just now',
            suggestions: [
                '🔍 Find Warehouse jobs in Singapore',
                '💼 What are top paying roles right now?',
                '📝 How can I boost my resume match score?',
                '🏢 How do employers post new jobs?'
            ]
        }
    ],
    toggle() {
        this.open = !this.open;
        if (this.open) {
            this.$nextTick(() => {
                const scrollArea = document.getElementById('ai-chat-messages');
                if (scrollArea) scrollArea.scrollTop = scrollArea.scrollHeight;
            });
        }
    },
    sendSuggestion(text) {
        this.input = text;
        this.sendMessage();
    },
    async sendMessage() {
        const query = this.input.trim();
        if (!query || this.loading) return;

        this.messages.push({
            sender: 'user',
            text: query,
            time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        });

        this.input = '';
        this.loading = true;

        this.$nextTick(() => {
            const scrollArea = document.getElementById('ai-chat-messages');
            if (scrollArea) scrollArea.scrollTop = scrollArea.scrollHeight;
        });

        try {
            const res = await fetch('/api/ai-chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ message: query })
            });

            if (res.ok) {
                const data = await res.json();
                this.messages.push({
                    sender: 'ai',
                    text: data.reply,
                    actions: data.actions || [],
                    time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                });
            } else {
                throw new Error('Fallback to local intelligence');
            }
        } catch (e) {
            // Intelligent local fallback response
            let fallbackReply = "I found matching opportunities on Lucky Boss! You can view all published vacancies across Singapore, Malaysia, and India.";
            let actions = [{ label: 'Explore All Jobs', url: '/jobs' }];

            const q = query.toLowerCase();
            if (q.includes('warehouse') || q.includes('supervisor')) {
                fallbackReply = "We have active openings for Warehouse Supervisor and Coordinator in Singapore (Jurong East & Kallang, SGD 2,800 - 4,500/mo).";
                actions = [{ label: 'View Warehouse Jobs', url: '/jobs?keyword=Warehouse' }];
            } else if (q.includes('resume') || q.includes('score')) {
                fallbackReply = "To increase your profile match score to 90%+, complete your work history, list key equipment/safety skills, and set your target location in your profile.";
                actions = [{ label: 'Create/Edit Profile', url: '/register/job-seeker' }];
            } else if (q.includes('employer') || q.includes('post') || q.includes('hire')) {
                fallbackReply = "Employers can register to post vacancies, access 50,000+ candidate profiles, and use automated AI candidate ranking.";
                actions = [{ label: 'Employer Portal', url: '/register/employer' }];
            } else if (q.includes('salary') || q.includes('paying')) {
                fallbackReply = "Top engineering and operations roles currently range from SGD 4,200 to SGD 6,500/mo with immediate shortlisting.";
                actions = [{ label: 'Search Top Salaries', url: '/jobs' }];
            }

            this.messages.push({
                sender: 'ai',
                text: fallbackReply,
                actions: actions,
                time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
            });
        } finally {
            this.loading = false;
            this.$nextTick(() => {
                const scrollArea = document.getElementById('ai-chat-messages');
                if (scrollArea) scrollArea.scrollTop = scrollArea.scrollHeight;
            });
        }
    }
}));

// ─── Alpine.js Global Utilities ───────────────────────────────
Alpine.data('dropdown', () => ({
    open: false,
    toggle() { this.open = !this.open; },
    close() { this.open = false; },
}));

Alpine.data('modal', () => ({
    show: false,
    open() { this.show = true; document.body.style.overflow = 'hidden'; },
    close() { this.show = false; document.body.style.overflow = ''; },
}));

Alpine.data('tabs', (defaultTab = '') => ({
    activeTab: defaultTab,
    switchTab(tab) { this.activeTab = tab; },
    isActive(tab) { return this.activeTab === tab; },
}));

Alpine.data('mobileMenu', () => ({
    open: false,
    toggle() { this.open = !this.open; },
}));

// ─── Start Alpine ─────────────────────────────────────────────
Alpine.start();
window.Alpine = Alpine;
