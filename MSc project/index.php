<?php
session_start();
include_once 'dbconnect.php';

//in case the user has logged in, the home page will be opened
if(isset($_SESSION['user'])!="")
{
	header("Location: home.php");
}

//after filling the fields and clicking the button, the method POST is called
if(isset($_POST['btn-login']))
{
        //retrieve values from input fields
	$email = mysql_real_escape_string($_POST['email']);
	$upass = mysql_real_escape_string($_POST['pass']);
	
        //We use trim to strip whitespace (or other characters) from the beginning and end of a string
	$email = trim($email);
	$upass = trim($upass);
	
        //retrieve the data from database for the email submitted
	$res=mysql_query("SELECT user_id, username, password FROM Users WHERE email='$email'");
	$row=mysql_fetch_array($res);
	
	$count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row

        //decrypt the password and checking if it is correct for this user. If it is, then the home page for users will be opened.
        //otherwise a message is shown!
	if($row['password']==md5($upass))
	{
                //checking if the admin has logged in. If he has, then we open the admin home page, otherwise we open the users' home page.
                if ($row['username']=="Admin")
		{
		     $_SESSION['user'] = $row['user_id'];
		     header("Location: admin-home.php");
		} else 
		{
		   $_SESSION['user'] = $row['user_id'];
		   header("Location: home.php");
		}
	} 
	else
	{
		?>
        <script>alert('Username / Password Seems Wrong !');</script>
        <?php
	}
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Make your own clothing tutorials - Login & Registration System</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<center>
<div id="login-form">
<!--Filling the fields with the information the user used to register and click the button in order to log in -->
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="email" placeholder="Your Email" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" placeholder="Your Password" required /></td>
</tr>
<tr>
<td><button type="submit" name="btn-login">Sign In</button></td>
</tr>
<tr>
<td><a href="register.php">Sign Up Here</a></td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>