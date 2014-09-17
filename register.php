<?php
	include_once "includes/settings.php";
	include_once "includes/session.php";
	if(isset($_SESSION['username'])) {
		header("Location: http://" . $setting['domain']);
		exit;
	}
?>

<html>

<head>
	<link rel="icon" type="image/png" href="images/favicon.png"/>
	<title>3_126 :: register</title>
	<link rel='stylesheet' type='text/css' href='/booru/css/reset.css'/>
	<link rel='stylesheet' type='text/css' href='/booru/css/main.css'/>
	<meta charset="UTF-8">
	<script src="/booru/js/jquery.js"></script>
</head>

<body>
	<div class="wrapper">
		<?php include "includes/sections/header.php"; ?>
		<?php include "includes/sections/status_messages.php"; ?>
		<div class="content">
			<div class="column1">
				<div class="c_c">
					<h3>Search tags</h3>
					<form action="index.php">
						<input type="text" name="search">
					</form>
					<hr/>
					<?php include "includes/sections/tags_trending.php"; ?>
				</div>
			</div>
			<div class="column2">
				<?php include "includes/sections/status_messages.php"; ?>
				<div class="c_c" style="line-height: 32px;">
					<form action="includes/register.php" method="post">
						<div style="width: 400px;"><span style="text-align: left;">Username</span>
							<div style="float: right;"><input type="text" name="username" style="width: 256px;" placeholder="Username" required></div>
						</div>
						<div style="width: 400px;"><span style="text-align: left;">Password</span>
							<div style="float: right;"><input type="password" name="password" style="width: 256px;" placeholder="Password" required></div>
						</div>
						<div style="width: 400px;"><span style="text-align: left;">Re-type Password</span>
							<div style="float: right;"><input type="password" name="verify" style="width: 256px;" placeholder="Password" required></div>
						</div>
						<div style="width: 400px;"><span style="text-align: left;">What is (3 x 4)<sup>2</sup>?</span>
							<div style="float: right;"><input type="text" name="bot_check" style="width: 256px;" placeholder="3 digit number here" required></div>
						</div>
						<input type="submit" value="Register" class="button"/>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>

</html>
<?php

?>