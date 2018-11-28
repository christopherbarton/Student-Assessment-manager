<?php
    include 'connect.inc.php';
    $self = htmlentities($_SERVER['PHP_SELF']);
    echo "<form action='insertCheckPointValues.php' method='post'>";

    session_start();
    $adminId=$_SESSION["adminId"];
    $userName=$_SESSION["userName"];
    $firstName=$_SESSION["firstName"];
    $lastName=$_SESSION["lastName"];


    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $userMS, $passwordMS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');

        //echo "Connected<br/>";
    } catch (PDOException $e) {
        $error = 'Connection to database failed';
        include 'error.html.php';
        exit();
    }
   /*echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    echo '<pre>';
    var_dump($_SESSION);
    echo '</pre>';*/
?>

<!doctype html>
<html>
	<head>
	<title>Student Assistant</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<link rel='stylesheet' type='text/css' href='style.php'>


	</head>
<body >
<?php
    $self = htmlentities($_SERVER['PHP_SELF']);
        echo "<form action = '$self' method='POST'> ";
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">Student Assistant</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <form class="form-inline">
      <a href="logout.php" class="btn btn-primary">Home</a>
      <input type='submit' class="btn btn-primary" name='studentLogin' value='Student Login' disabled>
      <input type='submit' class="btn btn-primary" name='adminLogin' value='Admin Login' disabled>
      <a href="logout.php" class="btn btn-primary" >Logout</a>
      <a class="nav-item nav-link " href="#"></a>
    </div>
  </div>
</nav>

<div class="container d-flex align-items-center" align="center" style = "padding:5px;">
    <div class="container ">
      <a href="adminPasswordControl.html.php" class="btn btn-info">Change Student Password</a>
</div>
</div>
