<?php

require_once("database.inc.php");

$db_con = db_connect();

$r = mysqli_query(
	$db_con, 
	"CREATE TABLE IF NOT EXISTS movies_cats (
		id int(11) NOT NULL AUTO_INCREMENT,
		name varchar(200) COLLATE utf8_unicode_ci NOT NULL,
		PRIMARY KEY (id)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2;"
);
echo "create movie_cats table\n<br />";
db_hasErrors($db_con, $r);

$r = mysqli_query(
	$db_con, 
	"INSERT INTO 
		movies_cats (id, name) 
	VALUES 
		(1, 'unsorted');"
);
echo "insert movie_cats: unsorted\n<br />";
db_hasErrors($db_con, $r);

$r = mysqli_query(
	$db_con, 	
	"CREATE TABLE IF NOT EXISTS movies (
		id int(11) NOT NULL AUTO_INCREMENT,
		time_added datetime NOT NULL,
		title varchar(200) COLLATE utf8_unicode_ci NOT NULL,
		year year(4) NOT NULL,
		imdb_id varchar(40) COLLATE utf8_unicode_ci NOT NULL,
		imdb_rating float NOT NULL,
		seen tinyint(1) NOT NULL,
		comment text COLLATE utf8_unicode_ci NOT NULL,
		cat int(11) NOT NULL DEFAULT '1',
		rank int(11) NOT NULL,
		PRIMARY KEY (id)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
);
echo "create movies table\n<br />";
db_hasErrors($db_con, $r);
	
db_disconnect($db_con, $db_con);

?>