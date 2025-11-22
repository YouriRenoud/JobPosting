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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_category_id'], $_POST['edit_category_name'])) {
    $categoriesController->updateCategory($_POST['edit_category_id'], $_POST['edit_category_name']);
    header("Location: categories.php?updated=1");
    exit;
}
?>

<div class="container mt-4">
    <h2 class="mb-4"><i class="fa-solid fa-layer-group"></i> Manage Job Categories</h2>

    <form class="d-flex mb-4" method="POST">
        <input type="text" name="category_name" class="form-control me-2" placeholder="Add new category..." required>
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add</button>
    </form>

    <div style="overflow-x: auto; width: 100%;">
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
                        <td>
                            <?php if (isset($_GET['edit']) && $_GET['edit'] == $cat['id']): ?>
                                <form method="POST" class="d-flex mb-0">
                                    <input type="hidden" name="edit_category_id" value="<?= $cat['id'] ?>">
                                    <input type="text" name="edit_category_name" class="form-control" required value="<?= htmlspecialchars($cat['category_name']) ?>">
                            <?php else: ?>
                                <?= htmlspecialchars($cat['category_name']) ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (isset($_GET['edit']) && $_GET['edit'] == $cat['id']): ?>
                                    <button type="submit" class="btn btn-success text-white btn-sm me-1" style="width: 6em;">
                                        <i class="fa-solid fa-floppy-disk"></i> Save
                                    </button>
                                    <button type="button" onclick="window.location.href='categories.php'" class="btn btn-danger text-white btn-sm" style="width: 6em;">
                                        <i class="fa-solid fa-xmark"></i> Cancel
                                    </button>
                                </form>
                            <?php else: ?>
                                <a href="categories.php?edit=<?= $cat['id'] ?>" class="btn btn-sm btn-warning text-white me-1" style="width: 6em;">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <a href="../../controllers/CategoriesController.php?action=deleteCategory&id=<?= $cat['id'] ?>"
                                class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')" style="width: 6em;">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../../Views/partials/footer.php'; ?>
