<?php
	
	// INCLUDES

	include_once('config.inc.php');
	include_once('util.inc.php');
	include_once('admin_functions.inc.php');
	include_once('movies.inc.php');
	
	// INIT
	
	$db_con = db_connect();
	$m = new Movies($db_con);
	
	// SECURITY
	
	session_start();
	if (!userLoginValid()) {
		header('Location: admin_login.php');
		exit;
	}
	
	// FUNCTIONS
	
	function isFormSubmit() {
		return isset($_GET['oneup']) 
				|| isset($_GET['onedown']);
	}
	
	function isValidForm() {
		global $error;
		// empty
		return !isset($error);
	}
	
	function processForm($db_con) {
		global $m;
		global $error;
		if (isset($_GET['oneup'])) {
			$oneUpId = sanitize($_GET['oneup']);
			if ($m->oneUp($oneUpId)) {
				header('Location: index.php?info=oneup_done');
				exit;
			} else {
				header('Location: index.php?error=oneup_fail');
				exit;
			}
		} else if (isset($_GET['onedown'])) {
			$oneDownId = sanitize($_GET['onedown']);
			if ($m->oneDown($oneDownId)) {
				header('Location: index.php?info=onedown_done');
				exit;
			} else {
				header('Location: index.php?error=onedown_fail');
				exit;
			}
		}
	}
	
	// LOGIC
	
	if (isFormSubmit()) {
		if (isValidForm()) {
			processForm($db_con);
		}
	}
	
?>
