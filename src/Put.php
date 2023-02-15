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
    <li><a href="http://localhost/inManage/api/src/Upload.php">Upload article</a></li>
      <li><a href="http://localhost/inManage/api/src/Delete.php">Delete article</a></li>
    </ul>
  </div>
</nav>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class=" text-center" style="  color: lightblue;
                        text-shadow: 2px 2px 4px black; font-size: 60px;" > <b> Update article </b></h1>
        </div>
    </div>
    <br> <br>
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
              <form action="" method="GET">
                <input id="article_name" type="text" class="form-control" name="article_name" placeholder="Article name">
                <br>
                <input id="length" type="number" class="form-control" name="length" placeholder="Minutes Long">
                <br>
                <input id="publish_date" type="date" class="form-control" name="publish_date" placeholder="Publish Date">
                <br>
                <label >Enter your content here</label><br>
                <textarea  style="margin-bottom :40px" rows = "10" cols = "60" name = "content">
                </textarea>
                <br>
                  <button type="submit" class="btn-block btn-primary" value="login" name="update"> <h5> <b> update </b></h5></button>
                </form>

                <br>
            </div>
            </div>
            <?php
              if (isset($_GET['update'])){


                //  $sql = "DELETE FROM article 
                // WHERE author = $userId and id = $articleIid";
                
                $cursor = $MySQLdb->prepare("UPDATE articles SET email = :email AND password = :password ");
                $cursor->execute(array(":email"=>$_GET["email"], ":password"=>$_GET["password"]) );

                $controller->processRequest("PATCH" ,$article, $data, $idFromUrl,  $_SESSION['id']);
}
            ?>
        </div>
    </div>
</div>
</body>
</html>