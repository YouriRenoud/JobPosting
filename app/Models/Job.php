<?php
require_once __DIR__ . '/../../config/Database.php';

class Job {
    private $conn;
    private $table_name = "Jobs";

    public $id;
    public $employer_id;
    public $category_id;
    public $title;
    public $location;
    public $description;
    public $requirements;
    public $salary;
    public $deadline;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO {$this->table_name}
            (employer_id, category_id, title, location, description, requirements, salary, deadline, status)
            VALUES (:employer_id, :category_id, :title, :location, :description, :requirements, :salary, :deadline, :status)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":employer_id", $this->employer_id);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":requirements", $this->requirements);
        $stmt->bindParam(":salary", $this->salary);
        $stmt->bindParam(":deadline", $this->deadline);
        $stmt->bindParam(":status", $this->status);
        return $stmt->execute();
    }

    public function getAll() {
        $query = "SELECT j.*, e.company_name, c.category_name
                FROM {$this->table_name} j
                JOIN Employers e ON j.employer_id = e.id
                JOIN JobCategories c ON j.category_id = c.id
                ORDER BY j.created_at DESC";
        return $this->conn->query($query);
    }

    public function getAllApproved() {
        $query = "SELECT j.*, e.company_name, c.category_name
                FROM {$this->table_name} j
                JOIN Employers e ON j.employer_id = e.id
                JOIN JobCategories c ON j.category_id = c.id
                WHERE j.status = 'approved'
                ORDER BY j.created_at DESC";
        return $this->conn->query($query);
    }

    public function search($keyword) {
        $query = "SELECT j.*, e.company_name, c.category_name
                FROM {$this->table_name} j
                JOIN Employers e ON j.employer_id = e.id
                JOIN JobCategories c ON j.category_id = c.id
                WHERE j.status = 'approved'
                    AND (j.title LIKE :keyword OR e.company_name LIKE :keyword OR c.category_name LIKE :keyword OR j.location LIKE :keyword)";
        $stmt = $this->conn->prepare($query);
        $kw = "%" . $keyword . "%";
        $stmt->bindParam(":keyword", $kw);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCategory($category_id) {
        $query = "SELECT j.*, e.company_name, c.category_name
                FROM Jobs j
                JOIN Employers e ON j.employer_id = e.id
                JOIN JobCategories c ON j.category_id = c.id
                WHERE j.status = 'approved' AND j.category_id = :category_id
                ORDER BY j.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":category_id", $category_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJobById($id) {
        $query = "SELECT j.*, e.company_name, c.category_name
                FROM Jobs j
                JOIN Employers e ON j.employer_id = e.id
                JOIN JobCategories c ON j.category_id = c.id
                WHERE j.id = :id AND j.status = 'approved'
                LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmployer($employer_id) {
        $query = "SELECT j.*, c.category_name
                FROM Jobs j
                JOIN JobCategories c ON j.category_id = c.id
                WHERE j.employer_id = :employer_id
                ORDER BY j.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":employer_id", $employer_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByStatus($status) {
        $query = "SELECT j.*, e.company_name, c.category_name
                FROM Jobs j
                JOIN Employers e ON j.employer_id = e.id
                JOIN JobCategories c ON j.category_id = c.id
                WHERE j.status = :status
                ORDER BY j.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE {$this->table_name} SET status=:status WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table_name} WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
    
    public function deleteJobWithReason($job, $reason) {
        $this->delete($job['id']);

        $message = "Your job posting '{$job['title']}' was removed. Reason: {$reason}";

        $query = "INSERT INTO Notifications (employer_id, job_title, job_description, message)
                VALUES (:employer_id, :job_title, :job_description, :message)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":employer_id", $job['employer_id']);
        $stmt->bindParam(":job_title", $job['title']);
        $stmt->bindParam(":job_description", $job['description']);
        $stmt->bindParam(":message", $message);
        $stmt->execute();
    }

    public function getNotificationsByEmployer($employer_id) {
        $query = "SELECT *
                FROM Notifications n
                WHERE n.employer_id = :employer_id
                ORDER BY n.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":employer_id", $employer_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
