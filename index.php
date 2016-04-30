<?php 

/* 
index.php
Display the brewers dashboard
*/

$page_title = 'Home';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

?>

    <div class="jumbotron">
      <div class="container">
        <h1>Let's Brew!</h1>
        <p>Use the pre-loaded style and ingredient information to create your favourite beer recipes and record your brews. </p>
      </div>
    </div>




<?php 
include ('includes/footer.html');
?>
