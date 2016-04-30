<?php

/* 
hop_new.php
Add a hop to the database
*/

$page_title = 'New Hop';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // retrieve the field values
    $hop['name'] = mysqli_real_escape_string($connection, test_input($_POST['name']));
    $hop['alpha'] = mysqli_real_escape_string($connection, test_input($_POST['alpha']));
    $hop['origin'] = mysqli_real_escape_string($connection, test_input($_POST['origin']));
    $hop['substitutes'] = mysqli_real_escape_string($connection, test_input($_POST['substitutes']));
    $hop['notes'] = mysqli_real_escape_string($connection, test_input($_POST['notes']));
    
    // set up the SQL INSERT
    $columns = "INSERT into hops (hop_name, hop_alpha, hop_origin, hop_substitutes, hop_notes) ";
    $values = "VALUES ('" . $hop['name'] . "', '" . $hop['alpha'] . "', '" . $hop['origin'] . "', '" . $hop['substitutes'] . "', '" . $hop['notes'] . "')";
    $query = $columns . $values;
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    
    // After saving to the database, redirect back to the list hops page 
    header("Location: hops_list.php");
    
}

?>

<h2>New Hop</h2>

<form name="hopform" action="hop_new.php" method="post">
    
<div class="row">
<div class="six_cols">
<div class="float_left">
<fieldset>
    <legend>Hop</legend>

    <label>Name *: </label>
    <input type="text" name="name" size=15 required oninvalid="this.setCustomValidity('Hop name is required.')" onchange="this.setCustomValidity('')" /> 
    
    <label>Alpha (%): </label>
    <input type="number" name="alpha" size=6 style="width: 6em" oninvalid="this.setCustomValidity('Alpha Acid is not numeric.')" onchange="this.setCustomValidity('')" />
    
    <label>Origin: </label>
    <input type="text" name="origin" size=10 />
    
    <p></p>
    
    <label>Subsitutes: </label>
    <input type="text" name="substitutes" size=50 />
    
    <p></p>
    
    <label>Notes: </label>
    <textarea rows=3 cols=130 name="notes"></textarea>

</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->
</div><!-- row -->

<div class="row">
<div class="float_left">
<input type="submit" value="Add Hop">
</div><!-- float_left -->
</div><!-- row -->

</form>

<?php 
include ('includes/footer.html');
?>
