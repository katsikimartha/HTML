<?php
session_start();
//in case we open this page directly, if the user has logged in then the home page for users (home.php) will open
//otherwise the index page will open so that he can log in
if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}
else if(isset($_SESSION['user'])!="")
{
	header("Location: home.php");
}
//when the user wants to log out, he clicks on the link that appears on the pages (home.php etc) and it will lead here. The isset will check if the logout is set
//then it will log out and return to the home page
if(isset($_GET['logout']))
{
	session_destroy();
	unset($_SESSION['user']);
	header("Location: /make-your-own-clothing-tutorials-home.html");
}
?>