<?php
$pageTitle = "Profile";
include '../app/Views/partials/header.php';
require_once '../app/controllers/AuthController.php';

$controller = new AuthController();
$user_id = $_SESSION['user']['id'];

$user = $controller->getUserById($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = [
        'name' => $_POST['full_name'],
        'email' => $_POST['email'],
    ];

    if ($user) {
        $controller->updateProfile($user_id, $data);
        $message = "Your profile was updated successfully!";
    } else {
        $error = "Error updating profile.";
    }

    $user = $controller->getUserById($user_id);
}
?>

<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h2 class="mb-4 text-primary"><i class="fa-solid fa-user"></i> Your Profile</h2>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" required
                       value="<?= htmlspecialchars($user['name'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required
                       value="<?= htmlspecialchars($user['email'] ?? '') ?>">
            </div>

            <button type="submit" class="btn btn-primary">
                <?= $user ? 'Update Information' : 'Register Company' ?>
            </button>
        </form>
    </div>
</div>

<?php include '../app/Views/partials/footer.php'; ?>
