# Lucky Boss — Global Recruitment & ATS Platform

A comprehensive enterprise recruitment and candidate matching application connecting corporate employers across **Singapore, Malaysia, and India** with verified job seekers.

![Lucky Boss Platform](public/images/lucky-boss-logo-transparent.png)

---

## 🚀 Quick Setup Instructions

For the complete step-by-step onboarding guide, refer to **[SETUP_GUIDE.md](SETUP_GUIDE.md)**.

```bash
# 1. Install PHP dependencies
composer install

# 2. Setup Environment
cp .env.example .env
php artisan key:generate

# 3. Migrate & Seed Database
php artisan migrate:fresh --seed

# 4. Compile Assets
npm install && npm run build

# 5. Start Server
php artisan serve --port=8000
```

---

## 🔑 Demo Login Accounts

* **Super Admin**: `admin@luckyboss.test` / `password` &rarr; [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)
* **Corporate Employer**: `employer@luckyboss.test` / `password` &rarr; [http://127.0.0.1:8000/employer](http://127.0.0.1:8000/employer)
* **Job Seeker**: `candidate@luckyboss.test` / `password` &rarr; [http://127.0.0.1:8000/job-seeker](http://127.0.0.1:8000/job-seeker)

---

## 🛠️ Tech Stack
* **Framework**: Laravel 12 (PHP 8.2+)
* **Styling & UI**: Tailwind CSS 3.4, Alpine.js 3.x
* **Build System**: Vite 7
* **Database**: SQLite (No external database server needed)
* **AI Engine**: Local NLP Heuristic Engine with BYOAI OpenAI integration support
