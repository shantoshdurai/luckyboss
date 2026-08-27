# 🚀 Lucky Boss — Global Recruitment & ATS Platform
### Production Setup & Developer Onboarding Guide

---

## 📌 Project Overview
**Lucky Boss** is an enterprise multi-tenant recruitment, ATS pipeline, and candidate matching platform connecting corporate employers across **Singapore, Malaysia, and India** with verified job seekers.

* **Backend**: Laravel 12 (PHP 8.2+)
* **Frontend**: Blade Templates, Tailwind CSS 3.4, Alpine.js 3.x, Vite 7
* **Database**: SQLite (Zero database server installation required)
* **Architecture**: Super Admin Command Center, Corporate Employer ATS Portal, Job Seeker Workspace, and Public Landing Portal.

---

## 📋 System Prerequisites
Before running the project, ensure you have the following installed on your machine:
* **PHP >= 8.2** (Extensions required: `pdo_sqlite`, `mbstring`, `openssl`, `curl`, `fileinfo`, `tokenizer`)
* **Composer >= 2.2**
*(Note: Node.js/npm is NOT required! All frontend styles and JavaScript are pre-bundled and ready to serve).*

---

## ⚡ 1-Minute Quick Start

### 1. Extract / Clone the Codebase
```bash
git clone https://github.com/shantoshdurai/luckyboss.git
cd luckyboss
```
*(Or extract the provided `luckyboss-production.zip` file into your desired directory)*

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Setup Environment File
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup & Demo Seeding
The SQLite database is pre-configured. Run migrations and the seeders to populate demo accounts, jobs, and categories:
```bash
php artisan migrate:fresh --seed
```

### 5. Start the Development Server
```bash
php artisan serve --host=127.0.0.1 --port=8000
```
Open **[http://127.0.0.1:8000](http://127.0.0.1:8000)** in your browser!

---

## 🔑 Pre-Configured Test Credentials

| Role | Email | Password | Direct Dashboard Link |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin@luckyboss.test` | `password` | `http://127.0.0.1:8000/admin` |
| **Corporate Employer** | `employer@luckyboss.test` | `password` | `http://127.0.0.1:8000/employer` |
| **Job Seeker (Candidate)** | `candidate@luckyboss.test` | `password` | `http://127.0.0.1:8000/job-seeker` |

---

## 🗺️ Application Architecture & Key Endpoints

### 1. Public Portal
* **Homepage**: `/` (Displays featured Singapore SGD & India INR vacancies with zero white-flash rendering)
* **Find Jobs**: `/jobs` (Stitch 2-column layout with left filter sidebar & horizontal cards)
* **Job Categories**: `/job-categories` (11 industry sectors with live role counts)
* **For Job Seekers**: `/job-seekers` (4-step career roadmap and live salary benchmarks)
* **For Employers**: `/employers` (Enterprise recruitment tiers and BYOAI copilot preview)
* **Recruitment Blog**: `/blog`

### 2. Candidate Workspace (`/job-seeker`)
* **Dashboard Overview**: Active 4-stage application pipeline stepper (Applied &rarr; Shortlisted &rarr; Interview &rarr; Offer) with expandable cards.
* **Profile & Skills Directory**: `/job-seeker/profile` (Instant autocomplete skill engine with 200+ preloaded technical tags and clean uploader).

### 3. Corporate Employer Portal (`/employer`)
* **Employer Dashboard**: `/employer` (Active postings, new applicants, and shortlisted candidates).
* **ATS Candidate Pipeline**: `/employer/portal/candidates`
* **Interview Schedule**: `/employer/portal/interviews`
* **Offer Letters Tracker**: `/employer/portal/offers`
* **Talent Search Pool**: `/employer/portal/candidate-search`
* **Recruitment Analytics**: `/employer/portal/analytics`
* **BYOAI & Model Routing**: `/employer/portal/ai-tools`

### 4. Super Admin Command Center (`/admin`)
* **Live System Metrics**: 41 functional modules, verification queues, and audit trails.
* **Custom Master Data**: `/admin/masters/job-categories`, `/admin/masters/countries`.
* **Feature Flags**: `/admin/ai-api` (1-click platform feature toggles).

---

## 🛠️ Development & Maintenance Commands

* **Clear All Caches**:
  ```bash
  php artisan optimize:clear
  ```
* **Re-compile Tailwind / Alpine JS Bundle**:
  ```bash
  npm run build
  ```
* **Run Verification Check**:
  ```bash
  php artisan test
  ```

---

## 🔒 Security & Environment Notes
* Sensitive API keys (OpenAI / WhatsApp / BYOAI) are encrypted using Laravel `Crypt::encryptString()`.
* Session cross-role middleware automatically prevents candidate/admin access collisions with friendly session redirects.
* SQLite database file is stored at `database/database.sqlite`.

---
*Built with ❤️ for Lucky Boss Recruitment Platform.*
