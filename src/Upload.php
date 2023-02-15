<?php

echo "upload";
session_start();
if(($_SESSION['id'] =='')){
    header("location: login.php");
}
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
      <li><a href="http://localhost/inManage/api/src/Delete.php">Delete article</a></li>
    </ul>
  </div>
</nav>

</body>
</html>