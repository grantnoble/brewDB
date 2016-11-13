<?php

/*
brew_view.php
View a brew in the database
*/

$page_title = 'View Brew';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// retrieve the brew details
// check that the 'id' variable is set in URL and it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
// get the recipe details
include('includes/get_brew_details.php');
}
// else if the id isn't set, or isn't valid, redirect back to list brews page
else
{
	echo '<script type="text/javascript">
	window.location = "brews_list.php"
	</script>';
}

// end of PHP section, now create the HTML form
?>

<div class="container">

<h2>View Brew</h2>

<form role="form" class="form-horizontal" name="brewform" action="brew_view.php" method="post">

<div class="row">

<fieldset class="col-xs-12 col-sm-6 col-md-8">

<div class="well">
<legend>Brew Details</legend>

	<div class="row margin-bottom-1em">

		<div class="col-xs-4 col-md-3">
			<label for="name" class="label-sm">Brew Name</label>
			<input type="text" class="form-control input-sm" id="name" name="name" readonly="yes" value="<?php echo $details['name']; ?>" />
		</div>

		<div class="col-xs-4 col-md-3">
			<label for="base_recipe" class="label-sm">Base Recipe</label>
			<input type="text" class="form-control input-sm" id="base_recipe" name="base_recipe" readonly="yes" value="<?php echo $details['base_recipe']; ?>" />
		</div>

		<div class="col-xs-4 col-md-3">
			<label for="style" class="label-sm">Style</label>
			<input type="text" class="form-control input-sm" id="style" name="style" readonly="yes" value="<?php echo $style['name']; ?>" />
		</div>

		<div class="col-xs-4 col-md-3">
			<label for="type" class="label-sm">Type</label>
			<input type="text" class="form-control input-sm" id="type" name="type" readonly="yes" value="<?php echo $details['type']; ?>" />
		</div>

	</div>

	<div class="row margin-bottom-1em">

		<div class="col-xs-2 col-md-2">
			<label for="batch_number" class="label-sm">Batch Number</label>
			<input type="text" class="form-control input-sm" id="batch_number" name="batch_number" readonly="yes" value="<?php echo $details['batch_number']; ?>" />
		</div>

		<div class="col-xs-5 col-sm-4 col-md-3">
			<label for="date" class="label-sm">Date (yyyy-mm-dd)</label>
			<input type="date" class="form-control input-sm" id="date" name="date" readonly="yes" value="<?php echo $details['date']; ?>" />
		</div>

		<div class="col-xs-3 col-md-4">
			<label for="brew_method" class="label-sm">Brew Method</label>
			<input type="text" class="form-control input-sm" id="brew_method" name="brew_method" readonly="yes" value="<?php echo $details['brew_method']; ?>" />
		</div>

		<div class="col-xs-3 col-md-3">
			<label for="no_chill" class="label-sm">No Chill?</label>
			<input type="text" class="form-control input-sm" id="no_chill" name="no_chill" readonly="yes" value="<?php echo $details['no_chill']; ?>" />
		</div>

	</div>

	<div class="row margin-bottom-1em">

		<div class="col-xs-4 col-sm-4 col-md-2">
			<label for="mash_volume" class="label-sm">Mash Vol (L)</label>
			<input type="number" class="form-control input-sm" min="0" step=".1" id="mash_volume" name="mash_volume" readonly="yes" value="<?php echo $details['mash_volume']; ?>" />
		</div>
		<div class="col-xs-4 col-sm-4 col-md-2">
			<label for="sparge_volume" class="label-sm">Sparge Vol (L)</label>
			<input type="number" class="form-control input-sm" min="0" step=".1" id="sparge_volume" name="sparge_volume" readonly="yes" value="<?php echo $details['sparge_volume']; ?>" />
		</div>
		<div class="col-xs-4 col-sm-4 col-md-2">
			<label for="boil_size" class="label-sm">Boil Size (L)</label>
			<input type="number" class="form-control input-sm" min="0" step=".1" id="boil_size" name="boil_size" readonly="yes" value="<?php echo $details['boil_size']; ?>" />
		</div>
		<div class="col-xs-4 col-sm-4 col-md-2">
			<label for="boil_time" class="label-sm">Boil Time</label>
			<input type="number" class="form-control input-sm" min="0" step="1" id="boil_time" name="boil_time" readonly="yes" value="<?php echo $details['boil_time']; ?>" />
		</div>
		<div class="col-xs-4 col-sm-4 col-md-2">
			<label for="batch_size" class="label-sm">Batch Size (L)</label>
			<input type="number" class="form-control input-sm" min="0" step=".1" id="batch_size" name="batch_size" readonly="yes" value="<?php echo $details['batch_size']; ?>" />
		</div>
		<div class="col-xs-4 col-sm-4 col-md-2">
			<label for="mash_efficiency" class="label-sm">Mash Eff (%)</label>
			<input type="number" class="form-control input-sm" min="0" step=".01" id="mash_efficiency" name="mash_efficiency" readonly="yes" value="<?php echo $details['mash_efficiency']; ?>" />
		</div>

	</div>

	<div class="row">

		<div class="hidden-xs col-sm-3 col-md-3">
			<label for="brewer" class="label-sm">Brewer</label>
			<input type="text" class="form-control input-sm" id="brewer" name="brewer" readonly="yes" value="<?php echo $details['brewer']; ?>" />
		</div>

		<div class="col-xs-12 col-md-9">
			<label for="notes" class="label-sm">Brew Notes</label>
			<textarea class="form-control input-sm" rows=2 cols=100 id="notes" name="notes" readonly="yes" value="<?php echo $details['notes']; ?>"></textarea>
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
			<input type="text" class="form-control input-sm padding-5px" id="style_og_min" name="style_og_min" readonly="yes" value="<?php echo $style['og_min']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="est_og" name="est_og" readonly="yes" value="<?php echo $details['est_og']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="act_og" name="act_og"  readonly="yes" value="<?php echo $details['act_og']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_og_max" name="style_og_max" readonly="yes" value="<?php echo $style['og_max']; ?>" />
		</div>

	</div>

	<div class="row margin-bottom-qtr-em">

		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">FG</label>
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_fg_min" name="style_fg_min" readonly="yes" value="<?php echo $style['fg_min']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="est_fg" name="est_fg" readonly="yes" value="<?php echo $details['est_fg']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="act_fg" name="act_fg" readonly="yes" value="<?php echo $details['act_fg']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_fg_max" name="style_fg_max" readonly="yes" value="<?php echo $style['fg_max']; ?>" />
		</div>

	</div>

	<div class="row margin-bottom-qtr-em">

		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">ABV&nbsp;(%)</label>
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_abv_min" name="style_abv_min" readonly="yes" value="<?php echo $style['abv_min']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="est_abv" name="est_abv" readonly="yes" value="<?php echo $details['est_abv']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="act_abv" name="act_abv" readonly="yes" value="<?php echo $details['act_abv']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_abv_max" name="style_abv_max" readonly="yes" value="<?php echo $style['abv_max']; ?>" />
		</div>

	</div>

	<div class="row margin-bottom-qtr-em">

		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">IBU</label>
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_ibu_min" name="style_ibu_min" readonly="yes" value="<?php echo $style['ibu_min']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="est_ibu" name="est_ibu" readonly="yes" value="<?php echo $details['est_ibu']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_ibu_max" name="style_ibu_max" readonly="yes" value="<?php echo $style['ibu_max']; ?>" />
		</div>

	</div>

	<div class="row">

		<div class="col-xs-2 col-md-5ths">
			<label class="label-sm">Color&nbsp;(L)</label>
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_color_min" name="style_color_min" readonly="yes" value="<?php echo $style['color_min']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="est_color" name="est_color" readonly="yes" value="<?php echo $details['est_color']; ?>" />
		</div>

		<div class="col-xs-2 col-md-5ths">
		</div>

		<div class="col-xs-2 col-md-5ths">
			<input type="text" class="form-control input-sm padding-5px" id="style_color_max" name="style_color_max" readonly="yes" value="<?php echo $style['color_max']; ?>" />
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
		if ($fermentables[$i]['name'])
		{
			echo '<div class="row margin-bottom-qtr-em">';

			echo '<div class="col-xs-6 col-sm-2 col-md-3">';
			echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_name" readonly="yes" value="' . $fermentables[$i]['name'] . '" />';
			echo '</div>';

			echo '<div class="col-xs-3 col-sm-2 col-md-1">';
			echo '<input type="number" class="form-control input-sm" min="0" step="0.001" name="fermentable' . $i . '_amount" readonly="yes" value="' . $fermentables[$i]['amount'] . '"/>';
			echo '</div>';

			echo '<div class="hidden-xs col-sm-2 col-md-1">';
			echo '<input type="number" class="form-control input-sm" name="fermentable' . $i . '_percent" readonly="yes" value="' . $fermentables[$i]['percent'] . '" />';
			echo '</div>';

			echo '<div class="hidden-xs col-sm-2 col-md-1">';
			echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_yield" readonly="yes" value="' . $fermentables[$i]['yield'] . '" />';
			echo '</div>';

			echo '<div class="hidden-xs col-sm-2 col-md-1">';
			echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_color" readonly="yes" value="' . $fermentables[$i]['color'] . '" />';
			echo '</div>';

			echo '<div class="col-xs-3 col-sm-2 col-md-1">';
			echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_type" readonly="yes" value="' . $fermentables[$i]['type'] . '" />';
			echo '</div>';

			echo '<div class="col-xs-3 col-sm-2 col-md-2">';
			echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_use" readonly="yes" value="' . $fermentables[$i]['use'] . '" />';
			echo '</div>';

			// the fermentable id
			echo '<input type="hidden" name="fermentable' . $i . '_id" value="' . $fermentables[$i]['id'] . '"/> ';

			echo '</div>';
		}
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
		if ($fermentables[$i]['name'])
		{
			echo '<div class="row margin-bottom-qtr-em">';

			echo '<div class="col-xs-6 col-sm-2 col-md-3">';
			echo '<input type="text" class="form-control input-sm" name="hop' . $i . '_name" readonly="yes" value="' . $hops[$i]['name'] . '" />';
			echo '</div>';

			echo '<div class="col-xs-3 col-sm-2 col-md-1">';
			echo '<input type="number" class="form-control input-sm" name="hop' . $i . '_amount" readonly="yes" value="' . $hops[$i]['amount'] . '" />';
			echo '</div>';

			echo '<div class="hidden-xs col-sm-2 col-md-1">';
			echo '<input type="number" class="form-control input-sm" name="hop' . $i . '_alpha" readonly="yes" value="' . $hops[$i]['alpha'] . '" />';
			echo '</div>';

			echo '<div class="col-xs-3 col-sm-2 col-md-1">';
			echo '<input type="number" class="form-control input-sm" name="hop' . $i . '_time" readonly="yes" value="' . $hops[$i]['time'] . '" />';
			echo '</div>';

			echo '<div class="hidden-xs col-sm-2 col-md-2">';
			echo '<input type="text" class="form-control input-sm" name="hop' . $i . '_form" readonly="yes" value="' . $hops[$i]['form'] . '"/>';
			echo '</div>';

			echo '<div class="hidden-xs col-sm-2 col-md-2">';
			echo '<input type="text" class="form-control input-sm" name="hop' . $i . '_use" readonly="yes" value="' . $hops[$i]['use'] . '"/>';
			echo '</div>';

			// the hops id
			echo '<input type="hidden" name="hop' . $i . '_id" value="' . $hops[$i]['id'] . '"/> ';

			echo '</div>';
		}
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
		if ($yeasts[$i]['fullname'])
		{
			echo '<div class="row margin-bottom-qtr-em">';

			echo '<div class="col-xs-6 col-sm-3 col-md-3">';
			echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_fullname" readonly="yes" value="' . $yeasts[$i]['fullname'] . '"/>';
			echo '</div>';

			echo '<div class="col-xs-3 col-sm-3 col-md-2">';
			echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_type" readonly="yes" value="' . $yeasts[$i]['type'] . '"/>';
			echo '</div>';

			echo '<div class="col-xs-3 col-sm-3 col-md-2">';
			echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_form" readonly="yes" value="' . $yeasts[$i]['form'] . '"/>';
			echo '</div>';

			echo '<div class="col-xs-3 col-sm-3 col-md-2">';
			echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_attenuation" readonly="yes" value="' . $yeasts[$i]['attenuation'] . '"/>';
			echo '</div>';

			echo '<div class="col-xs-3 col-sm-3 col-md-2">';
			echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_flocculation" readonly="yes" value="' . $yeasts[$i]['flocculation'] . '"/>';
			echo '</div>';

			// the yeast id
			echo '<input type="hidden" name="yeast' . $i . '_id" value="' . $yeasts[$i]['id'] . '"/> ';

			echo '</div>';
		}
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
		if ($miscs[$i]['name'])
		{
			echo '<div class="row margin-bottom-qtr-em">';

			echo '<div class="col-xs-6 col-sm-2 col-md-3">';
			echo '<input type="text" class="form-control input-sm" name="misc' . $i . '_name" readonly="yes" value="' . $miscs[$i]['name'] . '"/>';
			echo '</div>';

			echo '<div class="hidden-xs col-sm-2 col-md-2">';
			echo '<input type="text" class="form-control input-sm" name="misc' . $i . '_type" readonly="yes" value="' . $miscs[$i]['type'] . '"/> ';
			echo '</div>';

			echo '<div class="col-xs-3 col-sm-2 col-md-1">';
			echo '<input type="text" class="form-control input-sm" name="misc' . $i . '_amount" readonly="yes" value="' . $miscs[$i]['amount'] . '"/> ';
			echo '</div>';

			echo '<div class="col-xs-3 col-sm-2 col-md-1">';
			echo '<input type="text" class="form-control input-sm" name="misc' . $i . '_unit" readonly="yes" value="' . $miscs[$i]['unit'] . '"/> ';
			echo '</div>';

			echo '<div class="hidden-xs col-sm-2 col-md-2">';
			echo '<input type="text" class="form-control input-sm" name="misc' . $i . '_use" readonly="yes" value="' . $miscs[$i]['use'] . '"/> ';
			echo '</div>';

			// the miscs id
			echo '<input type="hidden" name="misc' . $i . '_id" value="' . $miscs[$i]['id'] . '"/> ';

			echo '</div>';
		}
	}
	?>

</fieldset>
</div>

<div class="row tab-pane fade" id="mash">
<fieldset class="fieldset col-xs-12 col-md-12 five-ingredients">

	<div class="row">

		<div class="col-xs-3 col-sm-2 col-md-1">
			<label class="label-sm">Temp&nbsp;(&deg;C)</label>
		</div>

		<div class="col-xs-3 col-sm-2 col-md-1">
			<label class="label-sm">Time</label>
		</div>

	</div>

	<?php
	$ingredient = "'mash'";
	for ($i=0; $i<=4; $i++)
	{
		if ($mashes[$i]['temp'] || $mashes[$i]['time'])
		{
			echo '<div class="row margin-bottom-qtr-em">';

			echo '<div class="col-xs-3 col-sm-2 col-md-1">';
			echo '<input type="number" class="form-control input-sm" name="mash' . $i . '_temp" readonly="yes" value="' . $mashes[$i]['temp'] . '"/> ';
			echo '</div>';

			echo '<div class="hidden-xs col-sm-2 col-md-1">';
			echo '<input type="number" class="form-control input-sm" name="mash' . $i . '_time" readonly="yes" value="' . $mashes[$i]['time'] . '"/> ';
			echo '</div>';

			// the mash id
			echo '<input type="hidden" name="mash' . $i . '_id" value="' . $mashes[$i]['id'] . '"/> ';

			echo '</div>';
		}
	}
	?>

</fieldset>
</div>

<div class="row tab-pane fade" id="fermentation">
<fieldset class="fieldset col-xs-12 col-md-12 five-ingredients">

	<div class="row">

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
		if ($fermentations[$i]['start_date'] || $fermentations[$i]['end_date'] || $fermentations[$i]['temp'] || $fermentations[$i]['measured_sg'])
		{
			echo '<div class="row margin-bottom-qtr-em">';

			echo '<div class="col-xs-3 col-sm-2 col-md-2">';
			echo '<input type="date" class="form-control input-sm" name="fermentation' . $i . '_start_date" readonly="yes" value="' . $fermentations[$i]['start_date'] . '"/> ';
			echo '</div>';

			echo '<div class="hidden-xs col-sm-2 col-md-2">';
			echo '<input type="date" class="form-control input-sm" name="fermentation' . $i . '_end_date" readonly="yes" value="' . $fermentations[$i]['end_date'] . '"/> ';
			echo '</div>';

			echo '<div class="hidden-xs col-sm-2 col-md-1">';
			echo '<input type="text" class="form-control input-sm" name="fermentation' . $i . '_temp" readonly="yes" value="' . $fermentations[$i]['temp'] . '"/> ';
			echo '</div>';

			echo '<div class="hidden-xs col-sm-2 col-md-1">';
			echo '<input type="text" class="form-control input-sm" name="fermentation' . $i . '_measured_sg" readonly="yes" value="' . $fermentations[$i]['measured_sg'] . '"/> ';
			echo '</div>';

			// the fermentation id
			echo '<input type="hidden" name="fermentation' . $i . '_id" value="' . $fermentations[$i]['start_date'] . '"/> ';

			echo '</div>';
		}
	}
	?>

</fieldset>
</div>

<div class="row tab-pane fade" id="packaging">
<fieldset class="fieldset col-xs-12 col-md-12">

	<div class="row">

		<div class="col-xs-6 col-sm-3 col-md-2">
			<label class="label-sm">Bottle or Keg</label>
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

	echo '<div class="row margin-bottom-qtr-em">';

	echo '<div class="col-xs-3 col-sm-2 col-md-2">';
	echo '<input type="text" class="form-control input-sm" name="packaging" readonly="yes" value="' . $details['packaging'] . '"/> ';
	echo '</div>';

	echo '<div class="col-xs-3 col-sm-3 col-md-2">';
	echo '<input type="date" class="form-control input-sm" name="packaging_date" readonly="yes" value="' . $details['packaging_date'] . '"/> ';
	echo '</div>';

	echo '<div class="col-xs-3 col-sm-3 col-md-2">';
	echo '<input type="number" class="form-control input-sm" name="vol_co2" readonly="yes" value="' . $details['vol_co2'] . '"/> ';
	echo '</div>';

	echo '</div>';
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
