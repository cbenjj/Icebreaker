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
                                                    '$maxDistance' => intval(200))),
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
            
//             $query = array( '$and' =>
//                         array(
//                         array( 'sender' =>
//                                 array( '$elemMatch' =>
//                                         array( 'facebookid' => $sender->facebookid )
//                                 )
//                         ),
//                         array( 'receiver' =>
//                                 array( '$elemMatch' =>
//                                         array( 'facebookid' => $receiver->facebookid )
//                                 )
//                         )
//                         )
//                         );
            
            
            $exists = $collection->count( $query );
            $exists = 0;
            
            if (!$exists)
            {
                // convert PHP object to associative array
                // mongo automatically converts objects to associative arrays
                //                 $user = (array) $user;
                $match = new Match();
                $match->sender = $sender;
                $match->receiver = $receiver;
                $match->message = $message;
                $match->timestamp = strtotime(date('YmdHis'));
                $match->complete = 0;
        
                $collection->insert( $match );
//                 $collection->ensureIndex(array('location' => '2dsphere'));
            }
        
        } catch (Exception $e) {
            
            error_log($e);
            throw $e;
        }
    }
    
    
    
    function getMatch(User $sender, User $receiver)
    {
        try {
        
            // select a collection:
            $collection = $this->db->match;
        
            // validate the user exists to avoid duplicate values
            // find by criteria
            $query = array( '$and' => array( array('sender.facebookid' => $sender->facebookid) , array('receiver.facebookid' => $receiver->facebookid) ) );
            $result = $collection->find( $query )->sort( array( 'timestamp' => -1 ) )->limit(1);
        
            if ($result->hasNext())
            {
                $match = new Match($result->getNext());
                return $match;
            }
        
            return null;
        
        } catch (Exception $e) {
            error_log($e);
            throw $e;
        }    	
    }
    
    function getMatchById($matchid)
    {
        try {
    
            // select a collection:
            $collection = $this->db->match;
    
            // validate the user exists to avoid duplicate values
            // find by criteria
            $query = array( '_id' => new MongoId($matchid) );
            $result = $collection->findOne( $query );
            
            $match = new Match($result);
    
            return $match;
    
        } catch (Exception $e) {
            error_log($e);
            throw $e;
        }
    }
    
    function hasUserMessageMatch(User $user)
    {
        try {
        
            // select a collection:
            $collection = $this->db->match;
        
            // validate the user exists to avoid duplicate values
            // find by criteria
            $query = array( 'receiver.facebookid' => $user->facebookid );
            $result = $collection->find( $query )->sort( array( 'timestamp' => -1 ) )->limit(1);
        
            if ($result->hasNext())
            {
                
                $match = new Match($result->getNext());
                return $match;
            }

            return null;
        
        } catch (Exception $e) {
            error_log($e);
            throw $e;
        }   	
    }

    // compare users common things and return the user with a higher score
    function getBestMatch(User $user, array $users)
    {
    	$maxscore = 0;
    	$maxuser = null;
    }
    
    function updateUserLocation(User $user)
    {
        try {
        
            // select a collection:
            $collection = $this->db->user;
            $collection->update( array('facebookid' => $user->facebookid) , $user);
        
        } catch (Exception $e) {
            error_log($e);
            throw $e;
        } 
    }
    
    function completeMatch(Match $match)
    {
        try {
        
            // select a collection:
            $collection = $this->db->match;
            $match->complete = 1;
            $collection->update( array('_id' => new MongoId($match->id)) , $match);
        
        
        } catch (Exception $e) {
            error_log($e);
            throw $e;
        }  
    }
    
//     function removeCollection()
//     {
//         $collection = $this->db->user;
//         $collection->remove();
//     }
}