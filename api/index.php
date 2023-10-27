<?php 
use Workerman\Worker;
use Workerman\WebServer;
use Workerman\Autoloader;
use PHPSocketIO\SocketIO;

define('GLOBAL_START', true);

//include 'api.php';
include 'socketapi.php';

Worker::runAll(); 
?>