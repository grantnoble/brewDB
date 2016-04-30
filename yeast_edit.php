<?php

/* 
yeast_edit.php
Edit a yeast in the database
*/

$page_title = 'Edit Yeast';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // retrieve the field values
    $yeast['id'] = mysqli_real_escape_string($connection, test_input($_POST['id']));
    $yeast['name'] = mysqli_real_escape_string($connection, test_input($_POST['name']));
    $yeast['type'] = mysqli_real_escape_string($connection, test_input($_POST['type']));
    $yeast['form'] = mysqli_real_escape_string($connection, test_input($_POST['form']));
    $yeast['laboratory'] = mysqli_real_escape_string($connection, test_input($_POST['laboratory']));
    $yeast['product_id'] = mysqli_real_escape_string($connection, test_input($_POST['product_id']));
    $yeast['min_temperature'] = mysqli_real_escape_string($connection, test_input($_POST['min_temperature']));
    $yeast['max_temperature'] = mysqli_real_escape_string($connection, test_input($_POST['max_temperature']));
    $yeast['flocculation'] = mysqli_real_escape_string($connection, test_input($_POST['flocculation']));
    $yeast['attenuation'] = mysqli_real_escape_string($connection, test_input($_POST['attenuation']));
    $yeast['best_for'] = mysqli_real_escape_string($connection, test_input($_POST['best_for']));
    $yeast['max_reuse'] = mysqli_real_escape_string($connection, test_input($_POST['max_reuse']));
    $yeast['notes'] = mysqli_real_escape_string($connection, test_input($_POST['notes']));
    
    $query = "UPDATE yeasts SET yeast_name='" . $yeast['name'] . "', yeast_type='" . $yeast['type'] . "', yeast_form='" . $yeast['form'] . "', yeast_laboratory='" . $yeast['laboratory'] . "' , yeast_product_id='" . $yeast['product_id'] . "' , yeast_min_temperature='" . $yeast['min_temperature'] . "' , yeast_max_temperature='" . $yeast['max_temperature'] . "' , yeast_flocculation='" . $yeast['flocculation'] . "' , yeast_attenuation='" . $yeast['attenuation'] . "' , yeast_best_for='" . $yeast['best_for'] . "' , yeast_max_reuse='" . $yeast['max_reuse'] . "' , yeast_notes='" . $yeast['notes'] . "' WHERE yeast_id='" . $yeast['id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    
    // After saving to the database, redirect back to the list yeasts page 
    header("Location: yeasts_list.php");
    
}

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
    // get the yeast
    $query = "SELECT * FROM yeasts WHERE yeast_id='" . $_GET['id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection)); 
 
}
// if id isn't set, or isn't valid, redirect back to view page
else
{
    header("Location: yeasts_list.php");
}

while($row = mysqli_fetch_array( $result ))
{
    $id = $row['yeast_id'];
    $name = $row['yeast_name'];
    $type = $row['yeast_type'];
    $form = $row['yeast_form'];
    $product_id = $row['yeast_product_id'];
    $laboratory = $row['yeast_laboratory'];
    $min_temperature = $row['yeast_min_temperature'];
    $max_temperature = $row['yeast_max_temperature'];
    $flocculation = $row['yeast_flocculation'];
    $attenuation = $row['yeast_attenuation'];
    $best_for = $row['yeast_best_for'];
    $max_reuse = $row['yeast_max_reuse'];
    $notes = $row['yeast_notes'];
}

?>

<h2>Edit Yeast</h2>

<form name="yeastform" action="yeast_edit.php" method="post">
    
<div class="row">
<div class="nine_cols">
<div class="float_left">
<fieldset>
    <legend>Yeast</legend>

    <label>Laboratory: </label>
    <input type="text" name="laboratory" size=15 value="<?php if (isset($_POST['laboratory'])) {echo $_POST['laboratory'];} else {echo $laboratory;} ?>" />
    
    <label>Product ID: </label>
    <input type="text" name="product_id" size=15 value="<?php if (isset($_POST['product_id'])) {echo $_POST['product_id'];} else {echo $product_id;} ?>" />
    
    <label>Name *: </label>
    <input type="text" name="name" size=15 required oninvalid="this.setCustomValidity('Yeast name is required.')" onchange="this.setCustomValidity('')" value="<?php if (isset($_POST['name'])) {echo $_POST['name'];} else {echo $name;} ?>" />
    
    <label>Type: </label>
    <input type="text" name="type" size=6 value="<?php if (isset($_POST['type'])) {echo $_POST['type'];} else {echo $type;} ?>" />
    
    <label>Form: </label>
    <input type="text" name="form" size=10 value="<?php if (isset($_POST['form'])) {echo $_POST['form'];} else {echo $form;} ?>" />
    
    <p></p>
    
    <label>Min Temp (&deg;C): </label>
    <input type="number" name="min_temperature" size=6 style="width: 6em" oninvalid="this.setCustomValidity('Temperature is not numeric.')" onchange="this.setCustomValidity('')" value="<?php if (isset($_POST['min_temperature'])) {echo $_POST['min_temperature'];} else {echo $min_temperature;} ?>" />
    
    <label>Max Temp (&deg;C): </label>
    <input type="number" name="max_temperature" size=6 style="width: 6em" oninvalid="this.setCustomValidity('Temperature is not numeric.')" onchange="this.setCustomValidity('')" value="<?php if (isset($_POST['max_temperature'])) {echo $_POST['max_temperature'];} else {echo $max_temperature;} ?>" />
    
    <label>Flocculation: </label>
    <input type="text" name="flocculation" size=15 value="<?php if (isset($_POST['flocculation'])) {echo $_POST['flocculation'];} else {echo $flocculation;} ?>" />
    
    <label>Attenuation (%): </label>
    <input type="number" name="attenuation" size=6 style="width: 6em" oninvalid="this.setCustomValidity('Attenuation is not numeric.')" onchange="this.setCustomValidity('')" value="<?php if (isset($_POST['attenuation'])) {echo $_POST['attenuation'];} else {echo $attenuation;} ?>" />
    
    <p></p>
    
    <label>Best For: </label>
    <input type="text" name="best_for" size=30 value="<?php if (isset($_POST['best_for'])) {echo $_POST['best_for'];} else {echo $best_for;} ?>" />
    
    <label>Max Reuse: </label>
    <input type="number" name="max_reuse" size=6 style="width: 6em" oninvalid="this.setCustomValidity('Max reuse is not numeric.')" onchange="this.setCustomValidity('')" value="<?php if (isset($_POST['max_reuse'])) {echo $_POST['max_reuse'];} else {echo $max_reuse;} ?>" />
    
    <p></p>
    
    <label>Notes: </label>
    <textarea rows=3 cols=130 name="notes" ><?php if (isset($_POST['notes'])) {echo $_POST['notes'];} else {echo $notes;} ?></textarea>
</fieldset>
</div><!-- float_left -->
</div><!-- nine_cols -->
</div><!-- row -->

<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<div class="row">
<div class="float_left">
<input type="submit" value="Update Yeast" />
</div><!-- float_left -->
</div><!-- row -->

</form>

<?php 
include ('includes/footer.html');
?>
