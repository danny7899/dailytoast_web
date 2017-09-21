<?php
ob_start();
session_start();

//database credentials
define ("DB_HOST", "fdb7.awardspace.net"); // set database host
define ("DB_USER", "1874117_danny"); // set database user
define ("DB_PASS","Dan781999"); // set database password
define ("DB_NAME","1874117_danny"); // set database name

$db = new PDO('mysql:host=fdb7.awardspace.net;dbname=1874117_danny', DB_USER, DB_PASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//set timezone
date_default_timezone_set('Asia/Jakarta');

//load classes as needed
function __autoload($class) {
   
   $class = strtolower($class);

	//if call from within assets adjust the path
   $classpath = 'classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	} 	
	
	//if call from within admin adjust the path
   $classpath = '../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	}
	
	//if call from within admin adjust the path
   $classpath = '../../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	} 		
	 
}

$user = new User($db); 

include('functions.php');
?>