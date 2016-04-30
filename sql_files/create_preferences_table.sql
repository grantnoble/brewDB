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