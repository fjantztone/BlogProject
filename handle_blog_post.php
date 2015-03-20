<?php
include 'includes/config.php';
$aResponse = array();
$allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
$allowedTags.='<li><ol><ul><span><div><br><ins><del>'; 
if(!empty($_POST['add_content']) && extract($_POST) <= 2){
 	$sContent = strip_tags(stripslashes($add_content), $allowedTags);
 	try {
 		$stmt = $db->prepare('INSERT INTO postsb(content, user_id) VALUES(:content, :user_id)');
 		if($stmt->execute(array('content' => $sContent, 'user_id' => $_SESSION['user']->get_id()))){
 			$aResponse['status'] = 'success';
 			$aResponse['type'] = 'insert'; 
 		}
 		else
 			$aResponse['status'] = 'dberror'; 
 	} catch (PDOException $e) {
 		echo $e->getMessage();
 	}
 	echo json_encode($aResponse);
}

else if(!empty($_POST['ed_content']) && extract($_POST) <= 3){
 	$sContent = strip_tags(stripslashes($ed_content), $allowedTags);
 	try {
 		$stmt = $db->prepare('UPDATE postsb SET content = :content WHERE user_id = :user_id AND id = :id');
 		if($stmt->execute(array('content' => $sContent, 'user_id' => $_SESSION['user']->get_id(), 'id' => $post_id))){ 
 			$aResponse['status'] = 'success';
 			$aResponse['type'] = 'update';
 			$aResponse['data'] = $ed_content;
 			$aResponse['id'] = $post_id;  
 		}
 		else
 			$aResponse['status'] = 'dberror'; 
 	} catch (PDOException $e) {
 		echo $e->getMessage();
 	}

 	echo json_encode($aResponse);
}
else{
 	$aResponse['status'] = 'error';
 	echo json_encode($aResponse); 
}

?>