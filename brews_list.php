<?php

/*
brews_list.php
List the brews in the database by date
*/

$page_title = 'List Brews';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// set list by date as the default
$sortby = "date";

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && ($_GET['id']=='date' || $_GET['id']=='style'))
{
	$sortby = $_GET['id'];
}

// set the query statement, either by style or by date
if ($sortby=='style')
{
	$query = "SELECT brew_id, brew_name, brew_type, brew_date, style_category_number, style_style_letter, style_name FROM brews INNER JOIN styles ON brew_style_id=style_id ORDER BY style_category_number, style_style_letter, brew_date";
}
else
{
	$query = "SELECT brew_id, brew_name, brew_type, brew_date, style_category_number, style_style_letter, style_name FROM brews INNER JOIN styles ON brew_style_id=style_id ORDER BY brew_date DESC";
}

// get results from database
$brews = mysqli_query($connection, $query) or die(mysqli_error($connection));

// display data in table
echo '<tr><td><h2>List Brews</h2></td></tr>';
echo '<table class="list_table">';
echo '<tr> <th>Name</th> <th colspan="2"><a href="brews_list.php?id=style">Style and Category</a></th> <th>Type</th> <th><a href="brews_list.php?id=date">Date</a></th> <th>Action</th> </tr>';

// loop through results of database query, displaying them in the table
while($row = mysqli_fetch_array( $brews ))
{
    // echo out the contents of each row into a table
    echo '<tr>';
    echo '<td><a href="brews_view.php?id=' . $row['brew_id'] . '">' . $row['brew_name'] . '</a></td>';
    echo '<td>' . $row['style_category_number'] . $row['style_style_letter'] . '</td>';
    echo '<td>' . $row['style_name'] . '</td>';
    echo '<td>' . $row['brew_type'] . '</td>';
	echo '<td>' . $row['brew_date'] . '</td>';
    echo '<td><a href="brews_view.php?id=' . $row['brew_id'] . '">View</a> / ';
    echo '<a href="brews_edit.php?id=' . $row['brew_id'] . '">Edit</a> / ';
    echo '<a href="brews_delete.php?id=' . $row['brew_id'] . '">Delete</a></td>';
    echo "</tr>";
    }

// close table
echo "</table>";

?>

<?php
include ('includes/footer.html');
?>
