<?php
if (!isset($pageTitle)) $pageTitle = "JobFinder";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link href="/WebProgAssignment251/public/CSS/global.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg fixed-top bg-dark shadow-sm">
    <div class="container gap-2">
        <a class="navbar-brand fw-bold text-primary" href="/WebProgAssignment251/public/index.php">
            <i class="fa-solid fa-briefcase"></i> JobFinder
        </a>

        <button class="navbar-toggler bg-primary" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav mb-lg-0 gap-2">
                <?php if (isset($_SESSION['user'])): ?>
                    <?php 
                    $role = $_SESSION['user']['role']; 
                    switch ($role) {
                        case 'admin':
                            echo '<li class="nav-item"><a class="nav-link ' . ($pageTitle=='Categories'?'active':'') . '" href="/WebProgAssignment251/app/Views/admin/categories.php">Categories</a></li>';
                            echo '<li class="nav-item"><a class="nav-link ' . ($pageTitle=='Users'?'active':'') . '" href="/WebProgAssignment251/app/Views/admin/users.php">Users</a></li>';
                            echo '<li class="nav-item"><a class="nav-link ' . ($pageTitle=='Job Postings'?'active':'') . '" href="/WebProgAssignment251/app/Views/admin/jobs.php">Job Postings</a></li>';
                            echo '<li class="nav-item"><a class="nav-link ' . ($pageTitle=='Moderate'?'active':'') . '" href="/WebProgAssignment251/app/Views/admin/moderate.php">Moderate</a></li>';
                            break;
                        case 'staff':
                            echo '<li class="nav-item"><a class="nav-link ' . ($pageTitle=='Job Postings'?'active':'') . '" href="/WebProgAssignment251/app/Views/admin/jobs.php">Job Postings</a></li>';
                            echo '<li class="nav-item"><a class="nav-link ' . ($pageTitle=='Moderate'?'active':'') . '" href="/WebProgAssignment251/app/Views/admin/moderate.php">Moderate</a></li>';
                            break;
                        case 'employer':
                            echo '<li class="nav-item"><a class="nav-link ' . ($pageTitle=='Company'?'active':'') . '" href="/WebProgAssignment251/app/Views/employers/register.php">Company</a></li>';
                            echo '<li class="nav-item"><a class="nav-link ' . ($pageTitle=='New Job'?'active':'') . '" href="/WebProgAssignment251/app/Views/employers/dashboard.php">My Jobs</a></li>';
                            break;
                        case 'visitor':
                            echo '<li class="nav-item"><a class="nav-link ' . ($pageTitle=='Profile'?'active':'') . '" href="/WebProgAssignment251/public/account.php">My Account</a></li>';
                            break;
                    }
                    ?>

                    <li class="nav-item">
                        <a class="btn btn-outline-danger" href="/WebProgAssignment251/public/logout.php">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </a>
                    </li>

                <?php else: ?>
                    <li class="nav-item"><a class="nav-link <?= ($pageTitle=='Home'?'active':'') ?>" href="/WebProgAssignment251/public/index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pageTitle=='Contact'?'active':'') ?>" href="/WebProgAssignment251/public/contact.php">Contact</a></li>

                    <li class="nav-item">
                        <a class="btn btn-outline-primary" href="/WebProgAssignment251/public/login.php">
                            <i class="fa-solid fa-user"></i> Login
                        </a>
                        <a class="btn btn-primary" href="/WebProgAssignment251/public/signup.php">
                            <i class="fa-solid fa-user-plus"></i> Sign Up
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-5">
