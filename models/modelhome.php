<?php
class ModelHome {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();

        $this->db->exec("
            CREATE TABLE IF NOT EXISTS books (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                titlu TEXT,
                autor TEXT,
                an INTEGER
            )
        ");


        $count = $this->db->query("SELECT COUNT(*) FROM books")->fetchColumn();
        if ($count == 0) {
            $this->db->exec("
                INSERT INTO books (titlu, autor, an) VALUES
                ('1984', 'George Orwell', 1949),
                ('To Kill a Mockingbird', 'Harper Lee', 1960),
                ('Fahrenheit 451', 'Ray Bradbury', 1953)
            ");
        }
    }

    public function getAllBooks() {
        $stmt = $this->db->query("SELECT * FROM books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchBooks($query) {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE titlu LIKE ? OR autor LIKE ?");
        $searchTerm = '%' . $query . '%';
        //echo $searchTerm;
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
