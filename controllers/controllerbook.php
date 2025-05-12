<?php
class ControllerBook extends Controller {
    public function __construct($actiune, $parametri) {
        parent::__construct();

        if ($actiune === 'view' && isset($parametri[0])) {
            $this->viewBook($parametri[0]);
        } else {
            $this->view->incarcaDatele("Cartea nu a fost găsită.");
            echo $this->view->oferaVizualizare();
        }
    }

    private function viewBook($id) {
        $book = $this->model->getBookById($id);

        if (is_array($book) && !empty($book)) {
            $this->view->incarcaDatele($book, $id);
        } else {
            $this->view->incarcaDatele("Cartea cu ID-ul $id nu există.");
        }
        echo $this->view->oferaVizualizare();
    }
}
