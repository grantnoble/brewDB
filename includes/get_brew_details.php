<?php
    // get id value
    $brew_id = $_GET['id'];

    // get the basic brew details
    $query = "SELECT * FROM brews WHERE brew_id='" . $brew_id . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	while($row = mysqli_fetch_array( $result ))
	{
		$details['id'] = $row['brew_id'];
		$details['name'] = $row['brew_name'];
		$details['batch_number'] = $row['brew_batch_number'];
		$details['date'] = $row['brew_date'];
		$details['recipe_id'] = $row['brew_recipe_id'];
		$details['type'] = $row['brew_type'];
		$details['style_id'] = $row['brew_style_id'];
		$details['brew_method'] = $row['brew_method'];
		$details['no_chill'] = $row['brew_no_chill'];
		$details['mash_volume'] = $row['brew_mash_volume'];
		$details['sparge_volume'] = $row['brew_sparge_volume'];
		$details['boil_size'] = $row['brew_boil_size'];
		$details['boil_time'] = $row['brew_boil_time'];
		$details['ibu_method'] = $row['brew_ibu_method'];
		$details['batch_size'] = $row['brew_batch_size'];
		$details['mash_efficiency'] = $row['brew_mash_efficiency'];
		$details['brewer'] = $row['brew_brewer'];
		$details['notes'] = $row['brew_notes'];
		$details['est_og'] = $row['brew_est_og'];
		$details['act_og'] = $row['brew_act_og'];
		$details['est_fg'] = $row['brew_est_fg'];
		$details['act_fg'] = $row['brew_act_fg'];
		$details['est_color'] = $row['brew_est_color'];
		$details['est_ibu'] = $row['brew_est_ibu'];
		$details['est_abv'] = $row['brew_est_abv'];
		$details['act_abv'] = $row['brew_act_abv'];
		$details['packaging'] = $row['brew_packaging'];
		$details['vol_co2'] = $row['brew_packaging_vol_co2'];
		$details['packaging_date'] = $row['brew_packaging_date'];
	}

	// get the recipe name
    $query = "SELECT recipe_name FROM recipes WHERE recipe_id='" . $details['recipe_id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	while($row = mysqli_fetch_array( $result ))
	{
		$details['base_recipe'] = $row['recipe_name'];
	}

	// get the brew style details
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

	// get the brew fermentable details
	// add up the total amount of fermentables to be able to calculate percentages
    $query = "SELECT brew_fermentable_amount FROM brews_fermentables WHERE brew_fermentable_brew_id='" . $brew_id . "'";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	for ($i=0; $i<=14; $i++)
	{
		if($row = mysqli_fetch_array( $result ))
		{
			$total_amount += $row['brew_fermentable_amount'];
		}
	}

	// if less than 15 fermentables, set the remaining values to NULL
    $query = "SELECT * FROM brews_fermentables WHERE brew_fermentable_brew_id='" . $brew_id . "' ORDER BY brew_fermentable_amount DESC";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	for ($i=0; $i<=14; $i++)
	{
		if($row = mysqli_fetch_array( $result ))
		{
			$fermentables[$i]['record_id'] = $row['brew_fermentable_id'];
			$fermentables[$i]['id'] = $row['brew_fermentable_fermentable_id'];
			$fermentables[$i]['amount'] = $row['brew_fermentable_amount'];
			$fermentables[$i]['percent'] = round(($row['brew_fermentable_amount'] / $total_amount * 100), 2);
			$fermentables[$i]['use'] = $row['brew_fermentable_use'];

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
    $query = "SELECT * FROM brews_hops WHERE brew_hop_brew_id='" . $brew_id . "' ORDER BY brew_hop_time DESC, brew_hop_amount DESC";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	for ($i=0; $i<=14; $i++)
	{
		if($row = mysqli_fetch_array( $result ))
		{
			$hops[$i]['record_id'] = $row ['brew_hop_id'];
			$hops[$i]['id'] = $row ['brew_hop_hop_id'];
			$hops[$i]['amount'] = $row ['brew_hop_amount'];
			$hops[$i]['alpha'] = $row ['brew_hop_alpha'];
			$hops[$i]['use'] = $row ['brew_hop_use'];
			$hops[$i]['time'] = $row ['brew_hop_time'];
			$hops[$i]['form'] = $row ['brew_hop_form'];

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

	// get the brew yeast details
	// if less than 1 yeasts, set the remaining values to NULL
    $query = "SELECT * FROM brews_yeasts WHERE brew_yeast_brew_id='" . $brew_id . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	for ($i=0; $i<=0; $i++)
	{
		if($row = mysqli_fetch_array( $result ))
		{
			$yeasts[$i]['record_id'] = $row['brew_yeast_id'];
			$yeasts[$i]['id'] = $row['brew_yeast_yeast_id'];

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
			$yeasts[$i]['type'] = NULL;
			$yeasts[$i]['form'] = NULL;
			$yeasts[$i]['attenuation'] = NULL;
			$yeasts[$i]['flocculation'] = NULL;
		}
		// for each of the possible yeasts, set an update flag to 0
		$yeasts[$i]['flag'] = 0;
	}

	// get the brew misc details
	// if less than 15 miscs, set the remaining values to NULL
    $query = "SELECT * FROM brews_miscs WHERE brew_misc_brew_id='" . $brew_id . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	for ($i=0; $i<=14; $i++)
	{
		if($row = mysqli_fetch_array( $result ))
		{
			$miscs[$i]['record_id'] = $row['brew_misc_id'];
			$miscs[$i]['id'] = $row['brew_misc_misc_id'];
			$miscs[$i]['amount'] = $row['brew_misc_amount'];
			$miscs[$i]['unit'] = $row['brew_misc_unit'];
			$miscs[$i]['use'] = $row['brew_misc_use'];

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
			$miscs[$i]['use'] = NULL;
		}
		// for each of the 15 possible miscs, set an update flag to 0
		$miscs[$i]['flag'] = 0;
	}

	// get the brew mash details
	// if less than 5 mash records, set the remaining values to NULL
    $query = "SELECT * FROM brews_mashes WHERE brew_mash_brew_id='" . $brew_id . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	for ($i=0; $i<=14; $i++)
	{
		if($row = mysqli_fetch_array( $result ))
		{
			$mashes[$i]['record_id'] = $row['brew_mash_id'];
			$mashes[$i]['temp'] = $row['brew_mash_temp'];
			$mashes[$i]['time'] = $row['brew_mash_time'];
		}
		else
		{
			$mashes[$i]['record_id'] = NULL;
			$mashes[$i]['temp'] = NULL;
			$mashes[$i]['time'] = NULL;
		}
		// for each of the 15 possible mashes, set an update flag to 0
		$mashes[$i]['flag'] = 0;
	}

	// get the brew fermentation details
	// if less than 5 fermentation records, set the remaining values to NULL
    $query = "SELECT * FROM brews_fermentations WHERE brew_fermentation_brew_id='" . $brew_id . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	for ($i=0; $i<=14; $i++)
	{
		if($row = mysqli_fetch_array( $result ))
		{
			$fermentations[$i]['record_id'] = $row['brew_fermentation_id'];
			$fermentations[$i]['start_date'] = $row['brew_fermentation_start_date'];
			$fermentations[$i]['end_date'] = $row['brew_fermentation_end_date'];
			$fermentations[$i]['temp'] = $row['brew_fermentation_temp'];
			$fermentations[$i]['measured_sg'] = $row['brew_fermentation_measured_sg'];
		}
		else
		{
			$fermentations[$i]['record_id'] = NULL;
			$fermentations[$i]['start_date'] = NULL;
			$fermentations[$i]['end_date'] = NULL;
			$fermentations[$i]['temp'] = NULL;
			$fermentations[$i]['measured_sg'] = NULL;
		}
		// for each of the 15 possible fermentations, set an update flag to 0
		$fermentations[$i]['flag'] = 0;
	}

?>
