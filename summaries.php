<?php
include_once 'autoload.php';

$WakaTime = new WakaTime();

$today 	= date('Y-m-d',strtotime("-1 days"));
$sixday = date('Y-m-d',strtotime("-6 days"));

$summaries = $WakaTime->summaries($sixday,$today,$user->access_token);

$activity = new Activity();

foreach ($summaries->data as $data){
	$date = $data->range->date;

	foreach ($data->languages as $var){
		$language 		= $var->name;
		$total_seconds 	= $var->total_seconds;

		$activity->add($user->id,$language,$total_seconds,$date);
	}
}

header("Location: index.php");
die();
?>