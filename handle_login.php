<?php
require_once('includes/helper_func.php');
require_once('includes/config.php');


if(!empty($_POST) && isset($_POST['username'], $_POST['password']) && (extract($_POST) <= 2)){
	$error = array();
	$user = new User(null, $_POST['username'], null, $_POST['password']);
	//$user = new User($db, $_POST['username'], null, $_POST['password']);
	$auth = new Auth($db, $user);
	if($auth->login())
		header('location: controlpanel.php');
	else
		$error[0] = '<span id="helpBlock" class="help-block"><p class="text-danger text-center">The log in credentials did not match.</p></span>';
}

	
?>