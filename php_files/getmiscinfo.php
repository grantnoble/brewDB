<?php

/*
getmiscinfo.php
Get the misc information for a selected misc.
*/

// since we are outputting xml, set the content type to be xml
header("Content-type: text/xml");

// connect to the database
include '../includes/database_connect.php';

// build the sql SELECT stament and query the database
$q = $_GET['q'];
$query = "SELECT * FROM miscs WHERE misc_name = '" . $q . "'";
$result = mysqli_query($connection, $query) or die(mysqli_error());

// build the xml output
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<misc>';

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
	echo "<misc_id>" . $row['misc_id'] . "</misc_id>";
	echo "<misc_type>" . $row['misc_type'] . "</misc_type>";
}

//close the top-level xml tag
echo "</misc>";

?>
