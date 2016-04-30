<?php

/* 
miscs_list.php
List the miscs in the database
*/

$page_title = 'List Miscs';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

echo "<h2>List Miscs</h2>";

// get results from database
$query = "SELECT * FROM miscs ORDER BY misc_name";
$miscs = mysqli_query($connection, $query) or die(mysqli_error($connection));  
                
// display data in table
echo '<table class="list_table">';
echo "<tr> <th>Name</th> <th>Type</th> <th>Use</th> </tr>";

// loop through results of database query, displaying them in the table
while($row = mysqli_fetch_array( $miscs ))
{
    // echo out the contents of each row into a table
    echo "<tr>";
    echo '<td><a href="misc_view.php?id=' . $row['misc_id'] . '">' . $row['misc_name'] . '</a></td>';
    echo '<td>' . $row['misc_type'] . '</td>';
    echo '<td>' . $row['misc_use'] . '</td>';
    echo '<td><a href="misc_view.php?id=' . $row['misc_id'] . '">View</a> / ';
    echo '<a href="misc_edit.php?id=' . $row['misc_id'] . '">Edit</a> / ';
    echo '<a href="misc_delete.php?id=' . $row['misc_id'] . '">Delete</a></td>';
    echo "</tr>"; 
    } 

// close table
echo "</table>";

?>

<?php 
include ('includes/footer.html');
?>
