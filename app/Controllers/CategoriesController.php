<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/Category.php';

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
}
?>
