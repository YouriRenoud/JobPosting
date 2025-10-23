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

    <link href="assets/css/global.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fa-solid fa-briefcase"></i> JobFinder
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link <?= ($pageTitle=='Home'?'active':'') ?>" href="/WebProgAssignment251/public/index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= ($pageTitle=='Jobs'?'active':'') ?>" href="index.php?controller=jobs&action=list">Jobs</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?controller=categories&action=list">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>

                <?php if (isset($_SESSION['user'])): ?>
                    <?php if ($_SESSION['user']['role'] === 'employer'): ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?controller=employers&action=dashboard">My Dashboard</a></li>
                    <?php elseif ($_SESSION['user']['role'] === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?controller=admin&action=dashboard">Admin Panel</a></li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-danger ms-2" href="/WebProgAssignment251/public/logout.php">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary ms-2" href="/WebProgAssignment251/public/login.php">
                            <i class="fa-solid fa-user"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-2" href="/WebProgAssignment251/public/signup.php">
                            <i class="fa-solid fa-user-plus"></i> Sign Up
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4">
