<?php
session_start();
require_once 'autoload.php';

$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if ($request === '' || $request === basename(__DIR__)) {
    header("Location: /project/auth/status");
    exit;
}

$parts = explode('/', $request);

$controller = !empty($parts[1]) ? ucfirst($parts[1]) : 'auth';
$actiune = $parts[2] ?? 'status';
$paramList = array_slice($parts, 2);

$controllerClass = 'Controller' . $controller;

if (class_exists($controllerClass)) {
    $ctrl = new $controllerClass($actiune, $paramList);
} else {
    echo "Controllerul '$controllerClass' nu există.";
}
