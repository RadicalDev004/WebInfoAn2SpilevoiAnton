<?php

class ControllerSettings extends Controller {
    public function __construct($actiune, $parametri) {
        parent::__construct();
        $this->actiune = $actiune;
        $this->parametri = $parametri;
        
        switch ($actiune) {
            case 'index':
                $username = $_SESSION['user'] ?? null;
                if ($username) {
                    $stats = $this->model->getUserStats($username);
                    $this->view->incarcaDatele($username, $stats);
                    echo $this->view->oferaVizualizare();
                }
                break;
            default:
                echo "Acțiune invalidă!";
        }
    }
}
?>
