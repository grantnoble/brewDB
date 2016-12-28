<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>All Tables Truncate</title>
</head>
<body>

<?php

/*
all_tables_truncate.php
Delete the data in all tables in the database
*/

header('Content-Type: text/html; charset="utf-8"', true);
// connect to the database
include '../includes/database_connect.php';

// fermentables
$query = "TRUNCATE TABLE fermentables;";

// hops
$query .= "TRUNCATE TABLE hops;";

// yeasts
$query .= "TRUNCATE TABLE yeasts;";

// miscs
$query .= "TRUNCATE TABLE miscs;";

// styles
$query .= "TRUNCATE TABLE styles;";

// persons
$query .= "TRUNCATE TABLE persons;";

// preferences
$query .= "TRUNCATE TABLE preferences;";

// recipes
$query .= "TRUNCATE TABLE recipes;";

// recipes_fermentables
$query .= "TRUNCATE TABLE recipes_fermentables;";

// recipes_hops
$query .= "TRUNCATE TABLE recipes_hops;";

// recipes_yeasts
$query .= "TRUNCATE TABLE recipes_yeasts;";

// recipes_miscs
$query .= "TRUNCATE TABLE recipes_miscs;";

// recipes_persons
$query .= "TRUNCATE TABLE recipes_persons;";

// brews
$query .= "TRUNCATE TABLE brews;";

// brews_fermentables
$query .= "TRUNCATE TABLE brews_fermentables;";

// brews_hops
$query .= "TRUNCATE TABLE brews_hops;";

// brews_yeasts
$query .= "TRUNCATE TABLE brews_yeasts;";

// brews_miscs
$query .= "TRUNCATE TABLE brews_miscs;";

// brews_persons
$query .= "TRUNCATE TABLE brews_persons;";

if (mysqli_multi_query($connection, $query))
	{
	echo 'Data in brewdb tables deleted...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

mysqli_close($connection);

?>

<form action="index.php">
<br>
<input type="submit" value="Back">
</form>

</body>
</html>
