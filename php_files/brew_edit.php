<?php

/*
brew_edit.php
Edit a brew in the database
*/

$page_title = 'Edit Brew';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$details['id'] = mysqli_real_escape_string($connection, test_input($_POST['id']));
	$details['name'] = mysqli_real_escape_string($connection, test_input($_POST['name']));
	$details['batch_number'] = mysqli_real_escape_string($connection, test_input($_POST['batch_number']));
	$details['date'] = mysqli_real_escape_string($connection, test_input($_POST['date']));
	if (!$details['date'])
	{
		$details['date'] = "0000-00-00";
	}

	//query the database to retireve the recipe_id for the base recipe
	$details['base_recipe'] = mysqli_real_escape_string($connection, test_input($_POST['base_recipe']));
	$query = "SELECT recipe_id FROM recipes WHERE recipe_name='" . $details['base_recipe'] . "'";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	while ($row = mysqli_fetch_array ( $result ))
	{
		$details['recipe_id'] = $row['recipe_id'];
	}

	$details['type'] = mysqli_real_escape_string($connection, test_input($_POST['type']));

	// query the database to retrieve the style_id for the style
	$details['style'] = mysqli_real_escape_string($connection, test_input($_POST['style']));
	$query = "SELECT style_id FROM styles WHERE style_name='" . $details['style'] . "'";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	while ($row = mysqli_fetch_array ( $result ))
	{
		$details['style_id'] = $row['style_id'];
	}

	// retrieve the basic brew details
	$details['method'] = mysqli_real_escape_string($connection, test_input($_POST['method']));
	$details['no_chill'] = mysqli_real_escape_string($connection, test_input($_POST['no_chill']));

	$details['mash_volume'] = mysqli_real_escape_string($connection, test_input($_POST['mash_volume']));
	$details['sparge_volume'] = mysqli_real_escape_string($connection, test_input($_POST['sparge_volume']));
	$details['boil_size'] = mysqli_real_escape_string($connection, test_input($_POST['boil_size']));
	$details['boil_time'] = mysqli_real_escape_string($connection, test_input($_POST['boil_time']));
	$details['batch_size'] = mysqli_real_escape_string($connection, test_input($_POST['batch_size']));
	$details['mash_efficiency'] = mysqli_real_escape_string($connection, test_input($_POST['mash_efficiency']));
	$details['brewer'] = mysqli_real_escape_string($connection, test_input($_POST['brewer']));
	$details['notes'] = mysqli_real_escape_string($connection, test_input($_POST['notes']));


	$details['est_og'] = mysqli_real_escape_string($connection, test_input($_POST['est_og']));
	if (!$details['est_og'])
	{
		$details['est_og'] = "NULL";
	}

	$details['act_og'] = mysqli_real_escape_string($connection, test_input($_POST['act_og']));
	if (!$details['act_og'])
	{
		$details['act_og'] = "NULL";
	}

	$details['est_fg'] = mysqli_real_escape_string($connection, test_input($_POST['est_fg']));
	if (!$details['est_fg'])
	{
		$details['est_fg'] = "NULL";
	}

	$details['act_fg'] = mysqli_real_escape_string($connection, test_input($_POST['act_fg']));
	if (!$details['act_fg'])
	{
		$details['act_fg'] = "NULL";
	}

	$details['est_ibu'] = mysqli_real_escape_string($connection, test_input($_POST['est_ibu']));
	if (!$details['est_ibu'])
	{
		$details['est_ibu'] = "NULL";
	}

	$details['est_color'] = mysqli_real_escape_string($connection, test_input($_POST['est_color']));
	if (!$details['est_color'])
	{
		$details['est_color'] = "NULL";
	}

	$details['est_abv'] = mysqli_real_escape_string($connection, test_input($_POST['est_abv']));
	if (!$details['est_abv'])
	{
		$details['est_abv'] = "NULL";
	}

	$details['act_abv'] = mysqli_real_escape_string($connection, test_input($_POST['act_abv']));
	if (!$details['act_abv'])
	{
		$details['act_abv'] = "NULL";
	}

	// retrieve the brew fermentables
	for ($i=0; $i<=14; $i++)
	{
		$fermentables[$i]['id'] = mysqli_real_escape_string($connection, test_input($_POST['fermentable' . $i . '_id']));
		$fermentables[$i]['name'] = mysqli_real_escape_string($connection, test_input($_POST['fermentable' . $i . '_name']));
		$fermentables[$i]['amount'] = mysqli_real_escape_string($connection, test_input($_POST['fermentable' . $i . '_amount']));
		$fermentables[$i]['use'] = mysqli_real_escape_string($connection, test_input($_POST['fermentable' . $i . '_use']));
		$fermentables[$i]['record_id'] = mysqli_real_escape_string($connection, test_input($_POST['fermentable' . $i . '_record_id']));
		$fermentables[$i]['flag'] = mysqli_real_escape_string($connection, test_input($_POST['fermentable' . $i . '_flag']));
	}

	// retrieve the brew hops
	for ($i=0; $i<=14; $i++)
	{
		$hops[$i]['id'] = mysqli_real_escape_string($connection, test_input($_POST['hop' . $i . '_id']));
		$hops[$i]['name'] = mysqli_real_escape_string($connection, test_input($_POST['hop' . $i . '_name']));
		$hops[$i]['amount'] = mysqli_real_escape_string($connection, test_input($_POST['hop' . $i . '_amount']));
		$hops[$i]['alpha'] = mysqli_real_escape_string($connection, test_input($_POST['hop' . $i . '_alpha']));
		$hops[$i]['time'] = mysqli_real_escape_string($connection, test_input($_POST['hop' . $i . '_time']));
		$hops[$i]['form'] = mysqli_real_escape_string($connection, test_input($_POST['hop' . $i . '_form']));
		$hops[$i]['use'] = mysqli_real_escape_string($connection, test_input($_POST['hop' . $i . '_use']));
		$hops[$i]['record_id'] = mysqli_real_escape_string($connection, test_input($_POST['hop' . $i . '_record_id']));
		$hops[$i]['flag'] = mysqli_real_escape_string($connection, test_input($_POST['hop' . $i . '_flag']));
	}

	// retrieve the brew yeasts
	$yeasts[0]['id'] = mysqli_real_escape_string($connection, test_input($_POST['yeast0_id']));
	$yeasts[0]['fullname'] = mysqli_real_escape_string($connection, test_input($_POST['yeast0_fullname']));
	$yeasts[0]['record_id'] = mysqli_real_escape_string($connection, test_input($_POST['yeast0_record_id']));
	$yeasts[$i]['flag'] = mysqli_real_escape_string($connection, test_input($_POST['yeast0_flag']));

	// retrieve the brew misc ingredients
	for ($i=0; $i<=4; $i++)
	{
		$miscs[$i]['id'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_id']));
		$miscs[$i]['name'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_name']));
		$miscs[$i]['amount'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_amount']));
		$miscs[$i]['unit'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_unit']));
		$miscs[$i]['type'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_type']));
		$miscs[$i]['use'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_use']));
		$miscs[$i]['record_id'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_record_id']));
		$miscs[$i]['flag'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_flag']));
	}

	// retrieve the brew mash details
	for ($i=0; $i<=4; $i++)
	{
		$mashes[$i]['temp'] = mysqli_real_escape_string($connection, test_input($_POST['mash' . $i . '_temp']));
		$mashes[$i]['time'] = mysqli_real_escape_string($connection, test_input($_POST['mash' . $i . '_time']));
		$mashes[$i]['record_id'] = mysqli_real_escape_string($connection, test_input($_POST['mash' . $i . '_record_id']));
		$mashes[$i]['flag'] = mysqli_real_escape_string($connection, test_input($_POST['mash' . $i . '_flag']));
	}

	// retrieve the brew fermentation details
	for ($i=0; $i<=4; $i++)
	{
		$fermentations[$i]['start_date'] = mysqli_real_escape_string($connection, test_input($_POST['fermentation' . $i . '_start_date']));
		$fermentations[$i]['end_date'] = mysqli_real_escape_string($connection, test_input($_POST['fermentation' . $i . '_end_date']));
		$fermentations[$i]['temp'] = mysqli_real_escape_string($connection, test_input($_POST['fermentation' . $i . '_temp']));
		$fermentations[$i]['measured_sg'] = mysqli_real_escape_string($connection, test_input($_POST['fermentation' . $i . '_measured_sg']));
		$fermentations[$i]['record_id'] = mysqli_real_escape_string($connection, test_input($_POST['fermentation' . $i . '_record_id']));
		$fermentations[$i]['flag'] = mysqli_real_escape_string($connection, test_input($_POST['fermentation' . $i . '_flag']));
	}

	// retrieve the brew packaging details
	$details['packaging'] = mysqli_real_escape_string($connection, test_input($_POST['packaging']));
	$details['packaging_date'] = mysqli_real_escape_string($connection, test_input($_POST['packaging_date']));
	$details['vol_co2'] = mysqli_real_escape_string($connection, test_input($_POST['vol_co2']));

	// now update the records in the database

	// update the brew record
	$query = "UPDATE brews SET brew_name='" . $details['name'] . "', brew_date='" . $details['date'] . "', brew_recipe_id='" . $details['recipe_id'] . "', brew_type='" . $details['type'] . "', brew_style_id='" . $details['style_id'] . "', brew_method='" . $details['method'] . "', brew_no_chill='" . $details['no_chill'] . "', brew_mash_volume=" . $details['mash_volume'] . ", brew_sparge_volume=" . $details['sparge_volume'] . ", brew_boil_size=" . $details['boil_size'] . ", brew_boil_time=" . $details['boil_time'] . ", brew_batch_size=" . $details['batch_size'] . ", brew_mash_efficiency=" . $details['mash_efficiency'] . ", brew_brewer='" . $details['brewer'] . "', brew_notes='" . $details['notes'] . "', brew_est_og=" . $details['est_og'] . ", brew_act_og=" . $details['act_og'] . ", brew_est_fg=" . $details['est_fg'] . ", brew_act_fg=" . $details['act_fg'] . ", brew_est_color=" . $details['est_color'] . ", brew_est_ibu=" . $details['est_ibu'] . ", brew_est_abv=" . $details['est_abv'] . ", brew_act_abv=" . $details['act_abv'] . ", brew_packaging='" . $details['packaging'] . "', brew_packaging_vol_co2=" . $details['vol_co2'] . ", brew_packaging_date='" . $details['packaging_date'] . "' WHERE brew_id='" . $details['id'] . "'";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

	// for each fermentable, do the update process
	for ($i=0; $i<=14; $i++)
	{
		// if the update flag is set, a DELETE, UPDATE, or INSERT is required, else do nothing.
		if ($fermentables[$i]['flag'])
		{
			// if record_id, and amount is zero, DELETE
			if ($fermentables[$i]['record_id'] && $fermentables[$i]['amount']==0)
			{
				$query = "DELETE FROM brews_fermentables WHERE brew_fermentable_id='" . $fermentables[$i]['record_id'] . "'";
			}
			// else if record_id and name, UPDATE
			elseif ($fermentables[$i]['record_id'] && $fermentables[$i]['name'])
			{
				$query = "UPDATE brews_fermentables SET brew_fermentable_fermentable_id='" . $fermentables[$i]['id'] . "', brew_fermentable_amount='" . $fermentables[$i]['amount'] . "', brew_fermentable_use='" . $fermentables[$i]['use'] . "' WHERE brew_fermentable_id='" . $fermentables[$i]['record_id'] . "'";
			}
			// else if !record_id and name, INSERT
			elseif ((!$fermentables[$i]['record_id']) && $fermentables[$i]['name'])
			{
				$query = "INSERT INTO brews_fermentables (brew_fermentable_brew_id, brew_fermentable_fermentable_id, brew_fermentable_amount, brew_fermentable_use) VALUES ('" . $details['id'] . "','" . $fermentables[$i]['id'] . "'," . $fermentables[$i]['amount'] . ",'" . $fermentables[$i]['use'] . "')";
			}
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

	// for each hop, do the update process
	for ($i=0; $i<=14; $i++)
	{
		// if the update flag is set, a DELETE, UPDATE, or INSERT is required, else do nothing.
		if ($hops[$i]['flag'])
		{
			// if record_id, and amount is zero, DELETE
			if ($hops[$i]['record_id'] && $hops[$i]['amount']==0)
			{
				$query = "DELETE FROM brews_hops WHERE brew_hop_id='" . $hops[$i]['record_id'] . "'";
			}
			// else if record_id and name, UPDATE
			elseif ($hops[$i]['record_id'] && $hops[$i]['name'])
			{
				$query = "UPDATE brews_hops SET brew_hop_hop_id='" . $hops[$i]['id'] . "', brew_hop_amount=" . $hops[$i]['amount'] . ", brew_hop_alpha=" . $hops[$i]['alpha'] . ",brew_hop_use='" . $hops[$i]['use'] . "', brew_hop_time=" . $hops[$i]['time'] . ", brew_hop_form='" . $hops[$i]['form'] . "' WHERE brew_hop_id='" . $hops[$i]['record_id'] . "'";
			}
			// else if !record_id and name, INSERT
			elseif ((!$hops[$i]['record_id']) && $hops[$i]['name'])
			{
				$query = "INSERT INTO brews_hops (brew_hop_brew_id, brew_hop_hop_id, brew_hop_amount, brew_hop_alpha, brew_hop_use, brew_hop_time, brew_hop_form) VALUES ('" . $details['id'] . "','" . $hops[$i]['id'] . "'," . $hops[$i]['amount'] . "," . $hops[$i]['alpha'] . ",'" . $hops[$i]['use'] . "'," . $hops[$i]['time'] . ",'" . $hops[$i]['form'] . "')";
			}
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}


	// for each yeast, do the update process
	for ($i=0; $i<=0; $i++)
	{
		// if the update flag is set, a DELETE, UPDATE, or INSERT is required, else do nothing.
		if ($yeasts[$i]['flag'])
		{
			/* if record_id and name is DELETE, DELETE
			if ($yeasts[$i]['record_id'] && $yeasts[$i]['amount']==0)
			{
				$query = "DELETE FROM brews_yeasts WHERE brew_yeast_id='" . $yeasts[$i]['record_id'] . "'";
			}*/
			// else if record_id and name, UPDATE
			if ($yeasts[$i]['record_id'] && $yeasts[$i]['fullname'])
			{
				$query = "UPDATE brews_yeasts SET brew_yeast_yeast_id='" . $yeasts[$i]['id'] . "' WHERE brew_yeast_id='" . $yeasts[$i]['record_id'] . "'";
			}
			// else if !record_id and name, INSERT
			elseif ((!$yeasts[$i]['record_id']) && $yeasts[$i]['fullname'])
			{
				$query = "INSERT INTO brews_yeasts (brew_yeast_brew_id, brew_yeast_yeast_id) VALUES (" . $details['id'] . "," . $yeasts[$i]['id'] . ")";
			}
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

	// for each misc, do the update process
	for ($i=0; $i<=14; $i++)
	{
		// if the update flag is set, a DELETE, UPDATE, or INSERT is required, else do nothing.
		if ($miscs[$i]['flag'])
		{
			// if record_id and amount is zero, DELETE
			if ($miscs[$i]['record_id'] && $miscs[$i]['amount']==0)
			{
				$query = "DELETE FROM brews_miscs WHERE brew_misc_id='" . $miscs[$i]['record_id'] . "'";
			}
			// else if record_id and name, UPDATE
			elseif ($miscs[$i]['record_id'] && $miscs[$i]['name'])
			{
				$query = "UPDATE brews_miscs SET brew_misc_misc_id='" . $miscs[$i]['id'] . "', brew_misc_amount='" . $miscs[$i]['amount'] . "', brew_misc_unit='" . $miscs[$i]['unit'] . "', brew_misc_use='" . $miscs[$i]['use'] . "' WHERE brew_misc_id='" . $miscs[$i]['record_id'] . "'";
			}
			// else if !record_id and name, INSERT
			elseif ((!$miscs[$i]['record_id']) && $miscs[$i]['name'])
			{
				$query = "INSERT INTO brews_miscs (brew_misc_brew_id, brew_misc_misc_id, brew_misc_amount, brew_misc_unit, brew_misc_use) VALUES ('" . $details['id'] . "','" . $miscs[$i]['id'] . "'," . $miscs[$i]['amount'] . ",'" . $miscs[$i]['unit'] . "','" . $miscs[$i]['use'] ."')";
			}
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

	// for each mash, do the update process
	for ($i=0; $i <=4; $i++)
	{
		// if the update flag is set, a DELETE, UPDATE, or INSERT is required, else do nothing.
		if ($mashes[$i]['flag'])
		{
			// if record_id and !temp and !time, DELETE
			if ($mashes[$i]['record_id'] && (!$mashes[$i]['temp']) && (!$mashes[$i]['time']))
			{
				$query = "DELETE FROM brews_mashes WHERE brew_mash_id='" . $mashes[$i]['record_id'] . "'";
			}
			// else if record_id and (temp or time), UPDATE
			elseif ($mashes[$i]['record_id'] && ($mashes[$i]['temp'] || $mashes[$i]['time']))
			{
				$query = "UPDATE brews_mashes SET brew_mash_temp=" . $mashes[$i]['temp'] . ", brew_mash_time=" . $mashes[$i]['time'] . " WHERE brew_mash_id='" . $mashes[$i]['record_id'] . "'";
			}
			// else if !record_id and (temp or time), INSERT
			elseif ((!$mashes[$i]['record_id']) && ($mashes[$i]['temp'] || $mashes[$i]['time']))
			{
				$query = "INSERT INTO brews_mashes (brew_mash_brew_id, brew_mash_temp, brew_mash_time) VALUES (" . $brew_id . "," . $mashes[$i]['temp'] . "," . $mashes[$i]['time'] . ")";
			}
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

	// for each fermentation, do the update process
	for ($i=0; $i <=4; $i++)
	{
		// if the fermentation flag is set, a DELETE, UPDATE, or INSERT is required, else do nothing.
		if ($fermentations[$i]['flag'])
		{
			// if record_id and !temp and !time, DELETE
			if ($fermentations[$i]['record_id'] && (!$fermentations[$i]['start_date']) && (!$fermentations[$i]['end_date']) && (!$fermentations[$i]['temp']) && (!$fermentations[$i]['measured_sg']))
			{
				$query = "DELETE FROM brews_fermentations WHERE brew_fermentation_id='" . $fermentations[$i]['record_id'] . "'";
			}
			// else if record_id and (start_date or end_date or temp or measured_sg), UPDATE
			elseif ($fermentations[$i]['record_id'] && ($fermentations[$i]['start_date'] || $fermentations[$i]['end_date'] || $fermentations[$i]['temp'] || $fermentations[$i]['measured_sg']))
			{
				$query = "UPDATE brews_fermentations SET brew_fermentation_start_date='" . $fermentations[$i]['start_date'] . "', brew_fermentation_end_date='" . $fermentations[$i]['end_date'] . "', brew_fermentation_temp=" . $fermentations[$i]['temp'] . ", brew_fermentation_measured_sg=" . $fermentations[$i]['measured_sg'] . " WHERE brew_fermentation_id='" . $fermentations[$i]['record_id'] . "'";
			}
			// else if !record_id and (temp or time), INSERT
			elseif ((!$fermentations[$i]['record_id']) && ($fermentations[$i]['temp'] || $fermentations[$i]['time']))
			{
				$query = "INSERT INTO brews_fermentations (brew_fermentation_brew_id, brew_fermentation_start_date, brew_fermentation_end_date, brew_fermentation_temp, brew_fermentation_measured_sg) VALUES (" . $brew_id . ",'" . $fermentations[$i]['start_date'] . "','" . $fermentations[$i]['end_date'] . "'," . $fermentations[$i]['temp'] . "," . $fermentations[$i]['measured_sg'] . ")";
			}
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

    // After saving to the database, redirect back to the list brew page
	echo '<script type="text/javascript">
	window.location = "brew_list.php"
	</script>';
}

// not a form submission, so retrieve the brew details
// check that the 'id' variable is set in URL and it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
// get the brew details
include('includes/get_brew_details.php');
}
// else if the id isn't set, or isn't valid, redirect back to list brews page
else
{
	echo '<script type="text/javascript">
	window.location = "brews_list.php"
	</script>';
}

// end of PHP section, now create the HTML form
?>

<div class="container">

<h2>Edit Brew</h2>

<form role="form" class="form-horizontal" name="brewform" action="brew_edit.php" method="post">

<input type="hidden" name="id" value="<?php echo $details['id']; ?>" />

<div class="row">

<fieldset class="col-xs-12 col-sm-6 col-md-8">

<div class="well">
<legend>Brew Details</legend>

	<div class="row margin-bottom-1em">

		<div class="col-xs-4 col-md-3">
			<label for="name" class="label-sm">Brew Name</label>
			<input type="text" class="form-control input-sm" id="name" name="name" value="<?php echo $details['name']; ?>" />
		</div>

		<div class="col-xs-4 col-md-3">
			<label for="base_recipe" class="label-sm">Base Recipe</label>
			<select class="form-control input-sm" id="base_recipe" name="base_recipe" onchange="getrecipeinfo(this.value);" >
				<option value="<?php echo $details['base_recipe']; ?>"><?php echo $details['base_recipe']; ?></option>
				<?php
				$query = "SELECT recipe_name FROM recipes ORDER BY recipe_date DESC";
				$result = mysqli_query($connection, $query);
				while ($row = mysqli_fetch_array ( $result ))
				{
					echo '<option value="' . $row['recipe_name'] . '">' . $row['recipe_name'] . '</option>';
				}
				?>
			</select>
		</div>

		<div class="col-xs-4 col-md-3">
			<label for="style" class="label-sm">Style</label>
			<input type="text" class="form-control input-sm" id="style" name="style" value="<?php echo $style['name']; ?>" />
		</div>

		<div class="col-xs-4 col-md-3">
			<label for="type" class="label-sm">Type</label>
			<input type="text" class="form-control input-sm" id="type" name="type" value="<?php echo $details['type']; ?>" />
		</div>

	</div>

	<div class="row margin-bottom-1em">

		<div class="col-xs-2 col-md-2">
			<label for="batch_number" class="label-sm">Batch Number</label>
			<input type="text" class="form-control input-sm" id="batch_number" name="batch_number" readonly="yes" value="<?php echo $details['batch_number']; ?>" />
		</div>

		<div class="col-xs-5 col-sm-4 col-md-3">
			<label for="date" class="label-sm">Date (yyyy-mm-dd)</label>
			<input type="date" class="form-control input-sm" id="date" name="date" value="<?php echo $details['date']; ?>" />
		</div>

		<div class="col-xs-3 col-md-4">
			<label for="brew_method" class="label-sm">Brew Method</label>
			<select class="form-control input-sm" id="method" name="method" required >
				<option value="<?php echo $details['method']; ?>"><?php echo $details['method']; ?></option>
				<option value="BIAB">BIAB</option>
				<option value="Batch Sparge">Batch Sparge</option>
				<option value="Fly Sparge">Fly Sparge</option>
				<option value="No Sparge">No Sparge</option>
				<option value="Partial Mash">Partial Mash</option>
				<option value="Extract">Extract</option>
			</select>
		</div>

		<div class="col-xs-3 col-md-3">
			<label for="no_chill" class="label-sm">No Chill?</label>
			<select class="form-control input-sm" id="no_chill" name="no_chill" required>
				<option value="<?php echo $details['no_chill']; ?>"><?php echo $details['no_chill']; ?></option>
				<option value="True">True</option>
				<option value="False">False</option>
			</select>
		</div>

	</div>

	<div class="row margin-bottom-1em">

		<div class="col-xs-4 col-sm-4 col-md-2">
			<label for="mash_volume" class="label-sm">Mash Vol (L)</label>
			<input type="number" class="form-control input-sm" min="0" step=".1" id="mash_volume" name="mash_volume" value="<?php echo $details['mash_volume']; ?>" />
		</div>
		<div class="col-xs-4 col-sm-4 col-md-2">
			<label for="sparge_volume" class="label-sm">Sparge Vol (L)</label>
			<input type="number" class="form-control input-sm" min="0" step=".1" id="sparge_volume" name="sparge_volume" value="<?php echo $details['sparge_volume']; ?>" />
		</div>
		<div class="col-xs-4 col-sm-4 col-md-2">
			<label for="boil_size" class="label-sm">Boil Size (L)</label>
			<input type="number" class="form-control input-sm" min="0" step=".1" id="boil_size" name="boil_size" value="<?php echo $details['boil_size']; ?>" />
		</div>
		<div class="col-xs-4 col-sm-4 col-md-2">
			<label for="boil_time" class="label-sm">Boil Time</label>
			<input type="number" class="form-control input-sm" min="0" step="1" id="boil_time" name="boil_time" value="<?php echo $details['boil_time']; ?>" />
		</div>
		<div class="col-xs-4 col-sm-4 col-md-2">
			<label for="batch_size" class="label-sm">Batch Size (L)</label>
			<input type="number" class="form-control input-sm" min="0" step=".1" id="batch_size" name="batch_size" value="<?php echo $details['batch_size']; ?>" />
		</div>
		<div class="col-xs-4 col-sm-4 col-md-2">
			<label for="mash_efficiency" class="label-sm">Mash Eff (%)</label>
			<input type="number" class="form-control input-sm" min="0" step=".01" id="mash_efficiency" name="mash_efficiency" value="<?php echo $details['mash_efficiency']; ?>" />
		</div>

	</div>

	<div class="row">

		<div class="hidden-xs col-sm-3 col-md-3">
			<label for="brewer" class="label-sm">Brewer</label>
			<input type="text" class="form-control input-sm" id="brewer" name="brewer" value="<?php echo $details['brewer']; ?>" />
				<datalist id="brewer">
				<?php
				$query = "SELECT person_first_name, person_last_name FROM persons ORDER BY person_last_name";
				$result = mysqli_query($connection, $query);
				while ($row = mysqli_fetch_array ( $result ))
				{
					echo '<option value="' . $row['person_first_name'] . ' ' . $row['person_last_name'] .  '">';
				}
				?>
				</datalist>
		</div>

		<div class="col-xs-12 col-md-9">
			<label for="notes" class="label-sm">Brew Notes</label>
			<textarea class="form-control input-sm" rows=2 cols=100 id="notes" name="notes" value="<?php echo $details['notes']; ?>"></textarea>
		</div>

	</div>
</div>

</fieldset>

<fieldset class="col-xs-12 col-sm-5 col-md-4">

<div class="well">
<legend>Style Characteristics</legend>

	<div class="row">

		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">&nbsp;</label>
		</div>

		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">Low</label>
		</div>

		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">Estimate</label>
		</div>

		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">Actual</label>
		</div>

		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">High</label>
		</div>

	</div>

	<div class="row margin-bottom-qtr-em">

		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">OG</label>
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_og_min" name="style_og_min" readonly="yes" value="<?php echo $style['og_min']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="est_og" name="est_og" readonly="yes" value="<?php echo $details['est_og']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="number" class="form-control input-sm padding-5px" id="act_og" name="act_og" min="0" step="0.001" value="<?php echo $details['act_og']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_og_max" name="style_og_max" readonly="yes" value="<?php echo $style['og_max']; ?>" />
		</div>

	</div>

	<div class="row margin-bottom-qtr-em">

		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">FG</label>
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_fg_min" name="style_fg_min" readonly="yes" value="<?php echo $style['fg_min']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="est_fg" name="est_fg" readonly="yes" value="<?php echo $details['est_fg']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="number" class="form-control input-sm padding-5px" id="act_fg" name="act_fg" min="0" step="0.001" value="<?php echo $details['act_fg']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_fg_max" name="style_fg_max" readonly="yes" value="<?php echo $style['fg_max']; ?>" />
		</div>

	</div>

	<div class="row margin-bottom-qtr-em">

		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">ABV&nbsp;(%)</label>
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_abv_min" name="style_abv_min" readonly="yes" value="<?php echo $style['abv_min']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="est_abv" name="est_abv" readonly="yes" value="<?php echo $details['est_abv']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="number" class="form-control input-sm padding-5px" id="act_abv" name="act_abv" min="0" step="0.1" value="<?php echo $details['act_abv']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_abv_max" name="style_abv_max" readonly="yes" value="<?php echo $style['abv_max']; ?>" />
		</div>

	</div>

	<div class="row margin-bottom-qtr-em">

		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">IBU</label>
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_ibu_min" name="style_ibu_min" readonly="yes" value="<?php echo $style['ibu_min']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="est_ibu" name="est_ibu" readonly="yes" value="<?php echo $details['est_ibu']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_ibu_max" name="style_ibu_max" readonly="yes" value="<?php echo $style['ibu_max']; ?>" />
		</div>

	</div>

	<div class="row">

		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">Color&nbsp;(L)</label>
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_color_min" name="style_color_min" readonly="yes" value="<?php echo $style['color_min']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="est_color" name="est_color" readonly="yes" value="<?php echo $details['est_color']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_color_max" name="style_color_max" readonly="yes" value="<?php echo $style['color_max']; ?>" />
		</div>

	</div>

</div>

</fieldset>
</div>

<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#fermentables">Fermentables</a></li>
	<li><a data-toggle="tab" href="#hops">Hops</a></li>
	<li><a data-toggle="tab" href="#yeast">Yeast</a></li>
	<li><a data-toggle="tab" href="#misc">Miscellaneous</a></li>
	<li><a data-toggle="tab" href="#mash">Mash Details</a></li>
	<li><a data-toggle="tab" href="#fermentation">Fermentation Details</a></li>
	<li><a data-toggle="tab" href="#packaging">Packaging</a></li>
</ul>

<div class="tab-content">

<div class="row tab-pane fade in active" id="fermentables">
<fieldset class="fieldset col-xs-12 col-md-12 five-ingredients">

	<div class="row">

		<div class="col-xs-6 col-sm-2 col-md-3">
			<label class="label-sm">Fermentable</label>
		</div>

		<div class="col-xs-3 col-sm-2 col-md-1">
			<label class="label-sm">Amount&nbsp;(kg)</label>
		</div>

		<div class="hidden-xs col-sm-2 col-md-1">
			<label class="label-sm">Percentage</label>
		</div>

		<div class="hidden-xs col-sm-2 col-md-1">
			<label class="label-sm">Yield (%)</label>
		</div>

		<div class="hidden-xs col-sm-2 col-md-1">
			<label class="label-sm">Color (L)</label>
		</div>

		<div class="col-xs-3 col-sm-2 col-md-1">
			<label class="label-sm">Type</label>
		</div>

		<div class="col-xs-3 col-sm-2 col-md-2">
			<label class="label-sm">Use</label>
		</div>

	</div>

	<?php
	$ingredient = "'fermentable'";
	for ($i=0; $i<=14; $i++)
	{
		echo '<div class="row margin-bottom-qtr-em">';

		echo '<div class="col-xs-6 col-sm-2 col-md-3">';
		echo '<select class="form-control input-sm" name="fermentable' . $i . '_name" onchange="getfermentableinfo(this.value,' .$i. '); set_flag(' . $ingredient . ', ' . $i . ');">';
		echo '<option value="' . $fermentables[$i]['name'] . '">' . $fermentables[$i]['name'] . '</option>';
		$query = "SELECT fermentable_name FROM fermentables ORDER BY fermentable_name";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		while ($row = mysqli_fetch_array ( $result ))
		{
			echo '<option value="' . $row['fermentable_name'] . '">' . $row['fermentable_name'] . '</option>';
		}
		echo '</select>';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="0" step="0.001" name="fermentable' . $i . '_amount" value="' . $fermentables[$i]['amount'] . '" onchange="calc_og_color_ibu(); set_flag(' . $ingredient . ', ' . $i . ');" />';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" name="fermentable' . $i . '_percent" readonly="yes" value="' . $fermentables[$i]['percent'] . '" />';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-1">';
		echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_yield" readonly="yes" value="' . $fermentables[$i]['yield'] . '" />';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-1">';
		echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_color" readonly="yes" value="' . $fermentables[$i]['color'] . '" />';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_type" readonly="yes" value="' . $fermentables[$i]['type'] . '" />';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-2">';
		echo '<select class="form-control input-sm" name="fermentable' . $i . '_use" onchange="set_flag(' . $ingredient . ', ' . $i . ')">';
		echo '<option value="' . $fermentables[$i]['use'] . '">' . $fermentables[$i]['use'] . '</option>';
		echo '<option value="Mashed">Mashed</option>';
		echo '<option value="Steeped">Steeped</option>';
		echo '<option value="Extract">Extract</option>';
		echo '<option value="Sugar">Sugar</option>';
		echo '<option value="Other">Other</option>';
		echo '</select>';
		echo '</div>';

		// the brews_fermentables record id
		echo '<input type="hidden" name="fermentable' . $i . '_record_id" value="'.  $fermentables[$i]['record_id'] . '"/>';
		// the fermentable id
		echo '<input type="hidden" name="fermentable' . $i . '_id" value="' . $fermentables[$i]['id'] . '"/>';
		// the update flag
		echo '<input type="hidden" name="fermentable' . $i . '_flag" value="' . $fermentables[$i]['flag'] . '"/>';

		echo '</div>';
	}
	?>

</fieldset>
</div>

<div class="row tab-pane fade" id="hops">
<fieldset class="fieldset col-xs-12 col-md-12 five-ingredients">

	<div class="row">

		<div class="col-xs-6 col-sm-2 col-md-3">
			<label class="label-sm">Hop</label>
		</div>

		<div class="col-xs-3 col-sm-2 col-md-1">
			<label class="label-sm">Amount&nbsp;(g)</label>
		</div>

		<div class="hidden-xs col-sm-2 col-md-1">
			<label class="label-sm">Alpha (%)</label>
		</div>

		<div class="col-xs-3 col-sm-2 col-md-1">
			<label class="label-sm">Time (min)</label>
		</div>

		<div class="hidden-xs col-sm-2 col-md-2">
			<label class="label-sm">Form</label>
		</div>

		<div class="hidden-xs col-sm-2 col-md-2">
			<label class="label-sm">Use</label>
		</div>

	</div>

	<?php
	$ingredient = "'hop'";
	for ($i=0; $i<=14; $i++)
	{
		echo '<div class="row margin-bottom-qtr-em">';
		echo '<div class="col-xs-6 col-sm-2 col-md-3">';
		echo '<select class="form-control input-sm" name="hop' . $i . '_name" onchange="gethopinfo(this.value,' .$i. '); set_flag(' . $ingredient . ', ' . $i . ');">';
		echo '<option value="' . $hops[$i]['name'] . '">' . $hops[$i]['name'] . '</option>';
		$query = "SELECT hop_name FROM hops ORDER BY hop_name";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		while ($row = mysqli_fetch_array ( $result ))
		{
			echo '<option value="' . $row['hop_name'] . '">' . $row['hop_name'] . '</option>';
		}
		echo '</select>';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="0" step="any" name="hop' . $i . '_amount" onchange="hops_messages(' .$i. '); calc_ibu(); set_flag(' . $ingredient . ', ' . $i . ');" value="'; echo $hops[$i]['amount']; echo '"/>';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="0" step="0.1" name="hop' . $i . '_alpha" onchange="hops_messages(' .$i. '); calc_ibu(); set_flag(' . $ingredient . ', ' . $i . ');" value="'; echo $hops[$i]['alpha']; echo '"/>';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="0" step="1" name="hop' . $i . '_time" onchange="hops_messages(' .$i. '); calc_ibu(); set_flag(' . $ingredient . ', ' . $i . ');" value="'; echo $hops[$i]['time']; echo '"/>';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-2">';
		echo '<select class="form-control input-sm" name="hop' . $i . '_form" onchange="set_flag(' . $ingredient . ', ' . $i . ')">';
		echo '<option value="' . $hops[$i]['form'] . '">' . $hops[$i]['form'] . '</option>';
		echo '<option value="Pellet">Pellet</option>';
		echo '<option value="Plug">Plug</option>';
		echo '<option value="Whole">Whole</option>';
		echo '</select>';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-2">';
		echo '<select class="form-control input-sm" name="hop' . $i . '_use" onchange="set_flag(' . $ingredient . ', ' . $i . ')">';
		echo '<option value="' . $hops[$i]['use'] . '">' . $hops[$i]['use'] . '</option>';
		echo '<option value="Aroma">Aroma</option>';
		echo '<option value="Boil">Boil</option>';
		echo '<option value="Dry Hop">Dry Hop</option>';
		echo '<option value="First Wort">First Wort</option>';
		echo '<option value="Mash">Mash</option>';
		echo '</select>';
		echo '</div>';

		// the brews_hops record id
		echo '<input type="hidden" name="hop' . $i . '_record_id" value="'; echo $hops[$i]['record_id']; echo '"/>';
		// the hops id
		echo '<input type="hidden" name="hop' . $i . '_id" value="'; echo $hops[$i]['id']; echo '"/>';
		// the update flag
		echo '<input type="hidden" name="hop' . $i . '_flag" value="'; echo $hops[$i]['flag']; echo '"/>';

		echo '</div>';
	}
	?>

</fieldset>
</div>

<div class="row tab-pane fade" id="yeast">
<fieldset class="fieldset col-xs-12 col-md-12">

	<div class="row">

		<div class="col-xs-6 col-sm-3 col-md-3">
			<label class="label-sm">Yeast</label>
		</div>

		<div class="col-xs-3 col-sm-3 col-md-2">
			<label class="label-sm">Type</label>
		</div>

		<div class="col-xs-3 col-sm-3 col-md-2">
			<label class="label-sm">Form</label>
		</div>

		<div class="col-xs-3 col-sm-3 col-md-2">
			<label class="label-sm">Attenuation (%)</label>
		</div>

		<div class="col-xs-3 col-sm-3 col-md-2">
			<label class="label-sm">Flocculation</label>
		</div>

	</div>

	<?php
	$ingredient = "'yeast'";
	for ($i=0; $i<=0; $i++)
	{
		echo '<div class="row margin-bottom-qtr-em">';
		echo '<div class="col-xs-6 col-sm-3 col-md-3">';
		echo '<select class="form-control input-sm" name="yeast' . $i . '_fullname" onchange="getyeastinfo(this.value,' .$i. '); set_flag(' . $ingredient . ', ' . $i . ');">';
		echo '<option value="' . $yeasts[$i]['fullname'] . '">' . $yeasts[$i]['fullname'] . '</option>';
		$query = "SELECT yeast_fullname FROM yeasts ORDER BY yeast_fullname";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		while ($row = mysqli_fetch_array ( $result ))
		{
			echo '<option value="' . $row['yeast_fullname'] . '">' . $row['yeast_fullname'] . '</option>';
		}
		echo '</select>';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-3 col-md-2">';
		echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_type" readonly="yes" value="'; echo $yeasts[$i]['type']; echo '"/>';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-3 col-md-2">';
		echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_form" readonly="yes" value="'; echo $yeasts[$i]['form']; echo '"/>';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-3 col-md-2">';
		echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_attenuation" readonly="yes" value="'; echo $yeasts[$i]['attenuation']; echo '"/>';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-3 col-md-2">';
		echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_flocculation" readonly="yes" value="'; echo $yeasts[$i]['flocculation']; echo '"/>';
		echo '</div>';

		// the brews_yeasts record id
		echo '<input type="hidden" name="yeast' . $i . '_record_id" value="'; echo $yeasts[$i]['record_id']; echo '"/>';
		// the yeast id
		echo '<input type="hidden" name="yeast' . $i . '_id" value="'; echo $yeasts[$i]['id']; echo '"/>';
		// the update flag
		echo '<input type="hidden" name="yeast' . $i . '_flag" value="'; echo $yeasts[$i]['flag']; echo '"/>';

		echo '</div>';
	}
	?>

</fieldset>
</div>

<div class="row tab-pane fade" id="misc">
<fieldset class="fieldset col-xs-12 col-md-12 five-ingredients">

	<div class="row">

		<div class="col-xs-6 col-sm-2 col-md-3">
			<label class="label-sm">Ingredient</label>
		</div>

		<div class="hidden-xs col-sm-2 col-md-2">
			<label class="label-sm">Type</label>
		</div>

		<div class="col-xs-3 col-sm-2 col-md-1">
			<label class="label-sm">Amount</label>
		</div>

		<div class="col-xs-3 col-sm-2 col-md-1">
			<label class="label-sm">Unit</label>
		</div>

		<div class="hidden-xs col-sm-2 col-md-2">
			<label class="label-sm">Use</label>
		</div>

	</div>

	<?php
	$ingredient = "'misc'";
	for ($i=0; $i<=14; $i++)
	{
		echo '<div class="row margin-bottom-qtr-em">';

		echo '<div class="col-xs-6 col-sm-2 col-md-3">';
		echo '<select class="form-control input-sm" name="misc' . $i . '_name" onchange="getmiscinfo(this.value,' .$i. '); set_flag(' . $ingredient . ', ' . $i . ');">';
		echo '<option value="' . $miscs[$i]['name'] . '">' . $miscs[$i]['name'] . '</option>';
        $query = "SELECT misc_name FROM miscs ORDER BY misc_name";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		while ($row = mysqli_fetch_array ( $result ))
		{
			echo '<option value="' . $row['misc_name'] . '">' . $row['misc_name'] . '</option>';
		}
		echo '</select>';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-2">';
		echo '<input type="text" class="form-control input-sm" name="misc' . $i . '_type" readonly="yes" value="'; echo $miscs[$i]['type']; echo '"/> ';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="0" step="0.1" name="misc' . $i . '_amount" onchange="miscs_messages(' .$i. '); set_flag(' . $ingredient . ', ' . $i . ')" value="'; echo $miscs[$i]['amount']; echo '"/> ';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="text" class="form-control input-sm" name="misc' . $i . '_unit" onchange="miscs_messages(' .$i. '); set_flag(' . $ingredient . ', ' . $i . ')" value="'; echo $miscs[$i]['unit']; echo '"/> ';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-2">';
		echo '<select class="form-control input-sm" name="misc' . $i . '_use" onchange="miscs_messages(' .$i. '); set_flag(' . $ingredient . ', ' . $i . ')"'; echo '"> ';
		echo '<option value="' . $miscs[$i]['use'] . '">' . $miscs[$i]['use'] . '</option>';
		echo '<option value="Boil">Boil</option>';
		echo '<option value="Mash">Mash</option>';
		echo '<option value="Primary">Primary</option>';
		echo '<option value="Secondary">Secondary</option>';
		echo '<option value="Bottling">Bottling</option>';
		echo '</select>';
		echo '</div>';

		// the brews_miscs record id
		echo '<input type="hidden" name="misc' . $i . '_record_id" value="'; echo $miscs[$i]['record_id']; echo '"/> ';
		// the miscs id
		echo '<input type="hidden" name="misc' . $i . '_id" value="'; echo $miscs[$i]['id']; echo '"/> ';
		// the update flag
		echo '<input type="hidden" name="misc' . $i . '_flag" value="'; echo $miscs[$i]['flag']; echo '"/> ';

		echo '</div>';
	}
	?>

</fieldset>
</div>

<div class="row tab-pane fade" id="mash">
<fieldset class="fieldset col-xs-12 col-md-12 five-ingredients">

	<div class="row">

		<div class="col-xs-3 col-sm-2 col-md-1">
			<label class="label-sm">Temp&nbsp;(&deg;C)</label>
		</div>

		<div class="col-xs-3 col-sm-2 col-md-1">
			<label class="label-sm">Time</label>
		</div>

	</div>

	<?php
	$ingredient = "'mash'";
	for ($i=0; $i<=4; $i++)
	{
		if ($mashes[$i]['temp'] || $mashes[$i]['time'])
		{
			echo '<div class="row margin-bottom-qtr-em">';

			echo '<div class="col-xs-3 col-sm-2 col-md-1">';
			echo '<input type="number" class="form-control input-sm" name="mash' . $i . '_temp" value="' . $mashes[$i]['temp'] . '" onchange="set_flag(' . $ingredient . ', ' . $i . ')" /> ';
			echo '</div>';

			echo '<div class="hidden-xs col-sm-2 col-md-1">';
			echo '<input type="number" class="form-control input-sm" name="mash' . $i . '_time" value="' . $mashes[$i]['time'] . '" onchange="set_flag(' . $ingredient . ', ' . $i . ')" /> ';
			echo '</div>';

			// the brews_mashes record_id
			echo '<input type="hidden" name="mash' . $i . '_record_id" value="' . $mashes[$i]['record_id'] . '"/> ';
			// the update flag
			echo '<input type="hidden" name="mash' . $i . '_flag" value="' . $mashes[$i]['flag'] . '"/>';

			echo '</div>';
		}
	}
	?>

</fieldset>
</div>

<div class="row tab-pane fade" id="fermentation">
<fieldset class="fieldset col-xs-12 col-md-12 five-ingredients">

	<div class="row">

		<div class="col-xs-3 col-sm-2 col-md-2">
			<label class="label-sm">Start Date (yyyy-mm-dd)</label>
		</div>

		<div class="col-xs-3 col-sm-2 col-md-2">
			<label class="label-sm">End Date (yyyy-mm-dd)</label>
		</div>

		<div class="col-xs-3 col-sm-2 col-md-1">
			<label class="label-sm">Temp&nbsp;(&deg;C)</label>
		</div>

		<div class="col-xs-3 col-sm-2 col-md-1">
			<label class="label-sm">Final SG</label>
		</div>

	</div>

	<?php
	$ingredient = "'fermentation'";
	for ($i=0; $i<=4; $i++)
	{
		if ($fermentations[$i]['start_date'] || $fermentations[$i]['end_date'] || $fermentations[$i]['temp'] || $fermentations[$i]['measured_sg'])
		{
			echo '<div class="row margin-bottom-qtr-em">';

			echo '<div class="col-xs-3 col-sm-2 col-md-2">';
			echo '<input type="date" class="form-control input-sm" name="fermentation' . $i . '_start_date" value="' . $fermentations[$i]['start_date'] . '" onchange="set_flag(' . $ingredient . ', ' . $i . ')" /> ';
			echo '</div>';

			echo '<div class="hidden-xs col-sm-2 col-md-2">';
			echo '<input type="date" class="form-control input-sm" name="fermentation' . $i . '_end_date" value="' . $fermentations[$i]['end_date'] . '" onchange="set_flag(' . $ingredient . ', ' . $i . ')" /> ';
			echo '</div>';

			echo '<div class="hidden-xs col-sm-2 col-md-1">';
			echo '<input type="number" class="form-control input-sm" min="0" step="0.1" name="fermentation' . $i . '_temp" value="' . $fermentations[$i]['temp'] . '" onchange="set_flag(' . $ingredient . ', ' . $i . ')" /> ';
			echo '</div>';

			echo '<div class="hidden-xs col-sm-2 col-md-1">';
			echo '<input type="number" class="form-control input-sm" name="fermentation' . $i . '_measured_sg" min="0" step="0.001" value="' . $fermentations[$i]['measured_sg'] . '" onchange="set_flag(' . $ingredient . ', ' . $i . ')" /> ';
			echo '</div>';

			// the brews_fermentations record_id
			echo '<input type="hidden" name="fermentation' . $i . '_record_id" value="' . $fermentations[$i]['record_id'] . '"/> ';
			// the update flag
			echo '<input type="hidden" name="fermentation' . $i . '_flag" value="' . $fermentations[$i]['flag'] . '"/>';

			echo '</div>';
		}
	}
	?>

</fieldset>
</div>

<div class="row tab-pane fade" id="packaging">
<fieldset class="fieldset col-xs-12 col-md-12">

	<div class="row">

		<div class="col-xs-6 col-sm-3 col-md-2">
			<label class="label-sm">Bottle or Keg</label>
		</div>

		<div class="col-xs-3 col-sm-3 col-md-2">
			<label class="label-sm">Date (yyyy-mm-dd)</label>
		</div>

		<div class="col-xs-3 col-sm-3 col-md-1">
			<label class="label-sm">Vol CO2</label>
		</div>

	</div>

	<?php
	$ingredient = "'packaging'";

	echo '<div class="row margin-bottom-qtr-em">';

	echo '<div class="col-xs-3 col-sm-2 col-md-2">';
	echo '<select class="form-control input-sm" name="packaging" >';
	echo '<option value="' . $details['packaging'] . '">' . $details['packaging'] . '</option>';
	echo '<option value="Bottle">Bottle</option>';
	echo '<option value="Keg">Keg</option>';
	echo '</select>';
	echo '</div>';

	echo '<div class="col-xs-3 col-sm-3 col-md-2">';
	echo '<input type="date" class="form-control input-sm" name="packaging_date" value="' . $details['packaging_date'] . '" />';
	echo '</div>';

	echo '<div class="col-xs-3 col-sm-3 col-md-2">';
	echo '<input type="number" class="form-control input-sm" min="0" step=".1" name="vol_co2" value="' . $details['vol_co2'] . '" />';
	echo '</div>';

	echo '</div>';
	?>

</fieldset>
</div>

</div>

<button type="submit" class="btn btn-default">Save</button>

</form>

</div>

<?php
include ('includes/footer.html');
?>
