<?php 
// Database configuration 
$dbHost     = "localhost"; 
$dbUsername = "root"; 
$dbPassword = ""; 
$dbName     = "pms"; 
 
// Create database connection 

$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 
 
// Check connection 
if ($db->connect_error) { 
    die("Connection failed: " . $db->connect_error); 
}


$con = mysqli_init();
mysqli_ssl_set($con,NULL,NULL, "{path to CA cert}", NULL, NULL);
mysqli_real_connect($conn, "pmss.mysql.database.azure.com", "nipa006", "{Jkdrjpwxgm9\}", "{pms}", 3306, MYSQLI_CLIENT_SSL);