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
                an INTEGER,
                pagini INTEGER
            )
        ");
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS favorites (
                nume TEXT,
                id_carte INTEGER,
                PRIMARY KEY(nume, id_carte)
            )
        ");


        $count = $this->db->query("SELECT COUNT(*) FROM books")->fetchColumn();
        if ($count == 0) {
            $this->db->exec("
    INSERT INTO books (titlu, autor, an, pagini) VALUES
    ('1984', 'George Orwell', 1949, 328),
    ('To Kill a Mockingbird', 'Harper Lee', 1960, 281),
    ('Fahrenheit 451', 'Ray Bradbury', 1953, 194),
    ('Brave New World', 'Aldous Huxley', 1932, 268),
    ('Animal Farm', 'George Orwell', 1945, 112),
    ('The Great Gatsby', 'F. Scott Fitzgerald', 1925, 180),
    ('The Catcher in the Rye', 'J.D. Salinger', 1951, 277),
    ('Lord of the Flies', 'William Golding', 1954, 224),
    ('Moby-Dick', 'Herman Melville', 1851, 635),
    ('Pride and Prejudice', 'Jane Austen', 1813, 279),
    ('The Hobbit', 'J.R.R. Tolkien', 1937, 310),
    ('Frankenstein', 'Mary Shelley', 1818, 280),
    ('The Picture of Dorian Gray', 'Oscar Wilde', 1890, 254),
    ('Jane Eyre', 'Charlotte Brontë', 1847, 500),
    ('Wuthering Heights', 'Emily Brontë', 1847, 416),
    ('Dracula', 'Bram Stoker', 1897, 418),
    ('Crime and Punishment', 'Fyodor Dostoevsky', 1866, 671),
    ('The Brothers Karamazov', 'Fyodor Dostoevsky', 1880, 796),
    ('Les Misérables', 'Victor Hugo', 1862, 1232),
    ('Don Quixote', 'Miguel de Cervantes', 1605, 863)
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
    
    public function toogleBookFavorite($id)
    {       
        $nume = $_SESSION['user'];
        if($this->isBookFavorite($id))
        {
            $stmt = $this->db->prepare("DELETE FROM favorites WHERE nume LIKE ? AND id_carte LIKE ?");
            $stmt->execute([$nume, $id]);
        }
        else
        {
            $stmt = $this->db->prepare("INSERT INTO favorites (nume, id_carte) VALUES (?, ?)");
            $stmt->execute([$nume, $id]);
        }
    }
    
    public function isBookFavorite($id)
    {
        $nume = $_SESSION['user'];
        $stmt = $this->db->prepare("SELECT * FROM favorites WHERE nume LIKE ? AND id_carte LIKE ?");
        $stmt->execute([$nume, $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return !empty($row);
    }
    public function getBookProgress($id)
    {
        $user = $_SESSION['user'];
        $stmt = $this->db->prepare("SELECT pages FROM progress WHERE book_id = ? and username = ?");
        $stmt->execute([$id, $user]);
        $pgs = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $pgs ? $pgs['pages'] : 0;
    }
}
