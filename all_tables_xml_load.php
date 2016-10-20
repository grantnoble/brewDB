<?php

/* 
all_tables_xml_load.php
Load all table details from the XML files into the database
*/

$page_title = 'Grant' . "'" . 's Brewing Database - Fermentables List';
include ('includes/header.html');
header('Content-Type: text/html; charset="utf-8"', true);

// connect to the database
include('includes/database_connect.php');

// Fermentables
// Set up some variables.
$xml_file = './xml_files/fermentables.xml';
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

// Main loop to build the sql INSERT statement.
$query = "";
$fcount = 1;
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
		if (($array[$i]['tag'] == 'NAME') || ($array[$i]['tag'] == 'VERSION') || ($array[$i]['tag'] == 'TYPE') || ($array[$i]['tag'] == 'YIELD') || ($array[$i]['tag'] == 'COLOR') || ($array[$i]['tag'] == 'ADD_AFTER_BOIL') || 
		($array[$i]['tag'] == 'ORIGIN') || ($array[$i]['tag'] == 'SUPPLIER') || ($array[$i]['tag'] == 'NOTES') || ($array[$i]['tag'] == 'MAX_IN_BATCH') || ($array[$i]['tag'] == 'RECOMMEND_MASH'))
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
	}
	// Else, if a 'close' level 2 item, build the sql INSERT statement.
	elseif (($array[$i]['type'] == 'close') && ($array[$i]['level'] == 2))
    {
    	// The substr function strips the last ', ' from $column and $value.
    	$query .= substr($column, 0, strlen($column)-2) . ') ' . substr($value, 0, strlen($value)-2) . ');';
		$fcount++;
    }
} // End of for loop.

//Hops
// Set up some variables.
$xml_file = './xml_files/hops.xml';
$xml_parser = xml_parser_create();

// Open the file and read the data.
$fp = fopen($xml_file, 'r');
$xml_data = fread($fp, filesize($xml_file));

// Parse the XML data into an array.
xml_parse_into_struct($xml_parser, $xml_data, $array);

// Free the parser and close the file.
xml_parser_free($xml_parser);
fclose($fp);

// Main loop to build the sql INSERT statement.
$hcount = 1;
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
    	if (($array[$i]['tag'] == 'NAME') || ($array[$i]['tag'] == 'VERSION') || ($array[$i]['tag'] == 'ORIGIN') || ($array[$i]['tag'] == 'ALPHA') || ($array[$i]['tag'] == 'SUBSTITUTES'))
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
	}
	// Else, if a 'close' level 2 item, build the sql INSERT statement.
	elseif (($array[$i]['type'] == 'close') && ($array[$i]['level'] == 2))
    {
    	// The substr function strips the last ', ' from $column and $value.
    	$query .= substr($column, 0, strlen($column)-2) . ') ' . substr($value, 0, strlen($value)-2) . ');';
		$hcount++;
    }
} // End of for loop.

// Yeasts
// Set up some variables.
$xml_file = './xml_files/yeasts.xml';
$xml_parser = xml_parser_create();

// Open the file and read the data.
$fp = fopen($xml_file, 'r');
$xml_data = fread($fp, filesize($xml_file));

// Parse the XML data into an array.
xml_parse_into_struct($xml_parser, $xml_data, $array);

// Free the parser and close the file.
xml_parser_free($xml_parser);
fclose($fp);

// Main loop to build the sql INSERT statement.
$ycount = 1;
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
    	if (($array[$i]['tag'] == 'NAME') || ($array[$i]['tag'] == 'VERSION') || ($array[$i]['tag'] == 'TYPE') || ($array[$i]['tag'] == 'FORM') || ($array[$i]['tag'] == 'LABORATORY') || ($array[$i]['tag'] == 'PRODUCT_ID') || 
		($array[$i]['tag'] == 'MIN_TEMPERATURE') || ($array[$i]['tag'] == 'MAX_TEMPERATURE') || ($array[$i]['tag'] == 'FLOCCULATION') || ($array[$i]['tag'] == 'ATTENUATION') || ($array[$i]['tag'] == 'NOTES') || 
		($array[$i]['tag'] == 'BEST_FOR') || ($array[$i]['tag'] == 'MAX_REUSE'))
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
	}
	// Else, if a 'close' level 2 item, build the sql INSERT statement.
	elseif (($array[$i]['type'] == 'close') && ($array[$i]['level'] == 2))
    {
    	// The substr function strips the last ', ' from $column and $value.
    	$query .= substr($column, 0, strlen($column)-2) . ') ' . substr($value, 0, strlen($value)-2) . ');';
		$ycount++;
    }
} // End of for loop.


// Miscs
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

// Main loop to build the sql INSERT statement.
$mcount = 1;
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
    	if (($array[$i]['tag'] == 'NAME') || ($array[$i]['tag'] == 'VERSION') || ($array[$i]['tag'] == 'TYPE') || ($array[$i]['tag'] == 'USE') || ($array[$i]['tag'] == 'USE_FOR') || ($array[$i]['tag'] == 'NOTES'))
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
	}
	// Else, if a 'close' level 2 item, build the sql INSERT statement.
	elseif (($array[$i]['type'] == 'close') && ($array[$i]['level'] == 2))
    {
    	// The substr function strips the last ', ' from $column and $value.
    	$query .= substr($column, 0, strlen($column)-2) . ') ' . substr($value, 0, strlen($value)-2) . ');';
		$mcount++;
    }
} // End of for loop.

/* BJCP
// Set up some variables.
$xml_file = './xml_files/bjcp.xml';
$xml_parser = xml_parser_create();

// Open the file and read the data.
$fp = fopen($xml_file, 'r');
$xml_data = fread($fp, filesize($xml_file));

// Parse the XML data into an array.
xml_parse_into_struct($xml_parser, $xml_data, $array);

// Free the parser and close the file.
xml_parser_free($xml_parser);
fclose($fp);

// Main loop to build the sql INSERT statement.
$bcount = 1;
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
    	if (($array[$i]['tag'] == 'REVISION') || ($array[$i]['tag'] == 'CLASS') || ($array[$i]['tag'] == 'NUMBER') || ($array[$i]['tag'] == 'NAME') || ($array[$i]['tag'] == 'NOTES'))
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
	}
	// Else, if a 'close' level 2 item, build the sql INSERT statement.
	elseif (($array[$i]['type'] == 'close') && ($array[$i]['level'] == 2))
    {
    	// The substr function strips the last ', ' from $column and $value.
    	$query .= substr($column, 0, strlen($column)-2) . ') ' . substr($value, 0, strlen($value)-2) . ');';
		$bcount++;
	}
} // End of for loop. */

// Styles
// Set up some variables.
$xml_file = './xml_files/styles.xml';
$xml_parser = xml_parser_create();

// Open the file and read the data.
$fp = fopen($xml_file, 'r');
$xml_data = fread($fp, filesize($xml_file));

// Parse the XML data into an array.
xml_parse_into_struct($xml_parser, $xml_data, $array);

// Free the parser and close the file.
xml_parser_free($xml_parser);
fclose($fp);

// Main loop to build the sql INSERT statement.
$scount = 1;
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
    	if (($array[$i]['tag'] == 'NAME') || ($array[$i]['tag'] == 'VERSION') || ($array[$i]['tag'] == 'CATEGORY_NAME') || ($array[$i]['tag'] == 'CATEGORY_NUMBER') || ($array[$i]['tag'] == 'SUBCATEGORY') || 
		($array[$i]['tag'] == 'STYLE_GUIDE') || ($array[$i]['tag'] == 'TYPE') || ($array[$i]['tag'] == 'OG_MIN') || ($array[$i]['tag'] == 'OG_MAX') || ($array[$i]['tag'] == 'FG_MIN') || ($array[$i]['tag'] == 'FG_MAX') || 
		($array[$i]['tag'] == 'IBU_MIN') || ($array[$i]['tag'] == 'IBU_MAX') || ($array[$i]['tag'] == 'COLOR_MIN') || ($array[$i]['tag'] == 'COLOR_MAX') || ($array[$i]['tag'] == 'ABV_MIN') || ($array[$i]['tag'] == 'ABV_MAX') || 
		($array[$i]['tag'] == 'NOTES') || ($array[$i]['tag'] == 'PROFILE') || ($array[$i]['tag'] == 'INGREDIENTS') || ($array[$i]['tag'] == 'EXAMPLES') || ($array[$i]['tag'] == 'IMPRESSION') || ($array[$i]['tag'] == 'AROMA') || 
		($array[$i]['tag'] == 'APPEARANCE') || ($array[$i]['tag'] == 'FLAVOR') || ($array[$i]['tag'] == 'MOUTHFEEL') || ($array[$i]['tag'] == 'COMMENTS') || ($array[$i]['tag'] == 'HISTORY') || 
		($array[$i]['tag'] == 'COMPARISONS'))
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
	}
	// Else, if a 'close' level 2 item, build the sql INSERT statement.
	elseif (($array[$i]['type'] == 'close') && ($array[$i]['level'] == 2))
    {
    	// The substr function strips the last ', ' from $column and $value.
    	$query .= substr($column, 0, strlen($column)-2) . ') ' . substr($value, 0, strlen($value)-2) . ');';
		$scount++;
	}
} // End of for loop.

// Preferences
$column = 'INSERT INTO preferences (preference_brew_type,preference_mash_type,preference_mash_volume,preference_sparge_volume,preference_no_chill,preference_boil_size,preference_boil_time,preference_evaporation_rate,preference_batch_size,preference_mash_efficiency,preference_ibu_method,preference_loss,preference_packaging)';
$value = 'VALUES ("All Grain","BIAB",34,0,"True",28,60,4,23,72,"Tinseth",1,"Bottle");';
$query .= $column . $value;

// Persons
$column = 'INSERT INTO persons (person_first_name,person_last_name)';
$value = 'VALUES (\'Master\',\'Brewer\');';
$query .= $column . $value;

$value = 'VALUES (\'Assistant\',\'Brewer\');';
$query .= $column . $value;

echo $query;
if (mysqli_multi_query($connection, $query))
{
	echo '<p>' . $fcount . ' records added to the fermentables table.</p>';
	echo '<p>' . $hcount . ' records added to the hops table.</p>';	
	echo '<p>' . $ycount . ' records added to the yeasts table.</p>';	
	echo '<p>' . $mcount . ' records added to the miscs table.</p>';
	/* echo '<p>' . $bcount . ' records added to the bjcp_categories table.</p>'; */
	echo '<p>' . $scount . ' records added to the styles table.</p>';
	echo '<p>' . '1 record added to the preferences table.</p>';
	echo '<p>' . '2 records added to the peoples table.</p>';
}
else
{
	die(mysqli_error($connection));
}

mysqli_close($connection);

include ('includes/footer.html');

?> 
