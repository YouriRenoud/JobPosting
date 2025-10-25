<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/Employer.php';
require_once __DIR__ . '/../models/Job.php';
require_once __DIR__ . '/../controllers/JobsController.php';

$jobsController = new JobsController();

if (isset($_GET['delete'])) {
    $job_id = (int)$_GET['delete'];
    $jobsController->deleteJob($job_id, $employer['id']);
    $message = "Job deleted successfully.";
}

if (isset($_POST['update_job'])) {
    $job_id = (int)$_POST['job_id'];
    $data = [
        'category_id' => $_POST['category_id'],
        'title' => $_POST['title'],
        'location' => $_POST['location'],
        'description' => $_POST['description'],
        'requirements' => $_POST['requirements'],
        'salary' => $_POST['salary'],
        'deadline' => $_POST['deadline']
    ];
    $jobsController->updateJob($job_id, $data);
    $message = "Job updated successfully.";
}

if (isset($_POST['create_job'])) {
    $data = [
        'employer_id' => $employer['id'],
        'category_id' => $_POST['category_id'],
        'title' => $_POST['title'],
        'location' => $_POST['location'],
        'description' => $_POST['description'],
        'requirements' => $_POST['requirements'],
        'salary' => $_POST['salary'],
        'deadline' => $_POST['deadline']
    ];
    $jobsController->createJob($data);
    $message = "New job posted successfully! Waiting for approval.";
}

class EmployersController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function createProfile($user_id, $data) {
        $emp = new Employer($this->db);
        $emp->user_id = $user_id;
        $emp->company_name = $data['company_name'];
        $emp->logo = $data['logo'] ?? null;
        $emp->website = $data['website'] ?? null;
        $emp->contact_email = $data['contact_email'];
        $emp->contact_phone = $data['contact_phone'] ?? null;
        $emp->description = $data['description'] ?? null;
        return $emp->create();
    }

    public function updateProfile($id, $data) {
        $emp = new Employer($this->db);
        $emp->id = $id;
        $emp->company_name = $data['company_name'];
        $emp->logo = $data['logo'];
        $emp->website = $data['website'];
        $emp->contact_email = $data['contact_email'];
        $emp->contact_phone = $data['contact_phone'];
        $emp->description = $data['description'];
        return $emp->update();
    }

    public function updateLogo($id, $data) {
        $emp = new Employer($this->db);
        $emp->id = $id;
        $emp->logo = $data['logo'];
        return $emp->updateLogo();
    }

    public function getProfile($user_id) {
        $emp = new Employer($this->db);
        return $emp->getByUser($user_id);
    }

    public function getMyJobs($employer_id) {
        $job = new Job($this->db);
        return $job->getByEmployer($employer_id);
    }

    public function getNotifications($employer_id) {
        $notif = new Job($this->db);
        return $notif->getNotificationsByEmployer($employer_id);
    }
}
?>
