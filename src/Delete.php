<?php

require "Database.php" ;
require "ArticleGateway.php";
require "ArticleController.php";


session_start();
if(($_SESSION['id'] =='')){
    header("location: ../User/login.php");
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

      <li><a href="http://localhost/inManage/api/src/Articles.php">Articles</a></li>
      <li><a href="http://localhost/inManage/api/src/Put.php">Edit article</a></li>
      <li><a href="http://localhost/inManage/api/src/Upload.php">Upload article</a></li>
    </ul>
  </div>
</nav>

<div class="row">
        <div class="col-md-12">
            <h1 class=" text-center" style="  color: lightblue;
            text-shadow: 2px 2px 4px black; font-size: 60px;" > <b> Delete  </b></h1>
        </div>
    </div>
    <br> <br>
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
            <form action="" method="GET">
                <br>
                <!-- <div class="input-group"> -->
                    <!-- <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span> -->
                    <div style="text-align: center; color:#3d9aa7; margin-bottom:10px">
                    <h4 ><strong>Enter an article id to delete </strong></h4>
                    </div>

                    
                    <input id="articleId" type="number" class="form-control" name="articleId" placeholder="Article Id">
                <!-- </div> -->
                <br>
                <button type="submit" class="btn-block btn-primary" name="submit"> <h5> <b> Send </b></h5></button>
                </form>
  
                <br>
            </div>
            </div>


            <?php
            if (isset($_GET['submit'])){
                $articleId = $_GET["articleId"];
                //by html
                $controller->processRequest("DELETE" , $articleId);
              }

            else {          
              $idFromUrl = $_GET["id"];  // file.php?id=3
                // by url
              $controller->processRequest("DELETE" , $idFromUrl);

            }
           ?>
        </div>
     
    </div>
    
    <br> <br>
</body>
</html>