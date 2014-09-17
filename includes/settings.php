<?php
	// == CONFIGURATION FILE

	// -- SQL --
	// hostname to connect to
	$hostname = "localhost";
	// SQL credentials
	$user = "booru_user";
	$password = "hFLfYTy3HT8gxFTYtheQgfRh";
	// database that stores info for the cache list
	$database = "booru";
	// defines the SQL connection
	$mysqli = new mysqli($hostname, $user, $password, $database);

	// -- TIME --
	date_default_timezone_set('America/Chicago');

	// -- OPTIONS --
	// amount of images to show per page
	$setting['images_on_page'] = 32;
	// output for uploaded files
	$setting['image_output'] = "/srv/http/booru/image_db/";
	$setting['image_output_htmlsafe'] = "/booru/image_db/";
	// maximum file size of images in bytes
	$setting['max_image_filesize'] = 10000000;
	// thumbnail size (width)
	$setting['thumbnail_size'] = 350;
	// thumbnail quality
	$setting['thumbnail_quality'] = 75;
	// allowed filestypes
	$setting['allowed_exts'] = "jpg,jpeg,png,bmp,gif";
	// where the index page is located
	$setting['domain'] = "192.168.1.150/booru/";
	// how long logins are preserved after inactivity in seconds
	$setting['login_lifetime'] = 86400;

	// -- ACCOUNT SETTINGS --
	// default rating for guests
	$acct_set['guest_rating'] = 1;
	// length of usernames
	$acct_set['username_maxlen'] = 32;
	$acct_set['username_minlen'] = 4;
	// length of password
	$acct_set['password_minlen'] = 6;
	// delay between registering accounts in minutes
	$acct_set['register_delay'] = 60;

	// -- ADMINS --
	// separate each user with a comma
	$setting['admin_list'] = array(
		"theblackparrot"
	);
?>