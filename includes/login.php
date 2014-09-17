<?php
	include_once "settings.php";

	$username = mysqli_real_escape_string($mysqli,stripslashes(strtolower(htmlspecialchars($_POST['username']))));
	$password = mysqli_real_escape_string($mysqli,stripslashes(strtolower(htmlspecialchars($_POST['password']))));

	if(strlen($username) >= $acct_set['username_minlen'] && strlen($username) < $acct_set['username_maxlen']) {
		if(strlen($password) >= $acct_set['password_minlen']) {
			$query = 'SELECT * FROM user_db WHERE USERNAME="' . $username . '"';
			$result = mysqli_query($mysqli,$query);

			if(mysqli_num_rows($result) == 1) {
				$row = mysqli_fetch_array($result);
				if($row['PASSWORD'] == hash("sha512",$password . "-:-" . $row['DATEADD'])) {
					session_start();
					$_SESSION['login'] = "1";
					$_SESSION['username'] = $username;
					$_SESSION['max_rating'] = $row['MAXRATING'];
					$_SESSION['user_id'] = $row['ID'];
					header('Location: http://' . $setting['domain'] . "?msg=login_success");
					exit;
				}
				else {
					header("Location: http://" . $setting['domain'] . "login.php?msg=login_fail");
					exit;
				}
			}
			else {
				header("Location: http://" . $setting['domain'] . "login.php?msg=login_fail");
				exit;
			}
		}
		else {
			header("Location: http://" . $setting['domain'] . "login.php?msg=login_fail");
			exit;
		}
	}
	else {
		header("Location: http://" . $setting['domain'] . "login.php?msg=login_fail");
		exit;
	}