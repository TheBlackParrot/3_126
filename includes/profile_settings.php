<?php
	include_once "settings.php";
	include_once "session.php";

	if($_SESSION['user_id'] != $_POST['id']) {
		header("Location: http://" . $setting['domain'] . "profile.php?msg=settings_fail&user=" . $_POST['id']);
	}

	//$query = 'SELECT MAXRATING FROM user_db WHERE USERNAME="' . $_SESSION['username'] . '"';
	//$result = mysqli_query($mysqli,$query);
	//$row = mysqli_fetch_array($result);

	$query = 'UPDATE user_db SET MAXRATING=' . $_POST['max-rating'] . ', TIMEZONE="' . $_POST['timezone'] . '" WHERE USERNAME="' . $_SESSION['username'] . '"';
	$result = mysqli_query($mysqli,$query);
	$_SESSION['max_rating'] = $_POST['max-rating'];
	$_SESSION['timezone'] = $_POST['timezone'];

	header("Location: http://" . $setting['domain'] . "user_settings.php?msg=settings_success&user=" . $_POST['id']);
	exit;
?>