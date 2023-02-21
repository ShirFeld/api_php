<?php

error_reporting (E_ALL ^ E_NOTICE); 
session_start();
// if(isset($_SESSION["id"]))
// {
//     // Header("Location: ../src/Articles.php");
//     Header("Location: temp.php");
// }

if($_SESSION["id"] != "")
{
    Header("Location: ../src/Articles.php");
}


if (isset($_GET['submit'])){
  $MySQLdb = new PDO("mysql:host=127.0.0.1;dbname=articles", "root", "");
  $MySQLdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $cursor = $MySQLdb->prepare("SELECT * FROM users WHERE email = :email AND password = :password ");
    $cursor->execute(array(":email"=>$_GET["email"], ":password"=>$_GET["password"]) );

    if($cursor->rowCount()){ // user is in the database
        $row = $cursor -> fetch();
        $_SESSION['email'] = $row['email'];
        $_SESSION['userName'] = $row['userName'];
        $_SESSION['id'] = $row['id'];
        // header("location: ../index.php");
        header("location: ../src/Articles.php");
        }
        else{
        header("location: login.php");
        }
}

?>

<html lang="en">
  <head>
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  </head>
  <body>

    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <ul class="nav navbar-nav">
          <li class="active"><a href="login.php">Home</a></li>
          <li><a href="../src/Articles.php">Articles</a></li>
        </ul>
      </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class=" text-center" style="  color: lightblue; text-shadow: 2px 2px 4px black; font-size: 70px;"> <b> Login </b></h1>
            </div>
        </div>
        <br> <br>
        <div class="row">
          <div class="col-md-offset-3 col-md-6">
            <div class="panel panel-default">
              <div class="panel-body">
                <form action="" method="GET">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="email" type="text" class="form-control" name="email" placeholder="Email">
                  </div>
                  <br>
                  <div class="input-group">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                   <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                  </div>
                  <br>
                  <button type="submit" class="btn-block btn-primary" value="login" name="submit"> <h5> <b> Login </b></h5></button>
                </form>
                  <br>
              </div>
            </div>
          </div>
        </div>
    </div>
  </body>
</html>