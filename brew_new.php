<?php

/*
brew_new.php
Create a brew, either from scratch or from a recipe, in the database
*/

$page_title = 'New Brew';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$details['name'] = mysqli_real_escape_string($connection, test_input($_POST['name']));

	// query the database to retrieve the style_id for the style
	$details['style'] = mysqli_real_escape_string($connection, test_input($_POST['style']));
	$query = "SELECT style_id FROM styles WHERE style_name='" . $details['style'] . "'";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	while ($row = mysqli_fetch_array ( $result ))
	{
		$details['style_id'] = $row['style_id'];
	}

	// retrieve the basic brew details
	$details['type'] = mysqli_real_escape_string($connection, test_input($_POST['type']));

	//query the database to retireve the recipe_id for the base recipe
	$details['base_recipe'] = mysqli_real_escape_string($connection, test_input($_POST['base_recipe']));
	$query = "SELECT recipe_id FROM recipes WHERE recipe_name='" . $details['base_recipe'] . "'";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	while ($row = mysqli_fetch_array ( $result ))
	{
		$details['recipe_id'] = $row['recipe_id'];
	}

	$details['batch_number'] = mysqli_real_escape_string($connection, test_input($_POST['batch_number']));

	$details['date'] = mysqli_real_escape_string($connection, test_input($_POST['date']));
	if (!$details['date'])
	{
		$details['date'] = "0000-00-00";
	}
	$details['brew_method'] = mysqli_real_escape_string($connection, test_input($_POST['brew_method']));
	$details['no_chill'] = mysqli_real_escape_string($connection, test_input($_POST['no_chill']));

	$details['mash_type'] = mysqli_real_escape_string($connection, test_input($_POST['mash_type']));
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
	}

	// retrieve the brew yeasts
	$yeasts[0]['id'] = mysqli_real_escape_string($connection, test_input($_POST['yeast0_id']));
	$yeasts[0]['fullname'] = mysqli_real_escape_string($connection, test_input($_POST['yeast0_fullname']));

	// retrieve the brew misc ingredients
	for ($i=0; $i<=4; $i++)
	{
		$miscs[$i]['id'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_id']));
		$miscs[$i]['name'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_name']));
		$miscs[$i]['amount'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_amount']));
		$miscs[$i]['unit'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_unit']));
		$miscs[$i]['type'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_type']));
		$miscs[$i]['use'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_use']));
	}

	// retrieve the brew mash details
	for ($i=0; $i<=4; $i++)
	{
		$mashes[$i]['temp'] = mysqli_real_escape_string($connection, test_input($_POST['mash' . $i . '_temp']));
		if (!$mashes['temp'])
		{
			$mashes['temp'] = "NULL";
		}

		$mashes[$i]['time'] = mysqli_real_escape_string($connection, test_input($_POST['mash' . $i . '_time']));
		if (!$mashes['time'])
		{
			$mashes['time'] = "NULL";
		}
	}

	// retrieve the brew fermentation details
	for ($i=0; $i<=4; $i++)
	{
		$fermentations[$i]['start_date'] = mysqli_real_escape_string($connection, test_input($_POST['fermentation' . $i . '_start_date']));
		if (!$fermentations['start_date'])
		{
			$fermentations['start_date'] = "NULL";
		}

		$fermentations[$i]['end_date'] = mysqli_real_escape_string($connection, test_input($_POST['fermentation' . $i . '_end_date']));
		if (!$fermentations['end_date'])
		{
			$fermentations['end_date'] = "NULL";
		}

		$fermentations[$i]['temp'] = mysqli_real_escape_string($connection, test_input($_POST['fermentation' . $i . '_temp']));
		if (!$fermentations['temp'])
		{
			$fermentations['temp'] = "NULL";
		}

		$fermentations[$i]['measured_sg'] = mysqli_real_escape_string($connection, test_input($_POST['fermentation' . $i . '_measured_sg']));
		if (!$fermentations['measured_sg'])
		{
			$fermentations['measured_sg'] = "NULL";
		}
	}

	// retrieve the brew packaging details
	$details['packaging'] = mysqli_real_escape_string($connection, test_input($_POST['packaging']));
	$details['packaging_date'] = mysqli_real_escape_string($connection, test_input($_POST['packaging_date']));
	if (!$details['packaging_date'])
	{
		$details['packaging_date'] = "NULL";
	}

	$details['vol_co2'] = mysqli_real_escape_string($connection, test_input($_POST['vol_co2']));
	if (!$details['vol_co2'])
	{
		$details['vol_co2'] = "NULL";
	}


	// now insert the records into the database

	// insert the brew record
	$insert = "INSERT INTO brews (brew_name, brew_batch_number, brew_date, brew_recipe_id, brew_type, brew_style_id, brew_method, brew_no_chill, brew_mash_volume, brew_sparge_volume, brew_boil_size, brew_boil_time, brew_batch_size, brew_mash_efficiency, brew_brewer, brew_notes, brew_est_og, brew_act_og, brew_est_fg, brew_act_fg, brew_est_color, brew_est_ibu, brew_est_abv, brew_act_abv, brew_packaging, brew_packaging_vol_co2, brew_packaging_date)";
	$values = "VALUES ('" . $details['name'] . "'," . $details['batch_number'] . ",'" . $details['date'] . "'," . $details['recipe_id'] . ",'" . $details['type'] . "'," . $details['style_id'] . ",'" . $details['brew_method'] . "','" . $details['no_chill'] . "'," . $details['mash_volume'] . "," . $details['sparge_volume'] . "," . $details['boil_size'] . "," . $details['boil_time'] . "," . $details['batch_size'] . "," . $details['mash_efficiency'] . ",'" . $details['brewer'] . "','" . $details['notes'] . "'," . $details['est_og'] . "," . $details['act_og'] . "," . $details['est_fg'] . "," . $details['act_fg'] . "," . $details['est_color'] . "," . $details['est_ibu'] . "," . $details['est_abv'] . "," . $details['act_abv'] . ",'" . $details['packaging'] . "'," . $details['vol_co2'] . ",'" . $details['packaging_date'] . "')";
	$query = $insert . " " . $values;
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

	// retrieve the id of the last insert as the brew_id for the brews_fermentables, brews_hops, brews_yeasts, brews_miscs, brews_mashes, and brews_ferments records
	$brew_id = mysqli_insert_id($connection);

	// for each fermentable, retrieve the fermentable id and insert the brew_fermentable records
	for ($i=0; $i <=14; $i++)
	{
		if ($fermentables[$i]['name'] && $fermentables[$i]['amount'] > 0)
		{
			$query = "INSERT INTO brews_fermentables (brew_fermentable_brew_id, brew_fermentable_fermentable_id, brew_fermentable_amount, brew_fermentable_use)
					VALUES (" . $brew_id . "," . $fermentables[$i]['id'] . "," . $fermentables[$i]['amount'] . ",'" . $fermentables[$i]['use'] . "')";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

	// for each hop, retrieve the hop id and insert the brew_hop records
	for ($i=0; $i <=14; $i++)
	{
		if ($hops[$i]['name'] && $hops[$i]['amount'] > 0)
		{
			$query = "INSERT INTO brews_hops (brew_hop_brew_id, brew_hop_hop_id, brew_hop_amount, brew_hop_alpha, brew_hop_use, brew_hop_time, brew_hop_form)
					VALUES (" . $brew_id . "," . $hops[$i]['id'] . "," . $hops[$i]['amount'] . "," . $hops[$i]['alpha'] . ",'" . $hops[$i]['use'] . "'," . $hops[$i]['time'] . ",'" . $hops[$i]['form'] . "')";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

	// for each yeast, retrieve the yeast id and insert the brew_yeast records
	for ($i=0; $i <=0; $i++)
	{
		if ($yeasts[$i]['fullname'])
		{
			$query = "INSERT INTO brews_yeasts (brew_yeast_brew_id, brew_yeast_yeast_id)
					VALUES (" . $brew_id . "," . $yeasts[$i]['id'] . ")";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

	// for each misc, retrieve the misc id and insert the brew_misc records
	for ($i=0; $i <=4; $i++)
	{
		if ($miscs[$i]['name'] && $miscs[$i]['amount'] > 0)
		{
			$query = "INSERT INTO brews_miscs (brew_misc_brew_id, brew_misc_misc_id, brew_misc_amount, brew_misc_unit, brew_misc_use)
					VALUES (" . $brew_id . "," . $miscs[$i]['id'] . "," . $miscs[$i]['amount'] . ",'" . $miscs[$i]['unit'] . "','" . $miscs[$i]['use'] . "')";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

	// for each mash, insert the brew_mash records
	for ($i=0; $i <=4; $i++)
	{
		if ($mashes[$i]['temp'] || $mashes[$i]['time'])
		{
			$query = "INSERT INTO brews_mashes (brew_mash_brew_id, brew_mash_temp, brew_mash_time)
					VALUES (" . $brew_id . "," . $mashes[$i]['temp'] . "," . $mashes[$i]['time'] . ")";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

	// for each fermentation, insert the brew_fermentation records
	for ($i=0; $i <=4; $i++)
	{
		if ($fermentations[$i]['start_date'] || $fermentations[$i]['end_date'] || $fermentations[$i]['temp'] || $fermentations[$i]['measured_sg'])
		{
			$query = "INSERT INTO brews_fermentations (brew_fermentation_brew_id, brew_fermentation_start_date, brew_fermentation_end_date, brew_fermentation_temp, brew_fermentation_measured_sg)
					VALUES (" . $brew_id . ",'" . $fermentations[$i]['start_date'] . "','" . $fermentations[$i]['end_date'] . "'," . $fermentations[$i]['temp'] . "," . $fermentations[$i]['measured_sg'] . ")";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

    // After saving to the database, redirect back to the new brew page
	echo '<script type="text/javascript">
	window.location = "brew_new.php"
	</script>';
}

// not a form submission, so retrieve the recipe details
// check that the 'id' variable is set in URL and it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
// get the recipe details
include('includes/get_recipe_details.php');
}

// end of PHP section, now create the HTML form
?>

<div class="container">

<h2>New Brew</h2>

<form role="form" class="form-horizontal" name="brewform" action="brew_new.php" method="post">

<div class="row">

<fieldset class="col-xs-12 col-sm-6 col-md-8">

<div class="well">
<legend>Brew Details</legend>

	<div class="row margin-bottom-1em">

		<div class="col-xs-4 col-md-3">
			<label for="name" class="label-sm">Brew Name</label>
			<input type="text" class="form-control input-sm" id="name" name="name" required value="<?php echo $details['name']; ?>" />
		</div>

		<div class="col-xs-4 col-md-3">
			<label for="base_recipe" class="label-sm">Base Recipe</label>
			<select class="form-control input-sm" id="base_recipe" name="base_recipe" onchange="getrecipeinfo(this.value);" >
				<option value="<?php echo $details['name']; ?>" selected>Select a base recipe...</option>
				<?php
				if (isset($_GET['id']))
				{
					echo '<option value="' . $details['name'] . '" selected>' . $details['name'] . '</option>';
				}
				else
				{
					echo '<option value="" selected>Select a base recipe...</option>';
				}
				$query = "SELECT recipe_name FROM recipes ORDER BY recipe_date DESC";
				$result = mysqli_query($connection, $query);
				while ($row = mysqli_fetch_array ( $result ))
				{
					echo '<option>' . $row['recipe_name'] . '</option>';
				}
				?>
			</select>
		</div>

		<div class="col-xs-4 col-md-3">
			<label for="style" class="label-sm">Style</label>
			<input class="form-control input-sm" id="style" name="style" readonly="yes" value="<?php echo $style['name']; ?>"/>
		</div>

		<div class="col-xs-4 col-md-3">
			<label for="type" class="label-sm">Type</label>
			<input class="form-control input-sm" id="type" name="type" readonly="yes" value="<?php echo $details['type']; ?>"/>
		</div>

	</div>

	<div class="row margin-bottom-1em">

		<?php
		$brew_batch_num = 0;
		$query = "SELECT brew_batch_number FROM brews ORDER BY brew_id DESC LIMIT 1";
		$result = mysqli_query($connection, $query);
		while ($row = mysqli_fetch_array ( $result ))
		{
			$brew_batch_number = $row['brew_batch_number'];
		}
		$brew_batch_number += 1;
		?>
		<div class="col-xs-2 col-md-2">
			<label for="batch_number" class="label-sm">Batch Number</label>
			<input type="text" class="form-control input-sm" id="batch_number" name="batch_number" required value="<?php echo $brew_batch_number; ?>"/>
		</div>

		<div class="col-xs-5 col-sm-4 col-md-3">
			<label for="date" class="label-sm">Date (yyyy-mm-dd)</label>
			<input type="date" class="form-control input-sm" id="date" name="date" value="<?php echo date("Y-m-d"); ?>"/>
		</div>

		<div class="col-xs-3 col-md-4">
			<label for="brew_method" class="label-sm">Brew Method</label>
			<select class="form-control input-sm" id="brew_method" name="brew_method" required >
				<option value="" disabled selected>Select a brew method...</option>
				<option>BIAB</option>
				<option>Batch Sparge</option>
				<option>Fly Sparge</option>
				<option>No Sparge</option>
				<option>Partial Mash</option>
				<option>Extract</option>
			</select>
		</div>

		<div class="col-xs-3 col-md-3">
			<label for="no_chill" class="label-sm">No Chill?</label>
			<select class="form-control input-sm" id="no_chill" name="no_chill" required>
				<option value="" disabled selected>True or False...</option>
				<option>True</option>
				<option>False</option>
			</select>
		</div>

	</div>

	<div class="row margin-bottom-1em">

		<?php
		$query = "SELECT preference_mash_volume, preference_sparge_volume, preference_boil_size, preference_boil_time, preference_evaporation_rate, preference_batch_size, preference_mash_efficiency FROM preferences";
		$result = mysqli_query($connection, $query);
		while ($row = mysqli_fetch_array ( $result ))
		{
			echo '<div class="col-xs-4 col-sm-4 col-md-2">';
				echo '<label for="mash_volume" class="label-sm">Mash Vol (L)</label>';
				echo '<input type="number" class="form-control input-sm" min="0" step=".1" id="mash_volume" name="mash_volume" value="' . $row['preference_mash_volume'] . '"/>';
			echo '</div>';
			echo '<div class="col-xs-4 col-sm-4 col-md-2">';
				echo '<label for="sparge_volume" class="label-sm">Sparge Vol (L)</label>';
				echo '<input type="number" class="form-control input-sm" min="0" step=".1" id="sparge_volume" name="sparge_volume" value="' . $row['preference_sparge_volume'] . '"/>';
			echo '</div>';
			echo '<div class="col-xs-4 col-sm-4 col-md-2">';
				echo '<label for="boil_size" class="label-sm">Boil Size (L)</label>';
				echo '<input type="number" class="form-control input-sm" min="0" step=".1" id="boil_size" name="boil_size" required onchange="calc_og_color_ibu();" value="' . $row['preference_boil_size'] . '"/>';
			echo '</div>';
			echo '<div class="col-xs-4 col-sm-4 col-md-2">';
				echo '<label for="boil_time" class="label-sm">Boil Time</label>';
				echo '<input type="number" class="form-control input-sm" min="0" step="1" id="boil_time" name="boil_time" required onchange="calc_og_color_ibu();" value="' . $row['preference_boil_time'] . '"/>';
			echo '</div>';
			echo '<div class="col-xs-4 col-sm-4 col-md-2">';
				echo '<label for="batch_size" class="label-sm">Batch Size (L)</label>';
				echo '<input type="number" class="form-control input-sm" min="0" step=".1" id="batch_size" name="batch_size" required onchange="calc_og_color_ibu();" value="' . $row['preference_batch_size'] . '"/>';
			echo '</div>';
			echo '<div class="col-xs-4 col-sm-4 col-md-2">';
				echo '<label for="mash_efficiency" class="label-sm">Mash Eff (%)</label>';
				echo '<input type="number" class="form-control input-sm" min="0" step=".01" id="mash_efficiency" name="mash_efficiency" required onchange="calc_og_color_ibu();" value="' . $row['preference_mash_efficiency'] . '"/>';
			echo '</div>';
		}
		?>

	</div>

	<div class="row">

		<div class="hidden-xs col-sm-3 col-md-3">
			<label for="brewer" class="label-sm">Brewer</label>
			<input list="persons" class="form-control input-sm" id="brewer" name="brewer" />
				<datalist id="persons">
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
			<textarea class="form-control input-sm" rows=2 cols=100 id="notes" name="notes"></textarea>
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
			<input type="text" class="form-control input-sm padding-5px" id="act_og" name="act_og"  />
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
			<input type="text" class="form-control input-sm padding-5px" id="act_fg" name="act_fg" />
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
			<input type="text" class="form-control input-sm padding-5px" id="act_abv" name="act_abv" />
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
		echo '<select class="form-control input-sm" name="fermentable' . $i . '_name" onchange="getfermentableinfo(this.value,' .$i. ');">';
		echo '<option>'; echo $fermentables[$i]['name']; echo '</option>';
		$query = "SELECT fermentable_name FROM fermentables ORDER BY fermentable_name";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		while ($row = mysqli_fetch_array ( $result ))
		{
			echo '<option>' . $row['fermentable_name'] . '</option>';
		}
		echo '</select>';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="0" step="0.001" name="fermentable' . $i . '_amount" value="' . $fermentables[$i]['amount'] . '" onchange="fermentables_messages(' .$i. '); calc_og_color_ibu(); set_flag(' . $ingredient . ', ' . $i . ');"' . '"/>';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" name="fermentable' . $i . '_percent" value="' . $fermentables[$i]['percent'] . '" readonly="yes" />';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-1">';
		echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_yield" value="' . $fermentables[$i]['yield'] . '" readonly="yes" />';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-1">';
		echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_color" value="' . $fermentables[$i]['color'] . '" readonly="yes" />';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_type" value="' . $fermentables[$i]['type'] . '" readonly="yes" />';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-2">';
		echo '<select class="form-control input-sm" name="fermentable' . $i . '_use" >';
		echo '<option>'; echo $fermentables[$i]['use']; echo '</option>';
		echo '<option>Mashed</option>';
		echo '<option>Steeped</option>';
		echo '<option>Extract</option>';
		echo '<option>Sugar</option>';
		echo '<option>Other</option>';
		echo '</select>';
		echo '</div>';

		// the fermentable id
		echo '<input type="hidden" name="fermentable' . $i . '_id" />';

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
		echo '<select class="form-control input-sm" name="hop' . $i . '_name" onchange="gethopinfo(this.value,' .$i. ');">';
		echo '<option>'; echo $hops[$i]['name']; echo '</option>';
		$query = "SELECT hop_name FROM hops ORDER BY hop_name";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		while ($row = mysqli_fetch_array ( $result ))
		{
			echo '<option>' . $row['hop_name'] . '</option>';
		}
		echo '</select>';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="0" step="any" name="hop' . $i . '_amount" value="' . $hops[$i]['amount'] . '" onchange="hops_messages(' .$i. '); calc_ibu();" />';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="0" step="0.1" name="hop' . $i . '_alpha" value="' . $hops[$i]['alpha'] . '" onchange="hops_messages(' .$i. '); calc_ibu();" />';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="0" step="1" name="hop' . $i . '_time" value="' . $hops[$i]['time'] . '" onchange="hops_messages(' .$i. '); calc_ibu();" />';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-2">';
		echo '<select class="form-control input-sm" name="hop' . $i . '_form" >';
		echo '<option>'; echo $hops[$i]['form']; echo '</option>';
		echo '<option>Pellet</option>';
		echo '<option>Plug</option>';
		echo '<option>Whole</option>';
		echo '</select>';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-2">';
		echo '<select class="form-control input-sm" name="hop' . $i . '_use" >';
		echo '<option>'; echo $hops[$i]['use']; echo '</option>';
		echo '<option>Aroma</option>';
		echo '<option>Boil</option>';
		echo '<option>Dry Hop</option>';
		echo '<option>First Wort</option>';
		echo '<option>Mash</option>';
		echo '</select>';
		echo '</div>';

		// the hops id
		echo '<input type="hidden" name="hop' . $i . '_id" />';

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
		echo '<select class="form-control input-sm" name="yeast' . $i . '_fullname" onchange="getyeastinfo(this.value,' .$i. ');">';
		echo '<option>'; echo $yeasts[$i]['fullname']; echo '</option>';
		$query = "SELECT yeast_fullname FROM yeasts ORDER BY yeast_fullname";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		while ($row = mysqli_fetch_array ( $result ))
		{
			echo '<option>' . $row['yeast_fullname'] . '</option>';
		}
		echo '</select>';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-3 col-md-2">';
		echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_type" value="' . $yeasts[$i]['type'] . '" readonly="yes" />';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-3 col-md-2">';
		echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_form" value="' . $yeasts[$i]['form'] . '" readonly="yes" />';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-3 col-md-2">';
		echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_attenuation" value="' . $yeasts[$i]['attenuation'] . '" readonly="yes" />';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-3 col-md-2">';
		echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_flocculation" value="' . $yeasts[$i]['flocculation'] . '" readonly="yes" />';
		echo '</div>';

		// the yeast id
		echo '<input type="hidden" name="yeast' . $i . '_id" value="'; echo $yeasts[$i]['id']; echo '"/>';

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
		echo '<select class="form-control input-sm" name="misc' . $i . '_name" onchange="getmiscinfo(this.value,' .$i. ');" >';
		echo '<option>'; echo $miscs[$i]['name']; echo '</option>';
        $query = "SELECT misc_name FROM miscs ORDER BY misc_name";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		while ($row = mysqli_fetch_array ( $result ))
		{
			echo '<option>' . $row['misc_name'] . '</option>';
		}
		echo '</select>';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-2">';
		echo '<input type="text" class="form-control input-sm" name="misc' . $i . '_type" value="' . $miscs[$i]['type'] . '" readonly="yes" /> ';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="0" step="0.1" name="misc' . $i . '_amount" value="' . $miscs[$i]['amount'] . '" onchange="miscs_messages(' .$i. ');" /> ';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="text" class="form-control input-sm" name="misc' . $i . '_unit" value="' . $miscs[$i]['unit'] . '" onchange="miscs_messages(' .$i. ');" /> ';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-2">';
		echo '<select class="form-control input-sm" name="misc' . $i . '_use" onchange="miscs_messages(' .$i. ');" > ';
		echo '<option>'; echo $miscs[$i]['use']; echo '</option>';
		echo '<option>Boil</option>';
		echo '<option>Mash</option>';
		echo '<option>Primary</option>';
		echo '<option>Secondary</option>';
		echo '<option>Bottling</option>';
		echo '</select>';
		echo '</div>';

		// the miscs id
		echo '<input type="hidden" name="misc' . $i . '_id" value="'; echo $miscs[$i]['id']; echo '"/> ';

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
		echo '<div class="row margin-bottom-qtr-em">';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="0" step="0.1" name="mash' . $i . '_temp" /> ';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="0" step="1" name="mash' . $i . '_time" /> ';
		echo '</div>';

		// the mash id
		echo '<input type="hidden" name="mash' . $i . '_id" value="'; echo $mashes[$i]['id']; echo '"/> ';

		echo '</div>';
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
		echo '<div class="row margin-bottom-qtr-em">';

		echo '<div class="col-xs-3 col-sm-2 col-md-2">';
		echo '<input type="date" class="form-control input-sm" name="fermentation' . $i . '_start_date" /> ';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-2">';
		echo '<input type="date" class="form-control input-sm" name="fermentation' . $i . '_end_date" /> ';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-1">';
		echo '<input type="text" class="form-control input-sm" name="fermentation' . $i . '_temp" /> ';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-1">';
		echo '<input type="text" class="form-control input-sm" name="fermentation' . $i . '_measured_sg" /> ';
		echo '</div>';

		// the fermentation id
		echo '<input type="hidden" name="fermentation' . $i . '_id" value="'; echo $fermentations[$i]['id']; echo '"/> ';

		echo '</div>';
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
	echo '<option>'; echo $details['packaging']; echo '</option>';
	echo '<option>Bottle</option>';
	echo '<option>Keg</option>';
	echo '</select>';
	echo '</div>';

	echo '<div class="col-xs-3 col-sm-3 col-md-2">';
	echo '<input type="date" class="form-control input-sm" name="packaging_date" />';
	echo '</div>';

	echo '<div class="col-xs-3 col-sm-3 col-md-2">';
	echo '<input type="number" min="0" step=".1" class="form-control input-sm" name="vol_co2" />';
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
