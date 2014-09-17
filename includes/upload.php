<?php
	include_once "settings.php";
	include_once "session.php";

	$name = $_FILES['userfile']['name'];
	$size = $_FILES['userfile']['size'];
	$ext = end((explode(".", $name)));
	$allowed_ext = explode(",",$setting['allowed_exts']);
	$date = time();

	if($size > $setting['max_image_filesize']) {
		header("Location: http://" . $setting['domain'] . "upload.php?msg=upload_fail_size");
		exit;
	}

	if(!in_array($ext,$allowed_ext)) {
		header("Location: http://" . $setting['domain'] . "upload.php?msg=upload_fail_type");
		exit;
	}

	$query = "SELECT ID FROM image_db ORDER BY ID DESC LIMIT 1";
	$result = mysqli_query($mysqli,$query);
	$num = mysqli_fetch_array($result);

	$fnum = $num['ID']+1;
	$fname = $setting['image_output'] . $fnum . "." . $ext;
	//echo $fname;
	if(move_uploaded_file($_FILES['userfile']['tmp_name'],$fname)) {
		$query = 'INSERT INTO image_db (FILE, DATEADD, RATING, TAGS, SOURCE, UPLOADER) VALUES ("' . $ext . '",' . $date . ',' . $_POST['rating'] . ',"' . strtolower(str_replace(" ","_",$_POST['tags'])) . '","' . $_POST['source'] . '","' . $_SESSION['username'] . '");';
		$result = mysqli_query($mysqli,$query);
		header("Location: http://" . $setting['domain'] . "?msg=upload_success");
	}
	else {
		header("Location: http://" . $setting['domain'] . "upload.php?msg=upload_fail_general");
		exit;
	}
?>