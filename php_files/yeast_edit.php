<?php
/*
yeast_edit.php
Edit a yeast in the database
*/

$page_title = 'Edit Yeast';
$error = "";
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // form validation OK, so retrieve the field values
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
	echo '<script type="text/javascript">
	window.location = "yeasts_list.php"
	</script>';
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
	echo '<script type="text/javascript">
	window.location = "yeasts_list.php"
	</script>';
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

<div class="container">

	<h2>Edit Yeast</h2>

	<form role="form" name="yeastform" data-toggle="validator" action="yeast_edit.php" method="post">

	<input type="hidden" name="id" value="<?php echo $id; ?>" />

	<div class="row">

		<fieldset class="col-xs-12 col-md-12">

		<div class="well">

			<div class="row margin-bottom-1em">

				<div class="col-xs-3 col-md-2">
					<label for="laboratory" class="label-sm">Laboratory</label>
					<input type="text" class="form-control input-sm" name="laboratory" id="laboratory" value="<?php if (isset($_POST['laboratory'])) {echo $_POST['laboratory'];} else {echo $laboratory;} ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="product_id" class="label-sm">Product ID</label>
					<input type="text" class="form-control input-sm" name="product_id" id="product_id" value="<?php if (isset($_POST['product_id'])) {echo $_POST['product_id'];} else {echo $product_id;} ?>" />
				</div>

				<div class="col-xs-3 col-md-3">
					<label for="name" class="label-sm">Name</label>
					<input type="text" class="form-control input-sm" name="name" id="name" required data-error="Yeast name required" value="<?php if (isset($_POST['name'])) {echo $_POST['name'];} else {echo $name;} ?>" />
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="type" class="label-sm">Type</label>
					<select name="type" id="type" class="form-control input-sm">
						<option><?php if (isset($_POST['type'])) {echo $_POST['type'];} else {echo $type;} ?></option>
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
						<option><?php if (isset($_POST['form'])) {echo $_POST['form'];} else {echo $form;} ?></option>
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
					<input type="number" class="form-control input-sm" name="min_temperature" id="min_temperature" value="<?php if (isset($_POST['min_temperature'])) {echo $_POST['min_temperature'];} else {echo $min_temperature;} ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="max_temperature" class="label-sm">Max&nbsp;Temp&nbsp;(&deg;C)</label>
					<input type="number" class="form-control input-sm" name="max_temperature" id="max_temperature" value="<?php if (isset($_POST['max_temperature'])) {echo $_POST['max_temperature'];} else {echo $max_temperature;} ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="attenuation" class="label-sm">Attenuation&nbsp;(%)</label>
					<input type="number" class="form-control input-sm" name="attenuation" id="attenuation" value="<?php if (isset($_POST['attenuation'])) {echo $_POST['attenuation'];} else {echo $attenuation;} ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="flocculation" class="label-sm">Flocculation</label>
					<select name="flocculation" id="flocculation" class="form-control input-sm">
						<option><?php if (isset($_POST['flocculation'])) {echo $_POST['flocculation'];} else {echo $flocculation;} ?></option>
						<option>Low</option>
						<option>Medium</option>
						<option>High</option>
						<option>Very High</option>
					</select>
				</div>

				<div class="col-xs-3 col-md-3">
					<label for="best_for" class="label-sm">Best For</label>
					<input type="text" class="form-control input-sm" name="best_for" id="best_for" value="<?php if (isset($_POST['best_for'])) {echo $_POST['best_for'];} else {echo $best_for;} ?>" />
				</div>

				<div class="col-xs-3 col-md-1">
					<label for="max_reuse" class="label-sm">Max&nbsp;Reuse</label>
					<input type="number" class="form-control input-sm" name="max_reuse" id="max_reuse" value="<?php if (isset($_POST['max_reuse'])) {echo $_POST['max_reuse'];} else {echo $max_reuse;} ?>" />
				</div>

			</div>

			<div class="row">

				<div class="col-xs-12 col-md-12">
					<label for="notes" class="label-sm">Notes</label>
					<textarea rows=3 cols=130 class="form-control input-sm" name="notes" id="notes"><?php if (isset($_POST['notes'])) {echo $_POST['notes'];} else {echo $notes;} ?></textarea>
				</div>

			</div>

		</div>

		</fieldset>

	</div>

	<button type="submit" class="btn btn-default">Save</button>

	</form>

</div>

<?php
include '../includes/footer.html';
?>
