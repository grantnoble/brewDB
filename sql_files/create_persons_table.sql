CREATE TABLE persons
(
person_id mediumint unsigned NOT NULL auto_increment,
person_first_name varchar(255),
person_last_name varchar(255),
PRIMARY KEY (person_id),
INDEX (person_last_name),
INDEX (person_first_name)
) AUTO_INCREMENT=60001;
