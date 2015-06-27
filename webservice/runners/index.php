<?php
 
require_once('../Slim/Slim.php');
require_once('config.php');
 
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->response()->header('Content-Type', 'application/json;charset=utf-8');

include ('corridas.php');
include ('corredores.php');
include ('inscricoes.php');
include ('funcoes.php');

$app->run();

?>