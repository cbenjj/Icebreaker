<?php

class User
{
    var $firstname;
    var $lastname;
    var $email;
    var $facebookid;
    var $deviceid;
    var $lat;
    var $lng;
    var $likes = array();
    var $languages = array();
    var $hometown;
    var $currentcity;
    var $birthday;
    var $location = array();
    
    function __construct(array $user = NULL)
    {
        if (!is_null($user))
        {
        	$this->firstname = $user['firstname'];
        	$this->lastname = $user['lastname'];
        	$this->email = $user['email'];
        	$this->facebookid = $user['facebookid'];
        	$this->deviceid = $user['deviceid'];
        	$this->lat = $user['lat'];
        	$this->lng = $user['lng'];
        	$this->hometown = $user['hometown'];
        	$this->currentcity = $user['currentcity'];
        	$this->birthday = $user['birthday'];
//         	$this->location = array($user['lng'],$user['lat']);
        	$this->location = $user['location'];
        	
        	foreach ($user['likes'] as $item)
        	{
        	    $like = new Like();
        	    $like->category = $item['category'];
        	    $like->name = $item['name'];
                array_push($this->likes, $like);	
        	}
        	
        	foreach ($user['languages'] as $item)
        	{
        	    array_push($this->languages, $item);
        	}
        }
    	
    }
}

?>