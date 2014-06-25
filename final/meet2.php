<?php require_once 'config.php';?>
<?php 
$sender_facebookid = $_REQUEST['sender_facebookid'];
$receiver_facebookid = $_REQUEST['receiver_facebookid'];

$mapper = new Mapper();
$sender = $mapper->getUserByFacebookId($sender_facebookid);
$receiver = $mapper->getUserByFacebookId($receiver_facebookid);

$match = $mapper->getMatch($sender, $receiver);
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="icebreaker.css" />
	</head>
	<body>

<h1>Hi <?=$receiver->firstname?>, I'm <?=$sender->firstname?>!<br> Wanna meet?</h1>
<p class="message"><?=$match->message?></p>
<form action="icebroken.php" method="post">
<input type="hidden" name="matchid" value="<?=$match->id?>" />
<button class="local-btn" type="submit">Break the Ice!<img src="hammer.png"/></button>
</form>
<br>

<h2 class="font2"> Things we have in common</h2>

<div class="about_me">
<h3> Music </h3>
<p>The best type of music </p>
</div>

<div class="about_me">
<h3> Movies  </h3>
<p>The best type of movies </p>
</div>

<div class="about_me">
<h3> Sports  </h3>
<p>The best type of sports </p>
</div>


</body>
</html>