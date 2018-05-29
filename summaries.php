<?php
include_once 'autoload.php';

$WakaTime = new WakaTime();
$activity = new Activity();

$today 	= date('Y-m-d',strtotime("-1 days"));
$sixday = date('Y-m-d',strtotime("-7 days"));

$summaries = $WakaTime->summaries($sixday,$today,$user->access_token);

if(count($summaries) > 0){
	foreach ($summaries->data as $data){

		$date = $data->range->date;

		// Languages activity
		foreach ($data->languages as $var){
			$language 		= $var->name;
			$total_seconds 	= $var->total_seconds;

			$activity->add($user->id,$language,$total_seconds,$date);
		}

		// Projects activity
		foreach ($data->projects as $var) {
			$name 			= $var->name;
			$total_seconds 	= $var->total_seconds;

			$activity->addProject($user->id,$name,$total_seconds,$date);
		}
	}
}

header("Location: index.php");
die();
?>