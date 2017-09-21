<?php
 
class DB_Functions {
 
    private $conn;
 
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $username, $email, $password) {
    
    	$activ_code = rand(1000,9999);
    	$user_ip = $_SERVER['REMOTE_ADDR'];
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
 
        $stmt = $this->conn->prepare("INSERT INTO users(full_name, user_name, user_email, pwd, users_ip, activation_code) VALUES(?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssss", $name, $username, $email, $encrypted_password, $activ_code);
        
        $user_id = mysql_insert_id($conn);  
		$md5_id = md5($user_id);
		mysql_query("update users set md5_id='$md5_id' where id='$user_id'");
        
        $result = $stmt->execute();
        $stmt->close();
 
        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->fetch_assoc();
            $stmt->close();
 
            return $user;
        } else {
            return false;
        }
    }
 
    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {
 
        if ($stmt = $this->conn->prepare("SELECT id, full_name, user_name, user_email, created_at, pwd FROM users WHERE user_email = (?)")) {
	        $stmt->bind_param("s", $email);
			$stmt->execute();
			$stmt->bind_result($id, $name, $username, $mail, $date, $pwd);
			$stmt->fetch();
			
			if ($pwd == checkhashSSHA($password, substr($password,0,9))) {
				
				$user = array("state" => "correct", "id" => $id, "full_name" => $name, "user_name" => $username, "user_email" => $mail, "created_at" => $date);
				/*$user["state"] = "correct";
				$user["id"] = $id;
				$user["full_name"] = $name;
				$user["user_name"] = $username;
				$user["user_mail"] = $mail;
				$user["created_at"] = $date;*/
				return $user;
			} else {
				$user = array("state" => "wrong");
				return $user;
			}
			
			
        }
        
         
    }
 
    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT user_email from users WHERE user_email = ?");
        
        $result = mysql_query("SELECT banned FROM users WHERE user_email = ".$email) or die(mysql_error());
        
        $state = mysql_fetch_array($result);
 
        $stmt->bind_param("s", $email);
 
        $stmt->execute();
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // user existed 
            if ($state["banned"] == 0) {
            	//not banned
	            $stmt->close();
				return true;
            } else {
            	//banned
	            $stmt->close();
				return false;
            }
            
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }
 
    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {
    
		substr($password,0,9);
		$encrypted = sha1($password . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
    
    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($password, $salt) {
 
		$hash = sha1($password . $salt);
 
        return $hash;
    }
 
}
 
?>