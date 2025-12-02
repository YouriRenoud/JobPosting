<?php
$pageTitle = "Apply for Job";
include '../partials/header.php';

require_once '../../controllers/JobsController.php';
require_once '../../controllers/ApplicationsController.php';

if (!isset($_SESSION['user'])) {
    header("Location: /JobPosting/public/login.php?error=login_required");
    exit;
}
else if ($_SESSION['user']['role'] !== 'visitor') {
    header("Location: /JobPosting/public/index.php");
    exit;
}

if (!isset($_GET['job_id'])) {
    header("Location: /JobPosting/public/index.php");
    exit;
}

$job_id = intval($_GET['job_id']);
$jobsController = new JobsController();
$job = $jobsController->showJob($job_id);

if (!$job) {
    echo "<div class='container mt-5 alert alert-danger'>Job not found.</div>";
    include '../partials/footer.php';
    exit;
}
?>

<div class="container mt-5 mb-5" style="max-width: 700px;">
    <div class="card shadow-sm p-4">
        <h3 class="text-primary mb-3"><i class="fa-solid fa-paper-plane"></i> Apply for “<?= htmlspecialchars($job['title']) ?>”</h3>
        <?php if (!empty($message)) echo $message; ?>

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="job_id" value="<?= htmlspecialchars($job_id) ?>">
            <div class="mb-3">
                <label class="form-label">Your Name</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['name']) ?>" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Your Email</label>
                <input type="email" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['email']) ?>" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Resume (PDF, DOCX)</label>
                <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx">
            </div>

            <div class="mb-3">
                <label class="form-label">Cover Letter</label>
                <textarea name="cover_letter" class="form-control" rows="5" placeholder="Write your cover letter here..." required></textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-paper-plane"></i> Submit Application
                </button>
            </div>
        </form>
    </div>
</div>

<?php include '../partials/footer.php'; ?>