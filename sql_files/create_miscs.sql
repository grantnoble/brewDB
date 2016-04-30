CREATE TABLE miscs
(
misc_id mediumint unsigned NOT NULL auto_increment,
misc_name varchar(255) NOT NULL,
misc_version tinyint unsigned NOT NULL default 1,
misc_type enum('Spice', 'Fining', 'Water Agent', 'Herb', 'Flavor', 'Other'),
misc_use enum('Boil', 'Mash', 'Primary', 'Secondary', 'Bottling'),
misc_time mediumint unsigned,
misc_amount float,
misc_amount_is_weight enum('True', 'False'),
misc_use_for varchar(255),
misc_notes varchar(255),
misc_display_amount varchar(255),
misc_inventory varchar(255),
misc_display_time varchar(255),
PRIMARY KEY (misc_id),
INDEX (misc_name)
) AUTO_INCREMENT=40001;
