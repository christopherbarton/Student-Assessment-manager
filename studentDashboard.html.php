
            <!-- Icon Cards-->
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bartcj2_in612";
               // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            $selectString = 'SELECT students.firstName AS first, students.lastName AS last, lab.labname AS lab, lab.isCheckpoint AS isChecked, completion.responseTime AS completed
            FROM students,completion,data,lab,tool
                WHERE students.studentId=completion.studentId
                    AND students.studentId=data.studentId
                    AND lab.labId=data.dataId
                    AND data.toolId=tool.toolId
                    AND completion.studentId=students.studentId
                        ORDER BY students.firstName';
            $StudentListQuery = $pdo->query($selectString); 
            $sqll = "SELECT  * from sales_stats WHERE month='Mar' ";

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
    $selectString = 'SELECT lab.labname,xValue,yValue 
	FROM data,lab
  		WHERE data.labId=lab.labId
      AND studentId= 1
      AND data.toolId=1
			';

    $result = $conn->query($selectString);
    /*
        ---------------------------
        example data: Table (googlechart)
        --------------------------
        weekly_task     percentage
        Sleep           30
        Watching Movie  10
        job             40
        Exercise        20
     */

    $rows = array();
    $table = array();
    $table['cols'] = array(

        // Labels for your chart, these represent the column titles.
        /*
            note that one column is in "string" format and another one is in "number" format
            as pie chart only required "numbers" for calculating percentage
            and string will be used for Slice title
     */
        array('label' => 'labname', 'type' => 'string'),
        array('label' => 'xValue', 'type' => 'number'),
        array('label' => 'yValue', 'type' => 'number')
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
    $jsonTable = json_encode($table);
    echo $jsonTable;
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
            ?>
                     <a class="card-footer text-white clearfix small z-1" href="#">
                     <span class="float-left">View Details</span>
                     <span class="float-right">
                     <i class="fa fa-angle-right"></i>
                     </span>
                     </a>
                  </div>
               </div>
               <div class="col-xl-3 col-sm-6 mb-3">
                  <div class="card text-white bg-success o-hidden h-100">
                     <div class="card-body">
                        <div class="card-body-icon">
                           <i class="fa fa-fw fa-shopping-cart"></i>
                        </div>
                        <div class="mr-5">123 New Orders!</div>
                     </div>
                     <a class="card-footer text-white clearfix small z-1" href="#">
                     <span class="float-left">View Details</span>
                     <span class="float-right">
                     <i class="fa fa-angle-right"></i>
                     </span>
                     </a>
                  </div>
               </div>
               <div class="col-xl-3 col-sm-6 mb-3">
                  <div class="card text-white bg-danger o-hidden h-100">
                     <div class="card-body">
                        <div class="card-body-icon">
                           <i class="fa fa-fw fa-support"></i>
                        </div>
                        <div class="mr-5">13 New Tickets!</div>
                     </div>
                     <a class="card-footer text-white clearfix small z-1" href="#">
                     <span class="float-left">View Details</span>
                     <span class="float-right">
                     <i class="fa fa-angle-right"></i>
                     </span>
                     </a>
                  </div>
               </div>
            </div>
            <?php
           