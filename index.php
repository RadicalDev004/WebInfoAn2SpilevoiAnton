<?php
session_start();
require_once 'autoload.php';

$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($request === '' || $request === basename(__DIR__)) {
    header("Location: /auth/status");
    exit;
}

$parts = explode('/', $request);

$controller = !empty($parts[0]) ? ucfirst($parts[0]) : 'auth';
$actiune = $parts[1] ?? 'status';
$paramList = array_slice($parts, 2);

$controllerClass = 'Controller' . $controller;
//echo $controllerClass;
if($controller === "imgs") exit;
if (class_exists($controllerClass)) {
    $ctrl = new $controllerClass($actiune, $paramList);
} else {
    //echo "Controllerul '$controllerClass' nu există.";
    header("Location: /home/status");
}
