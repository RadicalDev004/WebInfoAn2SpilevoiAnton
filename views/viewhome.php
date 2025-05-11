<?php
class ViewHome {
    private $templatePath = 'templates/home.tpl';
    private $vars = [];

    public function incarcaDatele($books, $search = false) {
        $cardsHtml = '';
        //debug::printArray($books);

        foreach ($books as $book) {
            $cardsHtml .= "
                <div class='book-card'>
                    <h3>" . htmlspecialchars($book['titlu']) . "</h3>
                    <p><strong>Autor:</strong> " . htmlspecialchars($book['autor']) . "</p>
                    <p><strong>An:</strong> " . htmlspecialchars($book['an']) . "</p>
                    <a href='/WebInfoAn2SpilevoiAnton/book/view/" . urlencode($book['id']) . "'>
                        <button style='margin-top:10px;'>Vezi detalii</button>
                    </a>
                </div>
            ";
        }
        $backfromsearch = "<button type='button'
            onclick=\"window.location.href='/WebInfoAn2SpilevoiAnton/home/index'\"
            style='padding: 0.5em 1em; background-color: #555; color: white; border: none; border-radius: 4px; cursor: pointer;'>
            X
        </button>";

        $this->vars = [
            '{{title}}' => 'Catalog Cărți',
            '{{headerTitle}}' => 'Lecturi',
            '{{bookCards}}' => $cardsHtml ,
            '{{back_from_search}}' => $search ? $backfromsearch : ''
        ];
    }

    public function oferaVizualizare() {
        $html = file_get_contents($this->templatePath);
        foreach ($this->vars as $placeholder => $value) {
            $html = str_replace($placeholder, $value, $html);
        }
        return $html;
    }
}
