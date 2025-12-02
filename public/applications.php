<?php
$pageTitle = "My Applications";
include '../app/Views/partials/header.php';

require_once '../app/controllers/ApplicationsController.php';
require_once '../app/controllers/JobsController.php';

$userEmail = $_SESSION['user']['email'];

$appController = new ApplicationsController();
$applications = $appController->getApplicationsByEmail($userEmail);
?>

<div class="container mt-5 mb-5">


    <h2 class="text-primary mb-4">


        <i class="fa-solid fa-file-lines"></i> My Applications


    </h2>





    <?php if (empty($applications)): ?>


        <div class="alert alert-info text-center">


            You haven’t applied to any jobs yet.


        </div>


    <?php else: ?>


        <div class="table-responsive">


            <table class="table table-hover align-middle">


                <thead class="table-light">


                    <tr>


                        <th>Job Title</th>


                        <th>Company</th>


                        <th>Location</th>


                        <th>Applied On</th>


                        <th>Status</th>


                        <th>Actions</th>


                    </tr>


                </thead>
                <tbody>
                    <?php foreach ($applications as $app): ?>
                        <tr>
                            <td><?= htmlspecialchars($app['title']) ?></td>
                            <td><?= htmlspecialchars($app['company_name']) ?></td>
                            <td><?= htmlspecialchars($app['location']) ?></td>
                            <td><?= htmlspecialchars($app['applied_at']) ?></td>
                            <td>
                                <span class="badge bg-secondary">Submitted</span>
                            </td>
                            <td>
                                <a href="/JobPosting/app/Views/jobs/show.php?id=<?= $app['job_id'] ?>" class="btn btn-sm btn-outline-success">
                                    <i class="fa-solid fa-briefcase"></i> View Offer
                                </a>

                                <?php if (!empty($app['resume'])): ?>
                                    <a href="../app/Views/uploads/resumes/<?= htmlspecialchars($app['resume']) ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="fa-solid fa-file-arrow-down"></i> Resume
                                    </a>
                                <?php endif; ?>

                                <button class="btn btn-sm btn-outline-info"
                                        data-bs-toggle="modal"
                                        data-bs-target="#coverModal"
                                        data-cover-letter="<?= htmlspecialchars($app['cover_letter'], ENT_QUOTES) ?>"
                                        data-job-title="<?= htmlspecialchars($app['title'], ENT_QUOTES) ?>">
                                    <i class="fa-solid fa-envelope-open-text"></i> View Letter
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="coverModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa-solid fa-envelope-open-text"></i> Cover Letter</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6 id="jobTitle" class="text-primary fw-bold mb-3"></h6>
                <p id="coverLetter" class="text-dark" style="white-space: pre-line;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const coverModal = document.getElementById('coverModal');
    coverModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const cover = button.getAttribute('data-cover-letter');
        const jobTitle = button.getAttribute('data-job-title');
        coverModal.querySelector('#coverLetter').textContent = cover;
        coverModal.querySelector('#jobTitle').textContent = jobTitle;
    });
});
</script>

<?php include '../app/Views/partials/footer.php'; ?>