<?php
/**
############################################################
### This file contains api server connection informations ##
############################################################
**/
             
//$engine	  = "mysqli";
$categoryapi= $_SESSION['compcat']? $_SESSION['compcat'] :"api";
$serverURL   = "http://localhost:8000/framework2/".$categoryapi."/api.php";  
//$engine	  = "mysqli";
 


?>
