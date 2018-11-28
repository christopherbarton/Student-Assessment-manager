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
        include 'createTables.php';
        $self = htmlentities($_SERVER['PHP_SELF']);
        echo "<form action = '$self' method='POST'> ";
        
    ?>
<div class="flex-container">
	<img src="photos/rioOlympics.png" class="img-rounded" alt="">
	
	<div class="container">
	<h2 class="text-center">Student List</h2>
</div>

<div class="flex-container">
<?php
try
    {
        $selectString = 'SELECT students.firstName AS first, 
                                students.lastName AS last, 
                                lab.labname AS lab, 
                                lab.isCheckpoint AS isChecked, 
                                completion.responseTime AS completed, 
                                students.userName AS username,
                                students.password AS password
                                    FROM students,completion,data,lab,tool
                                        WHERE students.studentId=completion.studentId
                                        AND students.studentId=data.studentId
                                        AND lab.labId=data.dataId
                                        AND data.toolId=tool.toolId
                                        AND completion.studentId=students.studentId
                                            ORDER BY students.firstName';
        $StudentListQuery = $pdo->query($selectString); 
        
?>
<!--Creates the dropdown so that the user can select a name from the database -->
<div class="flex-container">
    <div class="table-wrapper-scroll-y">
		<table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>	
                    <th scope="col">First Name</th><th scope="col">Last Name</th><th scope="col">lab Number</th><th scope="col">Is a Checkmark</th><th scope="completed">Completed</th>
                </tr>
            </thead>
                <tbody>
<?php
    foreach ($StudentListQuery as $row) 
        {
            echo("
                <tr>
                <td>$row[first]</td>
                <td>$row[last]</td>
                <td>$row[lab]</td>
                <td>$row[isChecked]</td>
                <td>$row[username]</td>
                <td>$row[password]</td>
                <td>$row[completed]</td>
                </tr>
                ");
        }
    ?>
</tbody>
        </table>
    </div> 
</div>
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