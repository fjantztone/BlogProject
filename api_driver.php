<?php 
include 'includes/config.php';
header('content-type', 'application/json');

try {
	$table = '';
	if($_GET['method'] == 'getComments' && isset($_GET['post_id'])){ //Join totally destroys the concept of my "api".... I guess a PHP library for this purpose would be the best.
		$post_id = (int)$_GET['post_id'];
		try{
			$stmt = $db->prepare('SELECT user_id, comments.id, username, url ,content, date FROM users, comments WHERE users.id = comments.user_id AND comments.post_id = :post_id ORDER BY date DESC');
			if($stmt->execute(array(':post_id' => $post_id)))
				echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
		}
		catch(PDOException $e){
			echo json_encode(array('error' => $e->getMessage()));
		}
		exit();
	}
	else if(isset($_GET['method']) && $_GET['method'] == 'getRating'){
		$rated_user = (int)$_GET['rated_user'];
		$stmt = $db->prepare('SELECT AVG(rating) as rating FROM ratings WHERE rated_user = :rated_user');
		$stmt->execute(array(':rated_user' => $rated_user));
		echo json_encode($stmt->fetchObject());
		exit();	    
	}	

	if(isset($_GET['table']) && !empty($_GET['table'])){
		if($_GET['table'] == 'postsb' || $_GET['table'] == 'comments' || $_GET['table'] == 'walls' || $_GET['table'] == 'ratings' || $_GET['table'] == 'subscribers') $table = $_GET['table'];
		else throw new Exception('Not valid table name');
		
		$userData = new UserData($db, $table);

		$params = array();
		$id = array();

		if(($_GET['method'] == 'insert' || $_GET['method'] == 'update') && $_GET['table'] == 'postsb'){
			if($userData->validate($_GET['content'])['status'] === 'invalid') throw new Exception('Bad form input.');
			
			$allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
			$allowedTags.='<li><ol><ul><span><div><br><ins><del>';
			$_GET['content'] = strip_tags(stripslashes($_GET['content']), $allowedTags);

		}
		foreach(array_keys($_GET) as $key){
			if($key == 'id' || $key == 'rated_by_user' || $key == 'sub_by_user' || $key == 'sub_user'){
				$id[$key] = $_GET[$key];
				continue;
			}
			else if($key != 'table' && $key != 'method')
				$params[$key] = $_GET[$key];
			
		}

	}
	if(isset($_GET['method'])){
		switch($_GET['method']){
			case 'getById':
				echo json_encode($userData->getById($id));
				break;
			case 'getByAll': 
				echo json_encode($userData->getByAll($params));
				break;
			case 'getByUserId': 
				echo json_encode($userData->getByUserId($_GET['user_id'], $params));
				break;
			case 'getByDate': 
				echo json_encode($userData->getByDate($_GET['user_id'], $params));
				break;
			case 'insert': 
				echo json_encode($userData->insert($id, $params));
				break;
			case 'update':
				echo json_encode($userData->update($id, $params));
				break;
			case 'delete': 
				echo json_encode($userData->delete($id));
				break;
			case 'validate': 
				echo json_encode($userData->validate($_GET['content']));
				break;
			default: 
				throw new Exception('Not valid method');
				break;
		}
	}
} catch (Exception $e) {
	echo json_encode(array('error' => $e->getMessage()));	
}

?>