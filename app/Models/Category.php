<?php
require_once __DIR__ . '/../../config/Database.php';

class Category {
    private $conn;
    private $table_name = "JobCategories";

    public $id;
    public $category_name;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO {$this->table_name} (category_name) VALUES (:category_name)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":category_name", $this->category_name);
        return $stmt->execute();
    }

    public function getAll() {
        $query = "SELECT * FROM {$this->table_name} ORDER BY category_name ASC";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table_name} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE {$this->table_name} SET category_name = :category_name WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":category_name", $this->category_name);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}
?>
