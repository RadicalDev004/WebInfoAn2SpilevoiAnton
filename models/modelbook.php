<?php
class ModelBook {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->db->exec("
    CREATE TABLE IF NOT EXISTS reviews (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        book_id INTEGER,
        username TEXT,
        text TEXT,
        rating INTEGER,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )
");
        $this->db->exec("
    CREATE TABLE IF NOT EXISTS progress (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        book_id INTEGER,
        username TEXT,
        pages INTEGER,
        UNIQUE(book_id, username)
    )
");
    }

    public function getBookById($id) {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getBookReviews($id) {
        $stmt = $this->db->prepare("SELECT * FROM reviews WHERE book_id = ? ORDER BY created_at DESC");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getBookAverage($id) {
        $stmt = $this->db->prepare("SELECT AVG(rating) as avg_rating FROM reviews WHERE book_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return round($result['avg_rating'] ?? 0, 2);
    }
    
    
    public function postReview($id, $user, $text, $stars) {
        $text = urldecode($text ?? '');
        $stmt = $this->db->prepare("
        INSERT INTO reviews (book_id, username, text, rating)
        VALUES (?, ?, ?, ?)
    ");

        return $stmt->execute([$id, $user, $text, $stars]);
    }
    
    public function getBookPages($id)
    {
        $stmt = $this->db->prepare("SELECT pagini FROM books WHERE id = ?");
        $stmt->execute([$id]);
        $pgs = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $pgs ? $pgs['pagini'] : 0;
    }
    
    public function getBookProgress($id, $user)
    {
        $stmt = $this->db->prepare("SELECT pages FROM progress WHERE book_id = ? and username = ?");
        $stmt->execute([$id, $user]);
        $pgs = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $pgs ? $pgs['pages'] : 0;
    }
    
    public function setBookProgress($id, $user, $pages)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM progress WHERE book_id = ? AND username = ?");
        $stmt->execute([$id, $user]);

        if ($stmt->fetchColumn() > 0) {
            $prev = $this->getBookProgress($id, $user);
            $pgs = $this->getBookPages($id);
            $newVal = $prev + $pages;
            if($newVal < 0) $newVal = 0;
            if($newVal > $pgs) $newVal = $pgs;
            
            $stmt = $this->db->prepare("UPDATE progress SET pages = ? WHERE book_id = ? AND username = ?");
            $stmt->execute([$newVal, $id, $user]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO progress (book_id, username, pages) VALUES (?, ?, ?)");
            $stmt->execute([$id, $user, $pages]);
        }
    }
}
