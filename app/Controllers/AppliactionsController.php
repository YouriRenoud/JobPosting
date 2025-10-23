<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/Application.php';

class ApplicationsController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function applyToJob($data) {
        $app = new Application($this->db);
        $app->job_id = $data['job_id'];
        $app->applicant_name = $data['applicant_name'];
        $app->applicant_email = $data['applicant_email'];
        $app->resume = $data['resume'] ?? null;
        $app->cover_letter = $data['cover_letter'] ?? null;
        return $app->create();
    }

    public function getApplicationsByJob($job_id) {
        $app = new Application($this->db);
        return $app->getByJob($job_id);
    }
}
?>
