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
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">Student Assistant</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <form class="form-inline">
      <input type='submit' class="btn btn-primary" name='' value='Home'>
      <input type='submit' class="btn btn-primary" name='studentLogin' value='Student Login'>
      <input type='submit' class="btn btn-primary" name='adminLogin' value='Admin Login'>
      <a class="nav-item nav-link " href="#"></a>
    </div>
  </div>
</nav>
<?php
        include 'connect.inc.php';
        $self = htmlentities($_SERVER['PHP_SELF']);
        echo "<form action = '$self' method='POST'> ";
        try
    {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $userMS, $passwordMS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');

       //echo "Connected<br/>";
    }

        catch (PDOException $e)
    {
        $error = 'Connection to database failed';
        include 'error.html.php';
        exit();
    }
?>
<h2> Select graphs </h2>
<div class="container float-left">
<div class="col-xs-6">
 <div class="form-group">
  <label for="studentClass">Student or Class (select one):</label>
    <select name="list3" class="form-control custom-select browser-default" id="studentClass" required>
      <option value="">Please Select</option>
      <option value="Student">Student</option>
      <option value="Class">Class</option>
    </select>
 </div>
 <div class="form-group">
  <label for="graphType ">Graph type (select one):</label>
    <select name="list3" class="form-control custom-select browser-default" id="graphType" required>
      <option value="">Please Select</option>
      <option value="pie">Pie</option>
      <option value="line">Line</option>
      <option value="bar">Bar</option>
    </select>
 </div>
 <div class="form-group">
  <label for="data">Dataset</label>
    <select name="list3" class="form-control custom-select browser-default" id="data" required>
      <option value="">Please Select</option>
      <option value="completedLabs">Completed labs</option>
      <option value="checkpointLabs">Checkpoint Labs</option>
      <option value="interestVsDifficultyAverages">Interest vs Difficulty averages</option>
      <option value="planVsFamiliarityAverages">Plan vs Familiarity averages</option>
      <option value="satisfactionVsImprovementAverages">Satisfaction vs Improvement averages</option>
    </select>
    </div>
 </div>
 <div class="flex-container">
             <input type='submit' class="btn btn-warning" name='submitStudentChart' value='Login' required>
        </div>
</div>


</body>