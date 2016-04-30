CREATE TABLE recipes_miscs
(
recipe_misc_id mediumint unsigned NOT NULL auto_increment,
recipe_rec_id mediumint unsigned NOT NULL,
misc_rec_id mediumint unsigned NOT NULL,
PRIMARY KEY (recipe_misc_id),
INDEX (recipe_rec_id),
INDEX (misc_rec_id)
);
