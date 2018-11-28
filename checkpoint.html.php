<?php
/* Creates a checkpoint dropdown using an array that it generates from 
1) queryig the database for all labs 
2) querying the database for labs done by a student
3) turning these results into arrays and then flipping the results
4) using array_diff_key to find the difference in thearrays 

*/
    include 'connect.inc.php';
    $self = htmlentities($_SERVER['PHP_SELF']);
    echo "<form action='insertCheckPointValues.php' method='post'>";

    session_start();
    $studentId = $_SESSION["studentId"];
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

    // Query to find all labs that a student has done
    $sql = "SELECT DISTINCT labId
                    FROM data 
                            WHERE data.studentId =\"$studentId\"
                                ORDER BY labId ";
                             

    $sth = $pdo->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();
    $result=array_flatten($result);
    $result= array_flip($result);
    
    /*echo "<pre>";
    print_r($result);
    echo " </pre>";*/ //Debugging

 // Query that finds all the checkpoint labs
    $query2 = "SELECT DISTINCT labId
                    FROM lab 
                       WHERE lab.isCheckpoint=1
                          ORDER BY labId
			";

    $stmt2  = $pdo->prepare($query2);
    $stmt2->execute();
    $result2 = $stmt2->fetchAll();
    $result2=array_flatten($result2);
    $result2=array_flip($result2);
   /* echo "<pre>";
    print_r($result2);
    echo "</pre>";*/ // debugging

// find all the results in the labs table that is not in the data table
 $result4 = array_diff_key($result2,$result);
/*echo "<pre>";
    print_r($result4);
echo "</pre>";*/ //debugging


           
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<link rel='stylesheet' type='text/css' href='style.php'>
</head>
<body>
 <!--Dropdown for userName select-->
<!--Creates the dropdown so that the user can select a userName from the database -->
<div class="flex-container d-flex align-items-center">
    <div class="form-group">
        <label for="lab">Select a Lab :</label>
        <select name="list1" class="form-control custom-select browser-default" class="selectpicker" id="lab" required>
            <option value="">Please Select</option>
            <?php
            foreach($result4 as $field=>$val)
        {      
            echo("<tr>");
            echo("<td>$field</td><td>$val</td>");
            echo("</tr>");
        }
      foreach ($result4 as $field=>$val) {
        echo '<option value="' . $field . '">' . "Lab ". $field . '</option>';
      }
          ?>
        </select>
    </div>

 <div class="form-group">
  <label for="interestDifficulty">Interest vs Difficulty (select one):</label>
    <select name="list2" class="form-control custom-select browser-default" id="interestDifficulty" required>
      <option value="">Please Select</option>
      <option value="10">10 Interesting</option>
      <option value="9">9</option>
      <option value="8">8</option>
      <option value="7">7</option>
      <option value="6">6</option>
      <option value="5">5</option>
      <option value="4">4</option>
      <option value="3">3</option>
      <option value="2">2</option>
      <option value="1">1</option>
      <option value="0">0</option>
      <option value="-1">-1</option>
      <option value="-2">-2</option>
      <option value="-3">-3</option>
      <option value="-4">-4</option>
      <option value="-5">-5</option>
      <option value="-6">-6</option>
      <option value="-7">-7</option>
      <option value="-7">-7</option>
      <option value="-8">-8</option>
      <option value="-9">-9</option>
      <option value="-10">-10 Boring</option>
    </select>
 </div>
 <div class="form-group">
  <label for="interestDifficulty2">Interest vs Difficulty (select one):</label>
    <select name="list3" class="form-control custom-select browser-default" id="interestDifficulty2" required>
      <option value="">Please Select</option>
      <option value="10">10 Hard</option>
      <option value="9">9</option>
      <option value="8">8</option>
      <option value="7">7</option>
      <option value="6">6</option>
      <option value="5">5</option>
      <option value="4">4</option>
      <option value="3">3</option>
      <option value="2">2</option>
      <option value="1">1</option>
      <option value="0">0</option>
      <option value="-1">-1</option>
      <option value="-2">-2</option>
      <option value="-3">-3</option>
      <option value="-4">-4</option>
      <option value="-5">-5</option>
      <option value="-6">-6</option>
      <option value="-7">-7</option>
      <option value="-7">-7</option>
      <option value="-8">-8</option>
      <option value="-9">-9</option>
      <option value="-10">-10 Easy</option>
    </select>
 </div>
  
 <div class="form-group">
  <label for="planvsFamiliarity">Plan vs Familiarity (select one):</label>
    <select name="list4" class="form-control custom-select browser-default" id="planvsFamiliarity" required>
      <option value="">Please Select</option>
      <option value="10">10 Clear plan</option>
      <option value="9">9</option>
      <option value="8">8</option>
      <option value="7">7</option>
      <option value="6">6</option>
      <option value="5">5</option>
      <option value="4">4</option>
      <option value="3">3</option>
      <option value="2">2</option>
      <option value="1">1</option>
      <option value="0">0</option>
      <option value="-1">-1</option>
      <option value="-2">-2</option>
      <option value="-3">-3</option>
      <option value="-4">-4</option>
      <option value="-5">-5</option>
      <option value="-6">-6</option>
      <option value="-7">-7</option>
      <option value="-7">-7</option>
      <option value="-8">-8</option>
      <option value="-9">-9</option>
      <option value="-10">-10 Can't plan</option>
    </select>
 </div>
 <div class="form-group">
  <label for="planvsFamiliarity2">Plan vs Familiarity (select one):</label>
    <select name="list5" class="form-control custom-select browser-default" id="planvsFamiliarity2" required>
      <option value="">Please Select</option>
      <option value="10">10 Can't plan</option>
      <option value="9">9</option>
      <option value="8">8</option>
      <option value="7">7</option>
      <option value="6">6</option>
      <option value="5">5</option>
      <option value="4">4</option>
      <option value="3">3</option>
      <option value="2">2</option>
      <option value="1">1</option>
      <option value="0">0</option>
      <option value="-1">-1</option>
      <option value="-2">-2</option>
      <option value="-3">-3</option>
      <option value="-4">-4</option>
      <option value="-5">-5</option>
      <option value="-6">-6</option>
      <option value="-7">-7</option>
      <option value="-7">-7</option>
      <option value="-8">-8</option>
      <option value="-9">-9</option>
      <option value="-10">-10 Familiar content</option>
    </select>
 </div>
 <div class="form-group">
  <label for="satisfactionvsImprovement">Satisfaction vs Improvement (select one):</label>
    <select name="list6" class="form-control custom-select browser-default" id="satisfactionvsImprovement" required>
      <option value="">Please Select</option>
      <option value="10">10 I feel triumphant</option>
      <option value="9">9</option>
      <option value="8">8</option>
      <option value="7">7</option>
      <option value="6">6</option>
      <option value="5">5</option>
      <option value="4">4</option>
      <option value="3">3</option>
      <option value="2">2</option>
      <option value="1">1</option>
      <option value="0">0</option>
      <option value="-1">-1</option>
      <option value="-2">-2</option>
      <option value="-3">-3</option>
      <option value="-4">-4</option>
      <option value="-5">-5</option>
      <option value="-6">-6</option>
      <option value="-7">-7</option>
      <option value="-7">-7</option>
      <option value="-8">-8</option>
      <option value="-9">-9</option>
      <option value="-10">-10 I feel frustrated</option>
    </select>
 </div>
  <div class="form-group">
  <label for="satisfactionvsImprovement"> Satisfaction vs Improvement (select one):</label>
    <select name="list7" class="form-control custom-select browser-default" id="satisfactionvsImprovement" required>
      <option value="">Please Select</option>
      <option value="10">10 Improved</option>
      <option value="9">9</option>
      <option value="8">8</option>
      <option value="7">7</option>
      <option value="6">6</option>
      <option value="5">5</option>
      <option value="4">4</option>
      <option value="3">3</option>
      <option value="2">2</option>
      <option value="1">1</option>
      <option value="0">0</option>
      <option value="-1">-1</option>
      <option value="-2">-2</option>
      <option value="-3">-3</option>
      <option value="-4">-4</option>
      <option value="-5">-5</option>
      <option value="-6">-6</option>
      <option value="-7">-7</option>
      <option value="-7">-7</option>
      <option value="-8">-8</option>
      <option value="-9">-9</option>
      <option value="-10">-10 No improvement</option>
    </select>
 </div>
         <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
 </div>


<?php

// function to flattern an array (turn a multidimention array into a 2 dimention array)
function array_flatten($array)
{
    if (!is_array($array)) {
        return false;
    }
    $result = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $arrayList=array_flatten($value);
            foreach ($arrayList as $listItem) {
                $result[] = $listItem;
            }
        } else {
            $result[$key] = $value;
        }
    }
    return $result;
}

?>