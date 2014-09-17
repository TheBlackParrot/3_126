<?php
	include_once dirname(dirname(__FILE__)) . "/session.php";
	include_once dirname(dirname(__FILE__)) . "/settings.php";
?>
<div class="header">
	<h4 style="float:left;">3_126</h4>
	<div class="h_link dropdown_s">
		Posts ▼
		<div class="dropdown">
			<ul style="list-style: none;">
				<a href="index.php"><li>All</li></a>
				<?php
					if(isset($_SESSION['username'])) {
						$query = 'SELECT ID FROM user_db WHERE USERNAME="' . $_SESSION['username'] . '"';
						$result = mysqli_query($mysqli,$query);
						$row = mysqli_fetch_array($result);
						echo '<a href="favorites.php"><li>Favorites</li></a>';
					}
				?>
			</ul>
		</div>
	</div>
	<script>
	$(document).ready(function(){
		$(".dropdown_s").on("click",function(){
			$(this).children(".dropdown").fadeIn(100)
		})
		$(".dropdown").on("mouseleave",function(){
			$(this).fadeOut(100)
		})
	});
	</script>
	<?php
		if(!isset($_SESSION['username']))
			$max_rating = $acct_set['guest_rating'];
		else
			$max_rating = $_SESSION['max_rating'];
		$query = 'SELECT ID FROM image_db WHERE RATING<=' . $max_rating;
		$result = mysqli_query($mysqli,$query);
		$count = mysqli_num_rows($result);
		if(isset($_SESSION['username'])) {
			echo '<a href="upload.php"><div class="h_link">Upload</div></a>';
			echo '<div class="h_c"><span style="color: rgba(255,255,255,0.2);">' . substr(sprintf("%07d",$count['ID']),0,7-strlen($count)) . '</span>' . $count . '</div>';
			echo '<a href="includes/logout.php"><div class="h_link_r" style="color: #e695ab;">Logout</div></a>';
			echo '<a href="user_settings.php"><div class="h_link_r">Settings</div></a>';
			echo '<a href="https://' . $setting['domain'] . 'profile.php?user=' . $row['ID'] . '"><div class="h_link_r" style="font-weight: 700;">';
			if(file_exists($setting['image_output'] . 'avatars/' . $row['ID'] . '.jpg')) {
				echo '<img style="width: 32px; border-radius: 5px; vertical-align: middle; margin-bottom: 3px; margin-right: 8px;" src="' . $setting['image_output_htmlsafe'] . 'avatars/' . $row['ID'] . '.jpg"/>';
			}
			else {
				echo '<img style="width: 32px" src="images/default_user.png"/>';
			}
			echo $_SESSION['username'] . '</div></a>';
		}
		else {
			echo '<div class="h_c"><span style="color: rgba(255,255,255,0.2);">' . substr(sprintf("%07d",$count['ID']),0,7-strlen($count)) . '</span>' . $count . '</div>';
			echo '<a href="https://' . $setting['domain'] . 'login.php"><div class="h_link_r" style="color: #95e6a9;">Login</div></a>';
			echo '<a href="https://' . $setting['domain'] . 'register.php"><div class="h_link_r">Register</div></a>';
		}
		echo '<a href="tos.php"><div class="h_link">T.O.S.</div></a>';
	?>
</div>