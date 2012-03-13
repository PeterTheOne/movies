<?php

	/* SAMPLE_CONFIG RENAME TO config.inc.php */

	/* DATABASE CONFIG */
	define('HOST',		'');
	define('USERNAME',	'');
	define('PASSWD',	'');
	define('DBNAME',	'');
	
	/* ADMIN MENU CONFIG */ // ADMIN_PASS salted with PASSWORD_SALT
	define('ADMIN_USER', 	'');
	define('ADMIN_PASS', 	'');
	
	/* SALT */
	define('SESSION_SALT',	'');
	define('PASSWORD_SALT',	'');
	
	/* OPTIONS */
	define('PRINT_DB_ERRORS', true);
	define('HTTPS_REDIRECT', false);

?>
