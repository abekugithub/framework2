<?php 
include "users.controller.php";
switch ($views) {
    
    default:
        include "users.view.php";
    break;
}
?>