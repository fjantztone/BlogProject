<?php 
class User {
	private $id;
	private $username;
	private $email;
	private $password;
	private $user_path;
	private $img_path;

	public function __construct($id = null, $username, $email = null, $password = null){
		if($id !== null)
			$this->id = $id;		
		$this->username = $username;
		if($email !== null)
			$this->email = $email;
		if($password !== null)
			$this->password = $password;
		$this->password = $password;
		$this->user_path = "users/" . $username;
		$this->img_path = "users/" . $username . "/img";
	}
	public function set_id($id)
	{
		$this->id = $id;
	}	
	public function get_id()
	{
		return $this->id;
	}
	public function get_username()
	{
		return $this->username;
	}
	public function get_email()
	{
		return $this->email;
	}
	public function get_password()
	{
		return $this->password;
	}	
	public function get_user_path()
	{
		return $this->user_path;
	}	
	public function get_img_path()
	{
		return $this->img_path;
	}
}

?>
