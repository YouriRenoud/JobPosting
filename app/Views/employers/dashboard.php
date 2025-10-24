<?php
$pageTitle = "My Jobs";
include '../partials/header.php';

require_once '../../controllers/EmployersController.php';
require_once '../../controllers/JobsController.php';
require_once '../../controllers/CategoriesController.php';

$user_id = $_SESSION['user']['id'];
$empController = new EmployersController();
$jobsController = new JobsController();
$catController = new CategoriesController();

$employer = $empController->getProfile($user_id);
if (!$employer) {
    header("Location: register.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'employer_id' => $employer['id'],
        'category_id' => $_POST['category_id'],
        'title' => $_POST['title'],
        'location' => $_POST['location'],
        'description' => $_POST['description'],
        'requirements' => $_POST['requirements'],
        'salary' => $_POST['salary'],
        'deadline' => $_POST['deadline']
    ];

    $jobsController->createJob($data);
    $message = "New job posted successfully! Waiting for approval.";
}

$jobs = $empController->getMyJobs($employer['id']);
$categories = $catController->getAllCategories();
?>

<div class="container my-5">
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
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jobs as $job): ?>
                    <tr>
                        <td><?= htmlspecialchars($job['title']) ?></td>
                        <td><?= htmlspecialchars($job['category_name']) ?></td>
                        <td><?= htmlspecialchars($job['location']) ?></td>
                        <td><span class="badge bg-<?= $job['status'] === 'approved' ? 'success' : ($job['status'] === 'pending' ? 'warning' : 'secondary') ?>">
                            <?= htmlspecialchars(ucfirst($job['status'])) ?>
                        </span></td>
                        <td><?= htmlspecialchars($job['deadline']) ?></td>
                    </tr>
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

        <button type="submit" class="btn btn-primary">Post Job</button>
    </form>
</div>

<?php include '../partials/footer.php'; ?>
