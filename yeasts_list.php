<?php

/* 
yeasts_list.php
List the yeasts in the database
*/

$page_title = 'List Yeasts';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

echo "<h2>List Yeasts</h2>";

// get results from database
$query = "SELECT * FROM yeasts ORDER BY yeast_laboratory, yeast_type, yeast_product_id";
$yeasts = mysqli_query($connection, $query) or die(mysqli_error($connection));  
                
// display data in table
echo '<table class="list_table">';
echo '<tr> <th>Yeast</th> <th>Type</th> <th>Form</th> <th>Attenuation</th> <th>Flocculation</th> <th>Action</th></tr>';

// loop through results of database query, displaying them in the table
while($yeastrow = mysqli_fetch_array( $yeasts ))
{
    // echo out the contents of each row into a table
    echo '<tr>';
    echo '<td><a href="yeast_view.php?id=' . $yeastrow['yeast_id'] . '">' . $yeastrow['yeast_laboratory'] . " " . $yeastrow['yeast_product_id'] . " " . $yeastrow['yeast_name'] . '</a></td>';
    echo '<td>' . $yeastrow['yeast_type'] . '</td>';
    echo '<td>' . $yeastrow['yeast_form'] . '</td>';
    echo '<td>' . $yeastrow['yeast_attenuation'] . '</td>';
    echo '<td>' . $yeastrow['yeast_flocculation'] . '</td>';
    echo '<td><a href="yeast_view.php?id=' . $yeastrow['yeast_id'] . '">View</a> / ';
    echo '<a href="yeast_edit.php?id=' . $yeastrow['yeast_id'] . '">Edit</a> / ';
    echo '<a href="yeast_delete.php?id=' . $yeastrow['yeast_id'] . '">Delete</a></td>';
    echo '</tr>'; 
    } 

// close table
echo "</table>";

?>

<?php 
include ('includes/footer.html');
?>
