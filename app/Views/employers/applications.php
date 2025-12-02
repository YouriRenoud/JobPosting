<?php
$pageTitle = "Applications";
include '../partials/header.php';

require_once '../../controllers/ApplicationsController.php';

$controller = new ApplicationsController();

$job_id = $_GET['job_id'] ?? null;
if (!$job_id) {
    echo "<div class='alert alert-danger m-4'>Invalid job ID.</div>";
    include '../partials/footer.php';
    exit;
}

$applications = $controller->getApplicationsByJob($job_id);
?>

<div class="container my-5">
    <h2 class="mb-4 text-primary"><i class="fa-solid fa-users"></i> Applications for Job #<?= htmlspecialchars($job_id) ?></h2>

    <?php if (empty($applications)): ?>
        <div class="alert alert-info">No applications received yet for this job.</div>
    <?php else: ?>
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Applicant Name</th>
                    <th>Email</th>
                    <th>Cover Letter</th>
                    <th>Resume</th>
                    <th>Applied At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $app): ?>
                    <tr>
                        <td><?= htmlspecialchars($app['applicant_name']) ?></td>
                        <td><?= htmlspecialchars($app['applicant_email']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-outline-info"
                                    data-bs-toggle="modal"
                                    data-bs-target="#coverModal"
                                    data-applicant="<?= htmlspecialchars($app['applicant_name']) ?>"
                                    data-cover="<?= htmlspecialchars($app['cover_letter'], ENT_QUOTES) ?>">
                                <i class="fa-solid fa-envelope-open-text"></i> View
                            </button>
                        </td>
                        <td>
                            <?php if (!empty($app['resume'])): ?>
                                <a href="../uploads/resumes/<?= htmlspecialchars($app['resume']) ?>" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="fa-solid fa-file-arrow-down"></i> Resume
                                </a>
                            <?php else: ?>
                                <span class="text-muted">No resume</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($app['applied_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="dashboard.php" class="btn btn-secondary mt-3"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
</div>

<!-- Modal for Cover Letter -->
<div class="modal fade" id="coverModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fa-solid fa-envelope-open-text"></i> Cover Letter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6 id="modalApplicantName" class="fw-bold"></h6>
                <p id="modalCoverLetter"></p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const coverModal = document.getElementById('coverModal');
    coverModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        document.getElementById('modalApplicantName').textContent = button.getAttribute('data-applicant');
        document.getElementById('modalCoverLetter').textContent = button.getAttribute('data-cover');
    });
});
</script>

<?php include '../partials/footer.php'; ?>