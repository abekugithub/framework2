<?php
namespace members;
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
        $sql=$this->sql;
        $paging= new \system\pagination();
        if(!empty($this->fsearch)){
            $query = "SELECT * FROM framework_clients WHERE CLNT_CODE LIKE ".$sql->Param('a')." OR CLNT_NAME LIKE ".$sql->Param('b');
            $paging->OS_Pagination($sql,$query,$this->limit,null,$this->page,'',[$this->fsearch.'%',$this->fsearch.'%']);
            $result=$paging->paginate();
            if($result){
                $this->response( ['status'=>true,'data'=>['tdata'=>$result->GetAll(),'page'=>$paging->renderNavNum()]],200);
            }  else{
                $this->response( ['status'=>true,'data'=>['tdata'=>$sql->ErrorMsg(),'page'=>$this->page]],200);
            }

        }else{
            $query = 'SELECT * FROM framework_clients';
            $paging->OS_Pagination($sql,$query,$this->limit,null,$this->page,'',[]);
            $result=$paging->paginate();
            if($result){
                $this->response( ['status'=>true,'data'=>['tdata'=>$result->GetAll(),'page'=>$paging->renderNavNum()]],200);
            }  else{
                $this->response( ['status'=>true,'data'=>['tdata'=>$sql->ErrorMsg(),'page'=>$this->page]],200);
            }
        }
    }


}