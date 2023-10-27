<?php
namespace login;

/**
 * login short summary.
 *
 * login description.
 *
 * @version 1.0
 * @author Solomon
 */
class login extends \REST
{
    function __construct(){
        parent::__construct();
        global$sql;
        $this->sql=$sql;
    }

    function Init(){
        $sql=$this->sql;
        $query = "SELECT USR_USERCODE,USR_USERNAME,USR_SURNAME,USR_OTHERNAME,USR_COMP_CODE,USR_BRAN_CODE,USR_STATUS FROM framework_users WHERE USR_STATUS='1' AND USR_USERNAME=".$sql->Param('a')." AND USR_PASSWORD=".$sql->Param('b')."";
        $stmt = $sql->Prepare($query);
        $stmt = $sql->Execute($stmt,array($this->username,$this->password));
        if($stmt){
            $this->response(array('status'=>true,'data'=>$stmt->FetchNextObject()),200);
        }   else{
            $this->response(array('status'=>false,'data'=>$sql->ErrorMsg()),200);
        }
    }
}