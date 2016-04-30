<?php

/* 
fermentables_list.php
List the fermentables in the database
*/

$page_title = 'List Fermentables';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

echo "<h2>List Fermentables</h2>";

// get results from database
$query = "SELECT * FROM fermentables ORDER BY fermentable_name";
$fermentables = mysqli_query($connection, $query) or die(mysqli_error($connection));  
                
// display data in table
echo '<table class="list_table">';
echo "<tr> <th>Name</th> <th>Type</th> <th>Yield&nbsp;(%)</th> <th>Color&nbsp;(L)</th> <th>Add&nbsp;After&nbsp;Boil</th> <th>Max&nbsp;in&nbsp;Batch&nbsp;(%)</th> <th>Recommend&nbsp;Mash</th> <th>Origin</th> <th>Supplier</th> <th>Action</th> </tr>";

// loop through results of database query, displaying them in the table
while($row = mysqli_fetch_array( $fermentables ))
{
    // echo out the contents of each row into a table
    echo "<tr>";
    echo '<td><a href="fermentable_view.php?id=' . $row['fermentable_id'] . '">' . $row['fermentable_name'] . '</a></td>';
    echo '<td>' . $row['fermentable_type'] . '</td>';
    echo '<td>' . $row['fermentable_yield'] . '</td>';
    echo '<td>' . $row['fermentable_color'] . '</td>';
    echo '<td>' . $row['fermentable_add_after_boil'] . '</td>';
    echo '<td>' . $row['fermentable_max_in_batch'] . '</td>';
    echo '<td>' . $row['fermentable_recommend_mash'] . '</td>';
    echo '<td>' . $row['fermentable_origin'] . '</td>';
    echo '<td>' . $row['fermentable_supplier'] . '</td>';
    echo '<td><a href="fermentable_view.php?id=' . $row['fermentable_id'] . '">View</a> / ';
    echo '<a href="fermentable_edit.php?id=' . $row['fermentable_id'] . '">Edit</a> / ';
    echo '<a href="fermentable_delete.php?id=' . $row['fermentable_id'] . '">Delete</a></td>';
    echo "</tr>"; 
    } 

// close table
echo "</table>";

?>

<?php 
include ('includes/footer.html');
?>
