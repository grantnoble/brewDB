CREATE TABLE recipes_hops
(
recipe_hop_id mediumint unsigned NOT NULL auto_increment,
recipe_rec_id mediumint unsigned NOT NULL,
hop_rec_id mediumint unsigned NOT NULL,
PRIMARY KEY (recipe_hop_id),
INDEX (recipe_rec_id),
INDEX (hop_rec_id)
);
