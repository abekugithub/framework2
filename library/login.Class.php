<?php
    /**
     *@desc this class handles all the client end log in details and methods
     *@desc this depands on the connect.php and Session.class.php
     */
	@define('USER_LOGIN_VAR',$uname);
	@define('USER_PASSW_VAR',$pwd);
	/* @define('USER_CAPTCHA_VAR',$captcha); */
	@define('USER_CAPTCHA_TXT',$txtcaptha);

	class Login{
		private $session;
		private $redirect;
		private $hashkey;
		private $md5 = false;
		private $sha2 = false;
		private $remoteip;
		private $useragent;
		private $sessionid;
		private $result;
		private $connect;
		private $crypt;
    	private $jconfig;




		public function __construct(){
			global $sql,$session;
			$this->redirect ="index.php?action=login";
			$this->hashkey	=$_SERVER['HTTP_HOST'];
			$this->sha2=true;
			$this->remoteip = $_SERVER['REMOTE_ADDR'];
			$this->useragent = $_SERVER['HTTP_USER_AGENT'];
			$this->session	=$session;
			$this->connect = $sql;
			$this->crypt = new cryptCls();
     		$this->sessionid = $this->session->getSessionID();
			$this->signin();
		}

		private function signin(){

			if($this->session->get('hash_key')){
				$this->confirmAuth();
				return;
			}
			if(!isset($_POST['doLogin'])){
				$this->logout();
			}
			if(USER_LOGIN_VAR=="" || USER_PASSW_VAR == ""){
				$this->logout("empty");
			}
			// if(USER_CAPTCHA_TXT =="" ||($this->session->get('code') != USER_CAPTCHA_TXT)){
			//   $this->direct("captchax");
			// }
			if($this->md5){
			}else if($this->sha2){
			   $passwrd = $this->crypt->loginPassword(USER_LOGIN_VAR,USER_PASSW_VAR);
			}else{
				$passwrd = USER_PASSW_VAR;
			}
     		//die($passwrd);
			$stmt = Execute(array('actions'=>'login\login','username'=>USER_LOGIN_VAR,'password'=>$passwrd));
          //  var_dump($stmt) ;die;
            if($stmt->status){
				if( $stmt->data ){

				$arr = $stmt->data;

				$userid = $arr->USR_CODE;
				$username = $arr->USR_USERNAME;
				$accstatus = $arr->USR_STATUS;
				$fullname = $arr->USR_OTHERNAME.''.$arr->USR_SURNAME;
                $institutionid = $arr->USR_FACICODE;
$institutioncategory=$arr->USR_COMPCAT;
				if($accstatus =='2'){
					$this->logout("locked");
				}

				$this->storeAuth($userid, $username,$institutionid,$fullname,$institutioncategory);
				$this->setLog("1");
				header('Location: ' . $this->redirect);
					//actions

				}else{
                    //$activity = "From a REMOTE IP:".$this->remoteip." USERAGENT:".$this->useragent."  with USERNAME:".USER_LOGIN_VAR." and PASSWORD:".USER_PASSW_VAR;
                    //$fullname ='';
                    //$type ='003';
                    //$query = "INSERT INTO template_eventlog (EVL_EVTCODE,EVL_USERID,EVL_FULLNAME,EVL_ACTIVITIES,EVL_IP,EVL_SESSION_ID,EVL_BROWSER) VALUES (".$this->connect->Param('a').",".$this->connect->Param('b').",".$this->connect->Param('c').",".$this->connect->Param('d').",".$this->connect->Param('e').",".$this->connect->Param('f').",".$this->connect->Param('g').")";
                    //$stmt = $this->connect->Execute($query,array($type,'0',$fullname,$activity,$this->remoteip,$toinsetsession,$this->useragent));

                    //print $this->connect->ErrorMsg();
					$this->logout("wrong");
					//$this->direct("wrong");
				}


			}else{ 
				$this->logout("wrong");
			}

		}//end

		public function direct($direction=''){
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Cache-Control: no-store, no-cache, must-validate');
			header('Cache-Control: post-check=0, pre-check=0',FALSE);
			header('Pragma: no-cache');

			if($direction == 'empty'){
			header('Location: ' . $this->redirect.'&attempt_in=0');
			}else if($direction == 'wrong'){
			header('Location: ' .$this->redirect.'&attempt_in=1');
			}else if($direction == 'subspen'){
			header('Location: ' .$this->redirect.'&attempt_in=120');
			}else if($direction=="out"){
			header('Location: ' .$this->redirect);
			}else if ( $direction =='captchax'){
			header('Location: ' .$this->redirect.'&attempt_in=11');
			}else{
			header('Location: ' .$this->redirect);
			}
			exit;

		}

		public function storeAuth($userid,$login,$institutionid,$fullname,$institutioncategory)
	{
		$this->session->set('actorid',$userid);
		$this->session->set('actor',$login);
		$this->session->set('h1',$login);
		$this->session->set('actorfulname',$fullname);
$this->session->set('compcat',$institutioncategory);
		$this->session->set('random_seed',md5(uniqid(microtime())));

		$hashkey = md5($this->hashkey . $login .$this->remoteip.$this->sessionid.$this->useragent);
		$this->session->set('hash_key',$hashkey);
		$this->session->set("LAST_REQUEST_TIME",time());

	}//end

		public function logout($msg="out")
	{

		if($msg =="out"){

		}
		$this->session->del('actor');
		$this->session->del('actorid');
		$this->session->del('actorfulname');
		$this->session->del('h1');
		$this->session->del('random_seed');
		$this->session->del('hash_key');
		$this->session->del('compcat');
		$this->direct($msg);
	}//end

	public function confirmAuth(){

		$login = $this->session->get("h1");
		$hashkey = $this->session->get('hash_key');

		if(md5($this->hashkey . $login .$this->remoteip.$this->sessionid.$this->useragent) != $hashkey)
		{
			$this->logout();
		}else{
			//UPDATE SESSION
			$userid=$this->session->get("actorid");
		}

	}//end

	private function setLog($act){
		$userid=$this->session->get("actorid");
		$fullname = $this->session->get('loginuserfulname');
		$toinsetsession = $this->session->getSessionID();
        Execute(array('actions'=>'login\setlog', 'act'=>$act ,'userid'=>$userid,'fullname'=>$fullname,'remoteip'=>$this->remoteip,'session'=>$toinsetsession,'useragent'=>$this->useragent));
       }

	}
?>
