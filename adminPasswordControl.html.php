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

session_start();

// Define variables and initialize with empty values
$userName = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";


    if (isset($_POST['submit'])) {
        $studentId = $_POST['list1'];  // Storing Selected Value In Variable
     // Displaying Selected Value
    $sessionfile = fopen("sessionfile.txt", "w");
        fputs($sessionfile, session_encode());
        fclose($sessionfile); //Debugging Session informtation
        file_put_contents('test.txt', file_get_contents('php://input'));
    }

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "<font size='3' color='red'>"."Password must have atleast 6 characters."."</font>";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "<font size='3' color='red'>"."Password did not match."."</font>";
        }
    }
    
    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        
        // Prepare an insert statement
        $sql = "UPDATE students SET password=:password WHERE studentId=\"$studentId\" ";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            // Set parameters
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                header("location: adminDashboard.html.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        unset($stmt);
    }
    // Close connection
    unset($pdo);
}

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


$query = "
    SELECT students.lastName AS Surname, students.firstName AS Name, studentId 
            FROM students 
                ORDER BY students.lastName ASC
			";
;
            $stmt  = $pdo->prepare($query);
            $stmt->execute();
   /*echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    echo '<pre>';
    var_dump($_SESSION);
    echo '</pre>';
*/
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<div class="flex-container " align="center">
    <div class="wrapper">
    <div class="form-group">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="lab">Select a User :</label>
        <select name="list1" class="form-control custom-select browser-default" class="selectpicker" id="lab" required>
            <option value="">Please Select</option>
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            echo '<option value="' . $row['studentId'] .'">' . $row['Surname'] . " " . $row['Name']. " " .$row['studentId'] .'</option>';
    }
  
?>
        </select>
    
           <p>Please enter a new password.</p>
       
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
        </div>    
    </div>    
</body>
</html>
