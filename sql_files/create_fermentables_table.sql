CREATE TABLE fermentables
(
fermentable_id mediumint unsigned NOT NULL auto_increment,
fermentable_name varchar(255) NOT NULL,
fermentable_version tinyint unsigned NOT NULL default 1,
fermentable_type enum('Grain', 'Extract', 'Dry Extract', 'Sugar', 'Adjunct'),
fermentable_amount float,
fermentable_yield tinyint unsigned,
fermentable_color float,
fermentable_add_after_boil enum('True', 'False'),
fermentable_origin varchar(255),
fermentable_supplier varchar(255),
fermentable_notes varchar(255),
fermentable_coarse_fine_diff tinyint unsigned,
fermentable_moisture tinyint unsigned,
fermentable_diastatic_power float, 
fermentable_protein tinyint unsigned, 
fermentable_max_in_batch tinyint unsigned,
fermentable_recommend_mash enum('True', 'False'),
fermentable_ibu_gal_per_lb float,
fermentable_display_amount varchar(255), 
fermentable_potential float, 
fermentable_inventory varchar(255),
fermentable_display_color varchar(255),
PRIMARY KEY (fermentable_id),
INDEX (fermentable_name)
) AUTO_INCREMENT=10001 CHARACTER SET utf8 COLLATE utf8_unicode_ci;
