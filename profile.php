<?php
	include_once "includes/settings.php";
	include_once "includes/session.php";
?>

<html>

<head>
	<link rel="icon" type="image/png" href="images/favicon.png"/>
	<title>3_126 :: viewing profile ID <?php echo $_GET['user']; ?></title>
	<link rel='stylesheet' type='text/css' href='/booru/css/reset.css'/>
	<link rel='stylesheet' type='text/css' href='/booru/css/main.css'/>
	<meta charset="UTF-8">
	<script src="/booru/js/jquery.js"></script>
	<script>
	$(document).ready(function(){
		$(".info").each(function(){
			$(this).fadeTo(0,0.75);
		})
		$(".image").hover(
			function() {
				$(this).children().fadeTo(80,1);
			}, function() {
				$(this).children().fadeTo(150,0.75);
			}
		)
	});
	</script>
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
						$query = "SELECT USERNAME,ID,DATEADD,MAXRATING,LASTACTIVE,TIMEZONE FROM user_db WHERE ID=" . $_GET['user'];
						$result = mysqli_query($mysqli,$query);

						if(mysqli_num_rows($result) == 1) {
							$row = mysqli_fetch_array($result);
							if(in_array($row['USERNAME'],$setting['admin_list']))
								echo '<h4 style="text-transform: uppercase;">' . $row['USERNAME'] . ' <span style="color: #a5ffbb; font-size: 12pt;">[ADMIN]</span></h4>';
							else
								echo '<h4 style="text-transform: uppercase;">' . $row['USERNAME'] . ' </h4>';
							if(file_exists($setting['image_output'] . 'avatars/' . $_GET['user'] . '.jpg')) {
								echo '<img style="float: left; background-color: #fff;" src="' . $setting['image_output_htmlsafe'] . 'avatars/' . $_GET['user'] . '.jpg"/>';
							}
							else {
								echo '<img style="float: left; background-color: #fff;" src="images/default_user.png"/>';
							}
							echo '<div style="height: 150px;">';
							echo '<table class="profile_t">';
							echo '<tr>';
							echo '<td><strong>ID</strong></td>';
							echo '<td>' . $_GET['user'] . '</td>';
							echo '</tr>';
							echo '<tr>';
							echo '<td><strong>Date Joined</strong></td>';
							echo '<td>' . date('M. d, Y g:i A',$row['DATEADD']) . '</td>';
							echo '</tr>';
							//these need to be coded in later
							echo '<tr>';
							echo '<td><strong>Uploads</strong></td>';
							$query2 = 'SELECT * FROM image_db WHERE UPLOADER="' . $row['USERNAME'] . '"';
							$result = mysqli_query($mysqli,$query2);
							echo '<td>' . mysqli_num_rows($result) . '</td>';
							echo '</tr>';
							echo '<tr>';
							echo '<td><strong>Last Active</strong></td>';
							echo '<td>' . date('M. d, Y g:i A',$row['LASTACTIVE']) . '</td>';
							echo '</tr>';
							echo '</table><br/></div>';
							echo '<h4>TOP POSTS</h4>';
							function getRating($num)
							{
								switch ($num) {
									case 1:
										return "Safe";
										break;
									case 2:
										return "Questionable";
										break;
									case 3:
										return "Explicit";
										break;
								}
							}
							function getRatingColor($num)
							{
								switch ($num) {
									case 1:
										return "#a5ffbb";
										break;
									case 2:
										return "#ffeaa5";
										break;
									case 3:
										return "#ffa5be";
										break;
								}
							}
							$query = 'SELECT * FROM image_db WHERE UPLOADER="' . $row['USERNAME'] . '" ORDER BY VIEWS DESC LIMIT 4';
							$result = mysqli_query($mysqli,$query);
							while($row2 = mysqli_fetch_array($result)) {
								if(!isset($_SESSION['username']))
									$max_rating = $acct_set['guest_rating'];
								else
									$max_rating = $_SESSION['max_rating'];
								if($row2['RATING'] > $max_rating)
									continue;

								if(isset($favorites))
									$favorites = count(explode(",",$row2['FAVORITES']));
								else
									$favorites = 0;
								if($row2['FAVORITES'] == NULL)
									$favorites = 0;
								$thumb_fn = $setting['image_output'] . 'thumbnails/' . $row2['ID'] . '.jpg';
								if(!file_exists($thumb_fn)) {
									$image = new Imagick();
									$image->readImage($setting['image_output'] . $row2['ID'] . "." . $row2['FILE']);
									$image->setFormat("jpg");
									$image->setImageCompression(Imagick::COMPRESSION_JPEG);
									$image->setImageCompressionQuality($setting['thumbnail_quality']);
									$image->thumbnailImage($setting['thumbnail_size'], 0);
									$image->writeImage($thumb_fn);
									$image->clear();
								}
								//$output = $image->getImageBlob();
								echo('<a href="image.php?id=' . $row2['ID'] . '"><div class="image" style="background-image: url(' . $setting['image_output_htmlsafe'] . 'thumbnails/' . $row2['ID'] . '.jpg);">');
								if(time() - (24*60*60) <= $row2['DATEADD'])
									echo('<div class="new_banner">NEW</div>');
								echo('<div class="info">
										<div class="i_l">
											<span style="color: ' . getRatingColor($row2['RATING']) . '; padding-left: 10px;">' . getRating($row2['RATING']) . '</span>
										</div>
										<div class="i_r">
											<span style="color: #add1ff; padding-right: 10px;">◉ ' . $row2['VIEWS'] . '</span>
											<span style="color: #ffa5be; padding-right: 10px;">❤ ' . $favorites . '</span>
											<span style="color: #ffeaa5; padding-right: 10px;">◆ -</span>
										</div>
									</div>
								</div></a>');
							}
						}
						else
							echo 'This user does not exist.';
					?>
				</div>
			</div>
		</div>
	</div>
</body>

</html>
<?php

?>