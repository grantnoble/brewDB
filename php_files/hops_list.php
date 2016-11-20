<?php

/* 
hops_list.php
List the hops in the database
*/

$page_title = 'List Hops';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// set list by hop_name as the default
$sortby = "hop_name";

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && ($_GET['id']=='hop_name' || $_GET['id']=='hop_alpha'))
{
	$sortby = $_GET['id'];
}

// set the query statement, either by name or alpha
if ($sortby=='hop_alpha')
{
	$query = "SELECT * FROM hops ORDER BY hop_alpha, hop_name";
}
else
{
	$query = "SELECT * FROM hops ORDER BY hop_name";
}

// get results from database
$hops = mysqli_query($connection, $query) or die(mysqli_error($connection));  
                
// display data in table
echo '<div class="container">';
echo "<h2>List Hops</h2>";
echo '<div class="table-responsive">';
echo '<table class="table table-hover table-condensed">';
echo '<tr class="info"> <th><a href="hops_list.php?id=hop_name">Name</a></th> <th><a href="hops_list.php?id=hop_alpha">Alpha</a></th> <th>Origin</th> <th>Substitutes</th> </tr>';

// loop through results of database query, displaying them in the table
while($row = mysqli_fetch_array( $hops ))
{
    // echo out the contents of each row into a table
    echo "<tr>";
	echo '<td><div class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">' . $row['hop_name'] . '</a>';
	echo '<ul class="dropdown-menu">';
	echo '<li><a href="hop_view.php?id=' . $row['hop_id'] . '" role="button">View</a></li>';
	echo '<li><a href="hop_edit.php?id=' . $row['hop_id'] . '" role="button">Edit</a></li>';
	echo '<li><a href="hop_delete.php?id=' . $row['hop_id'] . '" role="button">Delete</a></li>';
    echo '</ul></div></td>';
    echo '<td>' . $row['hop_alpha'] . '</td>';
    echo '<td>' . $row['hop_origin'] . '</td>';
    echo '<td>' . $row['hop_substitutes'] . '</td>';
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
