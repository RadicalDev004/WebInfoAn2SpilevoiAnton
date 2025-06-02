<?php
define('DIRECTOR_SITE', __DIR__);
define('SLASH', DIRECTORY_SEPARATOR);

function autoload($class) {
    //echo "Searching for $class <br>";
    $folders = ['util', 'models', 'controllers', 'views', 'util'];
    foreach ($folders as $folder) {
        $file = DIRECTOR_SITE . SLASH . $folder . SLASH . strtolower($class) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return 1;
        }
    }
    echo "Nu găsesc clasa $class";
    
    return 0;
}
spl_autoload_register('autoload');
