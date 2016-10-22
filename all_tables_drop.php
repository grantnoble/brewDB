<?php

/* 
all_tables_drop.php
Drop (delete) all tables in the database
*/

$page_title = 'Drop All Tables';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

echo '<div class="container">';
echo '<h2>Drop All Tables</h2>';

$query = "SHOW TABLES";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection)); 
while ($row = mysqli_fetch_array($result)) 
{ 
	$tables[] = "$row[0]";
}

foreach ($tables as $tablename)
{
	$query = 'DROP TABLE ' . $tablename;
	if (mysqli_query($connection, $query))
	{
		echo '<p>' . $tablename . ' table dropped.' . '</p>';
	}
	else
	{
	die(mysqli_error($connection));
	}
}
mysqli_close($connection);

echo '<form action="index.php">';
echo '<input class="btn btn-default" type="submit" value="Back" />';
echo '</form>';

include ('includes/footer.html');
?>
