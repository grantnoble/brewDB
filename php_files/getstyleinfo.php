<?php

/*
getstyleinfo.php
Get the style information for a selected style.
*/

// since we are outputting xml, set the content type to be xml
header("Content-type: text/xml");

// connect to the database
include '../includes/database_connect.php';

// build the sql SELECT stament and query the database
$q = $_GET['q'];
$query = "SELECT * FROM styles WHERE style_name = '" . $q . "'";
$result = mysqli_query($connection, $query) or die(mysqli_error());

// build the xml output
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<style>';

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
	echo "<style_og_min>" . number_format($row['style_og_min'],3) . "</style_og_min>";
	echo "<style_og_max>" . number_format($row['style_og_max'],3) . "</style_og_max>";
	echo "<style_fg_min>" . number_format($row['style_fg_min'],3) . "</style_fg_min>";
	echo "<style_fg_max>" . number_format($row['style_fg_max'],3) . "</style_fg_max>";
	echo "<style_ibu_min>" . $row['style_ibu_min'] . "</style_ibu_min>";
	echo "<style_ibu_max>" . $row['style_ibu_max'] . "</style_ibu_max>";
	echo "<style_color_min>" . $row['style_color_min'] . "</style_color_min>";
	echo "<style_color_max>" . $row['style_color_max'] . "</style_color_max>";
	echo "<style_abv_min>" . $row['style_abv_min'] . "</style_abv_min>";
	echo "<style_abv_max>" . $row['style_abv_max'] . "</style_abv_max>";
}

//close the top-level xml tag
echo "</style>";

?>
