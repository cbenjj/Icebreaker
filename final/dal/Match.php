<?php

class Match
{
    var $id;
    var $sender;
    var $receiver;
    var $location = array();
    var $timestamp;
//     var $likes;
    var $message;
//     var $color;
    var $complete;

    function __construct(array $match = NULL)
    {
        if (!is_null($match))
        {
            $this->id = $match['_id']->{'$id'};
            $this->sender = $match['sender'];
            $this->receiver = $match['receiver'];
            $this->location = $match['location'];
            $this->timestamp = $match['timestamp'];
            $this->message = $match['message'];
            $this->complete = $match['complete'];
            
        }
         
    }
}

?>