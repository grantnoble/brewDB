<?php

/* 
fermentables_list.php
List the fermentables in the database
*/

$page_title = 'List Fermentables';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// set list by fermentable_name as the default
$sortby = "fermentable_name";

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && ($_GET['id']=='fermentable_name' || $_GET['id']=='fermentable_type' || $_GET['id']=='fermentable_origin' || $_GET['id']=='fermentable_supplier'))
{
	$sortby = $_GET['id'];
}

// set the query statement, either by name, type, origin, or supplier
if ($sortby=='fermentable_supplier')
{
	$query = "SELECT * FROM fermentables ORDER BY fermentable_supplier, fermentable_name";
}
elseif ($sortby=='fermentable_origin')
{
	$query = "SELECT * FROM fermentables ORDER BY fermentable_origin, fermentable_name";
}
elseif ($sortby=='fermentable_type')
{
	$query = "SELECT * FROM fermentables ORDER BY CAST(fermentable_type AS CHAR), fermentable_name";
}
else
{
	$query = "SELECT * FROM fermentables ORDER BY fermentable_name";
}

// get results from database
$fermentables = mysqli_query($connection, $query) or die(mysqli_error($connection));  
                
// display data in table
echo '<div class="container">';
echo "<h2>List Fermentables</h2>";
echo '<div class="table-responsive">';
echo '<table class="table table-hover table-condensed">';
echo '<tr class="info"> <th><a href="fermentables_list.php?id=fermentable_name">Name</a></th> <th><a href="fermentables_list.php?id=fermentable_type">Type</a></th> <th>Yield&nbsp;(%)</th> <th>Color&nbsp;(L)</th> <th>Add&nbsp;After&nbsp;Boil</th> <th>Max&nbsp;in&nbsp;Batch&nbsp;(%)</th> <th>Recommend&nbsp;Mash</th> <th><a href="fermentables_list.php?id=fermentable_origin">Origin</a></th> <th><a href="fermentables_list.php?id=fermentable_supplier">Supplier</a></th> </tr>';

// loop through results of database query, displaying them in the table
while($row = mysqli_fetch_array( $fermentables ))
{
    // echo out the contents of each row into a table
	echo '<tr>';
	echo '<td><div class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">' . $row['fermentable_name'] . '</a>';
	echo '<ul class="dropdown-menu">';
	echo '<li><a href="fermentable_view.php?id=' . $row['fermentable_id'] . '" role="button">View</a></li>';
	echo '<li><a href="fermentable_edit.php?id=' . $row['fermentable_id'] . '" role="button">Edit</a></li>';
	echo '<li><a href="fermentable_delete.php?id=' . $row['fermentable_id'] . '" role="button">Delete</a></li>';
    echo '</ul></div></td>';
	echo '<td>' . $row['fermentable_type'] . '</td>';
	echo '<td>' . $row['fermentable_yield'] . '</td>';
	echo '<td>' . $row['fermentable_color'] . '</td>';
	echo '<td>' . $row['fermentable_add_after_boil'] . '</td>';
	echo '<td>' . $row['fermentable_max_in_batch'] . '</td>';
	echo '<td>' . $row['fermentable_recommend_mash'] . '</td>';
	echo '<td>' . $row['fermentable_origin'] . '</td>';
	echo '<td>' . $row['fermentable_supplier'] . '</td>';
	echo "</tr>"; 
    } 

// close table
echo '</table>';
echo '</div>';
echo '</div>';

?>

<?php 
include ('includes/footer.html');
?>
