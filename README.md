# WebProgAssignment251
Web Programming Group 7 Assignment

## Project Overview
A job board application with role-based access for visitors, employers, staff, and administrators.

## Setup Instructions

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server with mod_rewrite enabled
- Composer (optional, for future dependencies)

### Installation Steps

1. **Clone the Repository**

```
git clone <repository-url>
cd WebProgAssignment251
```


2. **Database Setup**
- Create a new MySQL database:
  ```
  CREATE DATABASE jobfinder;
  ```
- Import the database schema:
  ```
  mysql -u root -p jobfinder < database/script.sql
  ```
- Or use phpMyAdmin to import `database/script.sql`

3. **Configure Database Connection**
- Open `config/database.php`
- Update the database credentials:
  ```
  private $host = "localhost";
  private $db_name = "jobfinder";
  private $username = "root";
  private $password = "your_password";
  ```

4. **Set Up File Permissions**
- Ensure the `public/uploads/` directory is writable:
  ```
  chmod 755 public/uploads
  ```

5. **Configure Apache**
- Ensure your Apache `DocumentRoot` points to the project directory
- Enable mod_rewrite:
  ```
  a2enmod rewrite
  service apache2 restart
  ```
- Make sure `.htaccess` files are allowed in your Apache configuration

6. **Access the Application**
- Open your browser and navigate to:
  ```
  http://localhost/WebProgAssignment251/public/index.php
  ```

### Default Login Credentials

After running the database script, you can log in with these default accounts:

- **Admin**: admin@jobfinder.com / admin123
- **Staff**: staff@jobfinder.com / staff123
- **Employer**: employer@company.com / employer123
- **Visitor**: visitor@example.com / visitor123

### Troubleshooting

- **Database Connection Error**: Verify your credentials in `config/database.php`
- **File Upload Issues**: Check that `public/uploads/` has write permissions
- **404 Errors**: Ensure mod_rewrite is enabled and `.htaccess` is being read
- **Session Issues**: Verify that session.save_path is writable in your php.ini

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

## Technologies Used

- PHP 7.4+
- MySQL
- Bootstrap 5.3.3
- Font Awesome 6.5.0
- PDO for database operations
