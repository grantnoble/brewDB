<?php

/*
miscs_list.php
List the miscellaneous ingredients in the database
*/

$page_title = 'List Miscellaneous Ingredients';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

// set list by misc_name as the default
$sortby = "misc_name";

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && ($_GET['id']=='misc_name' || $_GET['id']=='misc_type' || $_GET['id']=='misc_use'))
{
	$sortby = $_GET['id'];
}

// set the query statement, either by name, type, origin, or supplier
if ($sortby=='misc_type')
{
	$query = "SELECT * FROM miscs ORDER BY CAST(misc_type AS CHAR), misc_name";
}
elseif ($sortby=='misc_use')
{
	$query = "SELECT * FROM miscs ORDER BY CAST(misc_use AS CHAR), misc_name";
}
else
{
	$query = "SELECT * FROM miscs ORDER BY misc_name";
}


// get results from database
$miscs = mysqli_query($connection, $query) or die(mysqli_error($connection));

// display data in table
echo '<div class="container">';
echo "<h2>List Miscellaneous</h2>";
echo '<div class="table-responsive">';
echo '<table class="table table-hover table-condensed">';
echo '<tr> <th><a href="miscs_list.php?id=misc_name">Name</a></th> <th><a href="miscs_list.php?id=misc_type">Type</a></th> <th><a href="miscs_list.php?id=misc_use">Use</a></th> </tr>';

// loop through results of database query, displaying them in the table
while($row = mysqli_fetch_array( $miscs ))
{
    // echo out the contents of each row into a table
	echo "<tr>";
	echo '<td><div class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">' . $row['misc_name'] . '</a>';
	echo '<ul class="dropdown-menu">';
	echo '<li><a href="misc_view.php?id=' . $row['misc_id'] . '" role="button">View</a></li>';
	echo '<li><a href="misc_edit.php?id=' . $row['misc_id'] . '" role="button">Edit</a></li>';
	echo '<li><a href="misc_delete.php?id=' . $row['misc_id'] . '" role="button">Delete</a></li>';
    echo '</ul></div></td>';
	echo '<td>' . $row['misc_type'] . '</td>';
	echo '<td>' . $row['misc_use'] . '</td>';
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
