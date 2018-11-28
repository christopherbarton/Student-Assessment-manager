<?php
// Initialize the session
session_start();
 $studentId = $_SESSION["studentId"];
$firstName = $_SESSION["firstName"];
$lastName = $_SESSION["lastName"];

// Check if the user is logged in, if not then redirect him to login page
/*if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: controller.php");
    exit;
  }*/
include 'connect.inc.php';

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
    $selectString = "SELECT lab.labname,xValue AS EasyHard,yValue AS InterestingBoring
  	FROM data,lab
  		WHERE data.labId=lab.labId
      AND studentId= \"$studentId\"
      AND data.toolId=1
      ORDER BY lab.labId 
			";
    $result = $conn->query($selectString);
    $rows = array();
    $table = array();
    $table['cols'] = array(

        // Labels for the chart.
        array('label' => 'labname', 'type' => 'string'),
        array('label' => 'Easy/Hard', 'type' => 'number'),
        array('label' => 'Interesting/Boring', 'type' => 'number')
    );
    /* Extract the information from $result */
    foreach ($result as $r) {
        $temp = array();

        // the following line will be used to slice the Pie chart
        $temp[] = array('v' => (string)$r['labname']);
        // Values of each slice
        $temp[] = array('v' => (int)$r['EasyHard']);
        $temp[] = array('v' => (int)$r['InterestingBoring']);
        $rows[] = array('c' => $temp);
    }

    $table['rows'] = $rows;

    // convert data into JSON format
    $jsonTable1 = json_encode($table);
    //echo $jsonTable1; //Debugging

// Setup second graph
    $selectString = "SELECT lab.labname,xValue,yValue
	    FROM data,lab
  		WHERE data.labId=lab.labId
      AND studentId= \"$studentId\"
      AND data.toolId=2
      ORDER BY lab.labId 
			";
      $result = $conn->query($selectString);
      $rows = array();
      $table = array();
      $table['cols'] = array(
        // Labels for the chart.
      array('label' => 'labname', 'type' => 'string'),
      array('label' => 'Focused/Stumped', 'type' => 'number'),
      array('label' => 'Old/New', 'type' => 'number')
  );
    /* Extract the information from $result */
    foreach ($result as $r) {
      $temp = array();

          // the following line will be used to slice the Pie chart
      $temp[] = array('v' => (string)$r['labname']);
          // Values of each slice
      $temp[] = array('v' => (int)$r['xValue']);
      $temp[] = array('v' => (int)$r['yValue']);
      $rows[] = array('c' => $temp);
  }

  $table['rows'] = $rows;

    // convert data into JSON format
  $jsonTable2 = json_encode($table);
  //echo "<br>" . "jsonTable2 : " . $jsonTable2; //Debugging

// Setup third graph
    $selectString = "SELECT lab.labname,xValue,yValue
        FROM data,lab
        WHERE data.labId=lab.labId
        AND studentId= \"$studentId\"
        AND data.toolId=3
        ORDER BY lab.labId 
        ";
    $result = $conn->query($selectString);
    $rows = array();
    $table = array();
    $table['cols'] = array(
          // Labels for the chart.
      array('label' => 'labname', 'type' => 'string'),
      array('label' => 'Success/Frustrated', 'type' => 'number'),
      array('label' => 'Improved/Stagnant', 'type' => 'number')
    );
      /* Extract the information from $result */
    foreach ($result as $r) {
      $temp = array();

            // the following line will be used to slice the Pie chart
      $temp[] = array('v' => (string)$r['labname']);
            // Values of each slice
      $temp[] = array('v' => (int)$r['xValue']);
      $temp[] = array('v' => (int)$r['yValue']);
      $rows[] = array('c' => $temp);
    }

    $table['rows'] = $rows;

      // convert data into JSON format
    $jsonTable3 = json_encode($table);
   // echo "<br>" . "jsonTable3 : " . $jsonTable3; //Debugging

//Setup forth graph
  $selectString = 'SELECT lab.labname,AVG(xValue) AS xValueAvg, AVG(yValue) AS yValueAvg
  	FROM data,lab
  		WHERE data.labId=lab.labId
       AND data.toolId=1
        GROUP BY lab.labname
        ORDER BY lab.labId 
			';
  $result = $conn->query($selectString);
  $rows = array();
  $table = array();
  $table['cols'] = array(

        // Labels for the chart.
    array('label' => 'labname', 'type' => 'string'),
    array('label' => 'Easy/Hard', 'type' => 'number'),
    array('label' => 'Interesting/Boring', 'type' => 'number')
  );
    /* Extract the information from $result */
  foreach ($result as $r) {
    $temp = array();

        // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string)$r['labname']);
        // Values of each slice
    $temp[] = array('v' => (int)$r['xValueAvg']);
    $temp[] = array('v' => (int)$r['yValueAvg']);
    $rows[] = array('c' => $temp);
  }

  $table['rows'] = $rows;

    // convert data into JSON format
  $jsonTable4 = json_encode($table);
  // echo $jsonTable4; //Debugging
//Setup fifth graph
  $selectString = 'SELECT lab.labname,AVG(xValue) AS xValueAvg, AVG(yValue) AS yValueAvg
  	FROM data,lab
  		WHERE data.labId=lab.labId
       AND data.toolId=2
        GROUP BY lab.labname
        ORDER BY lab.labId 
			';
  $result = $conn->query($selectString);
  $rows = array();
  $table = array();
  $table['cols'] = array(
        // Labels for the chart.
    array('label' => 'labname', 'type' => 'string'),
    array('label' => 'Focused/Stumped', 'type' => 'number'),
    array('label' => 'Old/New', 'type' => 'number')
  );
    /* Extract the information from $result */
  foreach ($result as $r) {
    $temp = array();

          // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string)$r['labname']);
          // Values of each slice
    $temp[] = array('v' => (int)$r['xValueAvg']);
    $temp[] = array('v' => (int)$r['yValueAvg']);
    $rows[] = array('c' => $temp);
  }

  $table['rows'] = $rows;

    // convert data into JSON format
  $jsonTable5 = json_encode($table);
  //echo "<br>" . "jsonTable5 : " . $jsonTable2; //Debugging
  
//Setup Sixth graph
  $selectString = 'SELECT lab . labname, AVG(xValue) as xValueAvg, AVG(yValue) as yValueAvg
    FROM data, lab
    WHERE data . labId = lab . labId
    and data . toolId = 3
    GROUP BY lab . labname
    ORDER BY lab.labId 
        ';
  $result = $conn->query($selectString);
  $rows = array();
  $table = array();
  $table['cols'] = array(
          // Labels for the chart.
    array('label' => 'labname', 'type' => 'string'),
    array('label' => 'Success/Frustrated', 'type' => 'number'),
    array('label' => 'Improved/Stagnant', 'type' => 'number')
  );
      /* Extract the information from $result */
  foreach ($result as $r) {
    $temp = array();
            // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string)$r['labname']);
            // Values of each slice
    $temp[] = array('v' => (int)$r['xValueAvg']);
    $temp[] = array('v' => (int)$r['yValueAvg']);
    $rows[] = array('c' => $temp);
  }
  $table['rows'] = $rows;
   // convert data into JSON format
  $jsonTable6 = json_encode($table);
   // echo "<br>" . "jsonTable3 : " . $jsonTable3; //Debugging


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

        google.setOnLoadCallback(drawChartStumpedFamiliar);

        google.setOnLoadCallback(drawChartSuccessFrustrated);

        google.setOnLoadCallback(drawChartEasyHardClass);

        google.setOnLoadCallback(drawChartStumpedFamiliarClass);

        google.setOnLoadCallback(drawChartSuccessFrustratedClass);

        // functions that set p the data for the charts
        function drawChartEasyHard() 
          {

            // Create our data table out of JSON data loaded from server.
              var data = new google.visualization.DataTable(<?= $jsonTable1 ?>);
              var options = 
                {
                    title: 'Interest / Difficulty',
                    hAxis: {title: '', minValue: -10, maxValue: 10},
                    vAxis: {title: '', minValue: -10, maxValue: 10},
                    //tooltip:{textStyle: {color: '#FF0000'}, showColorCode: true},
                    legend: {position: 'bottom', textStyle: {color: 'blue', fontSize: 12}, bold: 'true'},
                //backgroundColor: 'black'
                
                  };
              // Instantiate and draw our chart, passing in some options.
              // Do not forget to check your div ID
              var chart = new google.visualization.ScatterChart(document.getElementById('easyHardchart'));
              chart.draw(data, options);
          }

        
        function drawChartStumpedFamiliar() 
          {
            // Create our data table out of JSON data loaded from server.
              var data = new google.visualization.DataTable(<?= $jsonTable2 ?>);
              var options = 
                {
                    title: 'Stumped / Familiar',
                    hAxis: {title: '', minValue: -10, maxValue: 10},
                    vAxis: {title: '', minValue: -10, maxValue: 10},
                    is3D: 'true',
                //tooltip:{textStyle: {color: '#FF0000'}, showColorCode: true},
                   legend: {position: 'bottom', textStyle: {color: 'blue', fontSize: 12}, bold: 'true'},
                //backgroundColor: 'black'
                
                  };
              // Instantiate and draw our chart, passing in some options.
              // Do not forget to check your div ID
              var chart = new google.visualization.ScatterChart(document.getElementById('stumpedFamiliarchart'));
              chart.draw(data, options);
          }

        function drawChartSuccessFrustrated() 
          {
            // Create our data table out of JSON data loaded from server.
              var data = new google.visualization.DataTable(<?= $jsonTable3 ?>);
              var options = 
                {
                    title: 'Satisfaction / Improvement',
                    hAxis: {title: '', minValue: -10, maxValue: 10},
                    vAxis: {title: '', minValue: -10, maxValue: 10},
                    is3D: 'true',
                //tooltip:{textStyle: {color: '#FF0000'}, showColorCode: true},
                    legend: {position: 'bottom', textStyle: {color: 'blue', fontSize: 12}, bold: 'true'},
                //backgroundColor: 'black'
                
                  };
              // Instantiate and draw our chart, passing in some options.
              // Do not forget to check your div ID
              var chart = new google.visualization.ScatterChart(document.getElementById('successFrustratedchart'));
              chart.draw(data, options);
          }
       
        function drawChartEasyHardClass() 
          {
            // Create our data table out of JSON data loaded from server.
              var data = new google.visualization.DataTable(<?= $jsonTable4 ?>);
              var options = 
                {
                    title: 'Interest / Difficulty',
                    hAxis: {title: '', minValue: -10, maxValue: 10},
                    vAxis: {title: '', minValue: -10, maxValue: 10},
                    //tooltip:{textStyle: {color: '#FF0000'}, showColorCode: true},
                    legend: {position: 'bottom', textStyle: {color: 'blue', fontSize: 12}, bold: 'true'},
                //backgroundColor: 'grey'             
                  };
              // Instantiate and draw our chart, passing in some options.
              // Do not forget to check your div ID
              var chart = new google.visualization.ScatterChart(document.getElementById('easyHardchartClass'));
              chart.draw(data, options);
          }
        
        function drawChartStumpedFamiliarClass() 
          {
            // Create our data table out of JSON data loaded from server.
              var data = new google.visualization.DataTable(<?= $jsonTable5 ?>);
              var options = 
                {
                    title: 'Stumped / Familiar',
                    hAxis: {title: '', minValue: -10, maxValue: 10},
                    vAxis: {title: '', minValue: -10, maxValue: 10},
                    is3D: 'true',
                //tooltip:{textStyle: {color: '#FF0000'}, showColorCode: true},
                   legend: {position: 'bottom', textStyle: {color: 'blue', fontSize: 12}, bold: 'true'},
                //backgroundColor: 'black'
                
                  };
              // Instantiate and draw our chart, passing in some options.
              // Do not forget to check your div ID
              var chart = new google.visualization.ScatterChart(document.getElementById('stumpedFamiliarchartClass'));
              chart.draw(data, options);
          }
        function drawChartSuccessFrustratedClass() 
          {
            // Create our data table out of JSON data loaded from server.
              var data = new google.visualization.DataTable(<?= $jsonTable6 ?>);
              var options = 
                {
                    title: 'Satisfaction / Improvement',
                    hAxis: {title: '', minValue: -10, maxValue: 10},
                    vAxis: {title: '', minValue: -10, maxValue: 10},
                    is3D: 'true',
                //tooltip:{textStyle: {color: '#FF0000'}, showColorCode: true},
                    legend: {position: 'bottom', textStyle: {color: 'blue', fontSize: 12}, bold: 'true'},
                //backgroundColor: 'black'
                
                  };
              // Instantiate and draw our chart, passing in some options.
              // Do not forget to check your div ID
              var chart = new google.visualization.ScatterChart(document.getElementById('successFrustratedchartClass'));
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
      <a href="logout.php" class="btn btn-primary">Home</a>
      <input type='submit' class="btn btn-primary" name='studentLogin' value='Student Login' disabled>
      <input type='submit' class="btn btn-primary" name='adminLogin' value='Admin Login' disabled>
      <a href="checkpointAuth.html.php" class="btn btn-primary">Fill in Checkpoint</a>
      <a href="changePassword.php" class="btn btn-primary">Change Password</a>
      <a href="logout.php" class="btn btn-primary" >Logout</a>
      <a class="nav-item nav-link " href="#"></a>
    </div>
  </div>
</nav>
      <div class="container-fluid">
        <h2> Welcome <?php echo "$firstName $lastName" ?> </h2>
        <!--this is the div that will hold the chart-->
        <div class="row">
          <div class="col-sm-4">
            <div id="easyHardchart" style="width: 500; height: 300;"></div>
          </div>
          <div class="col-sm-4">   
            <div id="stumpedFamiliarchart" style="width: 500; height: 300;"></div>
          </div>
          <div class="col-sm-4">
            <div id="successFrustratedchart" style="width: 500; height: 300;"></div>
          </div> 
        </div>

        <div class="row">
          <div class="col-sm-4">
            <div id="easyHardchartClass" style="width: 500; height: 300;"></div>
          </div>
          <div class="col-sm-4">   
            <div id="stumpedFamiliarchartClass" style="width: 500; height: 300;"></div>
          </div>
          <div class="col-sm-4">
            <div id="successFrustratedchartClass" style="width: 500; height: 300;"></div>
          </div> 
        </div>
      </div>  
    </body>
  </html>
