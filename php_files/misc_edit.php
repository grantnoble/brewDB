<?php
/*
misc_edit.php
Edit a misc in the database
*/

$page_title = 'Edit Miscellaneous Ingredient';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // form validation OK, so retrieve the field values
    $misc['id'] = mysqli_real_escape_string($connection, test_input($_POST['id']));
    $misc['name'] = mysqli_real_escape_string($connection, test_input($_POST['name']));
    $misc['type'] = mysqli_real_escape_string($connection, test_input($_POST['type']));
    $misc['use'] = mysqli_real_escape_string($connection, test_input($_POST['use']));
    $misc['use_for'] = mysqli_real_escape_string($connection, test_input($_POST['use_for']));
    $misc['notes'] = mysqli_real_escape_string($connection, test_input($_POST['notes']));

    $query = "UPDATE miscs SET misc_name='" . $misc['name'] . "', misc_type='" . $misc['type'] . "', misc_use='" . $misc['use'] . "', misc_use_for='" . $misc['use_for'] . "', misc_notes='" . $misc['notes'] . "' WHERE misc_id='" . $misc['id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

    // After saving to the database, redirect back to the list miscs page
	echo '<script type="text/javascript">
	window.location = "miscs_list.php"
	</script>';
}

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
    // get the misc
    $query = "SELECT * FROM miscs WHERE misc_id='" . $_GET['id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
}
// if id isn't set, or isn't valid, redirect back to the list miscs page
else
{
	echo '<script type="text/javascript">
	window.location = "miscs_list.php"
	</script>';
}

while($row = mysqli_fetch_array( $result ))
{
    $id = $row['misc_id'];
    $name = $row['misc_name'];
    $type = $row['misc_type'];
    $use = $row['misc_use'];
    $use_for = $row['misc_use_for'];
    $notes = $row['misc_notes'];
}
?>

<div class="container">

	<h2>Edit Miscellaneous Ingredient</h2>

	<form role="form" name="miscform" data-toggle="validator" action="misc_edit.php" method="post">

	<input type="hidden" name="id" value="<?php echo $id; ?>" />

		<div class="well">

			<div class="row">

				<div class="form-group col-xs-3 col-md-3">
					<label for="name" class="label-sm">Name</label>
					<input type="text" class="form-control input-sm" name="name" id="name" required data-error="Ingredient name required" value="<?php if (isset($_POST['name'])) {echo $_POST['name'];} else {echo $name;} ?>" />
					<div class="help-block with-errors"></div>
				</div>

				<div class="form-group col-xs-3 col-md-2">
					<label for="type" class="label-sm">Type</label>
					<select name="type" id="type" class="form-control input-sm">
						<option selected><?php if (isset($_POST['type'])) {echo $_POST['type'];} else {echo $type;} ?></option>
						<option>Spice</option>
						<option>Fining</option>
						<option>Water Agent</option>
						<option>Herb</option>
						<option>Flavor</option>
						<option>Other</option>
					</select>
				</div>

				<div class="form-group col-xs-3 col-md-2">
					<label for="use" class="label-sm">Use</label>
					<select name="use" id="use" class="form-control input-sm">
						<option selected><?php if (isset($_POST['use'])) {echo $_POST['use'];} else {echo $use;} ?></option>
						<option>Mash</option>
						<option>Boil</option>
						<option>Primary</option>
						<option>Secondary</option>
						<option>Bottling</option>
					</select>
				</div>


				<div class="form-group col-xs-3 col-md-3">
					<label for="use_for" class="label-sm">Use For</label>
					<input type="text" class="form-control input-sm" name="use_for" id="use_for" value="<?php if (isset($_POST['use_for'])) {echo $_POST['use_for'];} else {echo $use_for;} ?>" />
				</div>

			</div>

			<div class="row">

				<div class="form-group col-xs-12 col-md-12">
					<label for="notes" class="label-sm">Notes</label>
					<textarea rows=3 cols=130 class="form-control input-sm" name="notes" id="notes"><?php if (isset($_POST['notes'])) {echo $_POST['notes'];} else {echo $notes;} ?></textarea>
				</div>

			</div>

		</div><!-- well -->

		<button type="submit" class="btn btn-default">Save</button>

	</form>

</div><!-- container -->

<?php
include '../includes/footer.html';
?>
