<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Miscs XML Load</title>
</head>
<body>

<?php

/* 
miscs_xml_load.php
Load miscellaneous ingredient details from an XML file into the database
*/
header('Content-Type: text/html; charset="utf-8"', true);
// connect to the database
include('includes/database_connect.php');

// Set up some variables.
$xml_file = './xml_files/miscs.xml';
$xml_parser = xml_parser_create();

// Open the file and read the data.
$fp = fopen($xml_file, 'r');
$xml_data = fread($fp, filesize($xml_file));

// Parse the XML data into an array.
xml_parse_into_struct($xml_parser, $xml_data, $array);

// Free the parser and close the file.
xml_parser_free($xml_parser);
fclose($fp);

/* Print out the array first.
for ($i=0; $i<=count($array)-1; $i++)
  {
  print_r($array[$i]);
  if (isset($array[$i]['value']))
    {
    echo "<br />" . $array[$i]['value'] . "<br />";
    }
    else
    {
    echo 'No value';
    }
  }*/

// Main loop to build the sql INSERT statement.// Main loop to build the sql INSERT statement.
$count = 1;
for ($i=0; $i<=count($array)-1; $i++)
  {
  // If an 'open' level 1 item, setup $table_name.
  if (($array[$i]['type'] == 'open') && ($array[$i]['level'] == 1))
    {
    $table_name = strtolower($array[$i]['tag']);
    }
  // Else, if an 'open' level 2 item, setup $column and $value.
  elseif (($array[$i]['type'] == 'open') && ($array[$i]['level'] == 2))
    {
    $column = 'INSERT INTO ' . $table_name . ' (';
    $value = 'VALUES (';
    $prefix = strtolower($array[$i]['tag']) . '_';
    }
  // Else, if a level 3 item, concatenate 'tag' and 'value' values to $column and $value.
  elseif ($array[$i]['level'] == 3)
    {
    $column .= $prefix;
    $column .= strtolower($array[$i]['tag']);
    $column .= ', ';
    // If the 'value' value is not empty, then if not a number, surround it with single quotes. If empty, comma space.
    if (isset($array[$i]['value']))
      {
      if (is_numeric($array[$i]['value']))
        {
        $value .= $array[$i]['value'];
        $value .= ', ';
        }
      else
        {
        $value .= '\'';
        $value .= $array[$i]['value'];
        $value .= '\'';
        $value .= ', ';
        }
      }
    else
      {
      $value .= '\'\', ';
      }
    }
  // Else, if a 'close' level 2 item, build the sql INSERT statement.
  elseif (($array[$i]['type'] == 'close') && ($array[$i]['level'] == 2))
    {
    // The substr function strips the last ', ' from $column and $value.
    $query = substr($column, 0, strlen($column)-2) . ') ' . substr($value, 0, strlen($value)-2) . ')';

    echo 'Record ' . $count . '<br />';
    echo $query . '<br />';
    if (mysqli_query($connection, $query))
      {
      echo 'Added to table...' . '<br />';
      $count++;
      }
      else
      {
      die(mysqli_error($connection));
      }
    }
  } // End of for loop.

mysqli_close($connection);

?> 

</body>
</html> 
