<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/Category.php';

$database = new Database();
$db = $database->getConnection();

$categoryModel = new Category($db);

$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

if ($action === 'deleteCategory' && $id) {
    if ($categoryModel->delete($id)) {
        header("Location: /JobPosting/app/Views/admin/categories.php?deleted=1");
        exit;
    } else {
        header("Location: /JobPosting/app/Views/admin/categories.php?error=1");
        exit;
    }
}

class CategoriesController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAllCategories() {
        $cat = new Category($this->db);
        return $cat->getAll();
    }

    public function addCategory($name) {
        $cat = new Category($this->db);
        $cat->category_name = $name;
        return $cat->create();
    }

    public function deleteCategory($id) {
        $cat = new Category($this->db);
        return $cat->delete($id);
    }

    public function updateCategory($id, $name) {
        $cat = new Category($this->db);
        $cat->id = $id;
        $cat->category_name = $name;
        $query = "UPDATE JobCategories SET category_name = :category_name WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":category_name", $name);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
