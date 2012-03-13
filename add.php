<?php
	
	// INCLUDES

	include_once('config.inc.php');
	include_once('admin_functions.inc.php');
	include_once('smarty.inc.php');
	include_once('movies.inc.php');
	
	// INIT
	
	$db_con = db_connect();
	$smarty = s_init();
	$m = new Movies($db_con);
	
	// SECURITY
	
	session_start();
	if (!userLoginValid()) {
		header('Location: admin_login.php');
		exit;
	} else {
		$smarty->assign('logged_in', true);
	}
	
	// FUNCTIONS
	
	function isFormSubmit() {
		return isset($_POST['title']);
	}
	
	function isValidForm() {
		global $error;
		if (!isTokenValid()) {
			$error .= "<li>token invalid</li>\n";
		}
		if (!isset($_POST['title']) || isEmpty($_POST['title'])) {
			$error .= "<li>title not set</li>\n";
		}
		if (!isset($_POST['year']) || isEmpty($_POST['year'])) {
			$error .= "<li>year not set</li>\n";
		}
		if (!isset($_POST['imdb_id']) || isEmpty($_POST['imdb_id'])) {
			$error .= "<li>imdb_id not set</li>\n";
		}
		if (!isset($_POST['imdb_rating']) || isEmpty($_POST['imdb_rating'])) {
			$error .= "<li>imdb_rating not set</li>\n";
		}
		if (!isset($_POST['comment']) || isEmpty($_POST['comment'])) {
			$error .= "<li>comment not set</li>\n";
		}
		if (!isset($_POST['catradio']) || isEmpty($_POST['catradio'])) {
			$error .= "<li>catradio not set</li>\n";
		} else {
			$catradio = sanitize($_POST['catradio']);
			if ($catradio == 'cat') {
				if (!isset($_POST['cat']) || isEmpty($_POST['cat'])) {
					$error .= "<li>cat not set</li>\n";
				}
			} else if ($catradio == 'newcat') {
				if (!isset($_POST['newcat']) || isEmpty($_POST['newcat'])) {
					$error .= "<li>newcat not set</li>\n";
				}
			}
		}
		return !isset($error);
	}
	
	// TODO: move db-queries to database.inc.php ?
	function processForm($db_con) {
		global $m;
		global $error;
		
		if (sanitize($_POST['catradio']) == 'newcat') {
			//TODO: check for security sanitize..
			$newcat = sanitize($_POST['newcat']);
			$result = mysqli_query(
				$db_con, 
				"INSERT INTO 
					movies_cats (
						name
					)
				VALUES (
					'$newcat'
				)"
			);
			if(db_hasErrors($db_con, $result)) {
				$error .= '<li>Couldnt insert new movie cat</li>';
				return;
			}
			$cat = mysqli_insert_id($db_con);
		}
		
		if (!isset($cat)) {
			$cat = sanitize($_POST['cat']);
		}
		
		
		if (quote_string($db_con, $_POST['seen']) === "'on'") {
			$seen = 1;
		} else {
			$seen = 0;
		}
		
		$q = "
			SELECT 
				MAX(rank) as maxRank 
			FROM 
				movies
		";
		$statsResult = mysqli_query($db_con, $q);
		$statsRow = mysqli_fetch_array($statsResult);
		$rank = $statsRow['maxRank'] + 1;
		
		if ($_POST['imdb_rating'] == 'N/A') {
			$imdb_rating = -1;
		} else {
			$imdb_rating = $_POST['imdb_rating'];
		}
	
		$q = sprintf("
			INSERT INTO 
				movies (
					time_added, 
					title, 
					year, 
					imdb_id, 
					imdb_rating, 
					seen, 
					comment, 
					cat, 
					rank
				) 
			VALUES (
				NOW(), 
				%s, 
				%s, 
				%s, 
				%s, 
				%s, 
				%s, 
				%s, 
				%s
			)
			",
			quote_string($db_con, $_POST['title']), 
			quote_string($db_con, $_POST['year']), 
			quote_string($db_con, $_POST['imdb_id']), 
			quote_string($db_con, $imdb_rating), 
			quote_string($db_con, $seen), 
			quote_string($db_con, $_POST['comment']), 
			quote_string($db_con, $cat), 
			quote_string($db_con, $rank));
			
		$result = mysqli_query($db_con, $q);
		if (!db_hasErrors($db_con, $result)) {
			header('Location: index.php?info=added');
			exit;
		} else {
			$error .= '<li>MySQL error</li>';
		}
	}
	
	// LOGIC
	
	if (isFormSubmit()) {
		if (isValidForm()) {
			processForm($db_con);
		}
	}
	
	// DISPLAY
	
	paramSmarty($smarty, 'title');
	paramSmarty($smarty, 'year');
	paramSmarty($smarty, 'imdb_id');
	paramSmarty($smarty, 'imdb_rating');
	paramSmarty($smarty, 'seen');
	paramSmarty($smarty, 'comment');
	paramSmarty($smarty, 'catradio');
	paramSmarty($smarty, 'cat');
	paramSmarty($smarty, 'newcat');
	
	if (isset($error)) {
		$smarty->assign('error', $error);
	}
	$smarty->assign('cats', $m->getCats(true));
	$smarty->assign('token', createToken());
	$smarty->display('add.tpl');
	
?>
