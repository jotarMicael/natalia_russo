<?php



class User {
 
    private $conn;
    private $table_name = "users";
	private $table_name2 = "roles";

	public $user_id;
	public $username;
	public $password;
	public $name;
	public $role;
 
    public function __construct($db){
        $this->conn = $db;
	}
	public function __destruct()
    {
        
    }
	
	function login() {

		$this->username = htmlspecialchars(strip_tags($this->username));
 
	    $query = "SELECT u.id,u.name,r.id as role_id FROM " . $this->table_name . " u
				  INNER JOIN " . $this->table_name2 . " r ON (u.role_id=r.id)
				  WHERE u.username = :1
				  AND u.password = :2 
				  LIMIT 0, 1";
	 
	    $stmt = $this->conn->prepare($query);
	 
		$stmt->bindParam(':1', $this->username);
		$stmt->bindParam(':2', $this->password);
	 
	    $stmt->execute();
	 
	    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	 
        $this->user_id = $row['id'];
		$this->name = $row['name'];
		$this->role = $row['role_id'];

	}

	function changePassword() {

		$this->password = htmlspecialchars(strip_tags($this->password));
 
	    $query = "UPDATE " . $this->table_name . " SET
			password = :password
			WHERE user_id = :user_id";
	 
	    $stmt = $this->conn->prepare($query);
	 
		$stmt->bindParam(":password", $this->password);
		$stmt->bindParam(":user_id", $this->user_id);
		
		$stmt->execute();
	}

	function updateLastLogin() {
 
	    $query = "UPDATE " . $this->table_name . " SET
			last_login = NOW()
			WHERE id = :user_id";
	 
	    $stmt = $this->conn->prepare($query);
	 
		$stmt->bindParam(":user_id", $this->user_id);
		
		$stmt->execute();
	}

	public function findById() {
 
	    $query = "SELECT * FROM " . $this->table_name . " u
				  WHERE user_id = ?
				  LIMIT 0, 1";
	 
	    $stmt = $this->conn->prepare($query);
	 
		$stmt->bindParam(1, $this->user_id);
	 
	    $stmt->execute();
	 
	    $row = $stmt->fetch(PDO::FETCH_ASSOC);
	 
		$this->username = $row['username'];
		$this->name = $row['name'];
		$this->role = $row['rol'];
	}

	function findComOrderByIdDesc() {
 
		$query = "SELECT * FROM 
			" . $this->table_name . " 
			WHERE rol = 'COM'
			ORDER BY user_id DESC";
	 
		$stmt = $this->conn->prepare($query);
	 
	    $stmt->execute();
	 
	    $clients = array();
		 
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		    
		    extract($row);
		 
		    $client_item = array(
		        "user_id" => intval($user_id),
				"name" => $name,
				"username" => $username,
				"email" => $email
		    );
		 
		    array_push($clients, $client_item);
		}
	 
	    return $clients;
	}

}
