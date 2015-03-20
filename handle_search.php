<?php
include 'includes/config.php';
if(isset($_POST['query'])){
	$aResponse = array();
	try{
		$stmt = $db->prepare('SELECT username, url FROM users WHERE username LIKE :username');
		$stmt->execute(array('username' => '%'.$_POST['query'].'%'));
		$matches = $stmt->fetchAll(PDO::FETCH_ASSOC);

	}catch(PDOException $e){
		echo $e->getMessage();
	}
	if(sizeof($matches) != 0){
		foreach($matches as $i=>$row){
			$aResponse[] = array('link' => '<a href="'.$row['url'].'">'.$row['username'].'</a>');
		}
	}
	echo json_encode($aResponse);
	
}
?>