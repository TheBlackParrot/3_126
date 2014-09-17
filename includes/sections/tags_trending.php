<?php
include_once dirname(dirname(__FILE__)) . "/session.php";
include_once dirname(dirname(__FILE__)) . "/settings.php";

$query = "SELECT RATING,TAGS FROM image_db ORDER BY ID DESC LIMIT 256";
$result = mysqli_query($mysqli,$query);
while($row = mysqli_fetch_array($result))
{
	if(!isset($_SESSION['username']))
		$max_rating = $acct_set['guest_rating'];
	else
		$max_rating = $_SESSION['max_rating'];
	if($row['RATING'] > $max_rating)
		continue;

	$tags = explode(",",$row['TAGS']);
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
<h3>Trending tags</h3>
<h4>Species</h4>
<?php
//foreach ($variable as $key => $value) {
//	# code...
//}
	if(isset($cat1)) {
		arsort($cat1);
		$cat1 = array_slice($cat1,0,7);
		foreach ($cat1 as $cat => $val) {
			echo '<a href="index.php?search=' . $cat . '" class="cat1">' . str_replace("_"," ",$cat) . '</a> <span style="font-size: 7pt;">(' . $val . ')</span><br/>';
		}
	}
?>
<br/>
<h4>Artist</h4>
<?php
	if(isset($cat2)) {
		arsort($cat2);
		$cat2 = array_slice($cat2,0,7);
		foreach ($cat2 as $cat => $val) {
			echo '<a href="index.php?search=' . $cat . '" class="cat2">' . str_replace("_"," ",$cat) . '</a> <span style="font-size: 7pt;">(' . $val . ')</span><br/>';
		}
	}
?>
<br/>
<h4>Pool</h4>
<?php
	if(isset($cat3)) {
		arsort($cat3);
		$cat3 = array_slice($cat3,0,7);
		foreach ($cat3 as $cat => $val) {
			echo '<a href="index.php?search=' . $cat . '" class="cat3">' . str_replace("_"," ",$cat) . '</a> <span style="font-size: 7pt;">(' . $val . ')</span><br/>';
		}
	}
?>
<br/>
<h4>Character</h4>
<?php
	if(isset($cat4)) {
		arsort($cat4);
		$cat4 = array_slice($cat4,0,7);
		foreach ($cat4 as $cat => $val) {
			echo '<a href="index.php?search=' . $cat . '" class="cat4">' . str_replace("_"," ",$cat) . '</a> <span style="font-size: 7pt;">(' . $val . ')</span><br/>';
		}
	}
?>
<br/>
<h4>Copyright</h4>
<?php
	if(isset($cat5)) {
		arsort($cat5);
		$cat5 = array_slice($cat5,0,7);
		foreach ($cat5 as $cat => $val) {
			echo '<a href="index.php?search=' . $cat . '" class="cat5">' . str_replace("_"," ",$cat) . '</a> <span style="font-size: 7pt;">(' . $val . ')</span><br/>';
		}
	}
?>
<br/>
<h4>Art Style</h4>
<?php
	if(isset($cat6)) {
		arsort($cat6);
		$cat6 = array_slice($cat6,0,7);
		foreach ($cat6 as $cat => $val) {
			echo '<a href="index.php?search=' . $cat . '" class="cat6">' . str_replace("_"," ",$cat) . '</a> <span style="font-size: 7pt;">(' . $val . ')</span><br/>';
		}
	}
?>
<hr/>
<?php
	if(isset($nocat)) {
		arsort($nocat);
		$nocat = array_slice($nocat,0,30);
		foreach ($nocat as $cat => $val) {
			echo '<a href="index.php?search=' . $cat . '">' . str_replace("_"," ",$cat) . '</a> <span style="font-size: 7pt;">(' . $val . ')</span><br/>';
		}
	}
?>