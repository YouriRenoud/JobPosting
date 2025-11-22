<?php
$pageTitle = "Job Postings";
include '../../Views/partials/header.php';

require_once '../../controllers/AdminController.php';
$adminController = new AdminController();
$jobs = $adminController->getAllJobs();
?>

<div class="container mt-4" style="min-height: 60vh;">
    <h2 class="mb-4 text-primary"><i class="fa-solid fa-briefcase"></i> All Job Postings</h2>

    <div style="overflow-x: auto; width: 100%;">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Employer</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Description</th>
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
                        <td><?= htmlspecialchars($job['location']) ?></td>
                        <td><?= htmlspecialchars(substr($job['description'], 0, 50)) ?>...</td>
                        <td>
                            <span class="badge bg-<?= $job['status'] === 'approved' ? 'success' : ($job['status'] === 'pending' ? 'warning' : 'secondary') ?>">
                                <?= htmlspecialchars(ucfirst($job['status'])) ?>
                            </span>
                        </td>
                        <td><?= $job['created_at'] ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning text-white me-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal"
                                    data-job-id="<?= $job['id'] ?>"
                                    data-job-title="<?= htmlspecialchars($job['title']) ?>"
                                    data-job-location="<?= htmlspecialchars($job['location']) ?>"
                                    data-job-description="<?= htmlspecialchars($job['description']) ?>"
                                    data-job-requirements="<?= htmlspecialchars($job['requirements']) ?>"
                                    style="width: 6em;">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>

                            <button class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"
                                    data-job-id="<?= $job['id'] ?>"
                                    data-job-title="<?= htmlspecialchars($job['title']) ?>"
                                    style="width: 6em;">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="../../controllers/AdminController.php">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Edit Job</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="editJob">
                    <input type="hidden" name="id" id="editJobId">

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="editJobTitle" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" id="editJobLocation" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editJobDescription" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Requirements</label>
                        <textarea name="requirements" id="editJobRequirements" class="form-control" rows="4" required></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning text-white">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="GET" action="../../controllers/AdminController.php">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fa-solid fa-triangle-exclamation"></i> Delete Job</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this job?</p>
                    <p><strong id="jobTitle"></strong></p>
                    <input type="hidden" name="action" value="deleteJob">
                    <input type="hidden" name="id" id="jobId">

                    <div class="mb-3">
                        <label class="form-label">Reason for deletion:</label>
                        <select name="reason" class="form-select" required>
                            <option value="">-- Select reason --</option>
                            <option value="Job expired">Job expired</option>
                            <option value="False information">False information</option>
                            <option value="Inappropriate content">Inappropriate content</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Confirm Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const jobId = button.getAttribute('data-job-id');
        const jobTitle = button.getAttribute('data-job-title');
        deleteModal.querySelector('#jobId').value = jobId;
        deleteModal.querySelector('#jobTitle').textContent = jobTitle;
    });

    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const jobId = button.getAttribute('data-job-id');
        const title = button.getAttribute('data-job-title');
        const location = button.getAttribute('data-job-location');
        const description = button.getAttribute('data-job-description');
        const requirements = button.getAttribute('data-job-requirements');

        editModal.querySelector('#editJobId').value = jobId;
        editModal.querySelector('#editJobTitle').value = title;
        editModal.querySelector('#editJobLocation').value = location;
        editModal.querySelector('#editJobDescription').value = description;
        editModal.querySelector('#editJobRequirements').value = requirements;
    });
});
</script>

<?php include '../../Views/partials/footer.php'; ?>
