<?php
	include_once dirname(dirname(__FILE__)) . "/settings.php";
	
	if(isset($_GET['msg'])) {
		switch ($_GET['msg']) {
			case "login_success":
				$msg = '<div class="status_message_s"><strong>Success!</strong> You are now logged in.';
				break;
			case "login_fail":
				$msg = '<div class="status_message_e"><strong>Woops!</strong> The username or password you entered is incorrect.';
				break;
			case "logout_success":
				$msg = '<div class="status_message_s"><strong>Success!</strong> You have been logged out.';
				break;
			case "register_success":
				$msg = '<div class="status_message_s"><strong>Success!</strong> You are now registered. Enjoy your stay!';
				break;
			case "register_fail_general":
				$msg = '<div class="status_message_e"><strong>Woops!</strong> Something went wrong with registering, please try again.';
				break;
			case "register_fail_taken":
				$msg = '<div class="status_message_e"><strong>Woops!</strong> This username is already taken, please use a different username.';
				break;
			case "register_fail_limits":
				$msg = '<div class="status_message_e"><strong>Woops!</strong> Usernames must be between ' . $acct_set['username_minlen'] . ' and ' . $acct_set['username_maxlen'] . ' characters. Passwords must be greater than ' . $acct_set['password_minlen'] . ' characters.';
				break;
			case "upload_success":
				$msg = '<div class="status_message_s"><strong>Success!</strong> Your image was successfully posted.';
				break;
			case "upload_fail_general":
				$msg = '<div class="status_message_e"><strong>Woops!</strong> Something went wrong with posting, please try again.';
				break;
			case "upload_fail_type":
				$temp = explode(",",$setting['allowed_exts']);
				$temp = implode(", ",$temp);
				$msg = '<div class="status_message_e"><strong>Woops!</strong> Images can only be the following filetypes: ' . $temp . '.';
				break;
			case "upload_fail_size":
				$msg = '<div class="status_message_e"><strong>Woops!</strong> Images must be smaller than ' . round($setting['max_image_filesize']/1024/1024,1) . 'MB.';
				break;
			case "settings_success":
				$msg = '<div class="status_message_s"><strong>Success!</strong> Your settings have been updated.';
				break;
			case "settings_fail":
				$msg = '<div class="status_message_e"><strong>Woops!</strong> Something went wrong with updating your settings, please try again.';
				break;
			case "edit_success":
				$msg = '<div class="status_message_s"><strong>Success!</strong> Post successfully updated.';
				break;
			case "edit_fail":
				$msg = '<div class="status_message_e"><strong>Woops!</strong> Something went wrong with editing the post, please try again.';
				break;
			case "favorite_success":
				$msg = '<div class="status_message_s"><strong>Success!</strong> Post added to your favorites.';
				break;
			case "favorite_success_rem":
				$msg = '<div class="status_message_s"><strong>Success!</strong> Post removed from your favorites.';
				break;
			case "please_login":
				$msg = '<div class="status_message_e"><strong>Woops!</strong> Please login in order to view this page.';
				break;
		}
		if(isset($msg))
			echo $msg . '<span class="status_message_close">×</span></div>';
	}
?>
<script>
$(document).ready(function(){
	$(".status_message_close").on("click",function(){
		$(this).parent().fadeOut(250,function(){
			$(this).remove();
		})
	})
});
</script>