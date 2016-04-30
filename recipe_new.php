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
	$query = "INSERT INTO recipes (recipe_name, recipe_type, recipe_style_id, recipe_batch_size, recipe_mash_efficiency, recipe_designer, recipe_notes, recipe_est_og, recipe_est_fg, recipe_est_color, recipe_est_ibu, recipe_est_abv, recipe_date)
		VALUES ('" . $details['name'] . "','" .  $details['type'] . "'," . $details['style_id'] . "," . $details['batch_size'] . "," .  $details['mash_efficiency'] . ",'" . $details['designer'] . "','" . $details['notes'] . "'," . $details['est_og'] . "," . $details['est_fg'] . "," . $details['est_color'] . "," . $details['est_ibu'] . "," . $details['est_abv'] . ",'" . $details['date'] . "')";
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
	for ($i=0; $i <=4; $i++)
	{
		if ($miscs[$i]['name'])
		{
			$query = "INSERT INTO recipes_miscs (recipe_misc_recipe_id, recipe_misc_misc_id, recipe_misc_amount, recipe_misc_unit)
					VALUES (" . $recipe_id . "," . $miscs[$i]['id'] . "," . $miscs[$i]['amount'] . ",'" . $miscs[$i]['unit'] . "')";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		}
	}

    // After saving to the database, redirect back to the new recipe page
    header("Location: recipe_new.php");
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

<h2>New Recipe</h2>

<form role="form" name="recipeform" action="recipe_new.php" onsubmit="return validate_form()" method="post">

<div class="row">
<div class="seven_cols">
<div class="float_left">
<fieldset>
	<legend>Recipe Details</legend>
	
	<label>Name*: </label>
	<input type="text" name="name" size=25 required oninvalid="this.setCustomValidity('Recipe name required.')" onchange="this.setCustomValidity('')" /> 
	
	<label>Style*: </label>
	<select name="style" required oninvalid="this.setCustomValidity('Recipe style required.')" onchange="this.setCustomValidity('');getstyleinfo(this.value);">
		<option></option>
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
		<option></option>
		<option>All Grain</option>
		<option>Extract</option>
		<option>Partial Mash</option>
	</select>
	
	<p></p>
	
	<label>Date (yyyy-mm-dd): </label>
	<input type="date" name="date" size=8 value="<?php $date = date("Y-m-d");echo $date; ?>"/>
	
	<?php
	// retrieve batch size and efficiency preferences
	$query = "SELECT * FROM preferences ORDER BY preference_id DESC LIMIT 1";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	while ($row = mysqli_fetch_array ( $result ))
	{
		$boil_size = $row['preference_boil_size'];
		$boil_time = $row['preference_boil_time'];
		$evaporation_rate = $row['preference_evaporation_rate'];
		$mash_efficiency = $row['preference_mash_efficiency'];
		$loss = $row['preference_loss'];
		$batch_size = $boil_size - ($evaporation_rate * $boil_time / 60) - $loss;
	}
	?>
	
	<label>Batch Size (L)*: </label>
	<input type="number" min="0" step="0.5" size=5 style="width: 5em" name="batch_size" required oninvalid="this.setCustomValidity('Batch size required.')" onchange="this.setCustomValidity('');calc_og_color_ibu();" value="<?php echo $batch_size; ?>"/>
	
	<input type="hidden" name="mash_efficiency" onchange="this.setCustomValidity('');calc_og_color_ibu();" value="<?php echo $mash_efficiency; ?>"/>
	
	<label>Designer: </label>
	<input list="persons" name="designer">
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
	<textarea rows=2 cols=100 name="notes"></textarea>
	
</fieldset>
</div><!-- float_left -->
</div><!-- seven_cols -->

<div class="five_cols">
<div class="float_left">
<fieldset>
    <legend>Style Characteristics</legend>
    <table class="list_table">
        <tr><td>&nbsp;</td><td>Low</td><td>Est.</td><td>High</td></tr>
            <td>OG</td>
            <td><input type="text" name="style_og_min" size=6 readonly="yes" /></td>
            <td><input type="text" name="est_og" size=6 readonly="yes" /></td>
            <td><input type="text" name="style_og_max" size=6 readonly="yes" /></td>
        </tr>
        <tr>
            <td>FG</td>
            <td><input type="text" name="style_fg_min" size=6 readonly="yes" /></td>
            <td><input type="text" name="est_fg" size=6 readonly="yes" /></td>
            <td><input type="text" name="style_fg_max" size=6 readonly="yes" /></td>
        </tr>
        <tr>
            <td>ABV %&nbsp;</td>
            <td><input type="text" name="style_abv_min" size=6 readonly="yes" /></td>
            <td><input type="text" name="est_abv" size=6 readonly="yes" /></td>
            <td><input type="text" name="style_abv_max" size=6 readonly="yes" /></td>
        </tr>
        <tr>
            <td>IBU</td>
            <td><input type="text" name="style_ibu_min" size=6 readonly="yes" /></td>
            <td><input type="text" name="est_ibu" size=6 readonly="yes" /></td>
            <td><input type="text" name="style_ibu_max" size=6 readonly="yes" /></td>
        </tr>
        <tr>
            <td>Color</td>
            <td><input type="text" name="style_color_min" size=6 readonly="yes" /></td>
            <td><input type="text" name="est_color" size=6 readonly="yes" /></td>
            <td><input type="text" name="style_color_max" size=6 readonly="yes" /></td>
        </tr>
    </table>
</fieldset>
</div><!-- float_left -->
</div><!-- five_cols -->
</div><!-- row -->

<div class="row">
<div class="six_cols">
<div class="float_left">
<fieldset>
    <legend>Fermentables</legend>
	<div class="five_ingredients">
    <table>
        <tr><td>Fermentable</td><td>Amount&nbsp;(kg)*</td><td>Yield&nbsp;(%)</td><td>Colour&nbsp;(L)</td><td>Use</td></tr>
        <?php
        for ($i=0; $i<=14; $i++)
        {
            echo '<tr>';
            echo '<td><select name="fermentable' . $i . '_name" onchange="getfermentableinfo(this.value,' .$i. ')">';
            echo '<option></option>';
            $query = "SELECT fermentable_name FROM fermentables ORDER BY fermentable_name";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
            while ($row = mysqli_fetch_array ( $result ))
            {
                echo '<option>' . $row['fermentable_name'] . '</option>';
            }
            echo '</select></td>';
            echo '<td><input type="number" min="0" step="0.1" size=5 style="width: 5em" name="fermentable' . $i . '_amount" onchange="fermentables_messages(' .$i. '); calc_og_color_ibu();" /> </td>';
            echo '<td><input type="text" size=6 readonly="yes" name="fermentable' . $i . '_yield" onchange="fermentables_messages(' .$i. '); calc_og_color_ibu();" /> </td>';
            echo '<td><input type="text" size=6 readonly="yes" name="fermentable' . $i . '_color" onchange="fermentables_messages(' .$i. '); calc_color();" /> </td>';
            echo '<td><select name="fermentable' . $i . '_use">';
            echo '<option></option>';
            echo '<option>Mashed</option>';
            echo '<option>Steeped</option>';
            echo '<option>Extract</option>';
            echo '<option>Sugar</option>';
            echo '<option>Other</option>';
            echo '</select></td>';
			echo '<td><input type="hidden" name="fermentable' . $i . '_id" /> </td>';
            echo '</tr>';
        }
        ?>
    </table>
	</div>
</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->

<div class="six_cols">
<div class="float_left">
<fieldset>
	<legend>Hops</legend>
	<div class="five_ingredients">
	<table>
   	<tr><td>Hop</td><td>Amount&nbsp;(g)*</td><td>Alpha&nbsp;(%)*</td><td>Time&nbsp;(min)*</td><td>Form</td><td>Use</td></tr>
		<?php
		for ($i=0; $i<=14; $i++)
		{
			echo '<tr>';
			echo '<td><select name="hop' . $i . '_name" onchange="gethopinfo(this.value,' .$i. ')">';
         echo '<option></option>';
         $query = "SELECT hop_name FROM hops ORDER BY hop_name";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			while ($row = mysqli_fetch_array ( $result ))
			{
				echo '<option>' . $row['hop_name'] . '</option>';
			}
			echo '</select></td>';
			echo '<td><input type="number" min="0" step="1" size=5 style="width: 5em" name="hop' . $i . '_amount" onchange="hops_messages(' .$i. '); calc_ibu();" /> </td>';
			echo '<td><input type="number" min="0" step="0.1" size=5 style="width: 5em" name="hop' . $i . '_alpha" onchange="hops_messages(' .$i. '); calc_ibu();" /> </td>';
			echo '<td><input type="number" min="0" step="1" size=5 style="width: 5em" name="hop' . $i . '_time" onchange="hops_messages(' .$i. '); calc_ibu();" /> </td>';
			echo '<td><select name="hop' . $i . '_form">';
			echo '<option></option>';
			echo '<option>Pellet</option>';
			echo '<option>Plug</option>';
			echo '<option>Whole</option>';
			echo '</select></td>';
			echo '<td><select name="hop' . $i . '_use">';
			echo '<option></option>';
			echo '<option>Aroma</option>';
			echo '<option>Boil</option>';
			echo '<option>Dry Hop</option>';
			echo '<option>First Wort</option>';
			echo '<option>Mash</option>';
			echo '</select></td>';
			echo '<td><input type="hidden" name="hop' . $i . '_id" /> </td>';
			echo '</tr>';
		}
		?>
	</table>
	</div>
</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->
</div><!-- row -->

<div class="row">
<div class="six_cols">
<div class="float_left">
<fieldset>
	<legend>Yeast</legend>
	<table>
		<tr><td>Name</td><td>Type</td><td>Form</td><td>Atten.&nbsp;(%)</td><td>Floc.</td></tr>
		<tr>
			<td><select name="yeast0_fullname" onchange="getyeastinfo(this.value)">
			<option></option>
			<?php
			$query = "SELECT yeast_laboratory, yeast_product_id, yeast_name FROM yeasts ORDER BY yeast_laboratory, yeast_name";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			while ($row = mysqli_fetch_array ( $result ))
			{
				echo '<option>' . $row['yeast_laboratory'] . ' ' . $row['yeast_product_id'] . ' ' . $row['yeast_name'] . '</option>';
			}
			?>
			</select></td>
			<td><input type="text" name="yeast0_type" size=6 readonly="yes" /></td>
			<td><input type="text" name="yeast0_form" size=6 readonly="yes" /></td>
			<td><input type="text" name="yeast0_attenuation" size=6 readonly="yes" /></td>
			<td><input type="text" name="yeast0_flocculation" size=6 readonly="yes" /></td>
			<td><input type="hidden" name="yeast0_id" /> </td>
			<td><input type="hidden" name="yeast0_laboratory" /></td>
			<td><input type="hidden" name="yeast0_product_id" /></td>
			<td><input type="hidden" name="yeast0_name" /></td>
		</tr>
	</table>
</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->

<div class="six-cols">
<div class="float_left">
<fieldset>
	<legend>Misc. Ingredients</legend>
	<div class="three_ingredients">
	<table>
		<tr><td>Name</td><td>Amount*</td><td>Unit*</td><td>Type</td></tr>
		<?php
		for ($i=0; $i<=4; $i++)
		{
			echo '<tr>';
			echo '<td><select name="misc' . $i . '_name" onchange="getmiscinfo(this.value,' .$i. ')">';
			echo '<option></option>';
         $query = "SELECT misc_name FROM miscs ORDER BY misc_name";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			while ($row = mysqli_fetch_array ( $result ))
			{
				echo '<option>' . $row['misc_name'] . '</option>';
			}
			echo '</select></td>';
         	echo '<td><input type="number" min="0" step="0.1" size=5 style="width: 5em" name="misc' . $i . '_amount" onchange="miscs_messages(' .$i. ');"/> </td>';
         	echo '<td><input type="text" name="misc' . $i . '_unit" size=6 onchange="miscs_messages(' .$i. ');"/> </td>';
			echo '<td><input type="text" name="misc' . $i . '_type" size=15 readonly="yes" /> </td>';
			echo '<td><input type="hidden" name="misc' . $i . '_id" /> </td>';
			echo '</tr>';
		}
		?>
	</table>
	</div>
</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->
</div><!-- row -->

<div class="row">
<input class="button" type="submit" value="Save" />
</div><!-- row -->

</form>

<?php
include ('includes/footer.html');
?>
