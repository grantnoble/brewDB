CREATE TABLE recipes_persons
(
recipe_person_id mediumint unsigned NOT NULL auto_increment,
recipe_rec_id mediumint unsigned NOT NULL,
person_rec_id mediumint unsigned NOT NULL,
PRIMARY KEY (recipe_person_id),
INDEX (recipe_rec_id),
INDEX (person_rec_id)
);
