<?php
session_start();

if(isset($_SESSION["username"]))
{
    Header("Location: profiles.php");
}


if (isset($_GET['action'])){
  $MySQLdb = new PDO("mysql:host=127.0.0.1;dbname=articles", "root", "");
  $MySQLdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $_GET["password"] = md5($_GET["password"]);  // md5 encryption
      preg_match('/^[a-zA-Z0-9]+@[a-zA-Z0-9]+.[a-z]+(.[a-z]+)?$/', $_GET['mail'])?:exit('not good input!'); 

      $cursor = $MySQLdb->prepare("SELECT * FROM users WHERE mail=:mail AND password=:password");
      $cursor->execute(array(":mail"=>$_GET["mail"], ":password"=>$_GET["password"]) );

      if($cursor->rowCount()){ // user is in the database
        $row = $cursor -> fetch();
        $_SESSION['username'] = $row['username'];
        $_SESSION['mail'] = $row['mail'];
        $_SESSION['id'] = $row['id'];
        // $_SESSION['profile'] = $row['profile'];
          header("location: index.php");
       
        }else{
          header("location: login.php");
        }
}

?>

<html lang="en">
<head>
  <title>Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
</style>
</head>
<body>



<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class=" text-center" style="  color: lightblue;
  text-shadow: 2px 2px 4px black; font-size: 70px;" > <b> Login </b></h1>
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
                    <input id="email" type="text" class="form-control" name="mail" placeholder="Email">
                
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <br>
              
                <button type="submit" class="btn-block btn-primary" value="login" name="action"> <h5> <b> Login </b></h5></button>
                </form>
                <br>
              
            </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>