<?php

/*
getyeastinfo.php
Get the yeast information for a selected yeast.
*/

// since we are outputting xml, set the content type to be xml
header("Content-type: text/xml");

// connect to the database
include '../includes/database_connect.php';

// build the sql SELECT stament and query the database
$q = $_GET['q'];
$query = "SELECT * FROM yeasts WHERE yeast_fullname = '" . $q . "'";
$result = mysqli_query($connection, $query) or die(mysqli_error());

// build the xml output
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<yeast>';

while ($row = mysqli_fetch_array ( $result ))
{
	// check for NULL values in the array and replace with a space
	foreach($row as $key=>$value)
	{
		if($value==NULL)
		{
			$row[$key]=" ";
		}
	}

	// output the body of the xml
	echo "<yeast_id>" . $row['yeast_id'] . "</yeast_id>";
	echo "<yeast_laboratory>" . $row['yeast_laboratory'] . "</yeast_laboratory>";
	echo "<yeast_product_id>" . $row['yeast_product_id'] . "</yeast_product_id>";
	echo "<yeast_name>" . $row['yeast_name'] . "</yeast_name>";
	echo "<yeast_fullname>" . $row['yeast_fullname'] . "</yeast_fullname>";
	echo "<yeast_type>" . $row['yeast_type'] . "</yeast_type>";
	echo "<yeast_form>" . $row['yeast_form'] . "</yeast_form>";
	echo "<yeast_attenuation>" . $row['yeast_attenuation'] . "</yeast_attenuation>";
	echo "<yeast_flocculation>" . $row['yeast_flocculation'] . "</yeast_flocculation>";
	echo "<yeast_notes>" . $row['yeast_notes'] . "</yeast_notes>";
}

//close the top-level xml tag
echo "</yeast>";

?>
