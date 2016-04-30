<?php

/* 
hop_delete.php
Delete a hop in the database
*/

$page_title = 'Delete Hop';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if ($_POST['sure'] == 'Yes')
    {
        $hop_id = mysqli_real_escape_string($connection, htmlspecialchars($_POST['id']));
        $query = "DELETE from hops WHERE hop_id='" . $hop_id . "'";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    // After deleting or not, redirect back to the hops_list page 
    header("Location: hops_list.php");
    
}

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
    // get the hop
    $query = "SELECT * FROM hops WHERE hop_id='" . $_GET['id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection)); 
 
}
// if id isn't set, or isn't valid, redirect back to list page
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

<h2>Delete Hop</h2>

<form name="hopform" action="hop_delete.php" method="post">
    
<div class="row">
<div class="six_cols">
<div class="float_left">
<fieldset>
    <legend>Hop</legend>

    <label>Name: </label>
    <input type="text" name="name" size=15 readonly="yes" value="<?php echo $name; ?>" />
    
    <label>Alpha (%): </label>
    <input type="text" name="alpha" size=6 readonly="yes" value="<?php echo $alpha; ?>" />
    
    <label>Origin: </label>
    <input type="text" name="origin" size=10 readonly="yes" value="<?php echo $origin; ?>" />
    
    <p></p>
    
    <label>Subsitutes: </label>
    <input type="text" name="substitutes" size=50 readonly="yes" value="<?php echo $substitutes; ?>" />
    
    <p></p>
    
    <label>Notes: </label>
    <textarea rows=3 cols=130 name="notes" readonly="yes"><?php echo $notes; ?></textarea>
    
</fieldset>
</div><!-- float_left -->
</div><!-- six_cols -->
</div><!-- row -->

<input type="hidden" name="id" value="<?php echo $id; ?>" />

<div class="row">
<div class="float_left">
<p>Are you sure you want to delete this record?</p>
<input type="radio" name="sure" value="Yes" /> Yes
<input type="radio" name="sure" value="No" /> No

<p><input type="submit" name="delete" value="Delete"></p>
</div><!-- float_left -->
</div><!-- row -->

</form>

<?php 
include ('includes/footer.html');
?>
