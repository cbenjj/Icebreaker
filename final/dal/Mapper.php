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
    	$this->db = $this->connection->icebreaker;
    }
    
    function signup(User $user)
    {
        try {
            
            // select a collection:
            $collection = $this->db->user;
            
            // validate the user exists to avoid duplicate values
            // find by criteria
            $query = array( 'facebookid' => $user->facebookid );
            $exists = $collection->count( $query );
            
//             $user = (array) $user;
            if (!$exists)
            {
                // convert PHP object to associative array
                // mongo automatically converts objects to associative arrays
//                 $user = (array) $user;

                $collection->insert( $user );
                
                $collection->ensureIndex(array('location' => '2dsphere'));
            }
            
        } catch (Exception $e) {
            error_log($e);
            throw $e;
        }
    } 
    
    function getUserByFacebookId($facebookid)
    {
        try {
        
            // select a collection:
            $collection = $this->db->user;
        
            // validate the user exists to avoid duplicate values
            // find by criteria
            $query = array( 'facebookid' => $facebookid );
            $result = $collection->findOne( $query );
            
            $user = new User($result);
        
            return $user;
        
        } catch (Exception $e) {
            error_log($e);
            throw $e;
        }
    }

    function getUsersByLocation(User $user,$lat,$lng)
    {
        try {
        
            // select a collection:
            $collection = $this->db->user;
            
            // validate the user exists to avoid duplicate values
            // find by criteria
            $query = array('location' => 
                                array('$near' => 
                                            array('$geometry' => 
                                                        array( 'type' => 'Point', 
                                                               'coordinates' => array($lng,$lat)), 
                                                    '$maxDistance' => intval(3000))),
                            'facebookid' => array('$ne' => $user->facebookid));
            
            $cursor = $collection->find($query);
        
            $users = array();
            
            foreach ( $cursor as $id => $value )
            {
                $user = new User($value);
                array_push($users, $user);
            }
            
            return $users;
        
        } catch (Exception $e) {
            error_log($e);
            throw $e;
        }
    }
    
    function getUserByDeviceId($deviceid)
    {
        try {
        
            // select a collection:
            $collection = $this->db->user;
        
            // validate the user exists to avoid duplicate values
            // find by criteria
            $query = array( 'deviceid' => $deviceid );
            $result = $collection->findOne( $query );
        
            $user = new User($result);
        
            return $user;
        
        } catch (Exception $e) {
            error_log($e);
            throw $e;
        }   
    }
    
    function createMatch(User $sender, User $receiver, $message)
    {
        try {
            
            // select a collection:
            $collection = $this->db->match;
        
            // validate the user exists to avoid duplicate values
            // find by criteria
            
            $query = array( '$and' =>
                        array(
                        array( 'sender' =>
                                array( '$elemMatch' =>
                                        array( 'facebookid' => $sender->facebookid )
                                )
                        ),
                        array( 'receiver' =>
                                array( '$elemMatch' =>
                                        array( 'facebookid' => $receiver->facebookid )
                                )
                        )
                        )
                        );

            $exists = $collection->count( $query );
            
            print"<pre>";print_r($exists);print"</pre>";
        
            if (!$exists)
            {
                // convert PHP object to associative array
                // mongo automatically converts objects to associative arrays
                //                 $user = (array) $user;
                $match = new Match();
                $match->sender = $sender;
                $match->receiver = $receiver;
                $match->message = $message;
        
                $collection->insert( $match );
//                 $collection->ensureIndex(array('location' => '2dsphere'));
            }
        
        } catch (Exception $e) {
            
            error_log($e);
            print"<pre>";print_r($e);print"</pre>";
            throw $e;
        }
    }
    
    function updateUserLocation(User $user)
    {
    	
    }
    
    function getMatch(User $u1, User $u2)
    {
    	
    }

    // compare users common things and return the user with a higher score
    function getBestMatch(User $user, array $users)
    {
    	$maxscore = 0;
    	$maxuser = null;
    	
    	
    }
    
//     function removeCollection()
//     {
//         $collection = $this->db->user;
//         $collection->remove();
//     }
}