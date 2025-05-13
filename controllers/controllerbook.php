<?php
class ControllerBook extends Controller {
    public function __construct($actiune, $parametri) {
        parent::__construct();

        if ($actiune === 'view' && isset($parametri[0])) {
            $this->viewBook($parametri[0]);
        } else if($actiune === 'submitReview') {
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
            $this->view->incarcaDatele("Cartea nu a fost găsită.");
            echo $this->view->oferaVizualizare();
        }
    }

    private function viewBook($id) {
        $user = $_SESSION['user'];
        $book = $this->model->getBookById($id);
        $reviews = $this->model->getBookReviews($id);
        $stars = $this->model->getBookAvarage($id);
        $pages = $this->model->getBookPages($id);   
        $progress = $this->model->getBookProgress($id, $user);   
        
        $average = 0;
        $values = array_column($stars, 'rating');
        if (!empty($values)) {
            $average = array_sum($values) / count($values);
        }
        $average = round($average, 1);     

        if (is_array($book) && !empty($book)) {
            $this->view->incarcaDatele($book, $reviews, $average, $pages, $progress, $id);
        } else {
            $this->view->incarcaDatele("Cartea cu ID-ul $id nu există.");
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
