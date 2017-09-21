<?php 
/********************** MYSETTINGS.PHP**************************
This updates user settings and password
************************************************************/
    include 'dbc.php'; 
  session_start();

  $page_title = "My Account Settings - Daily Toast";
  include '../frag/headerlog.php';
  page_protect();


$err = array();
$msg = array();

if($_POST['doUpdate'] == 'Update')  
{


$rs_pwd = mysql_query("select pwd from users where id='$_SESSION[user_id]'");
list($old) = mysql_fetch_row($rs_pwd);
$old_salt = substr($old,0,9);

//check for old password in md5 format
	if($old === PwdHash($_POST['pwd_old'],$old_salt))
	{
	$newsha1 = PwdHash($_POST['pwd_new']);
	mysql_query("update users set pwd='$newsha1' where id='$_SESSION[user_id]'");
	$msg[] = "Your new password is updated";
	//header("Location: mysettings.php?msg=Your new password is updated");
	} else
	{
	 $err[] = "Your old password is invalid";
	 //header("Location: mysettings.php?msg=Your old password is invalid");
	}

}

if($_POST['doSave'] == 'Save')  
{
// Filter POST data for harmful code (sanitize)
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}


mysql_query("UPDATE users SET
			`full_name` = '$data[name]',
			`address` = '$data[address]',
			`tel` = '$data[tel]',
			`fax` = '$data[fax]',
			`country` = '$data[country]',
			`website` = '$data[web]'
			 WHERE id='$_SESSION[user_id]'
			") or die(mysql_error());

//header("Location: mysettings.php?msg=Profile Sucessfully saved");
$msg[] = "Profile Sucessfully saved";
 }
 
$rs_settings = mysql_query("select * from users where id='$_SESSION[user_id]'"); 

//include '../includes/config.php';
  ?>
  
  <div id="content">
    <main>
      <section>
        <h2>My Account - Settings</h2>
        <article>
          <header>
            <h3>Update Account Data</h3>
            <br/>
          </header>
          <p>Here you can make changes to your profile. Please note that you will 
        not be able to change your email which has been already registered. Fields marked <span class="required">*</span> 
        are required.</p>
          
          <?php 
  if(!empty($err))  {
     echo "<div class=\"msg\">";
    foreach ($err as $e) {
      echo "* Error - $e <br>";
      }
    echo "</div>";  
     }
     if(!empty($msg))  {
      echo "<div class=\"msg\">" . $msg[0] . "</div>";

     }
    ?>
    <?php while ($row_settings = mysql_fetch_array($rs_settings)) {?>
      <form action="mysettings.php" method="post" name="myform" id="myform">
        <table width="90%" border="0" align="center" cellpadding="3" cellspacing="3" class="forms">
          <tr> 
            <td colspan="2"> Your Name / Company Name<br> <input name="name" type="text" id="name"  class="required" value="<?php echo $row_settings['full_name']; ?>" size="50"> 
              <span class="example">Your name or company name</span></td>
          </tr>
          <tr> 
            <td colspan="2">Contact Address <br /> 
              <textarea name="address" cols="40" rows="4" id="address"><?php echo $row_settings['address']; ?></textarea> 
            </td>
          </tr>
          <tr> 
            <td>Country</td>
            <td><input name="country" type="text" id="country" value="<?php echo $row_settings['country']; ?>" ></td>
          </tr>
          <tr> 
            <td width="27%">Phone</td>
            <td width="73%"><input name="tel" type="text" id="tel" value="<?php echo $row_settings['tel']; ?>"></td>
          </tr>
          <tr> 
            <td>Fax</td>
            <td><input name="fax" type="text" id="fax" value="<?php echo $row_settings['fax']; ?>"></td>
          </tr>
          <tr> 
            <td>Website</td>
            <td><input name="web" type="text" id="web" class="optional defaultInvalid url" value="<?php echo $row_settings['website']; ?>"> 
              <span class="example">http://www.example.com</span></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>User Name</td>
            <td><input name="user_name" type="text" id="web2" value="<?php echo $row_settings['user_name']; ?>" disabled></td>
          </tr>
          <tr> 
            <td>Email</td>
            <td><input name="user_email" type="text" id="web3"  value="<?php echo $row_settings['user_email']; ?>" disabled></td>
          </tr>
        </table>
        <p align="center"> 
          <input name="doSave" type="submit" id="doSave" value="Save">
        </p>
      </form>
    <?php } ?>
        </article>

        <article>
          <header>
            <h3>Change Password</h3>
            <p></p>
      <br/>
          </header>

          <p>If you want to change your password, please input your old and new password 
        to make changes.</p>
          <p></p>
          <form name="pform" id="pform" method="post" action="">
        <table width="80%" border="0" align="center" cellpadding="3" cellspacing="3" class="forms">
          <tr> 
            <td width="31%">Old Password</td>
            <td width="69%"><input name="pwd_old" type="password" class="required password"  id="pwd_old"></td>
          </tr>
          <tr> 
            <td>New Password</td>
            <td><input name="pwd_new" type="password" id="pwd_new" class="required password"  ></td>
          </tr>
        </table>
        <p align="center"> 
          <input name="doUpdate" type="submit" id="doUpdate" value="Update">
        </p>
        <p>&nbsp; </p>
      </form>
          
        </article>
      </section>
    </main>
    <?php include('../frag/sidebarlog.php'); ?>
  </div>
  
  <div id="footer">
   <?php include('../frag/footer.php'); ?>
  </div>
  </div>
  </body>
</html>


