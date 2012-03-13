<?php
	
	// INCLUDES

	include_once('config.inc.php');
	include_once('util.inc.php');
	include_once('admin_functions.inc.php');
	include_once('smarty.inc.php');
	include_once('database.inc.php');
	include_once('movies.inc.php');
	
	// INIT
	
	session_start();
	$db_con = db_connect();
	$smarty = s_init();
	// TODO: rename Movies to model?
	$m = new Movies($db_con);
	
	// DISPLAY
	
	if (isset($_GET['info'])) {
		if (sanitize($_GET['info']) == 'added') {
			$smarty->assign('info', '<li>Submitted</li>');
		} else if (sanitize($_GET['info']) == 'oneup_done') {
			$smarty->assign('info', '<li>OneUp Done</li>');
		} else if (sanitize($_GET['info']) == 'onedown_done') {
			$smarty->assign('info', '<li>OneDown Done</li>');
		}
	}
	if (isset($_GET['error'])) {
		if (sanitize($_GET['error']) == 'oneup_fail') {
			$smarty->assign('error', '<li>OneUp Fail</li>');
		} else if (sanitize($_GET['error']) == 'onedown_fail') {
			$smarty->assign('error', '<li>OneDown Fail</li>');
		}
	}
	if (userLoginValid()) {
		$smarty->assign('logged_in', true);
	}
	$smarty->assign('movies', $m);
	$smarty->display('list.tpl');

?>
