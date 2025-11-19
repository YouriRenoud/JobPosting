# WebProgAssignment251
Web Programming Group 7 Assignment

## Project Overview
A job board application with role-based access for visitors, employers, staff, and administrators.

## Setup Instructions

### Prerequisites
- XAMPP installed

### Installation Steps

1. **Clone the Repository**
- Clone the repo into htdocs folder of XAMPP
```
git clone <repository-url>
cd WebProgAssignment251
```

2. **Database Setup**
- Upload the file script.sql in database folder to phpMyAdmin

3. **Access the Application**
- Open your browser and navigate to:
  ```
  http://localhost/WebProgAssignment251/public/index.php
  ```

### Default Login Credentials

After running the database script, you can log in with these default accounts:

- **Admin**: admin@example.com / admin123
- **Staff**: staff@example.com / staff123
- **Employers**:
  + hr@techcorp.com / techcorp
  + recruit@finbank.com / finbank
  + viettel@example.com / viettel
  + hoabinh@example.com / hoabinh
  + jobs@meditech.com / meditech

## Project Structure
```
WebProgAssignment251/
├── app/
│ ├── Controllers/
│ │ ├── JobsController.php
│ │ ├── EmployersController.php
│ │ ├── ApplicationsController.php
│ │ ├── CategoriesController.php
│ │ ├── AuthController.php
│ │ └── AdminController.php
│ │
│ ├── Models/
│ │ ├── Job.php
│ │ ├── Employer.php
│ │ ├── User.php
│ │ ├── Application.php
│ │ ├── StaffAction.php
│ │ └── Category.php
│ │
│ └── Views/
│ ├── jobs/
│ │ ├── index.php // List all jobs
│ │ ├── show.php // Show one job's details
│ │ └── apply.php // Job application form
│ │
│ ├── employers/
│ │ ├── register.php // Company profile form
│ │ ├── dashboard.php // Employer's job management
│ │ └── applications.php // View applicants for a job
│ │
│ ├── admin/
│ │ ├── moderate.php // Approve/reject pending jobs
│ │ ├── jobs.php // Manage all jobs
│ │ ├── users.php // Manage all users
│ │ └── categories.php // Manage job categories
│ │
│ └── partials/
│ ├── header.php
│ └── footer.php
│
├── config/
│ └── database.php // Database connection settings
│
├── database/
│ └── script.sql // SQL schema and seed data
│
└── public/
├── css/
│ └── global.css
├── uploads/ // Company logos and resumes
│
├── index.php // Homepage and job listings
├── login.php // User login
├── signup.php // User registration
├── logout.php // Logout handler
├── account.php // User profile management
└── applications.php // View user's job applications
```

## Features

- **Role-Based Access Control**: Admin, Staff, Employer, and Visitor roles
- **Job Management**: Create, edit, delete, and search job postings
- **Application System**: Apply for jobs with resume upload
- **Moderation Queue**: Staff can approve/reject job submissions
- **Category Management**: Organize jobs by categories
- **User Management**: Admin can manage all users
- **Company Profiles**: Employers can create company profiles with logos
