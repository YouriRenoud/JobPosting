<?php
$pageTitle = "Categories";
include '../../Views/partials/header.php';

require_once '../../controllers/CategoriesController.php';
$categoriesController = new CategoriesController();
$categories = $categoriesController->getAllCategories();

// Handle form submission for new category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['category_name'])) {
    $categoriesController->addCategory($_POST['category_name']);
    header("Location: categories.php");
    exit;
}
?>

<div class="container mt-4">
    <h2 class="mb-4"><i class="fa-solid fa-layer-group"></i> Manage Job Categories</h2>

    <form class="d-flex mb-4" method="POST">
        <input type="text" name="category_name" class="form-control me-2" placeholder="Add new category..." required>
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add</button>
    </form>

    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= $cat['id'] ?></td>
                    <td><?= htmlspecialchars($cat['category_name']) ?></td>
                    <td>
                        <a href="../../controllers/CategoriesController.php?action=deleteCategory&id=<?= $cat['id'] ?>"
                           class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">
                           <i class="fa-solid fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../Views/partials/footer.php'; ?>
