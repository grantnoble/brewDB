<?php

/*
recipe_view.php
View a recipe in the database
*/

$page_title = 'View Recipe';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

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
	
	<h2>View Recipe</h2>

	<form role="form" class="form-horizontal" name="recipeform" action="recipe_view.php" method="post">

	<div class="row">

		<fieldset class="col-xs-12 col-sm-6 col-md-8">

		<div class="well">
		
		<legend>Recipe Details</legend>

			<div class="row margin-bottom-1em">
		
				<div class="col-xs-4 col-md-4">
					<label for="name" class="label-sm">Recipe Name</label>
					<input type="text" class="form-control input-sm" id="name" name="name" readonly="yes" value="<?php echo $details['name']; ?>" />
				</div>
		
				<div class="col-xs-4 col-md-5">
					<label for="style" class="label-sm">Style</label>
					<input type="text" class="form-control input-sm" id="style" name="style" readonly="yes" value="<?php echo $style['name']; ?>" />
				</div>
		
				<div class="col-xs-4 col-md-3">
					<label for="type" class="label-sm">Type</label>
					<input type="text" class="form-control input-sm" id="type" name="type" readonly="yes" value="<?php echo $details['type']; ?>" />
				</div>
		
			</div>

			<div class="row margin-bottom-1em">
	
				<div class="col-xs-4 col-sm-4 col-md-2">
					<label for="batch_size" class="label-sm">Batch Size (L)</label>
					<input type="text" class="form-control input-sm" id="batch_size" name="batch_size" readonly="yes" value="<?php echo $details['batch_size']; ?>"/>
				</div>
		
				<div class="col-xs-4 col-sm-4 col-md-2">
					<label for="mash_efficiency" class="label-sm">Mash Eff (%)</label>
					<input type="text" class="form-control input-sm" id="mash_efficiency" name="mash_efficiency" readonly="yes" value="<?php echo $details['mash_efficiency']; ?>"/>
				</div>
		
				<div class="col-xs-5 col-sm-4 col-md-3">
					<label for="date" class="label-sm">Date (yyyy-mm-dd)</label>
					<input type="date" class="form-control input-sm" id="date" name="date" readonly="yes" value="<?php echo $details['date']; ?>"/>
				</div>
		
				<div class="hidden-xs col-sm-4 col-md-5">
					<label for="designer" class="label-sm">Designer</label>
					<input type="text" class="form-control input-sm" id="designer" name="designer" readonly="yes" value="<?php echo $details['designer']; ?>"/>
				</div>
		
			</div>
	
			<div class="row">
		
				<div class="col-xs-12 col-md-12">
					<label for="notes" class="label-sm">Recipe Notes</label>
					<textarea class="form-control input-sm" rows=2 cols=100 id="notes" name="notes" readonly="yes" ><?php echo $details['notes']; ?></textarea>
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
 
			<div class="row">
	
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
 
			<div class="row">
    
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
 
			<div class="row">
	
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
 
			<div class="row">
    
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
				if ($fermentables[$i]['name'])
				{
			?>
			
			<div class="row margin-bottom-half_em">
		
				<div class="col-xs-6 col-sm-2 col-md-3">
					<?php
					echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_name" readonly="yes" value="' . $fermentables[$i]['name'] . '"/>';
					?>
				</div>
			
				<div class="col-xs-3 col-sm-2 col-md-1">
					<?php
					echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_amount" readonly="yes" value="' . $fermentables[$i]['amount'] . '"/>';
					?>
				</div>
			
				<div class="hidden-xs col-sm-2 col-md-1">
					<?php
					echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_percent" readonly="yes" value="' . $fermentables[$i]['percent'] . '"/>';
					?>
				</div>
			
				<div class="hidden-xs col-sm-2 col-md-1">
					<?php
					echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_yield" readonly="yes" value="' . $fermentables[$i]['yield'] . '"/>';
					?>
				</div>
			
				<div class="hidden-xs col-sm-2 col-md-1">
					<?php
					echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_color" readonly="yes" value="' . $fermentables[$i]['color'] . '"/>';
					?>
				</div>
			
				<div class="col-xs-3 col-sm-2 col-md-1">
					<?php
					echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_type" readonly="yes" value="'. $fermentables[$i]['type'] . '"/>';
					?>
				</div>
		
				<div class="col-xs-3 col-sm-2 col-md-2">
					<?php
					echo '<input type="text" class="form-control input-sm" name="fermentable' . $i . '_use" readonly="yes" value="'. $fermentables[$i]['use'] . '"/>';
					?>
				</div>
		
				<?php
				// the recipes_fermentables record id
				echo '<input type="hidden" name="fermentable' . $i . '_record_id" value="'; echo $fermentables[$i]['record_id']; echo '"/>';
				// the fermentable id
				echo '<input type="hidden" name="fermentable' . $i . '_id" value="'; echo $fermentables[$i]['id']; echo '"/>';
				?>
		
			</div>
		
			<?php
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
				if ($hops[$i]['name'])
				{
			?>
			
			<div class="row margin-bottom-half_em">
		
				<div class="col-xs-6 col-sm-2 col-md-3">
					<?php
					echo '<input type="text" class="form-control input-sm" name="hop' . $i . '_name" readonly="yes" value="' . $hops[$i]['name'] . '"/>';
					?>
				</div>
		
				<div class="col-xs-3 col-sm-2 col-md-1">
					<?php
					echo '<input type="text" class="form-control input-sm" name="hop' . $i . '_amount" readonly="yes" value="' . $hops[$i]['amount'] . '"/>';
					?>
				</div>

				<div class="hidden-xs col-sm-2 col-md-1">
					<?php
					echo '<input type="text" class="form-control input-sm" name="hop' . $i . '_alpha" readonly="yes" value="' . $hops[$i]['alpha'] . '"/>';
					?>
				</div>

				<div class="col-xs-3 col-sm-2 col-md-1">
					<?php
					echo '<input type="text" class="form-control input-sm" name="hop' . $i . '_time" readonly="yes" value="' . $hops[$i]['time'] . '"/>';
					?>
				</div>

				<div class="hidden-xs col-sm-2 col-md-2">
					<?php
					echo '<input type="text" class="form-control input-sm" name="hop' . $i . '_form" readonly="yes" value="' . $hops[$i]['form'] . '"/>';
					?>
				</div>

				<div class="hidden-xs col-sm-2 col-md-2">
					<?php
					echo '<input type="text" class="form-control input-sm" name="hop' . $i . '_use" readonly="yes" value="' . $hops[$i]['use'] . '"/>';
					?>
				</div>
		
				<?php
				// the recipes_hops record id
				echo '<input type="hidden" name="hop' . $i . '_record_id" value="'; echo $hops[$i]['record_id']; echo '"/>';
				// the hops id
				echo '<input type="hidden" name="hop' . $i . '_id" value="'; echo $hops[$i]['id']; echo '"/>';
				?>
		
			</div>
		
			<?php
				}
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
				if ($yeasts[$i]['fullname'])
				{
			?>
	
			<div class="row margin-bottom-half_em">
		
				<div class="col-xs-6 col-sm-3 col-md-3">
					<?php
					echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_fullname" readonly="yes" value="' . $yeasts[$i]['fullname'] . '"/>';
					?>
				</div>
		
				<div class="col-xs-3 col-sm-3 col-md-2">
					<?php
					echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_type" readonly="yes" value="' . $yeasts[$i]['type'] . '"/>';
					?>
				</div>
		
				<div class="col-xs-3 col-sm-3 col-md-2">
					<?php
					echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_form" readonly="yes" value="' . $yeasts[$i]['form'] . '"/>';
					?>
				</div>
		
				<div class="col-xs-3 col-sm-3 col-md-2">
					<?php
					echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_attenuation" readonly="yes" value="' . $yeasts[$i]['attenuation'] . '"/>';
					?>
				</div>
		
				<div class="col-xs-3 col-sm-3 col-md-2">
					<?php
					echo '<input type="text" class="form-control input-sm" name="yeast' . $i . '_flocculation" readonly="yes" value="' . $yeasts[$i]['flocculation'] . '"/>';
					?>
				</div>
		
				<?php
				// the recipes_yeasts record id
				echo '<input type="hidden" name="yeast' . $i . '_record_id" value="'; echo $yeasts[$i]['record_id']; echo '"/>';
				// the yeast id
				echo '<input type="hidden" name="yeast' . $i . '_id" value="'; echo $yeasts[$i]['id']; echo '"/>';
				?>
		
			</div>
		
			<?php
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
				if ($miscs[$i]['name'])
				{
			?>
	
			<div class="row margin-bottom-half_em">
		
				<div class="col-xs-6 col-sm-2 col-md-3">
					<?php
					echo '<input type="text" class="form-control input-sm" name="misc' . $i . '_name" readonly="yes" value="' . $miscs[$i]['name'] . '"/>';
					?>
				</div>
		
				<div class="col-xs-3 col-sm-2 col-md-1">
					<?php
					echo '<input type="text" class="form-control input-sm" name="misc' . $i . '_amount" readonly="yes" value="' . $miscs[$i]['amount'] . '"/> ';
					?>
				</div>

				<div class="col-xs-3 col-sm-2 col-md-1">
					<?php
					echo '<input type="text" class="form-control input-sm" name="misc' . $i . '_unit" readonly="yes" value="' . $miscs[$i]['unit'] . '"/> ';
					?>
				</div>

				<div class="hidden-xs col-sm-2 col-md-2">
					<?php
					echo '<input type="text" class="form-control input-sm" name="misc' . $i . '_type" readonly="yes" value="' . $miscs[$i]['type'] . '"/> ';
					?>
				</div>
		
				<?php
				// the recipes_miscs record id
				echo '<input type="hidden" name="misc' . $i . '_record_id" value="'; echo $miscs[$i]['record_id']; echo '"/> ';
				// the miscs id
				echo '<input type="hidden" name="misc' . $i . '_id" value="'; echo $miscs[$i]['id']; echo '"/> ';
				?>
		
			</div>
		
			<?php
				}
			}
			?>
	
		</fieldset>
		
		</div>

	</div>

	</form>

</div>

<!-- new form to submit only the recipe id using get not post-->
<div class="container">

<form role="form" class="form-horizontal" name="recipeformedit" method="get">
	<input type="hidden" name="id" value="<?php echo $details['id']; ?>" />
	<input class="btn btn-default" type="submit" name="function" value="Edit" formaction="recipe_edit.php" />
	<input class="btn btn-default" type="submit" name="function" value="Brew It" formaction="brew_new.php" />
</form>

</div>

<?php
include ('includes/footer.html');
?>
