# 🌟 Lucky Boss — Global Recruitment & AI-Powered ATS Platform

An enterprise recruitment, ATS candidate pipeline, and AI matching platform connecting corporate employers across **Singapore, Malaysia, and India** with verified job seekers.

![Lucky Boss Platform](public/images/lucky-boss-logo-transparent.png)

[![Platform Status](https://img.shields.io/badge/Platform-100%25%20Operational-brightgreen)](#)
[![QA Tests](https://img.shields.io/badge/QA%20Audit-38%2F38%20Passed-success)](#)
[![AI Engine](https://img.shields.io/badge/AI%20Core-Google%20Gemini%202.5%20Flash%20%2B%20NLP-blue)](#)
[![Browser Tests](https://img.shields.io/badge/Chrome%20E2E-4%2F4%20Journeys%20Verified-blueviolet)](#)

---

## 🤖 Gemini AI Capabilities & Tested Integrations

Lucky Boss features an enterprise **Dual-Engine AI Architecture** combining **Google Gemini 2.5 Flash** with an **Offline Heuristic NLP Fallback** (100% zero-downtime guarantee):

1. **📄 Multimodal Resume Parser & Skill Extractor (`Gemini 2.5 Flash`)**:
   - Parses uploaded PDF, DOCX, and image resumes using multimodal vision OCR (`inlineData` base64 transport + pure-PHP CMap stream decoder).
   - Automatically extracts candidate names, contact details, executive bio, and matches against an 80+ skill dictionary.
2. **🤖 Lucky AI Recruitment Copilot**:
   - Real-time conversational AI assistant guiding job seekers through vacancies and employers through recruitment analytics.
3. **✨ AI Job Description Generator**:
   - Generates structured, compliant job vacancy descriptions tailored to target country labor standards (Singapore MOM, Malaysia, India).
4. **📊 Semantic AI Candidate-Job Fit Scoring**:
   - Calculates 0–100% compatibility scores between candidate competencies, experience, and employer job requirements.
5. **🛡️ Enterprise BYOAI (Bring-Your-Own-AI)**:
   - Super Admin and enterprise employers can plug in their own encrypted API keys for isolated billing.

---

## 🚀 Quick Setup Instructions (1-Minute Run)

> 💡 **For full step-by-step instructions, see [SETUP_GUIDE.md](SETUP_GUIDE.md)**

```bash
# 1. Clone repository
git clone https://github.com/shantoshdurai/luckyboss.git
cd luckyboss

# 2. Install PHP & Node dependencies
composer install
npm install

# 3. Setup Environment
cp .env.example .env
php artisan key:generate

# 4. Initialize Database (Pre-seeded with demo records)
php artisan migrate:fresh --seed

# 5. Compile Frontend Assets
npm run build

# 6. Start Server
php artisan serve --port=8000
```
Open **[http://127.0.0.1:8000](http://127.0.0.1:8000)** in your browser!

---

## 🔑 Demo Test Accounts

| Role | Email | Password | Direct Dashboard Link |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin@luckyboss.test` | `password` | [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin) |
| **Corporate Employer** | `employer@luckyboss.test` | `password` | [http://127.0.0.1:8000/employer](http://127.0.0.1:8000/employer) |
| **Job Seeker (Candidate)** | `candidate@luckyboss.test` | `password` | [http://127.0.0.1:8000/job-seeker](http://127.0.0.1:8000/job-seeker) |

---

## 🧪 Comprehensive QA & Browser Audit Verification

The platform has been audited using end-to-end automated testing and live Google Chrome browser automation:
- **Platform Routes & API Audit**: `38 / 38 Tests Passed (100% Operational)`
- **Full User Journeys Tested**:
  1. **Visitor Journey**: Homepage search, multi-country filters, registration.
  2. **Candidate Journey**: AI Resume Builder, profile editing, 1-click job application.
  3. **Employer Journey**: Posting vacancies, candidate ATS pipeline review, match %.
  4. **Super Admin Journey**: 22 management modules, notification clear-all, AI telemetry.

---

## 🛠️ Technology Stack
- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade, Tailwind CSS 3.4, Alpine.js 3.x, Vite 7
- **Database**: SQLite (`database/database.sqlite` pre-seeded)
- **AI Core**: Google Gemini 2.5 Flash / OpenAI GPT-4o Mini / Local Heuristic NLP v2
- **Testing**: PHP QA Suite & Puppeteer Google Chrome Automation
