<?php

require_once 'dal/Like.php';
require_once 'dal/User.php';
require_once 'dal/Match.php';

Class Mapper
{
	var $connection;
	var $db;
    
    function __construct()
    {
    	$this->connection = new MongoClient();
    	$this->db = $connection->icebreaker;
    }
    
    function signup(User $user)
    {

    } 
    
    function getUserByFacebookId($facebookid)
    {
    	
    } 
    
    function getUserByDeviceId($deviceid)
    {
        
    }
    
    function sendMessage(User $sender, User $receiver, $message)
    {
    	
    }
    
    function getInterests(User $user)
    {
    	
    }
    
    function getUsersByLocation($lat,$lng)
    {
    	
    }
    
    function createMatch(User $u1, User $u2)
    {
    	
    }
    
    function completeMatch(User $u1, User $u2)
    {
    	
    }
    
    function updateUserLocation(User $user)
    {
    	
    }
    
    function getMatch(User $u1, User $u2)
    {
    	
    }
}