<?php

/*
brewdb_backup.php
Backup the brewdb database
*/

$page_title = 'Backup Database';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

echo '<div class="container">';
echo '<h2>Backup Database</h2>';

$backup_file = $database . "_backup_" . date("Y-m-d-H-i-s") . ".sql";
$command = "mysqldump -u " . $username . " -p" . $password . " brewdb_dev --skip-extended-insert --result-file=" . $backup_file;

system($command);

echo '<p>Backup to ' . $backup_file . ' successful.';

mysqli_close($connection);

echo '<form action="index.php">';
echo '<input class="btn btn-default" type="submit" value="Back" />';
echo '</form>';

include '../includes/footer.html';
?>
