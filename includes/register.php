<?php
	include_once "settings.php";

	$username = mysqli_real_escape_string($mysqli,stripslashes(strtolower(htmlspecialchars($_POST['username']))));
	$password = mysqli_real_escape_string($mysqli,stripslashes(strtolower(htmlspecialchars($_POST['password']))));
	$verify = mysqli_real_escape_string($mysqli,stripslashes(strtolower(htmlspecialchars($_POST['verify']))));
	$bot_check = mysqli_real_escape_string($mysqli,stripslashes(strtolower(htmlspecialchars($_POST['bot_check']))));
	$dateadd = time();

	if($password != $verify)
		die("Passwords do not match, please try again.");
	if($bot_check != 144)
		die("This is needed to make sure you are human. If you cannot answer this question, then you probably do not need to be using 3_126.");

	if(strlen($username) >= $acct_set['username_minlen'] && strlen($username) < $acct_set['username_maxlen']) {
		if(strlen($password) >= $acct_set['password_minlen']) {
			$query = 'SELECT * FROM user_db WHERE USERNAME="' . $username . '"';
			$result = mysqli_query($mysqli,$query);

			if(mysqli_num_rows($result) <= 0) {
				$query = 'INSERT INTO user_db (USERNAME, PASSWORD, DATEADD) VALUES ("' . $username . '", "' . hash("sha512",$password . "-:-" . $dateadd) . '", ' . $dateadd . ')';
				$result = mysqli_query($mysqli,$query);

				session_start();
				$_SESSION['login'] = 1;
				$_SESSION['username'] = $username;
				$_SESSION['max_rating'] = 1;

				header("Location: http://" . $setting['domain'] . "?msg=register_success");
				exit;

			}
			else {
				header("Location: http://" . $setting['domain'] . "register.php?msg=register_fail_taken");
				exit;
			}
		}
		else {
			header("Location: http://" . $setting['domain'] . "register.php?msg=register_fail_limits");
			exit;
		}
	}
	else {
		header("Location: http://" . $setting['domain'] . "register.php?msg=register_fail_limits");
		exit;
	}