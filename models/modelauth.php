<?php
class ModelAuth {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();

        $this->db->exec("
            CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                username VARCHAR(255) UNIQUE NOT NULL,
                password TEXT NOT NULL
            );
        ");
        setcookie('is_admin', '0', [
                    'expires' => time() + 3600,
                    'path' => '/',
                    'secure' => false,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);
    }

    public function autentifica($username, $password) {       
        $stmt = $this->db->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($username === "admin" && $password === "admin")
        {
            if ($username === 'admin' && $password === 'admin') {
                setcookie('is_admin', '1', [
                    'expires' => time() + 3600,
                    'path' => '/',
                    'secure' => false,
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);
                
                header("Location: /WebInfoAn2SpilevoiAnton/admin/index");
                exit;
            }
        }

        if ($row && password_verify($password, $row['password'])) {
            $payload = [
                'username' => $username,
                'exp' => time() + 3600
            ];
            $jwt = JWT::create($payload);
            setcookie('auth_token', $jwt, [
                'expires' => time() + 3600,
                'path' => '/',
                'secure' => false,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
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
