<?php
function isAjax () {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}
function is_image($file){
	$mime_types = array('jpg', 'png', 'gif', 'jpeg');
	$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
	return in_array($ext, $mime_types);
}
function is_valid_email($email){
	global $db; //Another scope.. Works in scope outside function
	try{
		$stmt = $db->prepare("SELECT count(*) FROM users WHERE email = :email");
		$stmt->execute(array('email' => $email));
		if(($stmt->fetchColumn() > 0) || !filter_var($email, FILTER_VALIDATE_EMAIL))
			return false;
		else
			return true;
	} catch(PDOException $e){
		$e->getMessage();
	}


}
function is_valid_username($username){
	global $db; //Another scope..
	$stmt = $db->prepare("SELECT count(*) FROM users WHERE username = :username");
	$stmt->execute(array('username' => $username));
	if($stmt->fetchColumn() > 0)
		return false;
	else if($username == preg_replace("/[^a-zA-Z0-9]/", "", $username))
		return true;

}
function is_valid_post($content)
{
	if(!preg_match("/\<\/h1\>/i", $content))
		return false;
}
function log_out(){
	session_destroy();
}
function get_node_val($html, $element)
{
	$dom = new domDocument('1.0', 'utf-8');
	$dom->loadHTML($html);
	$dom->preserveWhiteSpace = false;
	$element = $dom->getElementsByTagName($element);
	return $element->item(0)->nodeValue;
}
?>