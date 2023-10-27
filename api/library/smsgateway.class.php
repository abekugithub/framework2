<?php
//include(JPATH_PLUGINS."/smsgh/Api.php");

class smsgetway{
	private $config;
	private $url;
	private $apiHost;
	private $apiMessage;
	
	function __construct(){
		global $config;
		$this->config=$config;
			
		/*$this->apiHost = new SmsghApi();
		$this->apiHost->setClientId($this->config->smsusername);
		$this->apiHost->setClientSecret($this->config->smspassword);
		$this->apiHost->setContextPath("v3");
		$this->apiHost->setHttps(true);
		$this->apiHost->setHostname($this->config->smsurl);
		$this->apiMessage = new ApiMessage();
		$this->apiMessage->setFrom('CAGD');*/
	}
	
	/**
	 * 
	 * @param string $phone
	 * @param string $msg
	 
	public function sendSms($phone,$msg){
		$result = false;
		try {
			$this->apiMessage->setTo($phone);
			$this->apiMessage->setContent($msg);
			$this->apiMessage->setRegisteredDelivery(true);
			$response = $this->apiHost->getMessages()->send($this->apiMessage);
		
			$result = $response->getResponseStatus();
			
		
		} catch (Smsgh_ApiException $ex) {
			//echo 'ERROR: ', $ex->message(), "\n";
		}
	return $result;
	}*/
	
	/**
	 * 
	 * @param string $phone
	 * @param string $msg
	 */
	public function sendSms($phone,$msg){
		$url = 'http://txtconnect.co/api/send/';
		$result = false;
		$fields = array(
'token' => urlencode('d365dd3e5f898e8b6366f022bd1dcb0bb1ef4092'),
'msg' => urlencode($msg),
'from' => urlencode("CAGD"),
'to' => urlencode($phone),
);
$fields_string = "";
foreach ($fields as $key => $value) {
$fields_string .= $key . '=' . $value . '&';
}
rtrim($fields_string, '&');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$result = curl_exec($ch);
curl_close($ch);
$data = json_decode($result);
//print_r($data);
if($data->error == "0"){
$result = "200";
}else{
$result = $data->error;
}
		
		
	return $result;
	}
	
	/**
	 * sends same message in bulk
	 * @param array $arrayphone
	 * @param string $msg
	 */
	public function sendBulkSms($arrayphone,$msg){
		$returns =array();
		if(is_array($arrayphone)){
			foreach ($arrayphone as $phone){
				$returns[] =$this->sendSms($phone, $msg);
			}
		}else{
			$returns[] =$this->sendSms($phone, $msg);	
		}
		
		return $returns;
		
	}//end
	
	
		/*
			This function will validate the cellphone number
		*/
		function validateNumber($number, $forced_prefix = NULL, $number_length = '0'){
			
			if (!$forced_prefix){
				$forced_prefix = "+233";
			}
			
			// Remove any non-numeric characters in the number
			$number = preg_replace('/[^\+0-9]/s','',$number);
			
			// If a prefix is allready added then return the number "as is"
			if ( substr($number, 0, 1) == "+" || substr($number, 0, 2) === "00" ){
				return $number;
			}

			if (substr($number, 0, 1)=='0' && substr($number,0,2)!='00'){
				// single 0 at the beginning of number, we're supposed to remove that
				$number = substr($number,1);
			}
			
			// Add a prefix if the number doesn't have one yet
			if (isset($forced_prefix) && strlen($forced_prefix) > 0){
				if (substr($number, 0, strlen($forced_prefix)) != $forced_prefix){
					// The beginning of the number does not match the forced prefix
				}else{
					$number = substr($number, strlen($forced_prefix));
				}
			}
			
			// Check if the number is still not numeric, if so we return 0/false
			if (!is_numeric($number)){
				return 0;
			}
			
			// Check if the number has the correct length. 
			// Setting $number_length to 0 or false will skip this test
			if ($number_length && strlen($number) != $number_length){
				return 0;
			}
			
			// Add the forced prefix
			$number = $forced_prefix . $number;
			
			return $number;
		}
}
?>