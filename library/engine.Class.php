<?php
class engineClass{
	public  $sql;
	public $session;
	public $phpmailer;
	function  __construct() {
		global $sql,$session,$phpmailer;
		$this->session= $session;
		$this->sql = $sql;
		$this->phpmailer = $phpmailer;
	}
	public function concatmoney($num){
		if($num>1000000000000) {
			return round(($num/1000000000000),1).' tri';
			}else if($num>1000000000){ return round(($num/1000000000),1).' bil';
			}else if($num>1000000) {return round(($num/1000000),1).' mil';
			}else if($num>1000){ return round(($num/1000),1).' k';
		}
		return number_format($num);
	}
	public function getActorDetails($tablename){
		$actor_id = $this->session->get("actorid");
		$stmt = $this->sql->Prepare("SELECT * FROM  ".$this->sql->Param('a')."  WHERE USR_ID = ".$this->sql->Param('b')." ");
		$stmt = $this->sql->Execute($stmt,array($tablename,$actor_id));
		if($stmt && ($stmt->RecordCount() > 0)){
		 	return $stmt->FetchNextObject();
		}else{
			return false;
		}
	}//end of getActorsDetails

	public function msgBox($msg,$status){
		if(!empty($status)){
			if($status == "success"){
				echo '<script>document.querySelector(swal("Saved", "'.$msg.'", "success"));</script>';
			}elseif($status == "info"){
				echo '<script>document.querySelector(swal("Info!", "'.$msg.'", "info"));</script>';
			}else{
				echo '<script>document.querySelector(swal("Ooops!", "'.$msg.'", "error"));</script>';
			}
		}
	}
	public function validatePostForm($microtime){
     	$postkey = $this->session->get('postkey');
     	if(empty($postkey)){
     		$postkey = 2;
     	}
     	if($postkey != $microtime){
     		if($postkey == 2){
     			$this->session->set('postkey',$microtime);
     		}else{
                 $this->session->del('postkey');
                 $this->session->set('postkey',$microtime);
             }
     		return true;
     	}else{
     		return false;
     	}
     }

	 public function readMore($string,$textcount){
		 $string = strip_tags($string);
		if (strlen($string) > $textcount) {
			// truncate string
			$stringCut = substr($string, 0, $textcount);

			// make sure it ends in a word so assassinate doesn't become ass...
			$string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
		}
		return $string;
	 }
}
