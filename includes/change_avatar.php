<?php
	include_once "settings.php";
	include_once "session.php";

	if($_SESSION['id'] != $_POST['id']) {
		header("Location: http://" . $setting['domain'] . "profile.php?msg=settings_fail&user=" . $_POST['id']);
	}

	$name = $_FILES['userfile']['name'];
	$tmpfile = $_FILES['userfile']['tmp_name'];
	$ext = end((explode(".", $name)));
	$allowed_ext = explode(",",$setting['allowed_exts']);

	if($size > $setting['max_image_filesize']) {
		header("Location: http://" . $setting['domain'] . "profile.php?msg=upload_fail_size");
		exit;
	}

	if(!in_array($ext,$allowed_ext)) {
		header("Location: http://" . $setting['domain'] . "profile.php?msg=upload_fail_type");
		exit;
	}

	$fname = $setting['image_output'] . "avatars/" . $_POST['id'] . ".jpg";

	$image = new Imagick();
	$image->readImage($tmpfile);
	$image->setFormat("jpg");
	$image->setImageCompression(Imagick::COMPRESSION_JPEG);
	$image->setImageCompressionQuality(96);
	$image->thumbnailImage(100,100);
	$image->writeImage($fname);
	$image->clear();

	header("Location: http://" . $setting['domain'] . "profile.php?msg=settings_success&user=" . $_POST['id']);
	exit;
?>