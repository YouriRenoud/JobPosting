<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Employer.php';
require_once __DIR__ . '/../models/Job.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/StaffAction.php';

class AdminController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function listUsers() {
        $user = new User($this->db);
        return $user->getAll();
    }

    public function deleteUser($id) {
        $user = new User($this->db);
        return $user->delete($id);
    }

    public function createCategory($name) {
        $cat = new Category($this->db);
        $cat->category_name = $name;
        return $cat->create();
    }

    public function deleteCategory($id) {
        $cat = new Category($this->db);
        return $cat->delete($id);
    }

    // === Approve / Reject Jobs ===
    public function updateJobStatus($job_id, $status, $staff_id) {
        $job = new Job($this->db);
        $job->updateStatus($job_id, $status);

        $log = new StaffAction($this->db);
        $log->staff_id = $staff_id;
        $log->job_id = $job_id;
        $log->action_type = $status;
        $log->logAction();
    }

    // === View system statistics ===
    public function getStats() {
        $stats = [];
        $stats['total_jobs'] = $this->db->query("SELECT COUNT(*) FROM Jobs")->fetchColumn();
        $stats['active_employers'] = $this->db->query("SELECT COUNT(*) FROM Employers")->fetchColumn();
        $stats['pending_jobs'] = $this->db->query("SELECT COUNT(*) FROM Jobs WHERE status='pending'")->fetchColumn();
        return $stats;
    }
}
?>
