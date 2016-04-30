<?php

/* 
fermentable_view.php
View a fermentable in the database
*/

$page_title = 'View Fermentable';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// connect to the database
include('includes/database_connect.php');

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

<h2>View Fermentable</h2>

<form role="form" name="fermentableform" >

<div class="row">
<div class="six_cols">
<div class="float_left">
<fieldset>
    <legend>Fermentable</legend>
    
    <label>Name: </label>
    <input type="text" name="name" size=15 readonly="yes" value="<?php echo $name; ?>" />
    
    <label>Type: </label>
    <input type="text" name="type" size=15 readonly="yes" value="<?php echo $type; ?>" />
    
    <label>Yield (%): </label>
    <input type="text" name="yield" size=6 readonly="yes" value="<?php echo $yield; ?>" />
    
    <label>Color (L): </label>
    <input type="text" name="color" size=6 readonly="yes" value="<?php echo $color; ?>" />
    
    <p></p>
    
    <label>Add after Boil: </label>
    <input type="text" name="add_after_boil" size=6 readonly="yes" value="<?php echo $add_after_boil; ?>" />
    
    <label>Max in Batch (%): </label>
    <input type="text" name="max_in_batch" size=6 readonly="yes" value="<?php echo $max_in_batch; ?>" />
    
    <label>Recommend Mash: </label>
    <input type="text" name="recommend_mash" size=6 readonly="yes" value="<?php echo $recommend_mash; ?>" />
    
    <p></p>
    
    <label>Origin: </label>
    <input type="text" name="origin" size=10 readonly="yes" value="<?php echo $origin; ?>" />
    
    <label>Supplier: </label>
    <input type="text" name="supplier" size=15 readonly="yes" value="<?php echo $supplier; ?>" />
    
    <p></p>
    
    <label>Notes: <br></label>
    <textarea rows=3 cols=130 name="notes" readonly="yes"><?php echo $notes; ?></textarea>
    
</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->
</div><!-- row -->

</form>

<!-- new form to submit only the fermentable id using get not post-->
<form name="fermentableformedit" action="fermentable_edit.php" method="get">
<div class="row">
<div class="float_left">
	<input type="hidden" name="id" value="<?php echo $id; ?>" />
	<input type="submit" value="Edit Fermentable" />
</div><!-- float_left -->
</div><!-- row -->
</form>

<?php 
include ('includes/footer.html');
?>
