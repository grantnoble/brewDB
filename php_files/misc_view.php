<?php
/*
misc_view.php
View a misc in the database
*/

$page_title = 'View Miscellaneous Ingredient';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

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

	<h2>View Miscellaneous Ingredient</h2>

	<form role="form" name="miscform" action="misc_edit.php" method="post">

	<input type="hidden" name="id" value="<?php echo $id; ?>" />

		<div class="well">

			<div class="row">

				<div class="form-group col-xs-3 col-md-3">
					<label for="name" class="label-sm">Name</label>
					<input type="text" class="form-control input-sm" name="name" id="name" readonly="yes" value="<?php echo $name; ?>" />
				</div>

				<div class="form-group col-xs-3 col-md-2">
					<label for="type" class="label-sm">Type</label>
					<input type="text" class="form-control input-sm" name="type" id="type" readonly="yes" value="<?php echo $type; ?>" />
				</div>

				<div class="form-group col-xs-3 col-md-2">
					<label for="use" class="label-sm">Use</label>
					<input type="text" class="form-control input-sm" name="use" id="use" readonly="yes" value="<?php echo $use; ?>" />
				</div>


				<div class="form-group col-xs-3 col-md-3">
					<label for="use_for" class="label-sm">Use For</label>
					<input type="text" class="form-control input-sm" name="use_for" id="use_for" readonly="yes" value="<?php echo $use_for; ?>" />
				</div>

			</div>


			<div class="row">

				<div class="form-group col-xs-12 col-md-12">
					<label for="notes" class="label-sm">Notes</label>
					<textarea rows=3 cols=130 class="form-control input-sm" name="notes" id="notes" readonly="yes"><?php echo $notes; ?></textarea>
				</div>

			</div>

		</div><!-- well -->

	</form>

</div><!-- container -->

<!-- new form to submit only the fermentable id using get not post-->
<div class="container">

	<form role="form" name="miscformedit" action="misc_edit.php" method="get">
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input class="btn btn-default" type="submit" value="Edit" />
	</form>

</div>

<?php
include '../includes/footer.html';
?>
