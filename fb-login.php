<?php

require_once 'facebook/facebook.php';
require_once 'dal/Mapper.php';

// $mapper = new Mapper();

// $user = new User();

// $mapper->signup($user);

$facebook = new Facebook(array(
        'appId'  => '242999689243129',
        'secret' => '8e22375f93cd5db3767016410a3fc193',
));

// Get User ID
$user = $facebook->getUser();

if ($user) {
    try {
        // Proceed knowing you have a logged in user who's authenticated.
        $user_profile = $facebook->api('/me');
    } catch (FacebookApiException $e) {
        error_log($e);
        $user = null;
    }
    
}
else
{
    
    $loginUrl = $facebook->getLoginUrl();

    header('location:'.$loginUrl);
}

print"<pre>";print_r($user_profile);print"</pre>";

?>