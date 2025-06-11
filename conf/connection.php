<?php
define("HTTP_HOST_IP", "localhost");
$mysql_database = "import_excel_using_in_php";
$mysql_hostname = HTTP_HOST_IP;
$mysql_user 	= "root";
$mysql_password = "";
$prefix = "";
$conn = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect mysql");
mysqli_select_db($conn, $mysql_database) or die("Could not select database");
