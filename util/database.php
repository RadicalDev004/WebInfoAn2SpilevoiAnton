<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {

        try {
            $envUrl = getenv('DATABASE_URL');
if ($envUrl) {
    $envUrl = str_replace("postgres://", "pgsql://", $envUrl);
    $url = parse_url($envUrl);
    debug::printArray($url);

    $host = $url['host'] ?? 'localhost';
    if (!str_ends_with($host, '.internal')) {
        $host .= '.internal';
    }
    $port = $url['port'] ?? 5432;
    $dbname = isset($url['path']) ? ltrim($url['path'], '/') : '';
    $user = $url['user'] ?? '';
    $pass = $url['pass'] ?? '';
} else {

    $host = 'host.docker.internal';
    $port = 5432;
    $dbname = 'sgbd';
    $user = 'postgres';
    $pass = 'postgres';
}

            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
            echo $dsn."<br>";

            $this->connection = new PDO($dsn, $user, $pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $this->connection->exec("
            CREATE TABLE IF NOT EXISTS books (
                id SERIAL PRIMARY KEY,
                title TEXT,
                author TEXT,
                year INTEGER CHECK (year >= 0),
                publisher TEXT,
                description TEXT,
                pages INTEGER CHECK (pages >= 0),
                link TEXT
);

        ");
        $this->connection->exec("
            CREATE TABLE IF NOT EXISTS favorites (
                name VARCHAR(255),
                book_id INTEGER NOT NULL REFERENCES books(id) ON DELETE CASCADE,
                PRIMARY KEY (name, book_id)
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
