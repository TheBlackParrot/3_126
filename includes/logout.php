<?php
	include_once "settings.php";

	session_start();
	if(session_destroy()) {
		header("Location: http://" . $setting['domain'] . "?msg=logout_success");
	}
?>