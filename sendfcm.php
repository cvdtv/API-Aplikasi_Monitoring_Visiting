<?php

	require_once "notification.php";
	require_once "koneksi.php";
	

	$notification = new Notification();

	$title = isset($_POST['title'])?$_POST['title']:'';
	$send_to = isset($_POST['send_to'])?$_POST['send_to']:'';
	$message = isset($_POST['message'])?$_POST['message']:'';
	$action = isset($_POST['action'])?$_POST['action']:'';

	$firebase_token = isset($_POST['firebase_token'])?$_POST['firebase_token']:'';
	$firebase_api = isset($_POST['firebase_api'])?$_POST['firebase_api']:'';
	$topic = isset($_POST['topic'])?$_POST['topic']:'';
	$actionDestination = isset($_POST['action_destination'])?$_POST['action_destination']:'';

	if($actionDestination ==''){
		$action = '';
	}

	$filter = "";
	$idsales = "";

	$token="";
	$sql = "select token from sales where token is not null";
	$r = mysqli_query($con, $sql);
	$result = array();
	
	$title = "GROUP_2";
	$message = "message 03 group 2";
	
	$i = 0;

	while($row = mysqli_fetch_array($r)){
		$result[$i++] = $row['token'];
	}

	$firebase_token = $result;
	$firebase_token = "ecs-yA7ox3U:APA91bFM0Rk6DIIclayGRcIdqjPmgePliSTRXQt-kcvQeERnNyO-Dd2bO-8fQVGSmju6vGZ78RQFkATJ5oRddkzrrqFTSq3jVOY0LwteItbXcGFcuRVKt_R9ru4XkXlpNKQ7-qo_5_Rp";

	$notification->setTitle($title);
	$notification->setMessage($message);
	$notification->setAction($action);
	$notification->setActionDestination($actionDestination);
	
	
	$requestData = $notification->getNotificatin();

	echo $notification->sendFCMSingle($send_to, $topic, $firebase_token, $notification->setNotification($title, $message));
?>
