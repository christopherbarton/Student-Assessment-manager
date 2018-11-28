<?php
// Initialize the session
session_start();
$_SESSION["loggedin"] = false;
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: controller.php");
exit;
?>