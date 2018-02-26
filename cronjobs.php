<?php
include_once 'autoload.php';

$user = new User();
$userdata = $user->lostUpate();

$access_token = $userdata['access_token'];
$user_id = $userdata['id'];
$user_name = $userdata['name'];

if(empty($user_id) || empty($access_token)){
	echo 'Access token is empty!';
	exit(0);
}

$WakaTime = new WakaTime();

$end	= date('Y-m-d',strtotime("-1 days"));
$start 	= date('Y-m-d',strtotime("-3 days"));

$summaries = $WakaTime->summaries($start,$end,$access_token);

$activity = new Activity();

foreach ($summaries->data as $data){
	$date = $data->range->date;

	foreach ($data->languages as $var){
		$language 		= $var->name;
		$total_seconds 	= $var->total_seconds;

		$activity->add($user_id,$language,$total_seconds,$date);
	}
}

$user->updated($userdata['id']);
echo $user_name.' summaries updated.';
?>