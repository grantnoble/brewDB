<?php

/* 
misc_new.php
Add a misc to the database
*/

$page_title = 'New Misc';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // retrieve the field values
    $misc['name'] = mysqli_real_escape_string($connection, test_input($_POST['name']));
    $misc['type'] = mysqli_real_escape_string($connection, test_input($_POST['type']));
    $misc['use'] = mysqli_real_escape_string($connection, test_input($_POST['use']));
    $misc['use_for'] = mysqli_real_escape_string($connection, test_input($_POST['use_for']));
    $misc['notes'] = mysqli_real_escape_string($connection, test_input($_POST['notes']));
    
    // set up the SQL INSERT
    $columns = "INSERT into miscs (misc_name, misc_type, misc_use, misc_use_for, misc_notes) ";
    $values = "VALUES ('" . $misc['name'] . "', '" . $misc['type'] . "', '" . $misc['use'] . "', '" . $misc['use_for'] . "', '" . $misc['notes'] . "')";
    $query = $columns . $values;
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    
    // After saving to the database, redirect back to the list miscs page 
    header("Location: miscs_list.php");
    
}

?>

<h2>New Misc</h2>

<form name="miscform" action="misc_new.php" method="post">
    
<div class="row">
<div class="six_cols">
<div class="float_left">
<fieldset>
    <legend>Misc</legend>

    <label>Name *: </label>
    <input type="text" name="name" size=15 required oninvalid="this.setCustomValidity('Misc name is required.')" onchange="this.setCustomValidity('')" /> 
    
    <label>Type: </label>
    <select name="type">
        <option></option>
        <option>Spice</option>
        <option>Fining</option>
        <option>Water Agent</option>
        <option>Herb</option>
        <option>Flavor</option>
        <option>Other</option>
        </select>
    
    <label>Use: </label>
    <select name="use">
        <option></option>
        <option>Mash</option>
        <option>Boil</option>
        <option>Primary</option>
        <option>Secondary</option>
        <option>Bottling</option>
        </select>
    
    <p></p>
    
    <label>Use For: </label>
    <input type="text" name="use_for" size=50 />
    
    <p></p>
    
    <label>Notes: </label>
    <textarea rows=3 cols=130 name="notes"></textarea>

</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->
</div><!-- row -->

<div class="row">
<div class="float_left">
<input type="submit" value="Add Misc">
</div><!-- float_left -->
</div><!-- row -->

</form>

<?php 
include ('includes/footer.html');
?>
