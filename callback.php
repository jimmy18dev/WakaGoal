<?php
include_once 'autoload.php';

$code = $_GET['code'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://wakatime.com/oauth/token");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,"client_id=".AppID."&client_secret=".AppSecret."&code=".$code."&grant_type=authorization_code&redirect_uri=".RedirectURI);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$err = curl_error($curl);
$response = json_decode(curl_exec ($ch));
curl_close ($ch);

$access_token 	= $response->access_token;
$refresh_token 	= $response->refresh_token;

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
$err = curl_error($curl);

curl_close($curl);

$waka_id 	= $userprofile->data->id;
$name 		= $userprofile->data->full_name;
$email 		= $userprofile->data->email;
$website 	= $userprofile->data->website;
$photo 		= $userprofile->data->photo;

if(!empty($waka_id)){
	$user = new User();
	$user_id = $user->register($waka_id,$name,$email,$website,$access_token,$refresh_token,$photo);

	$cookie_time = time() + 3600 * 24 * 2; // Cookie Time (2 Months)
	$_SESSION['login_string'] = $user->Encrypt($user_id);
	setcookie('login_string',$user->Encrypt($user_id),$cookie_time);
}

header("Location: api.php");
die();
?>