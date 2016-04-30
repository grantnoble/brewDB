<?php
// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
    // get id value
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
    $query = "SELECT * FROM recipes_fermentables WHERE recipe_fermentable_recipe_id='" . $recipe_id . "' ORDER BY recipe_fermentable_amount DESC";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$i=0;
	while($row = mysqli_fetch_array( $result ))
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
		$i++;
	}
	$f=$i-1;

	// get the recipe hop details
    $query = "SELECT * FROM recipes_hops WHERE recipe_hop_recipe_id='" . $recipe_id . "' ORDER BY recipe_hop_time DESC, recipe_hop_amount DESC";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$i=0;
	while($row = mysqli_fetch_array( $result ))
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
		$i++;
	}
	$h=$i-1;

	// get the recipe yeast details
    $query = "SELECT * FROM recipes_yeasts WHERE recipe_yeast_recipe_id='" . $recipe_id . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$i=0;
	while($row = mysqli_fetch_array( $result ))
	{
		$yeasts[$i]['record_id'] = $row['recipe_yeast_id'];
		$yeasts[$i]['id'] = $row['recipe_yeast_yeast_id'];

		$query = "SELECT * FROM yeasts WHERE yeast_id='" . $yeasts[$i]['id'] . "'";
		$result2 = mysqli_query($connection, $query) or die(mysqli_error($connection));
		while($row2 = mysqli_fetch_array( $result2 ))
		{
			$yeasts[$i]['name'] = $row2['yeast_name'];
			$yeasts[$i]['product_id'] = $row2['yeast_product_id'];
			$yeasts[$i]['type'] = $row2['yeast_type'];
			$yeasts[$i]['form'] = $row2['yeast_form'];
			$yeasts[$i]['attenuation'] = $row2['yeast_attenuation'];
			$yeasts[$i]['flocculation'] = $row2['yeast_flocculation'];
		}
		$i++;
	}
	$y=$i-1;

	// get the recipe misc details
    $query = "SELECT * FROM recipes_miscs WHERE recipe_misc_recipe_id='" . $recipe_id . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$i=0;
	while($row = mysqli_fetch_array( $result ))
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
		$i++;
	}
	$m=$i-1;


}
// if id isn't set, or isn't valid, redirect back to view page
else
{
    header("Location: recipes_list.php");
}
?>
