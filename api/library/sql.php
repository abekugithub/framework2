<?php
	//$config = new JConfig();
    $sql = ADONewConnection($engine);
    $sql->debug = $config->debug;
	$sql->autoRollback = $config->autoRollback;
    $db = $sql->Connect($server, $username, $password, $database);
    $session = new Session();
	if(!$db){
		exit('Connection Down');	
	}


