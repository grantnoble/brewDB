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
	echo "<fermentable_id>" . $row2['fermentable_id'] . "</fermentable_id>";
	echo "<fermentable_name>" . $row2['fermentable_name'] . "</fermentable_name>";
	echo "<fermentable_type>" . $row2['fermentable_type'] . "</fermentable_type>";
	echo "<fermentable_yield>" . $row2['fermentable_yield'] . "</fermentable_yield>";
	echo "<fermentable_color>" . $row2['fermentable_color'] . "</fermentable_color>";
	echo "</fermentable>";
}

// *** hops ***
// build the SELECT statement for the recipes hops and query the database
$query = "SELECT * FROM recipes_hops WHERE recipe_hop_recipe_id = '" . $recipe_id . "' ORDER BY recipe_hop_amount, recipe_hop_time DESC";
$result1 = mysqli_query($connection, $query) or die(mysqli_error());

// fetch the recipe hop details
while ($row1 = mysqli_fetch_array($result1))
{
	// start the hop xml and output the hop amount xml
	echo "<hop>";
	echo "<hop_amount>" . $row1['recipe_hop_amount'] . "</hop_amount>";
	echo "<hop_alpha>" . $row1['recipe_hop_alpha'] . "</hop_alpha>";
	echo "<hop_use>" . $row1['recipe_hop_use'] . "</hop_use>";
	echo "<hop_time>" . $row1['recipe_hop_time'] . "</hop_time>";
	echo "<hop_form>" . $row1['recipe_hop_form'] . "</hop_form>";

	// save the hop id to query for the hop details
	$hop_id = $row1['recipe_hop_hop_id'];

	// build the SELECT statement for the hop and query the database
	$query = "SELECT * FROM hops where hop_id ='" . $hop_id . "' LIMIT 1";
	$result2 = mysqli_query($connection, $query) or die(mysqli_error());

	// fetch the hop details
	$row2 = mysqli_fetch_array($result2);

	// output the rest of the hop xml
	echo "<hop_id>" . $row2['hop_id'] . "</hop_id>";
	echo "<hop_name>" . $row2['hop_name'] . "</hop_name>";
	echo "</hop>";
}

// *** yeasts ***
// build the SELECT statement for the recipes yeasts and query the database
$query = "SELECT * FROM recipes_yeasts WHERE recipe_yeast_recipe_id = '" . $recipe_id . "'";
$result1 = mysqli_query($connection, $query) or die(mysqli_error());

// fetch the recipe yeast details
while ($row1 = mysqli_fetch_array($result1))
{
	// start the yeast xml 
	echo "<yeast>";

	// save the yeast id to query for the yeast details
	$yeast_id = $row1['recipe_yeast_yeast_id'];

	// build the SELECT statement for the yeast and query the database
	$query = "SELECT * FROM yeasts where yeast_id ='" . $yeast_id . "' LIMIT 1";
	$result2 = mysqli_query($connection, $query) or die(mysqli_error());

	// fetch the yeast details
	$row2 = mysqli_fetch_array($result2);

	// output the rest of the yeast xml
	echo "<yeast_id>" . $row2['yeast_id'] . "</yeast_id>";
	echo "<yeast_name>" . $row2['yeast_fullname'] . "</yeast_name>";
	echo "<yeast_type>" . $row2['yeast_type'] . "</yeast_type>";
	echo "<yeast_form>" . $row2['yeast_form'] . "</yeast_form>";
	echo "<yeast_attenuation>" . $row2['yeast_attenuation'] . "</yeast_attenuation>";
	echo "<yeast_flocculation>" . $row2['yeast_flocculation'] . "</yeast_flocculation>";
	echo "</yeast>";
}

// *** miscs ***
// build the SELECT statement for the recipes miscs and query the database
$query = "SELECT * FROM recipes_miscs WHERE recipe_misc_recipe_id = '" . $recipe_id . "' ORDER BY recipe_misc_amount DESC";
$result1 = mysqli_query($connection, $query) or die(mysqli_error());

// fetch the recipe misc details
while ($row1 = mysqli_fetch_array($result1))
{
	// start the misc xml and output the misc amount xml
	echo "<misc>";
	echo "<misc_amount>" . $row1['recipe_misc_amount'] . "</misc_amount>";
	echo "<misc_unit>" . $row1['recipe_misc_unit'] . "</misc_unit>";
	echo "<misc_use>" . $row1['recipe_misc_use'] . "</misc_use>";

	// save the misc id to query for the misc details
	$misc_id = $row1['recipe_misc_misc_id'];

	// build the SELECT statement for the misc and query the database
	$query = "SELECT * FROM miscs where misc_id ='" . $misc_id . "' LIMIT 1";
	$result2 = mysqli_query($connection, $query) or die(mysqli_error());

	// fetch the misc details
	$row2 = mysqli_fetch_array($result2);

	// output the rest of the misc xml
	echo "<misc_id>" . $row2['misc_id'] . "</misc_id>";
	echo "<misc_name>" . $row2['misc_name'] . "</misc_name>";
	echo "<misc_type>" . $row2['misc_type'] . "</misc_type>";
	echo "</misc>";
}

//close the top-level xml tag
echo "</recipe>";

?>
