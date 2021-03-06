<?php

/* 
style_view.php
View a style in the database
*/

$page_title = 'View Style';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['style_id']) && is_numeric($_GET['style_id']))
{
    // get id value
    $style_id = $_GET['style_id'];
 
    // get the style
    $query = "SELECT * FROM styles WHERE style_id='" . $style_id . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection)); 
 
}
// if id isn't set, or isn't valid, redirect back to view page
else
{
    header("Location: styles_list.php");
}

while($row = mysqli_fetch_array( $result ))
{
    $id = $row['style_id'];
    $guide = $row['style_guide'];
	$category = $row['style_category'];
	$subcategory = $row['style_subcategory'];
	$category_name = $row['style_category_name'];
    $name = $row['style_name'];
    $type = $row['style_type'];
	$og_min = $row['style_og_min'];
	$og_max = $row['style_og_max'];
	$fg_min = $row['style_fg_min'];
	$fg_max = $row['style_fg_max'];
	$ibu_min = $row['style_ibu_min'];
	$ibu_max = $row['style_ibu_max'];
	$color_min = $row['style_color_min'];
	$color_max = $row['style_color_max'];
	$abv_min = $row['style_abv_min'];
	$abv_max = $row['style_abv_max'];
    $notes = $row['style_notes'];
    $profile = $row['style_profile'];
    $ingredients = $row['style_ingredients'];
    $examples = $row['style_examples'];
}


?>
<div class="container">

	<h2>View Style</h2>

	<div class="well">

		<form role="form" class="form-horizontal" name="styleform" action="style_view.php" method="post">
	
			<!-- xs and sm media -->
			<div class="form-group margin-bottom visible-xs visible-sm">
				<div class="col-xs-4">
					<label for="guide" class="label-sm">Guide</label>
					<input type="text" class="form-control input-sm" id="guide" name="guide" readonly="yes" value="<?php echo $guide; ?>" />
				</div>
				<div class="col-xs-3">
					<label for="category" class="label-sm">Category</label>
					<input type="text" class="form-control input-sm" id="category" name="category" readonly="yes" value="<?php echo $category; ?>" />
				</div>
				<div class="col-xs-5">
					<label for="category_name" class="label-sm">Category Name</label>
					<input type="text" class="form-control input-sm" id="category_name" name="category_name" readonly="yes" value="<?php echo $category_name; ?>" />
				</div>
			</div>
			<div class="form-group margin-bottom visible-xs visible-sm">
				<div class="col-xs-12">
					<label for="category_notes" class="label-sm">Category Notes</label>
					<textarea class="form-control input-sm" rows="2" id="category_notes" name="category_notes" readonly="yes"><?php echo $category_notes; ?></textarea>
				</div>
			</div>
			<div class="form-group margin-bottom visible-xs visible-sm">
				<div class="col-xs-3">
					<label for="subcategory" class="label-sm">Subcategory</label>
					<input type="text" class="form-control input-sm" id="subcategory" name="subcategory" readonly="yes" value="<?php echo $subcategory; ?>" />
				</div>
				<div class="col-xs-5">
					<label for="name" class="label-sm">Style Name</label>
					<input type="text" class="form-control input-sm" id="name" name="name" readonly="yes" value="<?php echo $name; ?>" />
				</div>
				<div class="col-xs-4">
					<label for="type" class="label-sm">Style Type</label>
					<input type="text" class="form-control input-sm" id="type" name="type" readonly="yes" value="<?php echo $type; ?>" />
				</div>
			</div> 
			
			<!-- md media and larger -->
			<div class="form-group margin-bottom hidden-xs hidden-sm">
				<div class="col-md-2">
					<label for="guide" class="label-sm">Guide</label>
					<input type="text" class="form-control input-sm" id="guide" name="guide" readonly="yes" value="<?php echo $guide; ?>" />
				</div>
				<div class="col-md-2">
					<label for="category" class="label-sm">Category</label>
					<input type="text" class="form-control input-sm" id="category" name="category" readonly="yes" value="<?php echo $category; ?>" />
				</div>
				<div class="col-md-3">
					<label for="category_name" class="label-sm">Category Name</label>
					<input type="text" class="form-control input-sm" id="category_name" name="category_name" readonly="yes" value="<?php echo $category_name; ?>" />
				</div>
			</div>
			<div class="form-group margin-bottom hidden-xs hidden-sm">
				<div class="col-md-12">
					<label for="category_notes" class="label-sm">Category Notes</label>
					<textarea class="form-control input-sm" rows="2" id="category_notes" name="category_notes" readonly="yes"><?php echo $category_notes; ?></textarea>
				</div>
			</div>
			<div class="form-group margin-bottom hidden-xs hidden-sm">
				<div class="col-md-2">
					<label for="subcategory" class="label-sm">Subcategory</label>
					<input type="text" class="form-control input-sm" id="subcategory" name="subcategory" readonly="yes" value="<?php echo $subcategory; ?>" />
				</div>
				<div class="col-md-2">
					<label for="name" class="label-sm">Style Name</label>
					<input type="text" class="form-control input-sm" id="name" name="name" readonly="yes" value="<?php echo $name; ?>" />
				</div>
				<div class="col-md-2">
					<label for="type" class="label-sm">Style Type</label>
					<input type="text" class="form-control input-sm" id="type" name="type" readonly="yes" value="<?php echo $type; ?>" />
				</div>
			</div> 
			<div class="form-group margin-bottom">
				<div class="col-xs-3 col-md-2">
					<label for="og_min" class="label-sm">OG Min</label>
					<input type="text" class="form-control input-sm" id="og_min" name="og_min" readonly="yes" value="<?php echo $og_min; ?>" />
				</div>
				<div class="col-xs-3 col-md-2">
					<label for="og_max" class="label-sm">OG Max</label>
					<input type="text" class="form-control input-sm" id="og_max" name="og_max" readonly="yes" value="<?php echo $og_max; ?>" />
				</div>
				<div class="col-xs-3 col-md-2">
					<label for="fg_min" class="label-sm">FG Min</label>
					<input type="text" class="form-control input-sm" id="fg_min" name="fg_min" readonly="yes" value="<?php echo $fg_min; ?>" />
				</div>
				<div class="col-xs-3 col-md-2">
					<label for="fg_max" class="label-sm">FG Max</label>
					<input type="text" class="form-control input-sm" id="fg_max" name="fg_max" readonly="yes" value="<?php echo $fg_max; ?>" />
				</div>
			</div> 
			<div class="form-group margin-bottom">
				<div class="col-xs-3 col-md-2">
					<label for="ibu_min" class="label-sm">IBU Min</label>
					<input type="text" class="form-control input-sm" id="ibu_min" name="ibu_min" readonly="yes" value="<?php echo $ibu_min; ?>" />
				</div>
				<div class="col-xs-3 col-md-2">
					<label for="ibu_max" class="label-sm">IBU Max</label>
					<input type="text" class="form-control input-sm" id="ibu_max" name="ibu_max" readonly="yes" value="<?php echo $ibu_max; ?>" />
				</div>
				<div class="col-xs-3 col-md-2">
					<label for="color_min" class="label-sm">Color Min</label>
					<input type="text" class="form-control input-sm" id="color_min" name="color_min" readonly="yes" value="<?php echo $color_min; ?>" />
				</div>
				<div class="col-xs-3 col-md-2">
					<label for="color_max" class="label-sm">Color Max</label>
					<input type="text" class="form-control input-sm" id="color_max" name="color_max" readonly="yes" value="<?php echo $color_max; ?>" />
				</div>
			</div> 
			<div class="form-group margin-bottom">
				<div class="col-xs-3 col-md-2">
					<label for="abv_min" class="label-sm">ABV Min</label>
					<input type="text" class="form-control input-sm" id="abv_min" name="abv_min" readonly="yes" value="<?php echo $abv_min; ?>" />
				</div>
				<div class="col-xs-3 col-md-2">
					<label for="abv_max" class="label-sm">ABV Max</label>
					<input type="text" class="form-control input-sm" id="abv_max" name="abv_max" readonly="yes" value="<?php echo $abv_max; ?>" />
				</div>
			</div>
			<div class="form-group margin-bottom">
				<div class="col-xs-12">
					<label for="notes" class="label-sm">Notes</label>
					<textarea class="form-control input-sm" rows="2" id="notes" name="notes" readonly="yes"><?php echo $notes; ?></textarea>
				</div>
			</div>
			<div class="form-group margin-bottom">
				<div class="col-xs-12">
					<label for="profile" class="label-sm">Profile</label>
					<textarea class="form-control input-sm" rows="3" id="profile" name="profile" readonly="yes"><?php echo $profile; ?></textarea>
				</div>
			</div>
			<div class="form-group margin-bottom">
				<div class="col-xs-12">
					<label for="ingredients" class="label-sm">Ingredients</label>
					<textarea class="form-control input-sm" rows="2" id="ingredients" name="ingredients" readonly="yes"><?php echo $ingredients; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12">
					<label for="examples" class="label-sm">Examples</label>
					<textarea class="form-control input-sm" rows="2" id="examples" name="examples" readonly="yes"><?php echo $examples; ?></textarea>
				</div>
			</div>

		</form>

	</div><!-- well -->

</div><!-- container -->

<?php 
include '../includes/footer.html';
?>
