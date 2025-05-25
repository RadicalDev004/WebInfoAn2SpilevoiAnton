<?php

class ModelSettings{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function getUserStats($username) {
        // Get all books with progress for this user
        $stmt = $this->db->prepare("SELECT books.id, books.pages AS db_pages, books.link, progress.pages AS progress_pages
        FROM progress
        JOIN books ON progress.book_id = books.id
        WHERE progress.username = ?
        ");
        $stmt->execute([$username]);
        $allProgress = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $started = 0;
        $finished = 0;

        foreach ($allProgress as $row) {
            $progressPages = (int)$row['progress_pages'];
            $bookPages = $row['db_pages'] !== null ? (int)$row['db_pages'] : null;

            if ($bookPages === null && !empty($row['link'])) {
                $externalData = $this->getExternalBookData($row['link']);
                if (isset($externalData['volumeInfo']['pageCount'])) {
                    $bookPages = (int)$externalData['volumeInfo']['pageCount'];
                }
            }
            if ($progressPages > 0 && ($bookPages === null || $progressPages <= $bookPages)) {
                $started++;
            }

            if ($bookPages !== null && $progressPages === $bookPages) {
                $finished++;
            } elseif ($bookPages === null && $progressPages > 0) {
                $finished++;
            }
        }
        

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM reviews WHERE username = ?
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
    public function getBooksExportData($username) {
        $stmt = $this->db->prepare("SELECT 
        b.link AS BookLink,
        COALESCE(b.title, b.link) AS BookName,
        b.pages AS BookPages,
        COALESCE(MAX(p.pages), 0) AS PagesRead,
        CASE WHEN MAX(f.name) IS NOT NULL THEN 'Yes' ELSE 'No' END AS IsBookFavorite,
        COALESCE(ROUND(AVG(r.rating), 1), 0) AS AvarageReviews
        FROM books b
        JOIN progress p ON b.id = p.book_id AND p.username = ?
        LEFT JOIN favorites f ON b.id = f.book_id AND f.name = ?
        LEFT JOIN reviews r ON b.id = r.book_id
        GROUP BY b.id, b.title, b.link, b.pages
        ");
        $stmt->execute([$username, $username]);
        
        
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as &$row) {
            if ($row['bookname'] == $row['booklink'] && !empty($row['booklink'])) {
                $details = $this->getExternalBookData($row['booklink']);
                if (isset($details['volumeInfo'])) {
                    $row['bookname'] = $details['volumeInfo']['title'] ?? $row['booklink'];
                    $row['bookpages'] = $details['volumeInfo']['pageCount'] ?? $row['bookpages'];
                }
            }
        }
        return $data;
    }
    
    function getExternalBookData($link)
    {
        $response = file_get_contents($link);
        $data = json_decode($response, true);
        return $data;
    }
    
}
?>
