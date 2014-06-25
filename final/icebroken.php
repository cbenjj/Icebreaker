<?php require_once 'config.php';?>
<?php 
$matchid = $_POST['matchid'];

$mapper = new Mapper();
$match=$mapper->getMatchById($matchid);
$mapper->completeMatch($match);
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="icebreaker.css" />
	</head>
	<body>

<h1>CONGRATULATIONS! YOU HAVE BROKEN THE ICE!<br /> HAVE FUN!</h1>

</body>
</html>