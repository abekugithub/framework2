<?php
namespace login;
/**
 * setlog short summary.
 *
 * setlog description.
 *
 * @version 1.0
 * @author Solomon
 */
class setlog     extends \REST
{
    function __construct(){
        parent::__construct();
        global$sql;
        $this->sql=$sql;
    }

    function Init(){
        $sql=$this->sql;
        $query = "INSERT INTO framework_eventlog (EVL_EVTCODE,EVL_USERID,EVL_FULLNAME,EVL_ACTIVITIES,EVL_IP,EVL_SESSION_ID,EVL_BROWSER)
VALUES (".$sql ->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').
",".$sql->Param('f').",".$sql->Param('g').")";
		if($this->act == "1"){
            $type ='001';
            $activity = "From a REMOTE IP:".$this->remoteip." USERAGENT:".$this->useragent."  on SESSION ID:".$this->session;

        }else if($this->act == "0"){
            $userid = ($this->userid == "0")?"-1":$this->userid;
            $type ='002';
            $activity = "From a REMOTE IP:".$this->remoteip." USERAGENT:".$this->useragent."  on SESSION ID:".$this->session;
        }

        $stmt = $sql->Execute($query,array($type,$this->userid,$this->fullname,$activity,$this->remoteip,$this->session,$this->useragent));
                                                                              
        if($stmt){
            $this->response(array('status'=>true,'data'=>'Succesfully'),200);
        }   else{
            $this->response(array('status'=>false,'data'=>$sql->ErrorMsg()),200);
        }
    }
}