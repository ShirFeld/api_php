<?php
echo "update";
require "Database.php" ;
require "ArticleGateway.php";
require "ArticleController.php";


session_start();
if(($_SESSION['id'] =='')){
    header("location: login.php");
}

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


      <li><a href="Articles.php">Articles</a></li>
      <li><a href="update.php">Upload article</a></li>
      <li><a href="Delete.php">Delete article</a></li>
    </ul>
  </div>
</nav>

</body>
</html>