<?php
class Notification{
	private $title;
	private $message;
	private $image_url;
	private $action;
	private $action_destination;
	private $data;
	
	function __construct(){
         
	}
 
	public function setTitle($title){
		$this->title = $title;
	}
 
	public function setMessage($message){
		$this->message = $message;
	}
 
	public function setImage($imageUrl){
		$this->image_url = $imageUrl;
	}
 
	public function setAction($action){
		$this->action = $action;
	}
 
	public function setActionDestination($actionDestination){
		$this->action_destination = $actionDestination;
	}
 
	public function setPayload($data){
		$this->data = $data;
	}
	
	public function getNotificatin(){
		$notification = array();
		$notification['title'] = $this->title;
		$notification['message'] = $this->message;
		$notification['image'] = $this->image_url;
		$notification['action'] = $this->action;
		$notification['action_destination'] = $this->action_destination;
		return $notification;
	}

	public function setNotification($titlex, $messagex){
		$notification = array();
		$notification['title'] = $titlex;
		$notification['message'] = $messagex;
		return $notification;
	}

	public function sendFCMSingle($send_to, $topic, $firebase_token, $requestData){
		$firebase_api = "AAAAnxJJibo:APA91bEA25Re7xSKWwq7mTE6CdofpDEbGbarGVTvU6IbcxoI-4LRqhWCfw2KrUN0Ia3W-ZBq6tP8U5_HeKdwCWlpH_k68Cz_HLrAL9kq0zCrFbNuck7Bm0ivWLFICpskeCiXUxkSSmQk";

		if($send_to=='topic'){
			$fields = array(
				'to' => '/topics/' . $topic,
				'data' => $requestData,
			);
			
		}else{
			
			$fields = array(
				'to' => $firebase_token,
				'data' => $requestData,
			);
		}


		// Set POST variables
		$url = 'https://fcm.googleapis.com/fcm/send';

		$headers = array(
			'Authorization: key=' . $firebase_api,
			'Content-Type: application/json'
		);
		
		// Open connection
		$ch = curl_init();

		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Disabling SSL Certificate support temporarily
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

		// Execute post
		$result = curl_exec($ch);
		if($result === FALSE){
			die('Curl failed: ' . curl_error($ch));
		}

		// Close connection
		curl_close($ch);

		return $result;

	}

	public function sendFCMMultiple($send_to, $topic, $firebase_token, $requestData){
		$firebase_api = "AAAAnxJJibo:APA91bEA25Re7xSKWwq7mTE6CdofpDEbGbarGVTvU6IbcxoI-4LRqhWCfw2KrUN0Ia3W-ZBq6tP8U5_HeKdwCWlpH_k68Cz_HLrAL9kq0zCrFbNuck7Bm0ivWLFICpskeCiXUxkSSmQk";

		if($send_to=='topic'){
			$fields = array(
				'to' => '/topics/' . $topic,
				'data' => $requestData,
			);
			
		}else{
			
			$fields = array(
				'registration_ids' => $firebase_token,
				'data' => $requestData,
			);
		}


		// Set POST variables
		$url = 'https://fcm.googleapis.com/fcm/send';

		$headers = array(
			'Authorization: key=' . $firebase_api,
			'Content-Type: application/json'
		);
		
		// Open connection
		$ch = curl_init();

		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Disabling SSL Certificate support temporarily
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

		// Execute post
		$result = curl_exec($ch);
		if($result === FALSE){
			die('Curl failed: ' . curl_error($ch));
		}

		curl_close($ch);
		
		return $result;

	}
}
?>
