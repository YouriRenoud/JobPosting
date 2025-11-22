<?php
$pageTitle = "Users";
include '../../Views/partials/header.php';

require_once '../../controllers/AdminController.php';
$adminController = new AdminController();
$users = $adminController->listUsers();
?>

<div class="container mt-4">
    <h2 class="mb-4"><i class="fa-solid fa-users"></i> Manage Users</h2>

    <div style="overflow-x: auto; width: 100%;">
        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['name']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($u['role']) ?></span></td>
                        <td><?= $u['created_at'] ?></td>
                        <td>
                            <a href="../../controllers/AdminController.php?action=deleteUser&id=<?= $u['id'] ?>"
                            class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')"
                            style="width: 6em;">
                                <i class="fa-solid fa-user-xmark"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../Views/partials/footer.php'; ?>
