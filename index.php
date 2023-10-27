<?php

/*
Orcons FrameWork 2 CURL Edition which is compactible with Orcons Class API.
Date Created: 13-12-2018.
Developed By:  Dev.Team @ Orcons Systems Limited.
*/

include "config.php";

if(isset($action) && strtolower($action) == 'login'){
include('public/login/login.view.php');
	die();
}
$log = new Login();

if(isset($action) && strtolower($action) == 'logout'){
$log->logout();
}
if(isset($doLogin) && $doLogin == 'systemPingPass'){
	header('Location: index.php?action=index&pg=dashboard');
	die('Please wait...redirecting page');
}

//INSIDE THE SYSTEMS NOW
$engine = new engineClass();
$config = new JConfig();




//ini_set('display_errors', 1);

include("public/root.platform.php");

?>
