<?php

/* 
style_new.php
Create a style in the database
*/

$page_title = 'New Style';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$style['name'] = mysqli_real_escape_string($connection, test_input($_POST['name']));
	$style['type'] = mysqli_real_escape_string($connection, test_input($_POST['type']));
	$style['category'] = mysqli_real_escape_string($connection, test_input($_POST['category']));
	$style['category_number'] = mysqli_real_escape_string($connection, test_input($_POST['category_number']));
	$style['style_letter'] = mysqli_real_escape_string($connection, test_input($_POST['style_letter']));
	$style['style_guide'] = "BJCP";
	$style['og_min'] = mysqli_real_escape_string($connection, test_input($_POST['og_min']));
	if (!$style['og_min'])
	{
		$style['og_min'] = 0;
	}

	$style['og_max'] = mysqli_real_escape_string($connection, test_input($_POST['og_max']));
	if (!$style['og_max'])
	{
		$style['og_max'] = 0;
	}
	$style['fg_min'] = mysqli_real_escape_string($connection, test_input($_POST['fg_min']));
	if (!$style['fg_min'])
	{
		$style['fg_min'] = 0;
	}
	$style['fg_max'] = mysqli_real_escape_string($connection, test_input($_POST['fg_max']));
	if (!$style['fg_max'])
	{
		$style['fg_max'] = 0;
	}
	$style['ibu_min'] = mysqli_real_escape_string($connection, test_input($_POST['ibu_min']));
	if (!$style['ibu_min'])
	{
		$style['ibu_min'] = 0;
	}
	$style['ibu_max'] = mysqli_real_escape_string($connection, test_input($_POST['ibu_max']));
	if (!$style['ibu_max'])
	{
		$style['ibu_max'] = 0;
	}
	$style['abv_min'] = mysqli_real_escape_string($connection, test_input($_POST['abv_min']));
	if (!$style['abv_min'])
	{
		$style['abv_min'] = 0;
	}
	$style['abv_max'] = mysqli_real_escape_string($connection, test_input($_POST['abv_max']));
	if (!$style['abv_max'])
	{
		$style['abv_max'] = 0;
	}
	$style['color_min'] = mysqli_real_escape_string($connection, test_input($_POST['color_min']));
	if (!$style['color_min'])
	{
		$style['color_min'] = 0;
	}
	$style['color_max'] = mysqli_real_escape_string($connection, test_input($_POST['color_max']));
	if (!$style['color_max'])
	{
		$style['color_max'] = 0;
	}
	$style['notes'] = mysqli_real_escape_string($connection, test_input($_POST['notes']));
	$style['profile'] = mysqli_real_escape_string($connection, test_input($_POST['profile']));
	$style['ingredients'] = mysqli_real_escape_string($connection, test_input($_POST['ingredients']));
	$style['examples'] = mysqli_real_escape_string($connection, test_input($_POST['examples']));

    // set up the SQL INSERT
	$columns = "INSERT INTO styles (style_name, style_type, style_category, style_category_number, style_style_letter, style_style_guide, style_og_min, style_og_max, style_fg_min, style_fg_max, style_ibu_min, style_ibu_max, style_abv_min, style_abv_max, style_color_min, style_color_max, style_notes, style_profile, style_ingredients, style_examples) ";
	$values = "VALUES ('" . $style['name'] . "','" .  $style['type'] . "','" . $style['category'] . "','" . $style['category_number'] . "','" . $style['style_letter'] . "','" . $style['style_guide'] . "'," .$style['og_min'] . "," . $style['og_max'] . "," . $style['fg_min'] . "," . $style['fg_max'] . "," . $style['ibu_min'] . "," . $style['ibu_max'] . "," . $style['abv_min'] . "," . $style['abv_max'] . "," . $style['color_min'] . "," . $style['color_max'] . ",'" . $style['notes'] . "','" . $style['profile'] . "','" . $style['ingredients'] . "','" . $style['examples'] . "')";
	$query = $columns . $values;
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	
	// After saving to the database, redirect back to the list hops page 
	header("Location: styles_list.php");

}

// end of PHP section, now create the HTML form

?>
<div class="container">

<h2>New Style</h2>

<form role="form" class="form-horizontal" name="styleform" action="style_new.php" method="post">
	
	<div class="form-group margin-bottom">
		<div class="col-xs-4 col-md-2">
			<label>Style Guide</label>
			<select class="form-control input-sm" id="style_guide" name="style_guide" required >
				<option></option>
				<option>BJCP 2008</option>
				<option>BJCP 2015</option>
			</select>
		</div>
		<div class="col-xs-3 col-md-2">
			<label for="category_number" class="label-sm">Number</label>
			<input type="text" class="form-control input-sm" id="category_number" name="category_number" required />
		</div>
		<div class="col-xs-3 col-md-2">
			<label for="style_letter" class="label-sm">Letter</label>
			<input type="text" class="form-control input-sm" id="style_letter" name="style_letter" required />
		</div>
	</div>
	<div class="form-group margin-bottom">
		<div class="col-xs-4 col-md-4">
			<label for="category" class="label-sm">Category</label>
			<input type="text" class="form-control input-sm" id="category" name="category" required />
		</div>
		<div class="col-xs-4 col-md-4">
			<label for="name" class="label-sm">Style Name</label>
			<input type="text" class="form-control input-sm" id="name" name="name" required />
		</div>
		<div class="col-xs-4 col-md-2">
			<label for="type" class="label-sm">Style Type</label>
			<input type="text" class="form-control input-sm" id="type" name="type" required />
		</div>
	</div> 
	<div class="form-group margin-bottom">
		<div class="col-xs-3 col-md-2">
			<label for="og_min" class="label-sm">OG Min</label>
			<input type="number" class="form-control input-sm" id="og_min" name="og_min" />
		</div>
		<div class="col-xs-3 col-md-2">
			<label for="og_max" class="label-sm">OG Max</label>
			<input type="number" class="form-control input-sm" id="og_max" name="og_max" />
		</div>
		<div class="col-xs-3 col-md-2">
			<label for="fg_min" class="label-sm">FG Min</label>
			<input type="number" class="form-control input-sm" id="fg_min" name="fg_min" />
		</div>
		<div class="col-xs-3 col-md-2">
			<label for="fg_max" class="label-sm">FG Max</label>
			<input type="number" class="form-control input-sm" id="fg_max" name="fg_max" />
		</div>
	</div> 
	<div class="form-group margin-bottom">
		<div class="col-xs-3 col-md-2">
			<label for="ibu_min" class="label-sm">IBU Min</label>
			<input type="number" class="form-control input-sm" id="ibu_min" name="ibu_min" />
		</div>
		<div class="col-xs-3 col-md-2">
			<label for="ibu_max" class="label-sm">IBU Max</label>
			<input type="number" class="form-control input-sm" id="ibu_max" name="ibu_max" />
		</div>
		<div class="col-xs-3 col-md-2">
			<label for="color_min" class="label-sm">Color Min</label>
			<input type="number" class="form-control input-sm" id="color_min" name="color_min" />
		</div>
		<div class="col-xs-3 col-md-2">
			<label for="color_max" class="label-sm">Color Max</label>
			<input type="number" class="form-control input-sm" id="color_max" name="color_max" />
		</div>
	</div> 
	<div class="form-group margin-bottom">
		<div class="col-xs-3 col-md-2">
			<label for="abv_min" class="label-sm">ABV Min</label>
			<input type="number" class="form-control input-sm" id="abv_min" name="abv_min" />
		</div>
		<div class="col-xs-3 col-md-2">
			<label for="abv_max" class="label-sm">ABV Max</label>
			<input type="number" class="form-control input-sm" id="abv_max" name="abv_max" />
		</div>
	</div>
	<div class="form-group margin-bottom">
		<div class="col-xs-12">
			<label for="notes" class="label-sm">Notes</label>
			<textarea class="form-control input-sm" rows="3" id="notes" name="notes"></textarea>
		</div>
	</div>
	<div class="form-group margin-bottom">
		<div class="col-xs-12">
			<label for="profile" class="label-sm">Profile</label>
			<textarea class="form-control input-sm" rows="3" id="profile" name="profile"></textarea>
		</div>
	</div>
	<div class="form-group margin-bottom">
		<div class="col-xs-12">
			<label for="ingredients" class="label-sm">Ingredients</label>
			<textarea class="form-control input-sm" rows="2" id="ingredients" name="ingredients"></textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-12">
			<label for="examples" class="label-sm">Examples</label>
			<textarea class="form-control input-sm" rows="2" id="examples" name="examples"></textarea>
		</div>
	</div>
	
<input class="btn btn-sm btn-primary" type="submit" value="Save" />

</form>

</div><!-- container -->

<?php 
include ('includes/footer.html');
?>
