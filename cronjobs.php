<?php
include_once 'autoload.php';

$userdata 		= $user->lostUpate();

$access_token 	= $userdata['access_token'];
$refresh_token 	= $userdata['refresh_token'];
$expires_in 	= $userdata['expires_in'];
$user_id 		= $userdata['id'];
$user_name 		= $userdata['name'];

if(empty($user_id)){
	echo 'All Accounts Updated. ('.time().')';
	exit();
}

// Already registed
if(!empty($user_id) && time() > $expires_in){

	// Re-Authorize Using the Refresh Token
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://wakatime.com/oauth/token");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,"client_id=".AppID."&client_secret=".AppSecret."&refresh_token=".$refresh_token."&grant_type=refresh_token&redirect_uri=".DOMAIN.'/cronjobs.php');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = json_decode(curl_exec($ch));
	curl_close ($ch);

	$access_token   = $response->access_token;
	$refresh_token  = $response->refresh_token;
	$expires_in     = $response->expires_in;

	// Update new access_token and Refresh_token
	if(!empty($refresh_token) && !empty($access_token)){
		$user->updateAccessToken($userdata['id'],$access_token,$refresh_token,$expires_in);
	}
}

// Update Checking Time.
$user->updateCheckingTime($user_id);

$WakaTime 		= new WakaTime();

$end			= date('Y-m-d',strtotime("-1 days"));
$start 			= date('Y-m-d',strtotime("-6 days"));
$summaries 		= $WakaTime->summaries($start,$end,$access_token);

$activity 		= new Activity();

foreach ($summaries->data as $data){
	$date = $data->range->date;

	// Languages activity
	foreach ($data->languages as $var){
		$language 		= $var->name;
		$total_seconds 	= $var->total_seconds;

		$activity->add($user_id,$language,$total_seconds,$date);
	}

	// Projects activity
	foreach ($data->projects as $var) {
		$name 			= $var->name;
		$total_seconds 	= $var->total_seconds;

		$activity->addProject($user_id,$name,$total_seconds,$date);
	}
}

$user->updateFlag($userdata['id']);
echo $user_name.' Summaries Updated ('.time().')';
?>