<?php
/*
fermentable_new.php
Add a fermentable to the database
*/

$page_title = 'New Fermentable';
include '../includes/header.html';
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
	echo '<script type="text/javascript">
	window.location = "fermentables_list.php"
	</script>';
}
?>

<div class="container">

	<h2>New Fermentable</h2>

	<form role="form" name="fermentableform" data-toggle="validator" action="fermentable_new.php" method="post">

		<div class="well">

			<div class="row">

				<div class="form-group col-xs-3 col-md-3">
					<label for="name" class="label-sm">Name</label>
					<input type="text" class="form-control input-sm" name="name" id="name" required data-error="Fermentable name required" />
					<div class="help-block with-errors"></div>
				</div>

				<div class="form-group col-xs-3 col-md-2">
					<label for="type" class="label-sm">Type</label>
					<select name="type" id="type" class="form-control input-sm">
						<option value selected disabled></option>
						<option>Grain</option>
						<option>Extract</option>
						<option>Dry Extract</option>
						<option>Sugar</option>
					</select>
				</div>

				<div class="form-group col-xs-2 col-md-2">
					<label for="yield" class="label-sm">Yield (%)</label>
					<input type="number" class="form-control input-sm" name="yield" id="yield" />
				</div>

				<div class="form-group col-xs-2 col-md-2">
					<label for="color" class="label-sm">Color (L)</label>
					<input type="number" class="form-control input-sm" name="color" id="color" />
				</div>

			</div>

			<div class="row">

				<div class="form-group hidden-xs col-md-2">
					<label for="add_after_boil" class="label-sm">Add after boil?</label>
					<select name="add_after_boil" id="add_after_boil" class="form-control input-sm">
						<option value selected disabled></option>
						<option>True</option>
						<option>False</option>
					</select>
				</div>

				<div class="form-group col-xs-3 col-md-2">
					<label for="max_in_batch" class="label-sm">Max in Batch (%)</label>
					<input type="max_in_batch" class="form-control input-sm" name="max_in_batch" id="max_in_batch" />
				</div>

				<div class="form-group col-xs-3 col-md-2">
					<label for="recommend_mash" class="label-sm">Mash?</label>
					<select name="recommend_mash" id="recommend_mash" class="form-control input-sm">
						<option value selected disabled></option>
						<option>True</option>
						<option>False</option>
					</select>
				</div>

				<div class="form-group col-xs-3 col-md-3">
					<label for="origin" class="label-sm">Origin</label>
					<input type="text" class="form-control input-sm" name="origin" id="origin" />
				</div>

				<div class="form-group col-xs-3 col-md-3">
					<label for="supplier" class="label-sm">Supplier</label>
					<input type="text" class="form-control input-sm" name="supplier" id="supplier" />
				</div>

			</div>

			<div class="row">

				<div class="form-group col-xs-12 col-md-12">
					<label for="notes" class="label-sm">Notes</label>
					<textarea class="form-control input-sm" rows=3 cols=100 name="notes" id="notes"></textarea>
				</div>

			</div>

		</div><!-- well -->

	<button type="submit" class="btn btn-default">Save</button>

	</form>

</div><!-- container -->

<?php
include '../includes/footer.html';
?>
