<?php
	include_once "includes/settings.php";
	include_once "includes/session.php";
	if(!isset($_SESSION['username'])) {
		header("Location: http://" . $setting['domain'] . "?msg=please_login");
		exit;
	}
?>

<html>

<head>
	<link rel="icon" type="image/png" href="images/favicon.png"/>
	<title>3_126 :: settings></title>
	<link rel='stylesheet' type='text/css' href='/booru/css/reset.css'/>
	<link rel='stylesheet' type='text/css' href='/booru/css/main.css'/>
	<meta charset="UTF-8">
	<script src="/booru/js/jquery.js"></script>
</head>

<body>
	<div class="wrapper">
		<?php include "includes/sections/header.php"; ?>
		<div class="content">
			<div class="column1">
				<div class="c_c">
					<h3>Search tags</h3>
					<form>
						<input type="text" name="search">
					</form>
					<hr/>
					<?php include "includes/sections/tags_trending.php"; ?>
				</div>
			</div>
			<div class="column2">
				<?php include "includes/sections/status_messages.php"; ?>
				<div class="c_c" style="line-height: 32px;">
					<?php
						$query = "SELECT USERNAME,ID,MAXRATING,TIMEZONE FROM user_db WHERE ID=" . $_SESSION['user_id'];
						$result = mysqli_query($mysqli,$query);

						if(mysqli_num_rows($result) == 1) {
							$row = mysqli_fetch_array($result);
							if($_SESSION['username'] == $row['USERNAME']) {
								// this really needs to be cleaned up, holy crap.
								echo '<h4>SETTINGS</h4>';
								echo '<form action="includes/profile_settings.php" method="POST">';
								echo '<div style="width: 350px;">';
								echo '<span style="text-align: left;">Maximum Content Rating</span>';
								echo '<div style="float: right;">';
								echo '<select name="max-rating">';
								for($i=1;$i<=3;$i++) {
									switch($i) {
										case 1:
											if($i == $row['MAXRATING'])
												echo '<option value="1" selected>Safe</option>';
											else
												echo '<option value="1">Safe</option>';
											break;

										case 2:
											if($i == $row['MAXRATING'])
												echo '<option value="2" selected>Questionable</option>';
											else
												echo '<option value="2">Questionable</option>';
											break;

										case 3:
											if($i == $row['MAXRATING'])
												echo '<option value="3" selected>Explicit</option>';
											else
												echo '<option value="3">Explicit</option>';
											break;
									}
								}
								echo '</select>';
								echo '</div>';
								echo '</div>';
								echo '<div style="width: 350px;">';
								echo '<span style="text-align: left;">Timezone</span>';
								echo '<div style="float: right;">';
								echo '<select name="timezone">';
								foreach(timezone_identifiers_list() as $timezone) {
									if($timezone == $row['TIMEZONE'])
										echo '<option value="' . $timezone . '" selected>' . $timezone . '</option>';
									else
										echo '<option value="' . $timezone . '">' . $timezone . '</option>';
								}
								echo '</select>';
								echo '</div>';
								echo '</div>';
								echo '<input type="hidden" name="id" value="' . $_SESSION['user_id'] . '">';
								echo '<input type="submit" value="Submit" class="button" style="width: 350px;"/><br/>';
								echo '</form>';
								echo '<strong>Change Avatar/Icon</strong><br/>';
								echo '<form action="includes/change_avatar.php" method="POST" enctype="multipart/form-data">';
								echo '<input type="file" name="userfile" required/>';
								echo '<input type="hidden" name="id" value="' . $_SESSION['user_id'] . '">';
								echo '<input type="submit" value="Upload" class="button" style="width: 121px;"/>';
								echo '</form>';
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
</body>

</html>
<?php

?>