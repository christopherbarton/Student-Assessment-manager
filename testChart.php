<?php
// Initialize the session
session_start();
 $studentId = $_SESSION["studentId"];

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: controller.php");
    exit;
  }
include 'connect.inc.php';
$Uname = "2 Student";
try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $userMS, $passwordMS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec('SET NAMES "utf8"');

    //echo "Connected<br/>"; // Debugging
} catch (PDOException $e) {
    $error = 'Connection to database failed';
    include 'error.html.php';
    exit();
}

try {
 //Setup first graph
    $selectString = 'SELECT 
	(SELECT count(DISTINCT lab.labname)  
			FROM lab  
				WHERE lab.isCheckpoint=1) AS labCount,
	(SELECT count(DISTINCT completion.labId)
			FROM completion 
				WHERE completion.studentId=1) AS labCountDone 	
			';
    $result = $conn->query($selectString);
    $rows = array();
    $table = array();
    $table['cols'] = array(

        // Labels for the chart.
        array('label' => 'labCount', 'type' => 'string'),
        array('label' => 'labCount', 'type' => 'number'),
        array('label' => 'labCountDone', 'type' => 'number')
    );
    /* Extract the information from $result */
    foreach ($result as $r) {
        $temp = array();
		$temp[] = array('v' => (int)$r['labCountDone']);
        $temp[] = array('v' => (int)$r['labCount']);
        
        $rows[] = array('c' => $temp);
    }

    $table['rows'] = $rows;

    // convert data into JSON format
    $jsonTable1 = json_encode($table);
    echo $jsonTable1; //Debugging


} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

?>
  <html>
    <head>
      <!--Load the Ajax API and Bootstrap -->
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <link rel='stylesheet' type='text/css' href='style.php'>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">

      // Load the Visualization API and the piechart package.
        google.charts.load("current", {packages:["corechart"]});

      // Set a callback to run when the Google Visualization API is loaded.
        google.setOnLoadCallback(drawChartEasyHard);

 
        // functions that set p the data for the charts
        function drawChartEasyHard() 
          {

            // Create our data table out of JSON data loaded from server.
              var data = new google.visualization.DataTable(<?= $jsonTable1 ?>);
              var options = 
                {
                    title: 'Interest / Difculty',
                    //tooltip:{textStyle: {color: '#FF0000'}, showColorCode: true},
                    legend: {position: 'bottom', textStyle: {color: 'blue', fontSize: 12}, bold: 'true'},
                //backgroundColor: 'black'
                
                  };
              // Instantiate and draw our chart, passing in some options.
              // Do not forget to check your div ID
              var chart = new google.visualization.BarChart(document.getElementById('easyHardchart'));
              chart.draw(data, options);
          }

        
        
       </script>
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
      <input type='submit' class="btn btn-primary" name='' value='Home'>
      <input type='submit' class="btn btn-primary" name='studentLogin' value='Student Login' disabled>
      <input type='submit' class="btn btn-primary" name='adminLogin' value='Admin Login' disabled>
      <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
      <a class="nav-item nav-link " href="#"></a>
    </div>
  </div>
</nav>
      <div class="container-fluid">
        <!--this is the div that will hold the chart-->
        <div class="row">
          <div class="col-sm-4">
            <div id="easyHardchart" style="width: 500; height: 300;"></div>
          </div>

        </div>
      </div>  
    </body>
  </html>