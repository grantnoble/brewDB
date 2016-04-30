<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>All Tables Create</title>
</head>
<body>

<?php

/*
all_tables_create.php
Create all table in the database
*/
header('Content-Type: text/html; charset="utf-8"', true);
// connect to the database
include('includes/database_connect.php');

// Fermentables
$query = "CREATE TABLE fermentables (
fermentable_id mediumint unsigned NOT NULL auto_increment,
fermentable_name varchar(255) NOT NULL,
fermentable_version tinyint unsigned NOT NULL default 1,
fermentable_type enum('Grain', 'Extract', 'Dry Extract', 'Sugar', 'Adjunct'),
fermentable_yield float,
fermentable_color float,
fermentable_add_after_boil enum('True', 'False'),
fermentable_origin varchar(255),
fermentable_supplier varchar(255),
fermentable_notes varchar(511),
fermentable_max_in_batch tinyint unsigned,
fermentable_recommend_mash enum('True', 'False'),
PRIMARY KEY (fermentable_id),
INDEX (fermentable_name)
) AUTO_INCREMENT=10001 CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

// Hops
$query .= "CREATE TABLE hops
(
hop_id mediumint unsigned NOT NULL auto_increment,
hop_name varchar(255) NOT NULL,
hop_version tinyint unsigned NOT NULL default 1,
hop_alpha float,
hop_notes varchar(255),
hop_origin varchar(255),
hop_substitutes varchar(255),
PRIMARY KEY (hop_id),
INDEX (hop_name)
) AUTO_INCREMENT=20001 CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

// Yeasts
$query .= "CREATE TABLE yeasts
(
yeast_id mediumint unsigned NOT NULL auto_increment,
yeast_laboratory varchar(255),
yeast_product_id varchar(255),
yeast_name varchar(255),
yeast_fullname varchar(255),
yeast_version tinyint unsigned NOT NULL default 1,
yeast_type enum('Ale', 'Lager', 'Wheat', 'Wine', 'Champagne'),
yeast_form enum('Liquid', 'Dry', 'Slant', 'Culture'),
yeast_min_temperature mediumint unsigned,
yeast_max_temperature mediumint unsigned,
yeast_flocculation enum('Low', 'Medium', 'High', 'Very High'),
yeast_attenuation float,
yeast_notes varchar(511),
yeast_best_for varchar(255),
yeast_max_reuse mediumint unsigned,
PRIMARY KEY (yeast_id),
INDEX (yeast_fullname),
INDEX (yeast_name),
INDEX (yeast_type),
INDEX (yeast_form),
INDEX (yeast_laboratory),
INDEX (yeast_product_id),
INDEX (yeast_flocculation)
) AUTO_INCREMENT=30001 CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

$query .= "CREATE TRIGGER insert_trigger
BEFORE INSERT on yeasts
FOR EACH ROW
SET NEW.yeast_fullname = CONCAT(NEW.yeast_laboratory, ' ', NEW.yeast_product_id, ' ', NEW.yeast_name);";

$query .= "CREATE TRIGGER update_trigger
BEFORE UPDATE on yeasts
FOR EACH ROW
SET NEW.yeast_fullname = CONCAT(NEW.yeast_laboratory, ' ', NEW.yeast_product_id, ' ', NEW.yeast_name);";

// Miscs
$query .= "CREATE TABLE miscs
(
misc_id mediumint unsigned NOT NULL auto_increment,
misc_name varchar(255) NOT NULL,
misc_version tinyint unsigned NOT NULL default 1,
misc_type enum('Spice', 'Fining', 'Water Agent', 'Herb', 'Flavor', 'Other'),
misc_use enum('Mash', 'Boil', 'Primary', 'Secondary', 'Bottling'),
misc_use_for varchar(255),
misc_notes varchar(511),
PRIMARY KEY (misc_id),
INDEX (misc_name),
INDEX (misc_type)
) AUTO_INCREMENT=40001 CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

// Styles
$query .= "CREATE TABLE styles
(
style_id mediumint unsigned NOT NULL auto_increment,
style_version tinyint unsigned NOT NULL default 1,
style_name varchar(255) NOT NULL,
style_style_guide enum ('BJCP-2008', 'BJCP-2015'),
style_category_name varchar(255) NOT NULL,
style_category_number tinyint unsigned NOT NULL,
style_subcategory varchar(1) NOT NULL,
style_type enum('Lager', 'Ale', 'Mead', 'Wheat', 'Mixed', 'Cider'),
style_og_min float(5,3),
style_og_max float(5,3),
style_fg_min float(5,3),
style_fg_max float(5,3),
style_ibu_min float,
style_ibu_max float,
style_color_min float,
style_color_max float,
style_abv_min float(3,1),
style_abv_max float(3,1),
style_notes varchar(2047),
style_profile varchar(2047),
style_ingredients varchar(2047),
style_examples varchar(2047),
PRIMARY KEY (style_id),
INDEX (style_name),
INDEX (style_category_name),
INDEX (style_category_number),
INDEX (style_subcategory),
INDEX (style_type)
) AUTO_INCREMENT=50001 CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

/*
style_impression varchar(2047),
style_aroma varchar(2047),
style_appearance varchar(2047),
style_flavor varchar(2047),
style_mouthfeel varchar(2047),
style_comments varchar(2047),
style_history varchar(2047),
style_comparisons varchar(2047), */

// Persons
$query .= "CREATE TABLE persons
(
person_id mediumint unsigned NOT NULL auto_increment,
person_first_name varchar(255),
person_last_name varchar(255),
PRIMARY KEY (person_id),
INDEX (person_last_name),
INDEX (person_first_name)
) AUTO_INCREMENT=60001 CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

// Preferences
$query .= "CREATE TABLE preferences
(
preference_id mediumint unsigned NOT NULL auto_increment,
preference_page_title varchar(255),
preference_title varchar(255),
preference_sub_title varchar(255),
preference_boil_size float,
preference_boil_time mediumint unsigned,
preference_evaporation_rate float,
preference_batch_size float,
preference_mash_efficiency float,
preference_loss float,
PRIMARY KEY (preference_id)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

// Recipes
$query .= "CREATE TABLE recipes
(
recipe_id mediumint unsigned NOT NULL auto_increment,
recipe_name varchar(255) NOT NULL,
recipe_version tinyint unsigned NOT NULL default 1,
recipe_type enum('Extract', 'Partial Mash', 'All Grain') NOT NULL default 'All Grain',
recipe_style_id mediumint unsigned,
recipe_batch_size float,
recipe_mash_efficiency float,
recipe_designer varchar(255),
recipe_notes varchar(511),
recipe_date date,
recipe_est_og float,
recipe_est_fg float,
recipe_est_color float,
recipe_est_ibu float,
recipe_ibu_method enum('Rager', 'Tinseth', 'Garetz') NOT NULL default 'Tinseth',
recipe_est_abv float,
PRIMARY KEY (recipe_id),
INDEX (recipe_name),
INDEX (recipe_type),
INDEX (recipe_style_id)
) AUTO_INCREMENT=100001 CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

// recipes_fermentables
$query .= "CREATE TABLE recipes_fermentables
(
recipe_fermentable_id mediumint unsigned NOT NULL auto_increment,
recipe_fermentable_recipe_id mediumint unsigned NOT NULL,
recipe_fermentable_fermentable_id mediumint unsigned NOT NULL,
recipe_fermentable_amount float,
recipe_fermentable_use enum('Mashed', 'Steeped', 'Extract', 'Sugar', 'Other'),
PRIMARY KEY (recipe_fermentable_id),
INDEX (recipe_fermentable_recipe_id),
INDEX (recipe_fermentable_fermentable_id)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

// recipes_hops
$query .= "CREATE TABLE recipes_hops
(
recipe_hop_id mediumint unsigned NOT NULL auto_increment,
recipe_hop_recipe_id mediumint unsigned NOT NULL,
recipe_hop_hop_id mediumint unsigned NOT NULL,
recipe_hop_amount float,
recipe_hop_alpha float,
recipe_hop_use enum('Boil', 'Dry Hop', 'Mash', 'First Wort', 'Aroma'),
recipe_hop_time mediumint unsigned,
recipe_hop_form enum('Pellet', 'Plug', 'Leaf'),
PRIMARY KEY (recipe_hop_id),
INDEX (recipe_hop_recipe_id),
INDEX (recipe_hop_hop_id)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

// recipes_yeasts
$query .= "CREATE TABLE recipes_yeasts
(
recipe_yeast_id mediumint unsigned NOT NULL auto_increment,
recipe_yeast_recipe_id mediumint unsigned NOT NULL,
recipe_yeast_yeast_id mediumint unsigned NOT NULL,
PRIMARY KEY (recipe_yeast_id),
INDEX (recipe_yeast_recipe_id),
INDEX (recipe_yeast_yeast_id)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

// recipes_miscs
$query .= "CREATE TABLE recipes_miscs
(
recipe_misc_id mediumint unsigned NOT NULL auto_increment,
recipe_misc_recipe_id mediumint unsigned NOT NULL,
recipe_misc_misc_id mediumint unsigned NOT NULL,
recipe_misc_use enum('Boil', 'Mash', 'Primary', 'Secondary', 'Bottling'),
recipe_misc_amount float,
recipe_misc_unit varchar(255),
PRIMARY KEY (recipe_misc_id),
INDEX (recipe_misc_recipe_id),
INDEX (recipe_misc_misc_id)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

// recipes_persons
$query .= "CREATE TABLE recipes_persons
(
recipe_person_id mediumint unsigned NOT NULL auto_increment,
recipe_person_recipe_id mediumint unsigned NOT NULL,
recipe_person_person_id mediumint unsigned NOT NULL,
recipe_person_is_assistant enum('True', 'False'),
PRIMARY KEY (recipe_person_id),
INDEX (recipe_person_recipe_id),
INDEX (recipe_person_person_id)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

// Brews
$query .= "CREATE TABLE brews
(
brew_id mediumint unsigned NOT NULL auto_increment,
brew_recipe_id mediumint unsigned NOT NULL,
brew_name varchar(255) NOT NULL,
brew_version tinyint unsigned NOT NULL default 1,
brew_type enum('Extract', 'Partial Mash', 'All Grain') NOT NULL default 'All Grain',
brew_style_id mediumint unsigned,
brew_batch_num mediumint unsigned NOT NULL auto_increment,
brew_boil_size float,
brew_boil_time mediumint unsigned,
brew_batch_size float,
brew_mash_temp mediumint unsigned,
brew_mash_time mediumint unsigned,
brew_mash_efficiency float,
brew_fermentation_temp mediumint unsigned,
brew_brewer varchar(255),
brew_notes varchar(511),
brew_date date,
brew_act_og float,
brew_act_fg float,
brew_est_color float,
brew_est_ibu float,
brew_ibu_method enum('Rager', 'Tinseth', 'Garetz') NOT NULL default 'Tinseth',
brew_act_abv float,
PRIMARY KEY (brew_id),
INDEX (brew_name),
INDEX (brew_type),
INDEX (brew_style_id),
INDEX (brew_batch_num)
) AUTO_INCREMENT=200001 CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

// brews_fermentables
$query .= "CREATE TABLE brews_fermentables
(
brew_fermentable_id mediumint unsigned NOT NULL auto_increment,
brew_fermentable_brew_id mediumint unsigned NOT NULL,
brew_fermentable_fermentable_id mediumint unsigned NOT NULL,
brew_fermentable_amount float,
brew_fermentable_use enum('Mashed', 'Steeped', 'Extract', 'Sugar', 'Other'),
PRIMARY KEY (brew_fermentable_id),
INDEX (brew_fermentable_brew_id),
INDEX (brew_fermentable_fermentable_id)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

// brews_hops
$query .= "CREATE TABLE brews_hops
(
brew_hop_id mediumint unsigned NOT NULL auto_increment,
brew_hop_brew_id mediumint unsigned NOT NULL,
brew_hop_hop_id mediumint unsigned NOT NULL,
brew_hop_amount float,
brew_hop_alpha float,
brew_hop_use enum('Boil', 'Dry Hop', 'Mash', 'First Wort', 'Aroma'),
brew_hop_time mediumint unsigned,
brew_hop_form enum('Pellet', 'Plug', 'Leaf'),
PRIMARY KEY (brew_hop_id),
INDEX (brew_hop_brew_id),
INDEX (brew_hop_hop_id)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

// brews_yeasts
$query .= "CREATE TABLE brews_yeasts
(
brew_yeast_id mediumint unsigned NOT NULL auto_increment,
brew_yeast_brew_id mediumint unsigned NOT NULL,
brew_yeast_yeast_id mediumint unsigned NOT NULL,
PRIMARY KEY (brew_yeast_id),
INDEX (brew_yeast_brew_id),
INDEX (brew_yeast_yeast_id)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

// brews_miscs
$query .= "CREATE TABLE brews_miscs
(
brew_misc_id mediumint unsigned NOT NULL auto_increment,
brew_misc_brew_id mediumint unsigned NOT NULL,
brew_misc_misc_id mediumint unsigned NOT NULL,
brew_misc_use enum('Boil', 'Mash', 'Primary', 'Secondary', 'Bottling'),
brew_misc_amount float,
brew_misc_unit varchar(255),
PRIMARY KEY (brew_misc_id),
INDEX (brew_misc_brew_id),
INDEX (brew_misc_misc_id)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

// brews_persons
$query .= "CREATE TABLE brews_persons
(
brew_person_id mediumint unsigned NOT NULL auto_increment,
brew_person_brew_id mediumint unsigned NOT NULL,
brew_person_person_id mediumint unsigned NOT NULL,
brew_person_is_assistant enum('True', 'False'),
PRIMARY KEY (brew_person_id),
INDEX (brew_person_brew_id),
INDEX (brew_person_person_id)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

if (mysqli_multi_query($connection, $query))
	{
	echo 'brewdb tables created...' . '<br />';
	}
	else
	{
	die(mysqli_error($connection));
	}

mysqli_close($connection);

?>

<form action="index.php">
<br>
<input type="submit" value="Back">
</form>

</body>
</html>
