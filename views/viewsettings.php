<?php
class ViewSettings {
    private $templatePath = 'templates/settings.tpl';
    private $vars = [];

    public function incarcaDatele($username, $stats) {
        $this->vars = [
            '{{title}}' => 'Setări utilizator',
            '{{username}}' => htmlspecialchars($username),
            '{{startedBooks}}' => $stats['started'],
            '{{finishedBooks}}' => $stats['finished'],
            '{{commentsCount}}' => $stats['comments'],
            '{{favoritesCount}}' => $stats['favorites'],
            '{{loginButton}}' => ''
        ];
    }

    public function renderLogin() {
        $this->vars = [
            '{{title}}' => 'Login Required',
            '{{username}}' => '',
            '{{startedBooks}}' => '',
            '{{finishedBooks}}' => '',
            '{{commentsCount}}' => '',
            '{{favoritesCount}}' => '',
            '{{loginButton}}' => '<a href="/WebInfoAn2SpilevoiAnton/auth/login"><button>Login</button></a>'
        ];
        return $this->render();
    }

    public function oferaVizualizare() {
        $html = file_get_contents($this->templatePath);
        foreach ($this->vars as $placeholder => $value) {
            $html = str_replace($placeholder, $value, $html);
        }
        return $html;
    }
}
?>
