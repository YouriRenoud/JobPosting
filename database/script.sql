-- DATABASE: Job Posting Website

CREATE DATABASE IF NOT EXISTS job_posting_website;
USE job_posting_website;

DROP TABLE IF EXISTS Notifications;
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

CREATE TABLE Notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employer_id INT NOT NULL,
    job_title VARCHAR(150) NOT NULL,
    job_description TEXT NOT NULL,
    message VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employer_id) REFERENCES Employers(id) ON DELETE CASCADE
);

-- SAMPLE DATA

INSERT INTO Users (name, email, password_hash, role, created_at)
VALUES
('Admin User', 'admin@example.com', '$2y$10$zF8KEh1UmOMPudLKPF6Eq.cUZ8ZPrj84dPIrfSBL8SSCSnf1VxFHu', 'admin', '2025-10-25 08:15:42'),
('Staff Member', 'staff@example.com', '$2y$10$x37/096J0T.uTTvpIXz0tO7bMlK0VZvYbnmvkMg.nJdSvhk6/SsAO', 'staff', '2025-10-25 08:15:42'),
('Quan', 'quan@gmail.com', '$2y$10$QgqQyVgFYWC6JEUyrH11uuWaKW.5zDfn1Q1GXTp6.3L6Dx7KbME5W', 'visitor', '2025-10-25 08:25:37');

INSERT INTO Users (name, email, password_hash, role, created_at)
VALUES
('Tech HR', 'hr@techcorp.com', '$2y$10$XmSnHpEUG3zlYnsALBbdoOVuumLNBnTGr3uCH3eT.nJ1SCnU0bO.S', 'employer', '2025-10-25 08:15:42'),
('Finance Recruiter', 'recruit@finbank.com', '$2y$10$KPkXX5loSnZ.QrRv1TMUGuO7JkyhahUkkD6HzSung9HD5twNaKday', 'employer', '2025-10-25 08:15:42'),
('Viettel HR', 'viettel@example.com', '$2y$10$9L/2eCu6Z.neqSE66FrGSedLDuSROYsc.gzvUHsEAvH3zWCTgku.S', 'employer', '2025-10-25 08:15:42'),
('Hoa Binh Construction', 'hoabinh@example.com', '$2y$10$eQmwrK6dGwpuzA6CehADfOXsflLMmTC9kZLkspKglInjRssT3IqN.', 'employer', '2025-10-25 08:15:42'),
('Meditech HR', 'jobs@meditech.com', '$2y$10$lthY8gg4A3X.hFuhSPVt4uqEKuKKAjbck3xmhW1LlVPz7.Pl50kyW', 'employer', '2025-10-25 08:15:42'),
('Vingroup HR', 'hr@vingroup.net', '$2y$10$3lMWIeAjOON6g2ieRfatWe3xlejKByslYJKhsJYS9iU7PBFq9QHKe', 'employer', '2025-11-14 23:47:32'),
('FPT Software Recruiter', 'recruitment@fpt.software', '$2y$10$2hYIuTiknm4gZJFfoRUYBuzcXt7bL/N8W9GpSKR/bY9IIVioW8hKm', 'employer', '2025-11-14 23:48:10'),
('Vinamilk HR', 'hr@vinamilk.com.vn', '$2y$10$VyJ7rMbIFNaOgdtHEh9g1OguISliDdEE1TejZWQ7JeLHHS4uOwh/e', 'employer', '2025-11-14 23:48:38'),
('Massey University HR', 'hr@massey.ac.nz', '$2y$10$YaBS1a.9SJQpTN/j.6U6CuwQFvE9VtM/eYgJ7BhgsrMRHvvhGpA16', 'employer', '2025-11-14 23:49:03'),
('Amazon Web Services Recruiter', 'aws.recruiting@amazon.com', '$2y$10$OosKlQmQ7yf8TYsuR.roF.rcRJemaZjplORtBQLx4u0OJzKUbfYPK', 'employer', '2025-11-14 23:49:23');

INSERT INTO Employers (user_id, company_name, logo, website, contact_email, contact_phone, description)
VALUES
(4, 'TechCorp', 'techcorp_logo.png', 'https://techcorp.com', 'contact@techcorp.com', '+33123456789', 'A leading software company.'),
(5, 'FinBank', 'finbank_logo.png', 'https://finbank.com', 'jobs@finbank.com', '+33987654321', 'A trusted name in banking and finance.'),
(6, 'Viettel', 'viettel_logo.png', 'https://viettel.com.vn', 'contact@viettel.com', '+84888888888', 'Telecommunications and digital transformation leader.'),
(7, 'Hoa Binh Construction Group', 'hoabinh_logo.png', 'https://hoabinh.com.vn', 'hr@hoabinh.com', '+84999999999', 'Top construction and engineering firm.'),
(8, 'MediTech Solutions', 'meditech_logo.png', 'https://meditech.com', 'contact@meditech.com', '+33765432109', 'Healthcare technology and medical software company.'),
(10, 'FPT Software', 'fpt_logo.png', 'https://fpt-software.com', 'contact@fpt-software.com', '+842437689048', 'A global IT services and solutions provider headquartered in Vietnam.'),
(11, 'Vinamilk', 'vinamilk_logo.png', 'https://www.vinamilk.com.vn', 'vinamilk@vinamilk.com.vn', '+842854155555', 'The largest dairy company in Vietnam.'),
(12, 'Massey University', 'massey_logo.png', 'https://www.massey.ac.nz', 'contact@massey.ac.nz', '+6463569099', 'An innovative and progressive university in New Zealand.'),
(13, 'Amazon Web Services (AWS)', 'aws_logo.png', 'https://aws.amazon.com', 'aws@amazon.com', '+12062661000', 'A subsidiary of Amazon providing on-demand cloud computing platforms.'),
(9, 'Vingroup', 'vingroup_logo.png', 'https://vingroup.net', 'contact@vingroup.net', '+842439749999', 'A leading private conglomerate in Vietnam, focusing on technology, industry, and services.');

INSERT INTO JobCategories (category_name)
VALUES
('IT'),
('Finance'),
('Marketing'),
('Engineering'),
('Healthcare'),
('Education'),
('Design'),
('Sales'),
('Human Resources'),
('Logistics');

INSERT INTO Jobs (employer_id, category_id, title, location, description, requirements, salary, deadline, status, created_at)
VALUES
(1, 1, 'Software Engineer', 'Ho Chi Minh City', 'Develop scalable web applications using PHP and MySQL.', 'Bachelor in CS, 2+ years exp.', 45000, '2025-12-31', 'approved', '2025-10-25 08:15:42'),
(1, 1, 'Frontend Developer', 'Remote', 'Work with HTML, CSS, and React.', 'Experience with modern JS frameworks.', 48000, '2025-12-15', 'approved', '2025-10-25 08:15:42'),
(3, 1, 'Network Administrator', 'Hanoi', 'Maintain company network and security systems.', 'Cisco certification preferred.', 40000, '2025-11-30', 'approved', '2025-10-25 08:15:42'),
(1, 1, 'Data Analyst', 'Da Nang', 'Analyze datasets to provide insights.', 'Knowledge in Python and SQL.', 47000, '2025-12-20', 'approved', '2025-10-25 08:15:42'),
(2, 2, 'Financial Analyst', 'Hanoi', 'Analyze financial performance and market trends.', 'Finance degree, Excel & SQL.', 42000, '2025-11-30', 'approved', '2025-10-25 08:15:42'),
(2, 2, 'Accountant', 'Ho Chi Minh City', 'Prepare monthly reports and budgets.', 'Bachelor in Accounting, 3 years exp.', 39000, '2025-12-10', 'approved', '2025-10-25 08:15:42'),
(1, 3, 'Digital Marketing Specialist', 'Remote', 'Manage Google Ads and SEO campaigns.', 'Experience with analytics tools.', 40000, '2025-12-05', 'approved', '2025-10-25 08:15:42'),
(2, 3, 'Brand Manager', 'Hanoi', 'Develop and oversee brand campaigns.', 'MBA preferred, 4 years exp.', 52000, '2025-12-25', 'approved', '2025-10-25 08:15:42'),
(4, 4, 'Civil Engineer', 'Ho Chi Minh City', 'Manage construction projects and teams.', 'Degree in Civil Engineering.', 50000, '2025-11-20', 'approved', '2025-10-25 08:15:42'),
(4, 4, 'Project Manager', 'Da Nang', 'Lead large-scale construction projects.', 'PMP certification preferred.', 60000, '2025-12-10', 'approved', '2025-10-25 08:15:42'),
(5, 5, 'Medical Software Engineer', 'Hanoi', 'Develop hospital management software.', 'Experience in Java & databases.', 55000, '2025-12-31', 'approved', '2025-10-25 08:15:42'),
(5, 5, 'Clinical Data Analyst', 'Ho Chi Minh City', 'Analyze clinical data sets for insights.', 'Biostatistics knowledge.', 53000, '2025-11-28', 'approved', '2025-10-25 08:15:42'),
(1, 6, 'E-Learning Developer', 'Remote', 'Create online course content.', 'Knowledge in LMS systems.', 40000, '2025-12-15', 'approved', '2025-10-25 08:15:42'),
(3, 6, 'Training Coordinator', 'Hanoi', 'Coordinate corporate training sessions.', 'Good communication skills.', 38000, '2025-12-05', 'approved', '2025-10-25 08:15:42'),
(1, 7, 'UI/UX Designer', 'Remote', 'Design web and mobile interfaces.', 'Experience with Figma/Adobe XD.', 46000, '2025-12-20', 'approved', '2025-10-25 08:15:42'),
(3, 8, 'Sales Executive', 'Hanoi', 'Sell digital solutions to enterprises.', 'Strong communication skills.', 41000, '2025-12-30', 'approved', '2025-10-25 08:15:42'),
(2, 8, 'Account Executive', 'Ho Chi Minh City', 'Manage customer relationships.', 'CRM experience.', 42000, '2025-11-30', 'approved', '2025-10-25 08:15:42'),
(2, 9, 'HR Specialist', 'Hanoi', 'Support recruitment and onboarding.', 'HR degree or equivalent.', 37000, '2025-12-31', 'approved', '2025-10-25 08:15:42'),
(4, 10, 'Supply Chain Coordinator', 'Da Nang', 'Coordinate logistics and supply chain operations.', 'Experience in ERP systems.', 45000, '2025-12-10', 'approved', '2025-10-25 08:15:42'),
(4, 10, 'Warehouse Supervisor', 'Hanoi', 'Oversee daily warehouse activities.', '3 years experience in logistics.', 40000, '2025-12-20', 'approved', '2025-10-25 08:15:42'),
(9, 10, 'Logistics Manager', 'Ho Chi Minh City', 'Oversee and manage the entire logistics lifecycle.', 'Proven experience in a logistics management role.', 55000.00, '2025-12-18', 'approved', '2025-11-15 00:07:23'),
(10, 1, 'Cloud Solutions Architect', 'Remote', 'Design and implement cloud-based solutions for healthcare clients.', 'AWS or Azure certification required.', 65000.00, '2026-08-15', 'approved', '2025-11-15 00:07:23'),
(8, 5, 'Healthcare IT Consultant', 'Da Nang', 'Provide IT consultancy to healthcare organizations.', 'Strong understanding of healthcare systems.', 58000.00, '2025-12-22', 'approved', '2025-11-15 00:07:23'),
(8, 1, 'AI Research Scientist', 'Hanoi', 'Conduct research and development in the field of Artificial Intelligence.', 'PhD or Masters in a related field.', 70000.00, '2026-08-20', 'approved', '2025-11-15 00:07:23'),
(9, 8, 'Real Estate Sales Manager', 'Ho Chi Minh City', 'Lead a team of sales executives in the real estate division.', '5+ years of sales experience in real estate.', 68000.00, '2025-12-30', 'approved', '2025-11-15 00:07:23'),
(10, 1, 'DevOps Engineer', 'Ho Chi Minh City', 'Work on CI/CD pipelines and infrastructure automation.', 'Experience with Docker, Kubernetes, and Jenkins.', 60000.00, '2026-08-10', 'approved', '2025-11-15 00:07:23'),
(8, 7, 'Graphic Designer', 'Da Nang', 'Create visually appealing graphics for marketing and products.', 'Proficient in Adobe Creative Suite.', 48000.00, '2025-12-25', 'pending', '2025-11-15 00:07:23'),
(6, 10, 'Supply Chain Analyst', 'Hanoi', 'Analyze and optimize supply chain processes.', 'Strong analytical skills and experience with supply chain software.', 53000.00, '2025-12-28', 'approved', '2025-11-15 00:07:23'),
(10, 6, 'University Lecturer', 'Remote', 'Deliver lectures and tutorials for undergraduate and postgraduate students.', 'PhD in a relevant subject area.', 75000.00, '2026-02-08', 'approved', '2025-11-15 00:07:23'),
(2, 1, 'Cloud Support Engineer', 'Remote', 'Provide technical support to AWS customers.', 'Experience with cloud computing and networking.', 80000.00, '2026-08-25', 'approved', '2025-11-15 00:07:23'),
(8, 1, 'Cloud Security', 'Ho Chi Minh city', 'Do stuff about IT and Security', '1 year experience in security or experience in playing CTF challenge', 10000.00, '2025-12-25', 'rejected', '2025-11-15 14:53:24'),
(10, 6, 'Teaching Assistant', 'Ha Noi', 'Help professor teach specific major classes in university', 'Have teaching education degree', 7000.00, '2025-12-01', 'rejected', '2025-11-15 15:09:32');


INSERT INTO StaffActions (staff_id, job_id, action_type, action_date)
VALUES
(2, 1, 'approve', '2025-10-25 08:15:42'),
(2, 2, 'approve', '2025-10-25 08:15:42'),
(2, 31, 'reject', '2025-11-15 14:59:53'),
(2, 32, 'reject', '2025-11-15 15:09:49');