<?php
include_once 'autoload.php';

$code = $_GET['code'];

// Authentication
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://wakatime.com/oauth/token");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,"client_id=".AppID."&client_secret=".AppSecret."&code=".$code."&grant_type=authorization_code&redirect_uri=".DOMAIN.'/callback.php');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = json_decode(curl_exec ($ch));
curl_close ($ch);

$access_token 	= $response->access_token;
$refresh_token 	= $response->refresh_token;
$waka_id 		= $response->uid;

// Get Userdata from Wakatime API.
$curl = curl_init();
curl_setopt_array($curl, array(
	CURLOPT_URL => "https://wakatime.com/api/v1/users/current",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "UTF-8",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
		"authorization: Bearer ".$access_token
	),
));

$userprofile = json_decode(curl_exec($curl));
curl_close($curl);

$waka_id 	= $userprofile->data->id;
$name 		= $userprofile->data->full_name;
$email 		= $userprofile->data->email;
$website 	= $userprofile->data->website;
$photo 		= $userprofile->data->photo;

if(empty($waka_id)){
	header("Location: index.php");
	die();
}

// Get user data with UID (waka_id)
$userdata 		= $user->getFormWakaID($waka_id);
$user_id 		= $userdata['id'];

// Already registed
if(!empty($user_id)){
	// Already Registed and Update New Access_token and Refresh_token.
	echo '<p>Already Registed and Update New Access_token and Refresh_token</p>';
	$user->updateAccessToken($user_id,$access_token,$refresh_token,$expires_in);
	$user->edit($user_id,$name,$email,$website,$photo);
}else{
	// Register New Account.
	echo 'Register New Account';
	$user_id = $user->register($waka_id,$name,$email,$website,$access_token,$refresh_token,$photo);
}

// Declare session and cookie
if(!empty($user_id) && isset($user_id)){
	$cookie_time = time() + 3600 * 24 * 60; // Cookie Time (2 Months)
	$_SESSION['login_string'] = $user->Encrypt($user_id);
	setcookie('login_string',$user->Encrypt($user_id),$cookie_time);
}

// Get first summaries
header("Location: summaries.php");
die();
?>