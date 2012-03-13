<?php


/* 
 * TODO: write documentation
 */
function sanitize($str) {
	return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

/* 
 * TODO: write documentation
 */
function param($name) {
	return isset($_POST[$name]) ? sanitize($_POST[$name]) : "";
}

/* 
 * TODO: write documentation
 */
function paramSmarty($smarty, $name) {
	if (isset($_POST[$name])) {
		$smarty->assign('param_' . $name, sanitize($_POST[$name]));
	}
}

/* 
 * returns true, if post-parameter $name consists of nothing
 * but maybe whitespaces
 */
function isEmpty($string) {
	if (strlen(trim($string)) == 0) {
		return true;
	}
	return false;
}

/*
 * returns $value save for database input:
 * - stripslashes, if necessary
 * - quote, if not integer
 */
function quote_string($connection, $value) {
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}
	if (!is_int($value)) {
		$value = "'" . mysqli_real_escape_string($connection, $value) . "'";
	}
	return $value;
}

/* 
 * prints arrays nicely formated
*/
function printarray($arr) {
	echo "<pre>" . print_r($arr) . "</pre>";
}

?>
