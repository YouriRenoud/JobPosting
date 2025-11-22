<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/Job.php';

class JobsController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function listApprovedJobsPaginated($limit, $offset) {
        // To list approved job postings with pagination
        $job = new Job($this->db);
        return $job->getAllApprovedPaginated($limit, $offset);
    }

    public function countApprovedJobs() {
        // To count all approved job postings
        $job = new Job($this->db);
        return $job->countAllApproved();
    }

    public function searchJobsPaginated($keyword, $limit, $offset) {
        // To search approved job postings with pagination
        $job = new Job($this->db);
        return $job->searchPaginated($keyword, $limit, $offset);
    }

    public function countSearchJobs($keyword) {
        // To count search results for approved job postings
        $job = new Job($this->db);
        return $job->countSearch($keyword);
    }

    public function showByCategoryPaginated($category_id, $limit, $offset) {
        // To get job postings by category with pagination
        $job = new Job($this->db);
        return $job->getByCategoryPaginated($category_id, $limit, $offset);
    }

    public function countJobsByCategory($category_id) {
        // To count job postings by category
        $job = new Job($this->db);
        return $job->countByCategory($category_id);
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

    public function deleteJob($job_id, $employer_id = null) {
        $job = new Job($this->db);
        if ($employer_id !== null) {
            $jobData = $job->getJobById($job_id);
            if (!$jobData || $jobData['employer_id'] != $employer_id) {
                return false;
            }
        }
        return $job->delete($job_id);
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

    public function updateJob($job_id, $data) {
        $job = new Job($this->db);
        return $job->updateJobDetails($job_id, $data);
    }
}
?>
