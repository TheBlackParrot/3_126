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
	<title>3_126 :: uploading image</title>
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
					<form action="includes/upload.php" method="post" enctype="multipart/form-data">
						<div style="width: 320px;">
							<span style="text-align: left;">Rating</span>
							<div style="float: right;"><select name="rating">
								<option value="1">Safe</option>
								<option value="2">Questionable</option>
								<option value="3">Explicit</option>
							</select></div>
						</div>
						<div style="width: 320px;"><span style="text-align: left;">Tags</span>
							<div style="float: right;"><input type="text" name="tags" style="width: 256px;" required></div>
						</div>
						<div style="width: 320px;"><span style="text-align: left;">Source</span>
							<div style="float: right;"><input type="text" name="source" style="width: 256px;" required></div>
						</div>
						<input type="file" name="userfile" required/>
						<input type="submit" value="Upload" class="button" style="width: 91px;"/>
					</form>
					<span style="font-size: 8pt;">* Separate tags with commas</span><br/>
					<hr/>
					<h4>FILE LIMITATIONS</h4>
					<div style="line-height: 16px;">
						<strong>File size:</strong> <?php echo round($setting['max_image_filesize']/1024/1024,1) . 'MB'; ?><br/>
						<strong>File types:</strong>
						<?php
							$temp = explode(",",$setting['allowed_exts']);
							$temp = implode(", ",$temp);
							echo $temp;
						?>
					</div>
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
					<hr/>
					<h4>PROHIBITIED CONTENT</h4>
					<div style="line-height: 16px;">
						<list>
							<li>Watermarked images</li>
							<li>Real non-furry related images</li>
							<li><strong>ANY</strong> explicit or sexual content involving entities under 18 years of age</li>
							<li>Images with highly visible compression artificats</li>
						</list>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>
<?php

?>