<?php
/*
yeast_new.php
Add a yeast to the database
*/

$page_title = 'New Yeast';
include '../includes/header.html';
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
	echo '<script type="text/javascript">
	window.location = "yeasts_list.php"
	</script>';
}
?>

<div class="container">

	<h2>New Yeast</h2>

	<form role="form" name="yeastform" data-toggle="validator" action="yeast_new.php" method="post">

		<div class="well">

			<div class="row">

				<div class="fcol-xs-3 col-md-2">
					<label for="laboratory" class="label-sm">Laboratory</label>
					<input type="text" class="form-control input-sm" name="laboratory" id="laboratory" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="product_id" class="label-sm">Product ID</label>
					<input type="text" class="form-control input-sm" name="product_id" id="product_id" />
				</div>

				<div class="form-group col-xs-3 col-md-3">
					<label for="name" class="label-sm">Name</label>
					<input type="text" class="form-control input-sm" name="name" id="name" required data-error="Yeast name required" />
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="type" class="label-sm">Type</label>
					<select name="type" id="type" class="form-control input-sm">
						<option value selected disabled></option>
						<option>Ale</option>
						<option>Lager</option>
						<option>Wheat</option>
						<option>Wine</option>
						<option>Champagne</option>
					</select>
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="form" class="label-sm">Form</label>
					<select name="form" id="form" class="form-control input-sm">
						<option value selected disabled></option>
						<option>Liquid</option>
						<option>Dry</option>
						<option>Slant</option>
						<option>Culture</option>
					</select>
				</div>

			</div>

			<div class="row margin-bottom-1em">

				<div class="col-xs-3 col-md-2">
					<label for="min_temperature" class="label-sm">Min&nbsp;Temp&nbsp;(&deg;C)</label>
					<input type="number" class="form-control input-sm" name="min_temperature" id="min_temperature" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="max_temperature" class="label-sm">Max&nbsp;Temp&nbsp;(&deg;C)</label>
					<input type="number" class="form-control input-sm" name="max_temperature" id="max_temperature" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="attenuation" class="label-sm">Attenuation&nbsp;(%)</label>
					<input type="number" class="form-control input-sm" name="attenuation" id="attenuation" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="flocculation" class="label-sm">Flocculation</label>
					<select name="flocculation" id="flocculation" class="form-control input-sm">
						<option value selected disabled></option>
						<option>Low</option>
						<option>Medium</option>
						<option>High</option>
						<option>Very High</option>
					</select>
				</div>

				<div class="col-xs-3 col-md-3">
					<label for="best_for" class="label-sm">Best For</label>
					<input type="text" class="form-control input-sm" name="best_for" id="best_for" />
				</div>

				<div class="col-xs-3 col-md-1">
					<label for="max_reuse" class="label-sm">Max&nbsp;Reuse</label>
					<input type="number" class="form-control input-sm" name="max_reuse" id="max_reuse" />
				</div>

			</div>

			<div class="row">

				<div class="col-xs-12 col-md-12">
					<label for="notes" class="label-sm">Notes</label>
					<textarea rows=3 cols=130 class="form-control input-sm" name="notes" id="notes"></textarea>
				</div>

			</div>

		</div>

	<button type="submit" class="btn btn-default">Save</button>

	</form>

</div>

<?php
include '../includes/footer.html';
?>
