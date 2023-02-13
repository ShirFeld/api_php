<?php

declare(strict_types=1);

// session_start();

// if ($_SESSION['id'] ==''){
//     header("location:signup.html");
// }


function __autoload($class){ 
    // __DIR__ -> get the current script's directory
    require __DIR__ . "/src/$class.php";
};


set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException"); // how errors will be handled -> by ErrorHandler

header("Content-type: application/json; charset=UTF-8"); // convert the output to json



$parts = explode("/" , $_SERVER["REQUEST_URI"]); // takes the url and convert it to an array
if($parts[4] != "products"){
    http_response_code(404);
    exit;
}
$id = $parts[5] ?? null;



$database = new Database("localhost" , "articles" , "root" , "");
$gateway = new ArticleGateway($database);

$controller = new ArticleController($gateway);
$controller->processRequest($_SERVER["REQUEST_METHOD"] , $id);