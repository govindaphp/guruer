<?php 
namespace App\Libraries;
/* get the config values */
//include('JWT.php');
use Firebase\JWT\JWT;
use ReallySimpleJWT\Token;
require 'vendor/autoload.php';

class ZoomAPI{

	public function getToken(){
		$accountID = 'hGErVe7uR5-9_X4RVb1aLA';
		$clientId = 'mWHWupXVSRywccZpE47dbw';
		$clientSecret = 'ghCO381WHBdiilhtlfK1oxK8BhGri50C';

		$authHeader = base64_encode($clientId . ':' . $clientSecret);
		$url = 'https://zoom.us/oauth/token';

		$data = [
		'grant_type' => 'account_credentials',
		'account_id' => $accountID,
		];

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Host: zoom.us',
		'Authorization: Basic ' . $authHeader,
		]);
		$response = curl_exec($ch);
		$errorMessage = curl_error($ch);
		//echo $errorMessage;
		curl_close($ch);
		if(!$response){
			return false;
		}
		$responseData = json_decode($response, true);
		return $access_token = $responseData['access_token'];
	}
	
	function createUser($user){
		
		$access_token = $this->getToken();
		$body = array();
		
		$user_info = array();
		$body['action'] = 'create';
		$user_info['email'] = $user['email'];
		$user_info['type'] = 1;
		$user_info['first_name'] = $user['first_name'];
		$user_info['last_name'] = $user['last_name'];
		$body['user_info'] =  $user_info;
		$curl = curl_init();

		  curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.zoom.us/v2/users",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_SSL_VERIFYPEER => 0,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode($body),
		  CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $access_token,)));
		
		$response = curl_exec($curl);
		$arrdata=json_decode($response, true);
		
		//Check for any errors
		$errorMessage = curl_exec($curl);
		//echo $errorMessage;
		curl_close($curl);
		if(!$response){
			return false;
		}
		$arrdata= json_decode($response, true);
		return $arrdata;
	}
	
	function getUser($user){ 

		$access_token = $this->getToken();

		$apiCurl = curl_init("https://api.zoom.us/v2/users/".$user['email']);
		curl_setopt($apiCurl, CURLOPT_HTTPGET, true);
		curl_setopt($apiCurl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($apiCurl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token,));
		$response = curl_exec($apiCurl);
		$errorMessage = curl_error($apiCurl);
		echo $errorMessage; 

		curl_close($apiCurl);
		if(!$response){
			return false;
		}

		$arrdata = json_decode($response, true);
		return $arrdata; 
	}
	
	function createZoomMeeting($data){
		
		$token = $this->getToken();
		$body = array();
		$settings = array();

		$timestamp = strtotime($data['start_time']);
		$gmtDate =  gmdate("yyyy-MM-dd’T'HH:mm:ss'Z", $timestamp);
		
		$body['topic'] = $data['topic'];
		$body['type']  = 2;
		$body['start_time'] = $gmtDate;
		$body['duration']   = $data['duration'];
		$body['agenda']     = $data['agenda'];
		$body['timezone']   = '';
		$settings['host_video'] = false;
		$settings['participant_video'] = false;
		$settings['waiting_room'] = true;
		$body['settings'] =  $settings;
		$curl = curl_init();

		  curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.zoom.us/v2/users/".$data['zoom_user_id']."/meetings",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_SSL_VERIFYPEER => 0,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode($body),
		  CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token,'Content-Type: application/json',)
		));

		$response = curl_exec($curl);

		//Check for any errors
		$errorMessage = curl_error($curl);
		// $errorMessage;
		curl_close($curl);
		if(!$response){
			return false;
		}
		$arrdata= json_decode($response, true);
		return $arrdata;
	}
	

	/* function sendRequest_test($data){
			$token = $this->getToken();
			$body = array();
			$settings = array();

		    $timestamp = strtotime($data['start_time']);
		    $gmtDate =    gmdate("yyyy-MM-dd’T'HH:mm:ss'Z", $timestamp);
			
			$body['topic'] = $data['topic'];
			$body['type']  = 2;
			$body['start_time'] = $gmtDate;
			$body['duration']   = $data['duration'];
			$body['agenda']     = $data['agenda'];
			$body['timezone']   = '';
			$settings['host_video'] = false;
			$settings['participant_video'] = false;
			$settings['waiting_room'] = true;
			$body['settings'] =  $settings;
			$curl = curl_init();

			  curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.zoom.us/v2/users/".$data['zoom_user_id']."/meetings",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_SSL_VERIFYPEER => 0,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => json_encode($body),
			  CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token,),
			));

		$response = curl_exec($curl);
		$dd = json_decode($response, true);
		//Check for any errors
		$errorMessage = curl_exec($curl);
		//echo $errorMessage;
		curl_close($curl);
		if(!$response){
			return false;
		}
		$arrdata= json_decode($response, true);
		return $arrdata;
	}
	
	
	 */
	function getMeeting($meeting_id){
	
			$token = $this->getToken();
			$body = array();
			$curl = curl_init();

			  curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.zoom.us/v2/meetings/".$meeting_id,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_SSL_VERIFYPEER => 0,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_POSTFIELDS => json_encode($body),
			  CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token,),
			));

		$response = curl_exec($curl);
		//Check for any errors
		$errorMessage = curl_exec($curl);
		//echo $errorMessage;
		curl_close($curl);
		if(!$response){
			return false;
		}
		$arrdata= json_decode($response, true);
		return $arrdata;
	}
	
	function getMeetingRecording($meetingId){
		$request_url = $this->api_url."meetings/$meetingId/recordings";
	    return $this->sendRequestGET($request_url);	
	}
	
	function sendRequestGET($request_url){
		
		$token = $this->getToken();
		$body = array();
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		CURLOPT_URL =>$request_url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_POSTFIELDS => json_encode($body),
		CURLOPT_HTTPHEADER => array("authorization: Bearer ".$token),
		));

		$response = curl_exec($curl);
		//Check for any errors
		$errorMessage = curl_exec($curl);
		//echo $errorMessage;
		curl_close($curl);
		if(!$response){
			return false;
		}
		$arrdata = json_decode($response, true);
		return $arrdata;
    }
	
	
	function randomPassword($length) {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < $length; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

}
	



?>