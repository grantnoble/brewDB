<?php

/* 
misc_delete.php
Delete a misc in the database
*/

$page_title = 'Delete Misc';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if ($_POST['sure'] == 'Yes')
    {
        $misc_id = mysqli_real_escape_string($connection, htmlspecialchars($_POST['id']));
        $query = "DELETE from miscs WHERE misc_id='" . $misc_id . "'";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    // After deleting or not, redirect back to the miscs_list page 
    header("Location: miscs_list.php");
    
}

// check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
    // get the misc
    $query = "SELECT * FROM miscs WHERE misc_id='" . $_GET['id'] . "'";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection)); 
 
}
// if id isn't set, or isn't valid, redirect back to list page
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

<h2>Delete Misc</h2>

<form name="miscform" action="misc_delete.php" method="post">
    
<div class="row">
<div class="six_cols">
<div class="float_left">
<fieldset>
    <legend>Misc</legend>

    <label>Name: </label>
    <input type="text" name="name" size=15 readonly="yes" value="<?php echo $name; ?>" />
    
    <label>Type: </label>
    <input type="text" name="alpha" size=15 readonly="yes" value="<?php echo $type; ?>" />
    
    <label>Use: </label>
    <input type="text" name="origin" size=15 readonly="yes" value="<?php echo $use; ?>" />
    
    <p></p>
    
    <label>Use For: </label>
    <input type="text" name="substitutes" size=50 readonly="yes" value="<?php echo $use_for; ?>" />
    
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
