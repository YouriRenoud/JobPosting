<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/Application.php';

$appController = new ApplicationsController();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'job_id' => $_POST['job_id'],
        'applicant_name' => $_SESSION['user']['name'],
        'applicant_email' => $_SESSION['user']['email'],
        'cover_letter' => $_POST['cover_letter'],
    ];

    if (!empty($_FILES['resume']['name'])) {
        $uploadDir = "../uploads/resumes/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        
        $fileName = time() . "_" . basename($_FILES['resume']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['resume']['tmp_name'], $targetPath)) {
            $data['resume'] = $fileName;
        } else {
            $message = "<div class='alert alert-danger'>Error uploading resume.</div>";
        }
    }

    if (empty($message)) {
        $result = $appController->applyToJob($data);
        if ($result === "already_applied") {
            $message = "<div class='alert alert-warning'>You have already applied to this job.</div>";
        } elseif ($result === "success") {
            $message = "<div class='alert alert-success'>Application submitted successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error submitting your application.</div>";
        }
    }
}

class ApplicationsController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function applyToJob($data) {
        $app = new Application($this->db);
        if ($app->hasApplied($data['job_id'], $data['applicant_email'])) {
            return "already_applied";
        }
        $app->job_id = $data['job_id'];
        $app->applicant_name = $data['applicant_name'];
        $app->applicant_email = $data['applicant_email'];
        $app->resume = $data['resume'] ?? null;
        $app->cover_letter = $data['cover_letter'] ?? null;
        return $app->create() ? "success" : "error";
    }

    public function getApplicationsByJob($job_id) {
        $app = new Application($this->db);
        return $app->getByJob($job_id);
    }

    public function getApplicationsByEmail($email) {
        $app = new Application($this->db);
        return $app->getByEmail($email);
    }
}
?>
