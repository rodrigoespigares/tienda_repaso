<?php

session_start();
isset($_SESSION['carrito'])?"":$_SESSION['carrito']=[];

require_once '../vendor/autoload.php';
require_once '../config/config.php';


$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__,1));
$dotenv->safeLoad();
Routes\Routes::index();