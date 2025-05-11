<?php
class ControllerAuth extends Controller {
    public function __construct($actiune, $parametri) {
        parent::__construct();

        if ($actiune == "login") {
             $this->login($_POST['username'], $_POST['password']);
        } elseif ($actiune == "logout") {
        } elseif ($actiune == "register") {
             $this->register($_POST['username'], $_POST['password']);
        } elseif ($actiune == "status") {
            $html = file_get_contents("templates/auth.tpl");
            $html = str_replace("{{title}}", "Autentificare", $html);
            echo $html;
        }
        else {
            
        }
    }

    public function login($username, $password) {
        if ($this->model->autentifica($username, $password)) {
            //$this->view->incarcaDatele("Autentificare reușită! Bine ai venit, $username.");    
            header("Location: /WebInfoAn2SpilevoiAnton/home/index");     
        } else {
            $this->view->incarcaDatele("Autentificare eșuată. Verifică datele.");
        }
        echo $this->view->oferaVizualizare();
    }

    public function logout() {
        $this->model->logout();
        $this->view->incarcaDatele("Ai fost delogat.");
        echo $this->view->oferaVizualizare();
    }

    public function verificaAutentificare() {
        if ($this->model->esteAutentificat()) {
            $this->view->incarcaDatele("Utilizator autentificat: " . $_SESSION['user']);
        } else {
            $this->view->incarcaDatele("Niciun utilizator autentificat.");
        }
        echo $this->view->oferaVizualizare();
    }
    
    public function register($username, $password) {
        if($this->model->inregistreaza($username, $password))
        {  
            $this->view->incarcaDatele("Contul a fost înregistrat cu succes (simulat).");
        }
        else {
            $this->view->incarcaDatele("Exista deja un cont cu acel username.");
        }
        echo $this->view->oferaVizualizare();
    }

}
