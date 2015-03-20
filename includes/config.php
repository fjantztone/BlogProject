<?php
ob_start();
session_start();

define('DSN', 'mysql:dbname=db_blog;host=localhost'); //Data source
define('DBUSER', 'root'); //User
define('DBPASS', ''); //Pw
define('ROOTPATH', realpath(dirname(dirname(__FILE__))));
define('ROOTFOLDER', basename(dirname((dirname(__FILE__)))));
define('LINK', '//'.$_SERVER['HTTP_HOST'].'/'.ROOTFOLDER.'/');
define('USERLINK', '//'.$_SERVER['HTTP_HOST'].'/'.ROOTFOLDER.'/users/');

//Turn exceptions on. Turn off prepare emulation, not necessary for new MySQL.
try {
	$db = new PDO(DSN, DBUSER, DBPASS, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));	
} catch (PDOException $e){
	echo 'Connection error: ' .$e->getMessage();
}
date_default_timezone_set('Europe/Stockholm');

function __autoload($class_name){ //$classname will refer to the instanciated classes below.
	
	$filepath_root = 'class/class.'.strtolower($class_name).'.php';

	if(file_exists($filepath_root)){
		require_once($filepath_root); //include seem to screw things up..	
	}

	$filepath_folder = '../class/class.'.strtolower($class_name).'.php';

	if(file_exists($filepath_folder)){
		require_once($filepath_folder);
	}
	$filepath_folder_folder = '../../class/class.'.strtolower($class_name).'.php';
	
	if(file_exists($filepath_folder_folder)){
		require_once($filepath_folder_folder);
	}	
}

?>