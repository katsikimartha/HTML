<?php
//this is the home page for the administrator. He is the only who has access; he can add another user to the database.
session_start();
include_once 'dbconnect.php';

//if the user hasn't logged in, the index page will be opened so he can log in
if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}
$res=mysql_query("SELECT * FROM Users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

//when the button submit is clicked, the method 'add-user' is called.
if(isset($_POST['add-user']))
{
       //take the values from the form
      $name = mysql_real_escape_string($_POST['username']);
      $pass = mysql_real_escape_string($_POST['pass']);
      $email = mysql_real_escape_string($_POST['email']);

       //We use trim to strip whitespace (or other characters) from the beginning and end of a string
	$uname = trim($name);
	$email = trim($email);
	$upass = trim($pass);

       // email exist or not - checking if the user is already in the database
	$query = "SELECT email FROM Users WHERE email='$email'";
	$result = mysql_query($query);
	
	$count = mysql_num_rows($result); // if email not found then register (count==0)
	
	 if($count == 0){
		//add User data into the database
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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome </title>
<link rel="stylesheet" href="/hstyle.css" type="text/css" />
</head>
<body>
<div class="row">
<div class="header">
</div>
<ul class="topnav">
  <li><a class="active" href="admin-home.php">Home</a></li>
  <li><a href="users.php">Users</a></li>
  <li><a href="tutorials.php">Tutorials</a></li>
  <li><a href="questions.php">Questions</a></li>
  <li><a href="comments.php">Comments</a></li>
  <li><a href="tutorial-comments.php">Video Comments</a></li>
  <li><a href="logout.php?logout">Sign Out</a></li>
  <li class="icon">
    <a href="javascript:void(0);" style="font-size:15px;" onclick="myFunction()"><img border="0" alt="menu" src="/menu.png" width="15" height="5"></a>
  </li>
</ul>

<!--When the size of the page is getting smaller, not all the categories (from the ul list above) will be shown. Instead an image appears which has a link. When clicked it calls the function below which will open the navigation as a drop-down-->
<script>
function myFunction() {
    document.getElementsByClassName("topnav")[0].classList.toggle("responsive");
}
</script>

<!--The admin can add another user in the database.The code is the same as the one in the page 'register.php' -->
<div align="center">
       &nbsp;<h3> Add User </h3>
       <br>
       <form method="post">
           <input type="text" name="username" placeholder="User Name" required /><br>
           <input type="email" name="email" placeholder="Your Email" required /><br>
           <input type="password" name="pass" placeholder="Your Password" required /><br><br>
           <button type="submit" name="add-user">Submit</button><br>
       </form>
</div>

</div>
</div>
</body>
</html>