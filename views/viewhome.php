<?php
class ViewHome {
    private $templatePath = 'templates/home.tpl';
    private $vars = [];

    public function incarcaDatele($books, $externalBooks, $model, $from, $parametri, $favo = false, $unfinished = false, $top = false, $search = false, $searchTerm = "") {
        $cardsHtml = '';
        $extraCardsHtml = '';
        //debug::printArray($books);
        $cnt = 0;

        foreach ($books as $book) {
            $data = null;
            $externalFav = false;
            $externalUnf = false;
            $externalTop = false;
            $externalProgress = 0;
            
            //debug::printArray($book);
            
            if(isset($book['link']) && !empty($book['link'])){
                if($model->isBookFavorite($book['id']) && $favo)
                {
                    $data = $model->getExternalBookData($book['link']);
                    $externalFav = true;
                    $externalProgress =  $data['volumeInfo']['pageCount'] != 0 ? $model->getBookProgress($book['id']) / $data['volumeInfo']['pageCount'] * 100 : 0;
                }
                else if($model->hasBookProgress($book['id']) && $unfinished)
                {
                    $data = $model->getExternalBookData($book['link']);
                    $externalUnf = true;
                    $externalProgress =  $data['volumeInfo']['pageCount'] != 0 ? $model->getBookProgress($book['id']) / $data['volumeInfo']['pageCount'] * 100 : 0;
                }
                else if($top)
                {
                    $data = $model->getExternalBookData($book['link']);
                    $externalTop = true;
                    $externalProgress =  $data['volumeInfo']['pageCount'] != 0 ? $model->getBookProgress($book['id']) / $data['volumeInfo']['pageCount'] * 100 : 0;
                }
                else continue;
            }
            $fav = $model->isBookFavorite($book['id']);
            if($favo && !$fav) continue;
            if($unfinished && !$model->hasBookProgress($book['id'])) continue;
            
            $selectedClass = $fav ? 'selected' : '';
            $progressPercent = $book['pages'] != 0 ? $model->getBookProgress($book['id']) / $book['pages'] * 100 : 0;
            if($externalProgress != 0) $progressPercent = $externalProgress;
            $stars = $model->getBookAverage($book['id']);
            
            
            
            if($progressPercent == 0) $progressPercent = 1;
            if($stars == 0) $stars = '-';
            $cardsHtml .= "
    <div class='book-card".($externalFav || $externalUnf || $externalTop ? " external-card" : "")."'>
        <div style='width: 100%; height: 250px; border-radius: 4px; overflow: hidden; margin-bottom: 0.5em;'>
            <img src='".($data['volumeInfo']['imageLinks']['thumbnail'] ?? '')."' alt='Copertă'
            style='width: 100%; height: 100%; object-fit: cover; display: block;'
         onerror=\"this.style.display='none'; this.parentElement.innerHTML='<div style=\\'width: 100%; height: 100%; background-color: #e0e0e0; display: flex; align-items: center; justify-content: center; color: #777; font-size: 1.2em;\\'>Copertă</div>';\">
        </div>

        <h3>" . htmlspecialchars($externalFav || $externalUnf || $externalTop  ? $data['volumeInfo']['title'] : $book['title']) . "</h3>
        <p><strong>Autor:</strong> " . htmlspecialchars($externalFav || $externalUnf || $externalTop  ? ($data['volumeInfo']['authors'][0] ?? '-') : $book['author']) . "</p>
        <p><strong>An:</strong> " . htmlspecialchars($externalFav || $externalUnf || $externalTop  ? $data['volumeInfo']['publishedDate'] : $book['year']) . "</p>
        <p><strong>Editura:</strong> " . htmlspecialchars($externalFav || $externalUnf || $externalTop  ? $data['volumeInfo']['publisher'] : $book['publisher']) . "</p>
        <p style='color: gold;'><strong style='color: white;'>Rating: </strong><b>$stars</b>/5★</p>

        <!-- Progress Slider -->
        <div style='display: flex; align-items: center; gap: 0.5em; margin-top: 10px;'>
    <input type='range' min='0' max='100' value='" . $progressPercent . "'
           style='
               flex: 1;
               pointer-events: none;
               appearance: none;
               height: 8px;
               border-radius: 5px;
               background: linear-gradient(to right,rgb(17, 132, 247) " . $progressPercent . "%, #ffffff " . $progressPercent . "%);
           ' />
</div>


        <div style='display: flex; justify-content: space-between; align-items: center; margin-top: 10px;'>
            <a href=".($externalFav || $externalUnf || $externalTop  
            ? "'/WebInfoAn2SpilevoiAnton/book/viewExternal/" . urlencode(base64_encode($book['link']))  
            : "'/WebInfoAn2SpilevoiAnton/book/view/" . urlencode($book['id'])) . "'>
            <button style='
                padding: 0.4em 1em;
                background-color: rgb(37, 99, 235);
                border: none;
                color: white;
                border-radius: 6px;
                font-weight: bold;
                font-size: 0.9em;
                cursor: pointer;
                transition: background-color 0.3s ease, transform 0.2s ease;
                transform: translateY(0px);
            ' 
            onmouseover=\"this.style.backgroundColor='#3b82f6'; this.style.transform='translateY(-2px)';\" 
            onmouseout=\"this.style.backgroundColor='#2563eb'; this.style.transform='translateY(0)';\">
                Vezi detalii
            </button>
            </a>

            <button type='button' style='font-size: 2em;'
                class='star-button $selectedClass'
                onclick='toggleFavorite(this)'
                data-book-id='" . $book['id'] . "'>
                ★
            </button>
        </div>".($externalFav || $externalUnf || $externalTop  ? "<div class='link-extern'>
        <a href='".($data['volumeInfo']['infoLink'] ?? '')."' target='_blank' rel='noopener noreferrer'>
            <button>Link extern</button>
        </a> </div>" : "")."
    </div>
";

            $cnt = $cnt + 1;
        }
        //debug::printArray($externalBooks);
        if(!empty($externalBooks))
        foreach ($externalBooks['items'] as $book) {
            $fav = $model->isBookFavoriteLink($book['selfLink']);
            $progressPercent = ($book['volumeInfo']['pageCount'] ?? 0) == 0 ? 0 : $model->getExternalBookProgress($book['selfLink']) / $book['volumeInfo']['pageCount'] * 100;
            //$stars = $model->getBookAverage($book['id']);
            $stars = $model->getExternalAverage($book['selfLink']);
            if($stars == 0) $stars = '-';
            if($progressPercent == 0) $progressPercent = 1;
            $selectedClass = $fav ? 'selected' : '';
            $extraCardsHtml .= "
    <div class='book-card external-card'>
        <div style='width: 100%; height: 250px; border-radius: 4px; overflow: hidden; margin-bottom: 0.5em;'>
            <img src='".($book['volumeInfo']['imageLinks']['thumbnail'] ?? '')."' alt='Copertă'
            style='width: 100%; height: 100%; object-fit: cover; display: block;'
         onerror=\"this.style.display='none'; this.parentElement.innerHTML='<div style=\\'width: 100%; height: 100%; background-color: #e0e0e0; display: flex; align-items: center; justify-content: center; color: #777; font-size: 1.2em;\\'>Copertă</div>';\">
        </div>

        <h3>" . ($book['volumeInfo']['title'] ?? '-') . "</h3>
        <p><strong>Autor:</strong> " . ($book['volumeInfo']['authors'][0] ?? '-') . "</p>
        <p><strong>An:</strong> " . ($book['volumeInfo']['publishedDate'] ?? '-') . "</p>
        <p><strong>Editura:</strong> " . ($book['volumeInfo']['publisher'] ?? '-') . "</p>
        <p style='color: gold;'><strong style='color: white;'>Rating: </strong><b>$stars</b>/5★</p>
        
        <!-- Progress Slider -->
        <div style='display: flex; align-items: center; gap: 0.5em; margin-top: 10px;'>
            <input type='range' min='0' max='100' value='" . $progressPercent . "'
                   style='flex: 1; pointer-events: none; appearance: none; height: 8px; border-radius: 5px;
                          background: linear-gradient(to right, #0073e6 " . $progressPercent . "%, #e0e0e0 " . $progressPercent . "%);' />
        </div>

        <div style='display: flex; justify-content: space-between; align-items: center; margin-top: 10px;'>
            <a href='/WebInfoAn2SpilevoiAnton/book/viewExternal/" . urlencode(base64_encode($book['selfLink'])) . "'>
                <button>Vezi detalii</button>
            </a>
            
            <button type='button' style='font-size: 2em;'
                class='star-button $selectedClass'
                onclick='toggleFavoriteExternal(this, \"".$book['selfLink']."\" )'
                data-book-id='external'>
                ★
            </button>
        </div>
        
        <div class='link-extern'>
        <a href='".($book['volumeInfo']['infoLink'] ?? '')."' target='_blank' rel='noopener noreferrer'>
            <button>Link extern</button>
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
        if($unfinished) {
            $title = 'Istoric';
            $emptyInfo = '<h2>Nu ai nicio carte începută incă!</h2>';
        }
        if($top) {
            $title = 'Top';
            $emptyInfo = '<h2>Nu ai nicio carte în top incă!</h2>';
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
            '{{favorites_selected2}}' => $from === 'unfinished' ? 'blue' : '#aaa',
            '{{favorites_selected3}}' => $from === 'top' ? 'green' : '#aaa',
            '{{favorites_button_action}}' => $from === 'favorites' ? 'index' : 'favorites',
            '{{unfinished_button_action}}' => $from === 'unfinished' ? 'index' : 'unfinished',
            '{{top_button_action}}' => $from === 'top' ? 'index' : 'top',
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
