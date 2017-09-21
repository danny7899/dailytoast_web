<?php

function PwdHash($pwd, $salt = null)
{
    if ($salt === null)     {
        $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
    }
    else     {
        $salt = substr($salt, 0, SALT_LENGTH);
    }
    return $salt . sha1($pwd . $salt);
}

$con=mysqli_connect("fdb7.awardspace.net","1874117_danny","Dan781999","1874117_danny");

if (mysqli_connect_errno($con))
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$username = $_POST['username'];
$pass = $_POST['password'];
$password = PwdHash($pass,substr($pwd,0,9));

$result = mysqli_query($con,"SELECT user_level FROM users WHERE 
user_name='$username' AND pwd='$password'");
$row = mysqli_fetch_array($result);
$data = $row[0];

if($data == 1){
	echo 'Member';
} else {
	echo 'Administrator';
}
mysqli_close($con);
?>