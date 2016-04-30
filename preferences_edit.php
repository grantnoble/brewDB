<?php

/* 
preferences_edit.php
Edit brewdb preferences
*/

$page_title = 'Edit Preferences';
$error = "";
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // retrieve the field values
    $details['preference_id'] = mysqli_real_escape_string($connection, test_input($_POST['preference_id']));
    $details['boil_size'] = mysqli_real_escape_string($connection, test_input($_POST['boil_size']));
    $details['boil_time'] = mysqli_real_escape_string($connection, test_input($_POST['boil_time']));
    $details['evaporation_rate'] = mysqli_real_escape_string($connection, test_input($_POST['evaporation_rate']));
    $details['batch_size'] = mysqli_real_escape_string($connection, test_input($_POST['batch_size']));
    $details['mash_efficiency'] = mysqli_real_escape_string($connection, test_input($_POST['mash_efficiency']));
    $details['loss'] = mysqli_real_escape_string($connection, test_input($_POST['loss']));
    $details['page_title'] = mysqli_real_escape_string($connection, test_input($_POST['page_title']));
    $details['title'] = mysqli_real_escape_string($connection, test_input($_POST['title']));
    $details['sub_title'] = mysqli_real_escape_string($connection, test_input($_POST['sub_title']));
    
    $query = "UPDATE preferences SET preference_page_title='" . $details['page_title'] . "', preference_title='" . $details['title'] . "', preference_sub_title='" . $details['sub_title'] . "', preference_boil_size=" . $details['boil_size'] . ", preference_boil_time=" . $details['boil_time'] . ", preference_evaporation_rate=" . $details['evaporation_rate'] . ", preference_batch_size=" . $details['batch_size'] . ", preference_mash_efficiency=" . $details['mash_efficiency'] . ", preference_loss=" . $details['loss'] . " WHERE preference_id=" . $details['preference_id'] ;
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    
    // After saving to the database, redirect back to the home page 
    header("Location: index.php");
    
}

// if not form submission, retrieve preference details
$query = "SELECT * FROM preferences ORDER BY preference_id DESC LIMIT 1";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
while ($row = mysqli_fetch_array ( $result ))
{
	$preference_id = $row['preference_id'];
	$page_title = $row['preference_page_title'];
	$title = $row['preference_title'];
	$sub_title = $row['preference_sub_title'];
	$boil_size = $row['preference_boil_size'];
	$boil_time = $row['preference_boil_time'];
	$evaporation_rate = $row['preference_evaporation_rate'];
	$batch_size = $row['preference_batch_size'];
	$mash_efficiency = $row['preference_mash_efficiency'];
	$loss = $row['preference_loss'];
}

end:

?>

<h2>Edit Preferences</h2>

<form name="preferencesform" action="preferences_edit.php" method="post">
    
<div class="row">
<div class="six_cols">
<div class="float_left">
<fieldset>
    <legend>Preferences</legend>
    
     <label>Page Title</label><br>
    <input type="text" name="page_title" size=100 value="<?php echo $page_title; ?>" />
    
    <label>Title</label><br>
    <input type="text" name="title" size=100 value="<?php echo $title; ?>" />
    
    <label>Sub Title</label><br>
    <input type="text" name="sub_title" size=100 value="<?php echo $sub_title; ?>" />
    
    <p></p>
    
   <label>Boil Size (L)*: </label>
    <input type="number" name="boil_size" size=6 style="width: 6em" required oninvalid="this.setCustomValidity('Boil size is required or is not numeric.')" onchange="this.setCustomValidity('')" value="<?php echo $boil_size; ?>" />
    
    <label>Boil Time (mins)*: </label>
    <input type="number" name="boil_time" size=6 style="width: 6em" required oninvalid="this.setCustomValidity('Boil time is required or is not numeric.')" onchange="this.setCustomValidity('')" value="<?php echo $boil_time; ?>" />
    
    <label>Evaporation Rate (L/hr)*: </label>
    <input type="number" name="evaporation_rate" size=6 style="width: 6em" required oninvalid="this.setCustomValidity('Evaporation rate is required or is not numeric.')" onchange="this.setCustomValidity('')" value="<?php echo $evaporation_rate; ?>" />
    
    <p></p>
    
    <label>Batch Size (L)*: </label>
    <input type="number" name="batch_size" size=6 style="width: 6em" required oninvalid="this.setCustomValidity('Batch size is required or is not numeric.')" onchange="this.setCustomValidity('')" value="<?php echo $batch_size; ?>" />
    
    <label>Mash Efficiency (%)*: </label>
    <input type="number" name="mash_efficiency" size=6 style="width: 6em" required oninvalid="this.setCustomValidity('Mash efficiency is required or is not numeric.')" onchange="this.setCustomValidity('')" value="<?php echo $mash_efficiency; ?>" />
    
    <label>Loss (L)*: </label>
    <input type="number" name="loss" size=6 style="width: 6em" required oninvalid="this.setCustomValidity('Loss is required or is not numeric.')" onchange="this.setCustomValidity('')" value="<?php echo $loss; ?>" />
    
</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->
</div><!-- row -->

<input type="hidden" name="preference_id" value="<?php echo $preference_id; ?>"/>

<div class="row">
<input class="button" type="submit" value="Save" />
</div><!-- row -->

</form>

<?php 
include ('includes/footer.html');
?>
