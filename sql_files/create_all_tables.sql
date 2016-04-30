CREATE TABLE fermentables
(
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
) AUTO_INCREMENT=10001 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE hops
(
hop_id mediumint unsigned NOT NULL auto_increment,
hop_name varchar(255) NOT NULL,
hop_version tinyint unsigned NOT NULL default 1,
hop_alpha float,
hop_origin varchar(255),
hop_substitutes varchar(255),
PRIMARY KEY (hop_id),
INDEX (hop_name)
) AUTO_INCREMENT=20001 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE yeasts
(
yeast_id mediumint unsigned NOT NULL auto_increment,
yeast_name varchar(255) NOT NULL,
yeast_version tinyint unsigned NOT NULL default 1,
yeast_type enum('Ale', 'Lager', 'Wheat', 'Wine', 'Champagne'),
yeast_form enum('Liquid', 'Dry', 'Slant', 'Culture'),
yeast_laboratory varchar(255),
yeast_product_id varchar(255),
yeast_min_temperature mediumint unsigned,
yeast_max_temperature mediumint unsigned,
yeast_flocculation enum('Low', 'Medium', 'High', 'Very High'),
yeast_attenuation float,
yeast_notes varchar(511),
yeast_best_for varchar(255),
yeast_max_reuse mediumint unsigned,
PRIMARY KEY (yeast_id),
INDEX (yeast_name),
INDEX (yeast_type),
INDEX (yeast_form),
INDEX (yeast_laboratory),
INDEX (yeast_product_id),
INDEX (yeast_flocculation)
) AUTO_INCREMENT=30001 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE miscs
(
misc_id mediumint unsigned NOT NULL auto_increment,
misc_name varchar(255) NOT NULL,
misc_version tinyint unsigned NOT NULL default 1,
misc_type enum('Spice', 'Fining', 'Water Agent', 'Herb', 'Flavor', 'Other'),
PRIMARY KEY (misc_id),
INDEX (misc_name),
INDEX (misc_type)
) AUTO_INCREMENT=40001 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE styles
(
style_id mediumint unsigned NOT NULL auto_increment,
style_name varchar(255) NOT NULL,
style_category varchar(255) NOT NULL,
style_version tinyint unsigned NOT NULL default 1,
style_category_number varchar(255) NOT NULL,
style_style_letter varchar(255) NOT NULL,
style_style_guide varchar(255) NOT NULL,
style_type enum('Lager', 'Ale', 'Mead', 'Wheat', 'Mixed', 'Cider'),
style_og_min float,
style_og_max float,
style_fg_min float,
style_fg_max float,
style_ibu_min float,
style_ibu_max float,
style_color_min float,
style_color_max float,
style_carb_min float,
style_carb_max float,
style_abv_min float,
style_abv_max float,
style_notes varchar(511),
style_profile varchar(511),
style_ingredients varchar(511),
style_examples varchar(511),
PRIMARY KEY (style_id),
INDEX (style_name),
INDEX (style_category),
INDEX (style_category_number),
INDEX (style_style_letter),
INDEX (style_type)
) AUTO_INCREMENT=50001 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE persons
(
person_id mediumint unsigned NOT NULL auto_increment,
person_first_name varchar(255),
person_last_name varchar(255),
PRIMARY KEY (person_id),
INDEX (person_last_name),
INDEX (person_first_name)
) AUTO_INCREMENT=60001 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE preferences
(
preference_id mediumint unsigned NOT NULL auto_increment,
preference_boil_size float,
preference_boil_time float,
preference_evaporation_rate float,
preference_batch_size float,
preference_mash_efficiency float,
PRIMARY KEY (preference_id)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE recipes
(
recipe_id mediumint unsigned NOT NULL auto_increment,
recipe_name varchar(255) NOT NULL,
recipe_version tinyint unsigned NOT NULL default 1,
recipe_type enum('Extract', 'Partial Mash', 'All Grain') NOT NULL default 'All Grain',
recipe_style_id mediumint unsigned,
recipe_batch_size float,
recipe_boil_size float,
recipe_boil_time mediumint unsigned,
recipe_mash_efficiency float,
recipe_designer varchar(255),
recipe_notes varchar(511),
recipe_taste_notes varchar(511),
recipe_taste_rating float,
recipe_og float,
recipe_fg float,
recipe_fermentation_stages mediumint unsigned,
recipe_primary_age mediumint unsigned,
recipe_primary_temp mediumint unsigned,
recipe_secondary_age mediumint unsigned,
recipe_secondary_temp mediumint unsigned,
recipe_tertiary_age mediumint unsigned,
recipe_tertiary_temp mediumint unsigned,
recipe_bottle_age mediumint unsigned,
recipe_bottle_age_temp mediumint unsigned,
recipe_date date,
recipe_brew_date date,
recipe_carbonation float,
recipe_forced_carbonation enum('True', 'False'),
recipe_priming_sugar_name varchar(255),
recipe_carbonation_temp mediumint unsigned,
recipe_priming_sugar_equiv float,
recipe_keg_priming_factor float, 
recipe_est_og float,
recipe_est_fg float,
recipe_est_color float,
recipe_est_ibu float,
recipe_ibu_method enum('Rager', 'Tinseth', 'Garetz') NOT NULL default 'Tinseth',
recipe_est_abv float,
recipe_abv float,
recipe_actual_efficiency float,
PRIMARY KEY (recipe_id),
INDEX (recipe_name),
INDEX (recipe_type),
INDEX (recipe_style_id)
) AUTO_INCREMENT=100001 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE recipes_fermentables
(
recipe_fermentable_id mediumint unsigned NOT NULL auto_increment,
recipe_fermentable_recipe_id mediumint unsigned NOT NULL,
recipe_fermentable_fermentable_id mediumint unsigned NOT NULL,
recipe_fermentable_amount float,
recipe_fermentable_yield float,
recipe_fermentable_color float,
recipe_fermentable_use enum('Mashed', 'Steeped', 'Extract', 'Sugar', 'Other'),
PRIMARY KEY (recipe_fermentable_id),
INDEX (recipe_fermentable_recipe_id),
INDEX (recipe_fermentable_fermentable_id)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE recipes_hops
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
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE recipes_yeasts
(
recipe_yeast_id mediumint unsigned NOT NULL auto_increment,
recipe_yeast_recipe_id mediumint unsigned NOT NULL,
recipe_yeast_yeast_id mediumint unsigned NOT NULL,
recipe_yeast_amount float,
recipe_yeast_amount_is_weight enum('True', 'False'),
recipe_yeast_times_cultured mediumint unsigned,
recipe_yeast_add_to_secondary enum('True', 'False'),
PRIMARY KEY (recipe_yeast_id),
INDEX (recipe_yeast_recipe_id),
INDEX (recipe_yeast_yeast_id)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE recipes_miscs
(
recipe_misc_id mediumint unsigned NOT NULL auto_increment,
recipe_misc_recipe_id mediumint unsigned NOT NULL,
recipe_misc_misc_id mediumint unsigned NOT NULL,
recipe_misc_use enum('Boil', 'Mash', 'Primary', 'Secondary', 'Bottling'),
recipe_misc_time mediumint unsigned,
recipe_misc_amount float,
recipe_misc_amount_is_weight enum('True', 'False'),
recipe_misc_unit varchar(255),
PRIMARY KEY (recipe_misc_id),
INDEX (recipe_misc_recipe_id),
INDEX (recipe_misc_misc_id)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE recipes_persons
(
recipe_person_id mediumint unsigned NOT NULL auto_increment,
recipe_person_recipe_id mediumint unsigned NOT NULL,
recipe_person_person_id mediumint unsigned NOT NULL,
recipe_person_is_assistant enum('True', 'False'),
PRIMARY KEY (recipe_person_id),
INDEX (recipe_person_recipe_id),
INDEX (recipe_person_person_id)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;
