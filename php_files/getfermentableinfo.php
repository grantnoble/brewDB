<?php
/*
getfermentableinfo.php
Get the fermentable information for a selected fermentable.
*/
// since we are outputting xml, set the content type to be xml
header("Content-type: text/xml"); 

// connect to the database
include('includes/database_connect.php');

// build the sql SELECT stament and query the database
$q = $_GET['q'];
$query = "SELECT * FROM fermentables WHERE fermentable_name = '" . $q . "'";
$result = mysqli_query($connection, $query) or die(mysqli_error());
 
// build the xml output
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<fermentable>'; 

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
	echo "<fermentable_id>" . $row['fermentable_id'] . "</fermentable_id>";
	echo "<fermentable_yield>" . $row['fermentable_yield'] . "</fermentable_yield>";
	echo "<fermentable_color>" . $row['fermentable_color'] . "</fermentable_color>";
	echo "<fermentable_type>" . $row['fermentable_type'] . "</fermentable_type>";
}

//close the top-level xml tag
echo "</fermentable>";

?>
