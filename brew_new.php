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
	}

	// now insert the records into the database

	// insert the brew record
	$query = "INSERT INTO brews (brew_name, brew_type, brew_style_id, brew_batch_size, brew_mash_efficiency, brew_designer, brew_notes, brew_est_og, brew_est_fg, brew_est_color, brew_est_ibu, brew_est_abv, brew_date)
		VALUES ('" . $details['name'] . "','" .  $details['type'] . "'," . $details['style_id'] . "," . $details['batch_size'] . "," .  $details['mash_efficiency'] . ",'" . $details['designer'] . "','" . $details['notes'] . "'," . $details['est_og'] . "," . $details['est_fg'] . "," . $details['est_color'] . "," . $details['est_ibu'] . "," . $details['est_abv'] . ",'" . $details['date'] . "')";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

	// retrieve the id of the last insert as the brew_id for the brews_fermentables, brews_hops, brews_yeasts, and brews_miscs records
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
			$query = "INSERT INTO brews_miscs (brew_misc_brew_id, brew_misc_misc_id, brew_misc_amount, brew_misc_unit)
					VALUES (" . $brew_id . "," . $miscs[$i]['id'] . "," . $miscs[$i]['amount'] . ",'" . $miscs[$i]['unit'] . "')";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

    // After saving to the database, redirect back to the new brew page
    // After saving to the database, redirect back to the new brew page
	echo '<script type="text/javascript">
	window.location = "brew_new.php"
	</script>';
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
		
		<div class="col-xs-4 col-md-4">
			<label for="name" class="label-sm">Brew Name</label>
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
	
		<div class="col-xs-4 col-md-4">
			<label for="base_recipe" class="label-sm">Base Recipe</label>
			<select class="form-control input-sm" id="base_recipe" name="base_recipe" >
				<option value="" disabled selected>Select a base recipe...</option>
				<?php
				$query = "SELECT recipe_name FROM recipes ORDER BY recipe_date DESC";
				$result = mysqli_query($connection, $query);
				while ($row = mysqli_fetch_array ( $result ))
				{
					echo '<option>' . $row['recipe_name'] . '</option>';
				}
				?>
			</select>
		</div>
		
		<?php
		$brew_batch_num = 0;
		$query = "SELECT brew_batch_num FROM brews ORDER BY brew_id DESC LIMIT 1";
		$result = mysqli_query($connection, $query);
		while ($row = mysqli_fetch_array ( $result ))
		{
			$brew_batch_num = $row['brew_batch_num'];
		}
		$brew_batch_num += 1;
		?>
		<div class="col-xs-2 col-md-2">
			<label for="batch_number" class="label-sm">Batch Number</label>
			<input type="text" class="form-control input-sm" id="batch_number" name="batch_number" required value="<?php echo $brew_batch_num; ?>"/>
		</div>
		
		<div class="col-xs-5 col-sm-4 col-md-3">
			<label for="date" class="label-sm">Date (yyyy-mm-dd)</label>
			<input type="date" class="form-control input-sm" id="date" name="date" value="<?php echo date("Y-m-d"); ?>"/>
		</div>
		
	</div>
	
	<div class="row margin-bottom-1em">
		
		<?php
		$query = "SELECT preference_boil_size, preference_boil_time, preference_evaporation_rate, preference_batch_size, preference_mash_efficiency FROM preferences";
		$result = mysqli_query($connection, $query);
		while ($row = mysqli_fetch_array ( $result ))
		{
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
		
		<div class="hidden-xs col-sm-3 col-md-4">
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
		
	</div>
	
	<div class="row">
		
		<div class="col-xs-12 col-md-12">
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
			<input type="text" class="form-control input-sm padding-5px" id="style_og_min" name="style_og_min" readonly="yes" />
		</div>
		
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="est_og" name="est_og" readonly="yes" />
		</div>
		
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="act_og" name="act_og"  />
		</div>
		
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_og_max" name="style_og_max" readonly="yes" />
		</div>
		
	</div>
 
	<div class="row margin-bottom-qtr-em">
    
		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">FG</label>
		</div>
        
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_fg_min" name="style_fg_min" readonly="yes" />
		</div>
        
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="est_fg" name="est_fg" readonly="yes" />
		</div>
        
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="act_fg" name="act_fg" />
		</div>
        
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_fg_max" name="style_fg_max" readonly="yes" />
		</div>
        
	</div>
 
	<div class="row margin-bottom-qtr-em">
	
		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">ABV&nbsp;(%)</label>
		</div>
        
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_abv_min" name="style_abv_min" readonly="yes" />
		</div>
        
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="est_abv" name="est_abv" readonly="yes" />
		</div>
        
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="act_abv" name="act_abv" />
		</div>
        
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_abv_max" name="style_abv_max" readonly="yes" />
		</div>
        
	</div>
 
	<div class="row margin-bottom-qtr-em">
    
		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">IBU</label>
		</div>
        
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_ibu_min" name="style_ibu_min" readonly="yes" />
		</div>
        
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="est_ibu" name="est_ibu" readonly="yes" />
		</div>
        
		<div class="col-xs-2 col-md-5ths">
		</div>
        
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_ibu_max" name="style_ibu_max" readonly="yes" />
		</div>
        
	</div>
 
	<div class="row">
    
		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">Color&nbsp;(L)</label>
		</div>
        
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_color_min" name="style_color_min" readonly="yes" />
		</div>
        
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="est_color" name="est_color" readonly="yes" />
		</div>
        
		<div class="col-xs-2 col-md-5ths">
		</div>
        
		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_color_max" name="style_color_max" readonly="yes" />
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
	?>
		<div class="row margin-bottom-qtr-em">
		
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

<div class="row tab-pane fade" id="mash">
<fieldset class="fieldset col-xs-12 col-md-12 five-ingredients">

	<div class="row">
	
		<div class="col-xs-3 col-md-2">
			<label for="mash_type" class="label-sm">Mash Type</label>
			<select class="form-control input-sm" id="mash_type" name="mash_type" required >
				<option value="" disabled selected>Select a mash type...</option>
				<option>BIAB</option>
				<option>Batch Sparge</option>
				<option>Fly Sparge</option>
				<option>No Sparge</option>
			</select>
		</div>
		
		<div class="col-xs-6 col-sm-2 col-md-1">
			<label class="label-sm">Step</label>
			<input type="number" class="form-control input-sm" min="1" step="1" name="mash0_step" />
		</div>
		
		<div class="col-xs-3 col-sm-2 col-md-1">
			<label class="label-sm">Temp&nbsp;(&deg;C)</label>
			<input type="text" class="form-control input-sm" name="mash0_temp" />
		</div>
		
		<div class="col-xs-3 col-sm-2 col-md-1">
			<label class="label-sm">Time</label>
			<input type="text" class="form-control input-sm" name="mash0_time" />
		</div>
		
	</div>
	
	<?php
	$ingredient = "'mash'";
	for ($i=1; $i<=4; $i++)
	{
		echo '<div class="row">';
		
		echo '<div class="col-xs-3 col-sm-2 col-md-2">';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="1" step="1" name="mash' . $i . '_step" /> ';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="text" class="form-control input-sm" name="mash' . $i . '_temp" /> ';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-1">';
		echo '<input type="text" class="form-control input-sm" name="mash' . $i . '_time" /> ';
		echo '</div>';
		
		// the mash id
		echo '<input type="hidden" name="mash' . $i . '_id" value="'; echo $mash[$i]['id']; echo '"/> ';
		
		echo '</div>';
	}
	?>
	
</fieldset>
</div>

<div class="row tab-pane fade" id="fermentation">
<fieldset class="fieldset col-xs-12 col-md-12 five-ingredients">

	<div class="row">
	
		<div class="col-xs-6 col-sm-2 col-md-1">
			<label class="label-sm">Step</label>
		</div>
		
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
		echo '<div class="row">';
		
		echo '<div class="col-xs-3 col-sm-2 col-md-1">';
		echo '<input type="number" class="form-control input-sm" min="1" step="1" name="fermentation' . $i . '_step" /> ';
		echo '</div>';

		echo '<div class="col-xs-3 col-sm-2 col-md-2">';
		echo '<input type="text" class="form-control input-sm" name="fermentation' . $i . '_start_date" /> ';
		echo '</div>';

		echo '<div class="hidden-xs col-sm-2 col-md-2">';
		echo '<input type="text" class="form-control input-sm" name="fermentation' . $i . '_end_date" /> ';
		echo '</div>';
		
		echo '<div class="hidden-xs col-sm-2 col-md-1">';
		echo '<input type="text" class="form-control input-sm" name="fermentation' . $i . '_temp" /> ';
		echo '</div>';
		
		echo '<div class="hidden-xs col-sm-2 col-md-1">';
		echo '<input type="text" class="form-control input-sm" name="fermentation' . $i . '_measured_sg" /> ';
		echo '</div>';
		
		// the fermentation id
		echo '<input type="hidden" name="fermentation' . $i . '_id" value="'; echo $fermentation[$i]['id']; echo '"/> ';
		
		echo '</div>';
	}
	?>
	
</fieldset>
</div>

<div class="row tab-pane fade" id="packaging">
<fieldset class="fieldset col-xs-12 col-md-12">

	<div class="row">
	
		<div class="col-xs-6 col-sm-3 col-md-2">
			<label class="label-sm">Keg or Bottle</label>
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

</div>

<button type="submit" class="btn btn-default">Save</button>

</form>

</div>

<?php
include ('includes/footer.html');
?>
