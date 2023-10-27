<?php
	require_once("Rest.inc.php");
    require_once("config.php"); 
	class API extends \REST {


         private $classvars = array();
		public function __construct(){
			parent::__construct();
           // global $_REQUEST;
           // var_dump($_REQUEST);
            // Init parent contructor
			//$this->dbConnect();					// Initiate Database connection
		}


        function rsa(){
      /*      if (!isset($_REQUEST['rsadata'])) {
    // For the simulation purposes, we will return the public key
    // anytime the client sends an empty request
    //$this->response(( $_REQUEST),200);
$rsa = new system\rsa();
$this->response(base64_encode( $rsa->getPublicRsaKey()),200);
} else {*/
    // decoding data1
    $rsa = new system\rsa();
    $string = ($_REQUEST);
//$this->response(( $_REQUEST['actions']),200);
// $jsonArray = $rsa->RSADecryption($string);
// $this->response(json_encode( $jsonArray),200);
  //  if(!$jsonArray){
    //    $this->response('Not Authenticated',200);
    //}
    parse_str((http_build_query($_REQUEST)), $output);
    $this->classvars=$output;
    $this->in($output);
  //  $this->response(( $this->classvars),200);
//}
}

		/*
		 * Public method for access api.
		 * This method dynmically call the method based on the query string
		 *
		 */
		public function processApi(){
                        if(!isset($this->actions)){
                            $this->response('Invalid request params',200);
                        }
            $func= $this->actions;
                 if(!class_exists($func,true)){
                     $this->response('Your Moda Says No Class',200);
                 }else{ 
                     $function=  new $func();
                     $this-> in($this->classvars,$function);
                     $function->Init();
                 }
		}
        public function in($data,$classname=null){
            foreach($data as $key => $value){
                $prohibited = array('<script>','</script>','<style>','</style>');
                $value = str_ireplace($prohibited,"",$value);
                ($classname) ? $classname ->$key = @trim($value) :    $this ->$key = @trim($value);
            }
		}
	}

	// Initiiate Library

	$api = new API; 
    $api->rsa();
	$api->processApi();
?>