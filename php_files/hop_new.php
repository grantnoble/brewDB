<?php
/*
hop_new.php
Add a hop to the database
*/

$page_title = 'New Hop';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // retrieve the field values
    $hop['name'] = mysqli_real_escape_string($connection, test_input($_POST['name']));
    $hop['alpha'] = mysqli_real_escape_string($connection, test_input($_POST['alpha']));
    $hop['origin'] = mysqli_real_escape_string($connection, test_input($_POST['origin']));
    $hop['substitutes'] = mysqli_real_escape_string($connection, test_input($_POST['substitutes']));
    $hop['notes'] = mysqli_real_escape_string($connection, test_input($_POST['notes']));

    // set up the SQL INSERT
    $columns = "INSERT into hops (hop_name, hop_alpha, hop_origin, hop_substitutes, hop_notes) ";
    $values = "VALUES ('" . $hop['name'] . "', '" . $hop['alpha'] . "', '" . $hop['origin'] . "', '" . $hop['substitutes'] . "', '" . $hop['notes'] . "')";
    $query = $columns . $values;
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

    // After saving to the database, redirect back to the list hops page
	echo '<script type="text/javascript">
	window.location = "hops_list.php"
	</script>';
}
?>

<div class="container">

	<h2>New Hop</h2>

	<form role="form" name="hopform" data-toggle="validator" action="hop_new.php" method="post">

		<div class="well">

			<div class="row">

				<div class="form-group col-xs-3 col-md-3">
					<label for="name" class="label-sm">Name</label>
					<input type="text" class="form-control input-sm" name="name" id="name" required data-error="Hop name required" />
					<div class="help-block with-errors"></div>
				</div>

				<div class="col-xs-2 col-md-2">
					<label for="alpha" class="label-sm">Alpha (%)</label>
					<input type="number" class="form-control input-sm" name="alpha" id="alpha" />
				</div>

				<div class="col-xs-3 col-md-3">
					<label for="origin" class="label-sm">Origin</label>
					<input type="text" class="form-control input-sm" name="origin" id="origin" />
				</div>

				<div class="col-xs-3 col-md-3">
					<label for="substitutes" class="label-sm">Substitutes</label>
					<input type="text" class="form-control input-sm" name="substitutes" id="substitutes" />
				</div>

			</div>

			<div class="row">

				<div class="col-xs-12 col-md-12">
					<label for="notes" class="label-sm">Notes</label>
					<textarea class="form-control input-sm" rows=3 cols=100 name="notes" id="notes"></textarea>
				</div>

			</div>

		</div>


	<button type="submit" class="btn btn-default">Save</button>

	</form>

</div>

<?php
include '../includes/footer.html';
?>
