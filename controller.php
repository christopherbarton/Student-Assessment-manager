<?php
session_start();


include 'connect.inc.php'; // Log into Maria database
if (isset($_POST['adminLogin']))
    {
       header("location: adminLogin.html.php");
    /*echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    echo '<pre>';
    var_dump($_SESSION);
    echo '</pre>';*/
    } 
elseif (isset($_POST['studentLogin']))
    {
    header("location: studentLoginTest.html.php");
    /*echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    echo '<pre>';
    var_dump($_SESSION);
    echo '</pre>';*/
    }    
elseif (isset($_POST['login']))
    {
      // Check if the user is already logged in, if yes then redirect him to welcome page
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            //header("location: studentDashboard.html.php");
            include 'studentDashboard.html.php';
       /* echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        echo '<pre>';
        var_dump($_SESSION);
        echo '</pre>';*/
            exit;
        }
        else{
        include 'studentLoginTest.html.php';
        }
    }    

    //hasnt yet been submitted, display the form
else
    {
        include_once 'createTables.php';
        include 'mainForm.html.php';
    /*echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    echo '<pre>';
    var_dump($_SESSION);
    echo '</pre>';*/
    }
      /*echo "<pre>"; print_r($_POST) ;  echo "</pre>";
      echo '<pre>'; var_dump($_SESSION); echo '</pre>';*/
?>        
	