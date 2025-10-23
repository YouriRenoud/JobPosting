-- DATABASE: Job Posting Website

CREATE DATABASE IF NOT EXISTS job_posting_website;
USE job_posting_website;

DROP TABLE IF EXISTS Applications;
DROP TABLE IF EXISTS StaffActions;
DROP TABLE IF EXISTS Jobs;
DROP TABLE IF EXISTS JobCategories;
DROP TABLE IF EXISTS Employers;
DROP TABLE IF EXISTS Users;

CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff', 'employer', 'visitor') DEFAULT 'visitor',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Employers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    company_name VARCHAR(150) NOT NULL,
    logo VARCHAR(255),
    website VARCHAR(255),
    contact_email VARCHAR(150),
    contact_phone VARCHAR(50),
    description TEXT,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE JobCategories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE Jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employer_id INT NOT NULL,
    category_id INT,
    title VARCHAR(150) NOT NULL,
    location VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    requirements TEXT,
    salary DECIMAL(10,2),
    deadline DATE,
    status ENUM('pending', 'approved', 'rejected', 'inactive', 'expired') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employer_id) REFERENCES Employers(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES JobCategories(id) ON DELETE SET NULL
);

CREATE TABLE StaffActions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id INT NOT NULL,
    job_id INT NOT NULL,
    action_type ENUM('approve', 'reject', 'deactivate', 'edit') NOT NULL,
    action_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (staff_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (job_id) REFERENCES Jobs(id) ON DELETE CASCADE
);

CREATE TABLE Applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT NOT NULL,
    applicant_name VARCHAR(150) NOT NULL,
    applicant_email VARCHAR(150) NOT NULL,
    resume VARCHAR(255),
    cover_letter TEXT,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES Jobs(id) ON DELETE CASCADE
);

-- SAMPLE DATA

INSERT INTO Users (name, email, password_hash, role)
VALUES
('Admin User', 'admin@example.com', 'hashedpassword1', 'admin'),
('Staff Member', 'staff@example.com', 'hashedpassword2', 'staff');

INSERT INTO Users (name, email, password_hash, role)
VALUES
('Tech HR', 'hr@techcorp.com', 'hashedpassword3', 'employer'),
('Finance Recruiter', 'recruit@finbank.com', 'hashedpassword4', 'employer');

INSERT INTO Employers (user_id, company_name, logo, website, contact_email, contact_phone, description)
VALUES
(3, 'TechCorp', 'techcorp_logo.png', 'https://techcorp.com', 'contact@techcorp.com', '+33123456789', 'A leading software company.'),
(4, 'VPBank', 'vpbank_logo.png', 'https://vpbank.com', 'jobs@vpbank.com', '+33987654321', 'Major player in the banking sector.');

INSERT INTO JobCategories (category_name)
VALUES ('IT'), ('Finance'), ('Marketing'), ('Engineering'), ('Healthcare');

INSERT INTO Jobs (employer_id, category_id, title, location, description, requirements, salary, deadline, status)
VALUES
(1, 1, 'Software Engineer', 'Saigon', 'Develop web applications in PHP.', 'Bachelor in CS, 2+ years exp.', 45000, '2025-12-31', 'approved'),
(2, 2, 'Financial Analyst', 'Hanoi', 'Analyze financial data.', 'Finance degree, Excel skills.', 42000, '2025-11-30', 'approved'),
(1, 1, 'Frontend Developer', 'Remote', 'Work with HTML, CSS, JS.', 'Experience with React.', 48000, '2025-12-15', 'pending');

INSERT INTO StaffActions (staff_id, job_id, action_type)
VALUES
(2, 1, 'approve'),
(2, 2, 'approve');