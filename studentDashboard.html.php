
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

            $result = mysqli_query($conn, $sqll);
            if (mysqli_num_rows($result) > 0) {
                   // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
            <div class="row">
               <div class="col-xl-3 col-sm-6 mb-3">
                  <div class="card text-white bg-primary o-hidden h-100">
                     <div class="card-body">
                        <div class="card-body-icon">
                           <i class="fa fa-fw fa-comments"></i>
                        </div>
                        <div class="mr-5"><?php
                                            echo $row['Vistors'];
                                            ?> Vistors</div>
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
                  <div class="card text-white bg-warning o-hidden h-100">
                     <div class="card-body">
                        <div class="card-body-icon">
                           <i class="fa fa-fw fa-list"></i>
                        </div>
                        <div class="mr-5"><?php
                                            echo $row['revenue'];
                                            ?>  Revenue</div>
                     </div>
                     <?php

                }
            } else {
                echo '0 results';
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
           