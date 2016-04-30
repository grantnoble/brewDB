<?php

/* 
misc_view.php
View a misc in the database
*/

$page_title = 'View Miscs';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
    // get the misc
    $query = "SELECT * FROM miscs WHERE misc_id='" . $_GET['id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection)); 
 
}
// if id isn't set, or isn't valid, redirect back to view page
else
{
    header("Location: miscs_list.php");
}

while($row = mysqli_fetch_array( $result ))
{
    $id = $row['misc_id'];
    $name = $row['misc_name'];
    $type = $row['misc_type'];
    $use = $row['misc_use'];
    $use_for = $row['misc_use_for'];
    $notes = $row['misc_notes'];
}

?>

<h2>View misc</h2>

<form name="miscform" action="misc_view.php" method="post">
    
<div class="row">
<div class="six_cols">
<div class="float_left">
<fieldset>
    <legend>Misc</legend>
    
    <label>Name: </label>
    <input type="text" name="name" size=15 readonly="yes" value="<?php echo $name; ?>" />
    
    <label>Type: </label>
    <input type="text" name="type" size=15 readonly="yes" value="<?php echo $type; ?>" />
    
    <label>Use: </label>
    <input type="text" name="yield" size=15 readonly="yes" value="<?php echo $use; ?>" />
    
    <p></p>
    
    <label>Use For: </label>
    <input type="text" name="color" size=50 readonly="yes" value="<?php echo $use_for; ?>" />
    
    <p></p>
    
    <label>Notes: </label>
    <textarea rows=3 cols=130 name="notes" readonly="yes"><?php echo $notes; ?></textarea>
    
</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->
</div><!-- row -->

</form>

<!-- new form to submit only the misc id using get not post-->
<form name="miscformedit" action="misc_edit.php" method="get">
<div class="row">
<div class="float_left">
	<input type="hidden" name="id" value="<?php echo $id; ?>" />
	<input type="submit" value="Edit Misc" />
</div><!-- float_left -->
</div><!-- row -->
</form>

<?php 
include ('includes/footer.html');
?>
