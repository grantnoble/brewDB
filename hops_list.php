<?php

/* 
hops_list.php
List the hops in the database
*/

$page_title = 'List Hops';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

echo "<h2>List Hops</h2>";

// get results from database
$query = "SELECT * FROM hops ORDER BY hop_name";
$hops = mysqli_query($connection, $query) or die(mysqli_error($connection));  
                
// display data in table
echo '<table class="list_table">';
echo "<tr> <th>Name</th> <th>Alpha</th> <th>Origin</th> <th>Substitutes</th> <th>Action</th> </tr>";

// loop through results of database query, displaying them in the table
while($row = mysqli_fetch_array( $hops ))
{
    // echo out the contents of each row into a table
    echo "<tr>";
    echo '<td><a href="hop_view.php?id=' . $row['hop_id'] . '">' . $row['hop_name'] . '</a></td>';
    echo '<td>' . $row['hop_alpha'] . '</td>';
    echo '<td>' . $row['hop_origin'] . '</td>';
    echo '<td>' . $row['hop_substitutes'] . '</td>';
    echo '<td><a href="hop_view.php?id=' . $row['hop_id'] . '">View</a> / ';
    echo '<a href="hop_edit.php?id=' . $row['hop_id'] . '">Edit</a> / ';
    echo '<a href="hop_delete.php?id=' . $row['hop_id'] . '">Delete</a></td>';
    echo "</tr>"; 
    } 

// close table
echo "</table>";

?>

<?php 
include ('includes/footer.html');
?>
