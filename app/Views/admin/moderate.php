<?php
$pageTitle = "Moderate";
include '../../Views/partials/header.php';

require_once '../../controllers/AdminController.php';
$adminController = new AdminController();
$pendingJobs = $adminController->getPendingJobs();
?>

<div class="container mt-4">
    <h2 class="mb-4"><i class="fa-solid fa-gavel"></i> Moderate Job Listings</h2>

    <?php if (empty($pendingJobs)): ?>
        <p class="text-center text-muted">No jobs awaiting moderation.</p>
    <?php else: ?>
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Employer</th>
                    <th>Category</th>
                    <th>Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pendingJobs as $job): ?>
                    <tr>
                        <td><?= $job['id'] ?></td>
                        <td><?= htmlspecialchars($job['title']) ?></td>
                        <td><?= htmlspecialchars($job['company_name']) ?></td>
                        <td><?= htmlspecialchars($job['category_name']) ?></td>
                        <td><?= $job['created_at'] ?></td>
                        <td>
                            <a href="../../controllers/AdminController.php?action=approveJob&id=<?= $job['id'] ?>" class="btn btn-success btn-sm">
                                <i class="fa-solid fa-check"></i> Approve
                            </a>
                            <a href="../../controllers/AdminController.php?action=rejectJob&id=<?= $job['id'] ?>" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-xmark"></i> Reject
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include '../../Views/partials/footer.php'; ?>