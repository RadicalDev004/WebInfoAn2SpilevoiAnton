<?php
class ModelAuth {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();

        $this->db->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE,
                password TEXT
            )
        ");
    }

    public function autentifica($username, $password) {       
        $stmt = $this->db->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['user'] = $username;
            return true;
        }
        return false;
    }

    public function inregistreaza($username, $password) {
        try {
            $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            return $stmt->execute([$username, password_hash($password, PASSWORD_BCRYPT)]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function esteAutentificat() {
        return isset($_SESSION['user']);
    }

    public function logout() {
        session_destroy();
    }
}
