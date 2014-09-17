<?php
	include_once "settings.php";

	$query = "SELECT * FROM image_db WHERE ID=" . $_POST['id'];
	$result = mysqli_query($mysqli,$query);
	$num = mysqli_fetch_array($result);
	if(!isset($num)) {
		header("Location: http://" . $setting['domain'] . "edit.php?msg=edit_fail&id=" . $_POST['id']);
		exit;
	}
	else {
		$query = '	UPDATE image_db
					SET RATING=' . $_POST['rating'] . ', 
					TAGS="' . $_POST['tags'] . '", 
					SOURCE="' . $_POST['source'] . '"
					WHERE ID=' . $_POST['id'];
		$result = mysqli_query($mysqli,$query);
		header("Location: http://" . $setting['domain'] . "image.php?msg=edit_success&id=" . $_POST['id']);
		exit;
	}
?>