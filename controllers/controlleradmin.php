<?php

class ControllerAdmin extends Controller {
    private $actiune;
    private $parametri;

    public function __construct($actiune, $parametri) {
        parent::__construct();
        $this->actiune = $actiune;
        $this->parametri = $parametri;

        //$data = JWT::verifyAndResend();
        //$user = $data['username'];

        if (!isset($_COOKIE['is_admin']) || $_COOKIE['is_admin'] !== '1') {
            header('Location: /auth/status');
            exit;
        }

        if ($actiune === 'index') {
            $this->index($parametri[0] ?? "users");
        } else {
            header('Location: /admin/index');
        }
    }

    private function index($table) {
        $tables = $this->model->getTables();
        //debug::printArray($tables);
        $selectedTable = $table ?? null;
        $rows = [];

        if ($selectedTable && in_array($selectedTable, $tables)) {
            $rows = $this->model->getTableData($selectedTable);
            //debug::printArray($rows);
        }

        $this->view->incarcaDatele($tables, $selectedTable, $rows);
        echo $this->view->oferaVizualizare();
    }
}
