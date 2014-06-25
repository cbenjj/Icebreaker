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
	</head>
	<header>
	
	</header>
	<body>
			<div class="logo">
				<img src="logoicebreaker.png"/>
			</div>
			<div class="facebook-btn">
			    <a href="<?=ROOT?>fb-login.php?deviceid=<?=$_REQUEST['deviceid']?>"><img src="loginfb.png"/></a>
			</div>
	</body>
</html>