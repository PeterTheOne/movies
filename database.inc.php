<?php
	// INCLUDE
	
	include_once('config.inc.php');
	
	// FUNCTIONS

	function db_connect() {
		//TODO: error handling..
		$db_con = mysqli_connect(HOST, USERNAME, PASSWD, DBNAME);
		if ($db_con->connect_error) {
			echo "<p>error: $db_con->connect_error</p>";
		}
		$r = $db_con->set_charset("utf8");
		db_hasErrors($db_con, $r);
		return $db_con;
	}
	
	function db_disconnect($db_con) {
		$r = $db_con->close();
		db_hasErrors($db_con, $r);
	}
	
	function db_hasErrors($db_con, $result) {
		if(!$result){
			if (PRINT_DB_ERRORS) {
				echo "<p>error: $db_con->error</p>";
			}
			return true;
		}
		return false;
	}

?>
