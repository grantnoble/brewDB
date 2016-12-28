<?php

/*
misc_delete.php
Delete a misc in the database
*/

$page_title = 'Delete Miscellaneous Ingredients';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if ($_POST['sure'] == 'Yes')
    {
        $misc_id = mysqli_real_escape_string($connection, htmlspecialchars($_POST['id']));
        $query = "DELETE from miscs WHERE misc_id='" . $misc_id . "'";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    // After deleting or not, redirect back to the miscs_list page
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
// if id isn't set, or isn't valid, redirect back to list page
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

	<h2>Delete Miscellaneous</h2>

	<form role="form" class="form-horizontal" name="miscform" action="misc_delete.php" method="post">

	<div class="row">

		<fieldset class="col-xs-12 col-md-12">

		<div class="well">

			<div class="row margin-bottom-1em">

				<div class="col-xs-3 col-md-2">
					<label for="name" class="label-sm">Name</label>
					<input type="text" class="form-control input-sm" name="name" id="name" readonly="yes" value="<?php if (isset($_POST['name'])) {echo $_POST['name'];} else {echo $name;} ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="type" class="label-sm">Type</label>
					<input type="text" class="form-control input-sm" name="type" id="type" readonly="yes" value="<?php if (isset($_POST['type'])) {echo $_POST['type'];} else {echo $type;} ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="use" class="label-sm">Use</label>
					<input type="text" class="form-control input-sm" name="use" id="use" readonly="yes" value="<?php if (isset($_POST['use'])) {echo $_POST['use'];} else {echo $use;} ?>" />
				</div>

				<div class="col-xs-3 col-md-4">
					<label for="use_for" class="label-sm">Use For</label>
					<input type="text" class="form-control input-sm" name="use_for" id="use_for" readonly="yes" value="<?php if (isset($_POST['use_for'])) {echo $_POST['use_for'];} else {echo $use_for;} ?>" />
				</div>

			</div>


			<div class="row">

				<div class="col-xs-12 col-md-12">
					<label for="notes" class="label-sm">Notes</label>
					<textarea rows=3 cols=130 class="form-control input-sm" name="notes" id="notes" readonly="yes"><?php if (isset($_POST['notes'])) {echo $_POST['notes'];} else {echo $notes;} ?></textarea>
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
