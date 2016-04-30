<?php

/* 
misc_edit.php
Edit a misc in the database
*/

$page_title = 'Edit Misc';
$error = "";
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // form validation OK, so retrieve the field values
    $misc['id'] = mysqli_real_escape_string($connection, test_input($_POST['id']));
    $misc['name'] = mysqli_real_escape_string($connection, test_input($_POST['name']));
    $misc['type'] = mysqli_real_escape_string($connection, test_input($_POST['type']));
    $misc['use'] = mysqli_real_escape_string($connection, test_input($_POST['use']));
    $misc['use_for'] = mysqli_real_escape_string($connection, test_input($_POST['use_for']));
    $misc['notes'] = mysqli_real_escape_string($connection, test_input($_POST['notes']));
    
    $query = "UPDATE miscs SET misc_name='" . $misc['name'] . "', misc_type='" . $misc['type'] . "', misc_use='" . $misc['use'] . "', misc_use_for='" . $misc['use_for'] . "', misc_notes='" . $misc['notes'] . "' WHERE misc_id='" . $misc['id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    
    // After saving to the database, redirect back to the list miscs page 
    header("Location: miscs_list.php");
    
}

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
    // get the misc
    $query = "SELECT * FROM miscs WHERE misc_id='" . $_GET['id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection)); 
 
}
// if id isn't set, or isn't valid, redirect back to view page
else
{
    header("Location: miscs_list.php");
}

while($row = mysqli_fetch_array( $result ))
{
    $id = $row['misc_id'];
    $name = $row['misc_name'];
    $type = $row['misc_type'];
    $use = $row['misc_use'];
    $use_for = $row['misc_use_for'];
    $notes = $row['misc_notes'];
}

?>

<h2>Edit Misc</h2>

<form name="miscform" action="misc_edit.php" method="post">
    
<div class="row">
<div class="six_cols">
<div class="float_left">
<fieldset>
    <legend>Misc</legend>

    <label>Name *: </label>
    <input type="text" name="name" size=15 required oninvalid="this.setCustomValidity('Misc name is required.')" onchange="this.setCustomValidity('')" value="<?php if (isset($_POST['name'])) {echo $_POST['name'];} else {echo $name;} ?>" />
    
    <label>Type: </label>
    <select name="type">
        <option><?php if (isset($_POST['type'])) {echo $_POST['type'];} else {echo $type;} ?></option>
        <option>Spice</option>
        <option>Fining</option>
        <option>Water Agent</option>
        <option>Herb</option>
        <option>Flavor</option>
        <option>Other</option>
        </select>
    
    <label>Use: </label>
    <select name="use">
        <option><?php if (isset($_POST['use'])) {echo $_POST['use'];} else {echo $use;} ?></option>
        <option>Mash</option>
        <option>Boil</option>
        <option>Primary</option>
        <option>Secondary</option>
        <option>Bottling</option>
        </select>
    
    <p></p>
    
    <label>Use For: </label>
    <input type="text" name="use_for" size=50 value="<?php if (isset($_POST['use_for'])) {echo $_POST['use_for'];} else {echo $use_for;} ?>" />
    
    <p></p>
    
    <label>Notes: </label>
    <textarea rows=3 cols=130 name="notes"><?php if (isset($_POST['notes'])) {echo $_POST['notes'];} else {echo $notes;} ?></textarea>
    
</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->
</div><!-- row -->

<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<div class="row">
<div class="float_left">
<input type="submit" value="Update Misc" />
</div><!-- float_left -->
</div><!-- row -->

</form>

<?php 
include ('includes/footer.html');
?>
