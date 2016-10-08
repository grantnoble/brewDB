<?php

/* 
yeasts_list.php
List the yeasts in the database
*/

$page_title = 'List Yeasts';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// set list by yeast_fullname as the default
$sortby = "yeast_fullname";

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && ($_GET['id']=='yeast_fullname' || $_GET['id']=='yeast_type' || $_GET['id']=='yeast_form' || $_GET['id']=='yeast_attenuation' || $_GET['id']=='yeast_flocculation'))
{
	$sortby = $_GET['id'];
}

// set the query statement, either by fullname, type, form, attenuation, or flocculation
if ($sortby=='yeast_type')
{
	$query = "SELECT * FROM yeasts ORDER BY CAST(yeast_type AS CHAR), yeast_fullname";
}
elseif ($sortby=='yeast_form')
{
	$query = "SELECT * FROM yeasts ORDER BY CAST(yeast_form AS CHAR), yeast_fullname";
}
elseif ($sortby=='yeast_attenuation')
{
	$query = "SELECT * FROM yeasts ORDER BY yeast_attenuation, yeast_fullname";
}
elseif ($sortby=='yeast_flocculation')
{
	$query = "SELECT * FROM yeasts ORDER BY CAST(yeast_flocculation AS CHAR), yeast_fullname";
}
else
{
	$query = "SELECT * FROM yeasts ORDER BY yeast_fullname";
}

// get results from database
$yeasts = mysqli_query($connection, $query) or die(mysqli_error($connection));  
                
// display data in table
echo '<div class="container">';
echo "<h2>List Yeasts</h2>";
echo '<div class="table-responsive">';
echo '<table class="table table-hover table-condensed">';
echo '<tr class="info"> <th><a href="yeasts_list.php?id=yeast_fullname">Name</a></th> <th><a href="yeasts_list.php?id=yeast_type">Type</a></th> <th><a href="yeasts_list.php?id=yeast_form">Form</a></th> <th><a href="yeasts_list.php?id=yeast_attenuation">Attenuation</a></th> <th><a href="yeasts_list.php?id=yeast_flocculation">Flocculation</a></th> </tr>';

// loop through results of database query, displaying them in the table
while($yeastrow = mysqli_fetch_array( $yeasts ))
{
    // echo out the contents of each row into a table
    echo '<tr>';
    echo '<td><div class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">' . $yeastrow['yeast_fullname'] . '</a>';
	echo '<ul class="dropdown-menu">';
	echo '<li><a href="yeast_view.php?id=' . $row['yeast_id'] . '" role="button">View</a></li>';
	echo '<li><a href="yeast_edit.php?id=' . $row['yeast_id'] . '" role="button">Edit</a></li>';
	echo '<li><a href="yeast_delete.php?id=' . $row['yeast_id'] . '" role="button">Delete</a></li>';
    echo '</ul></div></td>';
    echo '<td>' . $yeastrow['yeast_type'] . '</td>';
    echo '<td>' . $yeastrow['yeast_form'] . '</td>';
    echo '<td>' . $yeastrow['yeast_attenuation'] . '</td>';
    echo '<td>' . $yeastrow['yeast_flocculation'] . '</td>';
    echo '</tr>'; 
    } 

// close table
echo '</table>';
echo '</div>';
echo '</div>';

?>

<?php 
include ('includes/footer.html');
?>
