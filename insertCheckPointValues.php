<?php
include 'connect.inc.php';

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

    try {
        session_start();
        // Setup variables from _POST
        $studentId=$_SESSION["studentId"];
        $labId=(int)($_POST["list1"]);
        $iDEH=$_POST["list2"]; // Interset Difficult Easy Hard
        $iDIB=$_POST["list3"]; // Interset Difficult Interesting Boring
        $sFFS=$_POST["list4"]; // Stumped Familiar Focused Stumped
        $sFON=$_POST["list5"]; // Stumped Familiar Old New
        $sISF=$_POST["list6"]; // Satisfaction Improvement Success Frustrated
        $sFIS=$_POST["list7"]; // Satisfaction Improvement Improved Stagnant
        
        // echo "$labId" . " " . "$iDEH" . " " . "$iDIB" . " " . "$sFFS" . " " . "$sFON" . " " . "$sISF" . " " . "$sFIS" ;  // Debugging
        $toolId=1;
        // Generate and execute a PDO query using the above variables
        $insertQuery = "INSERT INTO data(toolId,studentId,labId,xValue,yValue) 
                                            VALUES(:toolId,:studentId,:labId,:xValue,:yValue)";
        $stmt = $pdo->prepare($insertQuery);
        $stmt->bindParam(':toolId', $toolId);
        $stmt->bindParam(':studentId', $studentId);
        $stmt->bindParam(':labId', $labId);
        $stmt->bindParam(':xValue', $iDEH);
        $stmt->bindParam(':yValue', $iDIB);
        $stmt->execute(); 

        $toolId=2;
        $insertQuery = "INSERT into data(toolId,studentId,labId,xValue,yValue) 
                                            VALUES(:toolId,:studentId,:labId,:xValue,:yValue)";
        $stmt = $pdo->prepare($insertQuery);
        $stmt->bindParam(':toolId', $toolId);
        $stmt->bindParam(':studentId', $studentId);
        $stmt->bindParam(':labId', $labId);
        $stmt->bindParam(':xValue', $sFFS);
        $stmt->bindParam(':yValue', $sFON);
        $stmt->execute();

        $toolId=3;
        $insertQuery = "INSERT into data(toolId,studentId,labId,xValue,yValue) 
                                            VALUES(:toolId,:studentId,:labId,:xValue,:yValue)";
        $stmt = $pdo->prepare($insertQuery);
        $stmt->bindParam(':toolId', $toolId);
        $stmt->bindParam(':studentId', $studentId);
        $stmt->bindParam(':labId', $labId);
        $stmt->bindParam(':xValue', $sISF);
        $stmt->bindParam(':yValue', $sFIS);
        $stmt->execute();

        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        echo '<pre>';
        var_dump($_SESSION);
        echo '</pre>';*/
?>
<!DOCTYPE html>
<html>
<body>
<div align="center">
<p>Checkpoint added successfully </p>

<button onclick="myFunction()">Press to continue</button>

<script>
function myFunction() {
        window.location.href = "studentDashboard.html.php";
}
</script>
</div>
</body>
</html>


<?php

   echo" ";

    } catch (PDOException $e) {
    $error='Inserting new checkpoint Data Failed';
    include 'error.html.php';
    exit();
}
