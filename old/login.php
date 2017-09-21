<?php 
	//error_reporting(E_ALL ^ E_NOTICE);
	session_start();
 ?>
 <html lang="en">
 	<head>
 		<meta charset="UTF-8">
 		<title>Member System - Login</title>
 	</head>
 	<body>
 		<?php 
 			$form= "<form action='./login.php' method='post'>
				<table>
					<tr>
						<td>Username:</td>
						<td><input type='text' name='user'/></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type='password' name='password'/></td>
					</tr>
					<tr>
						<td></td>
						<td><input type='submit' name='loginbtn' value='Login'/></td>
					</tr>
				</table>
 			</form>";
 			if($_POST['loginbtn']){
 					$user = $_POST['user'];
 					$password = $_POST['password'];
 					$con=mysqli_connect("localhost", "danny7899", "Dan781999","webpage");
 					if (mysqli_connect_errno()){echo "Failed to connect to MySQL: " . mysqli_connect_error();}
 					if ($user){
 						if ($password){
 							//require("connect.php");
 							$password = md5(md5("aenahbr".$password."erhcg"));
 							//$query = "SELECT * FROM `users` WHERE `username`= \'$user\'";
 							$query = mysqli_query($con, "SELECT * FROM users WHERE username ='$user'");
 							$numrows= mysqli_num_rows($query);
 							if ($numrows == 1){
 								$row = mysqli_fetch_assoc($query);
 								$dbuser = $row('username');
 								$dbpass = $row('password');
 								$dbactive = $row('active');
 								if($password == $dbpass){
 									if ($dbactive == 1){
 										$_SESSION['userid'] = $dbid;
										$_SESSION['username'] = $dbuser;
										echo "You have been logged in as <b>$dbuser</b>. <a href='member.php'>Click here</a> to go to the member page.";

 									}else{echo "You must activate your account to log in. $form";}

 								}else{echo "You did not entered the correct password. $form";}

 							}else{echo "The username you entered was not found. $form";}
 							mysqlI_close($con);
 						}else{echo "You must enter your passord. $form";}

 					}else{echo "You must enter your username. $form";}
 			}else{echo $form;}
 		?>
	 </body>
 </html>