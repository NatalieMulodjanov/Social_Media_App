<?php
session_start();
if (isset($_SESSION['tmezone'])){
    date_default_timezone_set($_SESSION['tmezone']);
} else {
    date_default_timezone_set("America/Montreal");
}
//inclusions 
include('core/autoload.php');

$path = getcwd().'/';

$path = str_replace('\\', '/', $path);
$path = preg_replace('/^.+\/htdocs\//', '/', $path);
$path = preg_replace('/\/+/', '/', $path);

define('BASE', $path);
require("core/phpqrcode/qrlib.php");