<?php
class ControllerBook extends Controller {
    public function __construct($actiune, $parametri) {
        parent::__construct();

        if ($actiune === 'view' && isset($parametri[0])) {
            $this->viewBook($parametri[0]);
        } else if ($actiune === 'viewExternal' && isset($parametri[0])) {
            $encodedLink = urldecode($parametri[0]);
            $link = base64_decode($encodedLink);
            
            if (base64_decode($encodedLink, true) === false || empty($link) || !filter_var($link, FILTER_VALIDATE_URL)) {

                $this->view->incarcaDatele("Cartea nu a fost găsită.", null, null, null);
                echo $this->view->oferaVizualizare();
                return;
            }
            
            $this->viewExternalBook($link);
        } 
        else if($actiune === 'submitReview') {
            if(count($parametri) != 4)
            {
                
            } else {
                $this->submitReview($parametri[0],$parametri[1],$parametri[2],$parametri[3]);
                $id = $parametri[0];
                header("Location: /WebInfoAn2SpilevoiAnton/book/view/$id");
            }
        } else if($actiune === 'changeProgress')
        {
            $this->changeProgress($parametri[0], $parametri[1], $parametri[2]);
            $id = $parametri[0];
            header("Location: /WebInfoAn2SpilevoiAnton/book/view/$id");
        }
        else {
            $this->view->incarcaDatele("Cartea nu a fost găsită.", null, null, null);
            echo $this->view->oferaVizualizare();
        }
    }

    private function viewBook($id) {
        $user = $_SESSION['user'];
        $book = $this->model->getBookById($id);
        $reviews = $this->model->getBookReviews($id);
        $average = $this->model->getBookAverage($id);
        $pages = $this->model->getBookPages($id);   
        $progress = $this->model->getBookProgress($id, $user);   
        
        //debug::printArray($book);
        //echo $progress ;
         

        if (is_array($book) && !empty($book)) {
            $this->view->incarcaDatele($book, $reviews, $average, $pages, $progress, $id);
        } else {
            $this->view->incarcaDatele("Cartea cu ID-ul $id nu există.", null, null, null);
        }
        echo $this->view->oferaVizualizare();
    }
    
    private function viewExternalBook($link) {
        $user = $_SESSION['user'];
        $book = $this->model->getExternalBookData($link);
        $id = $this->model->getExternalBookId($link);
        
        $reviews = null;
        $average = null;
        $pages = $book['volumeInfo']['pageCount'] ?? 0;   
        $progress = 0; 
        
        //debug::printArray($book);
        
        if($id != 0)
        {
            $reviews = $this->model->getBookReviews($id);
            $average = $this->model->getBookAverage($id);
            $progress = $this->model->getBookProgress($id, $user);  
        }   
         

        if (is_array($book) && !empty($book)) {
            $this->view->incarcaDatele($book, $reviews, $average, $pages, $progress, $id, true, $link);
        } else {
            $this->view->incarcaDatele("Cartea cu ID-ul $id nu există." , null, null, nul);
        }
        echo $this->view->oferaVizualizare();
    }
    
    
    private function submitReview($id, $user, $text, $stars) {
        $this->model->postReview($id, $user, $text, $stars);
    }
    
    private function changeProgress($id, $user, $progress)
    {
        $this->model->setBookProgress($id, $user, $progress);
    }
}
