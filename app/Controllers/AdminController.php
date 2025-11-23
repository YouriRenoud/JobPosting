<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Employer.php';
require_once __DIR__ . '/../models/Job.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/StaffAction.php';

$database = new Database();
$db = $database->getConnection();

$jobModel = new Job($db);

$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

if ($action === 'approveJob' && $id) {
    if ($jobModel->updateStatus($id, 'approved')) {
        header("Location: /WebProgAssignment251/app/Views/admin/moderate.php?approved=1");
        exit;
    } else {
        header("Location: /WebProgAssignment251/app/Views/admin/moderate.php?error=1");
        exit;
    }
}
if ($action === 'rejectJob' && $id) {
    if ($jobModel->updateStatus($id, 'rejected')) {
        header("Location: /WebProgAssignment251/app/Views/admin/moderate.php?rejected=1");
        exit;
    } else {
        header("Location: /WebProgAssignment251/app/Views/admin/moderate.php?error=1");
        exit;
    }
}
if ($action == 'deleteUser' && $id) {
    $userModel = new User($db);
    if ($userModel->delete($id)) {
        header("Location: /WebProgAssignment251/app/Views/admin/users.php?deleted=1");
        exit;
    } else {
        header("Location: /WebProgAssignment251/app/Views/admin/users.php?error=1");
        exit;
    }
}
if ($action === 'deleteJob' && $id) {
    $jobId = $id;
    $reason = $_GET['reason'] ?? 'No reason specified';

    $job = $jobModel->getJobById($jobId);
    $jobModel->deleteJobWithReason($job, $reason);
    header("Location: /WebProgAssignment251/app/Views/admin/jobs.php?deleted=1");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'editJob') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];

    $adminController = new AdminController();
    $adminController->updateJob($id, $title, $location, $description, $requirements);

    header("Location: /WebProgAssignment251/app/Views/admin/jobs.php?updated=1");
    exit;
}

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

    public function getAllJobs() {
        $job = new Job($this->db);
        return $job->getAll();
    }

    public function deleteUser($id) {
        $user = new User($this->db);
        return $user->delete($id);
    }

    public function deleteJob($id) {
        $job = new Job($this->db);
        return $job->delete($id);
    }

    public function getPendingJobs() {
        $job = new Job($this->db);
        return $job->getByStatus('pending');
    }

    public function approveJob($id) {
        $job = new Job($this->db);

        $action = new StaffAction($this->db);
        $action->staff_id = $_SESSION['user']['id'];
        $action->job_id = $id;
        $action->action_type = 'approve';
        $action->logAction();

        return $job->updateStatus($id, 'approved');
    }

    public function rejectJob($id) {
        $job = new Job($this->db);

        $action = new StaffAction($this->db);
        $action->staff_id = $_SESSION['user']['id'];
        $action->job_id = $id;
        $action->action_type = 'reject';
        $action->logAction();

        return $job->updateStatus($id, 'rejected');
    }

    public function updateJob($id, $title, $location, $description, $requirements) {
        $job = new Job($this->db);
        $job->id = $id;
        $job->title = $title;
        $job->location = $location;
        $job->description = $description;
        $job->requirements = $requirements;
        return $job->updateJobDetails($id, [
            'title' => $title,
            'location' => $location,
            'description' => $description,
            'requirements' => $requirements
        ]);
    }

    public function getStats() {
        $stats = [];
        $stats['total_jobs'] = $this->db->query("SELECT COUNT(*) FROM Jobs")->fetchColumn();
        $stats['active_employers'] = $this->db->query("SELECT COUNT(*) FROM Employers")->fetchColumn();
        $stats['pending_jobs'] = $this->db->query("SELECT COUNT(*) FROM Jobs WHERE status='pending'")->fetchColumn();
        $stats['users_number'] = $this->db->query("SELECT COUNT(*) FROM Users")->fetchColumn();
        return $stats;
    }
}
?>
