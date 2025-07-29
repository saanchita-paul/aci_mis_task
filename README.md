# ACI MIS Task – Laravel Application

This Laravel project is built to fulfill a set of advanced requirements around data modeling, API security, background processing, package development, and performance optimization.

---

## Table of Contents

- [Requirements](#requirements)
- [Installation & Setup](#installation--setup)
- [Environment Configuration](#environment-configuration)
- [Task Breakdown](#task-breakdown)
    - [Task 1: Eloquent Relationships & Aggregation](#task-1-eloquent-relationships--aggregation)
    - [Task 2: API with Sanctum & RBAC](#task-2-api-with-sanctum--rbac)
    - [Task 3: Event-Driven Processing](#task-3-event-driven-processing)
    - [Task 4: PDF Report Package](#task-4-pdf-report-package)
    - [Task 5: DB Optimization & Telescope](#task-5-db-optimization--telescope)
- [Testing](#testing)
- [Performance Report](#performance-report)

---

## Requirements

- PHP >= 8.2
- Laravel 12
- MySQL
- Composer
- Laravel Sanctum
- Laravel Telescope

---

## Installation & Setup

1. **Clone the Repository**
   ```bash
   https://github.com/saanchita-paul/aci_mis_task.git
   cd aci_mis_task
   ```
   
2. **Install Dependencies**
```bash
composer install
```

3. **Environment Setup**

```bash
cp .env.example .env
php artisan key:generate

```
4. **Configure .env Database Fields**
```bash
DB_DATABASE=aci_mis
DB_USERNAME=root
DB_PASSWORD=yourpassword

```
5. **Run Migrations & Seeders**
```bash
php artisan migrate --seed

```
6. **Start Laravel Server**
```bash
php artisan serve

```

7. **Requires queue worker setup**

```bash
php artisan queue:work

```
---

##  Default User Credentials

Use the following account to log in and test:

| Email          | Password  | Role    |
|----------------|-----------|---------|
| user@gmail.com | password  | user    |

This user is automatically seeded using `UserSeeder` and has a default role of `user`.
---

## Environment Configuration

- Sanctum token-based auth is used for API protection.

- Telescope UI is available at: http://localhost:8000/telescope

- API base URL: http://localhost:8000/api/v1/

---

## Task Breakdown

**Task 1: Eloquent Relationships & Aggregation**

- Models: Organization, Team, Employee
- Relationships:
    - Organization hasMany Teams
    - Team belongsTo Organization
    - Team hasMany Employees
- Report:
    - Average salary per team
    - Total employees per organization
- Optimized with Eager Loading
- Used Eloquent scope

-----

**Task 2: API with Sanctum & RBAC**

- Sanctum installed for token-based auth
- API routes grouped by version: /api/v1/*
- CRUD for Organizations, Teams, Employees
- Roles: user (default) for now
- Used middleware for RBAC
- Example endpoints:
    - GET /api/v1/employees
    - GET /api/v1/organizations
    - GET /api/v1/teams

-----

**Task 3: Event-Driven Processing**

- JSON Import handled Event
- Laravel Queues used for background job
- SalaryUpdated event logs salary change
- Notification for progress tracking and error handling

-----


**Task 4: PDF Report Package**

- Custom package: aci/employee-reports
- Path-based repository: packages/Aci/EmployeeReports
- Endpoint to generate report
```bash
http://localhost:8000/employee-report/download
```
- Uses barryvdh/laravel-dompdf
- Command:
```bash
composer require aci/employee-reports:dev-main
```

-----

**Task 5: DB Optimization & Telescope**

- Indexes added on employees.start_date and employees.team_id
- Telescope installed and accessible at /telescope
- Used to inspect:
    - Slow queries
    - Query performance
    - Exceptions and logs

---

## Testing
- Feature and unit tests in tests/Feature and tests/Unit
- Run all tests:
```bash
php artisan test

```
---

## Performance Report
- Avg Query Time Before Indexing: 120ms
- Avg Query Time After Indexing: 25ms
- N+1 Queries Resolved: Yes (added `with('team.organization')`)
- Telescope Observations:
    - Query: `SELECT * FROM employees WHERE start_date >= ?`
        - Time: 22ms
        - Optimized via index on `start_date`

Conclusion: Adding indexes and eager-loading reduced total load time by ~80%.

---

### API Documentation

[Check Postman API Documentation](https://documenter.getpostman.com/view/15919922/2sB3B7PuV2)
