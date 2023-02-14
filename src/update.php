<?php
echo "update";
require "Database.php" ;
require "ArticleGateway.php";
require "ArticleController.php";


session_start();
if(($_SESSION['id'] =='')){
    header("location: login.php");
}

$parts = explode("/" , $_SERVER["REQUEST_URI"]); // takes the url and convert it to an array
$idFromUrl = $parts[5] ?? null;
// print_r($parts);
// echo $id;


$database = new Database("localhost" , "articles" , "root" , "");
$gateway = new ArticleGateway($database);
$controller = new ArticleController($gateway);
?>

<html lang="en">
<head>
  <title>Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
</style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <ul class="nav navbar-nav">


    <li><a href="http://localhost/inManage/api/src/Articles.php">Articles</a></li>
    <li><a href="http://localhost/inManage/api/src/Upload.php">Upload article</a></li>
      <li><a href="http://localhost/inManage/api/src/Delete.php">Delete article</a></li>
    </ul>
  </div>
</nav>


</body>
</html>