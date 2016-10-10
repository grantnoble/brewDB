<?php
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
		$details['ibu_method'] = $row['recipe_ibu_method'];
		$details['designer'] = $row['recipe_designer'];
		$details['notes'] = $row['recipe_notes'];
		$details['date'] = $row['recipe_date'];
		$details['est_og'] = $row['recipe_est_og'];
		$details['est_fg'] = $row['recipe_est_fg'];
		$details['est_color'] = $row['recipe_est_color'];
		$details['est_ibu'] = $row['recipe_est_ibu'];
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
	// add up the total amount of fermentables to be able to calculate percentages
    $query = "SELECT recipe_fermentable_amount FROM recipes_fermentables WHERE recipe_fermentable_recipe_id='" . $recipe_id . "'";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	for ($i=0; $i<=14; $i++)
	{
		if($row = mysqli_fetch_array( $result ))
		{
			$total_amount += $row['recipe_fermentable_amount'];
		}
	}
	
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
			$fermentables[$i]['percent'] = round(($row['recipe_fermentable_amount'] / $total_amount * 100), 2);
			$fermentables[$i]['use'] = $row['recipe_fermentable_use'];

			$query = "SELECT * FROM fermentables WHERE fermentable_id='" . $fermentables[$i]['id'] . "'";
			$result2 = mysqli_query($connection, $query) or die(mysqli_error($connection));
			while($row2 = mysqli_fetch_array( $result2 ))
			{
				$fermentables[$i]['name'] = $row2['fermentable_name'];
				$fermentables[$i]['yield'] = $row2['fermentable_yield'];
				$fermentables[$i]['color'] = $row2['fermentable_color'];
				$fermentables[$i]['type'] = $row2['fermentable_type'];
			}
		}
		else
		{
			$fermentables[$i]['record_id'] = NULL;
			$fermentables[$i]['id'] = NULL;
			$fermentables[$i]['name'] = NULL;
			$fermentables[$i]['amount'] = NULL;
			$fermentables[$i]['percent'] = NULL;
			$fermentables[$i]['yield'] = NULL;
			$fermentables[$i]['color'] = NULL;
			$fermentables[$i]['type'] = NULL;
			$fermentables[$i]['use'] = NULL;
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
	// if less than 15 miscs, set the remaining values to NULL
    $query = "SELECT * FROM recipes_miscs WHERE recipe_misc_recipe_id='" . $recipe_id . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	for ($i=0; $i<=14; $i++)
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
		// for each of the 15 possible miscs, set an update flag to 0
		$miscs[$i]['flag'] = 0;
	}
?>
