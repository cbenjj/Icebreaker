<?php require_once 'config.php';?>

<?php 
$sender_facebookid = $_REQUEST['sender_facebookid'];
$receiver_facebookid = $_REQUEST['receiver_facebookid'];

$mapper = new Mapper();
$sender = $mapper->getUserByFacebookId($sender_facebookid);
$receiver = $mapper->getUserByFacebookId($receiver_facebookid);

$commonlikes = $mapper->getCommonLikes($sender, $receiver);
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="icebreaker.css" />
	</head>
	<body>

        <h1>Hi <?=$sender->firstname?>, I'm <?=$receiver->firstname?> <br /> Wanna meet?</h1>
        
        <form method="POST" action="<?=ROOT?>controller.php">
        <input type="hidden" name="action" value="sendmessage" />
        <input type="hidden" name="deviceid" value="testDevice" />
        
        <input type="hidden" name="senderid" value="<?=$sender_facebookid?>" />
        <input type="hidden" name="receiverid" value="<?=$receiver_facebookid?>" />
        Recognize me by
        <br>
        <input class="textbox" type="text" name="message" maxlength="140" /><br>
        <button class="local-btn" type="submit">Break the Ice!<img src="hammer.png"/></button>
        </form>
        
        <br>
        
        <h2 class="font2"> Things we have in common </h2>
        
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