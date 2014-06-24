<?php 

require_once 'config.php';


$action=$_REQUEST['action'];

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
	case 'getcurrentstatus':
	   getCurrentStatusLocal();
	   break;
}

function sendMessageLocal()
{
    try {
        
        $senderid=$_POST['senderid'];
        $receiverid=$_POST['receiverid'];
        
        $mapper = new Mapper();
        
        $sender = $mapper->getUserByFacebookId($senderid);
        $receiver = $mapper->getUserByFacebookId($receiverid);
        
        $mapper->createMatch($sender, $receiver, $_POST['message']);
        
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
    
}

function getUserByDeviceIdLocal()
{
    $deviceid=$_REQUEST['deviceid'];
	$mapper = new Mapper();
    $user = $mapper->getUserByDeviceId($deviceid);
}


function getMatchLocal (){
	$mapper = new Mapper();
    $mapper->getMatch($senderid,$recieverid);
}

function getCurrentStatusLocal (){
	//$mapper = new Mapper();
    //$mapper->getMatch($senderid,$recieverid);
    
    // sample url for matching page
    echo ROOT."meet.php?sender_facebookid=500383379&receiver_facebookid=1173581624";
}
?>