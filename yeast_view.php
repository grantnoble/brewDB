<?php

/* 
yeast_view.php
View a yeast in the database
*/

$page_title = 'View Yeasts';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

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
    $laboratory = $row['yeast_laboratory'];
    $product_id = $row['yeast_product_id'];
    $min_temperature = $row['yeast_min_temperature'];
    $max_temperature = $row['yeast_max_temperature'];
    $flocculation = $row['yeast_flocculation'];
    $attenuation = $row['yeast_attenuation'];
    $best_for = $row['yeast_best_for'];
    $max_reuse = $row['yeast_max_reuse'];
    $notes = $row['yeast_notes'];
}


?>

<h2>View Yeast</h2>

<form name="yeastform" action="yeast_view.php" method="post">
    
<div class="row">
<div class="nine_cols">
<div class="float_left">
<fieldset>
    <legend>Yeast</legend>

    <label>Laboratory: </label>
    <input type="text" name="laboratory" size=15 readonly="yes" value="<?php echo $laboratory; ?>" />
    
    <label>Product ID: </label>
    <input type="text" name="product_id" size=15 readonly="yes" value="<?php echo $product_id; ?>" />
    
    <label>Name: </label>
    <input type="text" name="name" size=15 readonly="yes" value="<?php echo $name; ?>" />
    
    <label>Type: </label>
    <input type="text" name="type" size=15 readonly="yes" value="<?php echo $type; ?>" />
    
    <label>Form: </label>
    <input type="text" name="form" size=15 readonly="yes" value="<?php echo $form; ?>" />
    
    <p></p>
    
    <label>Min Temp (&deg;C): </label>
    <input type="text" name="min_temperature" size=6 readonly="yes" value="<?php echo $min_temperature; ?>" />
    
    <label>Max Temp (&deg;C): </label>
    <input type="text" name="max_temperature" size=6 readonly="yes" value="<?php echo $max_temperature; ?>" />
    
    <label>Flocculation: </label>
    <input type="text" name="flocculation" size=15 readonly="yes" value="<?php echo $flocculation; ?>" />
    
    <label>Attenuation (%): </label>
    <input type="text" name="attenuation" size=6 readonly="yes" value="<?php echo $attenuation; ?>" />
    
    <p></p>
    
    <label>Best For: </label>
    <input type="text" name="best_for" size=30 readonly="yes" value="<?php echo $best_for; ?>" />
    
    <label>Max Reuse: </label>
    <input type="text" name="max_reuse" size=6 readonly="yes" value="<?php echo $max_reuse; ?>" />
    
    <p></p>
    
    <label>Notes: </label>
    <textarea rows=3 cols=130 name="notes" readonly="yes"><?php echo $notes; ?></textarea>
</fieldset>
</div><!-- float_left -->
</div><!-- nine_cols -->
</div><!-- row -->

</form>

<!-- new form to submit only the yeast id using get not post-->
<form name="yeastformedit" action="yeast_edit.php" method="get">
<div class="row">
<div class="float_left">
	<input type="hidden" name="id" value="<?php echo $id; ?>" />
	<input type="submit" value="Edit Yeast" />
</div><!-- float_left -->
</div><!-- row -->
</form>

<?php 
include ('includes/footer.html');
?>
