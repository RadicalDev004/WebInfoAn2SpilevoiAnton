<?php
class ViewAuth {
    private $message;

    public function incarcaDatele($message) {
        $this->message = $message;
    }

    public function oferaVizualizare($title) {
        ob_start();
        readfile("templates/auth.tpl");
        $output = ob_get_clean();
        $output = str_replace("{{title}}", $title,$output);

        $output .= "<script>alert('" . addslashes($this->message ?? "unknown error") . "');</script>";

        return $output;
    }
}
