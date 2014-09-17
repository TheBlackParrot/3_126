<?php
	include_once "settings.php";

	session_start();
	if(isset($_SESSION['username'])) {
		$query = 'SELECT USERNAME,TIMEZONE FROM user_db WHERE USERNAME="' . $_SESSION['username'] . '"';
		$result = mysqli_query($mysqli,$query);
		$row = mysqli_fetch_array($result);
		if(!isset($row['USERNAME'])) {
			session_destroy();
		}
		else {
			$query = 'UPDATE user_db SET LASTACTIVE=' . time() . ' WHERE USERNAME="' . $row['USERNAME'] . '"';
			$result = mysqli_query($mysqli,$query);

			setcookie(session_name(),session_id(),time()+$setting['login_lifetime']);
			date_default_timezone_set($row['TIMEZONE']);
		}
	}
?>