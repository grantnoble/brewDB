<?php

/*
recipes_new.php
Create a recipe in the database
*/

$page_title = 'Grant' . "'" . 's Brewing Database - Recipe New';
$error = array ('name'=>'','style'=>'','type'=>'');
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// connect to the database
include('includes/database_connect.php');

// include the test_input function, which strips whitespace, slashes, and converts special characters
include('includes/test_input.php');

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	echo $f_name=$_POST['f_name'];

    // After saving to the database, redirect back to the new recipe page
    header("Location: recipes_new.php");
}

// end of PHP section, now create the HTML form
?>

<!--scripts to retrieve info from the styles, fermentables, hops, yeasts, and miscs tables-->
<script src="js_files/add_row.js"></script>

<h2>New Recipe</h2>

<form name="recipeform" action="recipes_new.php" onsubmit="return validate_form()" method="post">

<fieldset class="float_left">
	<legend>Fermentables</legend>
	<table class="table_ingredients" id="f_table">
		<tr>
			<td></td></td><td>Fermentable</td><td>Amount (kg)</td><td>Yield (%)</td><td>Colour (L)</td><td>Use</td></tr>
		<tr>
            <td><input type="checkbox" /></td>
			<td><select name="f_name[]" onchange="getfermentableinfo(this.value)" >
				<option>Select...</option>
				<?php $query = "SELECT fermentable_name FROM fermentables ORDER BY fermentable_name";
				$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
				while ($row = mysqli_fetch_array ( $result ))
				{
					echo '<option>' . $row['fermentable_name'] . '</option>';
				}?>
				</select></td>
            <td><input type="text" name="f_amount[]" size=6 onchange="calc_og_color_ibu()" /> </td>
            <td><input type="text" name="f_yield[]" size=6 onchange="calc_og_color_ibu()" /> </td>
            <td><input type="text" name="f_color[]" size=6 onchange="calc_color()" /> </td>
            <td><select name="f_use[]">
				<option>Select...</option>
				<option>Mashed</option>
				<option>Steeped</option>
				<option>Extract</option>
				<option>Sugar</option>
				<option>Other</option>
				</select></td>
			<td><input type="hidden" name="f_id[]" value="<?php if (isset($_POST['fermentable' . $i . '_id'])) echo $_POST['fermentable' . $i . '_id']; ?>"/> </td>
		</tr>
    </table>
	<input type="button" onclick="add_row('f_table')" value="Add";" /><input type="button" value="Delete";" />
</fieldset>
<p class="float_clear"></p>

<input type="submit" value="Save Recipe";" />

</form>

<?php
include ('includes/footer.html');
?>
