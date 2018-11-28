<?php
include 'connect.inc.php';


try
    {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $userMS, $passwordMS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');

      // echo "Connected<br/>"; // Debugging
    }

catch (PDOException $e)
    {
        $error = 'Connection to database failed';
        include 'error.html.php';
        exit();
    }

  try
  {
    //Check if table exsits if it does not creates the table
            if (tableExists($pdo,'students')==FALSE)
        {

        //Create the student table to store student data 
            $createQuery="CREATE TABLE students
            (
                studentId          INT(10) NOT NULL AUTO_INCREMENT,
                StudentNumber      INT(100) NOT NULL,
                firstName          VARCHAR(100),
                lastName           VARCHAR(100),
                userName           VARCHAR(100),
                password           VARCHAR(128),
                PRIMARY KEY(studentId)           
            )";

            $pdo->exec($createQuery);
            echo "Create sport student done<br/>"; // Debugging

        //Drop the admin table 

            $dropQuery = "DROP TABLE IF EXISTS admin";
            $pdo->exec($dropQuery);
            
          //Create the admin table to store admin data 
            $createQuery="CREATE TABLE admin
            (
                adminId            INT(10) NOT NULL AUTO_INCREMENT,
                firstName          VARCHAR(100),
                lastName           VARCHAR(100),
                userName           VARCHAR(100),
                password           VARCHAR(128),
                adminPassword      VARCHAR(128),
               
                PRIMARY KEY(adminId)           
            )";

            $pdo->exec($createQuery);
            echo "Create admin database done<br/>"; // Debugging

        //Drop the lab table 

            $dropQuery = "DROP TABLE IF EXISTS lab";
            $pdo->exec($dropQuery);
            
          //Create the lab table to store data data 
            $createQuery="CREATE TABLE lab
            (
                labId                   INT(10) NOT NULL AUTO_INCREMENT,
                labname                 VARCHAR(100),
                isCheckpoint            TINYINT(1) NOT NULL,

                PRIMARY KEY(labId)           
            )";

            $pdo->exec($createQuery);
            echo "Create lab database done<br/>"; // Debugging

        //Drop the tool table 

            $dropQuery = "DROP TABLE IF EXISTS tool";
            $pdo->exec($dropQuery);
            
          //Create the tool table to store tool data 
            $createQuery="CREATE TABLE tool
            (
                toolId                      INT(10) NOT NULL AUTO_INCREMENT,
                tableNamex                  VARCHAR(100),
                tableNamey                  VARCHAR(100),
                northLabel                  VARCHAR(100),
                southLabel                  VARCHAR(100),
                eastLabel                   VARCHAR(100),
                westLabel                   VARCHAR(100),
                PRIMARY KEY(toolId)           
            )";

            $pdo->exec($createQuery);
            echo "Create tool database done<br/>"; // Debugging
            
        //Drop the completion table 

            $dropQuery = "DROP TABLE IF EXISTS completion";
            $pdo->exec($dropQuery);
            
          //Create the completion table to store completion data 
            $createQuery="CREATE TABLE completion
            (
                completionId            INT(10) NOT NULL AUTO_INCREMENT,
                studentId               INT(10) NOT NULL,
                labId                   INT(10) NOT NULL,
                responseTime            TIMESTAMP,
                FOREIGN KEY (studentId) REFERENCES students(studentId),       
                                PRIMARY KEY(completionId)           
            )";

            $pdo->exec($createQuery);
            echo "Create completion database done<br/>"; // Debugging
           
        //Drop the data table 

             $dropQuery = "DROP TABLE IF EXISTS data";
             $pdo->exec($dropQuery);
             
           //Create the data table to store data data 
             $createQuery="CREATE TABLE data
             (
                 dataId            INT(10) NOT NULL AUTO_INCREMENT,
                 toolId            INT(10) NOT NULL,
                 studentId         INT(10) NOT NULL,
                 labId             INT(10) NOT NULL,
                 xValue            VARCHAR(32),
                 yValue            VARCHAR(32),

                 FOREIGN KEY (toolId) REFERENCES tool(toolId),       
                 FOREIGN KEY (studentId) REFERENCES students(studentId),
                       PRIMARY KEY(dataId)           
             )";
 
             $pdo->exec($createQuery);
             echo "Create data database done<br/>"; // Debugging
            
             inputData($pdo) ; 
        }

}
catch (PDOException $e)
{
    $error='Creating the table failed';
    include 'error.html.php';
    exit();
}

    //Reading csv file and INSERTing into tables
    function inputData($pdo)  {
        try
            {   
                date_default_timezone_set('UTC');
        // Insert admin data using prepared tables
                $insertQuery = "INSERT into admin(adminId,firstName,lastName,userName,password,adminPassword) VALUES(:adminId,:firstName,:lastName,:userName,:password,:adminPassword)";
                $stmt = $pdo->prepare($insertQuery);
                $stmt->bindParam(':adminId',$adminId);
                $stmt->bindParam(':firstName',$firstName);
                $stmt->bindParam(':lastName',$lastName);
                $stmt->bindParam(':userName',$userName);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':adminPassword',$adminPassword);
                
                $file = fopen("admin.csv","r");
                while(! feof($file))
                    {  
                    $myArray= fgetcsv($file);
                    $adminId= $myArray[0];
                    $firstName= $myArray[1];
                    $lastName= $myArray[2];
                    $userName= $myArray[3];
                    $password= password_hash($myArray[4], PASSWORD_DEFAULT);
                    $adminPassword= password_hash($myArray[5], PASSWORD_DEFAULT);
                    $stmt->execute();
                    }
                fclose($file);

        // Insert students data using prepared tables
                 $insertQuery = "INSERT into students(studentId,StudentNumber,firstName,lastName,userName,password) VALUES(:studentId,:StudentNumber,:firstName,:lastName,:userName,:password)";
                 $stmt = $pdo->prepare($insertQuery);
                 $stmt->bindParam(':studentId',$studentId);
                 $stmt->bindParam(':StudentNumber',$StudentNumber);
                 $stmt->bindParam(':firstName',$firstName);
                 $stmt->bindParam(':lastName',$lastName);
                 $stmt->bindParam(':userName',$userName);
                 $stmt->bindParam(':password',$password);
                 
                 $file = fopen("students.csv","r");
                 while(! feof($file))
                     {  
                     $myArray= fgetcsv($file);
                     $studentId= $myArray[0];
                     $StudentNumber= $myArray[1];
                     $firstName= $myArray[2];
                     $lastName= $myArray[3];
                     $userName= $myArray[4];
                     $password= password_hash("12345", PASSWORD_DEFAULT);

                     $stmt->execute();
                     }
                 fclose($file);

        // Insert lab data using prepared tables
                 $insertQuery = "INSERT into lab(labId,labname,isCheckpoint) VALUES(:labId,:labname,:isCheckpoint)";
                 $stmt = $pdo->prepare($insertQuery);
                 $stmt->bindParam(':labId',$labId);
                 $stmt->bindParam(':labname',$labname);
                 $stmt->bindParam(':isCheckpoint',$isCheckpoint);
                 
                 $file = fopen("lab.csv","r");
                 while(! feof($file))
                     {  
                     $myArray= fgetcsv($file);
                     $labId= $myArray[0];
                     $labname= $myArray[1];
                     $isCheckpoint= $myArray[2];
                     $stmt->execute();
                     }
                 fclose($file);

        // Insert tool data using prepared tables
                $insertQuery = "INSERT into tool(toolId,tableNamex,tableNamey,northLabel,southLabel,eastLabel,westLabel) VALUES(:toolId,:tableNamex,:tableNamey,:northLabel,:southLabel,:eastLabel,:westLabel)";
                $stmt = $pdo->prepare($insertQuery);
                $stmt->bindParam(':toolId',$toolId);
                $stmt->bindParam(':tableNamex',$tableNamex);
                $stmt->bindParam(':tableNamey',$tableNamey);
                $stmt->bindParam(':northLabel',$northLabel);
                $stmt->bindParam(':southLabel',$southLabel);
                $stmt->bindParam(':eastLabel',$eastLabel);
                $stmt->bindParam(':westLabel',$westLabel);
                
                $file = fopen("tool.csv","r");
                while(! feof($file))
                    {  
                    $myArray= fgetcsv($file);
                    $toolId= $myArray[0];
                    $tableNamex= $myArray[1];
                    $tableNamey= $myArray[2];
                    $northLabel= $myArray[3];
                    $southLabel= $myArray[4];
                    $eastLabel= $myArray[5];
                    $westLabel= $myArray[6];
                    $stmt->execute();
                    }
                fclose($file);

        // Insert completion data using prepared tables
                $insertQuery = "INSERT into completion(completionId,studentId,labId,responseTime) VALUES(:completionId,:studentId,:labId,:responseTime)";
                $stmt = $pdo->prepare($insertQuery);
                $stmt->bindParam(':completionId',$completionId);
                $stmt->bindParam(':studentId',$studentId);
                $stmt->bindParam(':labId',$labId);
                $stmt->bindParam(':responseTime',$responseTime);
                
                $file = fopen("completion.csv","r");
                while(! feof($file))
                    {  
                    $myArray= fgetcsv($file);
                    $completionId= $myArray[0];
                    $studentId= $myArray[1];
                    $labId= $myArray[2];
                    // $responseTime= substr($myArray[3], 0,3)."-".substr($myArray[3], 5,6)."-".substr($myArray[3], 8,9)." ".substr($myArray[3], 11,12).":".substr($myArray[3], 14,15);
                    $responseTimeString= $myArray[3];
                    $responseTime= date("Y-m-d G:i",strtotime($responseTimeString));  
                    $stmt->execute();
                    // print_r($responseTime); //Debugging
                    }
                fclose($file);

        // Insert data data using prepared tables
                $insertQuery = "INSERT into data(dataId,toolId,studentId,labId,xValue,yValue) VALUES(:dataId,:toolId,:studentId,:labId,:xValue,:yValue)";
                $stmt = $pdo->prepare($insertQuery);
                $stmt->bindParam(':dataId',$dataId);
                $stmt->bindParam(':toolId',$toolId);
                $stmt->bindParam(':studentId',$studentId);
                $stmt->bindParam(':labId',$labId);
                $stmt->bindParam(':xValue',$xValue);
                $stmt->bindParam(':yValue',$yValue);

                $file = fopen("data.csv","r");
                while(! feof($file))
                    {  
                    $myArray= fgetcsv($file);
                    $dataId= $myArray[0];
                    $toolId= $myArray[1];
                    $studentId= $myArray[2];
                    $labId= $myArray[3];
                    $xValue= $myArray[4];
                    $yValue= $myArray[5];
                    $stmt->execute();
                    }
                fclose($file);

            }
        catch (PDOException $e)
            {
                $error='Creating the table failed';
                include 'error.html.php';
                exit();

            }            
        }

function tableExists($pdo,$table)  
{

    // Try a select statement against the table
    // Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
    try {
        $result = $pdo->query("SELECT 1 FROM $table LIMIT 1");
    } catch (Exception $e) {
        // We got an exception == table not found
        return FALSE;
    }

    // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
    return $result !== FALSE;
}


?>