<?php 

/* 
index.php
Display the brewers dashboard
*/

$page_title = 'Home';
include '../includes/header.html';
header('Content-Type: text/html; charset="utf-8"', true);

?>

<div class="container-fluid">

	<div class="jumbotron">
      
		<h1>brewDB</h1>
		<p>Use the pre-loaded style and ingredient information to create your favourite beer recipes and record your brews.</p>

	</div>
	
</div>

<?php 
include '../includes/footer.html';
?>
