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
	<title>3_126 :: editing ID <?php echo $_GET['id']; ?></title>
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
					<?php
					$query = "SELECT * FROM image_db WHERE ID=" . $_GET['id'];
					$result = mysqli_query($mysqli,$query);
					while($row = mysqli_fetch_array($result))
					{
						$fname = $setting['image_output_htmlsafe'] . $_GET['id'] . "." . $row['FILE'];
						$source = $row['SOURCE'];
						$ext = $row['FILE'];
						$rating = $row['RATING'];
						$tags = explode(",",$row['TAGS']);
						$views = $row['VIEWS'];
						$uploader = $row['UPLOADER'];
						$dateadd = date('M. d, Y g:i A',$row['DATEADD']);
						$favorites = explode(",",$row['FAVORITES']);
						foreach ($tags as $tag) {
							if(substr($tag,0,5) == "spec:") {
								if(!isset($cat1[substr($tag,5)]))
									$cat1[substr($tag,5)] = 0;
								$cat1[substr($tag,5)]++;
								continue;
							}
							if(substr($tag,0,5) == "arti:") {
								if(!isset($cat2[substr($tag,5)]))
									$cat2[substr($tag,5)] = 0;
								$cat2[substr($tag,5)]++;
								continue;
							}
							if(substr($tag,0,5) == "pool:") {
								if(!isset($cat3[substr($tag,5)]))
									$cat3[substr($tag,5)] = 0;
								$cat3[substr($tag,5)]++;
								continue;
							}
							if(substr($tag,0,5) == "char:") {
								if(!isset($cat4[substr($tag,5)]))
									$cat4[substr($tag,5)] = 0;
								$cat4[substr($tag,5)]++;
								continue;
							}
							if(substr($tag,0,5) == "copy:") {
								if(!isset($cat5[substr($tag,5)]))
									$cat5[substr($tag,5)] = 0;
								$cat5[substr($tag,5)]++;
								continue;
							}
							if(substr($tag,0,5) == "styl:") {
								if(!isset($cat6[substr($tag,5)]))
									$cat6[substr($tag,5)] = 0;
								$cat6[substr($tag,5)]++;
								continue;
							}
							if(!isset($nocat[$tag]))
								$nocat[$tag] = 0;
							$nocat[$tag]++;
						}
					}
					?>
					<h3>Tags</h3>
					<h4>Species</h4>
					<?php
					//foreach ($variable as $key => $value) {
					//	# code...
					//}
						if(isset($cat1)) {
							arsort($cat1);
							foreach ($cat1 as $cat => $val) {
								echo '<a href="index.php?search=' . $cat . '" class="cat1">' . str_replace("_"," ",$cat) . '</a><br/>';
							}
						}
					?>
					<br/>
					<h4>Artist</h4>
					<?php
						if(isset($cat2)) {
							arsort($cat2);
							foreach ($cat2 as $cat => $val) {
								echo '<a href="index.php?search=' . $cat . '" class="cat2">' . str_replace("_"," ",$cat) . '</a><br/>';
							}
						}
					?>
					<br/>
					<h4>Pool</h4>
					<?php
						if(isset($cat3)) {
							arsort($cat3);
							foreach ($cat3 as $cat => $val) {
								echo '<a href="index.php?search=' . $cat . '" class="cat3">' . str_replace("_"," ",$cat) . '</a><br/>';
							}
						}
					?>
					<br/>
					<h4>Character</h4>
					<?php
						if(isset($cat4)) {
							arsort($cat4);
							foreach ($cat4 as $cat => $val) {
								echo '<a href="index.php?search=' . $cat . '" class="cat4">' . str_replace("_"," ",$cat) . '</a><br/>';
							}
						}
					?>
					<br/>
					<h4>Copyright</h4>
					<?php
						if(isset($cat5)) {
							arsort($cat5);
							foreach ($cat5 as $cat => $val) {
								echo '<a href="index.php?search=' . $cat . '" class="cat5">' . str_replace("_"," ",$cat) . '</a><br/>';
							}
						}
					?>
					<br/>
					<h4>Art Style</h4>
					<?php
						if(isset($cat6)) {
							arsort($cat6);
							foreach ($cat6 as $cat => $val) {
								echo '<a href="index.php?search=' . $cat . '" class="cat6">' . str_replace("_"," ",$cat) . '</a><br/>';
							}
						}
					?>
					<hr/>
					<?php
						if(isset($nocat)) {
							arsort($nocat);
							foreach ($nocat as $cat => $val) {
								echo '<a href="index.php?search=' . $cat . '">' . $cat . '</a><br/>';
							}
						}
					?>
					<hr/>
					<?php
						if(!isset($_SESSION['username']))
							$max_rating = $acct_set['guest_rating'];
						else
							$max_rating = $_SESSION['max_rating'];

						$image = new Imagick($setting['image_output'] . $_GET['id'] . "." . $ext);
						$geo = $image->getImageGeometry();
						$res = $geo['width'] . "x" . $geo['height'];
						$size = filesize($setting['image_output'] . $_GET['id'] . "." . $ext);
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
						if($rating <= $max_rating) {
							$views++;
							$query = '	UPDATE image_db
										SET VIEWS=' . $views . '
										WHERE ID=' . $_GET['id'];
							$result = mysqli_query($mysqli,$query);
						}
					?>
					<h3>Properties</h3>
					<strong>Uploader</strong><br/>
					<?php echo $uploader; ?><br/><br/>
					<strong>Uploaded on</strong><br/>
					<?php echo $dateadd; ?><br/><br/>
					<strong>Resolution</strong><br/>
					<?php echo $res; ?><br/><br/>
					<strong>File type</strong><br/>
					<?php echo $ext; ?><br/><br/>
					<strong>File size</strong><br/>
					<?php echo round($size/1024) . "KB"; ?><br/><br/>
					<strong>Rating</strong><br/>
					<span style="color: <?php echo getRatingColor($rating); ?>;"><?php echo getRating($rating); ?></span>
					<br/><br/>
					<a href="<?php echo $source; ?>" style="font-size: 11pt;"><strong>Source</strong></a><br/>
				</div>
			</div>
			<?php
				$query = "SELECT * FROM image_db WHERE ID=" . $_GET['id'];
				$result = mysqli_query($mysqli,$query);
				$row = mysqli_fetch_array($result);
			?>
			<div class="column2">
				<?php include "includes/sections/status_messages.php"; ?>
				<div class="c_c" style="line-height: 32px;">
					<form action="includes/edit.php" method="post">
						<div style="width: 320px;"><span style="text-align: left;">Rating</span>
							<div style="float: right;"><select name="rating">
								<?php
									for($i=1;$i<=3;$i++) {
										switch($i) {
											case 1:
												if($i == $row['RATING'])
													echo '<option value="1" selected>Safe</option>';
												else
													echo '<option value="1">Safe</option>';
												break;

											case 2:
												if($i == $row['RATING'])
													echo '<option value="2" selected>Questionable</option>';
												else
													echo '<option value="2">Questionable</option>';
												break;

											case 3:
												if($i == $row['RATING'])
													echo '<option value="3" selected>Explicit</option>';
												else
													echo '<option value="3">Explicit</option>';
												break;
										}
									}
								?>
							</select></div>
						</div>
						<div style="width: 320px;"><span style="text-align: left;">Tags</span>
							<div style="float: right;"><input type="text" name="tags" style="width: 256px;" value="<?php echo $row['TAGS']; ?>" required></div>
						</div>
						<div style="width: 320px;"><span style="text-align: left;">Source</span>
							<div style="float: right;"><input type="text" name="source" style="width: 256px;" value="<?php echo $row['SOURCE']; ?>" required></div>
						</div>
						<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"> 
						<input type="submit" value="Submit" class="button" style="width: 320px;"/>
					</form>
					<span style="font-size: 8pt;">* Separate tags with commas</span>
					<hr/>
					<h4>SOURCES</h4>
					<div style="line-height: 16px;">
						<p>To avoid confusion between 3_126, and e621/e926, the site will also follow their <a href="https://e621.net/wiki/show?title=avoid_posting">do not post</a> list.</p>
						<p>Valid sources come from an artist's gallery, be it on FA, SoFurry, Pixiv, etc. Blogs do not count as valid sources, nor anything the artist does not control.<br/>If you are an artist uploading your own art, set your source to your gallery, or if one does not exist for you, link to your artist tag here.</p>
					</div>
					<hr/>
					<h4>TAGGING</h4>
					<div style="line-height: 16px;">
						<p>There are 6 tag categories in 3_126: character, species, artist, pool, copyright, and art style.</p>
						<div style="width: 49%; float: left; line-height: 16px;">
							<p><strong>Character</strong> refers to either the name of the character(s) in the image, or an FA/Weasyl/SoFurry/etc. account of the owner. Only use the owner for a character tag if a specific name for said character cannot be found.<br/><span style="font-size: 8pt;"><strong>usage: </strong>char:fox_mccloud</span></p>
							<p><strong>Artist</strong> refers to the artist of the image. If it is a photograph, the photographer counts as the artist. <em>If an artist cannot be found for the image, <strong>do not upload it.</strong></em><br/><span style="font-size: 8pt;"><strong>usage: </strong>arti:rukis</span></p>
							<p><strong>Copyright</strong> refers to an entity that owns the character, e.g. a company (Nintendo) or brand (Frosted Flakes). Fan art usually falls within this category.<br/><span style="font-size: 8pt;"><strong>usage: </strong>copy:nintendo</span></p>
						</div>
						<div style="width: 49%; float: right; line-height: 16px;">
							<p><strong>Species</strong> refers to the species depectied in all characters. Extremely vague to extremely specific species (hybrids included) count as a species tag. If multiple species are in an image, tag each one.<br/><span style="font-size: 8pt;"><strong>usage: </strong>spec:german_shepard</span></p>
							<p><strong>Pool</strong> refers to a group of images that correspond with each other, usually as a story or comic. <em>Do not tag your character as a pool, that is what the character tag is for.</em><br/><span style="font-size: 8pt;"><strong>usage: </strong>pool:red_lantern</span></p>
							<p><strong>Art style</strong> refers to the style of art of the image. Traditional or digital, sketch, vector, lineart, etc. are examples to be used with this tag.<br/><span style="font-size: 8pt;"><strong>usage: </strong>styl:traditional</span>
						</div><br/>
						<p>Anything that doesn't fit with the specific tags are inserted as general tags. "male", "solo", "gay", "straight", and etc. for example are considered general tags.</p>
						<p>If you forget to add a tag, or someone else sees something that can be added or removed, they are free to do so. Their change will be listed under the change listings of the post (TODO: ADD THIS), and any abuse can be reported to an admin (TODO: ALSO DO THIS).</p>
						<p>Unlike e621/e926, if you can find the gender a character identifies as, <strong>use that gender</strong>. If one cannot be found, assume "ambiguous_gender" if it cannot be safely identified, otherwise use what the character appears to be biologically.</p>
						<hr/>
						<p>A tag string may look like the following, use this for reference if you would like to.<br/><span style="font-size: 8pt;">styl:digital,arti:furry_artist_2k16,spec:dog,spec:canine,spec:husky,spec:wolf,char:huzkerz,char:d_shep,male,couple,friends,cards,gambling,inside,topless,beer,drunk</span></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>
<?php

?>