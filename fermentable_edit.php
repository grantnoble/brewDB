<?php

/* 
fermentable_edit.php
Edit a fermentable in the database
*/

$page_title = 'Edit Fermentable';
$error = "";
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // form validation OK, so retrieve the field values
    $fermentable['id'] = mysqli_real_escape_string($connection, test_input($_POST['id']));
    $fermentable['name'] = mysqli_real_escape_string($connection, test_input($_POST['name']));
    $fermentable['type'] = mysqli_real_escape_string($connection, test_input($_POST['type']));
    $fermentable['yield'] = mysqli_real_escape_string($connection, test_input($_POST['yield']));
    $fermentable['color'] = mysqli_real_escape_string($connection, test_input($_POST['color']));
    $fermentable['add_after_boil'] = mysqli_real_escape_string($connection, test_input($_POST['add_after_boil']));
    $fermentable['max_in_batch'] = mysqli_real_escape_string($connection, test_input($_POST['max_in_batch']));
    $fermentable['recommend_mash'] = mysqli_real_escape_string($connection, test_input($_POST['recommend_mash']));
    $fermentable['origin'] = mysqli_real_escape_string($connection, test_input($_POST['origin']));
    $fermentable['supplier'] = mysqli_real_escape_string($connection, test_input($_POST['supplier']));
    $fermentable['notes'] = mysqli_real_escape_string($connection, test_input($_POST['notes']));
    
    $query = "UPDATE fermentables SET fermentable_name='" . $fermentable['name'] . "', fermentable_type='" . $fermentable['type'] . "', fermentable_yield=" . $fermentable['yield'] . ", fermentable_color=" . $fermentable['color'] . ", fermentable_add_after_boil='" . $fermentable['add_after_boil'] . "', fermentable_max_in_batch=" . $fermentable['max_in_batch'] . ", fermentable_recommend_mash='" . $fermentable['recommend_mash'] . "', fermentable_origin='" . $fermentable['origin'] . "', fermentable_supplier='" . $fermentable['supplier'] . "', fermentable_notes='" . $fermentable['notes'] . "' WHERE fermentable_id='" . $fermentable['id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    
    // After saving to the database, redirect back to the list fermentables page 
    header("Location: fermentables_list.php");
    
}

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
    // get the fermentable
    $query = "SELECT * FROM fermentables WHERE fermentable_id='" . $_GET['id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection)); 
 
}
// if id isn't set, or isn't valid, redirect back to view page
else
{
    header("Location: fermentables_list.php");
}

while($row = mysqli_fetch_array( $result ))
{
    $id = $row['fermentable_id'];
    $name = $row['fermentable_name'];
    $type = $row['fermentable_type'];
    $yield = $row['fermentable_yield'];
    $color = $row['fermentable_color'];
    $add_after_boil = $row['fermentable_add_after_boil'];
    $max_in_batch = $row['fermentable_max_in_batch'];
    $recommend_mash = $row['fermentable_recommend_mash'];
    $origin = $row['fermentable_origin'];
    $supplier = $row['fermentable_supplier'];
    $notes = $row['fermentable_notes'];
}

?>

<h2>Edit Fermentable</h2>

<form name="fermentableform" action="fermentable_edit.php" method="post">
    
<div class="row">
<div class="six_cols">
<div class="float_left">
<fieldset>
    <legend>Fermentable</legend>

    <label>Name *: </label>
    <input type="text" name="name" size=15 required oninvalid="this.setCustomValidity('Fermenatable name is required.')" onchange="this.setCustomValidity('')" value="<?php if (isset($_POST['name'])) {echo $_POST['name'];} else {echo $name;} ?>" />
    
    <label>Type: </label>
    <select name="type">
        <option><?php if (isset($_POST['type'])) {echo $_POST['type'];} else {echo $type;} ?></option>
        <option>Grain</option>
        <option>Extract</option>
        <option>Dry Extract</option>
        <option>Sugar</option>
        </select>
        
    <label>Yield (%): </label>
    <input type="number" name="yield" size=6 style="width: 6em" oninvalid="this.setCustomValidity('Yield is not numeric.')" onchange="this.setCustomValidity('')" value="<?php if (isset($_POST['yield'])) {echo $_POST['yield'];} else {echo $yield;} ?>" />
    
    <label>Color (L): </label>
    <input type="number" name="color" size=6 style="width: 6em" oninvalid="this.setCustomValidity('Color is not numeric.')" onchange="this.setCustomValidity('')" value="<?php if (isset($_POST['color'])) {echo $_POST['color'];} else {echo $color;} ?>" />
    
    <p></p>
    
    <label>Add after boil: </label>
    <select name="add_after_boil">
        <option><?php if (isset($_POST['add_after_boil'])) {if ($_POST['add_after_boil']) {echo 'True';} else {echo 'False';}} else {if ($add_after_boil) {echo 'True';} else {echo 'False';}} ?></option>
        <option>True</option>
        <option>False</option>
    </select>
        
    <label>Max in Batch (%): </label>
    <input type="number" name="max_in_batch" size=6 style="width: 6em" oninvalid="this.setCustomValidity('Color is not numeric.')" onchange="this.setCustomValidity('')" value="<?php if (isset($_POST['max_in_batch'])) {echo $_POST['max_in_batch'];} else {echo $max_in_batch;} ?>" />
    
    <label>Recommend Mash: </label>
    <select name="recommend_mash">
        <option><?php if (isset($_POST['recommend_mash'])) {if ($_POST['recommend_mash']) {echo 'True';} else {echo 'False';}} else {if ($recommend_mash) {echo 'True';} else {echo 'False';}} ?></option>
        <option>True</option>
        <option>False</option>
    </select>
        
    <p></p>
    
    <label>Origin: </label>
    <input type="text" name="origin" size=10 value="<?php if (isset($_POST['origin'])) {echo $_POST['origin'];} else {echo $origin;} ?>" />
    
    <label>Supplier: </label>
    <input type="text" name="supplier" size=15 value="<?php if (isset($_POST['supplier'])) {echo $_POST['supplier'];} else {echo $supplier;} ?>" />
    
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
<input type="submit" value="Update Fermentable" />
</div><!-- float_left -->
</div><!-- row -->

</form>

<?php 
include ('includes/footer.html');
?>
