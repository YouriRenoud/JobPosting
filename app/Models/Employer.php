<?php
require_once __DIR__ . '/../../config/Database.php';

class Employer {
    private $conn;
    private $table_name = "Employers";

    public $id;
    public $user_id;
    public $company_name;
    public $logo;
    public $website;
    public $contact_email;
    public $contact_phone;
    public $description;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO {$this->table_name}
            (user_id, company_name, logo, website, contact_email, contact_phone, description)
            VALUES (:user_id, :company_name, :logo, :website, :contact_email, :contact_phone, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":company_name", $this->company_name);
        $stmt->bindParam(":logo", $this->logo);
        $stmt->bindParam(":website", $this->website);
        $stmt->bindParam(":contact_email", $this->contact_email);
        $stmt->bindParam(":contact_phone", $this->contact_phone);
        $stmt->bindParam(":description", $this->description);
        return $stmt->execute();
    }

    public function getByUser($user_id) {
        $query = "SELECT * FROM {$this->table_name} WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE {$this->table_name}
                SET company_name=:company_name, logo=:logo, website=:website,
                    contact_email=:contact_email, contact_phone=:contact_phone,
                    description=:description
                WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":company_name", $this->company_name);
        $stmt->bindParam(":logo", $this->logo);
        $stmt->bindParam(":website", $this->website);
        $stmt->bindParam(":contact_email", $this->contact_email);
        $stmt->bindParam(":contact_phone", $this->contact_phone);
        $stmt->bindParam(":description", $this->description);
        return $stmt->execute();
    }

    public function updateLogo() {
        $query = "UPDATE {$this->table_name} SET logo=:logo WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":logo", $this->logo);
        return $stmt->execute();
    }
}
?>
