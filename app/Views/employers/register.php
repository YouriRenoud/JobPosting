<?php
$pageTitle = "Company";
include '../partials/header.php';
require_once '../../controllers/EmployersController.php';

$controller = new EmployersController();
$user_id = $_SESSION['user']['id'];

$employer = $controller->getProfile($user_id);

if (isset($_GET['remove_logo']) && $employer && !empty($employer['logo'])) {
    $filePath = "../images/" . $employer['logo'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
    $controller->updateLogo($employer['id'], ['logo' => null]);
    $employer['logo'] = null;
    $message = "Logo removed successfully.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $logoFileName = $employer['logo'] ?? null;

    if (!empty($_FILES['logo']['name'])) {
        $uploadDir = '../images/';
        $fileTmpPath = $_FILES['logo']['tmp_name'];
        $fileName = basename($_FILES['logo']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($fileExt, $allowedExtensions)) {
            $safeFileName = uniqid('logo_') . '.' . $fileExt;
            $uploadPath = $uploadDir . $safeFileName;

            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                if (!empty($employer['logo']) && file_exists($uploadDir . $employer['logo'])) {
                    unlink($uploadDir . $employer['logo']);
                }
                $logoFileName = $safeFileName;
            } else {
                $error = "Error uploading file. Please try again.";
            }
        } else {
            $error = "Invalid file type. Please upload a JPG, PNG, or GIF image.";
        }
    }

    $data = [
        'company_name' => $_POST['company_name'],
        'logo' => $logoFileName,
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
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Company Name</label>
                <input type="text" name="company_name" class="form-control" required
                       value="<?= htmlspecialchars($employer['company_name'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Company Logo</label>
                <input type="file" name="logo" class="form-control" accept="image/*">
                <?php if (!empty($employer['logo'])): ?>
                    <div class="mt-3 d-flex align-items-center">
                        <img src="../images/<?= htmlspecialchars($employer['logo']) ?>" alt="Logo"
                             class="img-thumbnail me-3" style="max-height: 120px;">
                        <a href="?remove_logo=1" class="btn btn-outline-danger btn-sm"
                           onclick="return confirm('Are you sure you want to remove the logo?');">
                            <i class="fa-solid fa-trash"></i> Remove Logo
                        </a>
                    </div>
                <?php endif; ?>
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
