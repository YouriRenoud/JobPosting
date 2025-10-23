<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/Job.php';

class JobsController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // List all approved jobs
    public function listApprovedJobs() {
        $job = new Job($this->db);
        return $job->getAllApproved();
    }

    // Search jobs by keyword
    public function searchJobs($keyword) {
        $job = new Job($this->db);
        return $job->search($keyword);
    }

    // Employer creates new job
    public function createJob($data) {
        $job = new Job($this->db);
        $job->employer_id = $data['employer_id'];
        $job->category_id = $data['category_id'];
        $job->title = $data['title'];
        $job->location = $data['location'];
        $job->description = $data['description'];
        $job->requirements = $data['requirements'];
        $job->salary = $data['salary'] ?? null;
        $job->deadline = $data['deadline'];
        $job->status = 'pending';
        return $job->create();
    }

    public function showByCategory($category_id) {
        $job = new Job($this->db);
        return $job->getByCategory($category_id);
    }

    public function showJob($id) {
        $job = new Job($this->db);
        return $job->getJobById($id);
    }

    public function changeStatus($job_id, $status) {
        $job = new Job($this->db);
        return $job->updateStatus($job_id, $status);
    }
}
?>
