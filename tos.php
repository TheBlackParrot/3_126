<?php
	include_once "includes/settings.php";
	include_once "includes/session.php";
?>

<html>

<head>
	<link rel="icon" type="image/png" href="images/favicon.png"/>
	<title>3_126 :: terms of service</title>
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
					<form action="">
						<input type="text" name="search">
					</form>
					<hr/>
					<?php include "includes/sections/tags_trending.php"; ?>
				</div>
			</div>
			<div class="column2">
				<?php include "includes/sections/status_messages.php"; ?>
				<div class="c_c" style="line-height: 32px;">
					<h4>TERMS OF SERVICE</h4>
					<div style="line-height: 16px;">
						<p>By using 3_126, you agree to the following terms. If you do not agree, please cease using the site.</p>
						<list>
							<li>If you are under 18 years of age, you are using the site with a parent's/guardian's permission.</li>
							<li>If you are under 18 years of age, you must have your filter set to Questionable or under.</li>
							<li>If you are under 16 years of age, you must have your filter set to Safe.</li>
							<li>You use the site as it is, with no warranty, express or implied. 3_126 and its staff are not liable for any damages that could occur from using the site.</li>
							<li>3_126 reserves the right to remove or modify any posts you make on the site, and to modify or remove your account if need be.</li>
						</list><br/>
						<p>Failure to comply with these terms may result in forced removal from the site.</p>
						<p style="font-size: 8pt">If you need to change your filter settings, click on your name on the top bar on the right.</p>
					</div>
					<h4>UPLOAD AGREEMENT</h4>
					<div style="line-height: 16px;">
						<p>You grant us a non-exclusive, royalty-free license to use and archive any works uploaded by you in accordance with this agreement.</p>
					</div>
					<h4>PROHIBITIED CONTENT</h4>
					<div style="line-height: 16px;">
						You may <strong>not</strong> upload any of the following:
						<list>
							<li>Watermarked images</li>
							<li>Real non-furry related images (fursuits are OK)</li>
							<li><strong>ANY</strong> explicit or sexual content involving entities under 18 years of age</li>
							<li>Images with highly visible compression artificats</li>
						</list><br/>
					</div>
					<h4>COPYRIGHT INFRINGEMENT</h4>
					<div style="line-height: 16px;">
						<p>If you believe a post is infringing on your copyright, please email me at <a href="mailto:theblackparrot@rocketmail.com">theblackparrot@rocketmail.com</a> and I will gladly help you in fixing the issue.<br/>We are currently working on a page specifically meant for takedown requests.</p>
					</div>
					<h4>PRIVACY POLICY</h4>
					<div style="line-height: 16px;">
						<p>3_126 will not disclose the IP address, email address, password, or favorited posts of any user except to site administration.<br/>3_126 is allowed to make public everything else, including but not limited to: uploaded posts, comments, and post edits.</p>
					</div>
					<h4>SOURCE CODE</h4>
					<div style="line-height: 16px;">
						<p>3_126 is <strong>open source</strong> and is licensed under the MIT License.</p>
						<pre style="font-family: monospace;">
The MIT License (MIT)

Copyright (c) 2014 TheBlackParrot

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
						</pre>
						<p>This license is included with the source code under LICENSE.txt.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>