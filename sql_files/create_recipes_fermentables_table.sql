CREATE TABLE recipes_fermentables
(
recipe_fermentable_id mediumint unsigned NOT NULL auto_increment,
recipe_rec_id mediumint unsigned NOT NULL,
fermentable_rec_id mediumint unsigned NOT NULL,
PRIMARY KEY (recipe_fermentable_id),
INDEX (recipe_rec_id),
INDEX (fermentable_rec_id)
);
