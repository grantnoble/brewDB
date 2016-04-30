<?php

/* 
hop_view.php
View a hop in the database
*/

$page_title = 'View Hop';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

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

<h2>View Hop</h2>

<form name="hopform" action="hop_view.php" method="post">
    
<div class="row">
<div class="six_cols">
<div class="float_left">
<fieldset>
    <legend>Hop</legend>
    
    <label>Name: </label>
    <input type="text" name="name" size=15 readonly="yes" value="<?php echo $name; ?>" />
    
    <label>Alpha: </label>
    <input type="text" name="type" size=6 readonly="yes" value="<?php echo $alpha; ?>" />
    
    <label>Origin: </label>
    <input type="text" name="yield" size=10 readonly="yes" value="<?php echo $origin; ?>" />
    
    <p></p>
    
    <label>Substitutes: </label>
    <input type="text" name="color" size=50 readonly="yes" value="<?php echo $substitutes; ?>" />
    
    <p></p>
    
    <label>Notes: </label>
    <textarea rows=3 cols=130 name="notes" readonly="yes"><?php echo $notes; ?></textarea>
    
</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->
</div><!-- row -->

</form>

<!-- new form to submit only the hop id using get not post-->
<form name="hopformedit" action="hop_edit.php" method="get">
<div class="row">
<div class="float_left">
	<input type="hidden" name="id" value="<?php echo $id; ?>" />
	<input type="submit" value="Edit Hop" />
</div><!-- float_left -->
</div><!-- row -->
</form>

<?php 
include ('includes/footer.html');
?>
