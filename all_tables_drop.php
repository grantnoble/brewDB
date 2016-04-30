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

// Fermentables
$query = "DROP TABLE fermentables";

if (mysqli_query($connection, $query))
	{
	echo 'fermentables table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// Hops
$query = "DROP TABLE hops";

if (mysqli_query($connection, $query))
	{
	echo 'hops table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// Yeasts
$query = "DROP TABLE yeasts";

if (mysqli_query($connection, $query))
	{
	echo 'yeasts table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// Miscs
$query = "DROP TABLE miscs";

if (mysqli_query($connection, $query))
	{
	echo 'miscs table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

/* BJCP Categories
$query = "DROP TABLE bjcp_categories";

if (mysqli_query($connection, $query))
	{
	echo 'bjcp_categories table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	} */

// Styles
$query = "DROP TABLE styles";

if (mysqli_query($connection, $query))
	{
	echo 'styles table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// Persons
$query = "DROP TABLE persons";

if (mysqli_query($connection, $query))
	{
	echo 'persons table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// Preferences
$query = "DROP TABLE preferences";

if (mysqli_query($connection, $query))
	{
	echo 'preferences table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// Recipes
$query = "DROP TABLE recipes";

if (mysqli_query($connection, $query))
	{
	echo 'recipes table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// recipes_fermentables
$query = "DROP TABLE recipes_fermentables";

if (mysqli_query($connection, $query))
	{
	echo 'recipes_fermentables table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// recipes_hops
$query = "DROP TABLE recipes_hops";

if (mysqli_query($connection, $query))
	{
	echo 'recipes_hops table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// recipes_yeasts
$query = "DROP TABLE recipes_yeasts";

if (mysqli_query($connection, $query))
	{
	echo 'recipes_yeasts table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// recipes_miscs
$query = "DROP TABLE recipes_miscs";

if (mysqli_query($connection, $query))
	{
	echo 'recipes_miscs table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// recipes_persons
$query = "DROP TABLE recipes_persons";

if (mysqli_query($connection, $query))
	{
	echo 'recipes_persons table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// brews
$query = "DROP TABLE brews";

if (mysqli_query($connection, $query))
	{
	echo 'brews table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// brews_fermentables
$query = "DROP TABLE brews_fermentables";

if (mysqli_query($connection, $query))
	{
	echo 'brews_fermentables table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// brews_hops
$query = "DROP TABLE brews_hops";

if (mysqli_query($connection, $query))
	{
	echo 'brews_hops table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// brews_yeasts
$query = "DROP TABLE brews_yeasts";

if (mysqli_query($connection, $query))
	{
	echo 'brews_yeasts table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// brews_miscs
$query = "DROP TABLE brews_miscs";

if (mysqli_query($connection, $query))
	{
	echo 'brews_miscs table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

// brews_persons
$query = "DROP TABLE brews_persons";

if (mysqli_query($connection, $query))
	{
	echo 'brews_persons table dropped...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

mysqli_close($connection);

?> 

</body>
</html> 
