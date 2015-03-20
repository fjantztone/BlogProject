<?php
require_once('includes/config.php');
require_once('includes/helper_func.php');

$aResponse = array('username' => true, 'email' => true, 'password' => null);
if(isAjax()){
	if(isset($_POST['username']) && !is_valid_username($_POST['username']))
		$aResponse['username'] = false;	
	
	if(isset($_POST['email']) && !is_valid_email($_POST['email']))
		$aResponse['email'] = false;	
	
	if(isset($_POST['password']))
		$aResponse['password'] = true;
	
	echo json_encode($aResponse);
} 
if(!empty($_POST) && isset($_POST['username'], $_POST['email'], $_POST['password']) && (extract($_POST) <= 4)){
	
	$error = array();
	if(!is_valid_username($_POST['username']))
		$error[0] = '<span id="helpBlock" class="help-block"><p class="text-danger">Username already in use.</p></span>';
	if(!is_valid_email($_POST['email']))
		$error[1] = '<span id="helpBlock" class="help-block"><p class="text-danger">Email already in use or wrong format type.</p></span>';
	if(empty($error)){
		$user = new User(null, $username, $email, $password);
		$auth = new Auth($db, $user);
		if($auth->sign_up() && $auth->login())
			header('location: controlpanel.php');

	}
}


	
?>