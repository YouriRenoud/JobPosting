<?php
require_once __DIR__ . '/../../config/Database.php';

class Application {
    private $conn;
    private $table_name = "Applications";

    public $id;
    public $job_id;
    public $applicant_name;
    public $applicant_email;
    public $resume;
    public $cover_letter;
    public $applied_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO {$this->table_name}
                (job_id, applicant_name, applicant_email, resume, cover_letter)
                VALUES (:job_id, :applicant_name, :applicant_email, :resume, :cover_letter)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":job_id", $this->job_id);
        $stmt->bindParam(":applicant_name", $this->applicant_name);
        $stmt->bindParam(":applicant_email", $this->applicant_email);
        $stmt->bindParam(":resume", $this->resume);
        $stmt->bindParam(":cover_letter", $this->cover_letter);
        return $stmt->execute();
    }

    public function getByJob($job_id) {
        $query = "SELECT * FROM {$this->table_name} WHERE job_id = :job_id ORDER BY applied_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":job_id", $job_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table_name} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
