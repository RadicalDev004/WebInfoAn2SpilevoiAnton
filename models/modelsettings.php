<?php

class ModelSettings{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function getUserStats($username) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM progress
            JOIN books ON progress.book_id = books.id
            WHERE progress.username = ? AND progress.pages > 0 AND progress.pages <= books.pages
        ");
        $stmt->execute([$username]);
        $started = $stmt->fetchColumn();

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM progress
            JOIN books ON progress.book_id = books.id
            WHERE progress.username = ? AND progress.pages = books.pages
        ");
        $stmt->execute([$username]);
        $finished = $stmt->fetchColumn();

        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM reviews WHERE username = ?
        ");
        $stmt->execute([$username]);
        $comments = $stmt->fetchColumn();
        
        
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM favorites WHERE name = ?");
        $stmt->execute([$username]);
        $favorites = $stmt->fetchColumn();

        return [
            'started' => $started,
            'finished' => $finished,
            'comments' => $comments,
            'favorites' => $favorites
        ];
    }
}
?>
