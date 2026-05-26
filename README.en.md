# 📋 DocFlow Management System

> A web-based document workflow management system with multi-level review — built with **Laravel 12** and **MySQL**.

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

---

## 📖 About

**DocFlow Management System** is a web application designed to manage the submission, review, and approval of documents through a structured multi-level workflow within an organization. This system was built following the *Iterative Software Development* methodology based on *A Concise Introduction to Software Engineering* by Pankaj Jalote (Springer, 2008).

### Background

Manual document management — via email or paper — frequently causes delays, lost files, and a lack of status transparency. DocFlow provides a digital solution that automates the review pipeline, gives all parties full visibility into document progress, and records every activity through a comprehensive audit log.

---

## ✨ Key Features

### 👤 Multi-Role User Management
- **3 user roles:** User, Reviewer, and Admin
- Account registration with Admin approval
- Profile and work-unit management

### 📄 Document Management
- Create, save as draft, edit, and delete documents
- Upload file attachments (PDF, Word, Excel, etc.)
- Submit documents to initiate the review workflow
- View document status history at any time

### 🔄 Multi-Level Review Workflow
- Multi-level review pipeline (Level 1 → Level 2 → Admin Approval)
- Each reviewer only sees documents assigned to their level
- Reviewer actions: **Approve**, **Reject**, or **Request Revision**
- Documents are returned to the User if revision is required

### 🔔 Notifications & Audit
- Real-time notifications on every status change
- Full audit log: every action recorded with IP address and timestamp
- Review history stored in `review_logs`

### 📊 Role-Based Dashboards
- **User:** Document status, unpublished drafts, submission history
- **Reviewer:** Document queue awaiting review, deadline monitor
- **Admin:** System-wide document monitoring, user management, final archive

### 🗄️ Archive & Reports
- Approved documents are automatically moved to the archive
- Filter and search documents by status, type, and date range

---

## 🗂️ Document State Diagram

```
Draft → Submitted → Under Review (Lvl 1) → Under Review (Lvl 2) → Admin Approval → Archived
                         ↓                        ↓                      ↓
                   Revision Requested       Revision Requested        Rejected
                         ↓
                   (returned to User)
```

---

## 🗃️ Database Schema

| Table                  | Description                                        |
|------------------------|----------------------------------------------------|
| `users`                | User data (role, status, work unit)                |
| `documents`            | Main document record + status + current_level      |
| `document_attachments` | File attachments per document                      |
| `review_logs`          | History of reviewer actions per level              |
| `notifications`        | Per-user notifications                             |
| `audit_logs`           | Full system activity log                           |

---

## 🛠️ Tech Stack

| Component      | Technology               |
|----------------|--------------------------|
| Backend        | Laravel 12 (PHP 8.2+)    |
| Database       | MySQL 8.0                |
| Frontend       | Blade + Tailwind CSS     |
| Auth           | Laravel Breeze / Sanctum |
| Queue          | Laravel Queue + Supervisor |
| Scheduler      | Laravel Scheduler (Cron) |
| Testing        | PHPUnit + Laravel Dusk   |

---

## ⚙️ Installation (Local Development)

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 8.0
- Git

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/aryaxsurya/docflow-management-system.git
cd docflow-management-system

# 2. Install PHP dependencies
composer install

# 3. Install Node.js dependencies
npm install && npm run build

# 4. Copy the environment file
cp .env.example .env

# 5. Generate the application key
php artisan key:generate

# 6. Configure your database in .env
# DB_DATABASE=docflow
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 7. Run migrations and seeders
php artisan migrate
php artisan db:seed --class=AdminUserSeeder

# 8. Create the storage symlink
php artisan storage:link

# 9. Start the development server
php artisan serve
```

Access the application at: `http://localhost:8000`

### Default Accounts (Seeder)
| Role     | Email                    | Password   |
|----------|--------------------------|------------|
| Admin    | admin@docflow.test       | password   |
| Reviewer | reviewer@docflow.test    | password   |
| User     | user@docflow.test        | password   |

---

## 🚀 Deployment (Production)

```bash
# After cloning to the server
composer install --optimize-autoloader --no-dev
npm install && npm run build
cp .env.example .env
php artisan key:generate

# Edit .env: set APP_ENV=production, APP_DEBUG=false, and DB credentials

php artisan migrate --force
php artisan db:seed --class=AdminUserSeeder --force

# Cache optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link

# Set permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data .
```

---

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run a specific test
php artisan test --filter DocumentWorkflowTest

# Generate a coverage report
php artisan test --coverage
```

---

## 📁 Folder Structure

```
docflow-management-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # AuthController, DocumentController, ReviewController, AdminController
│   │   └── Requests/          # Form Request validation
│   ├── Models/                # User, Document, ReviewLog, AuditLog, etc.
│   ├── Services/              # DocumentService, ReviewService (business logic)
│   ├── Policies/              # Role-based authorization
│   └── Events/ & Listeners/   # Notifications & audit log (decoupled)
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/                 # Blade templates per role
├── routes/
│   └── web.php
└── tests/
    ├── Unit/
    └── Feature/
```

---

## 📋 Development Methodology

This project follows **8 phases of Iterative Software Development** based on the Jalote methodology:

| Phase | Activity                              | Duration      |
|-------|---------------------------------------|---------------|
| 1     | Requirement Analysis & SRS            | 3–5 days      |
| 2     | Project Planning (estimation & risk)  | 2–3 days      |
| 3     | Architecture & Database Design        | 3–4 days      |
| 4     | Environment Setup & Scaffolding       | 1–2 days      |
| 5     | Core Module Implementation            | 15–20 days    |
| 6     | Testing & Quality Assurance           | 5–7 days      |
| 7     | Deployment & Go-Live                  | 2–3 days      |
| 8     | Maintenance & Next Iteration          | Ongoing       |

**Total estimated effort: ~35–45 working days**

---

## 🤝 Contributing

This project was developed as an academic assignment. Contributions and suggestions are welcome via [Issues](https://github.com/aryaxsurya/docflow-management-system/issues).

---

## 📜 License

This project is licensed under the [MIT License](LICENSE).

---

## 👤 Author

**Arya Surya**  
GitHub: [@aryaxsurya](https://github.com/aryaxsurya)

---

> *This project was built following A Concise Introduction to Software Engineering — Pankaj Jalote (Springer, 2008)*
