<?php
class ModelHome {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();

        


        $count = $this->db->query("SELECT COUNT(*) FROM books")->fetchColumn();
        if ($count == 0) {
            $this->db->exec("
INSERT INTO books (title, author, year, publisher, description, pages) VALUES
('1984', 'George Orwell', 1949, 'Secker & Warburg', 'A dystopian novel depicting a terrifying vision of a totalitarian future society controlled through surveillance, censorship, and propaganda.', 328),
('To Kill a Mockingbird', 'Harper Lee', 1960, 'J.B. Lippincott & Co.', 'This Pulitzer Prize-winning novel addresses serious issues like racial injustice and moral growth as seen through the eyes of a young girl in the Deep South.', 281),
('Fahrenheit 451', 'Ray Bradbury', 1953, 'Ballantine Books', 'Set in a future where books are outlawed and firemen burn any that are found, this story explores the consequences of censorship and loss of critical thought.', 194),
('Brave New World', 'Aldous Huxley', 1932, 'Chatto & Windus', 'A prophetic novel that delves into the dangers of a technologically advanced society that sacrifices individuality and freedom for stability and pleasure.', 268),
('Animal Farm', 'George Orwell', 1945, 'Secker & Warburg', 'An allegorical tale that critiques the corruption of socialist ideals in the Soviet Union through the uprising of farm animals against their human farmer.', 112),
('The Great Gatsby', 'F. Scott Fitzgerald', 1925, 'Charles Scribner''s Sons', 'A quintessential novel of the American Jazz Age, portraying the mysterious millionaire Jay Gatsby and his obsession with the beautiful Daisy Buchanan.', 180),
('The Catcher in the Rye', 'J.D. Salinger', 1951, 'Little, Brown and Company', 'A story about teenage angst and alienation told through the eyes of Holden Caulfield, a troubled youth navigating the challenges of adulthood.', 277),
('Lord of the Flies', 'William Golding', 1954, 'Faber and Faber', 'A powerful allegory about human nature, this novel portrays a group of boys stranded on an island who descend into savagery and chaos.', 224),
('Moby-Dick', 'Herman Melville', 1851, 'Harper & Brothers', 'A complex and symbolic narrative of Captain Ahab’s obsessive quest to kill the white whale, touching on themes of fate, vengeance, and the human spirit.', 635),
('Pride and Prejudice', 'Jane Austen', 1813, 'T. Egerton, Whitehall', 'A classic romance novel exploring the manners, upbringing, morality, and marriage in the society of early 19th-century England.', 279),
('The Hobbit', 'J.R.R. Tolkien', 1937, 'George Allen & Unwin', 'A hobbit’s unexpected journey with dwarves to reclaim a treasure guarded by a dragon. A tale of adventure and self-discovery.', 310),
('Frankenstein', 'Mary Shelley', 1818, 'Lackington, Hughes, Harding, Mavor & Jones', 'Victor Frankenstein creates life only to be horrified by what he has made, raising questions about science, responsibility, and humanity.', 280),
('The Picture of Dorian Gray', 'Oscar Wilde', 1890, 'Lippincott''s Monthly Magazine', 'A young man sells his soul for eternal youth, while his portrait bears the marks of his moral decay. A tale of vanity and corruption.', 254),
('Jane Eyre', 'Charlotte Brontë', 1847, 'Smith, Elder & Co.', 'The life of an orphaned girl who grows up to be a strong and independent woman. A story of love, morality, and resilience.', 500),
('Wuthering Heights', 'Emily Brontë', 1847, 'Thomas Cautley Newby', 'A haunting story of passion and revenge on the Yorkshire moors between Catherine and Heathcliff.', 416),
('Dracula', 'Bram Stoker', 1897, 'Archibald Constable and Company', 'The original vampire novel that defined a genre. A gripping tale of gothic horror, seduction, and the fight against evil.', 418),
('Crime and Punishment', 'Fyodor Dostoevsky', 1866, 'The Russian Messenger', 'A psychological drama about a young man who commits murder and must deal with the moral consequences of his actions.', 671),
('The Brothers Karamazov', 'Fyodor Dostoevsky', 1880, 'The Russian Messenger', 'An intense philosophical drama exploring faith, doubt, and reason, centered around a family torn by conflict.', 796),
('Les Misérables', 'Victor Hugo', 1862, 'A. Lacroix, Verboeckhoven & Cie.', 'An epic saga of redemption and justice in post-revolutionary France, centered on the life of ex-convict Jean Valjean.', 1232),
('Don Quixote', 'Miguel de Cervantes', 1605, 'Francisco de Robles', 'A nobleman obsessed with chivalric romances sets out on a comedic and tragic quest to revive knighthood.', 863);");

        }
    }

    public function getAllBooks() {
        $stmt = $this->db->query("SELECT * FROM books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchBooks($type, $query) {
        $allowed = ['titlu', 'autor', 'editura', 'an'];
        $query = urldecode($query);
        $query = trim(preg_replace('/\s+/', ' ', $query));
        if (!in_array($type, $allowed)) {
            throw null;
        }
        
        switch($type) {
            case 'titlu': $type = 'title'; break;
            case 'autor': $type = 'author'; break;
            case 'editura': $type = 'publisher'; break;
            case 'an': $type = 'year'; break;
        }
        
        if($type === 'an' && gettype($query) != 'integer') return [];
        $stmt = $this->db->prepare("SELECT * FROM books WHERE $type ILIKE ?");
        $searchTerm = '%' . $query . '%';
        $stmt->execute([$searchTerm]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function toogleBookFavorite($id)
    {       
        $nume = $_SESSION['user'];
        if($this->isBookFavorite($id))
        {
            $stmt = $this->db->prepare("DELETE FROM favorites WHERE name = ? AND book_id = ?");
            $stmt->execute([$nume, $id]);
        }
        else
        {
            $stmt = $this->db->prepare("INSERT INTO favorites (name, book_id) VALUES (?, ?)");
            $stmt->execute([$nume, $id]);
        }
    }
    
    public function isBookFavorite($id)
    {
        $nume = $_SESSION['user'];
        $stmt = $this->db->prepare("SELECT 1 FROM favorites WHERE name = ? AND book_id = ?");
        $stmt->execute([$nume, $id]);
        return (bool)$stmt->fetchColumn();
    }
    public function isBookFavoriteLink($link)
    {
        $id = $this->getExternalBookId($link);
        if($id == 0) return false;
        return $this->isBookFavorite($id);
    }
    
    public function getBookProgress($id)
    {
        $user = $_SESSION['user'];
        $stmt = $this->db->prepare("SELECT pages FROM progress WHERE book_id = ? and username = ?");
        $stmt->execute([$id, $user]);
        $pgs = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $pgs ? $pgs['pages'] : 0;
    }
    
    public function getBookAverage($id) {
        $stmt = $this->db->prepare("SELECT ROUND(AVG(rating)) as avg_rating FROM reviews WHERE book_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['avg_rating'] ?? 0;
    }
    
    public function getExternalBooks($type, $query)
    {
        $allowed = ['titlu', 'autor', 'editura', 'an'];
        $query = urldecode($query);
        $query = trim(preg_replace('/\s+/', ' ', $query));
        $queryType;
        switch ($type) {
            case 'titlu':
                $queryType = 'intitle';
                break;
            case 'autor':
                $queryType = 'inauthor';
                break;
            case 'editura':
                $queryType = 'inpublisher';
                break;
            default:
                $queryType = 'status';
                break;
        }
        $query= urlencode($query);
        $url = 'https://www.googleapis.com/books/v1/volumes?q=+'.$queryType.':'.$query.'&startIndex=0&maxResults=40';
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        return $data;
    }
    

    function getExternalBookId($link) {
        $stmt = $this->db->prepare("SELECT id FROM books WHERE link = ?");
        $stmt->execute([$link]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['id'] ?? 0;
    }
}
