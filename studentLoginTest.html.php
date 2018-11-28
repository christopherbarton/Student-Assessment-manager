<?php
include 'connect.inc.php';
include 'createTables.php';
// Initialize the session
//  session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: studentDashboard.html.php");
    exit;
}


$self = htmlentities($_SERVER['PHP_SELF']);
echo "<form action = '$self' method='POST'> ";
echo "<input type='hidden' name='userName'>";
 
// Define variables and initialize with empty values
$userName = "";
$password = "";
$username_err = $password_err = "";

 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Setup $username and $password variable if it exsists
    if (isset($_POST["userName"])) {
        $userName = trim($_POST["userName"]); // Trim (secure) user input 
        $_SESSION["userName"] = $userName;
    }
    if (isset($_POST["password"])) {
        $password = trim($_POST["password"]);
    }
    // Check if username is empty
    if (empty($userName)) {
        $username_err = "Please enter username.";
    } 
    else {
        $userName = trim($_POST["userName"]);// Trim (secure) user input
    }
    
    // Check if password is empty
    if (empty(trim($password))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]); // Trim (secure) user input

    }
    
    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT firstName,lastName,studentId, userName, password FROM students WHERE userName = :userName";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":userName", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["userName"]); // Trim (secure) user input
        
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if username exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $firstName = $row["firstName"];
                        $lastName = $row["lastName"];
                        $studentId = $row["studentId"];
                        $userName = $row["userName"];
                        $hashed_password = $row["password"];
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["studentId"] = $studentId;
                            $_SESSION["userName"] = $userName;
                            $_SESSION["firstName"] = $firstName;
                            $_SESSION["lastName"] = $lastName;
                            
                            $sessionfile = fopen("sessionfile.txt", "w");
                            fputs($sessionfile, session_encode());
                            fclose($sessionfile); //Debugging Session informtation
                            
                            // Redirect user to dashboard page
                            header("location: studentDashboard.html.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "<font size='3' color='red'>"."The password you entered was not valid."."</font>";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "<font size='3' color='red'>" . "No account found with that username." . "</font>";
                }
            } else {
                echo "<font size='3' color='red'>" . "Oops! Something went wrong. Please try again later." . "</font>";
            }
        }
        // Close statement
        unset($stmt);
    }
    // Close connection
    unset($pdo);
}
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
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
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
      <a class="nav-item nav-link " href="#"></a>
    </div>
  </div>
</nav>
<div class="container " align="center">
<div style = "margin:30px">
 <div style = "width:400px; border: solid 1px #547BCA; " align = "left">
  <div style = "background-color:#547BCA; color:#FFFFFF; padding:3px;"><h2 align="center"><b>Login</b></h2></div>
   <div style = "margin:30px">
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="userName" class="form-control" value="<?php echo $userName; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type='submit' class="btn btn-primary" name='studentLogin' value='Student Login'>
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
       </div>
      </div>
    </div>
   </div>
  </div>
 </div>
</body>
</html>