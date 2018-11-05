<!-- This file proccess _POST and creates a pdo MYSQL query to display a table of data-->
<!doctype html>
<html>
	<head>
		<title>Search Result</title>
		  <meta charset="UTF-8">
          
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>    
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl" crossorigin="anonymous"></script>
<link rel='stylesheet' type='text/css' href='style.php'>
</head>

<body>
<?php
        include 'connect.inc.php';
        include 'createAthletes.php';
        $self = htmlentities($_SERVER['PHP_SELF']);
        echo "<form action = '$self' method='POST'> ";
        
    ?>
<div class="flex-container">
	<img src="photos/rioOlympics.png" class="img-rounded" alt="">
	
	<div class="container">
	<h2 class="text-center">Results</h2>
</div>

<div class="flex-container">
<?php
try
    {
        $query = 'SELECT DISTINCT medalists.firstName AS first
        FROM medalists,sport,country
            WHERE medalists.sportId=sport.sportId
            AND medalists.countryId=country.countryId
                ORDER BY medalists.firstName';
        $stmt  = $pdo->prepare($query);
        $stmt->execute();
?>
<!--Creates the dropdown so that the user can select a name from the database -->
<div class="form-group">
<label for="name">Select Name:</label>'
<select name="list2" class="form-control" class="selectpicker" id="name">
<option value='-1'>Please Select</option>
<?php
    foreach ($MedalistSportCountry as $row) 
        {
            echo("
                <tr>
                <td>$row[first]</td>
                <td>$row[last]</td>
                <td>$row[sport]</td>
                <td>$row[country]<br/><img src='$row[flagImage]' alt='' class='rounded-top img-thumbnail' width='70' height='70'></td>
                <td><img src='photos/$row[image]' alt='Image not found' class='rounded-top img-thumbnail' width='100' height='100'></td>
                </tr>
                ");
        }
    ?>
</select>
<?php
    }

catch (PDOException $e)
    {
        $error = 'Select statement error';
        include 'error.html.php';
        exit();
    }
?>
</body>