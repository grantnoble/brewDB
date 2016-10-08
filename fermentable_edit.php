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

// end of PHP section, now create the HTML form
?>

<div class="container">

	<h2>Edit Fermentable</h2>

	<form role="form" class="form-horizontal" name="fermentableform" action="fermentable_edit.php" method="post">
    
	<input type="hidden" name="id" value="<?php echo $id; ?>" />

	<div class="row">

		<fieldset class="col-xs-12 col-md-12">

		<div class="well">

			<div class="row margin-bottom-1em">

				<div class="col-xs-3 col-md-3">
					<label for="name" class="label-sm">Name</label>
					<input type="text" class="form-control input-sm" name="name" id="name" required value="<?php if (isset($_POST['name'])) {echo $_POST['name'];} else {echo $name;} ?>" />
				</div>
		
				<div class="col-xs-3 col-md-2">
					<label for="type" class="label-sm">Type</label>
					<select name="type" id="type" class="form-control input-sm">
						<option><?php if (isset($_POST['type'])) {echo $_POST['type'];} else {echo $type;} ?></option>
						<option>Grain</option>
						<option>Extract</option>
						<option>Dry Extract</option>
						<option>Sugar</option>
					</select>
				</div>
		
				<div class="col-xs-2 col-md-2">
					<label for="yield" class="label-sm">Yield (%)</label>
					<input type="number" class="form-control input-sm" name="yield" id="yield" value="<?php if (isset($_POST['yield'])) {echo $_POST['yield'];} else {echo $yield;} ?>" />
				</div>
		
				<div class="col-xs-2 col-md-2">
					<label for="color" class="label-sm">Color (L)</label>
					<input type="number" class="form-control input-sm" name="color" id="color" value="<?php if (isset($_POST['color'])) {echo $_POST['color'];} else {echo $color;} ?>" />
				</div>
		
			</div>
			
			<div class="row margin-bottom-1em">
			
				<div class="hidden-xs col-md-2">
					<label for="add_after_boil" class="label-sm">Add after boil?</label>
					<select name="add_after_boil" id="add_after_boil" class="form-control input-sm">
						<option><?php if (isset($_POST['add_after_boil'])) {echo $_POST['add_after_boil'];} else {echo $add_after_boil;} ?></option>
						<option>True</option>
						<option>False</option>
					</select>
				</div>
		
				<div class="col-xs-3 col-md-2">
					<label for="max_in_batch" class="label-sm">Max in Batch (%)</label>
					<input type="max_in_batch" class="form-control input-sm" name="max_in_batch" id="max_in_batch" value="<?php if (isset($_POST['max_in_batch'])) {echo $_POST['max_in_batch'];} else {echo $max_in_batch;} ?>" />
				</div>
		
				<div class="col-xs-3 col-md-2">
					<label for="recommend_mash" class="label-sm">Mash?</label>
					<select name="recommend_mash" id="recommend_mash" class="form-control input-sm">
						<option><?php if (isset($_POST['recommend_mash'])) {echo $_POST['recommend_mash'];} else {echo $recommend_mash;} ?></option>
						<option>True</option>
						<option>False</option>
					</select>
				</div>
				
				<div class="col-xs-3 col-md-3">
					<label for="origin" class="label-sm">Origin</label>
					<input type="text" class="form-control input-sm" name="origin" id="origin" value="<?php if (isset($_POST['origin'])) {echo $_POST['origin'];} else {echo $origin;} ?>" />
				</div>
		
				<div class="col-xs-3 col-md-3">
					<label for="supplier" class="label-sm">Supplier</label>
					<input type="text" class="form-control input-sm" name="supplier" id="supplier" value="<?php if (isset($_POST['supplier'])) {echo $_POST['supplier'];} else {echo $supplier;} ?>" />
				</div>
		
			</div>
			
			<div class="row">
		
				<div class="col-xs-12 col-md-12">
					<label for="notes" class="label-sm">Notes</label>
					<textarea class="form-control input-sm" rows=3 cols=100 name="notes" id="notes"><?php if (isset($_POST['notes'])) {echo $_POST['notes'];} else {echo $notes;} ?></textarea>
				</div>
		
			</div>

		</div>
    
		</fieldset>
		
	</div>

	<button type="submit" class="btn btn-default">Save</button>

	</form>

</div>

<?php 
include ('includes/footer.html');
?>
