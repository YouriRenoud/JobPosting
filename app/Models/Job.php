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
        // Initialize database connection
        $this->conn = $db;
    }

    public function create() {
        // To create new job postings
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
        // To get all job postings
        $query = "SELECT j.*, e.company_name, c.category_name
                FROM {$this->table_name} j
                JOIN Employers e ON j.employer_id = e.id
                JOIN JobCategories c ON j.category_id = c.id
                ORDER BY j.created_at DESC";
        return $this->conn->query($query);
    }

    public function getAllApprovedPaginated($limit, $offset) {
        // To get all approved job postings with pagination
        $query = "SELECT j.*, e.company_name, c.category_name
                FROM {$this->table_name} j
                JOIN Employers e ON j.employer_id = e.id
                JOIN JobCategories c ON j.category_id = c.id
                WHERE j.status = 'approved'
                ORDER BY j.created_at DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAllApproved() {
        // To count all approved job postings
        $query = "SELECT COUNT(*) FROM {$this->table_name} WHERE status = 'approved'";
        return $this->conn->query($query)->fetchColumn();
    }

    public function searchPaginated($keyword, $limit, $offset) {
        // To search approved job postings with pagination
        $query = "SELECT j.*, e.company_name, c.category_name
                FROM {$this->table_name} j
                JOIN Employers e ON j.employer_id = e.id
                JOIN JobCategories c ON j.category_id = c.id
                WHERE j.status = 'approved'
                    AND (j.title LIKE :keyword OR e.company_name LIKE :keyword OR c.category_name LIKE :keyword OR j.location LIKE :keyword)
                ORDER BY j.created_at DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $kw = "%" . $keyword . "%";
        $stmt->bindParam(":keyword", $kw);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countSearch($keyword) {
        // To count search results for approved job postings
        $query = "SELECT COUNT(*) FROM {$this->table_name} j
                JOIN Employers e ON j.employer_id = e.id
                JOIN JobCategories c ON j.category_id = c.id
                WHERE j.status = 'approved'
                    AND (j.title LIKE :keyword OR e.company_name LIKE :keyword OR c.category_name LIKE :keyword OR j.location LIKE :keyword)";
        $stmt = $this->conn->prepare($query);
        $kw = "%" . $keyword . "%";
        $stmt->bindParam(":keyword", $kw);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getByCategoryPaginated($category_id, $limit, $offset) {
        // To get job postings by category with pagination
        $query = "SELECT j.*, e.company_name, c.category_name
                FROM {$this->table_name} j
                JOIN Employers e ON j.employer_id = e.id
                JOIN JobCategories c ON j.category_id = c.id
                WHERE j.status = 'approved' AND j.category_id = :category_id
                ORDER BY j.created_at DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":category_id", $category_id);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByCategory($category_id) {
        // To count job postings by category
        $query = "SELECT COUNT(*) FROM {$this->table_name} WHERE status = 'approved' AND category_id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":category_id", $category_id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function search($keyword) {
        // To search job postings by keyword
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
        // To get job postings by category
        $query = "SELECT j.*, e.company_name, c.category_name
                FROM {$this->table_name} j
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
        // To get a job posting by its ID
        $query = "SELECT j.*, e.company_name, c.category_name
                FROM {$this->table_name} j
                JOIN Employers e ON j.employer_id = e.id
                JOIN JobCategories c ON j.category_id = c.id
                WHERE j.id = :id
                LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmployer($employer_id) {
        // To get job postings by employer
        $query = "SELECT j.*, c.category_name
                FROM {$this->table_name} j
                JOIN JobCategories c ON j.category_id = c.id
                WHERE j.employer_id = :employer_id
                ORDER BY j.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":employer_id", $employer_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByStatus($status) {
        // To get job postings by status
        $query = "SELECT j.*, e.company_name, c.category_name
                FROM {$this->table_name} j
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
        // To update job posting status
        $query = "UPDATE {$this->table_name} SET status=:status WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function updateJobDetails($job_id, $data) {
        // To update job posting details
        $query = "UPDATE {$this->table_name} SET ";
        $fields = [];
        $params = [];

        foreach (['category_id', 'title', 'location', 'description', 'requirements', 'salary', 'deadline'] as $column) {
            if (isset($data[$column]) && $data[$column] !== null) {
                $fields[] = "$column = :$column";
                $params[":$column"] = $data[$column];
            }
        }

        if (empty($fields)) {
            return false;
        }

        $query .= implode(', ', $fields) . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':id', $job_id);

        return $stmt->execute();
    }

    public function delete($id) {
        // To delete a job posting
        $query = "DELETE FROM {$this->table_name} WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
    
    public function deleteJobWithReason($job, $reason) {
        // To delete a job posting with a reason and notify the employer
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
        // To get notifications for an employer
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
