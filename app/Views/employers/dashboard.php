<?php
$pageTitle = "My Jobs";
include '../partials/header.php';

require_once '../../controllers/EmployersController.php';
require_once '../../controllers/JobsController.php';
require_once '../../controllers/CategoriesController.php';

$user_id = $_SESSION['user']['id'];
$empController = new EmployersController();
$catController = new CategoriesController();

$employer = $empController->getProfile($user_id);
if (!$employer) {
    header("Location: register.php");
    exit;
}

$jobs = $empController->getMyJobs($employer['id']);
$categories = $catController->getAllCategories();
$notifications = $empController->getNotifications($employer['id']);
?>

<div class="container my-5">

    <h2 class="mb-4 text-primary"><i class="fa-solid fa-bell"></i> Notifications</h2>

    <?php if (empty($notifications)): ?>
        <p class="text-muted">No notifications at the moment.</p>
    <?php else: ?>
        <ul class="list-group mb-5 shadow-sm">
            <?php foreach ($notifications as $notif): ?>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div>
                        <strong><?= htmlspecialchars($notif['job_title']) ?></strong><br>
                        <span><?= htmlspecialchars($notif['job_description']) ?></span><br>
                        <span><?= htmlspecialchars($notif['message']) ?></span>
                    </div>
                    <small class="text-muted"><?= date("M d, Y H:i", strtotime($notif['created_at'])) ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h2 class="mb-4 text-primary"><i class="fa-solid fa-briefcase"></i> My Job Postings</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (empty($jobs)): ?>
        <p class="text-muted">You haven't posted any jobs yet.</p>
    <?php else: ?>
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Deadline</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jobs as $job): ?>
                    <tr>
                        <td><?= htmlspecialchars($job['title']) ?></td>
                        <td><?= htmlspecialchars($job['category_name']) ?></td>
                        <td><?= htmlspecialchars($job['location']) ?></td>
                        <td>
                            <span class="badge bg-<?= $job['status'] === 'approved' ? 'success' : ($job['status'] === 'pending' ? 'warning' : 'secondary') ?>">
                                <?= htmlspecialchars(ucfirst($job['status'])) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($job['deadline']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editJob<?= $job['id'] ?>">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <a href="?delete=<?= $job['id'] ?>" 
                               onclick="return confirm('Are you sure you want to delete this job?');"
                               class="btn btn-sm btn-danger">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Edit Job Modal -->
                    <div class="modal fade" id="editJob<?= $job['id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="POST">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title"><i class="fa-solid fa-pen"></i> Edit Job</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Job Title</label>
                                            <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($job['title']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Category</label>
                                            <select name="category_id" class="form-select" required>
                                                <?php foreach ($categories as $cat): ?>
                                                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $job['category_id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($cat['category_name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Location</label>
                                            <input type="text" name="location" class="form-control" required value="<?= htmlspecialchars($job['location']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Salary (USD)</label>
                                            <input type="number" name="salary" step="0.01" class="form-control" required value="<?= htmlspecialchars($job['salary']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Deadline</label>
                                            <input type="date" name="deadline" class="form-control" required value="<?= htmlspecialchars($job['deadline']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Requirements</label>
                                            <textarea name="requirements" class="form-control" rows="3"><?= htmlspecialchars($job['requirements']) ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($job['description']) ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="update_job" class="btn btn-primary">Save Changes</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Edit Modal -->

                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <hr class="my-5">

    <h3 class="mb-3"><i class="fa-solid fa-plus"></i> Add New Job</h3>
    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">Job Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Salary (USD)</label>
            <input type="number" name="salary" step="0.01" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input type="date" name="deadline" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Requirements</label>
            <textarea name="requirements" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" name="create_job" class="btn btn-primary">Post Job</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>
