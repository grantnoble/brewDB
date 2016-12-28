<?php

/*
preferences_edit.php
Edit brewdb preferences
*/

$page_title = 'Edit Preferences';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // retrieve the field values
    $details['preference_id'] = mysqli_real_escape_string($connection, test_input($_POST['preference_id']));
    $details['page_title'] = mysqli_real_escape_string($connection, test_input($_POST['page_title']));
    $details['title'] = mysqli_real_escape_string($connection, test_input($_POST['title']));
    $details['sub_title'] = mysqli_real_escape_string($connection, test_input($_POST['sub_title']));
    $details['brew_type'] = mysqli_real_escape_string($connection, test_input($_POST['brew_type']));
    $details['mash_type'] = mysqli_real_escape_string($connection, test_input($_POST['mash_type']));
    $details['mash_volume'] = mysqli_real_escape_string($connection, test_input($_POST['mash_volume']));
    $details['sparge_volume'] = mysqli_real_escape_string($connection, test_input($_POST['sparge_volume']));
    $details['no_chill'] = mysqli_real_escape_string($connection, test_input($_POST['no_chill']));
    $details['boil_size'] = mysqli_real_escape_string($connection, test_input($_POST['boil_size']));
    $details['boil_time'] = mysqli_real_escape_string($connection, test_input($_POST['boil_time']));
    $details['evaporation_rate'] = mysqli_real_escape_string($connection, test_input($_POST['evaporation_rate']));
    $details['batch_size'] = mysqli_real_escape_string($connection, test_input($_POST['batch_size']));
    $details['mash_efficiency'] = mysqli_real_escape_string($connection, test_input($_POST['mash_efficiency']));
    $details['loss'] = mysqli_real_escape_string($connection, test_input($_POST['loss']));
    $details['packaging'] = mysqli_real_escape_string($connection, test_input($_POST['packaging']));

    $query = "UPDATE preferences SET preference_page_title='" . $details['page_title'] . "', preference_title='" . $details['title'] . "', preference_sub_title='" . $details['sub_title'] . "', preference_brew_type='" . $details['brew_type'] . "', preference_mash_type='" . $details['mash_type'] . "', preference_mash_volume=" . $details['mash_volume'] . ", preference_sparge_volume=" . $details['sparge_volume'] . ", preference_no_chill='" . $details['no_chill'] . "', preference_boil_size=" . $details['boil_size'] . ", preference_boil_time=" . $details['boil_time'] . ", preference_evaporation_rate=" . $details['evaporation_rate'] . ", preference_batch_size=" . $details['batch_size'] . ", preference_mash_efficiency=" . $details['mash_efficiency'] . ", preference_loss=" . $details['loss'] . ", preference_packaging='" . $details['packaging'] . "' WHERE preference_id=" . $details['preference_id'] ;
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

    // After saving to the database, redirect back to the home page
	echo '<script type="text/javascript">
	window.location = "index.php"
	</script>';

}

// if not form submission, retrieve preference details
$query = "SELECT * FROM preferences ORDER BY preference_id DESC LIMIT 1";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
while ($row = mysqli_fetch_array ( $result ))
{
	$id = $row['preference_id'];
	$page_title = $row['preference_page_title'];
	$title = $row['preference_title'];
	$sub_title = $row['preference_sub_title'];
	$brew_type = $row['preference_brew_type'];
	$mash_type = $row['preference_mash_type'];
	$mash_volume = $row['preference_mash_volume'];
	$sparge_volume = $row['preference_sparge_volume'];
	$no_chill = $row['preference_no_chill'];
	$boil_size = $row['preference_boil_size'];
	$boil_time = $row['preference_boil_time'];
	$evaporation_rate = $row['preference_evaporation_rate'];
	$batch_size = $row['preference_batch_size'];
	$mash_efficiency = $row['preference_mash_efficiency'];
	$loss = $row['preference_loss'];
	$packaging = $row['preference_packaging'];
}

//end of PHP section, now create the HTML form
?>

<div class="container">

	<h2>Edit Preferences</h2>

	<form role="form" class="form-horizontal" name="preferencesform" action="preferences_edit.php" method="post">

	<input type="hidden" name="preference_id" value="<?php echo $id; ?>" />

	<div class="row">

		<fieldset class="col-xs-12 col-md-12">

		<div class="well">

			<div class="row margin-bottom-1em">

				<div class="col-xs-3 col-md-4">
					<label for="page_title" class="label-sm">Page Title</label>
					<input type="text" class="form-control input-sm" name="page_title" id="page_title" value="<?php if (isset($_POST['page_title'])) {echo $_POST['page_title'];} else {echo $page_title;} ?>" />
				</div>

				<div class="col-xs-3 col-md-4">
					<label for="title" class="label-sm">Title</label>
					<input type="text" class="form-control input-sm" name="title" id="title" value="<?php if (isset($_POST['title'])) {echo $_POST['title'];} else {echo $title;} ?>" />
				</div>

				<div class="col-xs-3 col-md-4">
					<label for="sub_title" class="label-sm">Sub Title</label>
					<input type="text" class="form-control input-sm" name="sub_title" id="sub_title" value="<?php if (isset($_POST['sub_title'])) {echo $_POST['sub_title'];} else {echo $sub_title;} ?>" />
				</div>

			</div>

			<div class="row margin-bottom-1em">

				<div class="col-xs-2 col-md-2">
					<label for="brew_type" class="label-sm">Brew Type</label>
					<select name="brew_type" id="brew_type" class="form-control input-sm">
						<option><?php if (isset($_POST['brew_type'])) {echo $_POST['brew_type'];} else {echo $brew_type;} ?></option>
						<option>All Grain</option>
						<option>Extract</option>
						<option>Partial Mash</option>
					</select>
				</div>

				<div class="col-xs-2 col-md-2">
					<label for="mash_type" class="label-sm">Mash Type</label>
					<select name="mash_type" id="mash_type" class="form-control input-sm">
						<option><?php if (isset($_POST['mash_type'])) {echo $_POST['mash_type'];} else {echo $mash_type;} ?></option>
						<option>BIAB</option>
						<option>Batch Sparge</option>
						<option>Fly Sparge</option>
						<option>No Sparge</option>
					</select>
				</div>

				<div class="col-xs-2 col-md-2">
					<label for="mash_volume" class="label-sm">Mash Volume (L)</label>
					<input type="number" class="form-control input-sm" name="mash_volume" id="mash_volume" required value="<?php if (isset($_POST['mash_volume'])) {echo $_POST['mash_volume'];} else {echo $mash_volume;} ?>" />
				</div>

				<div class="col-xs-2 col-md-2">
					<label for="sparge_volume" class="label-sm">Sparge Volume (L)</label>
					<input type="number" class="form-control input-sm" name="sparge_volume" id="sparge_volume" required value="<?php if (isset($_POST['sparge_volume'])) {echo $_POST['sparge_volume'];} else {echo $sparge_volume;} ?>" />
				</div>

				<div class="col-xs-2 col-md-2">
					<label for="no_chill" class="label-sm">No Chill?</label>
					<select name="no_chill" id="no_chill" class="form-control input-sm">
						<option><?php if (isset($_POST['no_chill'])) {echo $_POST['no_chill'];} else {echo $no_chill;} ?></option>
						<option>True</option>
						<option>False</option>
					</select>
				</div>

				<div class="col-xs-2 col-md-2">
					<label for="packaging" class="label-sm">Packaging</label>
					<select name="packaging" id="packaging" class="form-control input-sm">
						<option><?php if (isset($_POST['packaging'])) {echo $_POST['packaging'];} else {echo $packaging;} ?></option>
						<option>Bottle</option>
						<option>Keg</option>
					</select>
				</div>

			</div>

			<div class="row">

				<div class="col-xs-3 col-md-2">
					<label for="boil_size" class="label-sm">Boil Size (L)</label>
					<input type="number" class="form-control input-sm" name="boil_size" id="boil_size" required value="<?php if (isset($_POST['boil_size'])) {echo $_POST['boil_size'];} else {echo $boil_size;} ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="boil_time" class="label-sm">Boil Time (mins)</label>
					<input type="number" class="form-control input-sm" name="boil_time" id="boil_time" required value="<?php if (isset($_POST['boil_time'])) {echo $_POST['boil_time'];} else {echo $boil_time;} ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="evaporation_rate" class="label-sm">Evap Rate (L/hr)</label>
					<input type="number" class="form-control input-sm" name="evaporation_rate" id="evaporation_rate" required value="<?php if (isset($_POST['evaporation_rate'])) {echo $_POST['evaporation_rate'];} else {echo $evaporation_rate;} ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="batch_size" class="label-sm">Batch Size (L)</label>
					<input type="number" class="form-control input-sm" name="batch_size" id="batch_size" required value="<?php if (isset($_POST['batch_size'])) {echo $_POST['batch_size'];} else {echo $batch_size;} ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="mash_efficiency" class="label-sm">Mash Eff (%)</label>
					<input type="number" class="form-control input-sm" name="mash_efficiency" id="mash_efficiency" required value="<?php if (isset($_POST['mash_efficiency'])) {echo $_POST['mash_efficiency'];} else {echo $mash_efficiency;} ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="loss" class="label-sm">Loss (L)</label>
					<input type="number" class="form-control input-sm" name="loss" id="loss" required value="<?php if (isset($_POST['loss'])) {echo $_POST['loss'];} else {echo $loss;} ?>" />
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
