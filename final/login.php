<?php require_once 'config.php';?>
<?php 

$facebook = new Facebook(array(
        'appId'  => FACEBOOK_APPID,
        'secret' => FACEBOOK_SECRET,
));

// Get User ID
$user = $facebook->getUser();

if ($user) {
    header('location:index.php');
}

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="icebreaker.css" />
		<style>
		h3 {
		padding-bottom:100%;
		}
	   </style>
	</head>
	<header>
	
	</header>
	<body>
			<div class="logo">
				<img src="img/logoicebreaker.png"/>
			</div>
			
			<p class="font2"> The easiest way to meet people without leaving your comfort zone.<br>
			Make new friends in your city, country or wherever you are. </p>
			
			<div class="facebook-btn">
			    <a href="<?=ROOT?>fb-login.php?deviceid=<?=$_REQUEST['deviceid']?>"><img src="loginfb.png"/></a>
			</div>
			
			<h3> Opportunity awaits! </h3>
	</body>
</html>