<?php
$pageTitle = "Job Details";
include '../partials/header.php';

require_once '../../controllers/JobsController.php';
require_once '../../controllers/CategoriesController.php';

$jobsController = new JobsController();
$categoriesController = new CategoriesController();

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger text-center mt-5'>No job selected.</div>";
    include '../partials/footer.php';
    exit;
}

$id = intval($_GET['id']);
$job = $jobsController->showJob($id);

if (!$job) {
    echo "<div class='alert alert-warning text-center mt-5'>Job not found or unavailable.</div>";
    include '../partials/footer.php';
    exit;
}
?>

<div class="container mt-5 mb-5">
    <div class="card shadow-sm p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold mb-0"><?= htmlspecialchars($job['title']) ?></h2>
            <span class="badge bg-primary"><?= htmlspecialchars($job['category_name']) ?></span>
        </div>

        <p class="text-muted mb-1">
            <i class="fa-solid fa-building"></i> <?= htmlspecialchars($job['company_name']) ?>
        </p>
        <p class="text-muted mb-3">
            <i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($job['location']) ?>
        </p>

        <h5 class="mt-4">Job Description</h5>
        <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>

        <?php if (!empty($job['requirements'])): ?>
            <h5 class="mt-4">Requirements</h5>
            <p><?= nl2br(htmlspecialchars($job['requirements'])) ?></p>
        <?php endif; ?>

        <?php if (!empty($job['salary'])): ?>
            <h5 class="mt-4">Salary</h5>
            <p><strong>$<?= number_format($job['salary'], 2) ?></strong></p>
        <?php endif; ?>

        <?php if (!empty($job['deadline'])): ?>
            <h5 class="mt-4">Application Deadline</h5>
            <p><?= htmlspecialchars(date('F j, Y', strtotime($job['deadline']))) ?></p>
        <?php endif; ?>

        <hr>

        <div class="d-flex justify-content-between align-items-center">
            <a href="../../../public/index.php" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left"></i> Back to Jobs
            </a>
        </div>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
