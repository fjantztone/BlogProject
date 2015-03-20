<?php
include_once('includes/config.php'); 
$uploaded = array();
$uploaded['status'] = 'success';
if(!empty($_FILES['file']['name'][0])){
	$upload_folder = 'users/'.$_SESSION['user']->get_username().'/img/';	
	foreach($_FILES['file']['name'] as $position => $name){
		$mime_type = $_FILES['file']['type'][$position];
		$upload_path = $upload_folder . time() . '_' . basename($_FILES['file']['name'][$position]);	
		
		if(check_mime($mime_type) && move_uploaded_file($_FILES['file']['tmp_name'][$position], $upload_path)){
			$uploaded[] = array('name' => $upload_path, 'file' => $upload_path);
		}
		else $uploaded['status'] = 'error';


	}
	echo json_encode($uploaded);
}

function check_mime($mime) {
	switch($mime){
		case 'image/jpeg':
		case 'image/png':
		case 'image/gif':
		case 'image/jpg':
			return true;
		default:
			return false;
	}
}


?>