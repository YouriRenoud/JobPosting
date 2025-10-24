<?php
$pageTitle = "Company";
include '../partials/header.php';
require_once '../../controllers/EmployersController.php';

$controller = new EmployersController();
$user_id = $_SESSION['user']['id'];

$employer = $controller->getProfile($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'company_name' => $_POST['company_name'],
        'logo' => $_POST['logo'] ?? null,
        'website' => $_POST['website'],
        'contact_email' => $_POST['contact_email'],
        'contact_phone' => $_POST['contact_phone'],
        'description' => $_POST['description']
    ];

    if ($employer) {
        $controller->updateProfile($employer['id'], $data);
        $message = "Company profile updated successfully!";
    } else {
        $controller->createProfile($user_id, $data);
        $message = "Company registered successfully!";
    }

    $employer = $controller->getProfile($user_id);
}
?>

<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h2 class="mb-4 text-primary"><i class="fa-solid fa-building"></i> Company Profile</h2>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Company Name</label>
                <input type="text" name="company_name" class="form-control" required
                       value="<?= htmlspecialchars($employer['company_name'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Logo (URL or filename)</label>
                <input type="text" name="logo" class="form-control"
                       value="<?= htmlspecialchars($employer['logo'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Website</label>
                <input type="url" name="website" class="form-control"
                       value="<?= htmlspecialchars($employer['website'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Contact Email</label>
                <input type="email" name="contact_email" class="form-control" required
                       value="<?= htmlspecialchars($employer['contact_email'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Contact Phone</label>
                <input type="text" name="contact_phone" class="form-control"
                       value="<?= htmlspecialchars($employer['contact_phone'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($employer['description'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                <?= $employer ? 'Update Information' : 'Register Company' ?>
            </button>
        </form>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
