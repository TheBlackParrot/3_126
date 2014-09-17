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
	<?php
		if(isset($_GET['search']))
			echo '<title>3_126 :: favorite posts with "' . $_GET['search'] . '"</title>';
		else
			echo '<title>3_126 :: favorite posts</title>';
	?>
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
		$(".show_pages").each(function(){
			$(this).fadeTo(0,0.75);
		})
		$(".show_pages").hover(
			function() {
				$(this).fadeTo(80,1);
			}, function() {
				$(this).fadeTo(150,0.75);
			}
		)
		$(".show_pages").click(function(){
			$(".pagination").toggle(0)
			$(this).css("right","-5000px")
			$(".hide_pages").css("right","16px")
		})
		$(".hide_pages").click(function(){
			$(".pagination").toggle(0)
			$(this).css("right","-5000px")
			$(".show_pages").css("right","16px")
		})
	});
	</script>
</head>

<body>
	<div class="wrapper">
		<?php include "includes/sections/header.php"; ?>
		<div class="content">
			<div class="column1">
				<div class="c_c">
					<h3>Search favorites</h3>
					<form action="">
						<input type="text" name="search">
					</form>
					<hr/>
					<?php include "includes/sections/tags_trending.php"; ?>
				</div>
			</div>
			<div class="column2">
				<?php include "includes/sections/status_messages.php"; ?>
				<div class="c_c">
					<?php
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
						if(!isset($_GET['page']))
							$page = 0;
						else
							$page = $_GET['page']-1;
						$start = $page * $setting['images_on_page'];
						if(!isset($_GET['search']))
							$query = "SELECT * FROM image_db WHERE RATING<=" . $_SESSION['max_rating'] . " ORDER BY ID DESC LIMIT " . $page * $setting['images_on_page'] . ", " . $setting['images_on_page'];
						else {
							$search_words = explode(" ",$_GET['search']);

							$p_query = "";
							for($i=0;$i<count($search_words);$i++) {
								if($i != count($search_words)-1)
									$p_query .= "TAGS LIKE '%" . $search_words[$i] . "%' AND ";
								else
									$p_query .= "TAGS LIKE '%" . $search_words[$i] . "%'";
							}
							//die($p_query);

							$query = "SELECT * FROM image_db WHERE " . $p_query . " AND RATING<=" . $_SESSION['max_rating'] . " ORDER BY ID LIMIT " . $page * $setting['images_on_page'] . ", " . $setting['images_on_page'];
						}
						$result = mysqli_query($mysqli,$query);

						while($row = mysqli_fetch_array($result)) {
							$favorites_array = explode(",",$row['FAVORITES']);
							if(in_array($_SESSION['user_id'],$favorites_array)) {
								$max_rating = $_SESSION['max_rating'];
								if($row['RATING'] > $max_rating)
									continue;

								$favorites = count($favorites_array);

								if($row['FILE'] != "gif")
									$thumb_fn = $setting['image_output'] . 'thumbnails/' . $row['ID'] . '.jpg';
								else
									$thumb_fn = $setting['image_output'] . 'thumbnails/' . $row['ID'] . '.gif';
								if(!file_exists($thumb_fn)) {
									$image = new Imagick();
									$image->readImage($setting['image_output'] . $row['ID'] . "." . $row['FILE']);
									if($row['FILE'] != "gif") {
										$image->setFormat("jpg");
										$image->setImageCompression(Imagick::COMPRESSION_JPEG);
										$image->setImageCompressionQuality($setting['thumbnail_quality']);
										$image->thumbnailImage($setting['thumbnail_size'], 0);
										$image->writeImage($thumb_fn);
									}
									else {
										$image->setFormat("gif");
										$image = $image->coalesceImages();

										foreach ($image as $frame) {
											$frame->thumbnailImage($setting['thumbnail_size'], 0);
											$frame->setImagePage($setting['thumbnail_size'], 0, 0, 0);
										}

										$image = $image->deconstructImages();
										$image->writeImages($thumb_fn,true);
									}
									$image->clear();
								}
								//$output = $image->getImageBlob();
								if($row['FILE'] != "gif")
									echo('<a href="image.php?id=' . $row['ID'] . '"><div class="image" style="background-image: url(' . $setting['image_output_htmlsafe'] . 'thumbnails/' . $row['ID'] . '.jpg);">');
								else
									echo('<a href="image.php?id=' . $row['ID'] . '"><div class="image" style="background-image: url(' . $setting['image_output_htmlsafe'] . 'thumbnails/' . $row['ID'] . '.gif);">');
								if(time() - (24*60*60) <= $row['DATEADD'])
									echo('<div class="new_banner">NEW</div>');
								echo('<div class="info">
										<div class="i_l">
											<span style="color: ' . getRatingColor($row['RATING']) . '; padding-left: 10px;">' . getRating($row['RATING']) . '</span>
										</div>
										<div class="i_r">
											<span style="color: #add1ff; padding-right: 10px;">◉ ' . $row['VIEWS'] . '</span>
											<span style="color: #ffa5be; padding-right: 10px;">❤ ' . $favorites . '</span>
											<span style="color: #ffeaa5; padding-right: 10px;">◆ -</span>
										</div>
									</div>
								</div></a>');
							}
						}
						if(!mysqli_num_rows($result))
							echo 'No results found for "' . $_GET['search'] . '"';
					?>
					<div class="pagination">
						<div>
						<?php
							$toadd = 10;
							// have to take limits off here for correct page numbers, pretty sure this can be worked around but :X
							if(!isset($_GET['search']))
								$query = "SELECT * FROM image_db WHERE RATING<=" . $_SESSION['max_rating'];
							else {
								$search_words = explode(" ",$_GET['search']);

								$p_query = "";
								for($i=0;$i<count($search_words);$i++) {
									if($i != count($search_words)-1)
										$p_query .= "TAGS LIKE '%" . $search_words[$i] . "%' AND ";
									else
										$p_query .= "TAGS LIKE '%" . $search_words[$i] . "%'";
								}
								//die($p_query);

								$query = "SELECT * FROM image_db WHERE " . $p_query . " AND RATING<=" . $_SESSION['max_rating'];
							}
							$result = mysqli_query($mysqli,$query);
							$num_results = 0;
							while($row = mysqli_fetch_array($result)) {
								$favorites_array = explode(",",$row['FAVORITES']);
								if(in_array($_SESSION['user_id'],$favorites_array)) {
									$max_rating = $_SESSION['max_rating'];
									if($row['RATING'] > $max_rating)
										continue;
									$num_results++;
								}
							}
							$max = ceil($num_results / $setting['images_on_page']);
							if(!isset($_GET['page']))
								$page = 1;
							else
								$page = $_GET['page'];
							for($i=$page-10;$i<=$page-1;$i++) {
								if($i <= $max) {
									if($i <= 0) {
										$toadd++;
										continue;
									}
									if(!isset($_GET['search'])) {
										if($i == $page)
											echo '<a href="http://' . $setting['domain'] . '?page=' . $i . '"><div class="page_s">' . $i . '</div></a>';
										else
											echo '<a href="http://' . $setting['domain'] . '?page=' . $i . '"><div class="page">' . $i . '</div></a>';
									}
									else {
										if($i == $page)
											echo '<a href="http://' . $setting['domain'] . '?page=' . $i . '&search=' . $_GET['search'] . '"><div class="page_s">' . $i . '</div></a>';
										else
											echo '<a href="http://' . $setting['domain'] . '?page=' . $i . '&search=' . $_GET['search'] . '"><div class="page">' . $i . '</div></a>';
									}
								}
							}
							for($i=$page;$i<=$page+$toadd;$i++) {
								if($i <= $max) {
									if($i <= 0)
										continue;
									if(!isset($_GET['search'])) {
										if($i == $page)
											echo '<a href="http://' . $setting['domain'] . '?page=' . $i . '"><div class="page_s">' . $i . '</div></a>';
										else
											echo '<a href="http://' . $setting['domain'] . '?page=' . $i . '"><div class="page">' . $i . '</div></a>';
									}
									else {
										if($i == $page)
											echo '<a href="http://' . $setting['domain'] . '?page=' . $i . '&search=' . $_GET['search'] . '"><div class="page_s">' . $i . '</div></a>';
										else
											echo '<a href="http://' . $setting['domain'] . '?page=' . $i . '&search=' . $_GET['search'] . '"><div class="page">' . $i . '</div></a>';
									}
								}
							}
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="show_pages">▲</div>
	<div class="hide_pages">▼</div>
</body>

</html>