CREATE TABLE recipes
(
recipe_id mediumint unsigned NOT NULL auto_increment,
recipe_name varchar(255) NOT NULL,
recipe_version tinyint unsigned NOT NULL default 1,
recipe_type enum('Extract', 'Partial Mash', 'All Grain'),
recipe_style_id mediumint unsigned,
recipe_brewer_id mediumint unsigned,
recipe_asst_brewer_id mediumint unsigned,
recipe_batch_size float,
recipe_boil_size float,
recipe_boil_time mediumint unsigned,
recipe_efficiency float,
recipe_notes varchar(255),
recipe_taste_notes varchar(255),
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
recipe_carbonation float,
recipe_forced_carbonation enum('True', 'False'),
recipe_priming_sugar_name varchar(255),
recipe_carbonation_temp mediumint unsigned,
recipe_priming_sugar_equiv float,
recipe_keg_priming_factor float, 
recipe_est_og float,
recipe_est_fg float,
recipe_est_color float,
recipe_ibu float,
recipe_ibu_method enum('Rager', 'Tinseth', 'Garetz') NOT NULL default 'Tinseth',
recipe_est_abv float,
recipe_abv float,
recipe_actual_efficiency float,
PRIMARY KEY (recipe_id),
INDEX (recipe_name),
INDEX (recipe_type),
INDEX (recipe_brewer_id),
INDEX (recipe_style_id)
) AUTO_INCREMENT=100001;
