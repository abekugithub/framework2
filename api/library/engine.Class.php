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
		public function getActorDetails(){
				$actor_id = $this->session->get("actorid");
				$stmt = $this->sql->Prepare("SELECT * FROM church_users WHERE USR_ID = ".$this->sql->Param('a'));
				$stmt = $this->sql->Execute($stmt,array($actor_id));
				if($stmt && ($stmt->RecordCount() > 0)){
		 return $stmt->FetchNextObject();
		 }else{
				// print $this->sql->ErrorMsg();
				 return false;
		 }
		}//end of getActorsDetails

	public function msgBox($msg,$status){
		if(!empty($status)){
			if($status == "success"){
				echo '<div class="alert alert-success"> '.$msg.'</div>';
				}else{
				 echo '<div class="alert alert-danger"> '.$msg.'</div>';
			}
		}
	   }
}
