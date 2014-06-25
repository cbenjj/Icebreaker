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
        
        $match=$mapper->getMatch($sender, $receiver);
        $match->message=$_POST['message'];
        $mapper->updateMatch($match);
//         $mapper->createMatch($sender, $receiver, $_POST['message']);
        
        header('location:index.php');
        
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
// 	$mapper = new Mapper();
//     $mapper->getMatch($senderid,$recieverid);
}

function getCurrentStatusLocal (){
    
    $mapper = new Mapper();
    
    // get current user deviceid $_REQUEST['deviceid']
    $deviceid = $_GET['deviceid'];
    $user = $mapper->getUserByDeviceId($deviceid);
    
    if ($user->facebookid && !is_null($user->facebookid))
    {
    
        // get latitude and longitude
        $lat = floatval($_GET['lat']);
        $lng = floatval($_GET['lon']);
        
        // check for a message from another user
        $match = $mapper->hasUserMessageMatch($user);
        
        // if message exists display url for meet2.php
        if (!is_null($match) && !$match->complete)
        {
            echo ROOT."meet2.php?sender_facebookid=".$match->sender['facebookid']."&receiver_facebookid=".$match->receiver['facebookid'];
            exit;
        }
        
        // if there is no message check for users around the area
        // update current user location
        $user->location = array($lng, $lat);
        $mapper->updateUserLocation($user);
        
        if (!$mapper->hasPendingMatch($user))
        {
            $users = $mapper->getUsersByLocation($user, $lat, $lng);
            
            if (!empty($users))
            {
                // if there is a user in the area with same likes
                
                
                
                $mapper->createMatch($user, $users[0]);
            	// return url meet.php
                echo ROOT."meet.php?sender_facebookid=".$user->facebookid."&receiver_facebookid=".$users[0]->facebookid;
                exit;
            }
        }
    }
}
?>