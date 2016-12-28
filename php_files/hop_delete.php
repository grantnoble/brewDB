<?php

/*
hop_delete.php
Delete a hop in the database
*/

$page_title = 'Delete Hop';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if ($_POST['sure'] == 'Yes')
    {
        $hop_id = mysqli_real_escape_string($connection, htmlspecialchars($_POST['id']));
        $query = "DELETE from hops WHERE hop_id='" . $hop_id . "'";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    // After deleting or not, redirect back to the hops_list page
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
// if id isn't set, or isn't valid, redirect back to list page
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

?>

<div class="container">

	<h2>Delete Hop</h2>

	<form role="form" class="form-horizontal" name="hopform" action="hop_delete.php" method="post">

	<div class="row">

		<fieldset class="col-xs-12 col-md-12">

		<div class="well">

			<div class="row margin-bottom-1em">

				<div class="col-xs-3 col-md-3">
					<label for="name" class="label-sm">Name</label>
					<input type="text" class="form-control input-sm" name="name" id="name" readonly="yes" value="<?php echo $name; ?>" />
				</div>

				<div class="col-xs-2 col-md-2">
					<label for="alpha" class="label-sm">Alpha (%)</label>
					<input type="number" class="form-control input-sm" name="alpha" id="alpha" readonly="yes" value="<?php echo $alpha; ?>" />
				</div>

				<div class="col-xs-3 col-md-3">
					<label for="origin" class="label-sm">Origin</label>
					<input type="text" class="form-control input-sm" name="origin" id="origin" readonly="yes" value="<?php echo $origin; ?>" />
				</div>

				<div class="col-xs-3 col-md-3">
					<label for="substitutes" class="label-sm">Substitutes</label>
					<input type="text" class="form-control input-sm" name="substitutes" id="substitutes" readonly="yes" value="<?php echo $substitutes; ?>" />
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
include '../includes/footer.html';
?>
