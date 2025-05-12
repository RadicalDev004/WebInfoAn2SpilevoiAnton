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

    public function incarcaDatele($bookData, $id = -1) {
        if (is_array($bookData)) {
            $this->vars = [
                '{{title}}' => safeHtml($bookData, 'titlu', '-'),
                '{{author}}' => safeHtml($bookData, 'autor', '-'),
                '{{year}}' => safeHtml($bookData, 'an', '-'),
                '{{publisher}}' => safeHtml($bookData, 'editura', '-'),
                '{{avarage_rating}}' => safeHtml($bookData, 'rating', '-'),
                '{{user_reviews}}' => 'Nu exista recenzii!',
                '{{book_id}}' => $id,
                '{{hide}}' => '',
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

    public function oferaVizualizare() {
        return str_replace(array_keys($this->vars), array_values($this->vars), $this->template);
    }
    
    
}
