<?php

/*
recipes_list.php
List the recipes in the database by date
*/

$page_title = 'List Recipes';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

// set list by date as the default
$sortby = "date";

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && ($_GET['id']=='date' || $_GET['id']=='category' || $_GET['id']=='style_name'))
{
	$sortby = $_GET['id'];
}

// set the query statement, either by style or by date
if ($sortby=='category')
{
	$query = "SELECT recipe_id, recipe_name, recipe_type, recipe_date, style_guide, style_category, style_subcategory, style_name FROM recipes INNER JOIN styles ON recipe_style_id=style_id ORDER BY style_category, style_subcategory, recipe_date";
}
elseif ($sortby=='style_name')
{
	$query = "SELECT recipe_id, recipe_name, recipe_type, recipe_date, style_guide, style_category, style_subcategory, style_name FROM recipes INNER JOIN styles ON recipe_style_id=style_id ORDER BY style_name, recipe_date";
}
else
{
	$query = "SELECT recipe_id, recipe_name, recipe_type, recipe_date, style_guide, style_category, style_subcategory, style_name FROM recipes INNER JOIN styles ON recipe_style_id=style_id ORDER BY recipe_date DESC";
}

// get results from database
$recipes = mysqli_query($connection, $query) or die(mysqli_error($connection));

// display data in table
echo '<div class="container">';
echo '<h2>List Recipes</h2>';
echo '<div class="table-responsive">';
echo '<table class="table table-hover table-condensed">';
echo '<tr class="info"> <th>Recipe Name</th><th><a href="recipes_list.php?id=category">BJCP Category</a></th><th><a href="recipes_list.php?id=style_name">Style Name</a></th><th>Recipe Type</th> <th><a href="recipes_list.php?id=date">Date</a></th></tr>';

// loop through results of database query, displaying them in the table
while($row = mysqli_fetch_array( $recipes ))
{
    // echo out the contents of each row into a table
    echo '<tr>';
    echo '<td><div class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">' . $row['recipe_name'] . '</a>';
	echo '<ul class="dropdown-menu">';
	echo '<li><a href="recipe_view.php?id=' . $row['recipe_id'] . '" role="button">View</a></li>';
	echo '<li><a href="recipe_edit.php?id=' . $row['recipe_id'] . '" role="button">Edit</a></li>';
	echo '<li><a href="recipe_delete.php?id=' . $row['recipe_id'] . '" role="button">Delete</a></li>';
    echo '</ul></div></td>';
    echo '<td>' . $row['style_guide']. ' ' . $row['style_category'] . $row['style_subcategory'] . '</td>';
    echo '<td>' . $row['style_name'] . '</td>';
    echo '<td>' . $row['recipe_type'] . '</td>';
	echo '<td>' . $row['recipe_date'] . '</td>';
    echo "</tr>";
    }

// close table
echo "</table>";
echo '</div>';
echo '</div>';

?>

<?php
include '../includes/footer.html';
?>
