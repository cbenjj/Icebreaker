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
		<style type="text/css">
		html {
		  height: 100%;
		}
		body {
		  height: 100%;
		}
		</style>
	</head>
	<body>

    <h1>CONGRATULATIONS! You have broken the ice!<br/>Have fun!</h1>

</body>
</html>