<?php
class ViewHome {
    private $templatePath = 'templates/home.tpl';
    private $vars = [];

    public function incarcaDatele($books, $model, $from, $parametri, $favo = false, $search = false, $searchTerm = "") {
        $cardsHtml = '';
        //debug::printArray($books);
        $cnt = 0;

        foreach ($books as $book) {
            $fav = $model->isBookFavorite($book['id']);
            if($favo && !$fav) continue;
            $selectedClass = $fav ? 'selected' : '';
            $progressPercent = $model->getBookProgress($book['id']) / $book['pagini'] * 100;
            if($progressPercent == 0) $progressPercent = 1;
            $cardsHtml .= "
    <div class='book-card'>
        <div style='width: 100%; height: 250px; background-color: #e0e0e0; border-radius: 4px;
                    display: flex; align-items: center; justify-content: center; color: #777; font-size: 1.2em; margin-bottom: 0.5em;'>
            Copertă
        </div>

        <h3>" . htmlspecialchars($book['titlu']) . "</h3>
        <p><strong>Autor:</strong> " . htmlspecialchars($book['autor']) . "</p>
        <p><strong>An:</strong> " . htmlspecialchars($book['an']) . "</p>
        <p><strong>Rating: </strong>3/5★</p>

        <!-- Progress Slider -->
        <div style='display: flex; align-items: center; gap: 0.5em; margin-top: 10px;'>
            <input type='range' min='0' max='100' value='" . $progressPercent . "'
                   style='flex: 1; pointer-events: none; appearance: none; height: 8px; border-radius: 5px;
                          background: linear-gradient(to right, #0073e6 " . $progressPercent . "%, #e0e0e0 " . $progressPercent . "%);' />
        </div>

        <div style='display: flex; justify-content: space-between; align-items: center; margin-top: 10px;'>
            <a href='/WebInfoAn2SpilevoiAnton/book/view/" . urlencode($book['id']) . "'>
                <button>Vezi detalii</button>
            </a>

            <button type='button' style='font-size: 2em;'
                class='star-button $selectedClass'
                onclick='toggleFavorite(this)'
                data-book-id='" . $book['id'] . "'>
                ★
            </button>
        </div>
    </div>
";

            $cnt = $cnt + 1;
        }
        $backfromsearch = "<button type='button'
            onclick=\"window.location.href='/WebInfoAn2SpilevoiAnton/home/index'\"
            style='padding: 0.5em 1em; background-color: #555; color: white; border: none; border-radius: 4px; cursor: pointer;'>
            X
        </button>";
        
        $title = 'Lecturi';
        $emptyInfo = '';
        
        if($search){
            $title = 'Caută';
            $emptyInfo = '<h2>Nu există nicio carte care sa se conțină "'.$searchTerm.'"!</h2>';
        } 
        if($favo) {
            $title = 'Favorite';
            $emptyInfo = '<h2>Nu ai nicio carte la favorite!</h2>';
        }
        

        $this->vars = [
            '{{title}}' => 'Catalog Cărți',
            '{{headerTitle}}' => $title,
            '{{bookCards}}' => $cnt > 0 ? $cardsHtml : $emptyInfo,
            '{{back_from_search}}' => $search ? $backfromsearch : '',
            '{{from}}' => $from,
            '{{favorites_selected}}' => $from === 'favorites' ? 'gold' : '#aaa',
            '{{favorites_button_action}}' => $from === 'favorites' ? 'index' : 'favorites',
            '{{params}}' => is_array($parametri) ? '/'.implode('/', $parametri) : ''
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
