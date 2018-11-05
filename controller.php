<?php

include 'connect.inc.php'; // Log into Maria database
if (isset($_POST['adminLogin']))
    {
        include 'adminLogin.html.php';
       echo "<pre>"; print_r($_POST) ;  echo "</pre>";
    } 
elseif (isset($_POST['studentLogin']))
    {
        include 'studentLogin.html.php';
       echo "<pre>"; print_r($_POST) ;  echo "</pre>";
    }    
elseif (isset($_POST['studentHome']))
    {
        include 'studentHome.html.php';
       echo "<pre>"; print_r($_POST) ;  echo "</pre>";
    }    

    //hasnt yet been submitted, display the form
else
    {
        include 'createTables.php';
        include 'mainForm.html.php';
        echo "<pre>"; print_r($_POST) ;  echo "</pre>";

    }
      echo "<pre>"; print_r($_POST) ;  echo "</pre>";
?>        
	