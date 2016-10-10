<?php

/* 
fermentable_delete.php
Delete a fermentable in the database
*/

$page_title = 'Delete Fermentable';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if ($_POST['sure'] == 'Yes')
    {
        $fermentable_id = mysqli_real_escape_string($connection, htmlspecialchars($_POST['id']));
        $query = "DELETE from fermentables WHERE fermentable_id='" . $fermentable_id . "'";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    // After deleting or not, redirect back to the fermentables_list page 
	echo '<script type="text/javascript">
	window.location = "fermentables_list.php"
	</script>';
    
}

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
    // get the fermentable
    $query = "SELECT * FROM fermentables WHERE fermentable_id='" . $_GET['id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection)); 
 
}
// if id isn't set, or isn't valid, redirect back to list page
else
{
	echo '<script type="text/javascript">
	window.location = "fermentables_list.php"
	</script>';
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

<div class="container">

	<h2>Delete Fermentable</h2>

	<form role="form" class="form-horizontal" name="fermentableform" action="fermentable_delete.php" method="post">
    
	<div class="row">

		<fieldset class="col-xs-12 col-md-12">

		<div class="well">

			<div class="row margin-bottom-1em">

				<div class="col-xs-3 col-md-3">
					<label for="name" class="label-sm">Name</label>
					<input type="text" class="form-control input-sm" name="name" id="name" readonly="yes" value="<?php echo $name; ?>" />
				</div>
		
				<div class="col-xs-3 col-md-2">
					<label for="type" class="label-sm">Type</label>
					<input type="text" class="form-control input-sm" name="type" id="type" readonly="yes" value="<?php echo $type; ?>" />
				</div>
		
				<div class="col-xs-2 col-md-2">
					<label for="yield" class="label-sm">Yield (%)</label>
					<input type="number" class="form-control input-sm" name="yield" id="yield" readonly="yes" value="<?php echo $yield; ?>" />
				</div>
		
				<div class="col-xs-2 col-md-2">
					<label for="color" class="label-sm">Color (L)</label>
					<input type="number" class="form-control input-sm" name="color" id="color" readonly="yes" value="<?php echo $color; ?>" />
				</div>
		
			</div>
			
			<div class="row margin-bottom-1em">
			
				<div class="hidden-xs col-md-2">
					<label for="add_after_boil" class="label-sm">Add after boil?</label>
					<input type="text" class="form-control input-sm" name="add_after_boil" id="add_after_boil" readonly="yes" value="<?php echo $add_after_boil; ?>" />
				</div>
		
				<div class="col-xs-3 col-md-2">
					<label for="max_in_batch" class="label-sm">Max in Batch (%)</label>
					<input type="max_in_batch" class="form-control input-sm" name="max_in_batch" id="max_in_batch" readonly="yes" value="<?php echo $max_in_batch; ?>" />
				</div>
		
				<div class="col-xs-3 col-md-2">
					<label for="recommend_mash" class="label-sm">Mash?</label>
					<input type="text" class="form-control input-sm" name="recommend_mash" id="recommend_mash" readonly="yes" value="<?php echo $recommend_mash; ?>" />
				</div>
				
				<div class="col-xs-3 col-md-3">
					<label for="origin" class="label-sm">Origin</label>
					<input type="text" class="form-control input-sm" name="origin" id="origin" readonly="yes" value="<?php echo $origin; ?>" />
				</div>
		
				<div class="col-xs-3 col-md-3">
					<label for="supplier" class="label-sm">Supplier</label>
					<input type="text" class="form-control input-sm" name="supplier" id="supplier" readonly="yes" value="<?php echo $supplier; ?>" />
				</div>
		
			</div>
			
			<div class="row">
		
				<div class="col-xs-12 col-md-12">
					<label for="notes" class="label-sm">Notes</label>
					<textarea class="form-control input-sm" rows=3 cols=100 name="notes" id="notes" readonly="yes"><?php echo $notes; ?></textarea>
				</div>
		
			</div>

		</div>
    
		</fieldset>
		
	</div>

	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	<p>Are you sure you want to delete this record?</p>
	<label class="checkbox-inline">
		<input type="checkbox" name="sure" id="sure" value="Yes">Yes
	</label>
	<label class="checkbox-inline">
		<input class="btn btn-default" type="submit" value="Delete">
	</label>

	</form>

</div>

<?php 
include ('includes/footer.html');
?>
