<?php
/*
misc_new.php
Add a misc to the database
*/

$page_title = 'New Miscellaneous Ingredients';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // retrieve the field values
    $misc['name'] = mysqli_real_escape_string($connection, test_input($_POST['name']));
    $misc['type'] = mysqli_real_escape_string($connection, test_input($_POST['type']));
    $misc['use'] = mysqli_real_escape_string($connection, test_input($_POST['use']));
    $misc['use_for'] = mysqli_real_escape_string($connection, test_input($_POST['use_for']));
    $misc['notes'] = mysqli_real_escape_string($connection, test_input($_POST['notes']));

    // set up the SQL INSERT
    $columns = "INSERT into miscs (misc_name, misc_type, misc_use, misc_use_for, misc_notes) ";
    $values = "VALUES ('" . $misc['name'] . "', '" . $misc['type'] . "', '" . $misc['use'] . "', '" . $misc['use_for'] . "', '" . $misc['notes'] . "')";
    $query = $columns . $values;
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

    // After saving to the database, redirect back to the list miscs page
	echo '<script type="text/javascript">
	window.location = "miscs_list.php"
	</script>';
}
?>

<div class="container">

	<h2>New Miscellaneous Ingredient</h2>

	<form role="form" name="miscform" data-toggle="validator" action="misc_new.php" method="post">

		<div class="well">

			<div class="row ">

				<div class="form-group col-xs-3 col-md-3">
					<label for="name" class="label-sm">Name</label>
					<input type="text" class="form-control input-sm" name="name" id="name" required data-error="Ingredient name required" />
					<div class="help-block with-errors"></div>
				</div>

				<div class="form-group col-xs-3 col-md-2">
					<label for="type" class="label-sm">Type</label>
					<select name="type" id="type" class="form-control input-sm">
						<option value selected disabled></option>
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
						<option value selected disabled></option>
						<option>Mash</option>
						<option>Boil</option>
						<option>Primary</option>
						<option>Secondary</option>
						<option>Bottling</option>
					</select>
				</div>

				<div class="form-group col-xs-3 col-md-3">
					<label for="use_for" class="label-sm">Use For</label>
					<input type="text" class="form-control input-sm" name="use_for" id="use_for" />
				</div>

			</div>

			<div class="row">

				<div class="form-group col-xs-12 col-md-12">
					<label for="notes" class="label-sm">Notes</label>
					<textarea rows=3 cols=130 class="form-control input-sm" name="notes" id="notes"></textarea>
				</div>

			</div>

		</div><!-- well -->

	<button type="submit" class="btn btn-default">Save</button>

	</form>

</div><!-- container -->

<?php
include '../includes/footer.html';
?>
