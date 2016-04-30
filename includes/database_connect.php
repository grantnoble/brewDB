<?php
/* 
database_connect
Connects to the database
*/

// Database variables
$server = '127.0.0.1';
$username = 'root';
$password = 'beer';
$database = 'brewdb_dev';
 
// Connect to database
$connection = mysqli_connect($server, $username, $password, $database) or die ('Could not connect to MySQL: ' . mysqli_connect_error());

// Set the encoding
mysqli_set_charset($connection, 'utf8');

?>
