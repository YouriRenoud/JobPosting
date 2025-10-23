<?php
$pageTitle = "Login";
include '../app/Views/partials/header.php';
require_once '../app/Controllers/AuthController.php';

$authController = new AuthController();
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $authController->login($email, $password);
    if ($user) {
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit;
    } else {
        $message = "Invalid email or password.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm mt-5">
            <div class="card-body p-4">
                <h3 class="text-center mb-4"><i class="fa-solid fa-user"></i> Login</h3>

                <?php if ($message): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <p class="text-center mt-3 small">
                    Don't have an account? <a href="signup.php">Sign up here</a>.
                </p>
            </div>
        </div>
    </div>
</div>

<?php include '../app/Views/partials/footer.php'; ?>
