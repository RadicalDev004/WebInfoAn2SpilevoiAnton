<?php
class ControllerHome extends Controller {

    public function __construct($actiune, $parametri) {
        parent::__construct();
        $this->actiune = $actiune;
        $this->parametri = $parametri;
        
        if(!isset($_SESSION['user'])) {
            header("Location: /WebInfoAn2SpilevoiAnton/auth/login");
        }

        if ($actiune === 'index') {
            $this->index();
        } else if ($actiune === 'search') {
            //debug::printArray($parametri);
            $this->search($parametri[0], $parametri[1]);
        }
        else if ($actiune === 'toggleFavorite') {
            //debug::printArray($parametri);
            $this->toggleFavorite($parametri[0]);
            $from = $parametri[1];
            $params = implode('/', array_slice($parametri, 2)); 
            
            $info = $params === '' ? $from : "$from/$params";
            
            header("Location: /WebInfoAn2SpilevoiAnton/home/$info");
        }
        else if ($actiune === 'favorites') {
            if(is_array($parametri) && count($parametri) >= 1) {
                header("Location: /WebInfoAn2SpilevoiAnton/home/favorites");
            }
            $this->index(true);
        }
        else if ($actiune === 'unfinished') {
            if(is_array($parametri) && count($parametri) >= 1) {
                header("Location: /WebInfoAn2SpilevoiAnton/home/unfinsihed");
            }
            $this->index(false , true);
        }
        else if ($actiune === 'top') {
            if(is_array($parametri) && count($parametri) >= 1) {
                header("Location: /WebInfoAn2SpilevoiAnton/home/top");
            }
            $this->index(false , false ,true);
        }
        else if ($actiune === 'rss') {
            if(is_array($parametri) && count($parametri) >= 1) {
                header("Location: /WebInfoAn2SpilevoiAnton/home/rss");
            }
            $this->rss();
        }
        else {
            header("Location: /WebInfoAn2SpilevoiAnton/home/index");
        }
    }

    public function index($fav = false, $unfinished = false, $top = false) {
        $books = $top ?  $this->model->getAllBooksTop() : $this->model->getAllBooks();
        //debug::printArray($books);
        $letters = range('a', 'z');
        $randomLetter = $letters[array_rand($letters)];
        $externalBooks = ($fav || $unfinished || $top) ? [] : $this->model->getExternalBooks('', $randomLetter);
        $this->view->incarcaDatele($books, $externalBooks, $this->model, $this->actiune , $this->parametri, $fav, $unfinished, $top);
        echo $this->view->oferaVizualizare();
        
    }

    public function search($type, $query) {
        $books = $this->model->searchBooks($type, $query);
        $externalBooks = $this->model->getExternalBooks($type, $query);
        $this->view->incarcaDatele($books, $externalBooks, $this->model, $this->actiune , $this->parametri, false, false, false, true, $query);
        echo $this->view->oferaVizualizare();        
    }
    
    public function toggleFavorite($id) {
        $books = $this->model->toogleBookfavorite($id);
    }
    
    public function rss()
    {
        $rssContent = file_get_contents('http://localhost/WebInfoAn2SpilevoiAnton/api/rss.php');
        header("Content-Type: application/rss+xml; charset=UTF-8");
        echo $rssContent;
    }
}
