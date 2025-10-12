# WebProgAssignment251
Web Programming Group 7 Assignment

## Project Structure
WebProgAssignment251/
├── app/
│   ├── Controllers/
│   │   ├── JobsController.php
│   │   ├── EmployersController.php
│   │   └── AdminController.php
│   │
│   ├── Models/
│   │   ├── Job.php
│   │   ├── Employer.php
│   │   ├── User.php
│   │   └── Category.php
│   │
│   └── Views/
│       ├── jobs/
│       │   ├── index.php         // List all jobs
│       │   └── show.php          // Show one job's details
│       │
│       ├── employers/
│       │   ├── register.php      // Registration form
│       │   └── dashboard.php     // Employer's personal dashboard
│       │
│       ├── admin/
│       │   └── moderate.php      // Page for approving/rejecting jobs
│       │
│       └── partials/
│           ├── header.php
│           └── footer.php
│
├── config/
│   └── database.php              // Your database connection settings
│
├── database/
│   └── script.sql                // The SQL file to create tables and data [cite: 113, 114]
│
└── public/
    ├── css/
    │   └── style.css
    ├── js/
    │   └── main.js
    ├── uploads/                  // For company logos [cite: 47]
    │
    ├── .htaccess                 // Rewrites all requests to index.php
    └── index.php                 // THE ONLY ENTRY POINT! The Router.