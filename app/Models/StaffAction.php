<?php
require_once __DIR__ . '/../../config/Database.php';

class StaffAction {
    private $conn;
    private $table_name = "StaffActions";

    public $id;
    public $staff_id;
    public $job_id;
    public $action_type;
    public $action_date;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function logAction() {
        $query = "INSERT INTO {$this->table_name} (staff_id, job_id, action_type)
                VALUES (:staff_id, :job_id, :action_type)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":staff_id", $this->staff_id);
        $stmt->bindParam(":job_id", $this->job_id);
        $stmt->bindParam(":action_type", $this->action_type);
        return $stmt->execute();
    }

    public function getAll() {
        $query = "SELECT sa.*, u.name AS staff_name, j.title AS job_title
                FROM {$this->table_name} sa
                JOIN Users u ON sa.staff_id = u.id
                JOIN Jobs j ON sa.job_id = j.id
                ORDER BY sa.action_date DESC";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByJob($job_id) {
        $query = "SELECT * FROM {$this->table_name} WHERE job_id = :job_id ORDER BY action_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":job_id", $job_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
