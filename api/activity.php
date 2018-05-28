<?php
require_once '../autoload.php';
header("Content-type: application/json");
// header('Access-Control-Allow-Origin: *');

$returnObject = array(
	"apiVersion"  	=> 1.0,
	"execute"     	=> floatval(round(microtime(true)-StTime,4)),
);

$activity = new Activity();

switch ($_SERVER['REQUEST_METHOD']){
	case 'GET':
		switch ($_GET['request']){
			case 'activities':
				$profile_id = $_GET['profile_id'];
				$activities = $activity->listActivity($profile_id);
				$returnObject['activities'] = $activities;
				break;
			case 'leaderboards':
				$leaderboards = $activity->leaderboards();
				$returnObject['leaderboards'] = $leaderboards;
				break;
			default:
				$returnObject['message'] = 'GET API Not found!';
			break;
		}
    	break;
    case 'POST':
    	switch ($_POST['request']){
    		case 'edit_title':
    			break;
			default:
				$returnObject['message'] = 'POST API Not found!';
			break;
		}
    	break;
    default:
    	$returnObject['message'] = 'METHOD API Not found!';
    	break;
}

echo json_encode($returnObject);
exit();
?>