<?php
/*
getrecipeinfo.php
Get the style information for a selected style.
*/

// since we are outputting xml, set the content type to be xml
header("Content-type: text/xml"); 

// connect to the database
include('includes/database_connect.php');

// build the xml output
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<recipe>'; 

// *** recipe ***
// build the sql SELECT stament and query the database
$recipe_name = $_GET['q'];
$query = "SELECT * FROM recipes WHERE recipe_name = '" . $recipe_name . "' ORDER BY recipe_date DESC LIMIT 1";
$result = mysqli_query($connection, $query) or die(mysqli_error());
 
// fetch the recipe details
$row = mysqli_fetch_array($result);

// save the recipe_id and style_id for later queries
$recipe_id = $row['recipe_id'];
$style_id = $row['recipe_style_id'];

//check for NULL values in the array and replace with a space
foreach($row as $key=>$value)
{
	if($value==NULL)
	{
		$row[$key]=" ";
	}
}

// output the recipe xml
echo "<recipe_type>" . $row['recipe_type'] . "</recipe_type>";
echo "<recipe_est_og>" . $row['recipe_est_og'] . "</recipe_est_og>";
echo "<recipe_est_fg>" . $row['recipe_est_fg'] . "</recipe_est_fg>";
echo "<recipe_est_color>" . $row['recipe_est_color'] . "</recipe_est_color>";
echo "<recipe_est_ibu>" . $row['recipe_est_ibu'] . "</recipe_est_ibu>";
echo "<recipe_est_abv>" . number_format($row['recipe_est_abv'],1) . "</recipe_est_abv>";

// *** style ***
// build the SELECT statement for the style and query the database
$query = "SELECT * FROM styles WHERE style_id = '" . $style_id . "' LIMIT 1";
$result = mysqli_query($connection, $query) or die(mysqli_error());

// fetch the style details
$row = mysqli_fetch_array($result);

// check for NULL values in the array and replace with a space
foreach($row as $key=>$value)
{
	if($value==NULL)
	{
		$row[$key]=" ";
	}
}

// output the style xml
echo "<style_name>" . $row['style_name'] . "</style_name>";
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

// *** fermentables ***
// build the SELECT statement for the recipes fermentables and query the database
$query = "SELECT * FROM recipes_fermentables WHERE recipe_fermentable_recipe_id = '" . $recipe_id . "' ORDER BY recipe_fermentable_amount DESC";
$result1 = mysqli_query($connection, $query) or die(mysqli_error());

// fetch the recipe fermentable details
while ($row1 = mysqli_fetch_array($result1))
{
	// start the fermentable xml and output the fermentable amount xml
	echo "<fermentable>";
	echo "<fermentable_amount>" . $row1['recipe_fermentable_amount'] . "</fermentable_amount>";
	echo "<fermentable_use>" . $row1['recipe_fermentable_use'] . "</fermentable_use>";

	// save the fermentable id to query for the fermentable details
	$fermentable_id = $row1['recipe_fermentable_fermentable_id'];

	// build the SELECT statement for the fermentable and query the database
	$query = "SELECT * FROM fermentables where fermentable_id ='" . $fermentable_id . "' LIMIT 1";
	$result2 = mysqli_query($connection, $query) or die(mysqli_error());

	// fetch the fermentable details
	$row2 = mysqli_fetch_array($result2);

	// output the rest of the fermentable xml
	echo "<fermentable_name>" . $row2['fermentable_name'] . "</fermentable_name>";
	echo "<fermentable_type>" . $row2['fermentable_type'] . "</fermentable_type>";
	echo "<fermentable_yield>" . $row2['fermentable_yield'] . "</fermentable_yield>";
	echo "<fermentable_color>" . $row2['fermentable_color'] . "</fermentable_color>";
	echo "</fermentable>";
}

//close the top-level xml tag
echo "</recipe>";

?>
