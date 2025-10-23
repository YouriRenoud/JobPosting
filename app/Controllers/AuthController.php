<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function register($data) {
        $user = new User($this->db);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password_hash = password_hash($data['password'], PASSWORD_BCRYPT);
        $user->role = $data['role'] ?? 'employer';
        return $user->create();
    }

    public function login($email, $password) {
        $user = new User($this->db);
        $result = $user->login($email);
        if ($result && password_verify($password, $result['password_hash'])) {
            return $result;
        }
        return false;
    }
}
?>
