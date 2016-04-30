<?php
/* 
test_input
Strip whitespace, slashes, and converts special characters
*/

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
