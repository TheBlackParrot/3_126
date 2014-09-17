<?php
include_once "../settings.php";
include_once "../session.php";

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
<?php
	if($rating <= $max_rating) {
		echo '<hr/>';
		echo '<a href="' . $fname . '">Download</a>';
		if(isset($_SESSION['username'])) {
			$query = 'SELECT ID FROM user_db WHERE USERNAME="' . $_SESSION['username'] . '"';
			$result = mysqli_query($mysqli,$query);
			$temp = mysqli_fetch_array($result);
			if(in_array($temp['ID'],$favorites))
				echo '<br/><a href="includes/favorite.php?id=' . $_GET['id'] . '" style="color: #ffa5be;">Unfavorite</a>';
			else
				echo '<br/><a href="includes/favorite.php?id=' . $_GET['id'] . '" style="color: #ffa5be;">Favorite</a>';
			echo '<br/><br/><a href="edit.php?id=' . $_GET['id'] . '">Edit</a>';
			if($uploader == $_SESSION['username'])
				echo '<br/><a href="#" style="color: #ff4477;">Remove</a>';
			else
				echo '<br/><a href="#" style="color: rgba(255,255,255,0.2);">Remove</a>';
		}
		else {
			echo '<br/><a href="#" style="color: rgba(255,255,255,0.2);">Favorite</a>';
			echo '<br/><br/><a href="#" style="color: rgba(255,255,255,0.2);">Edit</a>';
			echo '<br/><a href="#" style="color: rgba(255,255,255,0.2);">Remove</a>';
		}
	}
?>