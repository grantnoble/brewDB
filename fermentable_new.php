<?php

/* 
fermentable_new.php
Add a fermentable to the database
*/

$page_title = 'New Fermentable';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // retrieve the field values
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
    
    // set up the SQL INSERT
    $columns = "INSERT into fermentables (fermentable_name, fermentable_type, fermentable_yield, fermentable_color, fermentable_add_after_boil, fermentable_max_in_batch, fermentable_recommend_mash, fermentable_origin, fermentable_supplier, fermentable_notes) ";
    $values = "VALUES ('" . $fermentable['name'] . "', '" . $fermentable['type'] . "', '" . $fermentable['yield'] . "', '" . $fermentable['color'] . "', '" . $fermentable['add_after_boil'] . "', '" . $fermentable['max_in_batch'] . "', '" . $fermentable['recommend_mash'] . "', '" . $fermentable['origin'] . "', '" . $fermentable['supplier'] . "', '" . $fermentable['notes'] . "')";
    $query = $columns . $values;
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    
    // After saving to the database, fermentable_new.php
    header("Location: fermentable_new.php");
    
}

$name = $type = $yield = $color = $add_after_boil = $max_in_batch = $recommend_mash = $origin = $supplier = $notes = $error = "";

?>

<h2>New Fermentable</h2>

<form name="fermentableform" action="fermentable_new.php" method="post">
    
<div class="row">
<div class="six_cols">
<div class="float_left">
<fieldset>
    <legend>Fermentable</legend>
    
    <label>Name *:</label>
    <input type="text" name="name" size=15 required oninvalid="this.setCustomValidity('Fermenatable name is required.')" onchange="this.setCustomValidity('')" /> 
    
    <label>Type: </label>
    <select name="type">
        <option></option>
        <option>Grain</option>
        <option>Extract</option>
        <option>Dry Extract</option>
        <option>Sugar</option>
    </select>
    
    <label>Yield (%): </label>
    <input type="number" name="yield" size=6 style="width: 6em" oninvalid="this.setCustomValidity('Yield is not numeric.')" onchange="this.setCustomValidity('')" />
    
    <label>Color (L): </label>
    <input type="number" name="color" size=6 style="width: 6em" oninvalid="this.setCustomValidity('Color is not numeric.')" onchange="this.setCustomValidity('')" />
    
    <p></p>
    
    <label>Add after boil: </label>
    <select name="add_after_boil">
        <option></option>
        <option>True</option>
        <option>False</option>
    </select>
    
    <label>Max in Batch (%): </label>
    <input type="number" name="max_in_batch" size=6 style="width: 6em" oninvalid="this.setCustomValidity('Max in batch is not numeric.')" onchange="this.setCustomValidity('')" />
    
    <label>Recommend Mash: </label>
    <select name="recommend_mash">
        <option></option>
        <option>True</option>
        <option>False</option>
    </select>
    
    <p></p>
    
    <label>Origin: </label>
    <input type="text" name="origin" size=10 />
    
    <label>Supplier: </label>
    <input type="text" name="supplier" size=15 />
    
    <p></p>
    
    <label>Notes: </label>
    <textarea rows=3 cols=130 name="notes"></textarea>
    
</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->
</div><!-- row -->

<div class="row">
<div class="float_left">
<input type="submit" value="Add Fermentable">
</div><!-- float_left -->
</div><!-- row -->

</form>

<?php 
include ('includes/footer.html');
?>
