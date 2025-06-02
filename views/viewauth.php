<?php
class ViewAuth {
    private $message;

    public function incarcaDatele($message) {
        $this->message = $message;
    }

    public function oferaVizualizare() {
        // Render the existing HTML template file
        ob_start();
        readfile("templates/auth.tpl");
        $output = ob_get_clean();

        // Append a <script> tag at the end (after the HTML)
        $output .= "<script>alert('" . addslashes($this->message ?? "unknown error") . "');</script>";

        return $output;
    }
}
