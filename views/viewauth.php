<?php
class ViewAuth {
    private $message;

    public function incarcaDatele($message) {
        $this->message = $message;
    }

    public function oferaVizualizare() {
        return "<h2>$this->message</h2>";
    }
}
