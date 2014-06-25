<?php
require_once 'config.php';

$mapper = new Mapper();

$facebook = new Facebook(array(
        'appId'  => FACEBOOK_APPID,
        'secret' => FACEBOOK_SECRET,
));

// Get User ID
$user = $facebook->getUser();

if ($user) {
    try {
        // Proceed knowing you have a logged in user who's authenticated.
        $user_profile = $facebook->api('/me');
        $user_likes = $facebook->api('/'.$user_profile['id'].'/likes/?limit=1000');

    } catch (FacebookApiException $e) {
        error_log($e);
        $user = null;
    }

//     $lng = floatval($_GET['lng']);
//     $lat = floatval($_GET['lat']);
    
    $user = new User();
    $user->firstname = $user_profile['first_name'];
    $user->lastname = $user_profile['last_name'];
    $user->email = isset($user_profile['email'])?$user_profile['email']:'';
    $user->facebookid = $user_profile['id'];
    $user->likes = array();
    foreach ($user_likes['data'] as $item)
    {
    	$like = new Like();
    	$like->category = $item['category'];
    	$like->name = $item['name'];
    	array_push($user->likes, $like);
    }
    $user->hometown = isset($user_profile['hometown'])?$user_profile['hometown']['name']:'';
    $user->currentcity = isset($user_profile['location'])?$user_profile['location']['name']:'';
    $user->birthday = isset($user_profile['birthday'])?$user_profile['birthday']:'';
    if (isset($user_profile['languages']))
    {
        foreach ($user_profile['languages'] as $item)
        {
            array_push($user->languages, $item['name']);
        }
    }
//     $user->lng = $lng;
//     $user->lat = $lat;
//     $user->location = array($lng, $lat);
    $user->deviceid = $_GET['deviceid'];
    
    $mapper->signup($user);
    
    header('location:index.php');
}
else
{
    $params = array('scope' => 'user_likes, email, languages, favorite_teams, education');
    
    $loginUrl = $facebook->getLoginUrl($params);

    header('location:'.$loginUrl);
}

?>