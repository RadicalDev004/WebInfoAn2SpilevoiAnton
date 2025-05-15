<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {

        try {
            $host = 'localhost';
            $port = 5555;
            $dbname = 'sgbd';
            $user = 'postgres';
            $pass = 'postgres';

            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

            $this->connection = new PDO($dsn, $user, $pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $this->connection->exec("
            CREATE TABLE IF NOT EXISTS books (
                id SERIAL PRIMARY KEY,
                titlu TEXT NOT NULL,
                autor TEXT NOT NULL,
                an INTEGER CHECK (an >= 0),
                editura TEXT,
                descriere TEXT,
                pagini INTEGER CHECK (pagini >= 0)
);

        ");
        $this->connection->exec("
            CREATE TABLE IF NOT EXISTS favorites (
                nume VARCHAR(255) NOT NULL,
                id_carte INTEGER NOT NULL REFERENCES books(id) ON DELETE CASCADE,
                PRIMARY KEY (nume, id_carte)
);

        ");
        $this->connection->exec("
    CREATE TABLE IF NOT EXISTS progress (
        id SERIAL PRIMARY KEY,
        book_id INTEGER REFERENCES books(id) ON DELETE CASCADE,
        username VARCHAR(255) NOT NULL,
        pages INTEGER NOT NULL,
        UNIQUE(book_id, username)
);

");

$this->connection->exec("
    CREATE TABLE IF NOT EXISTS reviews (
        id SERIAL PRIMARY KEY,
        book_id INTEGER REFERENCES books(id) ON DELETE CASCADE,
        username VARCHAR(255) NOT NULL,
        text TEXT NOT NULL,
        rating INTEGER CHECK (rating >= 0 AND rating <= 5),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

");
        } catch (PDOException $e) {
            die("Database Connection failed: " . $e->getMessage());
        }
    }

    private function __clone() {}

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->connection;
    }
}
