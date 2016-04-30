<?php

/*
recipes_view.php
View a recipe in the database
*/

$page_title = 'View Recipes';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// connect to the database
include('includes/database_connect.php');

// get the recipe details
include('includes/get_recipe_details.php');
?>

<h2>View Recipe</h2>

<form role="form" name="recipeform" >

<div class="row">
<div class="seven_cols">
<div class="float_left">
<fieldset>
    <legend>Details</legend>
    
	<label>Name: </label>
	<input type="text" name="name" readonly="yes" size=25 value="<?php echo $details['name']; ?>" /> 
	
	<label>Style: </label>
	<input type="text" name="style" readonly="yes" size=25 value="<?php echo $style['name']; ?>" />
	
	<label>Type: </label>
	<input type="text" name="type" readonly="yes" size=15 value="<?php echo $details['type']; ?>" />
	
	<p></p>
	
	<label>Date (yyyy-mm-dd): </label>
	<input type="date" name="date" readonly="yes" size=8 value="<?php echo $details['date']; ?>"/>
	
	<label>Batch Size (L): </label>
	<input type="text" name="batch_size" readonly="yes" size=6 value="<?php echo $details['batch_size']; ?>" />
	
	<label>Designer: </label>
	<input type="text" name="designer" readonly="yes" size=20 value="<?php echo $details['designer']; ?>" />

	<p></p>

	<label>Recipe Notes:<br> </label>
	<textarea rows=2 cols=100 name="notes" readonly="yes" ><?php echo $details['notes']; ?></textarea>

</fieldset>
</div><!-- float_left -->
</div><!-- seven_cols -->

<div class="five_cols">
<div class="float_left">
<fieldset>
    <legend>Style Characteristics</legend>
    <table class="list_table">
        <tr><td>&nbsp;</td><td>Low</td><td>Est.</td><td>High</td></tr>
        <tr>
            <td>OG</td>
            <td><input type="text" name="style_og_min" size=6 readonly="yes" value="<?php echo $style['og_min']; ?>" /></td>
            <td><input type="text" name="recipe_est_og" size=6 readonly="yes" value="<?php echo number_format($details['est_og'],3); ?>" /></td>
            <td><input type="text" name="style_og_max" size=6 readonly="yes" value="<?php echo $style['og_max']; ?>" /></td>
        </tr>
        <tr>
            <td>FG</td>
            <td><input type="text" name="style_fg_min" size=6 readonly="yes" value="<?php echo $style['fg_min']; ?>" /></td>
            <td><input type="text" name="recipe_est_fg" size=6 readonly="yes" value="<?php echo number_format($details['est_fg'],3); ?>" /></td>
            <td><input type="text" name="style_fg_max" size=6 readonly="yes" value="<?php echo $style['fg_max']; ?>" /></td>
        </tr>
        <tr>
            <td>ABV %&nbsp;</td>
            <td><input type="text" name="style_abv_min" size=6 readonly="yes" value="<?php echo $style['abv_min']; ?>" /></td>
            <td><input type="text" name="recipe_est_abv" size=6 readonly="yes" value="<?php echo $details['est_abv']; ?>" /></td>
            <td><input type="text" name="style_abv_max" size=6 readonly="yes" value="<?php echo $style['abv_max']; ?>" /></td>
        </tr>
        <tr>
            <td>IBU</td>
            <td><input type="text" name="style_ibu_min" size=6 readonly="yes" value="<?php echo $style['ibu_min']; ?>" /></td>
            <td><input type="text" name="recipe_est_ibu" size=6 readonly="yes" value="<?php echo $details['est_ibu']; ?>" /></td>
            <td><input type="text" name="style_ibu_max" size=6 readonly="yes" value="<?php echo $style['ibu_max']; ?>" /></td>
        </tr>
        <tr>
            <td>Color</td>
            <td><input type="text" name="style_color_min" size=6 readonly="yes" value="<?php echo $style['color_min']; ?>" /></td>
            <td><input type="text" name="recipe_est_color" size=6 readonly="yes" value="<?php echo $details['est_color']; ?>" /></td>
            <td><input type="text" name="style_color_max" size=6 readonly="yes" value="<?php echo $style['color_max']; ?>" /></td>
        </tr>
    </table>
</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->
</div><!-- row -->

<div class="row">
<div class="five_cols">
<div class="float_left">
<fieldset>
    <legend>Fermentables</legend>
    <?php
    if ($f>4)
    {
		echo '<div class="five_ingredients_view">';
	}
	else
	{
		echo '<div>';
	}
	?>
    <table>
    <tr><td>Fermentable</td><td>Amount&nbsp;(kg)</td><td>Yield&nbsp;(%)</td><td>Colour&nbsp;(L)</td><td>Use</td></tr>
    <?php
	for ($i=0; $i<=$f; $i++)
    {
        echo '<tr>';
        echo '<td><input type="text" name="fermentable' . $i . '_name" readonly="yes" size=20 value="' . $fermentables[$i]['name'] . '"/></td>';
        echo '<td><input type="text" name="fermentable' . $i . '_amount" readonly="yes" size=8 value="'. $fermentables[$i]['amount'] . '"/> </td>';
        echo '<td><input type="text" name="fermentable' . $i . '_yield" readonly="yes" size=8 value="'. $fermentables[$i]['yield'] . '"/> </td>';
        echo '<td><input type="text" name="fermentable' . $i . '_color" readonly="yes" size=8 value="'. $fermentables[$i]['color'] . '"/> </td>';
        echo '<td><input type="text" name="fermentable' . $i . '_use" readonly="yes" size=8 value="'. $fermentables[$i]['use'] . '"/> </td>';
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
	<?php
    if ($h>4)
    {
		echo '<div class="five_ingredients_view">';
	}
	else
	{
		echo '<div>';
	}
	?>
    <table>
    <tr><td>Hop</td><td>Amount&nbsp;(g)</td><td>Alpha&nbsp;(%)</td><td>Time&nbsp;(min)</td><td>Form</td><td>Use</td></tr>
    <?php
	for ($i=0; $i<=$h; $i++)
    {
        echo '<tr>';
        echo '<td><input type="text" name="hop' . $i . '_name" readonly="yes" size=15 value="' . $hops[$i]['name'] . '"/></td>';
        echo '<td><input type="text" name="hop' . $i . '_amount" readonly="yes" size=8 value="'. $hops[$i]['amount'] . '"/> </td>';
        echo '<td><input type="text" name="hop' . $i . '_alpha" readonly="yes" size=8 value="'. $hops[$i]['alpha'] . '"/> </td>';
        echo '<td><input type="text" name="hop' . $i . '_time" readonly="yes" size=8 value="'. $hops[$i]['time'] . '"/> </td>';
        echo '<td><input type="text" name="hop' . $i . '_form" readonly="yes" size=8 value="'. $hops[$i]['form'] . '"/> </td>';
        echo '<td><input type="text" name="hop' . $i . '_use" readonly="yes" size=8 value="'. $hops[$i]['use'] . '"/> </td>';
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
    <tr><td>Name</td><td>Product&nbsp;ID</td><td>Type</td><td>Form</td><td>Atten.&nbsp;(%)</td><td>Floc.</td></tr>
    <?php
	for ($i=0; $i<=$y; $i++)
    {
        echo '<tr>';
        echo '<td><input type="text" name="yeast' . $i . '_name" readonly="yes" size=30 value="' . $yeasts[$i]['name'] . '"/></td>';
        echo '<td><input type="text" name="yeast' . $i . '_product_id" readonly="yes" size=6 value="'. $yeasts[$i]['product_id'] . '"/> </td>';
        echo '<td><input type="text" name="yeast' . $i . '_type" readonly="yes" size=6 value="'. $yeasts[$i]['type'] . '"/> </td>';
        echo '<td><input type="text" name="yeast' . $i . '_form" readonly="yes" size=6 value="'. $yeasts[$i]['form'] . '"/> </td>';
        echo '<td><input type="text" name="yeast' . $i . '_attenuation" readonly="yes" size=6 value="'. $yeasts[$i]['attenuation'] . '"/> </td>';
        echo '<td><input type="text" name="yeast' . $i . '_flocculation" readonly="yes" size=6 value="'. $yeasts[$i]['flocculation'] . '"/> </td>';
        echo '</tr>';
    }
	?>
    </table>
</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->

<div class="6-cols">
<div class="float_left">
<fieldset>
    <legend>Misc. Ingredients</legend>
	<?php
    if ($m>2)
    {
		echo '<div class="three_ingredients_view">';
	}
	else
	{
		echo '<div>';
	}
	?>
    <table>
    <tr><td>Name</td><td>Amount</td><td>Unit</td><td>Type</td></tr>
    <?php
	for ($i=0; $i<=$m; $i++)
    {
        echo '<tr>';
        echo '<td><input type="text" name="misc' . $i . '_name" readonly="yes" size=20 value="' . $miscs[$i]['name'] . '"/></td>';
        echo '<td><input type="text" name="misc' . $i . '_amount" readonly="yes" size=8 value="'. $miscs[$i]['amount'] . '"/> </td>';
        echo '<td><input type="text" name="misc' . $i . '_unit" readonly="yes" size=8 value="'. $miscs[$i]['unit'] . '"/> </td>';
        echo '<td><input type="text" name="misc' . $i . '_type" readonly="yes" size=8 value="'. $miscs[$i]['type'] . '"/> </td>';
        echo '</tr>';
    }
	?>
    </table>
    </div>
</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->
</div><!-- row -->

</form>

<!-- new form to submit only the recipe id using get not post-->
<form name="recipeformedit" action="recipe_edit.php" method="get">
	<div class="row">
	<input type="hidden" name="id" value="<?php echo $details['id']; ?>" />
	<input class="button" type="submit" value="Edit" />
	</div><!-- row -->
</form>

<?php
include ('includes/footer.html');
?>
