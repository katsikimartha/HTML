<?php
session_start();
//connection to database
//and checking if the user has logged in. If he has, then the home page opens
if(isset($_SESSION['user'])!="")
{
	header("Location: home.php");
}
include_once 'dbconnect.php';

//when the button 'Sign Up Here' is clicked then the method POST will be checked if it is set. 
if(isset($_POST['btn-signup']))
{
        //The method POST is set. We take the values from the form
	$uname = mysql_real_escape_string($_POST['uname']);
	$email = mysql_real_escape_string($_POST['email']);
	$upass = md5(mysql_real_escape_string($_POST['pass']));
	
        //We use trim to strip whitespace (or other characters) from the beginning and end of a string
	$uname = trim($uname);
	$email = trim($email);
	$upass = trim($upass);
	
	 // email exist or not
	$query = "SELECT email FROM Users WHERE email='$email'";
	$result = mysql_query($query);
	
	$count = mysql_num_rows($result); // if email not found then register (count==0)
	
	 if($count == 0){
		//add data into the database
		if(mysql_query("INSERT INTO Users(username,email,password) VALUES('$uname','$email','$upass')"))
		{
                        //when the query above is complete, we update the id by increasing it by one for every new entry.
                        mysql_query("UPDATE Users SET user_id =  user_id + 1");
			 ?>
			<script>alert('successfully registered ');</script>
			<?php
 		}
		  else
		 {
			 ?>
                         //if data cannot be added to the database, a message is shown 
			<script>alert('error while registering you...');</script>
			<?php
		 }		
	 }
 	else{
 			?>
                         //if the email already exists in the database then the registration is not completed and a message is shown 
			<script>alert('Sorry Email ID already taken ...');</script>
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
<!--In this form, the user will write in the fields and when he clicks the button, the method post will be called. See the php code above. In addition, when the register is complete the user will use the link to go to the index page in order to log in.-->
<center>
<div id="login-form">
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="uname" placeholder="User Name" required /></td>
</tr>
<tr>
<td><input type="email" name="email" placeholder="Your Email" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" placeholder="Your Password" required /></td>
</tr>
<tr>
<td><button type="submit" name="btn-signup">Sign Me Up</button></td>
</tr>
<tr>
<td><a href="index.php">Sign In Here</a></td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>