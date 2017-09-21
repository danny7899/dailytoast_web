<?php
include 'db_connect.php';
$db = new DB_CONNECT();

/**
* Get user by email and password
*/
function getUserByEmailAndPassword($email, $password) {
	$stmt = mysql_query('SELECT id, full_name, user_name, user_email, date, pwd FROM users WHERE user_email = "'.$email.'"') or die(mysql_error());
    $user = mysql_fetch_array($stmt);
    
    $hashSQL = $user["pwd"];
    $hashPHP = PwdHash($password,substr($user["pwd"],0,9));
	//echo "hashfromSQL: ".$hashSQL."<br>";
	//echo "hashfromPHP: ".$hashPHP."<br>";
			
	if ($hashPHP == $hashSQL) {
		return $user;
	} else {
		return null;
	}
}
    
/**
* Decrypting password
* @param salt, password
* returns hash string
*/
function PwdHash($pwd, $salt) {
    $salt = substr($salt, 0, 9);
    return $salt . sha1($pwd . $salt);
}

// json response array
$response = array("error" => FALSE);
if (isset($_POST['email']) && isset($_POST['password'])) {
 
    // receiving the post params
    $email = $_POST['email'];
    $password = $_POST['password'];
 
    // get the user by email and password
    $user = getUserByEmailAndPassword($email, $password);
 
    if ($user != null) {
        // user is found
        $response["error"] = FALSE;
        $response["uid"] = $user["id"];
        $response["user"]["name"] = $user["full_name"];
        $response["user"]["username"] = $user["user_name"];
        $response["user"]["email"] = $user["user_email"];
        $response["user"]["created_at"] = $user["date"];
        echo json_encode($response);
    } else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters email or password is missing!";
    echo json_encode($response);
}
?>