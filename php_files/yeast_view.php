<?php

/*
yeast_view.php
View a yeast in the database
*/

$page_title = 'View Yeasts';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

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
    $laboratory = $row['yeast_laboratory'];
    $product_id = $row['yeast_product_id'];
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

	<form role="form" class="form-horizontal" name="yeastform" action="yeast_edit.php" method="post">

	<input type="hidden" name="id" value="<?php echo $id; ?>" />

	<div class="row">

		<fieldset class="col-xs-12 col-md-12">

		<div class="well">

			<div class="row margin-bottom-1em">

				<div class="col-xs-3 col-md-2">
					<label for="laboratory" class="label-sm">Laboratory</label>
					<input type="text" class="form-control input-sm" name="laboratory" id="laboratory" readonly="yes" value="<?php echo $laboratory; ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="product_id" class="label-sm">Product ID</label>
					<input type="text" class="form-control input-sm" name="product_id" id="product_id" readonly="yes" value="<?php echo $product_id; ?>" />
				</div>

				<div class="col-xs-3 col-md-3">
					<label for="name" class="label-sm">Name</label>
					<input type="text" class="form-control input-sm" name="name" id="name" readonly="yes" value="<?php echo $name; ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="type" class="label-sm">Type</label>
					<input type="text" class="form-control input-sm" name="type" id="type" readonly="yes" value="<?php echo $type; ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="form" class="label-sm">Form</label>
					<input type="text" class="form-control input-sm" name="form" id="form" readonly="yes" value="<?php echo $form; ?>" />
				</div>

			</div>

			<div class="row margin-bottom-1em">

				<div class="col-xs-3 col-md-2">
					<label for="min_temperature" class="label-sm">Min&nbsp;Temp&nbsp;(&deg;C)</label>
					<input type="number" class="form-control input-sm" name="min_temperature" id="min_temperature" readonly="yes" value="<?php echo $min_temperature; ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="max_temperature" class="label-sm">Max&nbsp;Temp&nbsp;(&deg;C)</label>
					<input type="number" class="form-control input-sm" name="max_temperature" id="max_temperature" readonly="yes" value="<?php echo $max_temperature; ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="attenuation" class="label-sm">Attenuation&nbsp;(%)</label>
					<input type="number" class="form-control input-sm" name="attenuation" id="attenuation" readonly="yes" value="<?php echo $attenuation; ?>" />
				</div>

				<div class="col-xs-3 col-md-2">
					<label for="flocculation" class="label-sm">Flocculation</label>
					<input type="text" class="form-control input-sm" name="flocculation" id="flocculation" readonly="yes" value="<?php echo $flocculation; ?>" />
				</div>

				<div class="col-xs-3 col-md-3">
					<label for="best_for" class="label-sm">Best For</label>
					<input type="text" class="form-control input-sm" name="best_for" id="best_for" readonly="yes" value="<?php echo $best_for; ?>" />
				</div>

				<div class="col-xs-3 col-md-1">
					<label for="max_reuse" class="label-sm">Max&nbsp;Reuse</label>
					<input type="number" class="form-control input-sm" name="max_reuse" id="max_reuse" readonly="yes" value="<?php echo $max_reuse; ?>" />
				</div>

			</div>

			<div class="row">

				<div class="col-xs-12 col-md-12">
					<label for="notes" class="label-sm">Notes</label>
					<textarea rows=3 cols=130 class="form-control input-sm" name="notes" id="notes" readonly="yes"><?php echo $notes; ?></textarea>
				</div>

			</div>

		</div>

		</fieldset>

	</div>

	</form>

</div>

<!-- new form to submit only the fermentable id using get not post-->
<div class="container">

<form role="form" class="form-horizontal" name="yeastformedit" action="yeast_edit.php" method="get">
	<input type="hidden" name="id" value="<?php echo $id; ?>" />
	<input class="btn btn-default" type="submit" value="Edit" />
</form>

</div>

<?php
include '../includes/footer.html';
?>
