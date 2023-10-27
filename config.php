<?php
/*
Orcons FrameWork 2 CURL Edition which is compactible with Orcons Class API.
Date Created: 13-12-2018.
Developed By:  Dev.Team @ Orcons Systems Limited.
*/

error_reporting(E_ALL ^ E_NOTICE);

//GLOBAL VARIABLES
global $sql,$session,$config,$pg,$option,$views,$viewpage,$msg,$currency;

define("SPATH_ROOT",dirname(__FILE__));
define("DS",DIRECTORY_SEPARATOR);
define( 'SPATH_LIBRARIES',	 	SPATH_ROOT.DS.'library' );
define( 'SPATH_PUBLIC'	   ,	SPATH_ROOT.DS.'public' );
define( 'SPATH_MEDIA'	   ,	SPATH_ROOT.DS.'media' );
define( 'SPATH_THEME'		,	SPATH_ROOT.DS.'theme' );
define( 'SPATH_COMPONENTS',	 	SPATH_ROOT.DS.'components' );
define( 'SPATH_CONFIGURATION' , SPATH_ROOT.DS.'configuration' );
define( 'SHOST_IMAGES'	   ,	SPATH_MEDIA.DS.'uploaded/' );
define( 'SPATH_PLUGINS'	   ,	SPATH_ROOT.DS.'plugins' );


//Post Keeper
if($_REQUEST){
	foreach($_REQUEST as $key => $value){
		$prohibited = array('<script>','</script>','<style>','</style>');
		$value = str_ireplace($prohibited,"",$value);
		$$key = @trim($value);
	}
}
if($_FILES){
	foreach($_FILES as $keyimg => $values){
		foreach($values as $key => $value){
			$$key = $value;
		}
	}

}
//SYSTEM TIMEZONE FORMAT
date_default_timezone_set('UTC');

class JConfig {

	public $secret='22AckerMyCh77';
	public $debug = false;
	public $autoRollback= true;
	public $ADODB_COUNTRECS = false;
	private static $_instance;
	public $smsusername ="";
	public $smspassword="";
	public $smsurl="";

	public function __construct(){
	}

	private function __clone(){}

	public static function getInstance(){
	if(!self::$_instance instanceof self){
	     self::$_instance = new self();
	 }
	    return self::$_instance;
	}

}

$config = JConfig::getInstance();

$app_name = "Framework II";
$favicon = "media/img/icons/favicon.png";

//included classes
include SPATH_LIBRARIES.DS."session.Class.php";
include SPATH_PLUGINS.DS."vendor".DS."autoload.php";
include SPATH_CONFIGURATION.DS."configuration.php";
include SPATH_LIBRARIES.DS."sql.php";
include SPATH_LIBRARIES.DS."cryptCls.php";
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."login.Class.php";
include SPATH_PLUGINS.DS."scssrouter".DS."generatelinks.php";
include SPATH_PLUGINS.DS."style.inc.php";
include SPATH_COMPONENTS.DS."components.init.php";
include  SPATH_PLUGINS.DS."socketclient".DS."emitter.php";
