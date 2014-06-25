<?php require_once 'config.php';?>
<?php
function cmp_by_category($a, $b) {
    return strcmp($a->category, $b->category);
}

$sender_facebookid = $_REQUEST['sender_facebookid'];
$receiver_facebookid = $_REQUEST['receiver_facebookid'];

$mapper = new Mapper();
$sender = $mapper->getUserByFacebookId($sender_facebookid);
$receiver = $mapper->getUserByFacebookId($receiver_facebookid);

$match = $mapper->getMatch($sender, $receiver);

$commonlikes = $mapper->getCommonLikes($sender, $receiver);
usort($commonlikes, "cmp_by_category");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="icebreaker.css" />
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    	<script type="text/javascript">
    		$(document).ready(function($) {
    			$('#accordion').find('.accordion-toggle').click(function(){
    	
    				//Expand or collapse this panel
    				$(this).next().slideToggle('fast');
    	
    				//Hide the other panels
    				$(".accordion-content").not($(this).next()).slideUp('fast');
    	
    			});
    		});
    	</script>
		
	</head>
	<body>

<h1>Hi <?=$receiver->firstname?>, I'm <?=$sender->firstname?>!<br> Wanna meet?</h1>


<h2 class="font2"> Things we have in common</h2>

<div id="accordion">

<div id="accordion">
<?php $i=0; ?>
<?php while ($i < count($commonlikes)) { ?>
<?php $current = $commonlikes[$i]; ?>
<div class="about_me">
<h3 class="accordion-toggle"> <?=$current->category?> <img src="img/dropdown_arrow2.png" /> </h3>
<div class="accordion-content">
<?php while ($i < count($commonlikes) && $current->category==$commonlikes[$i]->category) { ?>
<p><?=$commonlikes[$i]->name?></p>
<?php $i++;?>
<?php } ?>
</div>
</div>        
<?php } ?>
</div>

</div>

<h3><?=$sender->firstname?> says:</h3>
<p class="message"><?=$match->message?></p>
<form action="icebroken.php" method="post">
<input type="hidden" name="matchid" value="<?=$match->id?>" />
<input type="image" src="img/buttonimg.png" alt="Submit" width="90%">
</form>



</body>
</html>