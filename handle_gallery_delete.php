<?php
include 'includes/config.php';
if(isset($_POST)){
	$response = array();
	if(file_exists($_POST['file']) && (strpos($_POST['file'], 'users/'.$_SESSION['user']->get_username().'/img/') === 0) && array_map('unlink', glob($_POST['file']))) //File exists will prevent the problem if you drag a text for example uploads/*, it wont empty the folder.
		$response['status'] = 'success';
	else 
		$response['status'] = 'error';

	echo json_encode($response);
} 
?>