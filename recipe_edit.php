<?php

/*
recipe_edit.php
Edit a recipe in the database
*/

$page_title = 'Edit Recipe';
$error = "";
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
	for ($i=0; $i <=14; $i++)
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
	for ($i=0; $i <=14; $i++)
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
	$yeasts[0]['id'] = mysqli_real_escape_string($connection, test_input($_POST['yeast0_id']));
	$yeasts[0]['fullname'] = mysqli_real_escape_string($connection, test_input($_POST['yeast0_fullname']));
	$yeasts[0]['product_id'] = mysqli_real_escape_string($connection, test_input($_POST['yeast0_product_id']));
	$yeasts[0]['record_id'] = mysqli_real_escape_string($connection, test_input($_POST['yeast0_record_id']));
	$yeasts[0]['flag'] = mysqli_real_escape_string($connection, test_input($_POST['yeast0_flag']));

	// retrieve the recipe misc ingredients
	for ($i=0; $i <=4; $i++)
	{
		$miscs[$i]['id'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_id']));
		$miscs[$i]['name'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_name']));
		$miscs[$i]['amount'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_amount']));
		$miscs[$i]['unit'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_unit']));
		$miscs[$i]['type'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_type']));
		$miscs[$i]['record_id'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_record_id']));
		$miscs[$i]['flag'] = mysqli_real_escape_string($connection, test_input($_POST['misc' . $i . '_flag']));
	}

	// now update the records in the database

	// update the recipe record
	$query = "UPDATE recipes SET recipe_name='" . $details['name'] . "', recipe_type='" . $details['type'] . "', recipe_style_id='" . $details['style_id'] . "', recipe_batch_size=" . $details['batch_size'] . ", recipe_mash_efficiency=" . $details['mash_efficiency'] . ", recipe_designer='" . $details['designer'] . "', recipe_notes='" . $details['notes'] . "', recipe_est_og=" . $details['est_og'] . ", recipe_est_fg=" . $details['est_fg'] . ", recipe_est_color=" . $details['est_color'] . ", recipe_est_ibu=" . $details['est_ibu'] . ", recipe_est_abv=" . $details['est_abv'] . ", recipe_date='" . $details['date'] . "' WHERE recipe_id='" . $details['id'] . "'";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

	// for each fermentable, do the update process
	for ($i=0; $i <=14; $i++)
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
	for ($i=0; $i <=14; $i++)
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
				$query = "INSERT INTO recipes_hops (recipe_hop_recipe_id, recipe_hop_hop_id, recipe_hop_amount, recipe_hop_use, recipe_hop_time, recipe_hop_form) VALUES ('" . $details['id'] . "','" . $hops[$i]['id'] . "'," . $hops[$i]['amount'] . ",'" . $hops[$i]['use'] . "'," . $hops[$i]['time'] . ",'" . $hops[$i]['form'] . "')";
			}
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}


	// for each yeast, do the update process
	for ($i=0; $i <=0; $i++)
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
	for ($i=0; $i <=4; $i++)
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
				$query = "UPDATE recipes_miscs SET recipe_misc_misc_id='" . $miscs[$i]['id'] . "', recipe_misc_amount='" . $miscs[$i]['amount'] . "', recipe_misc_unit='" . $miscs[$i]['unit'] . "' WHERE recipe_misc_id='" . $miscs[$i]['record_id'] . "'";
			}
			// else if !record_id and name, INSERT
			elseif ((!$miscs[$i]['record_id']) && $miscs[$i]['name'])
			{
				$query = "INSERT INTO recipes_miscs (recipe_misc_recipe_id, recipe_misc_misc_id, recipe_misc_amount, recipe_misc_unit) VALUES ('" . $details['id'] . "','" . $miscs[$i]['id'] . "'," . $miscs[$i]['amount'] . ",'" . $miscs[$i]['unit'] . "')";
			}
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

	// After saving to the database, redirect back to the new recipe page
    header("Location: recipes_list.php");

	// some required fields are empty so display the error message
	if (false)
	{
		end:
		echo '<p class="error">' . $error . '</p>';
	}
}

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
	// get id value, that is, the recipe_id
	$recipe_id = $_GET['id'];

	// get the basic recipe details
	$query = "SELECT * FROM recipes WHERE recipe_id='" . $recipe_id . "'";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	while($row = mysqli_fetch_array( $result ))
	{
		$details['id'] = $row['recipe_id'];
		$details['name'] = $row['recipe_name'];
		$details['type'] = $row['recipe_type'];
		$details['style_id'] = $row['recipe_style_id'];
		$details['boil_size'] = $row['recipe_boil_size'];
		$details['boil_time'] = $row['recipe_boil_time'];
		$details['batch_size'] = $row['recipe_batch_size'];
		$details['mash_efficiency'] = $row['recipe_mash_efficiency'];
		$details['designer'] = $row['recipe_designer'];
		$details['notes'] = $row['recipe_notes'];
		$details['date'] = $row['recipe_date'];
		$details['est_og'] = $row['recipe_est_og'];
		$details['est_fg'] = $row['recipe_est_fg'];
		$details['est_color'] = $row['recipe_est_color'];
		$details['est_ibu'] = $row['recipe_est_ibu'];
		$details['ibu_method'] = $row['recipe_ibu_method'];
		$details['est_abv'] = $row['recipe_est_abv'];
	}

	// get the recipe style details
	$query = "SELECT * FROM styles WHERE style_id='" . $details['style_id'] . "'";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	while($row = mysqli_fetch_array( $result ))
	{
		$style['name'] = $row['style_name'];
		$style['og_min'] = $row['style_og_min'];
		$style['og_max'] = $row['style_og_max'];
		$style['fg_min'] = $row['style_fg_min'];
		$style['fg_max'] = $row['style_fg_max'];
		$style['ibu_min'] = $row['style_ibu_min'];
		$style['ibu_max'] = $row['style_ibu_max'];
		$style['color_min'] = $row['style_color_min'];
		$style['color_max'] = $row['style_color_max'];
		$style['abv_min'] = $row['style_abv_min'];
		$style['abv_max'] = $row['style_abv_max'];
	}

	// get the recipe fermentable details
	// if less than 15 fermentables, set the remaining values to NULL
    $query = "SELECT * FROM recipes_fermentables WHERE recipe_fermentable_recipe_id='" . $recipe_id . "' ORDER BY recipe_fermentable_amount DESC";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	for ($i=0; $i<=14; $i++)
	{
		if($row = mysqli_fetch_array( $result ))
		{
			$fermentables[$i]['record_id'] = $row['recipe_fermentable_id'];
			$fermentables[$i]['id'] = $row['recipe_fermentable_fermentable_id'];
			$fermentables[$i]['amount'] = $row['recipe_fermentable_amount'];
			$fermentables[$i]['use'] = $row['recipe_fermentable_use'];

			$query = "SELECT * FROM fermentables WHERE fermentable_id='" . $fermentables[$i]['id'] . "'";
			$result2 = mysqli_query($connection, $query) or die(mysqli_error($connection));
			while($row2 = mysqli_fetch_array( $result2 ))
			{
				$fermentables[$i]['name'] = $row2['fermentable_name'];
				$fermentables[$i]['yield'] = $row2['fermentable_yield'];
				$fermentables[$i]['color'] = $row2['fermentable_color'];
			}
		}
		else
		{
			$fermentables[$i]['record_id'] = NULL;
			$fermentables[$i]['id'] = NULL;
			$fermentables[$i]['amount'] = NULL;
			$fermentables[$i]['use'] = NULL;
			$fermentables[$i]['name'] = NULL;
			$fermentables[$i]['yield'] = NULL;
			$fermentables[$i]['color'] = NULL;
		}
		// for each of the 15 possible fermentables, set an update flag to 0
		$fermentables[$i]['flag'] = 0;
	}

	// get the recipe hop details
	// if less than 15 hops, set the remaining values to NULL
    $query = "SELECT * FROM recipes_hops WHERE recipe_hop_recipe_id='" . $recipe_id . "' ORDER BY recipe_hop_time DESC, recipe_hop_amount DESC";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	for ($i=0; $i<=14; $i++)
	{
		if($row = mysqli_fetch_array( $result ))
		{
			$hops[$i]['record_id'] = $row ['recipe_hop_id'];
			$hops[$i]['id'] = $row ['recipe_hop_hop_id'];
			$hops[$i]['amount'] = $row ['recipe_hop_amount'];
			$hops[$i]['alpha'] = $row ['recipe_hop_alpha'];
			$hops[$i]['use'] = $row ['recipe_hop_use'];
			$hops[$i]['time'] = $row ['recipe_hop_time'];
			$hops[$i]['form'] = $row ['recipe_hop_form'];

			$query = "SELECT hop_name FROM hops WHERE hop_id='" . $hops[$i]['id'] . "'";
			$result2 = mysqli_query($connection, $query) or die(mysqli_error($connection));
			while($row2 = mysqli_fetch_array( $result2 ))
			{
				$hops[$i]['name'] = $row2['hop_name'];
			}
		}
		else
		{
			$hops[$i]['record_id'] = NULL;
			$hops[$i]['id'] = NULL;
			$hops[$i]['amount'] = NULL;
			$hops[$i]['use'] = NULL;
			$hops[$i]['time'] = NULL;
			$hops[$i]['form'] = NULL;
			$hops[$i]['name'] = NULL;
			$hops[$i]['alpha'] = NULL;
		}
		// for each of the 15 possible hops, set an update flag to 0
		$hops[$i]['flag'] = 0;
	}

	// get the recipe yeast details
	// if less than 1 yeasts, set the remaining values to NULL
    $query = "SELECT * FROM recipes_yeasts WHERE recipe_yeast_recipe_id='" . $recipe_id . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	for ($i=0; $i<=0; $i++)
	{
		if($row = mysqli_fetch_array( $result ))
		{
			$yeasts[$i]['record_id'] = $row['recipe_yeast_id'];
			$yeasts[$i]['id'] = $row['recipe_yeast_yeast_id'];

			$query = "SELECT * FROM yeasts WHERE yeast_id='" . $yeasts[$i]['id'] . "'";
			$result2 = mysqli_query($connection, $query) or die(mysqli_error($connection));
			while($row2 = mysqli_fetch_array( $result2 ))
			{
				$yeasts[$i]['fullname'] = $row2['yeast_fullname'];
				$yeasts[$i]['type'] = $row2['yeast_type'];
				$yeasts[$i]['form'] = $row2['yeast_form'];
				$yeasts[$i]['attenuation'] = $row2['yeast_attenuation'];
				$yeasts[$i]['flocculation'] = $row2['yeast_flocculation'];
			}
		}
		else
		{
			$yeasts[$i]['record_id'] = NULL;
			$yeasts[$i]['id'] = NULL;
			$yeasts[$i]['fullname'] = NULL;
			$yeasts[$i]['form'] = NULL;
			$yeasts[$i]['attenuation'] = NULL;
			$yeasts[$i]['flocculation'] = NULL;
		}
		// for each of the possible yeasts, set an update flag to 0
		$yeasts[$i]['flag'] = 0;
	}

	// get the recipe misc details
	// if less than 5 miscs, set the remaining values to NULL
    $query = "SELECT * FROM recipes_miscs WHERE recipe_misc_recipe_id='" . $recipe_id . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	for ($i=0; $i<=4; $i++)
	{
		if($row = mysqli_fetch_array( $result ))
		{
			$miscs[$i]['record_id'] = $row['recipe_misc_id'];
			$miscs[$i]['id'] = $row['recipe_misc_misc_id'];
			$miscs[$i]['amount'] = $row['recipe_misc_amount'];
			$miscs[$i]['unit'] = $row['recipe_misc_unit'];

			$query = "SELECT * FROM miscs WHERE misc_id='" . $miscs[$i]['id'] . "'";
			$result2 = mysqli_query($connection, $query) or die(mysqli_error($connection));
			while($row2 = mysqli_fetch_array( $result2 ))
			{
				$miscs[$i]['name'] = $row2['misc_name'];
				$miscs[$i]['type'] = $row2['misc_type'];
			}
		}
		else
		{
			$miscs[$i]['record_id'] = NULL;
			$miscs[$i]['id'] = NULL;
			$miscs[$i]['amount'] = NULL;
			$miscs[$i]['unit'] = NULL;
			$miscs[$i]['name'] = NULL;
			$miscs[$i]['type'] = NULL;
		}
		// for each of the 4 possible miscs, set an update flag to 0
		$miscs[$i]['flag'] = 0;
	}
}
// else if id isn't set, or isn't valid, redirect back to view page
else
{
    header("Location: recipes_list.php");
}

// end of PHP section, now create the HTML form
?>

<!--scripts to validate the entire form if browser not HTML5 compatible-->
<script src="js_files/validate_form.js"></script>
<script src="js_files/validate_details.js"></script>
<script src="js_files/validate_fermentables.js"></script>
<script src="js_files/validate_hops.js"></script>
<script src="js_files/validate_miscs.js"></script>

<!--scripts to retrieve info from the styles, fermentables, hops, yeasts, and miscs tables-->
<script src="js_files/getstyleinfo.js"></script>
<script src="js_files/getfermentableinfo.js"></script>
<script src="js_files/gethopinfo.js"></script>
<script src="js_files/getyeastinfo.js"></script>
<script src="js_files/getmiscinfo.js"></script>

<!--scripts to set custom messages for invalid fields in fermentables, hops, and miscs sections-->
<script src="js_files/fermentables_messages.js"></script>
<script src="js_files/hops_messages.js"></script>
<script src="js_files/miscs_messages.js"></script>

<!--scripts to calculate og, color, ibu, batch and boil sizes-->
<script src="js_files/calc_og.js"></script>
<script src="js_files/calc_color.js"></script>
<script src="js_files/calc_ibu.js"></script>
<script src="js_files/calc_og_color_ibu.js"></script>
<script src="js_files/calc_batch_size.js"></script>
<script src="js_files/calc_boil_size.js"></script>

<!--script to set the changed flag-->
<script src="js_files/set_flag.js"></script>

<script src="js_files/validator.min.js"></script>

<div class="container">
	
<h2>Edit Recipe</h2>

<form role="form" class="form-horizontal" name="recipeform" action="recipe_edit.php" method="post">

<input type="hidden" name="id" value="<?php echo $details['id']; ?>" />
<fieldset class="fieldset col-md-6">
<legend class="fieldset">Recipe Details</legend>
	<div class="form-group margin-bottom">
		<div class="col-xs-4 col-md-4">
			<label for="name" class="label-sm">Recipe Name</label>
			<input type="text" class="form-control input-sm" id="name" name="name" required value="<?php echo $details['name']; ?>" />
		</div>
		
		<div class="col-xs-4 col-md-5">
			<label for="style" class="label-sm">Style</label>
			<select class="form-control input-sm" id="style" name="style" required >
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

	<div class="form-group margin-bottom">
		<div class="col-xs-4 col-md-4">
			<label for="date" class="label-sm">Date (yyyy-mm-dd)</label>
			<input type="date" class="form-control input-sm" id="name" name="date" value="<?php echo $details['date']; ?>"/>
		</div>
		
		<div class="col-xs-4 col-md-3">
			<label for="batch_size" class="label-sm">Batch Size (L)</label>
			<input type="number" class="form-control input-sm" min="0" step="1" id="batch_size" name="batch_size" required value="<?php echo $details['batch_size']; ?>"/>
		</div>
		
			<input type="hidden" name="mash_efficiency" required oninvalid="this.setCustomValidity('Mash efficiency required.')" onchange="this.setCustomValidity('');calc_og_color_ibu();" value="<?php echo $details['mash_efficiency']; ?>"/>
	
		<div class="col-xs-4 col-md-5">
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
	
	<div class="form-group margin-bottom">
		<div class="col-xs-12 col-md-12">
			<label for="notes" class="label-sm">Recipe Notes</label>
			<textarea  class="form-control input-sm" rows=2 cols=100 id="notes" name="notes"><?php echo $details['notes']; ?></textarea>
		</div>
	</div>
</fieldset>

<fieldset class="fieldset col-md-5">
<legend class="fieldset">Style Characteristics</legend>
	<div class="form-group margin-bottom">
	</div>
</fieldset>


<fieldset>
    <legend>Recipe Details</legend>
    
	<label>Name*: </label>
	<input type="text" name="name" size=25 required oninvalid="this.setCustomValidity('Recipe name required.')" onchange="this.setCustomValidity('')" value="<?php echo $details['name']; ?>" /> 
	
	<label>Style*: </label>
	<select name="style" required oninvalid="this.setCustomValidity('Recipe style required.')" onchange="this.setCustomValidity('');getstyleinfo(this.value);">
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
	
	<label>Type*: </label>
	<select name="type" required oninvalid="this.setCustomValidity('Recipe type required.')" onchange="this.setCustomValidity('')">
		<option><?php echo $details['type']; ?></option>
		<option>All Grain</option>
		<option>Extract</option>
		<option>Partial Mash</option>
	</select>
	
	<p></p>
	
	<label>Date (yyyy-mm-dd): </label>
	<input type="date" name="date" size=8 value="<?php echo $details['date']; ?>"/>
	
	<label>Batch Size (L)*: </label>
	<input type="number" min="0" step="1" size=5 style="width: 5em" name="batch_size" required oninvalid="this.setCustomValidity('Batch size required.')" onchange="this.setCustomValidity('');calc_og_color_ibu();" value="<?php echo $details['batch_size']; ?>"/>
	
	<input type="hidden" name="mash_efficiency" required oninvalid="this.setCustomValidity('Mash efficiency required.')" onchange="this.setCustomValidity('');calc_og_color_ibu();" value="<?php echo $details['mash_efficiency']; ?>"/>
	
	<label>Designer: </label>
	<input list="persons" name="designer" value="<?php echo $details['designer']; ?>"/>
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
	
	<p></p>
	
	<label>Recipe Notes:<br> </label>
	<textarea rows=2 cols=100 name="notes"><?php echo $details['notes']; ?></textarea>
	
</fieldset>

<fieldset>
    <legend>Style Characteristics</legend>
    <table class="list_table">
        <tr><td>&nbsp;</td><td>Low</td><td>Est.</td><td>High</td></tr>
        <tr>
            <td>OG</td>
            <td><input type="text" name="style_og_min" size=6 readonly="yes" value="<?php echo $style['og_min']; ?>" /></td>
            <td><input type="text" name="est_og" size=6 readonly="yes" value="<?php echo number_format($details['est_og'],3); ?>" /></td>
            <td><input type="text" name="style_og_max" size=6 readonly="yes" value="<?php echo $style['og_max']; ?>" /></td>
        </tr>
        <tr>
            <td>FG</td>
            <td><input type="text" name="style_fg_min" size=6 readonly="yes" value="<?php echo $style['fg_min']; ?>" /></td>
            <td><input type="text" name="est_fg" size=6 readonly="yes" value="<?php echo number_format($details['est_fg'],3); ?>" /></td>
            <td><input type="text" name="style_fg_max" size=6 readonly="yes" value="<?php echo $style['fg_max']; ?>" /></td>
        </tr>
        <tr>
            <td>ABV %&nbsp;</td>
            <td><input type="text" name="style_abv_min" size=6 readonly="yes" value="<?php echo $style['abv_min']; ?>" /></td>
            <td><input type="text" name="est_abv" size=6 readonly="yes" value="<?php echo $details['est_abv']; ?>" /></td>
            <td><input type="text" name="style_abv_max" size=6 readonly="yes" value="<?php echo $style['abv_max']; ?>" /></td>
        </tr>
        <tr>
            <td>IBU</td>
            <td><input type="text" name="style_ibu_min" size=6 readonly="yes" value="<?php echo $style['ibu_min']; ?>" /></td>
            <td><input type="text" name="est_ibu" size=6 readonly="yes" value="<?php echo $details['est_ibu']; ?>" /></td>
            <td><input type="text" name="style_ibu_max" size=6 readonly="yes" value="<?php echo $style['ibu_max']; ?>" /></td>
        </tr>
        <tr>
            <td>Color</td>
            <td><input type="text" name="style_color_min" size=6 readonly="yes" value="<?php echo $style['color_min']; ?>" /></td>
            <td><input type="text" name="est_color" size=6 readonly="yes" value="<?php echo $details['est_color']; ?>" /></td>
            <td><input type="text" name="style_color_max" size=6 readonly="yes" value="<?php echo $style['color_max']; ?>" /></td>
        </tr>
    </table>
</fieldset>

<fieldset>
    <legend>Fermentables</legend>
	<div class="five_ingredients">
    <table>
        <tr><td>Fermentable</td><td>Amount&nbsp;(kg)*</td><td>Yield&nbsp;(%)</td><td>Colour&nbsp;(L)</td><td>Use</td></tr>
		<?php
		$ingredient = "'fermentable'";
		for ($i=0; $i<=14; $i++)
		{
			echo '<tr>';
			echo '<td><select name="fermentable' . $i . '_name" onchange="getfermentableinfo(this.value,' .$i. '); set_flag(' . $ingredient . ', ' . $i . ');">';
			echo '<option>'; echo $fermentables[$i]['name']; echo '</option>';
			$query = "SELECT fermentable_name FROM fermentables ORDER BY fermentable_name";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			while ($row = mysqli_fetch_array ( $result ))
			{
				echo '<option>' . $row['fermentable_name'] . '</option>';
			}
			echo '</select></td>';
			echo '<td><input type="number" min="0" step="0.1" size=5 style="width: 5em" name="fermentable' . $i . '_amount" onchange="fermentables_messages(' .$i. '); calc_og_color_ibu(); set_flag(' . $ingredient . ', ' . $i . ');" value="'; echo $fermentables[$i]['amount']; echo '"/> </td>';
			echo '<td><input type="text" name="fermentable' . $i . '_yield" size=6 readonly="yes" onchange="fermentables_messages(' .$i. '); calc_og_color_ibu(); set_flag(' . $ingredient . ', ' . $i . ');" value="'; echo $fermentables[$i]['yield']; echo '"/> </td>';
			echo '<td><input type="text" name="fermentable' . $i . '_color" size=6 readonly="yes" onchange="fermentables_messages(' .$i. '); calc_color(); set_flag(' . $ingredient . ', ' . $i . ');" value="'; echo $fermentables[$i]['color']; echo '"/> </td>';
			echo '<td><select name="fermentable' . $i . '_use" onchange="set_flag(' . $ingredient . ', ' . $i . ')">';
			echo '<option>'; echo $fermentables[$i]['use']; echo '</option>';
			echo '<option>Mashed</option>';
			echo '<option>Steeped</option>';
			echo '<option>Extract</option>';
			echo '<option>Sugar</option>';
			echo '<option>Other</option>';
			echo '</select></td>';
			// the recipes_fermentables record id
			echo '<td><input type="hidden" name="fermentable' . $i . '_record_id" value="'; echo $fermentables[$i]['record_id']; echo '"/> </td>';
			// the fermentable id
			echo '<td><input type="hidden" name="fermentable' . $i . '_id" value="'; echo $fermentables[$i]['id']; echo '"/> </td>';
			// the update flag
			echo '<td><input type="hidden" name="fermentable' . $i . '_flag" value="'; echo $fermentables[$i]['flag']; echo '"/> </td>';
			echo '</tr>';
		}
		?>
	</table>
	</div>
</fieldset>

<fieldset>
	<legend>Hops</legend>
	<div class="five_ingredients">
	<table>
   	<tr><td>Hop</td><td>Amount&nbsp;(g)*</td><td>Alpha&nbsp;(%)*</td><td>Time&nbsp;(min)*</td><td>Form</td><td>Use</td></tr>
		<?php
		$ingredient = "'hop'";
		for ($i=0; $i<=14; $i++)
		{
			echo '<tr>';
			echo '<td><select name="hop' . $i . '_name" onchange="gethopinfo(this.value,' .$i. '); set_flag(' . $ingredient . ', ' . $i . ');">';
			echo '<option>'; echo $hops[$i]['name']; echo '</option>';
			$query = "SELECT hop_name FROM hops ORDER BY hop_name";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			while ($row = mysqli_fetch_array ( $result ))
			{
				echo '<option>' . $row['hop_name'] . '</option>';
			}
			echo '</select></td>';
			echo '<td><input type="number" min="0" step="any" size=5 style="width: 5em" name="hop' . $i . '_amount" onchange="hops_messages(' .$i. '); calc_ibu(); set_flag(' . $ingredient . ', ' . $i . ');" value="'; echo $hops[$i]['amount']; echo '"/> </td>';
			echo '<td><input type="number" min="0" step="0.1" size=5 style="width: 5em" name="hop' . $i . '_alpha" onchange="hops_messages(' .$i. '); calc_ibu(); set_flag(' . $ingredient . ', ' . $i . ');" value="'; echo $hops[$i]['alpha']; echo '"/> </td>';
			echo '<td><input type="number" min="0" step="1" size=5 style="width: 5em" name="hop' . $i . '_time" onchange="hops_messages(' .$i. '); calc_ibu(); set_flag(' . $ingredient . ', ' . $i . ');" value="'; echo $hops[$i]['time']; echo '"/> </td>';
			echo '<td><select name="hop' . $i . '_form" onchange="set_flag(' . $ingredient . ', ' . $i . ')">';
			echo '<option>'; echo $hops[$i]['form']; echo '</option>';
			echo '<option>Pellet</option>';
			echo '<option>Plug</option>';
			echo '<option>Whole</option>';
			echo '</select></td>';
			echo '<td><select name="hop' . $i . '_use" onchange="set_flag(' . $ingredient . ', ' . $i . ')">';
			echo '<option>'; echo $hops[$i]['use']; echo '</option>';
			echo '<option>Aroma</option>';
			echo '<option>Boil</option>';
			echo '<option>Dry Hop</option>';
			echo '<option>First Wort</option>';
			echo '<option>Mash</option>';
			echo '</select></td>';
			// the recipes_hops record id
			echo '<td><input type="hidden" name="hop' . $i . '_record_id" value="'; echo $hops[$i]['record_id']; echo '"/> </td>';
			// the hops id
			echo '<td><input type="hidden" name="hop' . $i . '_id" value="'; echo $hops[$i]['id']; echo '"/> </td>';
			// the update flag
			echo '<td><input type="hidden" name="hop' . $i . '_flag" value="'; echo $hops[$i]['flag']; echo '"/> </td>';
			echo '</tr>';
		}
		?>
	</table>
	</div>
</fieldset>

<fieldset>
	<legend>Yeast</legend>
	<table>
		<tr><td>Name</td><td>Type</td><td>Form</td><td>Atten.&nbsp;(%)</td><td>Floc.</td></tr>
		<?php
		$ingredient = "'yeast'";
		for ($i=0; $i<=0; $i++)
		{
			echo '<tr>';
			echo '<td><select name="yeast0_fullname" onchange="getyeastinfo(this.value); set_flag(' . $ingredient . ', ' . $i . ');">';
			echo '<option>'; echo $yeasts[$i]['fullname']; echo '</option>';
			$query = "SELECT yeast_fullname FROM yeasts ORDER BY yeast_fullname";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			while ($row = mysqli_fetch_array ( $result ))
			{
				echo '<option>' . $row['yeast_fullname'] . '</option>';
			}
			echo '</select></td>';
			echo '<td><input type="text" name="yeast' . $i . '_type" size=6 readonly="yes" value="'; echo $yeasts[$i]['type']; echo '"/></td>';
			echo '<td><input type="text" name="yeast' . $i . '_form" size=6 readonly="yes" value="'; echo $yeasts[$i]['form']; echo '"/></td>';
			echo '<td><input type="text" name="yeast' . $i . '_attenuation" size=6 readonly="yes" value="'; echo $yeasts[$i]['attenuation']; echo '"/></td>';
			echo '<td><input type="text" name="yeast' . $i . '_flocculation" size=6 readonly="yes" value="'; echo $yeasts[$i]['flocculation']; echo '"/></td>';
			// the recipes_yeasts record id
			echo '<td><input type="hidden" name="yeast' . $i . '_record_id" value="'; echo $yeasts[$i]['record_id']; echo '"/> </td>';
			// the yeast id
			echo '<td><input type="hidden" name="yeast' . $i . '_id" value="'; echo $yeasts[$i]['id']; echo '"/> </td>';
			// the update flag
			echo '<td><input type="hidden" name="yeast' . $i . '_flag" value="'; echo $yeasts[$i]['flag']; echo '"/> </td>';
			echo '</tr>';
		}
		?>
	</table>
</fieldset>

<fieldset>
	<legend>Misc. Ingredients</legend>
	<div class="three_ingredients">
	<table>
		<tr><td>Name</td><td>Amount&nbsp;*</td><td>Unit&nbsp;*</td><td>Type</td></tr>
		<?php
		$ingredient = "'misc'";
		for ($i=0; $i<=4; $i++)
		{
			echo '<tr>';
			echo '<td><select name="misc' . $i . '_name" onchange="getmiscinfo(this.value,' .$i. '); set_flag(' . $ingredient . ', ' . $i . ');">';
			echo '<option>'; echo $miscs[$i]['name']; echo '</option>';
         $query = "SELECT misc_name FROM miscs ORDER BY misc_name";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			while ($row = mysqli_fetch_array ( $result ))
			{
				echo '<option>' . $row['misc_name'] . '</option>';
			}
			echo '</select></td>';
         	echo '<td><input type="number" min="0" step="0.1" size=5 style="width: 5em" name="misc' . $i . '_amount" onchange="miscs_messages(' .$i. '); set_flag(' . $ingredient . ', ' . $i . ')" value="'; echo $miscs[$i]['amount']; echo '"/> </td>';
         	echo '<td><input type="text" size=6 name="misc' . $i . '_unit" onchange="miscs_messages(' .$i. '); set_flag(' . $ingredient . ', ' . $i . ')" value="'; echo $miscs[$i]['unit']; echo '"/> </td>';
			echo '<td><input type="text" size=15 name="misc' . $i . '_type" readonly="yes" value="'; echo $miscs[$i]['type']; echo '"/> </td>';
			// the recipes_miscs record id
			echo '<td><input type="hidden" name="misc' . $i . '_record_id" value="'; echo $miscs[$i]['record_id']; echo '"/> </td>';
			// the miscs id
			echo '<td><input type="hidden" name="misc' . $i . '_id" value="'; echo $miscs[$i]['id']; echo '"/> </td>';
			// the update flag
			echo '<td><input type="hidden" name="misc' . $i . '_flag" value="'; echo $miscs[$i]['flag']; echo '"/> </td>';
			echo '</tr>';
		}
		?>
	</table>
	</div>
</fieldset>


<div class="row">
<input class="button" type="submit" value="Save" />
</div><!-- row -->



</form>

</div>

<?php
include ('includes/footer.html');
?>
