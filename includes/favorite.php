<?php
	include_once "settings.php";
	include_once "session.php";
	if(!isset($_SESSION['username'])) {
		header("Location: http://" . $setting['domain'] . "?msg=please_login");
		exit;
	}
	$query = 'SELECT ID FROM user_db WHERE USERNAME="' . $_SESSION['username'] . '"';
	$result = mysqli_query($mysqli,$query);
	$row = mysqli_fetch_array($result);
	$user_id = $row['ID'];

	$query = 'SELECT FAVORITES FROM image_db WHERE ID=' . $_GET['id'];
	$result = mysqli_query($mysqli,$query);
	$row = mysqli_fetch_array($result);
	if(!isset($row['FAVORITES']))
		$favorites = $user_id;
	else {
		if($row['FAVORITES'] == "") {
			$favorites = $user_id;
		}
		else {
			$favorites = explode(",",$row['FAVORITES']);
			$is_in_array = in_array($user_id,$favorites);

			if($is_in_array) {
				$pos = array_search($user_id, $favorites);
				array_splice($favorites,$pos,1);
			}
			$favorites = implode(",",$favorites);
			if(!$is_in_array)
				$favorites .= "," . $user_id;
		}
	}

	$query = 'UPDATE image_db SET FAVORITES="' . $favorites . '" WHERE ID=' . $_GET['id'];
	$result = mysqli_query($mysqli,$query);
	if(isset($is_in_array)) {
		header("Location: http://" . $setting['domain'] . "image.php?msg=favorite_success_rem&id=" . $_GET['id']);
		exit;
	}
	else {
		header("Location: http://" . $setting['domain'] . "image.php?msg=favorite_success&id=" . $_GET['id']);
		exit;
	}

?>