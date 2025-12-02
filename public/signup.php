<?php
$pageTitle = "Sign Up";
include '../app/Views/partials/header.php';
require_once '../app/Controllers/AuthController.php';

$authController = new AuthController();
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'role' => $_POST['role'] ?? 'visitor',
    ];

    try {
        if ($authController->register($data)) {
            $message = "Registration successful! You can now log in.";
        } else {
            $message = "Error during registration. Try again.";
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $message = "This email is already registered. Please use a different email or log in.";
        } else {
            $message = "Error during registration. Try again.";
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm mt-5">
            <div class="card-body p-4">
                <h3 class="text-center mb-4"><i class="fa-solid fa-user-plus"></i> Create an Account</h3>

                <?php if ($message): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Account Type</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="employer">Employer</option>
                            <option value="visitor">Job Seeker</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                </form>

                <p class="text-center mt-3 small">
                    Already have an account? <a href="login.php">Login here</a>.
                </p>
            </div>
        </div>
    </div>
</div>

<?php include '../app/Views/partials/footer.php'; ?>
