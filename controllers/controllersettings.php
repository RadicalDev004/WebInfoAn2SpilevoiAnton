<?php

class ControllerSettings extends Controller {
    private $actiune;
    private $parametri;
    public function __construct($actiune, $parametri) {
        parent::__construct();
        $this->actiune = $actiune;
        $this->parametri = $parametri;
        
        $data = JWT::verifyAndResend();
        $name = $data['username'];
        
        switch ($actiune) {
            case 'index':
                $username = $name ?? null;
                if ($username) {
                    $stats = $this->model->getUserStats($username);
                    $this->view->incarcaDatele($username, $stats);
                    echo $this->view->oferaVizualizare();
                }
                break;
                case 'export':
                    $username = $name ?? null;
                    if ($username) {
  
                        $data = $this->model->getBooksExportData($username);
    
                        header('Content-Type: text/csv; charset=utf-8');
                        header('Content-Disposition: attachment; filename=books_export.csv');
    
                        $output = fopen('php://output', 'w');
                        fputcsv($output, ['BookLink', 'BookName', 'BookPages', 'PagesRead', 'IsBookFavorite', 'AvarageReviews']);
                        foreach ($data as $row) {
                            fputcsv($output, $row);
                        }
                        fclose($output);
                        exit;
                    } else {
                        echo "Trebuie să fii logat pentru a exporta datele!";
                    }
                    break;
            default:
                echo "Acțiune invalidă!";
        }
    }
}
?>
