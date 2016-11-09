<?php
session_start();

//in case the user has logged in, the home page for users will be opened, otherwise the general home page will be opened
if(isset($_SESSION['user'])!="")
{
	header("Location: make-your-own-clothing-tutorials/home.php");
} else {
	header("Location: make-your-own-clothing-tutorials-home.html");
}
?>