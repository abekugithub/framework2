<?php
namespace manageusers;
/**
 * list short summary.
 *
 * list description.
 *
 * @version 1.0
 * @author Solomon
 */
class home extends \REST{
         function __construct(){
             parent::__construct();
             global $sql;
             $this->sql=$sql;
         }

    function Init(){
        $sql = $this->sql;
        $stmt = $sql->Execute(  $sql->Prepare( "SELECT USR_USERCODE,USR_USERNAME,USR_SURNAME,USR_OTHERNAME,USR_STATUS,USR_COMP_CODE FROM framework_users WHERE USR_STATUS='1'"),array());   
        if($stmt){
           $this->response(  array('status'=>true,'data'=>$stmt->GetAll()),200);
        }else{
            $this->response(array('status'=>false,'data'=>$sql->ErrorMsg()),200);
        }
    }

}