<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/Employer.php';
require_once __DIR__ . '/../models/Job.php';

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

    public function getProfile($user_id) {
        $emp = new Employer($this->db);
        return $emp->getByUser($user_id);
    }

    // Get jobs posted by this employer
    public function getMyJobs($employer_id) {
        $job = new Job($this->db);
        $query = "SELECT * FROM Jobs WHERE employer_id = :employer_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":employer_id", $employer_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
