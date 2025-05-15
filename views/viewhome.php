<?php
class ViewHome {
    private $templatePath = 'templates/home.tpl';
    private $vars = [];

    public function incarcaDatele($books, $externalBooks, $model, $from, $parametri, $favo = false, $search = false, $searchTerm = "") {
        $cardsHtml = '';
        $extraCardsHtml = '';
        //debug::printArray($books);
        $cnt = 0;

        foreach ($books as $book) {
            $fav = $model->isBookFavorite($book['id']);
            if($favo && !$fav) continue;
            $selectedClass = $fav ? 'selected' : '';
            $progressPercent = $model->getBookProgress($book['id']) / $book['pagini'] * 100;
            $stars = $model->getBookAverage($book['id']);
            if($progressPercent == 0) $progressPercent = 1;
            if($stars == 0) $stars = '-';
            $cardsHtml .= "
    <div class='book-card'>
        <div style='width: 100%; height: 250px; background-color: #e0e0e0; border-radius: 4px;
                    display: flex; align-items: center; justify-content: center; color: #777; font-size: 1.2em; margin-bottom: 0.5em;'>
            Copertă
        </div>

        <h3>" . htmlspecialchars($book['titlu']) . "</h3>
        <p><strong>Autor:</strong> " . htmlspecialchars($book['autor']) . "</p>
        <p><strong>An:</strong> " . htmlspecialchars($book['an']) . "</p>
        <p><strong>Editura:</strong> " . htmlspecialchars($book['editura']) . "</p>
        <p style='color: gold;'><strong style='color: black;'>Rating: </strong><b>$stars</b>/5★</p>

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
        //debug::printArray($externalBooks);
        if(!empty($externalBooks))
        foreach ($externalBooks['items'] as $book) {
 
            $extraCardsHtml .= "
    <div class='book-card'>
        <div style='width: 100%; height: 250px; border-radius: 4px; overflow: hidden; margin-bottom: 0.5em;'>
            <img src='".($book['volumeInfo']['imageLinks']['thumbnail'] ?? '')."' alt='Copertă'
            style='width: 100%; height: 100%; object-fit: cover; display: block;'
         onerror=\"this.style.display='none'; this.parentElement.innerHTML='<div style=\\'width: 100%; height: 100%; background-color: #e0e0e0; display: flex; align-items: center; justify-content: center; color: #777; font-size: 1.2em;\\'>Copertă</div>';\">
        </div>

        <h3>" . ($book['volumeInfo']['title'] ?? '-') . "</h3>
        <p><strong>Autor:</strong> " . ($book['volumeInfo']['authors'][0] ?? '-') . "</p>
        <p><strong>An:</strong> " . ($book['volumeInfo']['publishedDate'] ?? '-') . "</p>
        <p><strong>Editura:</strong> " . ($book['volumeInfo']['publisher'] ?? '-') . "</p>

        <div style='display: flex; justify-content: space-between; align-items: center; margin-top: 10px;'>
            <a href='".($book['volumeInfo']['infoLink'] ?? '') . "'target='_blank' rel='noopener noreferrer'>
                <button>Vezi detalii</button>
            </a>
        </div>
    </div>
";
        }
        $backfromsearch = "<button type='button'
            onclick=\"window.location.href='/WebInfoAn2SpilevoiAnton/home/index'\"
            style='padding: 0.5em 1em; background-color: #555; color: white; border: none; border-radius: 4px; cursor: pointer;'>
            X
        </button>";
        
        $title = 'Lecturi';
        $emptyInfo = '';
        $searchType = isset($parametri[0]) ? $parametri[0] : 'titlu';
        
        $searchTerm = urldecode($searchTerm);
        
        if($search){
            $title = 'Caută';
            $emptyInfo = "<h2>Nu există nicio carte care sa se conțină '<b>$searchTerm</b>' in <b>$searchType</b>!</h2>";
        } 
        if($favo) {
            $title = 'Favorite';
            $emptyInfo = '<h2>Nu ai nicio carte la favorite!</h2>';
        }
        

        $this->vars = [
            '{{title}}' => 'Catalog Cărți',
            '{{headerTitle}}' => $title,
            '{{search_term}}' => $searchTerm,
            '{{search_type}}' => $searchType,
            '{{bookCards}}' => $cnt > 0 ? $cardsHtml : $emptyInfo,
            '{{extra_bookCards}}' => $extraCardsHtml,
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
