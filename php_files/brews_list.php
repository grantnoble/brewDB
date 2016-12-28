<?php

/*
brews_list.php
List the brews in the database by date
*/

$page_title = 'List Brews';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

// set list by date as the default
$sortby = "date";

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && ($_GET['id']=='date' || $_GET['id']=='style_category' || $_GET['id']=='style_name'))
{
	$sortby = $_GET['id'];
}

// set the query statement, either by style or by date
if ($sortby=='style_category')
{
	$query = "SELECT brew_id, brew_name, brew_type, brew_date, style_style_guide, style_category_number, style_subcategory, style_name FROM brews INNER JOIN styles ON brew_style_id=style_id ORDER BY style_category_number, style_subcategory, brew_date";
}
elseif ($sortby=='style_name')
{
	$query = "SELECT brew_id, brew_name, brew_type, brew_date, style_style_guide, style_category_number, style_subcategory, style_name FROM brews INNER JOIN styles ON brew_style_id=style_id ORDER BY style_name, brew_date";
}
else
{
	$query = "SELECT brew_id, brew_name, brew_type, brew_date, style_style_guide, style_category_number, style_subcategory, style_name FROM brews INNER JOIN styles ON brew_style_id=style_id ORDER BY brew_date DESC";
}

// get results from database
$recipes = mysqli_query($connection, $query) or die(mysqli_error($connection));

// display data in table
echo '<div class="container">';
echo '<h2>List Brews</h2>';
echo '<div class="table-responsive">';
echo '<table class="table table-hover table-condensed">';
echo '<tr class="info"> <th>Brew Name</th><th><a href="brews_list.php?id=style_category">BJCP Category</a></th><th><a href="brews_list.php?id=style_name">Style Name</a></th><th>Brew Type</th> <th><a href="brews_list.php?id=date">Date</a></th></tr>';

// loop through results of database query, displaying them in the table
while($row = mysqli_fetch_array( $recipes ))
{
    // echo out the contents of each row into a table
    echo '<tr>';
    echo '<td><div class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">' . $row['brew_name'] . '</a>';
	echo '<ul class="dropdown-menu">';
	echo '<li><a href="brew_view.php?id=' . $row['brew_id'] . '" role="button">View</a></li>';
	echo '<li><a href="brew_edit.php?id=' . $row['brew_id'] . '" role="button">Edit</a></li>';
	echo '<li><a href="brew_delete.php?id=' . $row['brew_id'] . '" role="button">Delete</a></li>';
    echo '</ul></div></td>';
    echo '<td>' . $row['style_style_guide']. ' ' . $row['style_category_number'] . $row['style_subcategory'] . '</td>';
    echo '<td>' . $row['style_name'] . '</td>';
    echo '<td>' . $row['brew_type'] . '</td>';
	echo '<td>' . $row['brew_date'] . '</td>';
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
