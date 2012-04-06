<?php
	// INCLUDE
	
	include_once('config.inc.php');
	
	// FUNCTIONS

	function db_connect() {
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
	
	function db_movieExistsByImdbId($db_con, $imdb_id) {
		$imdb_id = mysqli_real_escape_string($db_con, $imdb_id);
		$result = mysqli_query($db_con, "
			SELECT 
				*
			FROM 
				movies
			WHERE 
				imdb_id = '$imdb_id'
		");
		if(db_hasErrors($db_con, $result)) {
			return false;
		}
		if (mysqli_num_rows($result)) {
			return true;
		}
		return false;
	}

?>
