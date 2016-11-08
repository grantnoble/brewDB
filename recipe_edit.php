<?php

/*
recipe_edit.php
Edit a recipe in the database
*/

$page_title = 'Edit Recipe';
$error = "";
$total_amount = 0;
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// if form submission, retrieve the field values
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// field validation OK, so retrieve the field values from the form
	// recipe ID, name, and style
	$details['id'] = mysqli_real_escape_string($connection, test_input($_POST['id']));
	$details['name'] = mysqli_real_escape_string($connection, test_input($_POST['name']));
	$details['style'] = mysqli_real_escape_string($connection, test_input($_POST['style']));

	// query the database to retrieve the style ID for the style
	$query = "SELECT style_id FROM styles WHERE style_name='" . $details['style'] . "'";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	while ($row = mysqli_fetch_array ( $result ))
	{
		$details['style_id'] = $row['style_id'];
	}

	// retrieve the basic recipe details
	$details['type'] = mysqli_real_escape_string($connection, test_input($_POST['type']));
	$details['batch_size'] = mysqli_real_escape_string($connection, test_input($_POST['batch_size']));
	$details['mash_efficiency'] = mysqli_real_escape_string($connection, test_input($_POST['mash_efficiency']));
	$details['est_og'] = mysqli_real_escape_string($connection, test_input($_POST['est_og']));
	if (!$details['est_og'])
	{
		$details['est_og'] = "NULL";
	}

	$details['est_fg'] = mysqli_real_escape_string($connection, test_input($_POST['est_fg']));
	if (!$details['est_fg'])
	{
		$details['est_fg'] = "NULL";
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

	$details['date'] = mysqli_real_escape_string($connection, test_input($_POST['date']));
	if (!$details['date'])
	{
		$details['date'] = "NULL";
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
		$fermentables[$i]['delete'] = mysqli_real_escape_string($connection, test_input($_POST['fermentable' . $i . '_delete']));
		$fermentables[$i]['record_id'] = mysqli_real_escape_string($connection, test_input($_POST['fermentable' . $i . '_record_id']));
		$fermentables[$i]['flag'] = mysqli_real_escape_string($connection, test_input($_POST['fermentable' . $i . '_flag']));
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
		$hops[$i]['record_id'] = mysqli_real_escape_string($connection, test_input($_POST['hop' . $i . '_record_id']));
		$hops[$i]['flag'] = mysqli_real_escape_string($connection, test_input($_POST['hop' . $i . '_flag']));
	}

	// retrieve the recipe yeasts
	for ($i=0; $i<=0; $i++)
	{
		$yeasts[$i]['id'] = mysqli_real_escape_string($connection, test_input($_POST['yeast' . $i . '_id']));
		$yeasts[$i]['fullname'] = mysqli_real_escape_string($connection, test_input($_POST['yeast' . $i . '_fullname']));
		$yeasts[$i]['product_id'] = mysqli_real_escape_string($connection, test_input($_POST['yeast' . $i . '_product_id']));
		$yeasts[$i]['record_id'] = mysqli_real_escape_string($connection, test_input($_POST['yeast' . $i . '_record_id']));
		$yeasts[$i]['flag'] = mysqli_real_escape_string($connection, test_input($_POST['yeast' . $i . '_flag']));
	}

	// retrieve the recipe misc ingredients
	for ($i=0; $i <=14; $i++)
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

	// now update the records in the database

	// update the recipe record
	$query = "UPDATE recipes SET recipe_name='" . $details['name'] . "', recipe_type='" . $details['type'] . "', recipe_style_id='" . $details['style_id'] . "', recipe_batch_size=" . $details['batch_size'] . ", recipe_mash_efficiency=" . $details['mash_efficiency'] . ", recipe_designer='" . $details['designer'] . "', recipe_notes='" . $details['notes'] . "', recipe_est_og=" . $details['est_og'] . ", recipe_est_fg=" . $details['est_fg'] . ", recipe_est_color=" . $details['est_color'] . ", recipe_est_ibu=" . $details['est_ibu'] . ", recipe_est_abv=" . $details['est_abv'] . ", recipe_date='" . $details['date'] . "' WHERE recipe_id='" . $details['id'] . "'";
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
				$query = "DELETE FROM recipes_fermentables WHERE recipe_fermentable_id='" . $fermentables[$i]['record_id'] . "'";
			}
			// else if record_id and name, UPDATE 
			elseif ($fermentables[$i]['record_id'] && $fermentables[$i]['name'])
			{
				$query = "UPDATE recipes_fermentables SET recipe_fermentable_fermentable_id='" . $fermentables[$i]['id'] . "', recipe_fermentable_amount='" . $fermentables[$i]['amount'] . "', recipe_fermentable_use='" . $fermentables[$i]['use'] . "' WHERE recipe_fermentable_id='" . $fermentables[$i]['record_id'] . "'";
			}
			// else if !record_id and name, INSERT
			elseif ((!$fermentables[$i]['record_id']) && $fermentables[$i]['name'])
			{
				$query = "INSERT INTO recipes_fermentables (recipe_fermentable_recipe_id, recipe_fermentable_fermentable_id, recipe_fermentable_amount, recipe_fermentable_use) VALUES ('" . $details['id'] . "','" . $fermentables[$i]['id'] . "'," . $fermentables[$i]['amount'] . ",'" . $fermentables[$i]['use'] . "')";
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
				$query = "DELETE FROM recipes_hops WHERE recipe_hop_id='" . $hops[$i]['record_id'] . "'";
			}
			// else if record_id and name, UPDATE 
			elseif ($hops[$i]['record_id'] && $hops[$i]['name'])
			{
				$query = "UPDATE recipes_hops SET recipe_hop_hop_id='" . $hops[$i]['id'] . "', recipe_hop_amount=" . $hops[$i]['amount'] . ", recipe_hop_alpha=" . $hops[$i]['alpha'] . ",recipe_hop_use='" . $hops[$i]['use'] . "', recipe_hop_time=" . $hops[$i]['time'] . ", recipe_hop_form='" . $hops[$i]['form'] . "' WHERE recipe_hop_id='" . $hops[$i]['record_id'] . "'";
			}
			// else if !record_id and name, INSERT
			elseif ((!$hops[$i]['record_id']) && $hops[$i]['name'])
			{
				$query = "INSERT INTO recipes_hops (recipe_hop_recipe_id, recipe_hop_hop_id, recipe_hop_amount, recipe_hop_alpha, recipe_hop_use, recipe_hop_time, recipe_hop_form) VALUES ('" . $details['id'] . "','" . $hops[$i]['id'] . "'," . $hops[$i]['amount'] . "," . $hops[$i]['alpha'] . ",'" . $hops[$i]['use'] . "'," . $hops[$i]['time'] . ",'" . $hops[$i]['form'] . "')";
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
				$query = "DELETE FROM recipes_yeasts WHERE recipe_yeast_id='" . $yeasts[$i]['record_id'] . "'";
			}*/
			// else if record_id and name, UPDATE 
			if ($yeasts[$i]['record_id'] && $yeasts[$i]['fullname'])
			{
				$query = "UPDATE recipes_yeasts SET recipe_yeast_yeast_id='" . $yeasts[$i]['id'] . "' WHERE recipe_yeast_id='" . $yeasts[$i]['record_id'] . "'";
			}
			// else if !record_id and name, INSERT
			elseif ((!$yeasts[$i]['record_id']) && $yeasts[$i]['fullname'])
			{
				$query = "INSERT INTO recipes_yeasts (recipe_yeast_recipe_id, recipe_yeast_yeast_id) VALUES (" . $details['id'] . "," . $yeasts[$i]['id'] . ")";
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
			// if record_id and name is DELETE, DELETE
			if ($miscs[$i]['record_id'] && $miscs[$i]['amount']==0)
			{
				$query = "DELETE FROM recipes_miscs WHERE recipe_misc_id='" . $miscs[$i]['record_id'] . "'";
			}
			// else if record_id and name, UPDATE 
			elseif ($miscs[$i]['record_id'] && $miscs[$i]['name'])
			{
				$query = "UPDATE recipes_miscs SET recipe_misc_misc_id='" . $miscs[$i]['id'] . "', recipe_misc_amount='" . $miscs[$i]['amount'] . "', recipe_misc_unit='" . $miscs[$i]['unit'] . "', recipe_misc_use='" . $miscs[$i]['use'] . "' WHERE recipe_misc_id='" . $miscs[$i]['record_id'] . "'";
			}
			// else if !record_id and name, INSERT
			elseif ((!$miscs[$i]['record_id']) && $miscs[$i]['name'])
			{
				$query = "INSERT INTO recipes_miscs (recipe_misc_recipe_id, recipe_misc_misc_id, recipe_misc_amount, recipe_misc_unit, recipe_misc_use) VALUES ('" . $details['id'] . "','" . $miscs[$i]['id'] . "'," . $miscs[$i]['amount'] . ",'" . $miscs[$i]['unit'] . "','" . $miscs[$i]['use'] ."')";
			}
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

	// After saving to the database, redirect back to the list recipes page
	echo '<script type="text/javascript">
	window.location = "recipes_list.php"
	</script>';
}
	
// not a form submission, so retrieve the recipe details
// check that the 'id' variable is set in URL and it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
// get the recipe details
include('includes/get_recipe_details.php');
}
// else if the id isn't set, or isn't valid, redirect back to list recipes page
else
{
	echo '<script type="text/javascript">
	window.location = "recipes_list.php"
	</script>';
}

// end of PHP section, now create the HTML form
?>

<div class="container">
	
<h2>Edit Recipe</h2>

<form role="form" class="form-horizontal" name="recipeform" action="recipe_edit.php" method="post">

<input type="hidden" name="id" value="<?php echo $details['id']; ?>" />

<div class="row">

<fieldset class="col-xs-12 col-sm-6 col-md-8">

<div class="well">
<legend>Recipe Details</legend>

	<div class="row margin-bottom-1em">
		
		<div class="col-xs-4 col-md-4">
			<label for="name" class="label-sm">Recipe Name</label>
			<input type="text" class="form-control input-sm" id="name" name="name" required value="<?php echo $details['name']; ?>" />
		</div>
		
		<div class="col-xs-4 col-md-5">
			<label for="style" class="label-sm">Style</label>
			<select class="form-control input-sm" id="style" name="style" required onchange="getstyleinfo(this.value);">
				<option><?php echo $style['name']; ?></option>
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
				<option><?php echo $details['type']; ?></option>
				<option>All Grain</option>
				<option>Extract</option>
				<option>Partial Mash</option>
			</select>
		</div>
		
	</div>

	<div class="row margin-bottom-1em">
	
		<div class="col-xs-4 col-sm-4 col-md-2">
			<label for="batch_size" class="label-sm">Batch Size (L)</label>
			<input type="number" class="form-control input-sm" min="0" step=".1" id="batch_size" name="batch_size" required onchange="calc_og_color_ibu();" value="<?php echo $details['batch_size']; ?>"/>
		</div>
		
		<div class="col-xs-4 col-sm-4 col-md-2">
			<label for="mash_efficiency" class="label-sm">Mash Eff (%)</label>
			<input type="number" class="form-control input-sm" min="0" step=".01" id="mash_efficiency" name="mash_efficiency" required onchange="calc_og_color_ibu();" value="<?php echo $details['mash_efficiency']; ?>"/>
		</div>
		
		<div class="col-xs-5 col-sm-4 col-md-3">
			<label for="date" class="label-sm">Date (yyyy-mm-dd)</label>
			<input type="date" class="form-control input-sm" id="date" name="date" value="<?php echo $details['date']; ?>"/>
		</div>
		
		<div class="hidden-xs col-sm-4 col-md-5">
			<label for="designer" class="label-sm">Designer</label>
			<input list="persons" class="form-control input-sm" id="designer" name="designer" value="<?php echo $details['designer']; ?>"/>
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
			<textarea class="form-control input-sm" rows=2 cols=100 id="notes" name="notes"><?php echo $details['notes']; ?></textarea>
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
 
	<div class="row margin-bottom-qtr-em">
	
		<div class="col-xs-3 col-md-3 col-lg-3">
			<label for="name" class="label-sm">OG</label>
		</div>
		
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_og_min" name="style_og_min" readonly="yes" value="<?php echo $style['og_min']; ?>" />
		</div>
		
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="est_og" name="est_og" readonly="yes" value="<?php echo $details['est_og']; ?>" />
		</div>
		
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_og_max" name="style_og_max" readonly="yes" value="<?php echo $style['og_max']; ?>" />
		</div>
		
	</div>
 
	<div class="row margin-bottom-qtr-em">
    
		<div class="col-xs-3 col-md-3 col-lg-3">
			<label for="name" class="label-sm">FG</label>
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_fg_min" name="style_fg_min" readonly="yes" value="<?php echo $style['fg_min']; ?>" />
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="est_fg" name="est_fg" readonly="yes" value="<?php echo $details['est_fg']; ?>" />
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_fg_max" name="style_fg_max" readonly="yes" value="<?php echo $style['fg_max']; ?>" />
		</div>
        
	</div>
 
	<div class="row margin-bottom-qtr-em">
	
		<div class="col-xs-3 col-md-3 col-lg-3">
			<label for="name" class="label-sm">ABV %</label>
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_abv_min" name="style_abv_min" readonly="yes" value="<?php echo $style['abv_min']; ?>" />
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="est_abv" name="est_abv" readonly="yes" value="<?php echo $details['est_abv']; ?>" />
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_abv_max" name="style_abv_max" readonly="yes" value="<?php echo $style['abv_max']; ?>" />
		</div>
        
	</div>
 
	<div class="row margin-bottom-qtr-em">
    
		<div class="col-xs-3 col-md-3 col-lg-3">
			<label for="name" class="label-sm">IBU</label>
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_ibu_min" name="style_ibu_min" readonly="yes" value="<?php echo $style['ibu_min']; ?>" />
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="est_ibu" name="est_ibu" readonly="yes" value="<?php echo $details['est_ibu']; ?>" />
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_ibu_max" name="style_ibu_max" readonly="yes" value="<?php echo $style['ibu_max']; ?>" />
		</div>
        
	</div>
 
	<div class="row">
    
		<div class="col-xs-3 col-md-3 col-lg-3">
			<label for="name" class="label-sm">Color (L)</label>
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_color_min" name="style_color_min" readonly="yes" value="<?php echo $style['color_min']; ?>" />
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="est_color" name="est_color" readonly="yes" value="<?php echo $details['est_color']; ?>" />
		</div>
        
		<div class="col-xs-3 col-md-3">
			<input type="text" class="form-control input-sm" id="style_color_max" name="style_color_max" readonly="yes" value="<?php echo $style['color_max']; ?>" />
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
		<div class="row margin-bottom-qtr-em">
		
		<div class="col-xs-6 col-sm-2 col-md-3">
		<?php
		echo '<select class="form-control input-sm" name="fermentable' . $i . '_name" onchange="getfermentableinfo(this.value,' .$i. '); set_flag(' . $ingredient . ', ' . $i . ');">';
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
		echo '<input type="number" class="form-control input-sm" min="0" step="0.001" name="fermentable' . $i . '_amount" onchange="fermentables_messages(' .$i. '); calc_og_color_ibu(); set_flag(' . $ingredient . ', ' . $i . ');" value="'; echo $fermentables[$i]['amount']; echo '"/>';
		?>
		</div>
			
		<div class="hidden-xs col-sm-2 col-md-1">
		<?php
		echo '<input type="number" class="form-control input-sm" name="fermentable' . $i . '_percent" readonly="yes" value="'; echo $fermentables[$i]['percent']; echo '"/>';
		?>
		</div>
			
		<div class="hidden-xs col-sm-2 col-md-1">
		<?php
		echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_yield" readonly="yes" value="'; echo $fermentables[$i]['yield']; echo '"/>';
		?>
		</div>
			
		<div class="hidden-xs col-sm-2 col-md-1">
		<?php
		echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_color" readonly="yes" value="'; echo $fermentables[$i]['color']; echo '"/>';
		?>
		</div>
			
		<div class="col-xs-3 col-sm-2 col-md-1">
		<?php
		echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_type" readonly="yes" value="'; echo $fermentables[$i]['type']; echo '"/>';
		?>
		</div>
		
		<div class="col-xs-3 col-sm-2 col-md-2">
		<?php
		echo '<select class="form-control input-sm" name="fermentable' . $i . '_use" onchange="set_flag(' . $ingredient . ', ' . $i . ')">';
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
		// the recipes_fermentables record id
		echo '<input type="hidden" name="fermentable' . $i . '_record_id" value="'; echo $fermentables[$i]['record_id']; echo '"/>';
		// the fermentable id
		echo '<input type="hidden" name="fermentable' . $i . '_id" value="'; echo $fermentables[$i]['id']; echo '"/>';
		// the update flag
		echo '<input type="hidden" name="fermentable' . $i . '_flag" value="'; echo $fermentables[$i]['flag']; echo '"/>';
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
		echo '<div class="row margin-bottom-qtr-em">';
		echo '<div class="col-xs-6 col-sm-2 col-md-3">';
		echo '<select class="form-control input-sm" name="hop' . $i . '_name" onchange="gethopinfo(this.value,' .$i. '); set_flag(' . $ingredient . ', ' . $i . ');">';
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
		echo '<option>'; echo $hops[$i]['form']; echo '</option>';
		echo '<option>Pellet</option>';
		echo '<option>Plug</option>';
		echo '<option>Whole</option>';
		echo '</select>';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-2">';
		echo '<select class="form-control input-sm" name="hop' . $i . '_use" onchange="set_flag(' . $ingredient . ', ' . $i . ')">';
		echo '<option>'; echo $hops[$i]['use']; echo '</option>';
		echo '<option>Aroma</option>';
		echo '<option>Boil</option>';
		echo '<option>Dry Hop</option>';
		echo '<option>First Wort</option>';
		echo '<option>Mash</option>';
		echo '</select>';
		echo '</div>';

		// the recipes_hops record id
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
<fieldset class="fieldset col-xs-12 col-md-12 five-ingredients">

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
		
		// the recipes_yeasts record id
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
		echo '<option>'; echo $miscs[$i]['use']; echo '</option>';
		echo '<option>Boil</option>';
		echo '<option>Mash</option>';
		echo '<option>Primary</option>';
		echo '<option>Secondary</option>';
		echo '<option>Bottling</option>';
		echo '</select>';
		echo '</div>';
		
		// the recipes_miscs record id
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

</div>

<button type="submit" class="btn btn-default">Save</button>

</form>

</div>


<?php
include ('includes/footer.html');
?>
