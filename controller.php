<?php 

require_once 'dal/Mapper.php';


$action=$_POST['action'];

	$senderid=$_POST['senderid'];
	
	
	$receiverid=$_POST['receiverid'];

switch ($action)
{


	case 'sendmessage':
	sendMessageLocal();
	break;
	
	
	case 'deviceidget':
	getUserByDeviceIdLocal();
	break;
	
	case 'matchget':
	getMatchLocal();
	break;
	
	

	


}

function sendMessageLocal()
{

var_dump($_POST);


	
	$mapper = new Mapper();
$mapper->sendMessage($senderid, $receiverid, $_POST['message']);
	
}

function getUserByDeviceIdLocal()
{

var_dump($_REQUEST['deviceid']);
echo "JAJAJJAJA";
	
	$mapper = new Mapper();
$mapper->getUserByDeviceId($deviceid);
	
}


function getMatchLocal (){
echo "MAMMAA";
	
	$mapper = new Mapper();
$mapper->getMatch($senderid,$recieverid);
}

?>