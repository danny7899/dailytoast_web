<?php 
/*************** PHP LOGIN SCRIPT V 2.3*********************
(c) Balakrishnan 2009. All Rights Reserved

Usage: This script can be used FREE of charge for any commercial or personal projects. Enjoy!

Limitations:
- This script cannot be sold.
- This script should have copyright notice intact. Dont remove it please...
- This script may not be provided for download except from its original site.

For further usage, please contact me.

***********************************************************/
  include('dbc.php');
$err = array();

foreach($_GET as $key => $value) {
	$get[$key] = filter($value); //get variables are filtered.
}

if ($_POST['doLogin']=='Login')
{

foreach($_POST as $key => $value) {
	$data[$key] = filter($value); // post variables are filtered
}


$user_email = $data['usr_email'];
$pass = $data['pwd'];


if (strpos($user_email,'@') === false) {
    $user_cond = "user_name='$user_email'";
} else {
      $user_cond = "user_email='$user_email'";
    
}

	
$result = mysql_query("SELECT `id`,`pwd`,`full_name`,`user_email`,`approved`,`user_level`,`country`,`website` FROM users WHERE 
           $user_cond
			AND `banned` = '0'
			") or die (mysql_error()); 
$num = mysql_num_rows($result);

  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num > 0 ) { 
	
	list($id,$pwd,$full_name,$email,$approved,$user_level,$country,$website) = mysql_fetch_row($result);
	
	if(!$approved) {
	//$msg = urlencode("Account not activated. Please check your email for activation code");
	$err[] = "Account not activated. Please check your email for activation code";
	
	//header("Location: login.php?msg=$msg");
	 //exit();
	 }
	 
		//check against salt
	if ($pwd === PwdHash($pass,substr($pwd,0,9))) { 
	if(empty($err)){			

     // this sets session and logs user in  
       session_start();
	   session_regenerate_id (true); //prevent against session fixation attacks.

	   // this sets variables in the session 
		$_SESSION['user_id']= $id;  
		$_SESSION['user_name'] = $full_name;
		$_SESSION['user_level'] = $user_level;
		$_SESSION['user_email'] = $email;
		$_SESSION['user_country'] = $country;
		$_SESSION['user_website'] = $website;
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
		
		//update the timestamp and key for cookie
		$stamp = time();
		$ckey = GenKey();
		mysql_query("update users set `ctime`='$stamp', `ckey` = '$ckey' where id='$id'") or die(mysql_error());
		
		//set a cookie 
		
	   if(isset($_POST['remember'])){
				  setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_name",$_SESSION['user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_email",$_SESSION['user_email'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_country",$_SESSION['user_country'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_website",$_SESSION['user_website'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				   }
		  header("Location: ../index.php");
		 }
		}
		else
		{
		//$msg = urlencode("Invalid Login. Please try again with correct user email and password. ");
		$err[] = "Invalid Login. Please try again with correct user email and password.";
		//header("Location: login.php?msg=$msg");
		}
	} else {
		$err[] = "Error - Invalid login. No such user exists";
	  }		
}
					 
		$page_title = "Login - Daily Toast";
  include '../frag/headerlog.php';	


?>	

		<div id="content">
    		<main>
   			    <section>
        <h2>Login</h2>
        <article>
          <header>
            <p>
	  			<?php
	  			/******************** ERROR MESSAGES*************************************************
	  			This code is to show error messages 
	  			**************************************************************************/
	 			if(!empty($err))  {
	  				echo "<div class=\"msg\">";
	  				foreach ($err as $e) {
	    				echo "$e <br>";
	    			}
	  				echo "</div>";	
	   			}
	 			/******************************* END ********************************/	  
	 			?>
	 		</p>
			<br/>
          </header>
          <p>
          	<form action="login.php" method="post" name="logForm" id="logForm" >
        <table width="65%" border="0" cellpadding="4" cellspacing="4" class="loginform">
          <tr> 
            <td width="50%">Username or Email :</td>
            <td width="50%"><input name="usr_email" type="text" autocomplete="off" id="txtbox" size="35"  placeholder="Username or Email" spellcheck="false" aria-label="Username or Email" alt="Username or Email" value=""></td>
          </tr>
          <tr> 
            <td width="50%">Password :</td>
            <td width="50%"><input name="pwd" type="password" id="txtbox" size="35" placeholder="Password" spellcheck="false" aria-label="Password" alt="Password" value=""></td>
          </tr>
          
          <tr> 
            <td colspan="2"><div align="center">
                <input name="remember" type="checkbox" id="remember" value="1">
                Remember me</div></td>
          </tr>
          <tr> 
            <td colspan="2"> <div align="center">
            <p> <input name="doLogin" type="submit" id="doLogin3" value="Login"> </p>
            <br />
                <p><a href="register.php">Sign Up</a><font color="#FF6600"> 
                  |</font> <a href="forgot.php">Forgot Password</a> <font color="#FF6600"> 
                  </font></p>
              </div></td>
          </tr>
        </table>
        <div align="center"></div>
        <p align="center">&nbsp; </p>
      </form>
          </p>
        </article>
      </section>
    </main>
    <?php //include('../includes/config.php'); ?>
	<?php include('../frag/sidebarlog.php'); ?>
	</div>
	
	<div id="footer">
    <?php include('../frag/footer.php'); ?>
	</div>
  </body>
</html>