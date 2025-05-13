<?php
function safeHtml($array, $key, $default = '') {
    return isset($array[$key]) ? htmlspecialchars($array[$key]) : $default;
}
class ViewBook {
    private $template;
    private $vars = [];
    
    

    public function __construct() {
        $this->template = file_get_contents('templates/book.tpl');
    }

    public function incarcaDatele($bookData, $bookReviews, $average, $pages, $progress = 0, $id = -1) {
        $name = $_SESSION['user'] ?? 'guest';
        if (is_array($bookData)) {

            $reviewsHtml = '';
            if (!empty($bookReviews)) {
                foreach ($bookReviews as $review) {
                    $stars = str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']);
                    $reviewText = nl2br(htmlspecialchars($review['text']));
                    $user = htmlspecialchars($review['username']);
                    $date = isset($review['created_at']) ? htmlspecialchars($review['created_at']) : '';
    
                    $reviewsHtml .= "
                        <div style='border-bottom: 1px solid #eee; padding: 0.5em 0;'>
                            <div style='color: gold; font-size: 1.2em;'>$stars</div>
                            <small style='color: #555;'><b>$user</b> - $date</small>
                            <p style='margin: 0.3em 0;'>$reviewText</p>
                        </div>
                    ";
                }
            } else {
                $reviewsHtml = '<p>Nu există recenzii!</p>';
            }
            
        if (is_array($bookData)) {
            $this->vars = [
                '{{title}}' => safeHtml($bookData, 'titlu', '-'),
                '{{author}}' => safeHtml($bookData, 'autor', '-'),
                '{{year}}' => safeHtml($bookData, 'an', '-'),
                '{{publisher}}' => safeHtml($bookData, 'editura', '-'),
                '{{avarage_rating}}' => $average == 0 ? '-' : $average,
                '{{user_reviews}}' => $reviewsHtml,
                '{{book_id}}' => $id,
                '{{hide}}' => '',
                '{{username}}' => $name,
                '{{total_pages}}' => $pages,
                '{{pages_read}}' => $progress,
                '{{description}}' => array_key_exists('descriere', $bookData) ? nl2br(htmlspecialchars($bookData['descriere'])) : '-'
            ];
        } else {
            $this->vars = [
                '{{title}}' => 'Eroare',
                '{{author}}' => '',
                '{{year}}' => '',
                '{{publisher}}' => '',
                '{{avarage_rating}}' => '',
                '{{hide}}' => 'style="display:none; !important;"',
                '{{description}}' => $bookData
            ];
        }
    }
}

    public function oferaVizualizare() {
        return str_replace(array_keys($this->vars), array_values($this->vars), $this->template);
    }
    
    
}
