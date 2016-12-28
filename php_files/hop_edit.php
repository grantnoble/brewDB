<?php

/*
hop_edit.php
Edit a hop in the database
*/

$page_title = 'Edit Hop';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // form validation OK, so retrieve the field values
    $hop['id'] = mysqli_real_escape_string($connection, test_input($_POST['id']));
    $hop['name'] = mysqli_real_escape_string($connection, test_input($_POST['name']));
    $hop['alpha'] = mysqli_real_escape_string($connection, test_input($_POST['alpha']));
    $hop['origin'] = mysqli_real_escape_string($connection, test_input($_POST['origin']));
    $hop['substitutes'] = mysqli_real_escape_string($connection, test_input($_POST['substitutes']));
    $hop['notes'] = mysqli_real_escape_string($connection, test_input($_POST['notes']));

    $query = "UPDATE hops SET hop_name='" . $hop['name'] . "', hop_alpha='" . $hop['alpha'] . "', hop_origin='" . $hop['origin'] . "', hop_substitutes='" . $hop['substitutes'] . "', hop_notes='" . $hop['notes'] . "' WHERE hop_id='" . $hop['id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

    // After saving to the database, redirect back to the list fermentables page
	echo '<script type="text/javascript">
	window.location = "hops_list.php"
	</script>';

}

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
    // get the hop
    $query = "SELECT * FROM hops WHERE hop_id='" . $_GET['id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

}
// if id isn't set, or isn't valid, redirect back to view page
else
{
	echo '<script type="text/javascript">
	window.location = "hops_list.php"
	</script>';
}

while($row = mysqli_fetch_array( $result ))
{
    $id = $row['hop_id'];
    $name = $row['hop_name'];
    $alpha = $row['hop_alpha'];
    $origin = $row['hop_origin'];
    $substitutes = $row['hop_substitutes'];
    $notes = $row['hop_notes'];
}

// end of PHP section, now create the HTML form
?>

<div class="container">

	<h2>Edit Hop</h2>

	<form role="form" class="form-horizontal" name="hopform" action="hop_edit.php" method="post">

	<input type="hidden" name="id" value="<?php echo $id; ?>" />

	<div class="row">

		<fieldset class="col-xs-12 col-md-12">

		<div class="well">

			<div class="row margin-bottom-1em">

				<div class="col-xs-3 col-md-3">
					<label for="name" class="label-sm">Name</label>
					<input type="text" class="form-control input-sm" name="name" id="name" required value="<?php if (isset($_POST['name'])) {echo $_POST['name'];} else {echo $name;} ?>" />
				</div>

				<div class="col-xs-2 col-md-2">
					<label for="alpha" class="label-sm">Alpha (%)</label>
					<input type="number" class="form-control input-sm" name="alpha" id="alpha" value="<?php if (isset($_POST['alpha'])) {echo $_POST['alpha'];} else {echo $alpha;} ?>" />
				</div>

				<div class="col-xs-3 col-md-3">
					<label for="origin" class="label-sm">Origin</label>
					<input type="text" class="form-control input-sm" name="origin" id="origin" value="<?php if (isset($_POST['origin'])) {echo $_POST['origin'];} else {echo $origin;} ?>" />
				</div>

				<div class="col-xs-3 col-md-3">
					<label for="substitutes" class="label-sm">Substitutes</label>
					<input type="text" class="form-control input-sm" name="substitutes" id="substitutes" value="<?php if (isset($_POST['substitutes'])) {echo $_POST['substitutes'];} else {echo $substitutes;} ?>" />
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
include '../includes/footer.html';
?>
