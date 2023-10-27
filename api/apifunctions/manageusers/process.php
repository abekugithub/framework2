<?php 
namespace manageusers;

class process extends \REST {
    function __construct(){
        parent::__construct();
        global $sql;
        $this->sql=$sql;

    }
    
    function Init(){
        $this->response('we are here',200);
    }
}


?>