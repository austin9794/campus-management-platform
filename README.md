# 🎓 Campus Management Platform

A full-stack web application for managing students, courses, attendance, assignments, grades, and notifications across a university campus.

## Tech Stack
- **Frontend:** HTML5, CSS3, Vanilla JS
- **Backend:** PHP 8.1+ (MVC architecture, no framework)
- **Database:** MySQL 8+ / PostgreSQL 14+
- **Auth:** Session-based with CSRF protection and role-based access

## Roles
| Role | Access |
|------|--------|
| **Admin** | Full system access, user management, analytics |
| **Faculty** | Course management, mark attendance, grade assignments |
| **Student** | View courses, submit assignments, check grades |

## Quick Start

```bash
# 1. Install PHP dependencies
composer install

# 2. Copy and configure environment
cp .env.example .env
# Edit .env with your DB credentials

# 3. Create and seed the database
mysql -u root -p < database/schemas/schema.sql
mysql -u root -p campus_db < database/seeds/seed_demo_data.sql

# 4. Start a local PHP server
php -S localhost:8000 -t public router.php
```

Then visit [http://localhost:8000](http://localhost:8000)

## Demo Credentials (after seeding)
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@campus.edu | Admin@1234 |
| Faculty | faculty@campus.edu | Faculty@1234 |
| Student | student@campus.edu | Student@1234 |

## Project Structure
```
campus-management-platform/
├── public/             # Web root (CSS, JS, entry PHP pages)
│   ├── css/
│   └── js/
├── src/
│   ├── config/         # DB, app, auth, mail settings
│   ├── controllers/    # Request handlers
│   ├── models/         # Database query wrappers
│   ├── middleware/      # Auth, CSRF, rate limiting
│   ├── helpers/        # Utilities (session, validation, pagination...)
│   ├── services/       # Business logic (auth, email, grading, reports)
│   └── api/v1/         # REST API endpoints
├── views/
│   ├── auth/           # Login, register, password reset
│   ├── student/        # Student portal pages
│   ├── faculty/        # Faculty portal pages
│   ├── admin/          # Admin dashboard pages
│   └── shared/         # Header, footer, navbar, sidebar, modals
├── database/
│   ├── migrations/     # SQL migrations (run in order)
│   ├── seeds/          # Demo/test data
│   └── schemas/        # Full schema + ERD
├── tests/
│   ├── unit/
│   └── integration/
├── uploads/            # Student file submissions & avatars
├── logs/               # Application logs
├── docs/               # API, DB, setup, architecture docs
└── .env                # Environment config (never commit)
```

## Key Features
- JWT-free session auth with CSRF tokens
- Role-based access control (admin / faculty / student)
- Normalized relational schema (3NF+)
- REST JSON API under `/api/v1/`
- Real-time-ready notification system
- Attendance tracking with analytics
- Weighted grade calculation service
- File upload for assignment submissions
- Audit log for all admin actions
- Pagination on all list endpoints

## Docs
See the `/docs/` folder:
- `SETUP.md` — Installation guide
- `DATABASE.md` — Schema + ERD explanation
- `API.md` — REST API reference
- `ARCHITECTURE.md` — Design decisions
- `DEPLOYMENT.md` — Production checklist
