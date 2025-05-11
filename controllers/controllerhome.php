<?php
class ControllerHome extends Controller {
    public function __construct($actiune, $parametri) {
        parent::__construct();

        if ($actiune === 'index') {
            $this->index();
        } elseif ($actiune === 'search') {
            //debug::printArray($parametri);
            $this->search($parametri[0]);
        }
    }

    public function index() {
        $books = $this->model->getAllBooks();
        $this->view->incarcaDatele($books);
        echo $this->view->oferaVizualizare();
    }

    public function search($query) {
        $books = $this->model->searchBooks($query);
        $this->view->incarcaDatele($books, true);
        echo $this->view->oferaVizualizare();
    }
}
