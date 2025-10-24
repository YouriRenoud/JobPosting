<?php
$pageTitle = "Job Postings";
include '../../Views/partials/header.php';

require_once '../../controllers/AdminController.php';
$adminController = new AdminController();
$jobs = $adminController->getAllJobs();
?>

<div class="container mt-4" style="min-height: 60vh;">
    <h2 class="mb-4"><i class="fa-solid fa-briefcase"></i> All Job Postings</h2>

    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Employer</th>
                <th>Category</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobs as $job): ?>
                <tr>
                    <td><?= $job['id'] ?></td>
                    <td><?= htmlspecialchars($job['title']) ?></td>
                    <td><?= htmlspecialchars($job['company_name']) ?></td>
                    <td><?= htmlspecialchars($job['category_name']) ?></td>
                    <td><span class="badge bg-info"><?= htmlspecialchars($job['status']) ?></span></td>
                    <td><?= $job['created_at'] ?></td>
                    <td>
                        <a href="../../controllers/AdminController.php?action=deleteJob&id=<?= $job['id'] ?>"
                           class="btn btn-sm btn-danger" onclick="return confirm('Delete this job?')">
                           <i class="fa-solid fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../Views/partials/footer.php'; ?>
