<?php

/* 
styles_list.php
List the styles in the database
*/

$page_title = 'List Styles';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

// get results from database
$query = "SELECT * FROM styles ORDER BY style_category, style_subcategory";
$styles = mysqli_query($connection, $query) or die(mysqli_error($connection));  
                
// display data in table
echo '<div class="container">';
echo '<h2>List Styles - BJCP 2008</h2>';
echo '<div class="table-responsive">';
echo '<table class="table table-hover table-condensed">';
echo '<tr class="info"><th rowspan="2" style="vertical-align: bottom">Style</th><th rowspan="2" class="text-right" style="vertical-align: bottom">Type</th><th colspan="2" style="text-align: center">&nbsp;&nbsp;OG</th><th colspan="2" style="text-align: center">&nbsp;&nbsp;FG</th><th colspan="2" style="text-align: center">Color</th><th colspan="2" style="text-align: center">IBU</th><th colspan="2" style="text-align: center">ABV</th></tr>';
echo '<tr class="info"><th class="text-right">Min</th> <th class="text-right">Max</th><th class="text-right">Min</th> <th class="text-right">Max</th><th class="text-right">Min</th> <th class="text-right">Max</th> <th class="text-right">Min</th> <th class="text-right">Max</th><th class="text-right">Min</th> <th class="text-right">Max</th></tr>';


// loop through results of database query, displaying them in the table
$category = 0;
while($row = mysqli_fetch_array( $styles ))
{
	if ($row['style_category'] != $category)
	{
		$category = $row['style_category'];
		echo '<tr class="info"><th colspan="12">Category ' . $row['style_category'] . ' ' . $row['style_category_name'] . '</th></tr>';
		echo '<tr>';
		echo '<td><div class="dropdown"><a href="style_view.php?style_id=' . $row['style_id'] . '">' . $row['style_category'] . $row['style_subcategory'] . ' ' . $row['style_name'] . '</a></td>';
		echo '<td class="text-right">' . $row['style_type'] . '</td><td class="text-right">' . $row['style_og_min'] . '</td><td class="text-right">' . $row['style_og_max'] . '</td>';
		echo '<td class="text-right">' . $row['style_fg_min'] . '</td><td class="text-right">' . $row['style_fg_max'] . '</td><td class="text-right">' . $row['style_ibu_min'] . '</td>';
		echo '<td class="text-right">' . $row['style_ibu_max'] . '</td><td class="text-right">' . $row['style_color_min'] . '</td><td class="text-right">' . $row['style_color_max'] . '</td>';
		echo '<td class="text-right">' . $row['style_abv_min'] . '</td><td class="text-right">' . $row['style_abv_max'] . '</td>';
		echo '</tr>';

	}
	else
	{
		echo '<tr>';
		echo '<td><div class="dropdown"><a href="style_view.php?style_id=' . $row['style_id'] . '">' . $row['style_category'] . $row['style_subcategory'] . ' ' . $row['style_name'] . '</a></td>';
		echo '<td class="text-right">' . $row['style_type'] . '</td><td class="text-right">' . $row['style_og_min'] . '</td><td class="text-right">' . $row['style_og_max'] . '</td>';
		echo '<td class="text-right">' . $row['style_fg_min'] . '</td><td class="text-right">' . $row['style_fg_max'] . '</td><td class="text-right">' . $row['style_ibu_min'] . '</td>';
		echo '<td class="text-right">' . $row['style_ibu_max'] . '</td><td class="text-right">' . $row['style_color_min'] . '</td><td class="text-right">' . $row['style_color_max'] . '</td>';
		echo '<td class="text-right">' . $row['style_abv_min'] . '</td><td class="text-right">' . $row['style_abv_max'] . '</td>';
		echo '</tr>';
	}
}

echo '</table>';
echo '</div>';
echo '</div>';

?>

<?php 
include '../includes/footer.html';
?>
