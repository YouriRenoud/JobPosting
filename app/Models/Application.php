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

    public function hasApplied($job_id, $email) {
        $query = "SELECT COUNT(*) FROM {$this->table_name} WHERE job_id = :job_id AND applicant_email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":job_id", $job_id);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function getByJob($job_id) {
        $query = "SELECT * FROM {$this->table_name} WHERE job_id = :job_id ORDER BY applied_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":job_id", $job_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email) {
        $query = "SELECT *, j.title, j.location, e.company_name
                  FROM {$this->table_name} a
                  JOIN Jobs j ON a.job_id = j.id
                  JOIN Employers e ON j.employer_id = e.id
                  WHERE a.applicant_email = :email
                  ORDER BY a.applied_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
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
