<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Brewdb Backup</title>
</head>
<body>

<?php

/* 
brewdb_backup.php
Backup the brewdb database
*/
header('Content-Type: text/html; charset="utf-8"', true);
// connect to the database
include('includes/database_connect.php');

$backup_file = $database . "_backup_" . date("Y-m-d-H-i-s") . ".sql";
$command = "mysqldump -u " . $username . " -p" . $password . " brewdb > " . $backup_file;

system($command);

echo "Backup to " . $backup_file . " successful. Click 'back' to continue";

?> 

</body>
</html> 
