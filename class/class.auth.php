<?php 
class Auth {
	private $user;
	private $dbh;

	public function __construct(PDO $dbh, $user)
	{
		$this->dbh = $dbh;
		$this->user = $user;
	}

	private function create_hash(){
		return password_hash($this->user->get_password(), PASSWORD_DEFAULT);
	}
	private function verify_password($hash){
		return password_verify($this->user->get_password(), $hash);
	}
	private function get_hash(){
		try{
			$stmt = $this->dbh->prepare("SELECT password FROM users WHERE username = :username");
			$stmt->execute(array('username' => $this->user->get_username()));
			$row = $stmt->fetch();
	        return $row['password'];
		}
		catch(PDOException $e){
			echo 'Error: ' .$e->getMessage();
		}
	}
	public function login(){
		if($this->verify_password($this->get_hash())){
			$tmp_id = $this->get_user_id();
			$this->user->set_id($tmp_id);
			$_SESSION['user'] = $this->user;
			return true;
		}
		return false;
	}
	public function sign_up(){
		$tmp_password = $this->create_hash();
		try {
			$stmt = $this->dbh->prepare("INSERT INTO users (username, email, password, url) VALUES(:username, :email, :password, :url)");
			$bind = array('username' => $this->user->get_username(), 'email' => $this->user->get_email(), 'password' => $tmp_password, 'url' => $this->user->get_user_path());
			if($this->create_user_dir() && $stmt->execute($bind)){
				$this->user->set_id($this->dbh->lastInsertId());
				$this->write_user_files();
				return true;	
			}

		} catch(PDOException $e){
			echo 'Error: ' .$e->getMessage();
		}
	}
	private function create_user_dir(){
		if (!file_exists($this->user->get_user_path())){
			return mkdir($this->user->get_user_path(), 0777, true) && mkdir($this->user->get_img_path(), 0777, true);
		}
		return false;
	}
	private function write_user_files()
	{
		$file_contents = array(
		"config.php" => "<?php DEFINE('username', '" . $this->user->get_username() . "');\nDEFINE('user_id', '" . $this->user->get_id() . "');?>",
		"index.php" => "<?php include_once('config.php');\ninclude_once('../../includes/config.php');\ninclude_once(ROOTPATH.'/includes/helper_func.php');\ninclude_once(ROOTPATH.'/template/blog.php'); ?>",
		"index_ajax.php" => "<?php include_once('config.php');\ninclude_once('../../includes/config.php');\ninclude_once(ROOTPATH.'/template/blog_ajax.php'); ?>"
		);
		foreach($file_contents as $filename => $content){
			file_put_contents($this->user->get_user_path() . "/$filename", $content);
		}
	}

	public function get_user_id()
	{
		$stmt = $this->dbh->prepare('SELECT id FROM users WHERE username = :username');
		$stmt->execute(array('username' => $this->user->get_username()));
		return $stmt->fetchColumn(); 
	}
}
?>