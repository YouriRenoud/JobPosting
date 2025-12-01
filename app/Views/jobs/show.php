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
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div class="d-flex align-items-start">
                <?php if (!empty($job['logo'])): ?>
                    <img src="../images/<?= htmlspecialchars($job['logo']) ?>" 
                        alt="<?= htmlspecialchars($job['company_name']) ?>" 
                        class="me-3" 
                        style="width: 80px; height: 80px; object-fit: contain; border-radius: 12px; border: 1px solid #e0e0e0; padding: 8px;">
                <?php else: ?>
                    <div class="me-3 d-flex align-items-center justify-content-center" 
                        style="width: 80px; height: 80px; background-color: #f0f0f0; border-radius: 12px; border: 1px solid #e0e0e0;">
                        <i class="fa-solid fa-building fa-2x text-muted"></i>
                    </div>
                <?php endif; ?>
                <div>
                    <h2 class="fw-bold mb-2"><?= htmlspecialchars($job['title']) ?></h2>
                    <p class="text-muted mb-1">
                        <i class="fa-solid fa-building"></i> <?= htmlspecialchars($job['company_name']) ?>
                    </p>
                    <p class="text-muted mb-0">
                        <i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($job['location']) ?>
                    </p>
                </div>
            </div>
            <span class="badge bg-primary" style="font-size: 0.9rem;"><?= htmlspecialchars($job['category_name']) ?></span>
        </div>

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
