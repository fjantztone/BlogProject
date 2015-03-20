<?php
class UserData{
	private $dbh;
	private $table;

	public function __construct(PDO $dbh, $table){
		$this->dbh = $dbh;
		$this->table = $this->clean($table);
	}
	public function filterOpt($query, $filter)
	{
		if(isset($filter['order']))	
			$query .= ' ORDER BY ' .$filter['order']. ' DESC';
		if(isset($filter['limit']))	
			$query .= ' LIMIT ' .$filter['limit'];
		return $query;
	}
	public function getById($id = array(), $filter = array()){
		
		
		$binds = array();
		$bindnames = array();
		foreach(array_keys($id) as $key){
			$key = $this->clean($key);
			$binds[":$key"] = $id[$key];
			$bindnames[] = "$key = :$key";
		}
		$bindnames = implode(' AND ', $bindnames);
		$query = 'SELECT * FROM '.$this->table." WHERE $bindnames";
		$stmt = $this->dbh->prepare($query);
		$stmt->execute($binds);
		return $stmt->fetchAll(PDO::FETCH_CLASS);
	}

	public function getByAll($filter = array())
	{

		$query = 'SELECT * FROM '.$this->table;
		if(isset($filter)){
			$query = $this->filterOpt($query, $filter);
		}
		$stmt = $this->dbh->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_CLASS);		
	}
	public function getByUserId($user_id, $filter = array())
	{
		$query = 'SELECT * FROM '.$this->table . ' WHERE user_id = :user_id';
		if(isset($filter)){
			$query = $this->filterOpt($query, $filter);
		}
		$stmt = $this->dbh->prepare($query);
		$stmt->execute(array(':user_id' => $user_id));
		return $stmt->fetchAll(PDO::FETCH_CLASS);
	}
	public function getByDate($user_id, $filter = array())
	{

		$query = 'SELECT * FROM '.$this->table . ' WHERE user_id = :user_id AND DAY(date) =:day AND MONTH(date) = :month AND YEAR(date) = :year';
	    if(isset($filter)){
	    	$query = $this->filterOpt($query, $filter);
	    }

	    foreach(array_keys($filter) as $key){
	    	if($key == 'limit' || $key == 'order') continue;
	    	$key = $this->clean($key);
	    	$binds[":$key"] = $filter[$key];
	    }
	    $binds[':user_id'] = $user_id;
	    $stmt = $this->dbh->prepare($query);
		$stmt->execute($binds);
		
		return $stmt->fetchAll(PDO::FETCH_CLASS);
	}
	public function delete($id = array())
	{
		$binds = array();
		$bindnames = array();
		foreach(array_keys($id) as $key){
			$key = $this->clean($key);
			$binds[":$key"] = $id[$key];
			$bindnames[] = "$key = :$key";
		}
		$bindnames = implode(' AND ', $bindnames);
		$query = 'DELETE FROM '.$this->table." WHERE $bindnames";
		try{		
			$stmt = $this->dbh->prepare($query);
			if($stmt->execute($binds)){
				return array('status' => 'success');
			}			
		}		
		catch(PDOException $e){
			return $e->getMessage();
		}

		

	}
	public function update($id, $values)
	{
		$keyId = $this->clean(key($id));
		$binds = array(":$keyId" => $id[$keyId]);
		$bindnames = array();
		foreach(array_keys($id) as $key){
			$key = $this->clean($key); //Here
			$binds[":$key"] = $values[$key];
			$bindnames[] = "$key=:$key";			
		}
		foreach(array_keys($values) as $key){
			$key = $this->clean($key);
			$binds[":$key"] = $values[$key];
			$bindnames[] = "$key=:$key";
		}

		$bindnames = implode($bindnames, ',');
		$query = 'UPDATE '.$this->table." SET $bindnames WHERE $keyId = :$keyId";
		$stmt = $this->dbh->prepare($query);
		if($stmt->execute($binds))
			return array('status'=>'success');
	}
	public function insert($id = array(), $values)
	{
		$keys = array();
		$binds = array();
		$bindnames = array();
		$values = array_merge($id, $values);

		foreach(array_keys($values) as $key){
			$key = $this->clean($key);
			$keys[] = $key;
			$binds[":$key"] = $values[$key];
			$bindnames[] = ":$key";
		}
		$keys = implode($keys, ',');
		$bindnames = implode($bindnames, ',');
		$stmt = $this->dbh->prepare('INSERT INTO ' .$this->table." ($keys) VALUES ($bindnames)");
		if($stmt->execute($binds))
			return array('status' => 'success', 'id' => $this->dbh->lastInsertId());
	}
	public function validate($value){
		$aResponse = array('status' => 'success');
		$msg = array();
		if(!preg_match("/\<\/h1\>/i", $value)){
			$aResponse['status'] = 'invalid';
			array_push($msg, 'Post topic is required.'); 
		}
		if(strlen($value) < 150){
			$aResponse['status'] = 'invalid';
			array_push($msg, 'Post need to contain atleast 150 characters.');
		}
		if(!empty($msg)){
			$aResponse['msg'] = $msg;
		}
		return $aResponse; 

	}
	private function clean($key) {
	    return preg_replace('[^A-Za-z0-9_]', '', $key);
	}


}

?>