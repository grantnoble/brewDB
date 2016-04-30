<?php

/* 
hop_edit.php
Edit a hop in the database
*/

$page_title = 'Edit Hop';
$error = "";
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // form validation OK, so retrieve the field values
    $hop['id'] = mysqli_real_escape_string($connection, test_input($_POST['id']));
    $hop['name'] = mysqli_real_escape_string($connection, test_input($_POST['name']));
    $hop['alpha'] = mysqli_real_escape_string($connection, test_input($_POST['alpha']));
    $hop['origin'] = mysqli_real_escape_string($connection, test_input($_POST['origin']));
    $hop['substitutes'] = mysqli_real_escape_string($connection, test_input($_POST['substitutes']));
    $hop['notes'] = mysqli_real_escape_string($connection, test_input($_POST['notes']));
    
    $query = "UPDATE hops SET hop_name='" . $hop['name'] . "', hop_alpha='" . $hop['alpha'] . "', hop_origin='" . $hop['origin'] . "', hop_substitutes='" . $hop['substitutes'] . "', hop_notes='" . $hop['notes'] . "' WHERE hop_id='" . $hop['id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    
    // After saving to the database, redirect back to the list hops page 
    header("Location: hops_list.php");
    
}

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
    // get the hop
    $query = "SELECT * FROM hops WHERE hop_id='" . $_GET['id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection)); 
 
}
// if id isn't set, or isn't valid, redirect back to view page
else
{
    header("Location: hops_list.php");
}

while($row = mysqli_fetch_array( $result ))
{
    $id = $row['hop_id'];
    $name = $row['hop_name'];
    $alpha = $row['hop_alpha'];
    $origin = $row['hop_origin'];
    $substitutes = $row['hop_substitutes'];
    $notes = $row['hop_notes'];
}

?>

<h2>Edit Hop</h2>

<form name="hopform" action="hop_edit.php" method="post">
    
<div class="row">
<div class="six_cols">
<div class="float_left">
<fieldset>
    <legend>Hop</legend>

    <label>Name *: </label>
    <input type="text" name="name" size=15 required oninvalid="this.setCustomValidity('Hop name is required.')" onchange="this.setCustomValidity('')" value="<?php if (isset($_POST['name'])) {echo $_POST['name'];} else {echo $name;} ?>" />
    
    <label>Alpha (%): </label>
    <input type="number" name="alpha" size=6 style="width: 6em" oninvalid="this.setCustomValidity('Alpha Acid is not numeric.')" onchange="this.setCustomValidity('')" value="<?php if (isset($_POST['alpha'])) {echo $_POST['alpha'];} else {echo $alpha;} ?>" />
    
    <label>Origin: </label>
    <input type="text" name="origin" size=10 value="<?php if (isset($_POST['origin'])) {echo $_POST['origin'];} else {echo $origin;} ?>" />
    
    <p></p>
    
    <label>Subsitutes: </label>
    <input type="text" name="substitutes" size=50 value="<?php if (isset($_POST['substitutes'])) {echo $_POST['substitutes'];} else {echo $substitutes;} ?>" />
    
    <p></p>
    
    <label>Notes: </label>
    <textarea rows=3 cols=130 name="notes"><?php if (isset($_POST['notes'])) {echo $_POST['notes'];} else {echo $notes;} ?></textarea>
    
</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->
</div><!-- row -->

<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<div class="row">
<div class="float_left">
<input type="submit" value="Update Hop" />
</div><!-- float_left -->
</div><!-- row -->

</form>

<?php 
include ('includes/footer.html');
?>
