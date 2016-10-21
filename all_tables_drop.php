<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>All Tables Drop</title>
</head>
<body>

<?php

/* 
all_tables_drop.php
Drop (delete) all tables in the database
*/
header('Content-Type: text/html; charset="utf-8"', true);
// connect to the database
include('includes/database_connect.php');

// array to hold the names of the tables to drop
$array = ['fermentables', 'hops', 'yeasts', 'miscs', 'styles', 'persons', 'preferences', 'recipes', 'recipes_fermentables', 'recipes_hops', 'recipes_yeasts', 'recipes_miscs', 'recipes_persons', 'brews', 'brews_mashes', 'brews_ferments', 'brews_fermentables', 'brews_hops', 'brews_yeasts', 'brews_miscs', 'brews_persons'];

// for each table name in the array, drop the table
foreach($array as $table)
{
	$query = 'DROP TABLE ' . $table;
	if (mysqli_query($connection, $query))
	{
		echo $table . ' table dropped.' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}
}

mysqli_close($connection);


?>

<form action="index.php">
<br>
<input type="submit" value="Back">
</form>

</body>
</html> 
