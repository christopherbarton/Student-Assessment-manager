 <?php 
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
$selectString = "SELECT lab.isCheckpoint AS Checkpoint,completion.labId AS CheckpointDone,
	(SELECT count(DISTINCT lab.labname)  
			FROM lab  
				WHERE lab.isCheckpoint=1) AS labCount,
	(SELECT count(DISTINCT completion.labId)
			FROM completion 
        WHERE completion.studentId=1) AS labCountDone 
          FROM lab,completion
              WHERE completion.labId=lab.labId
                AND completion.studentId=12";

$result = $conn->query($selectString);
?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
           function drawChart()  
           {  
                var data = google.visualization.arrayToDataTable([  
                          ['labCount', 'labCountDone'],  
                          <?php 
                          while ($row = $result->fetch(PDO::FETCH_BOTH)) {
                            echo "['" . $row["Checkpoint"] . "', " . $row["labCount"] . "],";
                            echo "['" . $row["CheckpointDone"] . "', " . $row["labCountDone"] . "],";
                          }
                          ?>  
                     ]);  
                var options = {  
                      title: 'Labs Done',  
                      //is3D:true,  
                      pieHole: 0.4  
                     };  
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
                chart.draw(data, options);  
           }  
           </script>  
      </head>  
      <body>  
           <br /><br />  
           <div style="width:900px;">  
                <h3 align="center">Make Simple Pie Chart by Google Chart API with PHP Mysql</h3>  
                <br />  
                <div id="piechart" style="width: 900px; height: 500px;"></div>  
           </div>  
      </body>  
 </html>  