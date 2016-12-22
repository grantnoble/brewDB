<?php

/* 
styles_list.php
List the styles in the database
*/

$page_title = 'List Styles';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

// get results from database
$query = "SELECT * FROM styles ORDER BY style_category_number, style_subcategory";
$styles = mysqli_query($connection, $query) or die(mysqli_error($connection));  
                
// display data in table
echo '<div class="container">';
echo '<h2>List Styles</h2>';
echo '<div class="table-responsive">';
echo '<table class="table table-hover table-condensed">';
echo '<tr class="info"><th rowspan="2" style="vertical-align: bottom">Style</th><th rowspan="2" class="text-right" style="vertical-align: bottom">Type</th><th colspan="2" style="text-align: center">&nbsp;&nbsp;OG</th><th colspan="2" style="text-align: center">&nbsp;&nbsp;FG</th><th colspan="2" style="text-align: center">Color</th><th colspan="2" style="text-align: center">IBU</th><th colspan="2" style="text-align: center">ABV</th></tr>';
echo '<tr class="info"><th class="text-right">Min</th> <th class="text-right">Max</th><th class="text-right">Min</th> <th class="text-right">Max</th><th class="text-right">Min</th> <th class="text-right">Max</th> <th class="text-right">Min</th> <th class="text-right">Max</th><th class="text-right">Min</th> <th class="text-right">Max</th></tr>';


// loop through results of database query, displaying them in the table
$category = 0;
while($row = mysqli_fetch_array( $styles ))
{
	if ($row['style_category_number'] != $category)
	{
		$category = $row['style_category_number'];
		echo '<tr class="info"><th colspan="12">' . $row['style_style_guide'] . ' - Category ' . $row['style_category_number'] . ' ' . $row['style_category_name'] . '</th></tr>';
		echo '<tr>';
		echo '<td><div class="dropdown">';
		echo '<a class="dropdown-toggle" data-toggle="dropdown">' . $row['style_category_number'] . $row['style_subcategory'] . ' ' . $row['style_name'] . '</a>';
		echo '<ul class="dropdown-menu">';
		echo '<li><a href="style_view.php?style_id=' . $row['style_id'] . '" role="button">View</a></li>';
		echo '<li><a href="style_edit.php?style_id=' . $row['style_id'] . '" role="button">Edit</a></li>';
		echo '<li><a href="style_delete.php?style_id=' . $row['style_id'] . '" role="button">Delete</a></li>';
		echo '</ul></div></td>';
		echo '<td class="text-right">' . $row['style_type'] . '</td><td class="text-right">' . $row['style_og_min'] . '</td><td class="text-right">' . $row['style_og_max'] . '</td>';
		echo '<td class="text-right">' . $row['style_fg_min'] . '</td><td class="text-right">' . $row['style_fg_max'] . '</td><td class="text-right">' . $row['style_ibu_min'] . '</td>';
		echo '<td class="text-right">' . $row['style_ibu_max'] . '</td><td class="text-right">' . $row['style_color_min'] . '</td><td class="text-right">' . $row['style_color_max'] . '</td>';
		echo '<td class="text-right">' . $row['style_abv_min'] . '</td><td class="text-right">' . $row['style_abv_max'] . '</td>';
		echo '</tr>';

	}
	else
	{
		echo '<tr>';
		echo '<td><div class="dropdown">';
		echo '<a class="dropdown-toggle" data-toggle="dropdown">' . $row['style_category_number'] . $row['style_subcategory'] . ' ' . $row['style_name'] . '</a>';
		echo '<ul class="dropdown-menu">';
		echo '<li><a href="style_view.php?id=' . $row['style_id'] . '" role="button">View</a></li>';
		echo '<li><a href="style_edit.php?id=' . $row['style_id'] . '" role="button">Edit</a></li>';
		echo '<li><a href="style_delete.php?id=' . $row['style_id'] . '" role="button">Delete</a></li>';
		echo '</ul></div></td>';
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
