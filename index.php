<?php 
session_start();
use App\App;

include "autoload.php";
include "App/Helpers/helpers.php";
include "web.php";

$app = new App();
echo $app->run();