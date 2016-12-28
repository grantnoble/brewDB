<?php

/*
gethopinfo.php
Get the hop information for a selected hop.
*/

// since we are outputting xml, set the content type to be xml
header("Content-type: text/xml");

// connect to the database
include '../includes/database_connect.php';

// build the sql SELECT stament and query the database
$q = $_GET['q'];
$query = "SELECT * FROM hops WHERE hop_name = '" . $q . "'";
$result = mysqli_query($connection, $query) or die(mysqli_error());

// build the xml output
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<hop>';

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
	echo "<hop_id>" . $row['hop_id'] . "</hop_id>";
	echo "<hop_alpha>" . $row['hop_alpha'] . "</hop_alpha>";
}

//close the top-level xml tag
echo "</hop>";

?>
