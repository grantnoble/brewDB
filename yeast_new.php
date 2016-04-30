<?php

/* 
yeast_new.php
Add a yeast to the database
*/

$page_title = 'New Yeast';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // retrieve the field values
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
    
    // set up the SQL INSERT
    $columns = "INSERT into yeasts (yeast_name, yeast_type, yeast_form, yeast_laboratory, yeast_product_id, yeast_min_temperature, yeast_max_temperature, yeast_flocculation, yeast_attenuation, yeast_best_for, yeast_max_reuse, yeast_notes) ";
    $values = "VALUES ('" . $yeast['name'] . "', '" . $yeast['type'] . "', '" . $yeast['form'] . "', '" . $yeast['laboratory'] . "', '" . $yeast['product_id'] . "', '" . $yeast['min_temperature'] . "', '" . $yeast['max_temperature'] . "', '" . $yeast['flocculation'] . "', '" . $yeast['attenuation'] . "', '" . $yeast['best_for'] . "', '" . $yeast['max_reuse'] . "', '" . $yeast['notes'] . "')";
    $query = $columns . $values;
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    
    // After saving to the database, redirect back to the list hops page 
    header("Location: yeasts_list.php");
    
}

?>

<h2>Edit Yeast</h2>

<form name="yeastform" action="yeast_new.php" method="post">
    
<div class="row">
<div class="nine_cols">
<div class="float_left">
<fieldset>
    <legend>Yeast</legend>

    <label>Laboratory: </label>
    <input type="text" name="laboratory" size=15 />
    
    <label>Product ID: </label>
    <input type="text" name="product_id" size=15 />
    
    <label>Name *: </label>
    <input type="text" name="name" size=15 required oninvalid="this.setCustomValidity('Yeast name is required.')" onchange="this.setCustomValidity('')" />
    
    <label>Type: </label>
    <input type="text" name="type" size=6 />
    
    <label>Form: </label>
    <input type="text" name="form" size=10 />
    
    <p></p>
    
    <label>Min Temp (&deg;C): </label>
    <input type="number" name="min_temperature" size=6 style="width: 6em" oninvalid="this.setCustomValidity('Temperature is not numeric.')" onchange="this.setCustomValidity('')" />
    
    <label>Max Temp (&deg;C): </label>
    <input type="number" name="max_temperature" size=6 style="width: 6em" oninvalid="this.setCustomValidity('Temperature is not numeric.')" onchange="this.setCustomValidity('')" />
    
    <label>Flocculation: </label>
    <input type="text" name="flocculation" size=15 value="<?php if (isset($_POST['flocculation'])) {echo $_POST['flocculation'];} else {echo $flocculation;} ?>" />
    
    <label>Attenuation (%): </label>
    <input type="number" name="attenuation" size=6 style="width: 6em" oninvalid="this.setCustomValidity('Attenuation is not numeric.')" onchange="this.setCustomValidity('')" />
    
    <p></p>
    
    <label>Best For: </label>
    <input type="text" name="best_for" size=30 />
    
    <label>Max Reuse: </label>
    <input type="number" name="max_reuse" size=6 style="width: 6em" oninvalid="this.setCustomValidity('Max reuse is not numeric.')" onchange="this.setCustomValidity('')" />
    
    <p></p>
    
    <label>Notes: </label>
    <textarea rows=3 cols=130 name="notes" ></textarea>
</fieldset>
</div><!-- float_left -->
</div><!-- nine_cols -->
</div><!-- row -->

<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<div class="row">
<div class="float_left">
<input type="submit" value="Add Yeast" />
</div><!-- float_left -->
</div><!-- row -->

</form>

<?php 
include ('includes/footer.html');
?>
