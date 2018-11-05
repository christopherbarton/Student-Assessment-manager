
<!DOCTYPE html>
<html>
<head>
    <title>ZC-PHP Demo</title>
    <script src="//cdn.zingchart.com/zingchart.min.js"></script>

</head>
<body>
<h3>Simple Area Chart (Hardcoded)</h3>
<div id="myChart2"></div>

<?php
include 'zc.php';
use ZingChart\PHPWrapper\ZC;
echo "<div class='container'>";
$zc2 = new ZC("myChart2");// defaults to area type
$zc2->setSeriesData(0, [9,50,6,1,14,12]);
$zc2->setSeriesData(1, [34,24,16,11,44,52]);
$zc2->render();
echo "</div>";
?>

</div>