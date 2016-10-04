<?php

/*
recipe_new.php
Create a recipe in the database
*/

$page_title = 'New Recipe';
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

	// retrieve the basic recipe details
	$details['type'] = mysqli_real_escape_string($connection, test_input($_POST['type']));
	$details['boil_size'] = mysqli_real_escape_string($connection, test_input($_POST['boil_size']));
	$details['boil_time'] = mysqli_real_escape_string($connection, test_input($_POST['boil_time']));
	$details['batch_size'] = mysqli_real_escape_string($connection, test_input($_POST['batch_size']));
	$details['mash_efficiency'] = mysqli_real_escape_string($connection, test_input($_POST['mash_efficiency']));
	$details['est_og'] = mysqli_real_escape_string($connection, test_input($_POST['est_og']));
	if (!$details['est_og'])
	{
		$details['est_og'] = 0;
	}

	$details['est_fg'] = mysqli_real_escape_string($connection, test_input($_POST['est_fg']));
	if (!$details['est_fg'])
	{
		$details['est_fg'] = 0;
	}

	$details['est_ibu'] = mysqli_real_escape_string($connection, test_input($_POST['est_ibu']));
	if (!$details['est_ibu'])
	{
		$details['est_ibu'] = 0;
	}

	$details['est_color'] = mysqli_real_escape_string($connection, test_input($_POST['est_color']));
	if (!$details['est_color'])
	{
		$details['est_color'] = 0;
	}

	$details['est_abv'] = mysqli_real_escape_string($connection, test_input($_POST['est_abv']));
	if (!$details['est_abv'])
	{
		$details['est_abv'] = 0;
	}

	$details['date'] = mysqli_real_escape_string($connection, test_input($_POST['date']));
	if (!$details['date'])
	{
		$details['date'] = "0000-00-00";
	}

	$details['designer'] = mysqli_real_escape_string($connection, test_input($_POST['designer']));
	$details['notes'] = mysqli_real_escape_string($connection, test_input($_POST['notes']));

	// retrieve the recipe fermentables
	for ($i=0; $i<=14; $i++)
	{
		$fermentables[$i]['id'] = mysqli_real_escape_string($connection, test_input($_POST['fermentable' . $i . '_id']));
		$fermentables[$i]['name'] = mysqli_real_escape_string($connection, test_input($_POST['fermentable' . $i . '_name']));
		$fermentables[$i]['amount'] = mysqli_real_escape_string($connection, test_input($_POST['fermentable' . $i . '_amount']));
		$fermentables[$i]['use'] = mysqli_real_escape_string($connection, test_input($_POST['fermentable' . $i . '_use']));
	}

	// retrieve the receipe hops
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

	// retrieve the recipe yeasts
	$yeasts[0]['id'] = mysqli_real_escape_string($connection, test_input($_POST['yeast0_id']));
	$yeasts[0]['fullname'] = mysqli_real_escape_string($connection, test_input($_POST['yeast0_fullname']));

	// retrieve the recipe misc ingredients
	for ($i=0; $i<=4; $i++)
	{
		$miscs[$i]['id'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_id']));
		$miscs[$i]['name'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_name']));
		$miscs[$i]['amount'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_amount']));
		$miscs[$i]['unit'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_unit']));
		$miscs[$i]['type'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_type']));
	}

	// now insert the records into the database

	// insert the recipe record
	$query = "INSERT INTO recipes (recipe_name, recipe_type, recipe_style_id, recipe_boil_size, recipe_boil_time, recipe_batch_size, recipe_mash_efficiency, recipe_designer, recipe_notes, recipe_est_og, recipe_est_fg, recipe_est_color, recipe_est_ibu, recipe_est_abv, recipe_date)
		VALUES ('" . $details['name'] . "','" .  $details['type'] . "'," . $details['style_id'] . "," . $details['boil_size'] . "," . $details['boil_time'] . "," . $details['batch_size'] . "," .  $details['mash_efficiency'] . ",'" . $details['designer'] . "','" . $details['notes'] . "'," . $details['est_og'] . "," . $details['est_fg'] . "," . $details['est_color'] . "," . $details['est_ibu'] . "," . $details['est_abv'] . ",'" . $details['date'] . "')";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

	// retrieve the id of the last insert as the recipe_id for the recipes_fermentables, recipes_hops, recipes_yeasts, and recipes_miscs records
	$recipe_id = mysqli_insert_id($connection);

	// for each fermentable, retrieve the fermentable id and insert the recipe_fermentable records
	for ($i=0; $i <=14; $i++)
	{
		if ($fermentables[$i]['name'])
		{
			$query = "INSERT INTO recipes_fermentables (recipe_fermentable_recipe_id, recipe_fermentable_fermentable_id, recipe_fermentable_amount, recipe_fermentable_use)
					VALUES (" . $recipe_id . "," . $fermentables[$i]['id'] . "," . $fermentables[$i]['amount'] . ",'" . $fermentables[$i]['use'] . "')";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

	// for each hop, retrieve the hop id and insert the recipe_hop records
	for ($i=0; $i <=14; $i++)
	{
		if ($hops[$i]['name'])
		{
			$query = "INSERT INTO recipes_hops (recipe_hop_recipe_id, recipe_hop_hop_id, recipe_hop_amount, recipe_hop_alpha, recipe_hop_use, recipe_hop_time, recipe_hop_form)
					VALUES (" . $recipe_id . "," . $hops[$i]['id'] . "," . $hops[$i]['amount'] . "," . $hops[$i]['alpha'] . ",'" . $hops[$i]['use'] . "'," . $hops[$i]['time'] . ",'" . $hops[$i]['form'] . "')";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

	// for each yeast, retrieve the yeast id and insert the recipe_yeast records
	for ($i=0; $i <=0; $i++)
	{
		if ($yeasts[$i]['fullname'])
		{
			$query = "INSERT INTO recipes_yeasts (recipe_yeast_recipe_id, recipe_yeast_yeast_id)
					VALUES (" . $recipe_id . "," . $yeasts[$i]['id'] . ")";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

	// for each misc, retrieve the misc id and insert the recipe_misc records
	for ($i=0; $i <=14; $i++)
	{
		if ($miscs[$i]['name'])
		{
			$query = "INSERT INTO recipes_miscs (recipe_misc_recipe_id, recipe_misc_misc_id, recipe_misc_amount, recipe_misc_unit)
					VALUES (" . $recipe_id . "," . $miscs[$i]['id'] . "," . $miscs[$i]['amount'] . ",'" . $miscs[$i]['unit'] . "')";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

    // After saving to the database, redirect back to the new recipe page
	echo '<script type="text/javascript">
	window.location = "recipe_new.php"
	</script>';
}

// end of PHP section, now create the HTML form
?>

<div class="container">
	
<h2>New Recipe</h2>

<form role="form" class="form-horizontal" name="recipeform" action="recipe_new.php" method="post">

<div class="row">

<fieldset class="col-xs-12 col-sm-6 col-md-8">

<div class="well">
<legend>Recipe Details</legend>

	<div class="row margin-bottom-1em">
		
		<div class="col-xs-4 col-md-4">
			<label for="name" class="label-sm">Recipe Name</label>
			<input type="text" class="form-control input-sm" id="name" name="name" required />
		</div>
		
		<div class="col-xs-4 col-md-5">
			<label for="style" class="label-sm">Style</label>
			<select class="form-control input-sm" id="style" name="style" required onchange="getstyleinfo(this.value);">
				<option value="" disabled selected>Select a style...</option>
				<?php
				$query = "SELECT style_name FROM styles ORDER BY style_name";
				$result = mysqli_query($connection, $query);
				while ($row = mysqli_fetch_array ( $result ))
				{
					echo '<option>' . $row['style_name'] . '</option>';
				}
				?>
			</select>
		</div>
		
		<div class="col-xs-4 col-md-3">
			<label for="type" class="label-sm">Type</label>
			<select class="form-control input-sm" id="type" name="type" required >
				<option value="" disabled selected>Select a type...</option>
				<option>All Grain</option>
				<option>Extract</option>
				<option>Partial Mash</option>
			</select>
		</div>
		
	</div>

	<div class="row margin-bottom-1em">
		
		<?php
		$query = "SELECT preference_boil_size, preference_boil_time, preference_evaporation_rate, preference_batch_size, preference_mash_efficiency FROM preferences";
		$result = mysqli_query($connection, $query);
		while ($row = mysqli_fetch_array ( $result ))
		{
			echo '<div class="col-xs-4 col-sm-4 col-md-3">';
				echo '<label for="boil_size" class="label-sm">Boil Size (L)</label>';
				echo '<input type="number" class="form-control input-sm" min="0" step=".1" id="boil_size" name="boil_size" required onchange="calc_og_color_ibu();" value="' . $row['preference_boil_size'] . '"/>';
			echo '</div>';
			echo '<div class="col-xs-4 col-sm-4 col-md-3">';
				echo '<label for="boil_time" class="label-sm">Boil Time (min)</label>';
				echo '<input type="number" class="form-control input-sm" min="0" step="1" id="boil_time" name="boil_time" required onchange="calc_og_color_ibu();" value="' . $row['preference_boil_time'] . '"/>';
			echo '</div>';
			echo '<div class="col-xs-4 col-sm-4 col-md-3">';
				echo '<label for="batch_size" class="label-sm">Batch Size (L)</label>';
				echo '<input type="number" class="form-control input-sm" min="0" step=".1" id="batch_size" name="batch_size" required onchange="calc_og_color_ibu();" value="' . $row['preference_batch_size'] . '"/>';
			echo '</div>';
			echo '<div class="col-xs-4 col-sm-4 col-md-3">';
				echo '<label for="mash_efficiency" class="label-sm">Mash Efficiency (%)</label>';
				echo '<input type="number" class="form-control input-sm" min="0" step=".01" id="mash_efficiency" name="mash_efficiency" required onchange="calc_og_color_ibu();" value="' . $row['preference_mash_efficiency'] . '"/>';
			echo '</div>';
		}
		?>
		
	</div>
	
	<div class="row margin-bottom-1em">
	
		<div class="col-xs-5 col-sm-4 col-md-3">
			<label for="date" class="label-sm">Date (yyyy-mm-dd)</label>
			<input type="date" class="form-control input-sm" id="date" name="date" value="<?php echo date("Y-m-d"); ?>"/>
		</div>
		
		<div class="hidden-xs col-sm-4 col-md-6">
			<label for="designer" class="label-sm">Designer</label>
			<input list="persons" class="form-control input-sm" id="designer" name="designer" />
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
		
	</div>
	
	<div class="row">
		
		<div class="col-xs-12 col-md-12">
			<label for="notes" class="label-sm">Recipe Notes</label>
			<textarea class="form-control input-sm" rows=2 cols=100 id="notes" name="notes"></textarea>
		</div>
		
	</div>
</div>
	
</fieldset>

<fieldset class="col-xs-12 col-sm-5 col-md-4">

<div class="well">
<legend>Style Characteristics</legend>
 
	<div class="row">
    
		<div class="col-xs-3 col-md-3">
			<label for="name" class="label-sm">&nbsp;</label>
		</div>
		
		<div class="col-xs-3 col-md-3">
			<label for="name" class="label-sm">Low</label>
		</div>
		
		<div class="col-xs-3 col-md-3">
			<label for="name" class="label-sm">Est.</label>
		</div>
		
		<div class="col-xs-3 col-md-3">
			<label for="name" class="label-sm">High</label>
		</div>
		
	</div>
 
	<div class="row">
	
		<div class="col-xs-3 col-md-3 col-lg-3">
			<label for="name" class="label-sm">OG</label>
		</div>
		
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_og_min" name="style_og_min" readonly="yes" />
		</div>
		
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="est_og" name="est_og" readonly="yes" />
		</div>
		
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_og_max" name="style_og_max" readonly="yes" />
		</div>
		
	</div>
 
	<div class="row">
    
		<div class="col-xs-3 col-md-3 col-lg-3">
			<label for="name" class="label-sm">FG</label>
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_fg_min" name="style_fg_min" readonly="yes" />
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="est_fg" name="est_fg" readonly="yes" />
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_fg_max" name="style_fg_max" readonly="yes" />
		</div>
        
	</div>
 
	<div class="row">
	
		<div class="col-xs-3 col-md-3 col-lg-3">
			<label for="name" class="label-sm">ABV %</label>
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_abv_min" name="style_abv_min" readonly="yes" />
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="est_abv" name="est_abv" readonly="yes" />
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_abv_max" name="style_abv_max" readonly="yes" />
		</div>
        
	</div>
 
	<div class="row">
    
		<div class="col-xs-3 col-md-3 col-lg-3">
			<label for="name" class="label-sm">IBU</label>
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_ibu_min" name="style_ibu_min" readonly="yes" />
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="est_ibu" name="est_ibu" readonly="yes" />
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_ibu_max" name="style_ibu_max" readonly="yes" />
		</div>
        
	</div>
 
	<div class="row">
    
		<div class="col-xs-3 col-md-3 col-lg-3">
			<label for="name" class="label-sm">Color (L)</label>
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_color_min" name="style_color_min" readonly="yes" />
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="est_color" name="est_color" readonly="yes" />
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_color_max" name="style_color_max" readonly="yes" />
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
	?>
		<div class="row margin-bottom-half_em">
		
		<div class="col-xs-6 col-sm-2 col-md-3">
		<?php
		echo '<select class="form-control input-sm" name="fermentable' . $i . '_name" onchange="getfermentableinfo(this.value,' .$i. ');">';
		echo '<option>'; echo $fermentables[$i]['name']; echo '</option>';
		$query = "SELECT fermentable_name FROM fermentables ORDER BY fermentable_name";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		while ($row = mysqli_fetch_array ( $result ))
		{
			echo '<option>' . $row['fermentable_name'] . '</option>';
		}
		?>
		</select>
		</div>
			
		<div class="col-xs-3 col-sm-2 col-md-1">
		<?php
		echo '<input type="number" class="form-control input-sm" min="0" step="0.001" name="fermentable' . $i . '_amount" onchange="fermentables_messages(' .$i. '); calc_og_color_ibu(); set_flag(' . $ingredient . ', ' . $i . ');"' . '"/>';
		?>
		</div>
			
		<div class="hidden-xs col-sm-2 col-md-1">
		<?php
		echo '<input type="number" class="form-control input-sm" name="fermentable' . $i . '_percent" readonly="yes" />';
		?>
		</div>
			
		<div class="hidden-xs col-sm-2 col-md-1">
		<?php
		echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_yield" readonly="yes" />';
		?>
		</div>
			
		<div class="hidden-xs col-sm-2 col-md-1">
		<?php
		echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_color" readonly="yes" />';
		?>
		</div>
			
		<div class="col-xs-3 col-sm-2 col-md-1">
		<?php
		echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_type" readonly="yes" />';
		?>
		</div>
		
		<div class="col-xs-3 col-sm-2 col-md-2">
		<?php
		echo '<select class="form-control input-sm" name="fermentable' . $i . '_use" >';
		echo '<option>'; echo $fermentables[$i]['use']; echo '</option>';
		?>
		<option>Mashed</option>
		<option>Steeped</option>
		<option>Extract</option>
		<option>Sugar</option>
		<option>Other</option>
		</select>
		</div>
		
		<?php
		// the fermentable id
		echo '<input type="hidden" name="fermentable' . $i . '_id" />';
		?>
		
		</div>
		
	<?php
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
		echo '<div class="row margin-bottom-half_em">';
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
		echo '<input type="number" class="form-control input-sm" min="0" step="any" name="hop' . $i . '_amount" onchange="hops_messages(' .$i. '); calc_ibu();" />';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="0" step="0.1" name="hop' . $i . '_alpha" onchange="hops_messages(' .$i. '); calc_ibu();" />';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="0" step="1" name="hop' . $i . '_time" onchange="hops_messages(' .$i. '); calc_ibu();" />';
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
		echo '<div class="row margin-bottom-half_em">';
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
		echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_type" readonly="yes" />';
		echo '</div>';
		
		echo '<div class="col-xs-3 col-sm-3 col-md-2">';
		echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_form" readonly="yes" />';
		echo '</div>';
		
		echo '<div class="col-xs-3 col-sm-3 col-md-2">';
		echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_attenuation" readonly="yes" />';
		echo '</div>';
		
		echo '<div class="col-xs-3 col-sm-3 col-md-2">';
		echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_flocculation" readonly="yes" />';
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
		
		<div class="col-xs-3 col-sm-2 col-md-1">
			<label class="label-sm">Amount</label>
		</div>
		
		<div class="col-xs-3 col-sm-2 col-md-1">
			<label class="label-sm">Unit</label>
		</div>
		
		<div class="hidden-xs col-sm-2 col-md-2">
			<label class="label-sm">Type</label>
		</div>
		
	</div>
	
	<?php
	$ingredient = "'misc'";
	for ($i=0; $i<=14; $i++)
	{
		echo '<div class="row margin-bottom-half_em">';
		
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
		
		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="0" step="0.1" name="misc' . $i . '_amount" onchange="miscs_messages(' .$i. ');" /> ';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="text" class="form-control input-sm" name="misc' . $i . '_unit" onchange="miscs_messages(' .$i. ');" /> ';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-2">';
		echo '<input type="text" class="form-control input-sm" name="misc' . $i . '_type" readonly="yes" /> ';
		echo '</div>';
		
		// the miscs id
		echo '<input type="hidden" name="misc' . $i . '_id" value="'; echo $miscs[$i]['id']; echo '"/> ';
		
		echo '</div>';
	}
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
